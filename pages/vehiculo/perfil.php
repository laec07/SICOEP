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
$datos_empresa=mysqli_query($conexion,"SELECT * FROM empresa where id_empresa='$em'");
$empresa=mysqli_fetch_array($datos_empresa);
$usuario=$_SESSION['usuario']['USUARIO'];
$dat_usuario=mysqli_query($conexion,"SELECT * FROM usuario WHERE USUARIO='$usuario'");
$datos_usuario=mysqli_fetch_array($dat_usuario);
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
  <title>SIPOV</title>
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
      <span class="logo-mini"><b>S</b>POV</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Punto</b>VENTA</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
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
              <li class="user-footer">
                <div class="pull-left">
                  <a href="perfil.php" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="../../layout.php" class="btn btn-default btn-flat">Salir</a>
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
       
        <li><a href="vehiculo.php"><i class="fa fa-car"></i><span>Vehículos</span></a></li>
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
        <small>Perfil</small>
      </h1>
     

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
          <div class="box">
            <div class="box-header">
              <h3 class="box title" >Usuario: <?php echo $_SESSION['usuario']['USUARIO']?> </h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div>
                    <img src="<?php echo $foto?>" class="img-circle" >
                  </div>
                </div>
                <div class="col-md-9">
                  <h3>Datos del usuario:</h3>
                  <hr/>
                  <table style="width: 50%;">
                    <tbody>
                      <tr>
                        <td><b>Nombre:<b></td>
                        <td><?php echo $datos_usuario['NOMBRE'] ?></td>
                        <td><a data-target="#CambiaNombre" data-toggle='modal'> Cambiar</a></td>
                      </tr>
                      <tr>
                        <td><b>Clave:<b></td>
                          <td>**********</td>
                          <td><a data-target="#CambiaClave" data-toggle='modal'> Cambiar</a></td>
                      </tr>
                    </tbody>
                  </table>
                  
                </div>
              </div>
            </div>
          </div>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!--- Inicio ventanas modales-->
<!-- *************Editar nombre******************** -->
    <div class="modal" id="CambiaNombre" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Actualizar perfil</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="../../consultas/perfil_edita_nombre.php" method="POST">
                          <div class="from-goup">
                            <label>Nuevo nombre:</label>
                            <input type="text" name="nombre" autocomplete="of" minlength="3" maxlength="50" required="" value="<?php echo $datos_usuario['NOMBRE'] ?>" class="form-control" >
                          </div>
                              <br/>
                                  <input class="btn btn-success pull-right" type="Submit" name="guardar" value="Actualizar" >
                                  <br/>
                          </FORM>
                    </div>
                </div>
            </div>
        </div>
<!-- *************Editar nombre******************** -->
<!-- *************Editar clave******************** -->
    <div class="modal" id="CambiaClave" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Actualizar clave</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="../../consultas/perfil_edita_clave.php" method="POST">
                          <div class="from-goup">
                            <label>Clave actual:</label>
                            <input type="text" name="c_actual" autocomplete="of" minlength="3" maxlength="50" required=""  class="form-control" >
                          </div>
                          <div class="from-goup">
                            <label>Nueva clave:</label>
                            <input type="password" name="c_nueva" id="c_nueva" autocomplete="of" minlength="3" maxlength="50" required=""  class="form-control" >
                          </div>
                          <div class="from-goup">
                            <label>Confirmar nueva clave:</label>
                            <input type="password" name="c_confirm" id="c_confirm" autocomplete="of" minlength="3" maxlength="50" required=""  class="form-control" onkeyup="repite();" >
                            <p style="display: none;" class="help-block" id="aviso" style="color: red;">Por favor repita su nueva contraseña</p>
                          </div>
                              <br/>
                                  <input class="btn btn-success pull-right" type="Submit" name="guardar" value="Actualizar" id="boton" >
                                  <br/>
                          </FORM>
                    </div>
                </div>
            </div>
        </div>
<!-- *************Editar clave******************** -->  
  <!--/Fin ventanas modales -->
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      V 2.1
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
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
<script>
  function repite(){
    var nueva = document.getElementById('c_nueva').value
    var confirm=document.getElementById('c_confirm').value
    if (confirm==nueva) {
      document.getElementById('aviso').style.display='none'
      document.getElementById('aviso').style.color='red'
      document.getElementById('boton').disabled = false; 
    }else{
      document.getElementById('aviso').style.display='block'
      document.getElementById('aviso').style.color='red'
      document.getElementById('boton').disabled = true;
    }
  }

</script>
</body>
</html>