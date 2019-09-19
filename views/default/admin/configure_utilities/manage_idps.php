<?php

elgg_register_menu_item('title', ElggMenuItem::factory([
	'name' => 'create_idp_blank',
	'text' => elgg_echo('add:object:saml_idp'),
	'icon' => 'plus',
	'href' => 'ajax/form/saml_sso/edit_idp',
	'class' => 'elgg-button elgg-button-action elgg-lightbox',
]));

elgg_register_menu_item('title', ElggMenuItem::factory([
	'name' => 'create_idp_from_xml',
	'text' => elgg_echo('add:object:saml_idp:from_xml'),
	'icon' => 'plus',
	'href' => 'ajax/form/saml_sso/add_idp_from_xml',
	'class' => 'elgg-button elgg-button-action elgg-lightbox',
]));

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'saml_idp',
	'limit' => false,
	'no_results' => true,
]);
