<?php
namespace ColdTrick\SAMLSSO\Controller;

use Elgg\Request;

class SLO {

	public function __invoke(Request $request) {
		
		if (!logout()) {
			return elgg_error_response(elgg_echo('logouterror'));
		}
		
		return elgg_ok_response('', elgg_echo('logoutok'), '');
	}
}
