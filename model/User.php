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

    if (!isset($_SESSION['RegisterView::Message'])) {
      $this->userData = $this->dbHelper->saveData(array(
        'username' => $username,
        'password' => $this->hash($password)
      ));
      return true;
    }
  }

  public function findUser($username, $password) {

    $this->userData = $this->dbHelper->findData(array(
      'username' => $username
    ));

    if (password_verify($password, $this->userData->fetch()['password'])){
      return true;
    } else {
      return false;
    }
  }

  private function saveValidator($username, $password, $passwordRepeat) {
    $this->getUsernameMinLength($username);
    $this->getPasswordMinLength($password);
    $this->getUsernameExists($username);
    $this->getPasswordMatch($password, $passwordRepeat);
  }

  private function addMessage(String $message) {
    if (isset($_SESSION['RegisterView::Message'])) {
      $_SESSION['RegisterView::Message'] .= $message . '<br>';
    } else {
      $_SESSION['RegisterView::Message'] = $message . '<br>';
    }
	}

  private function hash($passToHash) {
    return password_hash("$passToHash", PASSWORD_BCRYPT, ["cost" => 8]);
  }

	private function getUsernameMinLength($username) {
    if (strlen($username) < 3) {
      $this->addMessage($this->messageType['userLength']);
    }
	}

	private function getPasswordMinLength($password) {
    if (strlen($password) < 6) {
      $this->addMessage($this->messageType['passLength']);
    }
	}

	private function getUsernameExists($username) {
		if (!empty($_POST['RegisterView::Register'])) {
			$this->addMessage($this->messageType['userExists']);
		}
  }
  
  private function getPasswordMatch($password, $passwordRepeat) {
		if ($password != $passwordRepeat) {
			$this->addMessage($this->messageType['passMatch']);
		}
	}
}

?>
