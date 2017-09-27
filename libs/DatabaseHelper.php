<?php

require_once('Connection.php');

class DatabaseHelper {

  private $dbConnect;

  public function __construct() {
    $db = new Connection();
    $this->dbConnect = $db->getDBConnection();
  }

  public function saveData($data) {
    $sql = 'INSERT INTO Users(username, password) VALUES(:username, :password)';
    $stmt = $this->dbConnect->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function findData($data) {
    $sql = 'SELECT * FROM Users WHERE ';

    foreach($data as $key => $value)
    {
      $sql .= $key . '=:' . $key;
      if(end($data) != $value){
        $sql .= ' AND ';
      }
    }

    $stmt = $this->dbConnect->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }
}
?>
