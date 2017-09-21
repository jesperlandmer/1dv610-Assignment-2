<?php

class LoginCtrl {

	/**
	 * Save new user
	 *
	 * Should be called after a register attempt has successfully been made
	 *
	 * @return void
	 */
	public function loginUser(User $userDetails) {

		$userDetails->loginUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
	}

	private function checkUsernameField() {
		return strlen($_POST['LoginView::UserName']) < 3;
	}

	private function checkPasswordField() {
		return strlen($_POST['LoginView::Password']) < 6;
	}
}
