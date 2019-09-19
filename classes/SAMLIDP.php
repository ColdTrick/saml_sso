<?php

class SAMLIDP extends ElggObject {
	
	const SUBTYPE = 'saml_idp';

	/**
	 * initializes the default class attributes
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PUBLIC;
		$this->attributes['owner_guid'] = elgg_get_site_entity()->guid;
		$this->attributes['container_guid'] = elgg_get_site_entity()->guid;
	}
	
}
