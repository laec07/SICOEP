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
/*******************************************************************************************/
$datos_empresa=mysqli_query($conexion,"SELECT * FROM empresa where id_empresa='$em'");
$empresa=mysqli_fetch_array($datos_empresa);
$pais=$_SESSION['usuario']['codigo_pais'];
/*******************************************************************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
/********************************************************************************************************/
$placa=$_GET['placa'];
/**********************************************************************************************************/ 
 $vehi=mysqli_query($conexion,"SELECT
  ID,
  id_equipo,
  foto1,
  fecha
FROM
  foto_vehi
WHERE
  id_equipo = '$placa'
ORDER BY
  fecha");
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
  <!-- Estilo para fotos -->
  <link rel="stylesheet" href="../../bower_components/foto/foto.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
      <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="../../dist/css/skins/skin-red.min.css">
  <link rel="shortcut icon" href="../../dist/img/logo.ico" />
  <link rel="stylesheet"  href="../../dist/css/lightbox.css">

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
<style>

input[type=checkbox] 
{ 
  display: none;
} 
.zoom1 img 
{     
  transition: transform 0.25s ease; 
  cursor: zoom-in;
} 

input[type=checkbox]:checked ~ label > div > img 
{ 
  transform: scale(2); 
  cursor: zoom-out; 
}




</style>

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
         <!-- 
         <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <ul class="treeview-menu">
            <li class="active"><a href="../pages/"><i class="fa fa-circle-o"></i> Dashboard</a></li>
         
          </ul>
          </a>
         </li>
         -->
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
       
        <li class="active"><a href="vehiculo.php"><i class="fa fa-car"></i><span>Vehículos</span></a></li>
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
     <li><a href="asignaciones.php"><i class="fa fa-edit"></i><span>Asignaciones</span></a></li>
        <li><a href="mantenimientos.php"><i class="fa fa-wrench"></i><span>Mantenimientos</span></a></li>
        
        <!--
        <li class="treeview">
          <a href="#">
            <i class="fa fa-line-chart"></i>
            <span>Reportes</span>
             <i class="fa fa-angle-left pull-right"></i>
            <span class="pull-right-container">           
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="reporte_ventas.php"><i class="fa  fa-circle"></i>Ventas</a></li>
            <li><a href="reportes_compras.php"><i class="fa  fa-circle"></i>Compras</a></li>
            <li><a href="envios.php"><i class="fa  fa-circle"></i>Envíos</a></li>
            <li><a href="inventario_r.php"><i class="fa  fa-circle"></i>Inventario</a></li>      
          </ul>
        </li>-->
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
        <li ><a href="mov_diario.php"><i class="fa fa-road"></i><span>Mov diario</span></a></li>
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
       <!-- <li class="header">MENU</li>-->
        <!-- Optionally, you can add icons to the links -->
      <!--  <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
        <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
          </ul>
        </li>-->
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
            <small>VEHICULO</small>
          </h3>
        </div>
         <div class="col-md-1">
          <a href="" class="btn btn-info" data-target='#NuevoVehi' data-toggle='modal' title="Agregar nuevo vehículo"><i class="fa fa-plus"></i> Agregar</a>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content container-fluid">
      <!--------------------------***************************************************************************************************************
        | Your Page Content Here |
        ------------------------------------------------------------------------------------------------------------------------------------->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Fotos vehículo</h3>
          </div>
          <div class="box-body">
            <div id="muestra_fotos"></div>
            
          </div>
        </div>
        

    </section>
    <!-- /.Finaliza content ---------------------------------------------------->

<div class="row">
  
 

    <div class="col-md-6" >
       <div style="overflow:scroll;height: 100%" class="zoom1">
        <input type="checkbox" id="zoomCheck"> 
          <label for="zoomCheck"> 
            <div id="foto1"  ></div>
          </label>
      </div>
    </div>

  <div class="col-md-6" >
    <div style="overflow:scroll;height: 100%" class="zoom1">
      <input type="checkbox" id="zoomCheck1">
      <label for="zoomCheck1">
          <div id="foto2"></div>
      </label>
    </div>
  </div>
</div>
  </div>
  <!-- /.content-wrapper -->
  <!--Inicia ventanas emergentes ------------------------------------->
 <!-- *************Form ingreso fotos******************** -->
        <div class="modal fade" id="NuevoVehi">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo vehículo</h4>
              </div>
              <div class="modal-body">
                <form  action="../../consultas/foto1.php" enctype="multipart/form-data" method="post">
              <input type="text" style="display: none;" name="placa" value="<?php echo $placa; ?>"  >
               <input  type="file" id="files1" name="archivo" class="input-file ng-pristine ng-valid ng-touched" files-model="" ng-model="project.fileList">
              <div div class="upload2" upload-image="" id="imagePreview1">
                <label for="files1">
                  <span class="add-image">
                    Foto </br>1
                  </span>
                  <output id="list" for="imagePreview1"></output>
                </label>
              </div>
              <div>
                <input type="file" id="files2" name="archivo2" class="input-file ng-pristine ng-valid ng-touched" files-model="" ng-model="project.fileList" >
                 <div class="upload" upload-image="" id="imagePreview2">
                  <label for="files2">
                    <span class="add-image">
                      Foto </br>2
                    </span>
                      <output id="list"></output>
                    </label>
              </div>
              <div>
                
                  <input type="file" id="files3" name="archivo3" class="input-file ng-pristine ng-valid ng-touched" files-model="" ng-model="project.fileList" >
                  <div class="upload" upload-image="" id="imagePreview3">
                    <label for="files3">
                    <span class="add-image">
                      Foto </br>3
                    </span>
                    <output id="list"></output>
                    </label>
                  </div>
              </div>
              <div>
                 <input type="file" id="files4" name="archivo4" class="input-file ng-pristine ng-valid ng-touched" files-model="" ng-model="project.fileList">
                 <div class="upload" upload-image="" id="imagePreview4">
                 
                  <label for="files4">
                    <span class="add-image">
                      Foto </br>4
                    </span>
                    <output id="list"></output>
                  </label>
                </div>
                </div>
              </div>
              <div>
                <input type="file" id="files5" name="archivo5" class="input-file ng-pristine ng-valid ng-touched" files-model="" ng-model="project.fileList">
                <div class="upload" upload-image="" id="imagePreview5">
                  
                  <label for="files5">
                  <span class="add-image">
                    Foto </br>5
                  </span>
                  <output id="list"></output>
                  </label>
                </div>
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
  <!-- *************Form ingreso fotos******************** -->
  
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

<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- ligthbox -->
<script src="../../dist/js/lightbox.js"></script>
<script src="../../controllers/foto_vehi.js"></script>


<script >
  (function(){
    function filePreview(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e){
          $('#imagePreview1').html("<img src='"+e.target.result+"'/ class= 'img2'>");
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#files1').change(function(){
      filePreview(this);
    })
  })();

 
 (function(){
    function filePreview2(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e){
          $('#imagePreview2').html("<img src='"+e.target.result+"'/class= 'img2'>");
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#files2').change(function(){
      filePreview2(this);
    })
  })();

  (function(){
    function filePreview3(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e){
          $('#imagePreview3').html("<img src='"+e.target.result+"'/class= 'img2'>");
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#files3').change(function(){
      filePreview3(this);
    })
  })();

  (function(){
    function filePreview4(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e){
          $('#imagePreview4').html("<img src='"+e.target.result+"'/class= 'img2'>");
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#files4').change(function(){
      filePreview4(this);
    })
  })();
  
   (function(){
    function filePreview5(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e){
          $('#imagePreview5').html("<img src='"+e.target.result+"'/class= 'img2'>");
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#files5').change(function(){
      filePreview5(this);
    })
  })();

//////////ejecuta funcion para mostrar fotos ajax
show(<?php echo "'".$placa."'"?>);
///////////////////

 $(document).ready(function(){
    $(".moverImagen").draggable();
 
    $("#cuadro").droppable({
        drop: function (event, ui) {
            ui.draggable.addClass("dropped");
            $(this).append(ui.draggable);
        }
    });
 
 })
 
</script>  
</body>
</html>