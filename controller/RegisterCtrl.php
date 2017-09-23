<?php

class RegisterCtrl {

	private $errorLog = array();
	private $errorMessage = '';
	private $user;

	/**
	 * Save new user
	 *
	 * Should be called after a register attempt has successfully been made
	 *
	 * @return void
	 */
	public function addNewUser(User $user) {
		$this->user = $user;
		$this->validator();
		$this->saveUserToDb();
	}

	private function saveUserToDb() {
		if (empty($this->errorLog)) {
			$this->user->saveUser($_POST['RegisterView::UserName'], $_POST['RegisterView::Password']);
			header("Location:/index.php?LoginView::Message=Registered new user.");
		} else {
			header("Location:" . $_SERVER['PHP_SELF'] . "?register&RegisterView::Message=" . $this->errorMessage);
		}
	}

	private function validator() {
		$this->checkPasswordMatch();
		$this->checkUsernameInput();
		$this->checkPasswordInput();
		$this->checkUsernameExists();
	}

	private function addError(String $message) {
		$this->errorLog[] = $message;
		$this->errorMessage .= $message . '<br>';
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
			$this->addError("Passwords do not match.");
		}
	}

	private function checkUsernameInput() {
		if (strlen($_POST['RegisterView::UserName']) < 3) {
			$this->addError("Username has too few characters, at least 3 characters.");
		}
	}

	private function checkPasswordInput() {
		if (strlen($_POST['RegisterView::Password']) < 6) {
			$this->addError("Password has too few characters, at least 6 characters.");
		}
	}

	private function checkUsernameExists() {
		if ($this->user->userExists($_POST['RegisterView::UserName'])) {
			$this->addError("User exists, pick another username.");
		}
	}
}
