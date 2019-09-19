<?php

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'url',
	'#label' => elgg_echo('saml_sso:add_from_xml:url'),
]);

echo elgg_view_field([
	'#type' => 'plaintext',
	'#label' => elgg_echo('saml_sso:add_from_xml:xml'),
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);
