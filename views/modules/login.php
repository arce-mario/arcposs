<div class="login-box">

  <div class="login-logo">
    <b>Inventory</b> System

  </div>

  <div class="login-box-body">

    <p class="login-box-msg">Inicie sesión para poder acceder al sistema</p>

    <form action="#" method="post">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Nombre de usuario" name="username" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
      <?php
        $login = new UserController();
        $login -> loginUser();
      ?>
    </form>

    <a href="register.html" class="text-center">Registrarse en el sistema</a>

  </div>

</div>
