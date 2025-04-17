<?php
/**
 * All plugin settings can be configured by this view
 */

/* @var $plugin \ElggPlugin */
$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'switch',
	'#label' => elgg_echo('saml_sso:settings:use_http_x_forwarded'),
	'#help' => elgg_echo('saml_sso:settings:use_http_x_forwarded:help'),
	'name' => 'params[use_http_x_forwarded]',
	'value' => $plugin->use_http_x_forwarded,
]);

echo elgg_view_field([
	'#type' => 'switch',
	'#label' => elgg_echo('saml_sso:settings:enable_replay_protection'),
	'#help' => elgg_echo('saml_sso:settings:enable_replay_protection:help'),
	'name' => 'params[enable_replay_protection]',
	'value' => $plugin->enable_replay_protection,
]);

echo elgg_view_field([
	'#type' => 'switch',
	'#label' => elgg_echo('saml_sso:settings:disable_sso_on_logout'),
	'#help' => elgg_echo('saml_sso:settings:disable_sso_on_logout:help'),
	'name' => 'params[disable_sso_on_logout]',
	'value' => $plugin->disable_sso_on_logout,
]);
