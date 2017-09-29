<?php

class LoginCtrl {

	private $username;
	private $password;
	private $user;
	private $messageType = array(
		"userLength" => "Username is missing",
		"passLength" => "Password is missing",
		"noUserFound" => "Wrong name or password",
		"welcome" => "Welcome"
	);

	/**
	 * Login user
	 *
	 * Should be called after an attempt has been made to log in
	 *
	 * @return void, BUT writes to session message and does redirect
	 */
	public function loginUser(User $user) {
		$this->setCredentials($user);

		// CHECK INPUTS
		if ($this->getUsernameInput()) {
			$this->addMessage($this->messageType['userLength']);
		} else if ($this->getPasswordInput()) {
			$this->addMessage($this->messageType['passLength']);
		} else {
			$this->getUser();
			header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
			exit();
		}
	}

	/**
	 * Set private and session variables for user
	 * @return void BUT sets class variables!
	 */
	 private function setCredentials($user) {
		$this->user = $user;
		$this->username = $_REQUEST['LoginView::UserName'];
		$this->password = $_REQUEST['LoginView::Password'];
		$_SESSION['LoginView::UserName'] = $this->username;
	}

	/**
	 * Get user credentials and set cookies.
	 * @return void BUT writes to session message!
	 */
	private function getUser() {
		if ($this->getUserFound()) {
			$this->setUserCookies();
			$this->addMessage($this->messageType['welcome']);
		} else {
			$this->addMessage($this->messageType['noUserFound']);
			
		}
	}

	/**
	 * Set cookies for logged in user
	 * @return void BUT writes to cookies!
	 */
	private function setUserCookies() {
		$this->setCookieWithTime('LoginView::CookieName', $this->username);
		$this->setCookieWithTime('LoginView::CookiePassword', $this->password);
	}

	/**
	 * Set cookies that expires in 30 days (86400 sec = 1 day)
	 * @return void BUT writes to cookies!
	 */
	private function setCookieWithTime($cookieName, $cookieValue) {
		setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/");
	}

	/**
	 * Fetch find user method from model
	 * @return boolean, if user exists or not
	 */
	private function getUserFound() {
		return $this->user->findUser($this->username, $this->password);
	}

	/**
	 * @return boolean, username input is empty or not
	 */
	private function getUsernameInput() {

		return strlen($this->username) <= 0;
	}

	/**
	 * @return boolean, password input is empty or not
	 */
	private function getPasswordInput() {
		
		return strlen($this->password) <= 0;
	}

	/**
	 * Add message to session stored message outputted in login page view
	 * @param $message, message to add to session
	 * @return void
	 */
	protected function addMessage(String $message) {
		if (isset($_SESSION['LoginView::Message'])) {
		  $_SESSION['LoginView::Message'] .= $message . '<br>';
		} else {
		  $_SESSION['LoginView::Message'] = $message . '<br>';
		}
	}
}
