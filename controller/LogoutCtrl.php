<?php

require_once('LoginCtrl.php');

class LogoutCtrl extends LoginCtrl {

	private $user;
	private $messageType = array(
		"logOut" => "Bye bye!"
	);

	/**
	 * Checks if logged in or not
	 * @return boolean
	 */
	public function isLoggedIn(User $user) {
		if ($this->cookieIsSet()) {
			return $this->findUserByCookie($user);
		}
	}

	/**
	 * Log out user and clear cookies
	 * @return void BUT updates request headers
	 */
	public function logoutUser() {
		$this->clearCookies();
		header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
		exit();
	}

	/**
	 * Clear user cookies
	 * @return void BUT updates cookies
	 */
	private function clearCookies() {
		if ($this->cookieIsSet()) {
			setcookie('LoginView::CookieName', '', time() - 3600);
			setcookie('LoginView::CookiePassword', '', time() - 3600);
			parent::addMessage($this->messageType['logOut']);
		}
	}

	/**
	 * @return boolean user cookies set or not
	 */
	private function cookieIsSet() {
		return (isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword']));
	}

	/**
	 * Find user based on the set user cookies
	 * @return boolean user found or not
	 */
	private function findUserByCookie($user) {
		if ($user->findUser($_COOKIE['LoginView::CookieName'], $_COOKIE['LoginView::CookiePassword'])) {
			return true;
		} else {
			$this->addMessage('Wrong information in cookies');
			return false;
		}
	}
}
