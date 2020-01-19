<?php
require_once "resources/Notifications.php";
/**
 *
 */
class ImageUser{

  static public function saveImage($image,$name){

    //Get width and height from original image
    list($orgWidth, $orgHeight) = getimagesize($image["tmp_name"]);

    //Define new name for image user
    $name = $name.$randomNumber = mt_rand(40000,125000);

    $path = self::resizeImage($image, $orgWidth, $orgHeight, $name);

    return $path;
  }

  static public function replaceImage($image,$name,$currentPath){
    //Remove current image
    if ($currentPath != "") {
      unlink($currentPath);
    }
    return self::saveImage($image,$name);
  }

  static public function deleteImage($path){
    unlink($path);
  }

  static private function resizeImage($image, $orgWidth, $orgHeight, $name){
    $notification = new Notification();
    $dstImg = imagecreatetruecolor(300,300);
    //Define default path of user pictures
    $path = "views/dist/img/user_images/";

    if ($image["type"] == "image/jpeg") {

      //Add new name for image to variable path
      $path = $path.$name."jpg";
      //Resize image (default size 300x300)
      $originImage = imagecreatefromjpeg($image["tmp_name"]);
      imagecopyresized($dstImg, $originImage, 0, 0, 0, 0, 300, 300,$orgWidth, $orgHeight);
      //Save image file in local server
      imagejpeg($dstImg, $path);

    }else if($image["type"] == "image/png"){

      //Add new name for image to variable path
      $path = $path.$name."png";
      //Resize image (default size 300x300)
      $originImage = imagecreatefrompng($image["tmp_name"]);
      imagecopyresized($dstImg, $originImage, 0, 0, 0, 0, 300, 300,$orgWidth, $orgHeight);
      //Save image file in local server
      imagepng($dstImg, $path);
    }

    //Show Notifications with message in  HTML view
    $notification -> showNotification('Imagen <b>'.$name.'</b> '.
     'guardada correctamente.',"Nuevo recurso","light", 4000);

    return $path;
  }
}
