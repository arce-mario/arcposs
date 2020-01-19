<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Gestión de categorías
      <small>Panel de control</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard"><i class="glyphicon glyphicon-th-large"></i> Administración</a></li>
      <li class="active">Categorías</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <div class="box-header with-border">
        <h3 class="box-title"><i class="glyphicon glyphicon-th-list"></i> Administrar categorías</h3>
      </div>

      <div class="box-body">

        <form method="POST" class="form-horizontal">
          <input type="hidden" id="opc" name="opc" value="0">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label for="categoryName"  style="width:72px;" class="col-sm-2 control-label">Categoría:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="category" name="category" placeholder="Nueva categoría">
                  <br>
                </div>
                <div class="col-sm-6">
                  <button id="btnFormCategory" type="submit" class="btn btn-primary">Guardar categoría</button>
                  <button id="btnReset" type="reset" class="btn btn-danger">Cancelar registro</button>
                </div>
              </div>
            </div>
            <div id="infoMessage" class="col-md-5"></div>
          </div>
          <?php
            $categoryController = new CategoryController();
            $categoryController -> executePostActions();
          ?>
        </form>
        <div class="row">

          <div class="col-md-12">
            <p><strong>Lista de registros en el sistema</strong></p>
            <table class="table table-bordered table-striped dt-responsive data-table" style="width:100%;">
              <thead>
                <tr>
                  <th style="width:40px;">#</th>
                  <th>Categoría</th>
                  <th>Fecha de registro</th>
                  <th>Cantidad de productos</th>
                  <th style="width:40px;"></th>
                  <th style="max-width:140px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $categoryData = array('table' => "categories");
                  $categories = CategoryController::listCategories($categoryData);

                  foreach ($categories as $key => $item) {
                    echo '<tr>
                      <td>'.(++$key).'</td>
                      <td>'.$item['category'].'</td>
                      <td>'.$item['create_at'].'</td>
                      <td>
                        <div class="progress progress-sm">
                          <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-blue">120/240</span>
                      </td>
                      <td style="text-align:center;">
                        <div class="btn-group">

                          <button class="btn btn-primary btn-xs edit-category" category-id="'.$item["category_id"].'">
                            <i class="fa fa-pencil"></i> Editar
                          </button>
                          <button class="btn btn-danger btn-xs delete-category" category-id="'.$item["category_id"].'">
                            <i class="fa fa-times"></i> Eliminar
                          </button>
                        </div>
                      </td>
                    </tr>';
                  }
                ?>
              </tbody>
            </table>
            <?php
              $category = new CategoryController();
              $category -> executeGetActions();
            ?>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>

<script type="text/javascript" src="views/js/category.page.js"></script>
