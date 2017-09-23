<?php

class RegisterCtrl {

	/**
	 * Save new user
	 *
	 * Should be called after a register attempt has successfully been made
	 *
	 * @return void
	 */
	public function addNewUser(User $user) {

		if ($this->saveUserSuccessful($user)) {
			header("Location:/index.php?LoginView::Message=Registered new user.");
		}
	}

	public function saveUserSuccessful($user) {
		return $user->saveUser($_POST['RegisterView::UserName'], 
		$_POST['RegisterView::Password'], $_POST['RegisterView::PasswordRepeat']);
	}
}
