<?php

class LoginCtrl {

	private $user;
	private $salt = 'adsfasdfa*sdfaADSsdfAds^hthdgfhdaASDD*fsmJDJSJJ';
	private $messageType = array(
		"userLength" => "Username is missing",
		"passLength" => "Password is missing",
		"noUserFound" => "Wrong name or password",
		"welcome" => "Welcome",
		"logOut" => "Bye bye!"
	);

	public function loginUser(User $user) {
		$this->user = $user;
		$_SESSION['loginUser'] = $_REQUEST['LoginView::UserName'];

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

	public function isLoggedIn(User $user) {
		$this->user = $user;

		if ($this->cookieIsSet()) {
			return $this->findUserByCookie();
		}
	}

	public function logoutUser() {
		$this->clearCookies();
		header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
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

	private function clearCookies() {
		if ($this->cookieIsSet()) {
			setcookie('LoginView::CookieName', '', time() - 3600);
			setcookie('LoginView::CookiePassword', '', time() - 3600);
			setcookie('LoginView::Message', 'Bye bye!', time() + (86400 * 30), "/");
		}
	}

	private function cookieIsSet() {
		return (isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword']));
	}

	private function findUserByCookie() {
		echo md5($_COOKIE['LoginView::CookiePassword'], 'gadsgagfsd');
		if ($this->user->findUser($_COOKIE['LoginView::CookieName'], $_COOKIE['LoginView::CookiePassword'])) {
			return true;
		} else {
			$this->addMessage('Wrong information in cookies');
			return false;
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

	protected function addMessage(String $message) {
		if (isset($_SESSION['LoginView::Message'])) {
		  $_SESSION['LoginView::Message'] .= $message . '<br>';
		} else {
		  $_SESSION['LoginView::Message'] = $message . '<br>';
		}
	}
}
