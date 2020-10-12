<?php

namespace ColdTrick\SAMLSSO;

class Menus {
	
	/**
	 * Hook to register menu items on the admin pages
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:page'
	 *
	 * @return boolean
	 */
	public static function registerAdminPageMenu(\Elgg\Hook $hook) {
		if (!elgg_is_admin_logged_in() || !elgg_in_context('admin')) {
			return;
		}
		
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'manage_idps',
			'href' => 'admin/configure_utilities/manage_idps',
			'text' => elgg_echo('admin:configure_utilities:manage_idps'),
			'parent_name' => 'configure_utilities',
			'section' => 'configure',
		]);
		
		return $return;
	}
	
	/**
	 * Hook to register menu items to the IDP entity
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:entity'
	 *
	 * @return boolean
	 */
	public static function registerIDPEdit(\Elgg\Hook $hook) {
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \SAMLIDP) {
			return;
		}
		
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'edit',
			'icon' => 'edit',
			'href' => elgg_http_add_url_query_elements('ajax/form/saml_sso/edit_idp', [
				'guid' => $entity->guid,
			]),
			'text' => elgg_echo('edit'),
			'link_class' => 'elgg-lightbox',
		]);
		
		$force_text = $entity->force_authentication ? elgg_echo('saml_sso:force_authentication:disable') : elgg_echo('saml_sso:force_authentication:enable');
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'force_authentication',
			'icon' => 'user-lock',
			'href' => elgg_generate_action_url('saml_sso/force_authentication', [
				'guid' => $entity->guid,
			]),
			'text' => $force_text,
		]);
		
		return $return;
	}
	
	/**
	 * Hook to register menu items to the IDP entity
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:login'
	 *
	 * @return boolean
	 */
	public static function registerLoginMenu(\Elgg\Hook $hook) {
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => 'saml_idp',
		]);
		
		if (empty($entities)) {
			return;
		}
		
		$return = $hook->getValue();
		
		foreach ($entities as $entity) {
			if (!$entity->showOnLoginForm()) {
				continue;
			}
			
			$id = $entity->getIDPID();
			$return[] = \ElggMenuItem::factory([
				'name' => "login_{$id}",
				'href' => elgg_generate_entity_url($entity, 'login'),
				'text' => elgg_echo('login') . " ({$entity->getDisplayName()})",
			]);
		}
		
		return $return;
	}
}
