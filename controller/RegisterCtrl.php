<?php

require_once('LoginCtrl.php');

class RegisterCtrl extends LoginCtrl {

	private $username;
	private $password;
	private $passwordRepeat;
	private $user;
	private $messageType = array(
		"registered" => "Registered new user.",
	);

	/**
	 * Save new user
	 *
	 * Should be called after a register attempt has successfully been made
	 *
	 * @return void
	 */
	public function addNewUser(User $user) {
		$this->setCredentials($user);
		$this->saveUser();

		$_SESSION['RegisterView::UserName'] = $this->getFilterUserName();
		$_SESSION['LoginView::UserName'] = $this->username;
	}

	private function setCredentials($user) {
		$this->user = $user;
		$this->username = $_REQUEST['RegisterView::UserName'];
		$this->password = $_REQUEST['RegisterView::Password'];
		$this->passwordRepeat = $_REQUEST['RegisterView::PasswordRepeat'];
	}

	private function saveUser() {
		if ($this->isUserSaved()) {
			parent::addMessage($this->messageType['registered']);
			header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
			exit();
		}
	}

	private function isUserSaved() {
		return $this->user->saveUser($this->username, $this->password, $this->passwordRepeat);
	}

	private function getFilterUserName() {
		return filter_var($this->username, FILTER_SANITIZE_STRING);
	}
}
