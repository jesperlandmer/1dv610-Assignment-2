<?php

//INCLUDE THE LIBRARY FILES NEEDED...
require_once(__DIR__ . '/../libs/Connection.php');

class User {

  private $dbConnect;
  private $statement;

  /**
	 * Set DB Connection Variable
	 *
	 * Should be called after a new instance of User
	 *
	 * @return void
	 */
  public function __construct() {

    $db = new Connection();
    $this->dbConnect = $db->getDBConnection();
  }

  /**
	 * Save user data to db
	 *
	 * Should be called after a new register attempt
	 *
	 * @return void
	 */
  public function saveUser($name, $password) {
    $this->prepareUserSaveStatement();

    try {
      $this->executeUserSaveStatement(array(
        'username' => $name,
        'password' => $this->hash($password)
      ));
    } catch(PDOException $e) {
      $_SESSION["errorLog"][] = "User exists, pick another username.";
    }
  }

  /**
   * Find user data from db
   *
   * Should be called after a login attempt
   *
   * @return void
   */
  public function loginUser($name, $password) {
    $this->prepareUserLookUpStatement();

    $dbExecute = $this->executeUserSaveStatement(array(
      'username' => $name
    ));
    echo $this->dbConnect.fetchAll();
  }

  /**
	 * Hash user password
	 *
	 * Should be called when saving user data to DB
	 *
	 * @return string
	 */
  private function hash($passToHash) {
    return password_hash("$passToHash", PASSWORD_BCRYPT, ["cost" => 8]);
  }

  /**
	 * Prepare statement to save user
	 *
	 * Should be called after a register attempt
	 *
	 * @return void
	 */
  private function prepareUserSaveStatement() {
    $this->statement = $this->dbConnect->prepare("INSERT INTO user(username, password)
        VALUES(:username, :password)");
  }

  /**
   * Prepare statement to look up user
   *
   * Should be called after a login attempt
   *
   * @return void
   */
  private function prepareUserLookUpStatement() {
    $this->statement = $this->dbConnect->prepare("SELECT * FROM `user` WHERE 'username'=:username");
  }

  /**
	 * Execute statement to save user
	 *
	 * Should be called after a register attempt
	 *
	 * @return void
	 */
  private function executeUserSaveStatement(array $userData) {
    $this->statement->execute($userData);
  }
}
