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
$Result=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais' and usa_vehi='S'" );
$Result2=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais' and usa_vehi='S'" );
/****************************************************/
$li_usuarios=mysqli_query($conexion, "SELECT * FROM usuario where estado='ACTIVO' and codigo_pais='$pais' and TIPO IN ('Admin_carros','Oper_carros') AND USUARIO NOT IN ('adming', 'admins') ");
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
  <meta content="width=device-width" name="viewport">
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
     <!---Estilo para checkbox-->
  <link rel="stylesheet" type="text/css" href="../../dist/css/checkbox.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="../../dist/css/skins/skin-red.min.css">
  <link rel="shortcut icon" href="../../dist/img/logo.ico" />
  <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Estilo boton editar sobre foto -->
  <link rel="stylesheet"  href="../../dist/css/imagen_hover.css">
  <!-- Estilo para fotos -->
  <link rel="stylesheet" href="../../bower_components/foto/foto.css">
  <link rel="stylesheet"  href="../../dist/css/lightbox.css">
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
            <li ><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard</a></li>            
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
        <!--Configuración -->
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-gears"></i>
            <span>Configuración</span>
             <i class="fa fa-angle-left pull-right"></i>
            <span class="pull-right-container">           
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="usuarios.php"><i class="fa  fa-user-plus"></i>Usuarios</a></li>
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
        <div class="col-md-8">
          <h1>
        <?php echo $empresa['empresa']; ?>
        <small>Usuarios</small>
      </h1>    
        </div>
        <div class="col-md-2">
          <a href="" class="btn btn-info" data-target="#NuevoUsuario" data-toggle='modal' title="Nueva Ruta"><i class="fa fa-plus"></i> Agregar</a>
        </div>
      </div>
      

      
    </section>

    <!-- Main content -->
    <section class="content container-fluid connectedSortable">
     
      
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#general" data-toggle="tab" >General    </a> </li>
    <li><a href="#permisos_panel" data-toggle="tab" > Permisos   </a> </li>

  </ul>
  <div class="tab-content">

    <div class="tab-pane fade in active" id="general">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4>Usuarios</h4>
          </div>
          
          <div class="box-body">
            <div id="general_usuarios"></div>
          </div>
        </div>      
    </div>
    <div class="tab-pane fade" id="permisos_panel"> 
      <div class="box box-primary">
        <div class="box-header">
          
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <label>Usuario</label>
              <select class="form-control" id="lista_usuario" onchange="bpermisos_usuario();">
                <option>Seleccione usuario</option>
            <?php
              while ($f_usuarios=mysqli_fetch_array($li_usuarios)) {
                echo "
                  <option value='".$f_usuarios['USUARIO']."' >".$f_usuarios['USUARIO']." </option>

                ";
              }
            ?>
              </select>
            </div>

          </div>
        </div>
      </div>
      <div class="box">
        <div class="box-header">
          <h4>Permisos usuario App operativo</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div id="permisosApp"></div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>



    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <!-- *************Form ingreso nuevo usuario******************** -->
    <div class="modal" id="NuevoUsuario" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nuevo usuario</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="../../consultas/usuario_guarda.php" method="POST" >    
                         <div class="form-group">
                          <label >NOMBRE:</label>
                          <input type="text" name="nombre" placeholder="nombre" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label >USUARIO:</label>
                          <input type="text" name="usuario" placeholder="usuario" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label>CORREO:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                          <input type="email" class="form-control" placeholder="Email" name="correo">
                          </div>
                        </div>
                        <div class="form-group">
                          <label >CLAVE:</label>
                          <input type="password" name="clave" id="clave"  placeholder="******" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label >CONFIRMAR CLAVE:</label>
                          <input type="password" name="clave2"  id="clave2" placeholder="******" class="form-control" maxlength="200" onkeyup="repite();" required="">
                          <p style="display: none;" class="help-block" id="aviso" style="color: red;">Por favor repita su nueva contraseña</p>
                        </div>
                        <div class="form-group">
                          <label >TIPO:</label>
                          <SELECT  name="tipo" id="tipo"  class="form-control" onchange="tipo_f();" >
                            <option value="Admin_carros">ADMINISTRADOR</option>
                            <option value="Oper_carros">OPERATIVO</option>
                          </SELECT>
                        </div>
                        <div class="form-group" id="estatus" style="display: none;">
                            <label for="sede">Seleccione Sede:</label>
                            <SELECT  name="sede" class="form-control" >
                            <?php 
                              while($fila=mysqli_fetch_row($Result)){
                                  echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                              }
                            ?>
                            </SELECT>
                        </div>
                        <div class="form-group" id="alerta1">
                          <label>Alerta combustible</label>
                          <select name="alerta_com" class="form-control">
                            <option value="S">SI</option>
                            <option value="N">NO</option>
                          </select>
                        </div>
                        <div class="form-group" id="alerta2">
                          <label>Alerta Mantenimiento</label>
                          <select name="alerta_man" class="form-control">
                            <option value="S">SI</option>
                            <option value="N">NO</option>
                          </select>
                        </div>                       
                         <div class="form-group">
                            <label for="estado">ESTADO:</label>
                            <SELECT  name="estado" class="form-control" id="estado"  >
                              <option>ACTIVO</option>
                              <option>INACTIVO</option>
                            </SELECT>
                          </div>
                                  <input class="btn btn-primary pull-right" type="Submit" name="guardar" value="Guardar" id="boton" >
                </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso nuevo usuario******************** -->
  <!-- *************Form Editar usuario******************** -->
    <div class="modal" id="EditarUsuario" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>EDITAR USUARIO</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="../../consultas/usuario_edita.php" method="POST" >    
                         <div class="form-group">
                          <label >NOMBRE:</label>
                          <input type="text" id="nombre_e" name="nombre_e" placeholder="nombre" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label >USUARIO:</label>
                          <input type="text" id="usuario_e" name="usuario_e" placeholder="usuario" class="form-control" maxlength="200" readonly="">
                        </div>
                        <div class="form-group">
                          <label>CORREO:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                          <input type="email" class="form-control" placeholder="Email" name="correo_e" id="correo_e">
                          </div>
                        </div>
                        <div class="form-group">
                          <label >CLAVE:</label>
                          <input type="password" name="clave_e" id="clave_e" onkeyup="repite_e2();" placeholder="******" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label >CONFIRMAR CLAVE:</label>
                          <input type="password" name="clave2_e"  id="clave2_e" placeholder="******" class="form-control" maxlength="200" onkeyup="repite_e();" required="">
                          <p style="display: none;" class="help-block" id="aviso_e" style="color: red;">Por favor repita su nueva contraseña</p>
                        </div>
                        <div class="form-group">
                          <label >TIPO:</label>
                          <SELECT  name="tipo_e" id="tipo_e"  class="form-control" onchange="tipo_fe();" >
                            <option value="Admin_carros">ADMINISTRADOR</option>
                            <option value="Oper_carros">OPERATIVO</option>
                          </SELECT>
                        </div>
                        <div class="form-group" id="estatus_e" style="display: none;">
                            <label for="sede">SEDE:</label>
                            <SELECT  name="sede_e" id='sede_e' class="form-control" >
                            <?php 
                              while($fila=mysqli_fetch_row($Result2)){
                                  echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                              }
                            ?>
                            </SELECT>
                        </div>
                        <div class="form-group" id="alerta1_e">
                          <label>Alerta combustible</label>
                          <select name="alerta_com_e" id="alerta_com_e" class="form-control">
                            <option value="S">SI</option>
                            <option value="N">NO</option>
                          </select>
                        </div>
                        <div class="form-group" id="alerta2_e">
                          <label>Alerta Mantenimiento</label>
                          <select name="alerta_man_e" id="alerta_man_e" class="form-control">
                            <option value="S">SI</option>
                            <option value="N">NO</option>
                          </select>
                        </div>                       
                         <div class="form-group">
                            <label for="estado">ESTADO:</label>
                            <SELECT  name="estado_e" id='estado_e' class="form-control" id="estado"  >
                              <option>ACTIVO</option>
                              <option>INACTIVO</option>
                            </SELECT>
                          </div>
                                  <input class="btn btn-primary pull-right" type="Submit" name="guardar" value="Guardar" id="boton_e" >
                </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************/. Form Editar usuario******************** -->
    <!-- *************Form Editar permisos******************** -->
    <div class="modal" id="EditaPermisos" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>EDITAR PERMISOS USUARIO</h4>                       
                    </div>
                    <div class="modal-body">
                       <div id="show_permission_">Hola</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************/. Form Editar usuario******************** -->
  <!-- *************Form ingreso fotos******************** -->
        <div class="modal fade" id="editPick">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar foto</h4>
              </div>
              <div class="modal-body">
                <form >
                 
              <input type="text"  name="usuario_f" id="usuario_f" style="display: none;" >
               <input  type="file" id="imagen" name="imagen" class="input-file ng-pristine ng-valid ng-touched" files-model="" ng-model="project.fileList">
              <div  class="upload2" upload-image="" id="imagePreview1">
                <label for="imagen">
                  <span class="add-image">
                    Foto </br>1
                  </span>
                  <output id="list" for="imagePreview1"></output>
                </label>
              </div>
              <button onclick="fotoUsuario_guarda();" type="reset" class="btn btn-primary btn-block" data-dismiss="modal">Guardar</button>
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
  <!-- *************./Form ingreso fotos******************** --> 
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
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../controllers/usuarios.js"></script>
<!-- ligthbox -->
<script src="../../dist/js/lightbox.js"></script>
<script>
  lista_usuarios()

  function repite(){
    var nueva = document.getElementById('clave').value
    var confirm=document.getElementById('clave2').value
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

  function tipo_f(){
    var lista = document.getElementById('tipo')
    var opcion = lista.options[lista.selectedIndex].value;
    var opcion = lista.options[lista.selectedIndex].text;

    if (opcion == 'OPERATIVO') {
      document.getElementById('estatus').style.display='block';
      document.getElementById('alerta1').style.display='none';
    }else{
      document.getElementById('estatus').style.display='none';
      document.getElementById('alerta1').style.display='block';
    }
  }

  /////////////////////////////editar//////////////////////
  function repite_e(){
    var nueva = document.getElementById('clave_e').value
    var confirm=document.getElementById('clave2_e').value
    if (confirm==nueva) {
      document.getElementById('aviso_e').style.display='none'
      document.getElementById('aviso_e').style.color='red'
      document.getElementById('boton_e').disabled = false; 
    }else{
      document.getElementById('aviso_e').style.display='block'
      document.getElementById('aviso_e').style.color='red'
      document.getElementById('boton_e').disabled = true;
    }
  }

  function repite_e2(){
    var nueva = document.getElementById('clave_e').value
    var confirm=document.getElementById('clave2_e').value
    if (confirm==nueva) {
      document.getElementById('aviso_e').style.display='none'
      document.getElementById('aviso_e').style.color='red'
      document.getElementById('boton_e').disabled = false; 
    }else{
      document.getElementById('aviso_e').style.display='block'
      document.getElementById('aviso_e').style.color='red'
      document.getElementById('boton_e').disabled = true;
    }
  }

  function tipo_fe(){
    var lista = document.getElementById('tipo_e')
    var opcion = lista.options[lista.selectedIndex].value;
    var opcion = lista.options[lista.selectedIndex].text;

    if (opcion == 'OPERATIVO') {
      document.getElementById('estatus_e').style.display='block';
      document.getElementById('alerta1_e').style.display='none';
    }else{
      document.getElementById('estatus_e').style.display='none';
      document.getElementById('alerta1_e').style.display='block';
    }
  }

$('#EditarUsuario').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato0 = button.data('usuario_e')
      var dato1 = button.data('nombre_e')
      var dato2 = button.data('clave_e')
      var dato3 = button.data('clave_e')
      var dato4 = button.data('tipo_e')
      var dato5 = button.data('depto_e')
      var dato6 = button.data('estado_e')
      var dato7 = button.data('alerta_man')
      var dato8 = button.data('alerta_com')
      var dato9 = button.data('correo')

      if (dato4 == 'Oper_carros') {
      document.getElementById('estatus_e').style.display='block';
      document.getElementById('alerta1_e').style.display='none';
    }else{
      document.getElementById('estatus_e').style.display='none';
      document.getElementById('alerta1_e').style.display='block';
    }

      var modal = $(this)
      modal.find('.modal-body #usuario_e').val(dato0)
      modal.find('.modal-body #nombre_e').val(dato1)
      modal.find('.modal-body #clave_e').val(dato2)
      modal.find('.modal-body #clave2_e').val(dato3)
      modal.find('.modal-body #tipo_e').val(dato4)
      modal.find('.modal-body #sede_e').val(dato5)
      modal.find('.modal-body #estado_e').val(dato6)
      modal.find('.modal-body #alerta_man_e').val(dato7)
      modal.find('.modal-body #alerta_com_e').val(dato8)
      modal.find('.modal-body #correo_e').val(dato9)
    });
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  });

$('#EditaPermisos').on('show.bs.modal', function(event){

    var button = $(event.relatedTarget)
    var usuario = button.data('usuario')

    show_permission(usuario);
})
$('#editPick').on('hidden.bs.modal', function(){ 

    $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
    $('#imagePreview1').html("<label for='imagen'><span class='add-image'>Foto </br>1</span><output id='list' for='imagePreview1'></output></label>");
  });
//trae datos para editar usuario
 $('#editPick').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('usuario')


      var modal = $(this)    
      modal.find('.modal-body #usuario_f').val(recipient0)

    });
//Visualizar imagen previa
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
    $('#imagen').change(function(){
      filePreview(this);
    })
  })();
</script>
</body>
</html>