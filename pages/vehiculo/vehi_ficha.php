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
/********************************************************************************************************/
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/***********************************************************************************************************//*Datos para la foto*/
$f_vehi=mysqli_query($conexion,"SELECT 
  v.id_equipo,
v.Marca,
v.Modelo,
  v.codigo_pais,
  f.foto1,
  f.fecha,
  v.Estado_equipo,
  v.Kilometraje
FROM
  vehiculo v
LEFT JOIN foto_vehi f ON f.id_equipo = v.Id_equipo
WHERE
  v.codigo_pais = '$pais'
AND 
  v.id_equipo='$placa'
GROUP BY
  v.Id_equipo");
$foto_vehi=mysqli_fetch_array($f_vehi);
if (empty($foto_vehi['foto1'])) {
                    $foto_vehi['foto1']='files/vacio.jpg';
                  }
/********************************************************************************************************/
$c_a=mysqli_query($conexion,"SELECT count(*) as cant_asig from asignacion_vehiculo where Id_equipo='$placa'");
$cant_asig=mysqli_fetch_array($c_a);
/********************************************************************************************************/
$t_m=mysqli_query($conexion,"SELECT SUM(costo) as total_mante FROM mantenimiento_vehiculo where Id_equipo='$placa'");
$total_mante=mysqli_fetch_array($t_m);
/********************************************************************************************************/
$d_a=mysqli_query($conexion,"SELECT p.Usuario,d.Depto from asignacion_vehiculo v, usuarios p,depto d where Id_equipo='$placa' AND Estado_asig ='ACTIVO' AND v.Id_usuario=p.Id_usuario and v.Id_depto=d.Id_depto");
$datos_asig=mysqli_fetch_array($d_a);
if ($datos_asig['Depto']=="") {
  $datos_asig['Depto']="SIN_DEPTO";
  $datos_asig['Usuario']="SIN_PILOTO";
}
/********************************************************************************************************/
$query=mysqli_query($conexion,
  " 
SELECT
  mv.ID,
  mv.Id_equipo,
  v.Equipo,
  v.Modelo,
  v.Marca,
  mv.Fecha,
  t.tipo_mantenimiento,
  mv.Observaciones,
  mv.Kilometrajem,
  mv.serie_fact,
  mv.no_fact,
  mv.costo,
  mv.codigo_pais,
  p.proveedor,
  mv.canal,
  a.Id_depto,
  d.Depto,
  mv.id_tipomantenimiento,
  mv.id_proveedor,
  mv.costo_unitario
FROM
  mantenimiento_vehiculo mv
INNER JOIN vehiculo v ON v.Id_equipo = mv.Id_equipo
LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
AND a.Estado_asig = 'ACTIVO'
LEFT JOIN depto d ON d.Id_depto = a.Id_depto
LEFT JOIN proveedor p ON p.id_proveedor = mv.id_proveedor
LEFT JOIN tipo_mantenimiento t ON t.id_tipomantenimiento=mv.id_tipomantenimiento
WHERE
mv.id_equipo='$placa'
  ");

$asignaciones=mysqli_query($conexion,"
SELECT
  a.Id_Asignacion,
  a.Id_equipo,
  a.Fecha,
  d.Depto,
  a.canal,
  u.Usuario,
  a.fecha_accesorios,
  a.fecha_fotos,
  a.llanta_der_delantera,
  a.llanta_der_trasera,
  a.llanta_iz_delantera,
  a.llanta_iz_trasera,
  a.Observaciones,
  a.kilometraje,
  a.Estado_asig,
  a.fecha_baja
FROM
  asignacion_vehiculo a, depto d,usuarios u
WHERE
  Id_equipo = '$placa'
AND d.Id_depto=a.Id_depto AND a.Id_usuario=u.Id_usuario ORDER BY Fecha DESC

  ");
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
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!---Estilo para checkbox-->
  <link rel="stylesheet" type="text/css" href="../../dist/css/checkbox.css">
  
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
  <style type="text/css">
    @media print{
  .oculto-impresion, .oculto-impresion *{
    display: none !important;

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
         <!-- 

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
      <div class="row">
        <div class="col-md-8">
          <h3>
            <?php echo $empresa['empresa']; ?>
            <small>FICHA VEHICULO</small>
          </h3>
        </div>
        <div class="col-md-2">
            
            
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
            <h3 class="box-title">Ficha Vehículo</h3>
          </div>
          <div class="box-body">
            
              <div class="row">
                <div class="col-md-3" >
                  <img  style="width: 200px;" src="../../consultas/<?php echo $foto_vehi['foto1'] ?>"  class='img'  />
                </div>
                <div class="col-md-3">
                  <table style="width: 100%;">
                    <tr>
                      <th>Placas:</th>
                      <td><?php echo $foto_vehi['id_equipo']; ?></td>
                    </tr>
                    <tr>
                      <th>Modelo:</th>
                      <td><?php echo $foto_vehi['Marca']; ?></td>
                    </tr>
                    <tr>
                      <th>Año:</th>
                      <td><?php echo $foto_vehi['Modelo']; ?></td>
                    </tr>
                    <tr>
                      <th>Kilometraje:</th>
                      <td><?php echo $foto_vehi['Kilometraje']; ?></td>
                    </tr>
                    <tr>
                      <th>Estatus:</th>
                      <td><?php echo $foto_vehi['Estado_equipo']; ?></td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-3">
                  <table style="width: 100%;">
                    <tr>
                      <th>Asignaciones:</th>
                      <td><?php echo $cant_asig['cant_asig']; ?></td>
                    </tr>
                    <tr>
                      <th>Costo mant.:</th>
                      <td><?php echo $rps['moneda'].$total_mante['total_mante']; ?></td>
                    </tr>
                    <tr>
                      <th>Piloto actual:</th>
                      <td><?php echo $datos_asig['Usuario']; ?></td>
                    </tr>
                    <tr>
                      <th>Depto. Actual:</th>
                      <td><?php echo $datos_asig['Depto']; ?></td>
                    </tr>
                  
                  </table>
                </div>
              </div>
            </div>
          </div>
<!-- Historial Asignaciones ---------------------------------------------------->
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title">Historial Asignaciones</h3>
      
      <div class="box-tools pull-right">
        <?php
            echo"
            <a href='vehiculo_asig_excel.php?placa=$placa' class='btn btn-success oculto-impresion'><i class='fa fa-file-excel-o'></i></a>
            ";
            ?>
        <button type="button" class="btn btn-box-tool oculto-impresion" data-widget="collapse" ><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Depto</th>
                    <th>Canal</th>
                    <th>Usuario</th>
                    <th>F.accesorios</th>
                    <th>F.fotos</th>
                    <th >IZ. D.</th>
                    <th >DER. D.</th>
                    <th >IZ. T.</th>
                    <th >DER. T.</th>
                    <th>Obs.</th>
                    <th>Kilometraje</th>
                    <th>Estado Asig.</th>
                    <th>Fecha baja</th>
                    <th class='oculto-impresion'></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while ($fila=mysqli_fetch_array($asignaciones)) {
                      echo "
                        <tr>
                          <td>".$fila['Fecha']."</td>
                          <td>".$fila['Depto']."</td>
                          <td>".$fila['canal']."</td>
                          <td>".$fila['Usuario']."</td>
                          <td>".$fila['fecha_accesorios']."</td>
                          <td>".$fila['fecha_fotos']."</td>
                          <td>".$fila['llanta_iz_delantera']."%</td>
                          <td>".$fila['llanta_der_delantera']."%</td>
                          <td>".$fila['llanta_iz_trasera']."%</td>
                          <td>".$fila['llanta_der_trasera']."%</td>
                          <td>".$fila['Observaciones']."</td>
                          <td>".$fila['kilometraje']."</td>
                          <td>".$fila['Estado_asig']."</td>
                          <td>".$fila['fecha_baja']."</td>
                          <td class='oculto-impresion'><a class='btn btn-warning' target=_blank href= 'pdf_hojavehi.php?ID=".$fila['Id_Asignacion']."&placa=".$fila['Id_equipo']."'><span class='glyphicon glyphicon-print'  ></span></a></td>
                        </tr>


                      ";
                    }
                  ?>
                </tbody>

          </table>
    </div>
  </div>  
<!-- /.Historial Asignaciones ---------------------------------------------------->
 <!-- Historial mantenimiento ---------------------------------------------------->
  <div class="box box-warning">
    <div class="box-header">
      <h3 class="box-title">Historial Mantenimientos</h3>
      <div class="box-tools pull-right">
        <?php
            echo"
            <a href='mantenimientos_excel_b.php?inicio=Todos&fin=Todos&idequip=$placa&tipo=Todos' class='btn btn-success oculto-impresion '><i class='fa fa-file-excel-o'></i></a>
            ";
            ?>
        <button type="button" class="btn btn-box-tool oculto-impresion" data-widget="collapse" ><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>               
                  <th>Fecha</th>
                  <th>Datos Vehi.</th>
                  <th>Datos Asignación</th>
                  <th>Tipo mantenimiento</th>
                  <th>Obs. Mantenimiento</th>
                  <th>Proveedor</th>
                  <th>Serie Fact.</th>
                  <th>No. Fact.</th>
                 <th>Costo</th>
                  
                </tr>   
                </thead>
                <tbody>
                <?php
               
                  while ($fila=mysqli_fetch_array($query)) {
                    echo"
                    <tr>
                      <td>".date_format(new Datetime($fila['Fecha']),'Y/m/d' )."</td>
                      <td>".$fila['Id_equipo']."<br>".$fila['Equipo']."<br>".$fila['Marca']."<br>".$fila['Kilometrajem']."</td>
                      <td>".$fila['canal']."<br>".$fila['Depto']."</td>
                      <td>".$fila['tipo_mantenimiento']."</td>
                      <td>".$fila['Observaciones']."</td>
                      <td>".$fila['proveedor']."</td>
                      <td>".$fila['serie_fact']."</td>
                      <td>".$fila['no_fact']."</td>
                      <td>".$fila['costo']."</td>
                    </tr>

                    ";
                  
                  }
                  
                ?>
                </tbody>

          </table>
    </div>
  </div>  
<!-- /.Historial mantenimiento ---------------------------------------------------->         
       
        

    </section>
    <!-- /.Finaliza content ---------------------------------------------------->
  </div>
  <!-- /.content-wrapper -->
  <!--Inicia ventanas emergentes ------------------------------------->
 
  
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
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


</body>
</html>