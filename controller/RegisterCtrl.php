<?php

require_once('LoginCtrl.php');

class RegisterCtrl extends LoginCtrl {

	private $username;
	private $password;
	private $passwordRepeat;
	private $messageType = array(
		"registered" => "Username is missing",
	);

	/**
	 * Save new user
	 *
	 * Should be called after a register attempt has successfully been made
	 *
	 * @return void
	 */
	public function addNewUser(User $user) {

		$this->username = $_REQUEST['RegisterView::UserName'];
		$this->password = $_REQUEST['RegisterView::Password'];
		$this->passwordRepeat = $_REQUEST['RegisterView::PasswordRepeat'];
		$this->filterUserName();

		if ($this->saveUserSuccessful($user)) {
			$this->setLoginUsername();
			parent::addMessage($this->messageType['registered']);
			$_SESSION['LoginView::Message'] = 'Registered new user.';
			header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
			exit();
		}
	}

	private function saveUserSuccessful($user) {
		return $user->saveUser($this->username, $this->password, $this->passwordRepeat);
	}

	private function filterUserName() {
		$_SESSION['RegisterView::UserName'] = filter_var($this->username, FILTER_SANITIZE_STRING);
	}

	private function setLoginUsername() {
		$_SESSION['LoginView::UserName'] = $this->username;
	}
}
