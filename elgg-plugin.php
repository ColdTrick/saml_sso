<?php

use ColdTrick\SAMLSSO\Bootstrap;

return [
	'bootstrap' => Bootstrap::class,
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'saml_idp',
			'class' => \SAMLIDP::class,
		],
	],
	'routes' => [
		
	],
	'hooks' => [
		'register' => [
			'menu:page' => [
				'\ColdTrick\SAMLSSO\Menus::registerAdminPageMenu' => [],
			]
		]
	],
	'actions' => [
		'saml_sso/edit_idp' => [
			'access' => 'admin',
		],
	],
];
