<?php

session_start();

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $cookieName = 'RegisterView::CookieName';
	private static $cookiePassword = 'RegisterView::CookiePassword';
	private static $messageId = 'RegisterView::Message';
	/**
	 * Create HTTP response
	 *
	 * Should be called after a register attempt has been made
	 *
	 * @return  void BUT writes to standard output!
	 */
	public function response() {
		$message = $this->setMessage() ?: '';

		$response = $this->generateRegisterFormHTML($message);
		return $response;
	}

	private function setMessage() {
		if(isset($_GET[self::$messageId])) {
			return $_GET[self::$messageId];
		}
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateRegisterFormHTML($message) {
		return '
			<h2>Register new user</h2>
			<form method="post">
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" /><br>

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" /><br>

					<label for="' . self::$passwordRepeat . '">Repeat password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" /><br>

					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
	}
}
