<?php
namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Request;
use Elgg\Http\ErrorResponse;

class Metadata {

	public function __invoke(Request $request) {
		$entity = $request->getEntityParam();
		
		elgg_entity_gatekeeper($entity->guid, 'object', 'saml_idp');
		
		try {
			$auth = new \OneLogin\Saml2\Auth($entity->getSettings());
			$settings = $auth->getSettings();
			$metadata = $settings->getSPMetadata();
			$errors = $settings->validateMetadata($metadata);
			if (!empty($errors)) {
				throw new \OneLogin\Saml2\Error(
					'Invalid SP metadata: ' . implode(', ', $errors),
					\OneLogin\Saml2\Error::METADATA_SP_INVALID
				);
			}
		} catch (\Exception $e) {
			return new ErrorResponse($e->getMessage());
		}
		
		// need to set charset because OneLogin generates xml without encoding set explicitely
		header('Content-Type: text/xml; charset=ISO-8859-1');
		return elgg_ok_response($metadata);
	}
}
