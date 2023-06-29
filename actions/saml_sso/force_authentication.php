<?php

$guid = (int) get_input('guid');

$idp = get_entity($guid);
if (!$idp instanceof \SAMLIDP) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if ($idp->force_authentication) {
	unset($idp->force_authentication);
} else {
	// remove from existing entities
	elgg_delete_metadata([
		'type' => 'object',
		'subtype' => \SAMLIDP::SUBTYPE,
		'metadata_name' => 'force_authentication',
		'limit' => false,
	]);
	
	$idp->force_authentication = true;
}

return elgg_ok_response(elgg_echo('save:success'));
