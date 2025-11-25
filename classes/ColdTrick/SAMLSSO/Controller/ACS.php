<?php

namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Exceptions\DatabaseException;
use Elgg\Exceptions\HttpException;
use Elgg\Request;

/**
 * Assertion Consumer Service controller
 */
class ACS {

	/**
	 * Handles ACS request
	 *
	 * @param Request $request the request
	 *
	 * @return \Elgg\Http\ResponseBuilder
	 * @throws HttpException
	 */
	public function __invoke(Request $request) {
		/* @var $entity SAMLIDP */
		$entity = $request->getEntityParam();
		
		elgg_entity_gatekeeper($entity->guid, 'object', \SAMLIDP::SUBTYPE);
		
		$forward = elgg_normalize_site_url($request->getParam('RelayState', '/', false)) ?? '/';
		
		// edge case where SSO proces kicks in but there is already a logged-in user
		if (elgg_is_logged_in()) {
			return elgg_redirect_response($forward);
		}
		
		$saml_response = $request->getParam('SAMLResponse', null, false);
		if (empty($saml_response)) {
			elgg_get_session()->set('disable_sso', true);
			return elgg_error_response(elgg_echo('error:missing_data'));
		}
		
		try {
			// set static usage of proxy vars
			\OneLogin\Saml2\Utils::setProxyVars((bool) elgg_get_plugin_setting('use_http_x_forwarded', 'saml_sso'));
			
			$settings = new \OneLogin\Saml2\Settings($entity->getSettings());
			$response = new \OneLogin\Saml2\Response($settings, $saml_response);
			if (!$response->isValid()) {
				elgg_get_session()->set('disable_sso', true);
				return elgg_error_response($response->getError());
			}
			
			// check for SAML replay
			if ((bool) elgg_get_plugin_setting('enable_replay_protection', 'saml_sso')) {
				$id = $response->getAssertionId() ?? $response->getId();
				if (!empty($id)) {
					if (_elgg_services()->hmacCacheTable->loadHMAC($id)) {
						elgg_get_session()->set('disable_sso', true);
						
						return elgg_error_response(elgg_echo('saml_sso:acs:error:replay'), REFERRER, ELGG_HTTP_UNAUTHORIZED);
					}
					
					// need to store the ID for replay protection
					try {
						_elgg_services()->hmacCacheTable->storeHMAC($id);
					} catch (DatabaseException $e) {
						elgg_log('Unable to store in HMAC table during Single Sign On replay protection', \Psr\Log\LogLevel::WARNING);
					}
				}
			}
			
			// try to find the user
			$user = elgg_get_user_by_username($response->getNameId(), (bool) $entity->use_email);
			if (empty($user)) {
				elgg_get_session()->set('disable_sso', true);
				return elgg_error_response(elgg_echo('login:baduser'));
			}
			
			elgg_login($user, true);
			
			return elgg_redirect_response($forward);
		} catch (\Exception $e) {
			elgg_get_session()->set('disable_sso', true);
			return elgg_error_response($e->getMessage());
		}
		
		return elgg_ok_response();
	}
}
