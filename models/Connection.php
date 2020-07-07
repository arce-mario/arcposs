<?php
/**
 *
 */
class Connection{

  public function connect(){
    $conn = new PDO("mysql:host=localhost;dbname=arcposs","ArcPossAdmin","Usuario123.");
    $conn -> exec("set names utf8");
    return $conn;
  }
}
