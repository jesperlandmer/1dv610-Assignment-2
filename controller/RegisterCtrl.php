<?php

class RegisterCtrl {

	public function __construct() {
		if (!empty($_POST['RegisterView::Register'])) {
			$this->checkPasswordMatch();
			$this->checkUsernameInput();
			$this->checkPasswordInput();
		}
	}

	/**
	 * Save new user
	 *
	 * Should be called after a register attempt has successfully been made
	 *
	 * @return void
	 */
	public function addNewUser(User $userDetails) {
		$userDetails->saveUser($_POST['RegisterView::UserName'], $_POST['RegisterView::Password']);
	}

	/**
	 * Check password match
	 *
	 * Should be called after a register attempt has been made
	 *
	 * @return boolean
	 */
	private function checkPasswordMatch() {
		if ($_POST['RegisterView::Password'] != $_POST['RegisterView::PasswordRepeat']) {
			$_SESSION["errorLog"][] = "Passwords do not match.";
		}
	}

	private function checkUsernameInput() {
		if (strlen($_POST['RegisterView::UserName']) < 3) {
			$_SESSION["errorLog"][] = "Username has too few characters, at least 3 characters.";
		}
	}

	private function checkPasswordInput() {
		if (strlen($_POST['RegisterView::Password']) < 6) {
			$_SESSION["errorLog"][] = "Password has too few characters, at least 6 characters.";
		}
	}
}
