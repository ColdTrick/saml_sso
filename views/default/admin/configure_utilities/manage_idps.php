<?php

elgg_register_menu_item('title', ElggMenuItem::factory([
	'name' => 'create_idp_blank',
	'icon' => 'plus',
	'text' => elgg_echo('add:object:saml_idp'),
	'href' => elgg_generate_url('ajax', [
		'type' => 'form',
		'segments' => 'saml_sso/edit_idp',
	]),
	'class' => 'elgg-button elgg-button-action elgg-lightbox',
]));

elgg_register_menu_item('title', ElggMenuItem::factory([
	'name' => 'create_idp_from_xml',
	'icon' => 'plus',
	'text' => elgg_echo('add:object:saml_idp:from_xml'),
	'href' => elgg_generate_url('ajax', [
		'type' => 'form',
		'segments' => 'saml_sso/add_idp_from_xml',
	]),
	'class' => 'elgg-button elgg-button-action elgg-lightbox',
]));

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => \SAMLIDP::SUBTYPE,
	'limit' => false,
	'no_results' => true,
]);
