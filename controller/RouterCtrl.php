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
		if ($this->isRegisterPage()) {
			$rc->addNewUser($usr);

		} else if ($this->isLoginPage()) {
			$lc->loginUser($usr);

		} else if ($this->isLogOut()) {
			$lc->logoutUser();
		}
	}

	private function isRegisterPage() {
		return isset($_REQUEST['RegisterView::Register']);
	}

	private function isLoginPage() {
		return isset($_REQUEST['LoginView::Login']);
	}

	private function isLogOut() {
		return isset($_REQUEST['LoginView::Login']);
	}
}
