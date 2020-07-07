<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Gestión de usuarios
      <small>panel de control</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard"><i class="glyphicon glyphicon-th-large"></i> Administración</a></li>
      <li class="active">Usuarios</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <form id="userForm" method="post" enctype="multipart/form-data">
      <input type="hidden" id="opc" name="opc" value="0">
      <div id="boxUserForm" class="box collapsed">
        <!--Block box header-->
        <div class="box-header with-border">
          <h4 id="formTitle" class="box-title"><i class="fa fa-user-plus"></i> Nuevo registro</h4>
          <div class="box-tools pull-right">
            <button id="btnFormUser" type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!--Block box body-->
        <div class="box-body">
          <div class="row">
            <!--First column of the form for register user-->
            <div class="col-md-3">
              <!--input for user name value-->
              <div id="userNameGroup" class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </span>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario" required>
                </div>
              </div>
              <!--input for user password value-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-lock"></i>
                  </span>
                  <input type="password" class="form-control" autocomplete="new-password" id="password" name="password" placeholder="Contraseña" required>
                </div>
              </div>
            </div>

            <!--Second column of the form for register user-->
            <div class="col-md-3">
              <!--input for user name value-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </span>
                  <input type="text" class="form-control" id="userFullName" name="userFullName" placeholder="Ingresar nombre" required>
                </div>
              </div>
              <!--select for rol value-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-unlock-alt"></i>
                  </span>
                  <select class="form-control" id="userRol" name="userRol" placeholder="Nombre completo" required>
                    <option value="" selected>Selecionar un rol</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Especial">Especial</option>
                    <option value="Vendedor">Vendedor</option>
                  </select>
                </div>
              </div>
            </div>
            <!--Three column of the form for register user-->
            <div class="col-md-6" style="overflow:hidden;">
              <div style="width: 280px;" class="pull-left">
                <strong>Selecionar foto de perfil</strong>
                <p class="help-block">Imagen con tamaño máximo de 20 MB.</p>
                <input type="file" style="margin-bottom: 10px;" name="userImage" class="user-profile">
              </div>
              <div style="width:100px; padding 0 10px;" class="pull-left">
                <img src="views/dist/img/default.png" style="height: 94px;" class="img-thumbnail img-prev">
              </div>
            </div>
          </div>
          <?php
            $user = new UserController();
            $user -> executePostActions();
          ?>
        </div>
        <!--Block box footer-->
        <div class="box-footer">
          <button id="save" type="submit" class="btn btn-primary">Nuevo registro</button>
          <button id="reset" onclick="resetUserForm();" type="reset" class="btn btn-danger">Cancelar registro</button>
        </div>
      </div>
    </form>

    <div class="box">
      <div class="box-header with-border">
        <h4 class="box-title"><i class="fa fa-users"></i> Usuarios registrados en el sistema</h4>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive data-table" style="width:100%;">
          <thead>
            <tr>
              <th style="width:10px;">#</th>
              <th style="max-width:35px;">Foto</th>
              <th>Nombre</th>
              <th>Usuario</th>
              <th>Rol</th>
              <th style="max-width:60px;">Estado</th>
              <th>Última sesión</th>
              <th style="min-width:123px;">Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php
              $users = UserController::listUsers("users",null);
              $count = 0;
              foreach ($users as $key => $item) {
                //Define text to show in column status, from numeric status values of database
                if ($item['status'] == 0) {
                  $status = '<button type="button" class="btn btn-danger btn-xs btn-status" '.
                            'user-id="'.$item["user_id"].'" style="width:53px;">Inactivo</button>';
                }else{
                  $status = '<button type="button" class="btn btn-success btn-xs btn-status" '.
                            'user-id="'.$item["user_id"].'" style="width:53px;">Activo</button>';
                }

                if($item["picture"] != '' AND !file_exists($item["picture"]))
                   $item["picture"] = 'views/dist/img/user_images/anonymous.png';

                echo 'hola mundo '.file_exists($item["picture"]);

                echo '<tr>
                  <td>'.++$count.'</td>
                  <td>
                    <img src="'.$item["picture"].'" style="width: 25px;">
                  </td>
                  <td>'.$item["full_name"].'</td>
                  <td>'.$item["user_name"].'</td>
                  <td>'.$item["profile"].'</td>
                  <td style="text-align:center;">
                    '.$status.'
                  </td>
                  <td>'.($item["last_login"] != null? $item["last_login"]: "Sin registros").'</td>
                  <td style="text-align:center;">
                    <div class="btn-group">
                      <button class="btn btn-primary btn-xs edit-user" user-id="'.$item["user_id"].'">
                        <i class="fa fa-pencil"></i> Editar
                      </button>
                      <button class="btn btn-danger btn-xs delete-user" user-id="'.$item["user_id"].'">
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
          $user = new UserController();
          $user -> executeGetActions();
        ?>
      </div>
    </div>
  </section>
</div>
<script type="text/javascript" src="views/js/user.page.js"></script>
