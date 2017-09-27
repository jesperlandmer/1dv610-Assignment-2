<?php

class LoginCtrl {

	private $user;
	private $messageType = array(
		"userLength" => "Username is missing",
		"passLength" => "Password is missing",
		"noUserFound" => "Wrong name or password",
		"welcome" => "Welcome",
		"logOut" => "Bye bye!"
	);

	public function loginUser(User $user) {
		$this->user = $user;

		if ($this->getUsernameInput($_REQUEST['LoginView::UserName'])) {
			$this->addMessage($this->messageType['userLength']);
		} else if ($this->getPasswordInput($_REQUEST['LoginView::Password'])) {
			$this->addMessage($this->messageType['passLength']);
		} else {
			$this->getUser($user);
		}
	}

	public function isLoggedIn(User $user) {
		$this->user = $user;
		
		if ($this->cookieIsSet()) {
			echo $this->getUserFound($_COOKIE['LoginView::CookieName'], $_COOKIE['LoginView::CookiePassword']);
			return true;
		}
	}

	public function logoutUser() {
		setcookie('LoginView::CookieName', '', time() - 3600);
		setcookie('LoginView::CookiePassword', '', time() - 3600);
		setcookie('LoginView::Message', 'Bye bye!', time() + (86400 * 30), "/");
		header('Location: index.php');
	}

	private function getUser() {
		if ($this->getUserFound($_REQUEST['LoginView::UserName'], $_REQUEST['LoginView::Password'])) {
			$this->setCookie('LoginView::CookieName', $_REQUEST['LoginView::UserName']);
			$this->setCookie('LoginView::CookiePassword', $_REQUEST['LoginView::Password']);
			setcookie('LoginView::Message', 'Welcome!', time() + (86400 * 30), "/");
			header('Location: index.php');
		} else {
			$this->addMessage($this->messageType['noUserFound']);
		}
	}

	private function setCookie($cookieName, $cookieValue) {
		setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/");
	}

	private function cookieIsSet() {
		return isset($_REQUEST['LoginView::CookieName']) && isset($_REQUEST['LoginView::CookiePassword']);
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

	protected function addMessage(String $message) {
		if (isset($_SESSION['LoginView::Message'])) {
		  $_SESSION['LoginView::Message'] .= $message . '<br>';
		} else {
		  $_SESSION['LoginView::Message'] = $message . '<br>';
		}
	}
}
