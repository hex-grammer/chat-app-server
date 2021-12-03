<?php
class Database
{
  // DB Params
  private $host = 'localhost';
  private $db_name = 'survei_api';
  private $username = 'root';
  private $password = '';
  private $conn;

  // HOSTED SERVER
  // private $host = 'localhost';
  // private $db_name = 'u110754158_teq_chat';
  // private $username = 'u110754158_root';
  // private $password = '^M1Y|4F~lVb';
  // private $conn;

  // DB Connect
  public function connect()
  {
    $this->conn = null;

    try {
      $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo 'Connection Error: ' . $e->getMessage();
    }

    return $this->conn;
  }
}
