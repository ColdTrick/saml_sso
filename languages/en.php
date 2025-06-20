<?php

return [
	'item:object:saml_idp' => "SAML IDP configuration",
	'admin:configure_utilities:manage_idps' => "Manage SAML IDPs",
	
	'saml_sso:settings:use_http_x_forwarded' => "Use proxy variables",
	'saml_sso:settings:use_http_x_forwarded:help' => "Allow the usage of HTTP_X_FORWARDED server information",
	'saml_sso:settings:enable_replay_protection' => "Enable SAML replay protection",
	'saml_sso:settings:enable_replay_protection:help' => "Protect against re-use of a received SAML authentication response",
	'saml_sso:settings:disable_sso_on_logout' => "Disable SSO on logout",
	'saml_sso:settings:disable_sso_on_logout:help' => "Enabling this will prevent forced SSO for users that explicitly use the logout action",
	
	'add:object:saml_idp' => "Create IDP",
	'add:object:saml_idp:from_xml' => "Create IDP from XML",
	
	'saml_sso:add_from_xml:url' => "Enter IDP metadata URL for autodetection",
	'saml_sso:add_from_xml:xml' => "or paste IDP metadata XML",
	
	'saml_sso:saml_idp:sso_url' => "Single Sign On URL",
	'saml_sso:saml_idp:slo_url' => "Single Log Out URL",
	'saml_sso:saml_idp:x509cert' => "x509 Certificate",
	'saml_sso:saml_idp:private_key' => "Private Key",
	'saml_sso:saml_idp:show_on_login_form' => "Show on login form",
	'saml_sso:saml_idp:use_email' => "Use email to match user",
	'saml_sso:saml_idp:settings:current' => "Current IDP settings",
	'saml_sso:saml_idp:settings:update' => "Enter to update IDP settings",

	'saml_sso:force_authentication' => "Forced Authentication",
	'saml_sso:force_authentication:enable' => "Enable Forced Authentication",
	'saml_sso:force_authentication:disable' => "Disable Forced Authentication",
	
	'saml_sso:acs:error:replay' => "A duplicate authentication request has been detected. Please retry logging in.",
];
