<?php

require_once('LoginCtrl.php');

class LogoutCtrl extends LoginCtrl {

	private $user;
	private $messageType = array(
		"logOut" => "Bye bye!"
	);

	public function isLoggedIn(User $user) {
		$this->user = $user;

		if ($this->cookieIsSet()) {
			return $this->findUserByCookie();
		}
	}

	public function logoutUser() {
		$this->clearCookies();
		header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
		exit();
	}

	private function clearCookies() {
		if ($this->cookieIsSet()) {
			setcookie('LoginView::CookieName', '', time() - 3600);
			setcookie('LoginView::CookiePassword', '', time() - 3600);
			parent::addMessage($this->messageType['logOut']);
		}
	}

	private function cookieIsSet() {
		return (isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword']));
	}

	private function findUserByCookie() {
		if ($this->user->findUser($_COOKIE['LoginView::CookieName'], $_COOKIE['LoginView::CookiePassword'])) {
			return true;
		} else {
			$this->addMessage('Wrong information in cookies');
			return false;
		}
	}
}
