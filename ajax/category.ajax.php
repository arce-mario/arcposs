<?php
require_once "../controllers/Category.controller.php";
require_once "../models/Category.model.php";
require_once "../resources/Notifications.php";
/**
 *
 */
class CategoryAjax{

  static public function showUser($categotyID){
    $categoryData = array('table' => "categories", 'columnName' => "category_id",
                          'value' => $categotyID);
    $response = CategoryController::listCategories($categoryData);

    echo json_encode($response);
  }
}

if(isset($_POST["categoryID"])){

  $category = new CategoryAjax();
  $category -> showUser($_POST['categoryID']);
}
