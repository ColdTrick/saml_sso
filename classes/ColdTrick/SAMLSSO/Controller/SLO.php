<?php

namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Request;

/**
 * Single Log Out
 */
class SLO {

	/**
	 * Handles single log out request
	 *
	 * @param Request $request the request
	 *
	 * @return \Elgg\Http\ResponseBuilder
	 */
	public function __invoke(Request $request) {
		
		if (!elgg_logout()) {
			return elgg_error_response(elgg_echo('logouterror'));
		}
		
		return elgg_ok_response('', elgg_echo('logoutok'), '');
	}
}
