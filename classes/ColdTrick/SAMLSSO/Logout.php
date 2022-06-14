<?php

namespace ColdTrick\SAMLSSO;

use Elgg\Http\ResponseBuilder;
use Elgg\Http\OkResponse;

class Logout {
	
	/**
	 * Disable forced SSO login after a logout
	 *
	 * @param \Elgg\Hook $hook 'response', 'action:logout'
	 *
	 * @return null|ResponseBuilder
	 */
	public static function disableSso(\Elgg\Hook $hook): ?ResponseBuilder {

		$response = $hook->getValue();
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
