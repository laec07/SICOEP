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
$fecha_actual= Date("Y/m/d");
$mes_actual= Date("m");
$año_actual= date("Y");
//////////////////////////////////////////////
$id_solicitud=$_GET['id_solicitud'];
/**********************************************/
$ruta=mysqli_query($conexion,
  "
SELECT
  c.id_solicitud,
  c.id_depto,
  c.id_ruta,
  r.ruta,
  r.piloto,
  r.tipo_vehi,
  r.id_equipo,
  r.canal,
  c.tipo_combustible,
  c.galones,
  c.precio,
  c.total,
  r.asignado_gal,
  r.restantes_gal
FROM
  combustible_detalle c,
  ruta r
WHERE c.id_ruta=r.id_ruta 
AND c.id_solicitud=$id_solicitud
  ");
/****************************************************/
$dt=mysqli_query($conexion,"SELECT Depto FROM depto d,combustible_solicitud c WHERE c.id_solicitud='$id_solicitud' AND c.id_depto=d.Id_depto");
$depto=mysqli_fetch_array($dt);
/***************************************************/
$ts=mysqli_query($conexion,"SELECT sum(total) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total=mysqli_fetch_array($ts);
/******************************************************/
$ts_g=mysqli_query($conexion,"SELECT sum(galones) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total_g=mysqli_fetch_array($ts_g);
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
  <meta content="width=device-width" name="viewport">
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
   
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
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
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
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
          <!-- Messages: style can be found in dropdown.less-->
          <!--<li class="dropdown messages-menu">-->
            <!-- Menu toggle button -->
            <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>-->
                <!-- inner menu: contains the messages -->
               <!-- <ul class="menu">-->
                 <!-- <li>start message -->
                   <!-- <a href="#">
                      <div class="pull-left">-->
                        <!-- User Image -->
                       <!-- <img src="dist/img/sin_foto.jpg" class="img-circle" alt="User Image">
                      </div>-->
                      <!-- Message title and timestamp -->
                     <!-- <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>-->
                      <!-- The message -->
                    <!--  <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>-->
                  <!-- end message -->
              <!--  </ul>-->
                <!-- /.menu -->
             <!-- </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>-->
          <!-- /.messages-menu -->

          <!-- Notifications Menu -->
          <!--<li class="dropdown notifications-menu">-->
            <!-- Menu toggle button -->
           <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>-->
                <!-- Inner Menu: contains the notifications -->
              <!--  <ul class="menu">-->
                  <!--<li> start notification -->
                  <!--  <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>-->
                  <!-- end notification -->
               <!-- </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>-->
          <!-- Tasks Menu -->
          <!--<li class="dropdown tasks-menu">-->
            <!-- Menu Toggle Button -->
           <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>-->
                <!-- Inner menu: contains the tasks -->
             <!--   <ul class="menu">-->
                 <!-- <li> Task item -->
                 <!--   <a href="#">-->
                      <!-- Task title and progress text -->
                   <!--   <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>-->
                      <!-- The progress bar -->
                  <!--    <div class="progress xs">-->
                        <!-- Change the css width attribute to simulate progress -->
                     <!--   <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>-->
                  <!-- end task item -->
              <!--  </ul>
              </li>-->
            <!--   <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
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
             <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>-->
                <!-- /.row -->
              <!-- </li>-->
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
          <!-- Control Sidebar Toggle Button -->
       <!--   <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
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

      <!-- search form (Optional) 
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>-->
      <!-- /.search form -->

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
            <li ><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard</a></li>            
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
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-tint"></i>
            <span>Combustible</span>
             <i class="fa fa-angle-left pull-right"></i>
            <span class="pull-right-container">           
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="solicitudes.php"><i class="fa  fa-check-square"></i>Solicitudes</a></li>
            <li><a href="rutas.php"><i class="fa  fa-car"></i>Rutas</a></li>
            <li ><a href="solicitudes_reporte.php"><i class="fa fa-line-chart"></i>Reportes</a></li>
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
      <div class="row">
        <div class="col-md-5">
          <h3>
            <?php echo $empresa['empresa']; ?>
            <small>Solicitudes combustible</small>
          </h3>
           
        </div>
        <div class='col-md-3'>
      <div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <div class="row">
          <div class="col-md-6">
            <h4>Total: <?php echo $rps['moneda']. number_format($total['total'],2,'.',',');?></h4> 
          </div>
          <div class="col-md-2">
            <h4>Galones: <?php echo  number_format($total_g['total'],2,'.',',');?></h4> 
          </div>
        </div>
                 
    </div>
  </div>
         <div class="col-md-4">
          <a href="solicitudes.php" class="btn btn-info"   title="Regresar"><i class="fa fa-mail-reply"></i> Regresar</a>
          
        </div>
        
      </div>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
     
      
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
      <div class='box box-warning'>
        <div class='box-header with-border''>
          <div class='row'>
            <div class='col-md-3'>
              <h3 class='box-title'><?php echo $depto['Depto'];?> -</h3><small>Solicitud No. <?php echo $id_solicitud; ?> </small>
            </div>
          </div>
          
        </div>
      <div class='box-body'>
            <div style='overflow:scroll;height: 100% '>
              <table id='example2' class='table table-bordered table-striped'>
                <thead>
                  <tr>               
                  <th>Ruta</th>
                  <th>Piloto</th>
                  <th>Tipo vehi.</th>
                  <th>Placa</th>
                  <th>Canal</th>
                  <th>tipo combustible</th>
                  <th>Galones</th>
                  <th>Precio</th>
                  <th>Total</th>
                  <th>Gal. disponibles</th>
                  <th>Gal. Asignados</th>
                  
                </tr>   
                </thead>
                <tbody>
                <?php
                while ($fila=mysqli_fetch_array($ruta)) {

                 

                    echo "
                    <tr>
                      <td>".$fila['ruta']."</td>
                      <td>".$fila['piloto']."</td>
                      <td>".$fila['tipo_vehi']."</td>
                      <td>".$fila['id_equipo']."</td>
                      <td>".$fila['canal']."</td>
                      <td>".$fila['tipo_combustible']."</td>
                      <td>".$fila['galones']."</td>
                      <td>".$fila['precio']."</td>
                      <td>".$fila['total']."</td>
                      <td>".$fila['restantes_gal']."</td>
                      <td>".$fila['asignado_gal']."</td>
                      
                    </tr>

                    ";
                  }  
                ?>
                </tbody>
          </table>
            </div>
            <div class='modal-footer'>
            <form method='POST' action='../../consultas/solicitud_autorizar.php'>
            <input type='hidden' value=<?php echo $id_solicitud;?> name='id_solicitud'  >
            <input type="hidden" name="estado" value="APROBADO" >
            <input type="submit" onclick="return confirm('Aprobando solicitud No. <?php echo $id_solicitud ?>, ¿Desea continuar?')" class='btn btn-success' value='Aprobar'>
            <input type="hidden" name="motivo">
            <a  data-toggle='modal' data-target='#RechaSolicitud' class='btn btn-danger'>Rechazar</a>
            </form>
            
            </div>
          </div><!--Termina box body-->
                  
        </div>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- *************Rechazo******************** -->
   <div class="modal modal-danger fade" id="RechaSolicitud">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Motivo rechazo:</h4>
              </div>
              <div class="modal-body">
                <form action='../../consultas/solicitud_autorizar.php' method="POST">
                    <div class="form-group">
                      <label for="motivo">Describa motivo:</label>
                      <textarea class="form-control" name="motivo"></textarea>
                      <input type='hidden' value=<?php echo $id_solicitud;?> name='id_solicitud'  >
                      <input type="hidden" name="estado" value="RECHAZADO">
                    </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Aplicar</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- *************./Rechazo******************** -->
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      v 2.0
    </div>
    <!-- Default to the left -->
    <strong>&copy;laec 2018 </strong> 
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

<script >



</script>
</body>
</html>