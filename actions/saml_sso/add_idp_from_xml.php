<?php

use OneLogin\Saml2\IdPMetadataParser;

$title = get_input('title');
$url = get_input('url');
$xml = get_input('xml', '', false);

if (empty($url) && empty($xml)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

try {
	if (!empty($url)) {
		$settings = IdPMetadataParser::parseRemoteXML($url);
	} else {
		$settings = IdPMetadataParser::parseXML($xml);
	}
} catch (Exception $e) {
	return elgg_error_response($e->getMessage());
}

$idp_settings = elgg_extract('idp', $settings);

$idp = new SAMLIDP();
$idp->title = $title;
$idp->settings = serialize($idp_settings);

$idp->save();

return elgg_ok_response();
