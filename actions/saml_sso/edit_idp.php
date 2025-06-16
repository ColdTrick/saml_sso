<?php

use OneLogin\Saml2\IdPMetadataParser;

$guid = (int) get_input('guid');
if (!empty($guid)) {
	$idp = get_entity($guid);
	if (!$idp instanceof \SAMLIDP) {
		return elgg_error_response(elgg_echo('error:missing_data'));
	}
} else {
	$idp = new \SAMLIDP();
	
	if (!$idp->save()) {
		return elgg_error_response(elgg_echo('save:fail'));
	}
}

$url = get_input('settings_url');
$xml = get_input('settings_xml', '', false);
$idp_settings = null;
try {
	if (!empty($url)) {
		$idp_settings = IdPMetadataParser::parseRemoteXML($url);
	} elseif (!empty($xml)) {
		$idp_settings = IdPMetadataParser::parseXML($xml);
	}
} catch (Exception $e) {
	return elgg_error_response($e->getMessage());
}

$idp->title = get_input('title');
$idp->description = get_input('description');
$idp->show_on_login_form = (int) get_input('show_on_login_form');
$idp->use_email = (int) get_input('use_email');

if ($idp_settings) {
	$idp->settings = serialize($idp_settings);
} else {
	$idp->sso_url = get_input('sso_url');
	$idp->slo_url = get_input('slo_url');
	$idp->x509cert = get_input('x509cert');
	$idp->private_key = get_input('private_key');
}

return elgg_ok_response(elgg_echo('save:success'));
