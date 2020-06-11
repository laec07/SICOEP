<?php
 include ("../../conexion.php");  
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}   
$em=$_SESSION['usuario']['id_empresa'];
$busca_foto=$_SESSION['usuario']['foto'];
if ($busca_foto=="") {
  $foto='../../dist/img/sin_foto.jpg';
}else{
   $foto='../../consultas/'.$_SESSION['usuario']['foto'];
}
/****************************************************/
$datos_empresa=mysqli_query($conexion,"SELECT * FROM empresa where id_empresa='$em'");
$empresa=mysqli_fetch_array($datos_empresa);
/************************************************/
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/*************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
$mes_actual= Date("m");
$año_actual= date("Y");
/*************************************************/
$placa=$_GET['placa'];
/***************************************************/
/****************************************************/
/***************************************************/
/******************************************************/
?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SICOEP</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
    <!-- Input file -->
  <link rel="stylesheet" href="../../dist/css/input_file.css">
   
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="../../dist/css/skins/skin-red.min.css">
  <link rel="shortcut icon" href="../../dist/img/logo.ico" />



  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--

-->
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>E</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SICO</b>EP</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="index.php" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          </li>-->
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="<?php echo $foto?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $_SESSION['usuario']['USUARIO']?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="<?php echo $foto?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['usuario']['NOMBRE'] ?> - <?php echo $_SESSION['usuario']['TIPO']?>
                  <!--<small>Member since Nov. 2012</small>-->
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left"> 
                  <a href="perfil.php" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="../../login/layout.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $foto?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['usuario']['NOMBRE'] ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>


      <!-- BARRA DE MENNU -->
      
      <ul class="sidebar-menu" data-widget="tree">

         <li class="header">MENU PRINCIPAL</li>
         <!--Dashboard -->
         <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard</a></li>            
          </ul>
        </li>
        <!--Vehículos -->       
        <li><a href="vehiculo.php"><i class="fa fa-car"></i><span>Vehículos</span></a></li>
        <!--Pilotos -->
        <li><a href="pilotos.php"><i class="fa fa-user"></i><span>Pilotos</span></a></li>
        <!--Asignaciones -->
        <li><a href="asignaciones.php"><i class="fa fa-edit"></i><span>Asignaciones</span></a></li>
        <!--Mantenimientos -->
        <li><a href="mantenimientos.php"><i class="fa fa-wrench"></i><span>Mantenimientos</span></a></li>
        <!--Combustible -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-tint"></i>
            <span>Combustible</span>
             <i class="fa fa-angle-left pull-right"></i>
            <span class="pull-right-container">           
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="solicitudes.php"><i class="fa  fa-check-square"></i>Solicitudes</a></li>
            <li><a href="rutas.php"><i class="fa  fa-car"></i>Rutas</a></li>
            <li ><a href="solicitudes_reporte.php"><i class="fa fa-line-chart"></i>Reportes</a></li>
            <li ><a href="gasolinera.php"><i class="fa fa-circle"></i>Gasolineras</a></li>
          </ul>
        </li>
        <!--Movimiento diario-->
        <li><a href="mov_diario.php"><i class="fa fa-road"></i><span>Mov diario</span></a></li>
        <!--Configuración -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gears"></i>
            <span>Configuración</span>
             <i class="fa fa-angle-left pull-right"></i>
            <span class="pull-right-container">           
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="usuarios.php"><i class="fa  fa-user-plus"></i>Usuarios</a></li>             
          </ul>
        </li>
       <!--Nuevo -->
       <!--/. Nuevo -->
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $empresa['empresa']; ?>
        <small>Seccion</small>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>-->
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
     
      
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <!-- Inicia contenedor principal -->
        <div class=" box box-danger">
          <!-- Head -->
          <div class="box-head">
            <h4>Carga documentos de vehículos</h4>
          <!-- ./ Head -->
          </div>
          <!--  Body -->
          <div class="box-body">
            <!--    column-->
            <div  class="row">
              <!--   firs column-->
              <div class="col-md-6">
                <form action="" id="form_subir">
                  
                  <div class="form-1-2 form-group">
                    <div class='file-input'>
                      <input type='file' name="archivo" class="form-control" required="">
                      <span class='button'>Seleccionar archivo</span>
                      <label class='label' data-js-label>No hay archivo seleccionado</label>
                    </div>
                    <br>
                    <label>Observaciones</label>
                    <input type="text" name="descripcion" class="form-control" maxlength="50" required="">
                  </div>

                  <div class="barra form-group">
                    <div class="barra_azul" id="barra_estado">
                      <span id="perct"></span>
                    </div>

                  </div>                  

                  <div class="acciones">
                    <div class="row">
                      <div class="col-md-4">
                        <input type="submit" class="btn btn-primary btn-block" value="Enviar"> 
                      </div>
                      <div class="col-md-4">
                        <input type="button" class="btn btn-danger btn-block" id="cancelar" value="Cancelar"> 
                      </div>
                    </div>
                  </div>

                  <input type="hidden" value="<?php echo $placa ?>" name="placa" id="placa">                  

                </form>
                <!--  ./ firs column-->
              </div>
            <!--  ./  column-->
            </div>
            <!--  ./ Body -->
          </div>
        <!-- ./ contenedor principal -->
        </div>

        <div id="contenido"></div>

       


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      v 2.1
    </div>
    <!-- Default to the left -->
    <strong>&copy;laec 2020 </strong> 
  </footer>

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE App -->
<script src="../../controllers/vehiculo_archivos.js"></script>


</body>
</html>