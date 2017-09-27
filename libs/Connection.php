<?php
class Connection {

  private $dbHost = "localhost";
  private $dbName = "users";
  private $dbUser = "root";
  private $dbPass = "root";
  private $dbConnect;

  /**
	 * Start and handle database connection
	 *
	 * Should be called after a register attempt
	 *
	 * @return void
	 */
  public function __construct() {

    try {
      $this->dbConnect = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
      $this->dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $err) {
      $this->connectDBError($err);
    }
  }

  /**
	 * Handle PDO database connection errors
	 *
	 * Should be called after a db connection has failed
	 *
	 * @return void
	 */
  private function connectDBError($err) {
    echo "DB Connection Fail: $err";
    die();  //  terminate connection
  }

  /**
	 * Handle db connection
	 *
	 * Should be called when in need of db access
	 *
	 * @return PDO
	 */
  public function getDBConnection() {

    if ($this->dbConnect instanceof PDO) {
     return $this->dbConnect;
    }
  }
}
?>
