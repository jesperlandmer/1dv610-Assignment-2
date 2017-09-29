<?php

class LoginCtrl {

	private $user;
	private $salt = 'adsfasdfa*sdfaADSsdfAds^hthdgfhdaASDD*fsmJDJSJJ';
	private $messageType = array(
		"userLength" => "Username is missing",
		"passLength" => "Password is missing",
		"noUserFound" => "Wrong name or password",
		"welcome" => "Welcome"
	);

	public function loginUser(User $user) {
		$this->user = $user;
		$_SESSION['LoginView::UserName'] = $_REQUEST['LoginView::UserName'];

		if ($this->getUsernameInput($_REQUEST['LoginView::UserName'])) {
			$this->addMessage($this->messageType['userLength']);
		} else if ($this->getPasswordInput($_REQUEST['LoginView::Password'])) {
			$this->addMessage($this->messageType['passLength']);
		} else {
			$this->getUser($user);
			header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
			exit();
		}
	}

	private function getUser() {
		if ($this->getUserFound($_REQUEST['LoginView::UserName'], $_REQUEST['LoginView::Password'])) {
			$this->setCookie('LoginView::CookieName', $_REQUEST['LoginView::UserName']);
			$this->setCookie('LoginView::CookiePassword', $_REQUEST['LoginView::Password']);
			$this->addMessage($this->messageType['welcome']);
		} else {
			$this->addMessage($this->messageType['noUserFound']);
		}
	}

	protected function setCookie($cookieName, $cookieValue) {
		setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/");
	}

	protected function addMessage(String $message) {
		if (isset($_SESSION['LoginView::Message'])) {
		  $_SESSION['LoginView::Message'] .= $message . '<br>';
		} else {
		  $_SESSION['LoginView::Message'] = $message . '<br>';
		}
	}

	private function getUserFound($username, $password) {
		return $this->user->findUser($username, $password);
	}

	private function getUsernameInput($username) {

		return strlen($username) <= 0;
	}

	private function getPasswordInput($password) {
		
		return strlen($password) <= 0;
	}
}
