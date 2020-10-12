<?php
/**
 * View for saml_idp
 *
 * @uses $vars['entity'] SAMLIDP entity to show
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \SAMLIDP) {
	return;
}

$imprint = [];
if ($entity->force_authentication) {
	$imprint[] = [
		'icon_name' => 'user-lock',
		'content' => elgg_echo('saml_sso:force_authentication'),
	];
}

$params = [
	'icon' => false,
	'byline' => false,
	'access' => false,
	'imprint' => $imprint,
	'content' => $entity->description,
];
$params = $params + $vars;
echo elgg_view('object/elements/summary', $params);
