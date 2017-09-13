<?php
class User {

  private $dbConnect;

  public function __construct(Connection $db) {

    $this->dbConnect = $db->getDBConnection();
  }

  public function saveUser($name, $password) {

    $password = $this->hash($password);
    $sth = $this->dbConnect->prepare('SELECT *
    FROM users');
    $result = $sth->fetchAll();
    echo var_dump($result);
  }

  private function hash($passToHash) {
    return password_hash("$passToHash", PASSWORD_BCRYPT, ["cost" => 8]);
  }
}
