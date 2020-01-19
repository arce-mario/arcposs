<?php session_start(); header("Cache-Control: no-cache, must-revalidate"); ob_start();?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inventory Sistem</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins-->
  <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Notifications -->
  <link rel="stylesheet" href="views/dist/css/notiny.css">
  <!--iCheck-->
  <link rel="stylesheet" href="views/plugins/iCheck/line/blue.css">
  <!--Scripts-->
  <!-- jQuery 3 -->
  <script src="views/bower_components/jquery/dist/jquery.min.js"></script>
</head>
  <?php
    $session = array('allow' => false,'cssClases' => "");
    if (isset($_SESSION["currentSession"]) && $_SESSION["currentSession"] != "") {
      $session['allow'] = true;
      $session['cssClases'] = "skin-blue sidebar-collapse sidebar-mini";
    }else{
      $session['cssClases'] = "login-page";
    }
  ?>
  <body class="<?php echo "hold-transition ".$session['cssClases'];?>">
    <?php
    //Show notifications
    if(isset($_SESSION["notifications"])){
      echo $_SESSION["notifications"];
      unset($_SESSION["notifications"]);
    }
    ?>
    <!-- Site wrapper -->
    <div class="wrapper">
      <?php
        //Validate if exist a current sesion
        if ($session['allow']) {

          //Header with name of system and data user
          include "modules/header.php";
          //Module of left menu
          include "modules/leftSideMenu.html";

          //Content main
          if (isset($_GET["route"])) {
            $routes = array('dashboard','users','categories','products','clients',
                            'register-sale','manager-sale','reports','login-out');

            $route = $_GET["route"];
            $band = true;
            foreach ($routes as $key => $value) {
              if($value == $route){
                include "modules/".$route.".php";
                $band = false;
                break;
              }
            }

            if($band){
              include "modules/error404.php";
            }

          }else{
            include "modules/dashboard.php";
          }

          //Footer
          include "modules/footer.php";

        }else{
          include "modules/login.php";
        }
      ?>
    </div>
    <!-- ./wrapper -->
    <!-- Bootstrap 3.3.7 -->
    <script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="views/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="views/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="views/dist/js/adminlte.min.js"></script>
    <script src="views/js/template.js"></script>
    <!--Notifications-->
    <script src="views/dist/js/notiny.js"></script>
  </body>
</html>
