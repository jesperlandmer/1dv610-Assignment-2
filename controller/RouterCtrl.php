<?php

require_once(__DIR__ . '/../model/User.php');

class RouterCtrl {

	/**
	 * Handle HTTP request
	 *
	 * Should be instatiated after a post has been made
	 *
	 * @return Void
	 */
	public function route(RegisterCtrl $rc, Connection $db) {
		if (!empty($_POST['RegisterView::register'])) {
			$rc->addNewUser(new User($db));
		} else {
			echo "Hej";
		}
	}
}
