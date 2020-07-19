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

/***************************************************/

/****************************************************/
/***************************************************/
/******************************************************/
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SICOEP</title>
  <!-- Tell the browser to be responsive to screen width -->
  
  <!-- Select2 -->
  <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
  <meta content="width=device-width" name="viewport">
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
    <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
      <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> 
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- estilo check box-->
  <link rel="stylesheet" href="../../dist/css/checkbox.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="../../dist/css/skins/skin-red.min.css">
  <link rel="shortcut icon" href="../../dist/img/logo.ico" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

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
         <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard</a></li>            
          </ul>
        </li>
        <!--Vehículos -->       
        <li><a href="vehiculo.php"><i class="fa fa-car"></i><span>Vehículos</span></a></li>
        <!--Pilotos -->
        <li><a href="pilotos.php"><i class="fa fa-user"></i><span>Pilotos</span></a></li>
                <!--Prueba manejo-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-columns"></i>
            <span>Prueba manejo</span>
             <i class="fa fa-angle-left pull-right"></i>
            <span class="pull-right-container">           
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pm_prueba.php"><i class="fa  fa-file-text"></i>Prueba</a></li>
            <li><a href="pm_aspirantes.php"><i class="fa  fa-user"></i>Aspirantes</a></li>
            <li><a href="pm_config.php"><i class="fa  fa-gears"></i>Configuración</a></li>
             
          </ul>
        </li>
        <!--Asignaciones -->
        <li><a href="asignaciones.php"><i class="fa fa-edit"></i><span>Asignaciones</span></a></li>
        <!--Mantenimientos -->
        <li><a href="mantenimientos.php"><i class="fa fa-wrench"></i><span>Mantenimientos</span></a></li>
        <!--Combustible -->
        <li class=" active treeview">
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
            <li class="active"><a href="solicitudes_reporte.php"><i class="fa fa-line-chart"></i>Reportes</a></li>
            <li ><a href="gasolinera.php"><i class="fa fa-circle"></i>Gasolineras</a></li>
          </ul>
        </li>
        <!--Movimiento diario-->
        <li ><a href="mov_diario.php"><i class="fa fa-road"></i><span>Mov diario</span></a></li>
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
            <li><a href="../../manuales/SICOEP-VEHICULOS.pdf" target="_blank"><i class="fa  fa-book"></i>Manual usuario - Vehiculo</a></li>
            <li><a href="../../manuales/SICOEP-OPERATIVO.pdf" target="_blank"><i class="fa  fa-book"></i>Manual usuario - Operativo</a></li>             
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
        <small>Reportes combustible</small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid connectedSortable ">
      
      <ul class="nav nav-tabs">
        <li class="active"><a href="#general" data-toggle="tab" >General    </a> </li>
        <li><a href="#detalle" data-toggle="tab" > Detalles   </a> </li>
        <li><a href="#cierre" data-toggle="tab" > Cierres rutas   </a> </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade in active" id="general">
<!---Panel 1 -------------------------------------------------------------------------------------------------->
          <div class="box box-info">
              <div class="box-head">
                <div class="row">
                  <div class="col-md-10">
                    <h4 class="box-title">Seleccione parametros:<small>General</small></h4>
                  </div>
                  <div class="col-md-2">
                    <label>IDP </label> <input type="checkbox" id="check_idp"> 
                  </div>
                </div> 
              </div>
            <div class="box-body">
              <div class="row">
                <!--------------------------------- -->
                <div class="col-md-2">
                  <label>Buscar por:</label>
                  <select class="form-control" id="g_buscapor" onchange="g_buscar_por()" >
                    <option value="1">SEDE</option>
                    <option value="2">CANAL</option>
                  </select>
                </div>
                <!--------------------------------- -->
                <div class="col-md-2" id="g_buscado">
                  
                </div>
                <!--------------------------------- -->
                <div class="col-md-3">
                      <label>Del:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control" name="g_f1" id="g_f1" value="<?php echo Date("Y-m-d")?>">
                      </div>                
                </div>
                <!--------------------------------- -->
                <div class="col-md-3">
                      <label>Al:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control" name="g_f2" id="g_f2" value="<?php echo Date("Y-m-d")?>">
                      </div><!-- /.input group -->   
                </div>
                <!--------------------------------- -->
                <div class="col-md-2">
                  <label></label> 
                  <a class="btn btn-primary form-control" onclick="g_buscar();" title="Buscar"><span class="fa fa-search"></span> </a>
                </div>
                <!--------------------------------- -->         
              </div>
            </div>
          </div>
          <div id="muestratabla"></div>

        </div>
<!--Panel 2------------------------------------------------------------------------------------->
        <div class="tab-pane fade" id="detalle">
            <div class="box box-info">
              <div class="box-head">
                <h4 class="box-title">Seleccione parametros:<small> Detalles</small></h4>
              </div>
            <div class="box-body">
              <div class="row">
                <!--------------------------------- -->
                <div class="col-md-2">
                  <label>Buscar por:</label>
                  <select class="form-control" id="buscapor" onchange="buscar_por()" >
                    <option value="1">SEDE</option>
                    <option value="2">CANAL</option>
                  </select>
                </div>
                <!--------------------------------- -->
                <div class="col-md-2" id="buscado">
                  
                </div>
                <!--------------------------------- -->
                <div class="col-md-3">
                      <label>Del:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control" name="f1" id="f1" value="<?php echo Date("Y-m-d")?>">
                      </div>                
                </div>
                <!--------------------------------- -->
                <div class="col-md-3">
                      <label>Al:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control" name="f2" id="f2" value="<?php echo Date("Y-m-d")?>">
                      </div><!-- /.input group -->   
                </div>
                <!--------------------------------- -->
                <div class="col-md-1">
                  <label></label>
                  <a class="btn btn-primary form-control" onclick="buscar();" title="Buscar"><span class="fa fa-search"></span> </a>
                </div>
                <!--------------------------------- -->         
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
               <div id="mostrardatos"></div>
            </div>
            <div class="col-md-6">
               <div id="mostrardetalle1"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
               <div id="mostrardetallec"></div>
            </div>
            <div class="col-md-6">
               <div id="mostrardetaller"></div>
            </div>
          </div>
        </div>
<!-------------- Panel 3 ---------------------------------------------->
        <div class="tab-pane fade" id="cierre">
<!---Panel 1 -------------------------------------------------------------------------------------------------->
          <div class="box box-info">
              <div class="box-head">
                <h4 class="box-title">Seleccione parametros:<small>Cierres rutas</small></h4>
              </div>
            <div class="box-body">
              <div class="row">
                <!--------------------------------- -->
                <div class="col-md-3">
                  <label>SEDE:</label>
                  <select class="form-control" id="g_buscapor"  >
                    <option>TODOS</option>
                  </select>
                </div>
                <!--------------------------------- -->
                <div class="col-md-3">
                  <label>Mes:</label>
                  <input type="month" name="mes" id="mes" class="form-control">
                </div>
                <!--------------------------------- -->

                <!--------------------------------- -->
                <div class="col-md-1">
                  <label></label>
                  <a class="btn btn-primary form-control" onclick="g_buscar();" title="Buscar"><span class="fa fa-search"></span> </a>
                </div>
                <!--------------------------------- -->         
              </div>
            </div>
          </div>
          <div id="muestratabla"></div>

        </div>
      </div>
    
    
    
      <!--------------------------
        | Your Page Content Here |
        -------------------------->

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

 

      
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Acciones desde la bd -->
<script src="../../controllers/solicitud_reportes.js"></script>



</body>
</html>