<header class="main-header">
  <!--Logotipo-->
  <a href="#" class="logo">
    <!--Mini logo-->
    <span class="logo-mini">
      <b class="glyphicon glyphicon-briefcase"></b>
    </span>
    <!--Regular logo-->
    <span class="logo-lg">
      <b>Inventory System</b>
    </span>
  </a>
  <!--Sidebar-->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!--Profile user-->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php
              if ($_SESSION['currentSession']['picture'] != '' AND is_file($_SESSION['currentSession']['picture'])) {

                echo '<img src="'.$_SESSION['currentSession']['picture'].'" class="user-image" alt="User Image">';
              }else{

                echo '<img src="views/dist/img/user_images/anonymous-white.png" class="user-image" alt="User Image">';
                $_SESSION['currentSession']['picture'] = "views/dist/img/user_images/anonymous-white.png";
              }
            ?>
            <span class="hidden-xs"><?php echo $_SESSION['currentSession']['user_name']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo $_SESSION['currentSession']['picture']; ?>" class="img-circle" alt="User Image">
              <p>
                <?php echo $_SESSION['currentSession']['full_name']; ?>
                <small><?php echo $_SESSION['currentSession']['profile'];  ?></small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Perfil</a>
              </div>
              <div class="pull-right">
                <a href="login-out" class="btn btn-default btn-flat">Cerrar sesión</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
