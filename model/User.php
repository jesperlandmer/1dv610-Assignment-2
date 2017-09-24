<?php

//INCLUDE THE LIBRARY FILES NEEDED...
require_once(__DIR__ . '/../libs/DatabaseHelper.php');

class User {

  private $dbHelper;
  private $userData;
  private $errorMessage;
  private $errorMessageType = array(
    "userLength" => "Username has too few characters, at least 3 characters.",
    "passLength" => "Password has too few characters, at least 6 characters.",
    "passMatch" => "Passwords do not match.",
    "userExists" => "User exists, pick another username.",
    "noUserFound" => "Wrong name or password"
);

  /**
	 * Fetch Database Helper Functions
	 *
	 * Should be called after a new instance of User
	 *
	 * @return void
	 */
  public function __construct() {

    $this->dbHelper = new DatabaseHelper();
  }

  /**
	 * Save user data to db
	 *
	 * Should be called after a new register attempt
	 *
	 * @return void
	 */
  public function saveUser($username, $password, $passwordRepeat) {

    $this->saveValidator($username, $password, $passwordRepeat);
    $this->userData = $this->dbHelper->saveData(array(
      'username' => $username,
      'password' => $this->hash($password)
    ));

    return true;
  }

  public function findUser($username, $password) {

    $this->userData = $this->dbHelper->findData(array(
      'username' => $username
    ));

    if (password_verify($password, $this->userData->fetch()['password'])){
      return true;
    } else {
      header("Location:" . $_SERVER['PHP_SELF'] . "?LoginView::Message=Wrong name or password");
    }
  }

  private function saveValidator($username, $password, $passwordRepeat) {
    $this->getUsernameMinLength($username);
    $this->getPasswordMinLength($password);
    $this->getUsernameExists($username);
    $this->getPasswordMatch($password, $passwordRepeat);
    if (isset($this->errorMessage)) {
      header("Location:" . $_SERVER['PHP_SELF'] . "?register&RegisterView::Message=" . $this->errorMessage);
    }
  }

  private function addError(String $message) {
		$this->errorMessage .= $message . '<br>';
	}

  private function hash($passToHash) {
    return password_hash("$passToHash", PASSWORD_BCRYPT, ["cost" => 8]);
  }

	private function getUsernameMinLength($username) {
    if (strlen($username) < 3) {
      $this->addError($this->errorMessageType['userLength']);
    }
	}

	private function getPasswordMinLength($password) {
    if (strlen($username) < 6) {
      $this->addError($this->errorMessageType['passLength']);
    }
	}

	private function getUsernameExists($username) {
		if (!empty($_POST['RegisterView::Register'])) {
			$this->addError($this->errorMessageType['userExists']);
		}
  }
  
  private function getPasswordMatch($password, $passwordRepeat) {
		if ($password != $passwordRepeat) {
			$this->addError($this->errorMessageType['passMatch']);
		}
	}
}

?>
