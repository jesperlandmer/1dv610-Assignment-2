<?php

require_once('LoginCtrl.php');

class RegisterCtrl extends LoginCtrl {

	/**
	 * Save new user
	 *
	 * Should be called after a register attempt has successfully been made
	 *
	 * @return void
	 */
	public function addNewUser(User $user) {
		$_SESSION['RegisterView::UserName'] = filter_var($_REQUEST['RegisterView::UserName'], FILTER_SANITIZE_STRING);

		if ($this->saveUserSuccessful($user)) {
			$_SESSION['LoginUser'] = $_REQUEST['RegisterView::UserName'];
			$_SESSION['LoginView::Message'] = 'Registered new user.';
			header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
		}
	}

	public function saveUserSuccessful($user) {
		return $user->saveUser($_REQUEST['RegisterView::UserName'], 
		$_REQUEST['RegisterView::Password'], $_REQUEST['RegisterView::PasswordRepeat']);
	}
}
