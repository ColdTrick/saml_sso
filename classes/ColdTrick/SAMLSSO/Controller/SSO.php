<?php

namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Exceptions\HttpException;
use Elgg\Http\ResponseBuilder;
use Elgg\Request;

/**
 * Single Sign On
 */
class SSO {

	/**
	 * Handles single sign on request
	 *
	 * @param Request $request the Request
	 *
	 * @return null|ResponseBuilder
	 * @throws HttpException
	 */
	public function __invoke(Request $request) {
		$entity = $request->getEntityParam();

		elgg_entity_gatekeeper($entity->guid, 'object', \SAMLIDP::SUBTYPE);
		
		try {
			$auth = new \OneLogin\Saml2\Auth($entity->getSettings());
			$auth->login('/');
		} catch (\Exception $e) {
			return elgg_error_response($e->getMessage());
		}
		
		return null;
	}
}
