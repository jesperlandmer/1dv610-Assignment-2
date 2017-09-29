<?php

require_once('LayoutView.php');

class RegisterView extends LayoutView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';

	/**
	 * Create HTTP response
	 *
	 * Should be called after a register attempt has been made
	 *
	 * @return  void BUT writes to standard output!
	 */
	public function response($isLoggedIn) {
		$message = parent::getRequestStore('RegisterView::Message') ?: '';

		if (!$isLoggedIn) {
			$response = $this->generateRegisterFormHTML($message);
			return $response;
		} else {
			throw new Exception('Can\'t register when logged in');
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
					<input type="text" name="' . self::$name . '" id="' . self::$name . '" value="' . parent::getRequestStore(self::$registerName) .'">
					<br>
			
					<label for="' . self::$password . '">Password  :</label>
					<input type="password" name="' . self::$password . '" id="' . self::$password . '" value="">
					<br>
			
					<label for="' . self::$passwordRepeat . '">Repeat password  :</label>
					<input type="password" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="">
					<br>
			
					<input id="submit" type="submit" name="' . self::$register . '" value="Register">
					<br>
				</fieldset>
			</form>
		';
	}

}


