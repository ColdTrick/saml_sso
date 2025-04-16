<?php

namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Request;

/**
 * Metadata controller callback
 */
class Metadata {

	/**
	 * Returns metadata for a given IDP configuration
	 *
	 * @param \Elgg\Request $request the request
	 *
	 * @return \Elgg\Http\ResponseBuilder
	 */
	public function __invoke(Request $request) {
		$entity = $request->getEntityParam();
		
		elgg_entity_gatekeeper($entity->guid, 'object', \SAMLIDP::SUBTYPE);
		
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
			return elgg_error_response($e->getMessage());
		}
		
		// need to set charset because OneLogin generates xml without encoding set explicitly
		header('Content-Type: text/xml; charset=ISO-8859-1');
		return elgg_ok_response($metadata);
	}
}
