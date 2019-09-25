<?php
namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Request;

class SSO {

	public function __invoke(Request $request) {
		$entity = $request->getEntityParam();

		elgg_entity_gatekeeper($entity->guid, 'object', 'saml_idp');
		
		$auth = new \OneLogin\Saml2\Auth($entity->getSettings());
		$auth->login('/');
	}
}
