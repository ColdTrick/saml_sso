<?php

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'required' => true,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);
