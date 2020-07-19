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
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
  <!-- galería -->
  <link rel="stylesheet"  href="../../dist/css/lightbox.css">
  <!-- efectos imagenes -->
  <link rel="stylesheet"  href="../../dist/css/imagen_hover.css"> 

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
        <!--Prueba manejo-->
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-columns"></i>
            <span>Prueba manejo</span>
             <i class="fa fa-angle-left pull-right"></i>
            <span class="pull-right-container">           
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pm_prueba.php"><i class="fa  fa-file-text"></i>Prueba</a></li>
            <li class="active"><a href="pm_aspirantes.php"><i class="fa  fa-user"></i>Aspirantes</a></li>
            <li><a href="pm_config.php"><i class="fa  fa-gears"></i>Configuración</a></li>
             
          </ul>
        </li>
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
      <div class="row">
        <div class="col-md-10">
          <h3>
            <?php echo $empresa['empresa']; ?>
            <small>Aspirantes</small>
          </h3>
        </div>
         <div class="col-md-1">
          <a href="" class="btn btn-info" data-target="#nuevoUsu" data-toggle='modal' title="Nuevo Aspirante"><i class="fa fa-plus"></i> Aspirante</a>
        </div>
      </div>

    </section>

    <!-- Main content -->
    <section class="content container-fluid">
     
     <div id="contenido"></div> 

<!-- modales -->

 <div class="modal" id="nuevoUsu" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nuevo Aspirante </h4>                       
                    </div>
                    <div class="modal-body">
                       <form action="" method="POST">                  
                          <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input class="form-control" id="nombre" required="" name="nombre" type="text" placeholder="Nombre" maxlength="50" required="" ></input>
                          </div>
                          <div class="form-group">
                            <label for="edad">Email:</label>
                            <input class="form-control" id="email" maxlength="50" name="email" type="email" placeholder="ejemplo@correo.com"></input>
                          </div>
                          <div class="form-group">
                            <label for="direccion">Telefono:</label>
                            <input class="form-control" id="tel" name="tel" type="number"  placeholder="Telefono"></input>
                          </div>
                          <div class="form-group">
                            <label for="direccion">Direccion:</label>
                            <input class="form-control" id="dir" name="dir" type="text" placeholder="Direccion"></input>
                          </div>
                          <div class="form-group">
                            <label for="direccion"><?php echo $rps['doc'];?></label>
                            <input class="form-control" id="dpi" name="dpi" type="number" placeholder="<?php echo $rps['doc'];?>"></input>
                          </div>
                          <div class="form-group">
                            <label for="direccion">Tipo Licencia:</label>
                            
                            <select class="form-control" id="tipo" name="tipo" type="number">
                        
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                        <option>M</option>
                        <option>Liviana</option>
                        <option>Pesada</option>
                        <option>Profesional</option>
                    </select>
                          </div>
                          <div class="form-group">
                            <label for="direccion">Numero Licencia:</label>
                            <input class="form-control" id="numlic" required="" name="numlic" type="text" placeholder="Licencia"></input>
                          </div>

                        <div class="form-group">
                          <label>Fecha vencimiento licencia</label>
                          <input type="date" name="fecha_venci" id="fecha_venci" class="form-control" value="<?php echo date('Y-m-d') ?>">
                        </div>

                        <div class="form-group">
                          <label>Experiencia(años)</label>
                          <input type="number" name="experiencia" id="experiencia" class="form-control" max="50" step="1" >
                        </div>

              <button type="button" class="btn btn-success" onclick="insert_data();" data-dismiss="modal">Guardar</button>
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso pilotos******************** --> 
  <!-- *************Form Edita fotos******************** -->
        <div class="modal fade" id="editPick">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar foto</h4>
              </div>
              <div class="modal-body">
                <form  action="../../consultas/piloto_foto.php" enctype="multipart/form-data" method="post">
                 
              <input type="text"  name="id_piloto" id="id_piloto" style="display: none;" >
               <input  type="file" id="files1" name="archivo" class="input-file ng-pristine ng-valid ng-touched" files-model="" ng-model="project.fileList">
              <div div class="upload2" upload-image="" id="imagePreview1">
                <label for="files1">
                  <span class="add-image">
                    Foto </br>1
                  </span>
                  <output id="list" for="imagePreview1"></output>
                </label>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <!-- *************./Form Editar fotos******************** --> 
  <!-- *************Form Foto licencia******************** -->
        <div class="modal fade" id="editLic">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Foto Licencia</h4>
              </div>
              <div class="modal-body">
                <form  action="../../consultas/piloto_licencia.php" enctype="multipart/form-data" method="post">
              <input type="text"  name="id_piloto" id="id_piloto" style="display: none;" >
               <input  type="file" id="files2" name="archivo" class="input-file ng-pristine ng-valid ng-touched" files-model="" ng-model="project.fileList">
              <div div class="upload2" upload-image="" id="imagePreview2">
                <label for="files2">
                  <span class="add-image">
                    Foto </br>Licencia
                  </span>
                  <output id="list" for="imagePreview2"></output>
                </label>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <!-- *************./Form Foto licencia******************** --> 
      <!-- *************Form Edita pilotos******************** -->
        <div class="modal" id="editUsu" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Editar Aspirante</h4>
                    </div>
                    <div class="modal-body">                      
                       <form action="../../consultas/piloto_edita.php" method="POST">                          
                                  
                                  <input  id="id" name="id" type="hidden" ></input>       
                              <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input class="form-control" id="nombre" name="nombre" type="text" ></input>
                              </div>
                              <div class="form-group">
                                <label for="edad">E-mail:</label>
                                <input class="form-control" id="email" name="email" type="text" ></input>
                              </div>
                              <div class="form-group">
                                <label for="edad">Telefono:</label>
                                <input class="form-control" id="tel" name="tel" type="text" ></input>
                              </div>
                              <div class="form-group">
                                <label for="direccion">Direccion:</label>
                                <input class="form-control" id="direccion" name="direccion" type="text" ></input>
                              </div>
                              <div class="form-group">
                                <label for="direccion"><?php echo $rps['doc'];?></label>
                                <input class="form-control" id="dpi" name="dpi" type="text" ></input>
                              </div>
                              <div class="form-group">
                                <label for="direccion">Licencia:</label>

                                <input class="form-control" id="lic" name="lic" type="text" ></input>
                              </div>
                              <div class="form-group">
                                <label for="direccion">Tipo:</label>

                          <select class="form-control" id="tipo" name="tipo" type="text">

                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                        <option>M</option>
                        <option>Liviana</option>
                        <option>Pesada</option>
                        <option>Profesional</option>
                    </select>
                              </div>

                         <div class="form-group">
                          <label>Fecha vencimiento licencia</label>
                          <input type="date" name="fecha_venci_e" id="fecha_venci_e" class="form-control" >
                        </div>

                        <div class="form-group">
                          <label>Experiencia(años)</label>
                          <input type="number" name="experiencia_e" id="experiencia_e" class="form-control" max="50" step="1" >
                        </div>     

                  <input type="submit" class="btn btn-success">             
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
    <!-- *************Form Edita pilotos******************** -->       
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
<!-- Acciones BD -->
<script src="../../controllers/pm_aspirantes.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- ligthbox -->
<script src="../../dist/js/lightbox.js"></script>


</body>
</html>