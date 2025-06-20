<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $entity ? $entity->guid : null,
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'required' => true,
	'name' => 'title',
	'value' => $entity ? $entity->title : null,
]);

echo elgg_view_field([
	'#type' => 'plaintext',
	'#label' => elgg_echo('description'),
	'name' => 'description',
	'value' => $entity ? $entity->description : null,
	'rows' => 3,
]);

if ($entity && $entity->settings) {
	echo elgg_view_message('info', elgg_format_element('pre', [], var_export(unserialize($entity->settings), true)), [
		'title' => elgg_echo('saml_sso:saml_idp:settings:current'),
	]);
	
	echo elgg_view_field([
		'#type' => 'fieldset',
		'legend' => elgg_echo('saml_sso:saml_idp:settings:update'),
		'fields' => [
			[
				'#type' => 'url',
				'#label' => elgg_echo('saml_sso:add_from_xml:url'),
				'name' => 'settings_url',
			],
			[
				'#type' => 'plaintext',
				'#label' => elgg_echo('saml_sso:add_from_xml:xml'),
				'name' => 'settings_xml',
			],
		]
	]);
} else {
	echo elgg_view_field([
		'#type' => 'url',
		'#label' => elgg_echo('saml_sso:saml_idp:sso_url'),
		'required' => true,
		'name' => 'sso_url',
		'value' => $entity ? $entity->sso_url : null,
	]);
	
	echo elgg_view_field([
		'#type' => 'url',
		'#label' => elgg_echo('saml_sso:saml_idp:slo_url'),
		'name' => 'slo_url',
		'value' => $entity ? $entity->slo_url : null,
	]);
	
	echo elgg_view_field([
		'#type' => 'plaintext',
		'#label' => elgg_echo('saml_sso:saml_idp:x509cert'),
		'name' => 'x509cert',
		'rows' => 3,
		'value' => $entity ? $entity->x509cert : null,
	]);
	
	echo elgg_view_field([
		'#type' => 'plaintext',
		'#label' => elgg_echo('saml_sso:saml_idp:private_key'),
		'name' => 'private_key',
		'rows' => 3,
		'value' => $entity ? $entity->private_key : null,
	]);
}

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('saml_sso:saml_idp:show_on_login_form'),
	'name' => 'show_on_login_form',
	'checked' => $entity ? ($entity->show_on_login_form !== 0) : false,
	'switch' => true,
	'default' => 0,
	'value' => 1,
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('saml_sso:saml_idp:use_email'),
	'name' => 'use_email',
	'checked' => $entity ? (bool) $entity->use_email : false,
	'switch' => true,
	'default' => 0,
	'value' => 1,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'text' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);
