<?php

namespace ColdTrick\SAMLSSO\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the admin_header menu
 */
class AdminHeader {
	
	/**
	 * Register menu items on the admin pages
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		if (!elgg_is_admin_logged_in() || !elgg_in_context('admin')) {
			return null;
		}
		
		/* @var $return MenuItems */
		$return = $event->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'manage_idps',
			'text' => elgg_echo('admin:configure_utilities:manage_idps'),
			'href' => 'admin/configure_utilities/manage_idps',
			'parent_name' => 'utilities',
		]);
		
		return $return;
	}
}
