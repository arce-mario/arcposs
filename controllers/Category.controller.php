<?php
/**
 *
 */
class CategoryController{

  /**
   * This method is for execute inserts and updates of categories to database
   **/
  static public function executePostActions(){
    //Create instance of Notifications class for show information in HTML view
    $notification = new Notification();

    if (isset($_POST['opc'])) {
      //Get option value from $opc data with format option:id_user
      $opc = preg_split("~:~",$_POST['opc'])[0];

      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST['category'])) {
        //if correctly data exist then excute methods for save registry or modify
        $categoryData = array('table' => "categories", 'category' => $_POST['category'],
                              'categoryID' => 0);

        if($opc == 0){
          //Call method to create a new category;
          self::createCategory($categoryData, $notification);
        }elseif ($opc == 1 && preg_split("~:~",$_POST['opc'])[1] != null) {
          //Get categoryID value from $opc data
          $categoryData["categoryID"] = preg_split("~:~",$_POST['opc'])[1];
          //Call method to edit registry of database;
          self::editCategory($categoryData, $notification);

        }else{
          //Show Notifications with error message in  HTML view
          $notification -> showNotification("Se ha detactado una modificación, ".
          "en los datos tecnicos de la solitud y la petición ha sido cancelada.",
          "¡Advertencia!, ¡detengase!","danger", 5000);

          header("location:categories");
        }

      }else{
        //Show Notifications with error message in  HTML view
        $notification -> showNotification("Revise que los datos hayan sido definidos".
        " correctamente.","Error en la información del formulario","danger", 5000);

        header("location:categories");
      }
    }
  }

  private static function createCategory($categoryData, $notification){
    $response = CategoryModel::createCategory($categoryData);

    if ($response) {
      //Show Notifications with success message in  HTML view
      $notification -> showNotification("Nueva categoría registrada correctamente",
      "¡Éxito!","success", 4000);
    }else{
      //Show Notifications with error message in  HTML view
      $notification -> showNotification("No se logró guardar el registro en el sistema".
      " posiblemente no haya tenido acceso a la base de datos",
      "Error interno","danger", 5000);
    }

    header("location:categories");
  }

  private static function editCategory($categoryData, $notification){
    $response = CategoryModel::editCategory($categoryData);

    if ($response) {
      //Show Notifications with success message in  HTML view
      $notification -> showNotification("Categoría editada correctamente",
      "¡Éxito!","success", 4000);
    }else{
      //Show Notifications with error message in  HTML view
      $notification -> showNotification("No se logró editar el registro en el sistema".
      " posiblemente no haya tenido acceso a la base de datos",
      "Error interno","danger", 5000);
    }

    header("location:categories");
  }
  /**
   * This method is for execute delete of categories to database
   **/
  static public function executeGetActions(){
    //Create instance of Notifications class for show information in HTML view
    $notification = new Notification();
    if (isset($_GET['categoryID'])) {
      $categoryData = array('table' => "categories", 'columnName' => "category_id",
                            'value' => $_GET['categoryID']);

      $category = CategoryModel::listCategories($categoryData);

      if($category != null){

        self::deleteCategory($categoryData, $notification,$category);

      }else{
        //Show Notifications with error message in  HTML view
        $notification -> showNotification("No se logró eliminar el registro en el sistema".
        " posiblemente el id sea incorrecto.",
        "Error al ejecutar la solicitud","danger", 5000);
      }
    }
  }

  static private function deleteCategory($categoryData, $notification, $category){

    $response = CategoryModel::deleteCategory($categoryData);

    if ($response) {
      //Show Notifications with success message in  HTML view
      $notification -> showNotification("Categoría <strong>".$category['category'].
      "</strong> eliminada correctamente", "¡Éxito!","success", 4000);
    }else{
      //Show Notifications with error message in  HTML view
      $notification -> showNotification("No se logró eliminar el registro del sistema".
      " posiblemente no haya tenido acceso a la base de datos.",
      "Error interno","danger", 5000);
    }

    header("location:categories");
  }

  static public function listCategories($categoryData){

    return CategoryModel::listCategories($categoryData);
  }
}
