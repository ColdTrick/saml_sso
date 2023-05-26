<?php

namespace ColdTrick\SAMLSSO\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the entity menu
 */
class Entity {
	
	/**
	 * Register menu items to the IDP entity
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return null|MenuItems
	 */
	public static function registerIDPEdit(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \SAMLIDP) {
			return null;
		}
		
		/* @var $return MenuItems */
		$return = $event->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'edit',
			'icon' => 'edit',
			'text' => elgg_echo('edit'),
			'href' => elgg_http_add_url_query_elements('ajax/form/saml_sso/edit_idp', [
				'guid' => $entity->guid,
			]),
			'link_class' => 'elgg-lightbox',
		]);
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'force_authentication',
			'icon' => 'user-lock',
			'text' => elgg_echo('saml_sso:force_authentication:enable'),
			'href' => elgg_generate_action_url('saml_sso/force_authentication', [
				'guid' => $entity->guid,
			]),
			'item_class' => $entity->force_authentication ? 'hidden' : null,
			'data-toggle' => 'unforce_authentication',
		]);
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'unforce_authentication',
			'icon' => 'user-lock',
			'text' => elgg_echo('saml_sso:force_authentication:disable'),
			'href' => elgg_generate_action_url('saml_sso/force_authentication', [
				'guid' => $entity->guid,
			]),
			'item_class' => $entity->force_authentication ? null : 'hidden',
			'data-toggle' => 'force_authentication',
		]);
		
		return $return;
	}
}
