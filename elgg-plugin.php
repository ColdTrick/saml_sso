<?php

use Elgg\Router\Middleware\Gatekeeper;
use Elgg\Router\Middleware\LoggedOutGatekeeper;

return [
	'plugin' => [
		'version' => '2.1',
	],
	'settings' => [
		'use_http_x_forwarded' => 0,
		'disable_sso_on_logout' => false,
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'saml_idp',
			'class' => \SAMLIDP::class,
		],
	],
	'routes' => [
		'login:object:saml_idp' => [
			'path' => 'saml_idp/login/{guid}',
			'controller' => ColdTrick\SAMLSSO\Controller\SSO::class,
			'middleware' => [
				LoggedOutGatekeeper::class,
			],
			'walled' => false,
		],
		'acs:object:saml_idp' => [
			'path' => 'saml_idp/acs/{guid}',
			'controller' => ColdTrick\SAMLSSO\Controller\ACS::class,
			'walled' => false,
		],
		'logout:object:saml_idp' => [
			'path' => 'saml_idp/logout/{guid}',
			'controller' => ColdTrick\SAMLSSO\Controller\SLO::class,
			'middleware' => [
				Gatekeeper::class,
			],
		],
		'metadata:object:saml_idp' => [
			'path' => 'saml_idp/metadata/{guid}',
			'controller' => ColdTrick\SAMLSSO\Controller\Metadata::class,
			'walled' => false,
		],
	],
	'hooks' => [
		'register' => [
			'menu:entity' => [
				'\ColdTrick\SAMLSSO\Menus::registerIDPEdit' => [],
			],
			'menu:login' => [
				'\ColdTrick\SAMLSSO\Menus::registerLoginMenu' => [],
			],
			'menu:page' => [
				'\ColdTrick\SAMLSSO\Menus::registerAdminPageMenu' => [],
			],
		],
		'response' => [
			'action:logout' => [
				'\ColdTrick\SAMLSSO\Logout::disableSso' => [],
			],
		],
	],
	'actions' => [
		'saml_sso/add_idp_from_xml' => [
			'access' => 'admin',
		],
		'saml_sso/edit_idp' => [
			'access' => 'admin',
		],
		'saml_sso/force_authentication' => [
			'access' => 'admin',
		],
	],
	'view_extensions' => [
		'page/default' => [
			'saml_sso/force_authentication' => ['priority' => 200],
		],
		'page/walled_garden' => [
			'saml_sso/force_authentication' => ['priority' => 200],
		],
	],
	'view_options' => [
		'forms/saml_sso/add_idp_from_xml' => ['ajax' => true],
		'forms/saml_sso/edit_idp' => ['ajax' => true],
	],
];
