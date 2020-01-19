<?php
/**
 *
 */
class Connection{

  public function connect(){
    $conn = new PDO("mysql:host=localhost;dbname=pos_invetory_system","root","");
    $conn -> exec("set names utf8");
    return $conn;
  }
}
