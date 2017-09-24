<?php

class LoginCtrl {

	private $user;
	private $messageType = array(
		"userLength" => "Username is missing",
		"passLength" => "Password is missing",
		"noUserFound" => "Wrong name or password",
		"welcome" => "Welcome"
	);

	public function loginUser(User $user) {
		$this->user = $user;

		if ($this->getUsernameInput()) {
			$this->addMessage($this->messageType['userLength']);
		} else if ($this->getPasswordInput()) {
			$this->addMessage($this->messageType['passLength']);
		} else {
			$this->getUser($user);
		}
	}

	private function getUser() {
		if ($this->getUserFound()) {
			$this->setCookie();
			$this->addMessage($this->messageType['welcome']);
		} else {
			$this->addMessage($this->messageType['noUserFound']);
		}
	}

	private function setCookie() {
		setcookie($_POST['LoginView::UserName'], $_POST['LoginView::Password'], time() + (86400 * 30), "/");
	}

	private function getUserFound() {
		return $this->user->findUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
	}

	private function getUsernameInput() {

		return strlen($_POST['LoginView::UserName']) <= 0;
	}

	private function getPasswordInput() {
		
		return strlen($_POST['LoginView::Password']) <= 0;
	}

	private function addMessage(String $message) {
		if (isset($_SESSION['LoginView::Message'])) {
		  $_SESSION['LoginView::Message'] .= $message . '<br>';
		} else {
		  $_SESSION['LoginView::Message'] = $message . '<br>';
		}
	}
}
