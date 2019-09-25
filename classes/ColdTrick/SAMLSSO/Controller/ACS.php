<?php
namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Request;
use Elgg\Http\ErrorResponse;

class ACS {

	public function __invoke(Request $request) {
		$entity = $request->getEntityParam();
		elgg_entity_gatekeeper($entity->guid, 'object', 'saml_idp');
		
		try {
			$settings = new \OneLogin\Saml2\Settings($entity->getSettings());
			$response = new \OneLogin\Saml2\Response($settings, $request->getParam('SAMLResponse', null, false));
			if (!$response->isValid()) {
				return new ErrorResponse($response->getError());
			}
			
		 	$user = get_user_by_username($response->getNameId());
            if (empty($user)) {
            	return new ErrorResponse(elgg_echo('login:baduser'));
            }
            
            login($user, true);
            
			
// 			$attributes = $response->getAttributes();
//             if (!empty($attributes)) {
//                 $content .= 'You have the following attributes:<br>';
//                 $content .= '<table><thead><th>Name</th><th>Values</th></thead><tbody>';
//                 foreach ($attributes as $attributeName => $attributeValues) {
//                     $content .= '<tr><td>' . htmlentities($attributeName) . '</td><td><ul>';
//                     foreach ($attributeValues as $attributeValue) {
//                         $content .= '<li>' . htmlentities($attributeValue) . '</li>';
//                     }
//                     $content .= '</ul></td></tr>';
//                 }
//                 $content .= '</tbody></table>';
//             }
            
			$forward = $request->getParam('RelayState', '/', false);
            return elgg_redirect_response($forward);
            
		} catch (\Exception $e) {
			return new ErrorResponse($e->getMessage());
		}
		
		return elgg_ok_response();
	}
}
