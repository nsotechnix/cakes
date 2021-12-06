<?php

/**
 *
 */
class DbConfig {

  protected $servername = 'localhost';
  protected $username = "amarbazar_mlm";
  protected $password = "Otechnix@12345#";
  // public function __construct() {
  //   if ($_SERVER['HTTP_HOST'] == 'localhost') {
  //     $this->password="";
  //   } else {
  //     $this->password="Otechnix@123";
  //   }
  // }

  public function connect() {
    try {

      $connection = new PDO("mysql:host=$this->servername;dbname=amarbazar_mlm", $this->username, $this->password);

      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // echo "Connected!";

      return $connection;
    } catch (PDOException $e) {

      echo '<br>' . $e->getMessage();
    }
  }
}
