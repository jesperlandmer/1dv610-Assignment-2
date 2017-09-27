<?php

require_once(__DIR__ . '/../model/User.php');

class RouterCtrl {
	/**
	 * Register or login user depending on HTTP request
	 *
	 * Should be instatiated after a post has been made
	 *
	 * @return void
	 */
	public function route(User $usr, RegisterCtrl $rc, LoginCtrl $lc) {
		if (!empty($_POST['RegisterView::Register'])) {
			$rc->addNewUser($usr);
		} else if (!empty($_POST['LoginView::Login'])) {
			$lc->loginUser($usr);
		} else if (!empty($_POST['LoginView::Logout'])) {
			$lc->logoutUser();
		}
	}
}
