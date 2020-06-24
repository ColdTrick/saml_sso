<?php
namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Request;
use Elgg\Http\ErrorResponse;

class ACS {

	public function __invoke(Request $request) {
		$entity = $request->getEntityParam();
		elgg_entity_gatekeeper($entity->guid, 'object', 'saml_idp');
		
		try {
			// set static usage of proxy vars
			\OneLogin\Saml2\Utils::setProxyVars((bool) elgg_get_plugin_setting('use_http_x_forwarded', 'saml_sso'));
			
			$settings = new \OneLogin\Saml2\Settings($entity->getSettings());
			$response = new \OneLogin\Saml2\Response($settings, $request->getParam('SAMLResponse', null, false));
			if (!$response->isValid()) {
				elgg_get_session()->set('disable_sso', true);
				return new ErrorResponse($response->getError());
			}
			
		 	$user = get_user_by_username($response->getNameId());
            if (empty($user)) {
            	elgg_get_session()->set('disable_sso', true);
            	return new ErrorResponse(elgg_echo('login:baduser'));
            }
            
            login($user, true);
             
			$forward = $request->getParam('RelayState', '/', false);
            return elgg_redirect_response($forward);
            
		} catch (\Exception $e) {
			elgg_get_session()->set('disable_sso', true);
			return new ErrorResponse($e->getMessage());
		}
		
		return elgg_ok_response();
	}
}
