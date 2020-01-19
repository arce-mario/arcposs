<?php
require_once "Connection.php";
/**
 *
 */
class UserModel{
  /**
   * Show user
   */
  static public function showUsers($table, $data){

    if ($data != null) {
      //Define SELECT SQL;
      $sql = "SELECT * FROM $table WHERE ".$data['columnName']." = :value";

      //Prepare connection
      $stms = Connection::connect()->prepare($sql);

      //Set parameters of SQL query
      $stms -> bindParam(":value", $data['value'], PDO::PARAM_STR);

      $stms -> execute();

      return $stms -> fetch();

    }else{
      //Define SELECT SQL;
      $sql = "SELECT * FROM $table";

      //Prepare connection
      $stms = Connection::connect()->prepare($sql);
      $stms -> execute();

      return $stms -> fetchAll();

    }
  }

  static public function saveUser($table, $data){
    //Define INSERT SQL query
    $sql = "INSERT INTO $table (full_name, user_name, password, profile, picture) ".
           "VALUES (:fullName,:userName,:password,:rol,:picture)";

    //Prepare connection
    $stms = Connection::connect()->prepare($sql);

    //Set parameters of consult SQL
    $stms -> bindParam(":fullName", $data["fullName"], PDO::PARAM_STR);
    $stms -> bindParam(":userName", $data["userName"], PDO::PARAM_STR);
    $stms -> bindParam(":password", $data["password"], PDO::PARAM_STR);
    $stms -> bindParam(":rol", $data["rol"], PDO::PARAM_STR);
    $stms -> bindParam(":picture", $data["picture"], PDO::PARAM_STR);

    return $stms -> execute();
  }

  static public function editUser($table, $data){
    //Define UPDATE SQL query
    $sql = "UPDATE $table SET full_name = :fullName, user_name = :userName, ".
           "password = :password, profile = :rol, picture = :picture ".
           "WHERE user_id = :userID";

    //Prepare connection
    $stms = Connection::connect()->prepare($sql);

    //Set parameters of consult SQL
    $stms -> bindParam(":fullName", $data["fullName"], PDO::PARAM_STR);
    $stms -> bindParam(":userName", $data["userName"], PDO::PARAM_STR);
    $stms -> bindParam(":password", $data["password"], PDO::PARAM_STR);
    $stms -> bindParam(":rol", $data["rol"], PDO::PARAM_STR);
    $stms -> bindParam(":picture", $data["picture"], PDO::PARAM_STR);
    $stms -> bindParam(":userID", $data["userID"], PDO::PARAM_STR);

    return $stms -> execute();
  }

  static public function updateUser($table, $data){
    //Define UPDATE SQL query
    $sql = "UPDATE $table SET ".$data['columnName']." = :value ".
           "WHERE ".$data['where']." = :where";

    //Prepare connection
    $stms = Connection::connect()->prepare($sql);

    //Set parameters of consult SQL
    $stms -> bindParam(":value", $data["value"], PDO::PARAM_STR);
    $stms -> bindParam(":where", $data["whereValue"], PDO::PARAM_STR);

    return $stms -> execute();
  }

  static public function deleteUser($userID){
    //Define DELETE SQL query
    $sql = "DELETE FROM users WHERE user_id = :user_id";

    $stms = Connection::connect()->prepare("SELECT count(*) as count from users");
    $stms -> execute();
    $result = $stms -> fetch();

    if($result['count'] > 1){
      //Prepare connection
      $stms = Connection::connect()->prepare($sql);
      //Set parameters of consult SQL
      $stms -> bindParam(":user_id", $userID, PDO::PARAM_STR);
      return $stms -> execute();

    }else{
      return 3;
    }
  }
}
