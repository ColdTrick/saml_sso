<?php

namespace ColdTrick\SAMLSSO;

use Elgg\Http\ResponseBuilder;
use Elgg\Http\OkResponse;

/**
 * Logout callbacks
 */
class Logout {
	
	/**
	 * Disable forced SSO login after a logout
	 *
	 * @param \Elgg\Event $event 'response', 'action:logout'
	 *
	 * @return null|ResponseBuilder
	 */
	public static function disableSso(\Elgg\Event $event): ?ResponseBuilder {

		$response = $event->getValue();
		if (!$response instanceof OkResponse) {
			return null;
		}
		
		if (!(bool) elgg_get_plugin_setting('disable_sso_on_logout', 'saml_sso')) {
			return null;
		}
		
		$forward = $response->getForwardURL() ?: elgg_get_site_url();
		$forward = elgg_http_add_url_query_elements($forward, [
			'disable_sso' => 1,
		]);
		
		$response->setForwardURL($forward);
		
		return $response;
	}
}
