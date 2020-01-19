<?php
require_once "Connection.php";
/**
 *
 */
class ProductModel{

  static public function listProducts($productData){

    if (isset($productData['value'])){
      //Define SQL SELECT;
      $sql = "SELECT * FROM ".$productData['table']." WHERE ".$productData['columnName']." = :value ORDER BY code DESC";

      //Prepare connection
      $stms = Connection::connect() -> prepare($sql);

      //Set parameters of SQL consult
      $stms -> bindParam(":value", $productData['value'], PDO::PARAM_STR);
      $stms -> execute();
      return $stms -> fetch();

    }else{
      //Define SELECT SQL;
      $sql = "SELECT * FROM ".$productData['table'];
      //Prepare connection
      $stms = Connection::connect() -> prepare($sql);

      $stms -> execute();
      return $stms -> fetchAll();
    }
  }
}
