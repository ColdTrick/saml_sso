<?php

namespace ColdTrick\SAMLSSO;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		elgg_register_ajax_view('forms/saml_sso/add_idp_from_xml');
		elgg_register_ajax_view('forms/saml_sso/edit_idp');
	}
}
