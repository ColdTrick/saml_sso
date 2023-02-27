<?php

use OneLogin\Saml2\Constants;

/**
 * SAML IDP Entity
 */
class SAMLIDP extends ElggObject {
	
	const SUBTYPE = 'saml_idp';

	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PUBLIC;
		$this->attributes['owner_guid'] = elgg_get_site_entity()->guid;
		$this->attributes['container_guid'] = elgg_get_site_entity()->guid;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getURL(): string {
		return elgg_generate_entity_url($this, 'metadata');
	}
	
	/**
	 * Returns an id for use in links and config
	 *
	 * @return string
	 */
	public function getIDPID(): string {
		return 'idp_' . elgg_get_friendly_title($this->getDisplayName());
	}
	
	/**
	 * Checks if this IDP should show on the login form
	 *
	 * @return bool
	 */
	public function showOnLoginForm(): bool {
		return $this->show_on_login_form !== 0;
	}
	
	/**
	 * Return an SAML settings array
	 *
	 * @return array
	 */
	public function getSettings(): array {
		return [
			// Enable debug mode (to print errors).
			'debug' => !empty(elgg_get_config('debug')),
			'security' => [
				'requestedAuthnContext' => false,
			],
			// Service Provider Data that we are deploying.
			'sp' => $this->getSPSettings(),
			
			// Identity Provider Data that we want connected with our SP.
			'idp' => $this->getIDPSettings(),
		];
	}
	
	/**
	 * Return service provider settings
	 *
	 * @return array
	 */
	protected function getSPSettings(): array {
		$result = [
			// Identifier of the SP entity  (must be a URI)
			'entityId' => elgg_generate_entity_url($this, 'metadata'),
			// Specifies info about where and how the <AuthnResponse> message MUST be
			// returned to the requester, in this case our SP.
			'assertionConsumerService' => [
				// URL Location where the <Response> from the IdP will be returned
				'url' => elgg_generate_entity_url($this, 'acs'),
				// SAML protocol binding to be used when returning the <Response>
				// message. OneLogin Toolkit supports this endpoint for the
				// HTTP-POST binding only.
				'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
			],
			// Specifies info about where and how the <Logout Response> message MUST be
			// returned to the requester, in this case our SP.
			'singleLogoutService' => [
				// URL Location where the <Response> from the IdP will be returned
				'url' => elgg_generate_entity_url($this, 'logout'),
				// SAML protocol binding to be used when returning the <Response>
				// message. OneLogin Toolkit supports the HTTP-Redirect binding
				// only for this endpoint.
				'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
			],
			// Specifies the constraints on the name identifier to be used to
			// represent the requested subject.
			// Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported.
			'NameIDFormat' => Constants::NAMEID_UNSPECIFIED,
		];
		
		if ($this->x509cert) {
			$result['x509cert'] = $this->x509cert;
		}
		
		if ($this->private_key) {
			$result['privateKey'] = $this->private_key;
		}
		
		return $result;
	}
	
	/**
	 * Returns Identity Provider settings
	 *
	 * @return array
	 */
	protected function getIDPSettings(): array {
		$settings = $this->settings;
		if (!empty($settings)) {
			return unserialize($this->settings);
		}
		
		$result = [
			'entityId' => $this->getIDPID(),
			'singleSignOnService' => [
				'url' => $this->sso_url,
			],
		];
		
		if (!empty($this->slo_url)) {
			$result['singleLogoutService'] = [
				'url' => $this->slo_url,
			];
		}
		
		return $result;
	}
}
