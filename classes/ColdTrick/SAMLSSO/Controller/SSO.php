<?php
namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Http\ErrorResponse;
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
	 * @return void
	 */
	public function __invoke(Request $request) {
		$entity = $request->getEntityParam();

		elgg_entity_gatekeeper($entity->guid, 'object', 'saml_idp');
		
		try {
			$auth = new \OneLogin\Saml2\Auth($entity->getSettings());
			$auth->login('/');
		} catch (\Exception $e) {
			return new ErrorResponse($e->getMessage());
		}
	}
}
