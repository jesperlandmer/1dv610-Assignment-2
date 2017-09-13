<?php

require_once(__DIR__ . '/../model/User.php');

class RegisterCtrl {

	/**
	 * Check password match
	 *
	 * Should be called after a register attempt has been made
	 *
	 * @return Boolean
	 */
	private function checkPasswordMatch() {
		return $_POST['RegisterView::Password'] == $_POST['RegisterView::RepeatPassword'];
	}

	/**
	 * Save new user
	 *
	 * Should be called after a register attempt has successfully been made
	 *
	 * @return Void
	 */
	public function addNewUser($newUser) {
		if ($this->checkPasswordMatch()) {
			$newUser->saveUser($_POST['RegisterView::UserName'], $_POST['RegisterView::Password']);
		}
	}

	/**
	 * 	public function addNewUser($newUser) {
	 *		if ($this->checkPasswordMatch()) {
	 *			$newUser->saveUser($name, $password);
	 *		}
	 *	}
	 */
}
