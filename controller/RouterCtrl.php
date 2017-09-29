<?php

require_once(__DIR__ . '/../model/User.php');

class RouterCtrl {
	
	/**
	 * Routes the http-request to right controller
	 *
	 * Should be instatiated on each request
	 *
	 * @return void BUT writes to sessions and cookies!
	 */
	public function route(User $usr, RegisterCtrl $rc, LoginCtrl $lic, LogoutCtrl $loc) {
		if ($this->isRegisterPage()) {
			$rc->addNewUser($usr);

		} else if ($this->isLoginPage()) {
			$lic->loginUser($usr);

		} else if ($this->isLogOut()) {
			$loc->logoutUser();
		}
	}

	private function isRegisterPage() {
		return isset($_REQUEST['RegisterView::Register']);
	}

	private function isLoginPage() {
		return isset($_REQUEST['LoginView::Login']);
	}

	private function isLogOut() {
		return isset($_REQUEST['LoginView::Logout']);
	}
}
