<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Gestión de productos
      <small>panel de control</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard"><i class="glyphicon glyphicon-th-large"></i> Administración</a></li>
      <li class="active">Productos</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Box products list -->
    <div class="box">

      <div class="box-header with-border">
        <h3 class="box-title"><i class="glyphicon glyphicon-th-list"></i> Lista de productos registrados</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
      </div>

      <div class="box-body">

        <div class="form-group">
          <div class="btn-group">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Registrar producto</button>
            <button type="button" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Exportar a pdf</button>
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-eye"></i> Mostrar columna de acciones</a></li>
              </ul>
            </div>
          </div>
        </div>

        <table id="productsTable" class="table table-bordered table-striped dt-responsive" style="width:100%;">
          <thead>
            <tr>
              <th style="width:20px;">#</th>
              <th>Imagen</th>
              <th>Código</th>
              <th>Descripción</th>
              <th>Categoría</th>
              <th>Stock</th>
              <th style="min-width:60px;">Precio de compra</th>
              <th style="min-width:60px;">Precio de venta</th>
              <th>Agregado</th>
              <th style="min-width:100px;">Acciones</th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>

<div class="modal fade" id="modal-default" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="productForm" method="post">

        <input type="hidden" name="opc" value="0">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Registrar producto</h4>
        </div>
        <div class="modal-body">

          <div class="row">

            <div class="col-md-8">
              <strong>Selecionar Imagen del producto</strong>
              <p class="help-block">Imagen con tamaño máximo de 20 MB.</p>
              <input type="file" style="margin-bottom: 10px;" name="userImage" class="user-profile">
            </div>

            <div class="col-md-4">
              <img src="views/dist/img/products/default/anonymous.png" style="height: 94px;" class="img-thumbnail img-prev">
            </div>
          </div>

          <div class="form-group">
            <strong>Datos generales del producto</strong>
          </div>

          <div class="row">
            <div class="col-md-4">
              <!--input for product code value-->
              <div class="form-group">
               <div class="input-group">
                 <span class="input-group-addon">
                   <i class="fa fa-barcode"></i>
                 </span>
                 <input type="text" class="form-control" id="code" name="code" placeholder="Código" required disabled>
               </div>
              </div>
            </div>
            <div class="col-md-8">
              <!--Select for product category value-->
              <div class="form-group">
               <div class="input-group">
                 <span class="input-group-addon">
                   <i class="fa fa-table"></i>
                 </span>
                 <select type="text" class="form-control" id="category" name="category" required>
                   <option value="0">Selecionar categoría</option>
                   <?php
                     //Get categories from database
                     $categoryData = array('table' => "categories");
                     $categories = CategoryController::listCategories($categoryData);

                     foreach($categories as $key => $item){
                       echo '<option value="'.$item['category_id'].'">'.$item['category'].'</option>';
                     }
                   ?>
                 </select>
               </div>
             </div>
            </div>

            <div class="col-md-12">
              <!--textarea for product description value-->
              <div class="form-group">
                <textarea class="form-control" rows="2" placeholder="Descripción del producto"></textarea>
              </div>
            </div>
          </div>

          <div class="form-group">
            <strong>Datos base del inventario</strong>
            <p class="help-block">Defina la cantidad de productos en existencia con un valor entero.</p>
            <div class="row">
              <div class="col-lg-5" style="margin-bottom: 8px;">
                <input type="checkbox" class="icheck">
              </div>
              <div class="col-lg-3">
                <div class="input-group input-group-sm" id="percentGroup" style="display:none;">
                  <input type="number" class="form-control" id="percent" placeholder="porcentaje" value="40">
                  <span class="input-group-addon"><strong>%</strong></span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <!--input for product stock value-->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-check"></i>
                </span>
                <input type="number" class="form-control" id="stock" name="stock" min="0" placeholder="Stock" required>
              </div>
            </div>
            <!--input for product bay price value-->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-arrow-up"></i>
                </span>
                <input type="text" class="form-control" id="purchasePrice" name="purchasePrice" min="0" placeholder="Precio compra" required>
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-arrow-down"></i>
                </span>
                <input type="text" class="form-control" id="salePrice" name="salePrice" min="0" placeholder="Precio venta" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
          <button type="submit" class="btn btn-primary pull-left">Guardar registro</button>
        </div>
      </form>
      <?php
        $productController = new ProductController();
        $productController -> excecutePostActions();
      ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script type="text/javascript" src="views/js/product.page.js"></script>
<script type="text/javascript" src="views/plugins/iCheck/icheck.js"></script>
