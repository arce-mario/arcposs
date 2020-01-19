<?php
require_once "../controllers/User.controller.php";
require_once "../models/User.model.php";
require_once "../resources/Notifications.php";
/**
 *
 */
class UserAjax{

  static public function editUser($userID){

    $data = array('columnName' => "user_id", 'value' => $userID);

    $response = UserController::listUsers("users",$data);

    echo json_encode($response);
  }

  static public function validateUserName($userName){

    $data = array('columnName' => "user_name", 'value' => $userName);

    $response = UserController::listUsers("users",$data);
    echo response;
    echo json_encode($response["user_name"]);
  }

  static public function editStatus($userID, $status){

    $data = array('columnName' => "status", 'where' => "user_id", 'value' => $status,
                  'whereValue' => $userID);

    if ($data['value'] == "Activo") {

      $data['value'] = 0;
    }elseif ($data['value'] == "Inactivo"){

      $data['value'] = 1;
    }else{

      return -1;
    }

    if (UserController::updateUser("users",$data)) {

      echo json_encode($data['value']);
    }else{

      echo json_encode(-1);
    }

  }
}

if (isset($_POST["status"])) {

  $userAjax = new UserAjax();
  $userAjax -> editStatus($_POST["userID"],$_POST["status"]);
}elseif(isset($_POST["userID"])) {

  $userAjax = new UserAjax();
  $userAjax -> editUser($_POST["userID"]);
}elseif ($_POST["userName"]){

  $userAjax = new UserAjax();
  $userAjax -> validateUserName($_POST["userName"]);
}
