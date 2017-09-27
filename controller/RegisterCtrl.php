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

		if ($this->saveUserSuccessful($user)) {
			$_SESSION['LoginView::Message'] = 'Registered new user.';
			parent::setCookie('LoginView::CookieName', $_REQUEST['RegisterView::UserName']);
			header('Location: index.php');
		}
	}

	public function saveUserSuccessful($user) {
		return $user->saveUser($_REQUEST['RegisterView::UserName'], 
		$_REQUEST['RegisterView::Password'], $_REQUEST['RegisterView::PasswordRepeat']);
	}
}
