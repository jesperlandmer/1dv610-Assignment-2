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
  public function saveUser($username, $password) {
    $this->saveUserStatement();

    try {
      $this->executeSaveUserStatement(array(
        'username' => $username,
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
  public function loginUser($username, $password) {

    $stmt = $this->dbConnect->prepare('SELECT * FROM Users WHERE username=:name');
    $stmt->bindParam(':name', $username);
    $stmt->execute();

    if (password_verify($password, $stmt->fetch()['password'])){
      $_SESSION['LoginView::CookieName'] = $username;
      $_SESSION['LoginView::CookiePassword'] = $password;
      echo 'exists!';
    } else {
      $_SESSION["errorLog"][] = 'Wrong name or password';
    }
  }

  public function find(array $data) {
    $stmt = $this->dbConnect->prepare('SELECT * FROM Users WHERE username=:username');
    $stmt->execute($data);
    return password_verify($password, $stmt->fetch()['password']);
  }

  public function userExists($username) {
    $stmt = $this->dbConnect->prepare('SELECT * FROM Users WHERE username=:name');
    $stmt->bindParam(':name', $username);
    $stmt->execute();
    return $stmt->rowCount() > 0;
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
  private function saveUserStatement() {
    $this->statement = $this->dbConnect->prepare("INSERT INTO Users(username, password)
        VALUES(:username, :password)");
  }

  /**
   * Prepare statement to look up user
   *
   * Should be called after a login attempt
   *
   * @return void
   */
  private function lookUpUserStatement() {
    $this->statement = $this->dbConnect->prepare("SELECT username FROM users WHERE username = :name");
  }

  /**
	 * Execute statement to save user
	 *
	 * Should be called after a register attempt
	 *
	 * @return void
	 */
  private function executeSaveUserStatement(array $userData) {
    $this->statement->execute($userData);
  }

  private function executeLookUpUserStatement(array $userData) {
    $this->statement->execute($userData);
  }
}

?>
