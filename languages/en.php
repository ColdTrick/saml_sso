<?php

return [
	'admin:configure_utilities:manage_idps' => "Manage SAML IDPs",
	
	'saml_sso:settings:use_http_x_forwarded' => "Use proxy variables",
	'saml_sso:settings:use_http_x_forwarded:help' => "Allow the usage of HTTP_X_FORWARDED server information",
	
	'add:object:saml_idp' => "Create IDP",
	'add:object:saml_idp:from_xml' => "Create IDP from XML",
	
	'saml_sso:add_from_xml:url' => "Enter IDP metadata URL for autodetection",
	'saml_sso:add_from_xml:xml' => "or paste IDP metadata XML",
	
	'saml_sso:saml_idp:sso_url' => "Single Sign On URL",
	'saml_sso:saml_idp:slo_url' => "Single Log Out URL",
	'saml_sso:saml_idp:x509cert' => "x509 Certificate",
	'saml_sso:saml_idp:private_key' => "Private Key",
	'saml_sso:saml_idp:show_on_login_form' => "Show on login form",

	'saml_sso:force_authentication' => "Forced Authentication",
	'saml_sso:force_authentication:enable' => "Enable Forced Authentication",
	'saml_sso:force_authentication:disable' => "Disable Forced Authentication",
];
