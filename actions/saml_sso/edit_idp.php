<?php

$guid = (int) get_input('guid');

if (!empty($guid)) {
	$idp = get_entity($guid);
	
	if (!$idp instanceof \SAMLIDP) {
		return elgg_error_response();
	}
} else {
	$idp = new SAMLIDP();
	$idp->save();
}

$idp->title = get_input('title');
$idp->description = get_input('description');
$idp->sso_url = get_input('sso_url');
$idp->slo_url = get_input('slo_url');
$idp->x509cert = get_input('x509cert');
$idp->private_key = get_input('private_key');
$idp->show_on_login_form = (int) get_input('show_on_login_form');

return elgg_ok_response();
