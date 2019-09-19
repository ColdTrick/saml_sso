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
}
