<?php
include_once "Controller.php";
/**
 *
 */
class UserController extends Controller{

  public function loginUser(){

    if (isset($_POST['userName'])) {
      
      if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['userName'])&&
          isset($_POST['userPassword'])) {

          $table = "users";
          $crypt = crypt($_POST['userPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
          $userData = array('columnName' => "user_name", 'value' => $_POST['userName']);

          $response = UserModel::showUsers($table, $userData);

          if($response != NULL && $response["password"] == $crypt){

            if ($response['status']) {
              $_SESSION['currentSession'] = $response;

              //Define last login
              date_default_timezone_set('America/Managua');
              $currentDate = date("Y-m-d H:i:s");
              $data = array('columnName' => "last_login", 'where' => "user_id", 'value' => $currentDate,
                            'whereValue' => $response["user_id"]);

              if(UserModel::updateUser($table, $data)){
                echo '<script>window.location = "dashboard";</script>';
              }else{
                echo '<br><div class="alert alert-danger">Error interno del sistema, reintente nuevamente.</div>';
              }

            } else {
              echo '<br><div class="alert alert-danger">Error, usuario desactivado.</div>';
            }


          }else{
            echo '<br><div class="alert alert-danger">Error, no se logró acceder al sistema.</div>';
          }

      }
    }
  }

  public function executeGetActions(){

    if(isset($_GET['userID'])){
      //Create instance of Notifications class for show information in HTML view
      $notification = new Notification();
      $userData = array('columnName' => "user_id", 'value' => $_GET['userID']);
      $user = UserModel::showUsers("users",$userData);
      $response = false;

      if($user != null){
        $response = UserModel::deleteUser($_GET['userID']);
      }

      if($response == 3){
        //Show Notifications with error message in  HTML view
        $notification -> showNotification("No se logró eliminar el usuario.",
        "¡Alerta! Acción no permitida","danger", 5000);

      }else if($response){
        //Show Notifications with success message in  HTML view
        $notification -> showNotification("El usuario se ha eliminado correctamente.",
        "Éxito","success", 3000);
        ImageUser::deleteImage($user["picture"]);

      }else{
        //Show Notifications with error message in  HTML view
        $notification -> showNotification("No se logró ejecutar la acción solicitada.",
        "Error al eliminar el usuario.","danger", 5000);
      }
      header("location:users");
    }
  }

  public function executePostActions(){
    //Create instance of Notifications class for show information in HTML view
    $notification = new Notification();
    $picture = "";

    if(isset($_POST['opc'])){

      $opc = preg_split("~:~",$_POST['opc'])[0];
      //Validate data from view for userName
      if (validateData($_POST['userFullName'],1) && validateData($_POST['userName'],2) &&
          validateData($_POST['userRol'],2) && validateData($_POST['userPassword'],3)) {

            $crypt = "";
            //Save registry in data base
            if ($_POST['userPassword'] != "") {

              $crypt = crypt($_POST['userPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            }else{

              $crypt = crypt($_POST['currentPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            }

            $userData = array("fullName" => $_POST['userFullName'],
                              "userName" => $_POST['userName'],
                              "rol" => $_POST['userRol'],
                              "password" => $crypt,
                              "picture" => "",
                              "userID" => "");

            if($opc == 0){
              //Call method to create a new user;
              self::createUser($userData);
            }elseif ($opc == 1 && validateData($_POST['currentPassword'],3) &&
                     $_POST['currentImage'] != null) {

              $userData["picture"] = $_POST['currentImage'];
              $userData["userID"] = preg_split("~:~",$_POST['opc'])[1];
              //Call method to edit registry of database;
              self::editUser($userData);
            }else{
              //Show Notifications with error message in  HTML view
              $notification -> showNotification("Se ha detactado una modificación, ".
              "en los datos tecnicos de la solitud y la petición ha sido cancelada.",
              "¡Advertencia!, ¡detengase!","danger", 5000);
            }

      }else{
        //Show Notifications with error message in  HTML view
        $notification -> showNotification("Revise que los datos hayan sido definidos".
        "correctamente.","Error en la información del usuario","danger", 5000);
      }
    }
  }

  private function createUser($userData){
    //Create instance of Notifications class for show information in HTML view
    $notification = new Notification();

    //Validate if user send image file from HTML form
    if ($_FILES["userImage"]["tmp_name"] != null) {
      //Excecute method for different format of images (PNG/JPEG)
      $userData["picture"] = Imageuser::saveImage($_FILES["userImage"], $userData['userName']);
    }

    $table = "users";
    //Call function saveUser() in User.Model.php
    $response = UserModel::saveUser($table, $userData);

    if($response){
      //Show Notifications with success message in  HTML view
      $notification -> showNotification("El usuario se ha registrado correctamente.",
      "Éxito","success", 3000);
      header("location:users");
    }else{
      //Show Notifications with error message in  HTML view
      $notification -> showNotification("No se logró acceder a la base datos.",
      "Error al registrar el usuario ","danger", 5000);
    }
  }

  private function editUser($userData){
    //Create instance of Notifications class for show information in HTML view
    $notification = new Notification();

    //Validate if user send image file from HTML form
    if ($_FILES["userImage"]["tmp_name"] != null) {
      //Excecute method for different format of images (PNG/JPEG)
      $userData["picture"] = Imageuser::replaceImage($_FILES["userImage"],
               $userData['userName'],$_POST['currentImage']);
    }

    $table = "users";
    //Call function saveUser() in User.Model.php
    $response = UserModel::editUser($table, $userData);

    if($response){
      //Show Notifications with success message in  HTML view
      $notification -> showNotification("El usuario se ha modificado correctamente.",
      "Éxito","success", 3000);
      header("Location: users");
    }else{
      //Show Notifications with error message in  HTML view
      $notification -> showNotification("No se logró acceder a la base datos.",
      "Error al modificar el registro.","danger", 5000);
    }
  }

  public function listUsers($table,$data){

    return UserModel::showUsers($table, $data);
  }

  public function updateUser($table, $data){

    return $result = UserModel::updateUser($table, $data);
  }
}
