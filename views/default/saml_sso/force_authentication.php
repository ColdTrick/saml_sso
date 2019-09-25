<?php

if (elgg_is_logged_in()) {
	// no need to do anything if already logged in
	return;
}

if (get_input('disable_sso')) {
	// bypass for sso
	elgg_get_session()->set('disable_sso', true);
	return;
}

$disable_sso = elgg_get_session()->get('disable_sso', false);
if ($disable_sso === true) {
	// sso was bypassed on a previous page
	return;
}

$forced_idps = elgg_get_entities([
	'type' => 'object',
	'subtype' => 'saml_idp',
	'metadata_name' => 'force_authentication',
	'limit' => 1,
]);
if (empty($forced_idps)) {
	return;
}

$forced_idp = $forced_idps[0];

$forward = elgg_get_session()->get('last_forward_from', current_page_url());

$auth = new \OneLogin\Saml2\Auth($forced_idp->getSettings());
$auth->login($forward);
