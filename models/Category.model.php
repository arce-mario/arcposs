<?php
require_once "Connection.php";
/**
 *
 */
class CategoryModel{

  static public function listCategories($categoryData){

    if (isset($categoryData['value'])){
      //Define SELECT SQL;
      $sql = "SELECT * FROM ".$categoryData['table']." WHERE ".$categoryData['columnName']." = :value";
      //Prepare connection
      $stms = Connection::connect() -> prepare($sql);

      //Set parameters of consult SQL
      $stms -> bindParam(":value", $categoryData['value'], PDO::PARAM_STR);
      $stms -> execute();
      return $stms -> fetch();

    }else{
      //Define SELECT SQL;
      $sql = "SELECT * FROM ".$categoryData['table'];
      //Prepare connection
      $stms = Connection::connect() -> prepare($sql);

      $stms -> execute();
      return $stms -> fetchAll();
    }
  }

  static public function createCategory($categoryData){
    $sql = "INSERT INTO ".$categoryData['table']." (category) VALUES (:category)";

    //Prepare connection
    $stms = Connection::connect() -> prepare($sql);

    //Set parameters of consult SQL
    $stms -> bindParam(":category", $categoryData['category'], PDO::PARAM_STR);

    return $stms -> execute();
  }

  static public function editCategory($categoryData){
    $sql = "UPDATE ".$categoryData['table']." SET category = :category WHERE category_id = :category_id";

    //Prepare connection
    $stms = Connection::connect() -> prepare($sql);

    //Set parameters of consult SQL
    $stms -> bindParam(":category", $categoryData['category'], PDO::PARAM_STR);
    $stms -> bindParam(":category_id", $categoryData['categoryID'], PDO::PARAM_STR);

    return $stms -> execute();
  }

  static public function deleteCategory($categoryData){
    $sql = "DELETE FROM ".$categoryData['table']." WHERE ".$categoryData['columnName']." = :value";

    //Prepare connection
    $stms = Connection::connect() -> prepare($sql);

    //Set parameters of consult SQL
    $stms -> bindParam(":value", $categoryData['value'], PDO::PARAM_STR);

    return $stms -> execute();
  }
}
