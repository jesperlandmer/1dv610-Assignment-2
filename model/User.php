<?php

//INCLUDE THE LIBRARY FILES NEEDED...
require_once(__DIR__ . '/../libs/DatabaseHelper.php');

class User {

  private $dbHelper;
  private $userData;
  private $messageType = array(
    "userLength" => "Username has too few characters, at least 3 characters.",
    "passLength" => "Password has too few characters, at least 6 characters.",
    "passMatch" => "Passwords do not match.",
    "userExists" => "User exists, pick another username.",
    "invalidUsernameFormat" => "Username contains invalid characters.",
    "noUserFound" => "Wrong name or password"
  );

  /**
	 * Fetch Database Helper Functions
	 *
	 * Should be called after a new instance of model User
	 *
	 * @return void
	 */
  public function __construct() {

    $this->dbHelper = new DatabaseHelper();
  }

  /**
	 * Save user data to DB if validator passes
	 *
	 * Should be called after a new register attempt
	 *
	 * @return boolean
	 */
  public function saveUser($username, $password, $passwordRepeat) {

    $this->saveValidator($username, $password, $passwordRepeat);

    if (!isset($_SESSION['RegisterView::Message'])) {
      $this->userData = $this->dbHelper->saveData(array(
        'username' => $username,
        'password' => $this->hash($password)
      ));
      return true;
    }
  }

  /**
	 * Find user from DB
	 *
	 * @return boolean if user is found or not
	 */
  public function findUser($username, $password) {

    $this->userData = $this->getUser($username);

    //Check against hashed password
    if (password_verify($password, $this->userData->fetch()['password'])){
      return true;
    } else {
      return false;
    }
  }

  /**
	 * Start validator methods
	 *
	 * @return void BUT writes to session message!
	 */
  private function saveValidator($username, $password, $passwordRepeat) {
    $this->getValidInputFormat($username);
    $this->getUsernameMinLength($username);
    $this->getPasswordMinLength($password);
    $this->getUsernameExists($username);
    $this->getPasswordMatch($password, $passwordRepeat);
  }

	/**
   * Add message to session stored message outputted in register page view
   * @param $message, string to add to session
	 * @return void
	 */
  private function addMessage(String $message) {
    if (isset($_SESSION['RegisterView::Message'])) {
      $_SESSION['RegisterView::Message'] .= $message . '<br>';
    } else {
      $_SESSION['RegisterView::Message'] = $message . '<br>';
    }
	}

  /**
   * Create a hash of input password
   * @param $passToHash
	 * @return string, hashed passwored
	 */
  private function hash($passToHash) {
    return password_hash("$passToHash", PASSWORD_BCRYPT, ["cost" => 8]);
  }

  /**
   * Find user in DB
   * @param $username, string to find DB row by
	 * @return array, PDO database object
	 */
  private function getUser($username) {
    return $this->dbHelper->findData(array(
      'username' => $username
    ));
  }

  /**
   * Check if input is not script
   * @param $username, string to filter
	 * @return void, BUT writes to session message!
	 */
  private function getValidInputFormat($username) {
    if (filter_var($username, FILTER_SANITIZE_STRING) != $username) {
      $this->addMessage($this->messageType['invalidUsernameFormat']);
    }
	}

  /**
   * Check if username input length is longer than 3
   * @param $username, string to evaluate
	 * @return void, BUT writes to session message!
	 */
	private function getUsernameMinLength($username) {
    if (strlen($username) < 3) {
      $this->addMessage($this->messageType['userLength']);
    }
	}

  /**
   * Check if password input length is longer than 6
   * @param $password, string to evaluate
	 * @return void, BUT writes to session message!
	 */
	private function getPasswordMinLength($password) {
    if (strlen($password) < 6) {
      $this->addMessage($this->messageType['passLength']);
    }
	}

  /**
   * Check if user exists
   * @param $username, string to evaluate
	 * @return void, BUT writes to session message!
	 */
	private function getUsernameExists($username) {
		if ($this->getUser($username)->rowCount() > 0) {
			$this->addMessage($this->messageType['userExists']);
		}
  }
  
  /**
   * Check if password and repeated password match
   * @param $password, $passwordRepeat, strings to match
	 * @return void, BUT writes to session message!
	 */
  private function getPasswordMatch($password, $passwordRepeat) {
		if ($password != $passwordRepeat) {
			$this->addMessage($this->messageType['passMatch']);
		}
	}
}

?>
