<?php
require_once "../controllers/Product.controller.php";
require_once "../models/Product.model.php";
require_once "../controllers/Category.controller.php";
require_once "../models/Category.model.php";
/**
 *
 */
class ProductAjax{

  static public function listProductsForDataTable(){
    //Get all products from database
    $productData = array('table' => "products");
    $products = ProductController::listProducts($productData);
    $list = array();

    foreach ($products as $key => $item) {
      //Define value for actions column in HTML table
      $buttonsAction = '<div class="btn-group">
        <button class="btn btn-primary btn-xs edit-product" product-id="'.$item["product_id"].'">
          <i class="fa fa-pencil"></i> Editar
        </button>
        <button class="btn btn-danger btn-xs delete-product" product-id="'.$item["product_id"].'">
          <i class="fa fa-times"></i> Eliminar
        </button>
      </div>';

      //Get category name with category_id value
      $categoryData = array('table' => "categories",'columnName' => "category_id",
                            'value' => $item['category_id']);
      $category = CategoryController::listCategories($categoryData);

      //Load image if exist path value in database
      if ($item['image'] == null) {
        $imageCell = '<img src="views/dist/img/user1-128x128.jpg" width="40px">';
      }else{
        $imageCell = '<img src="'.$item['image'].'" width="40px">';
      }

      //Show alerts for stock product value
      if ($item['stock'] < 10) {
        $stockClass = "bg-red";
      }elseif ($item['stock'] >= 10 && $item['stock'] <= 15) {
        $stockClass = "bg-yellow";
      }else{
        $stockClass = "bg-blue";
      }
      //Construct JSON array with logic of DataTable
      array_push($list,array(
        ($key+1),
        $imageCell,
        $item['code'],
        $item['description'],
        $category['category'],
        '<span class="badge '.$stockClass.'" style="width:52px; text-align: center;">'.$item['stock'].' und</span>',
        '$ '.$item['purchase_price'],
        '$ '.$item['sale_price'],
        $item['date'],
        preg_replace("/[\r\n|\n|\r]+/", "", $buttonsAction)
      ));
    }
    //Send in HTTP response, the JSON array for DataTable plugin
    echo '{"data":'.json_encode($list).'}';
  }

  static public function getLastProducForCategory($categoryID){
    //Get last product for category with category_id value
    $productData = array('table' => "products",'columnName' => "category_id",
                          'value' => $categoryID);

    $product = ProductController::listProducts($productData);

    echo json_encode($product['code']);
  }
}

if (isset($_POST["categoryID"])) {
  ProductAjax::getLastProducForCategory($_POST["categoryID"]);
}else{
  ProductAjax::listProductsForDataTable();
}
