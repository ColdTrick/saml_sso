<?php

namespace ColdTrick\SAMLSSO;

/**
 * Various menu callbacks
 */
class Menus {
	
	/**
	 * Register menu items on the admin pages
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return boolean
	 */
	public static function registerAdminPageMenu(\Elgg\Event $event) {
		if (!elgg_is_admin_logged_in() || !elgg_in_context('admin')) {
			return;
		}
		
		$return = $event->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'manage_idps',
			'href' => 'admin/configure_utilities/manage_idps',
			'text' => elgg_echo('admin:configure_utilities:manage_idps'),
			'parent_name' => 'configure_utilities',
		]);
		
		return $return;
	}
	
	/**
	 * Register menu items to the IDP entity
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return boolean
	 */
	public static function registerIDPEdit(\Elgg\Event $event) {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \SAMLIDP) {
			return;
		}
		
		$return = $event->getValue();
		
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
	 * Register menu items to the IDP entity
	 *
	 * @param \Elgg\Event $event 'register', 'menu:login'
	 *
	 * @return boolean
	 */
	public static function registerLoginMenu(\Elgg\Event $event) {
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => 'saml_idp',
			'limit' => false,
		]);
		
		if (empty($entities)) {
			return;
		}
		
		$return = $event->getValue();
		
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
