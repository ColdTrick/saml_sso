<?php

$guid = (int) get_input('guid');

$idp = get_entity($guid);
if (!$idp instanceof \SAMLIDP) {
	return elgg_error_response();
}

if ($idp->force_authentication) {
	unset($idp->force_authentication);
} else {

	// remove from existing entities
	elgg_delete_metadata([
		'type' => 'object',
		'subtype' => 'saml_idp',
		'metadata_name' => 'force_authentication',
		'limit' => false,
	]);
	
	$idp->force_authentication = true;
}

return elgg_ok_response();
