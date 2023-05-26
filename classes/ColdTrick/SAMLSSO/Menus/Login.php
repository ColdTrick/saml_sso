<?php

namespace ColdTrick\SAMLSSO\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the login menu
 */
class Login {
	
	/**
	 * Register menu items to the IDP entity
	 *
	 * @param \Elgg\Event $event 'register', 'menu:login'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => \SAMLIDP::SUBTYPE,
			'limit' => false,
		]);
		
		if (empty($entities)) {
			return null;
		}
		
		/* @var $return MenuItems */
		$return = $event->getValue();
		
		/* @var $entity \SAMLIDP */
		foreach ($entities as $entity) {
			if (!$entity->showOnLoginForm()) {
				continue;
			}
			
			$id = $entity->getIDPID();
			$return[] = \ElggMenuItem::factory([
				'name' => "login_{$id}",
				'text' => elgg_echo('login') . " ({$entity->getDisplayName()})",
				'href' => elgg_generate_entity_url($entity, 'login'),
			]);
		}
		
		return $return;
	}
}
