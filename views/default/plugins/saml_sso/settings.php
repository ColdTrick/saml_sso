<?php
/**
 * All plugin settings can be configured by this view
 */

/* @var $plugin \ElggPlugin */
$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('saml_sso:settings:use_http_x_forwarded'),
	'#help' => elgg_echo('saml_sso:settings:use_http_x_forwarded:help'),
	'name' => 'params[use_http_x_forwarded]',
	'checked' => (bool) $plugin->use_http_x_forwarded,
	'switch' => true,
	'default' => 0,
	'value' => 1,
]);
