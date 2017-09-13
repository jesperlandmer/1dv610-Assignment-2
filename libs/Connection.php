<?php
class Connection {

  private $dbHost = "localhost";
  private $dbName = "users";
  private $dbUser = "root";
  private $dbPass = "root";
  private $dbConnect;

  public function __construct() {

    try {
      $this->connectDB();
    }
    catch (PDOException $err) {
      $this->connectDBError($err);
    }
  }

  private function connectDB() {
    $this->dbConnect = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
    $this->dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  private function connectDBError() {
    echo "DB Connection Fail: $err";
    die();  //  terminate connection
  }

  public function getDBConnection() {

    if ($this->dbConnect instanceof PDO) {
     return $this->dbConnect;
    }
  }
}
?>
