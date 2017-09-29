<?php

require_once('LoginView.php');

class RegisterView extends LoginView {
	private static $register = 'RegisterView::Register';
	private static $registerName = 'RegisterView::UserName';
	private static $registerPassword = 'RegisterView::Password';
	private static $registerPasswordRepeat = 'RegisterView::PasswordRepeat';
	private static $registerMessageId = 'RegisterView::Message';

	/**
	 * Create HTTP response
	 *
	 * Should be called after a register attempt has been made
	 *
	 * @return  void BUT writes to standard output!
	 */
	public function response($isLoggedIn) {
		$message = parent::setMessage('RegisterView::Message') ?: '';

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
					<p id="' . self::$registerMessageId . '">' . $message . '</p>
			
					<label for="' . self::$registerName . '">Username :</label>
					<input type="text" size="20" name="' . self::$registerName . '" id="' . self::$registerName . '" value="' . parent::getRequestUserName() .'">
					<br>
			
					<label for="' . self::$registerPassword . '">Password  :</label>
					<input type="password" size="20" name="' . self::$registerPassword . '" id="' . self::$registerPassword . '" value="">
					<br>
			
					<label for="' . self::$registerPasswordRepeat . '">Repeat password  :</label>
					<input type="password" size="20" name="' . self::$registerPasswordRepeat . '" id="' . self::$registerPasswordRepeat . '" value="">
					<br>
			
					<input id="submit" type="submit" name="' . self::$register . '" value="Register">
					<br>
				</fieldset>
			</form>
		';
	}
}


