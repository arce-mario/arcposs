<?php
/**
 *
 */
class ProductController{

  //This method validates the product data from the HTML view
  static public function executePostActions(){

  }
  //Executes the method call in the model to save the record
  static private function saveProduct(){
    //Create instance of Notifications class for show information in HTML view
    $notification = new Notification();
    $picture = "";

    if(isset($_POST['opc'])){

      $opc = preg_split("~:~",$_POST['opc'])[0];
      //Validate data from view for userName

    }

  }

  //This function list all products from database
  static public function listProducts($ProductData){

    return ProductModel::listProducts($ProductData);

  }
}
?>
