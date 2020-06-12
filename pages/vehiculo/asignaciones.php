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
$sede=$_SESSION['usuario']['Id_depto'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/*******************************************************************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
/**********************************************************************************************************/ 
$sedes=mysqli_query($conexion, 
  "SELECT
  d.Id_depto,
  d.Depto,
  COUNT(a.Id_Asignacion) as total
FROM
  depto d,
  asignacion_vehiculo a
WHERE
a.Id_depto = d.Id_depto
AND d.Tipo = 'SEDE'
AND d.codigo_pais = '$pais'
AND a.Estado_asig='ACTIVO'
GROUP BY d.Id_depto,d.Depto
  ");
/******************************************************************************************************/
$Result=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais'" );
$Resultequip=mysqli_query($conexion, "SELECT * FROM vehiculo WHERE Estado_equipo = 'ACTIVO' and codigo_pais='$pais' ");
$Resultusua=mysqli_query($conexion, "SELECT Id_usuario,Usuario FROM usuarios where codigo_pais='$pais' and tipo_usu='Piloto' AND estado ='ACTIVO'" );
$canal=mysqli_query($conexion,"SELECT * FROM canal");

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

    <!-- Select2 -->
  <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">

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
            <li><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard</a></li>            
          </ul>
        </li>
        <!--Vehículos -->       
        <li><a href="vehiculo.php"><i class="fa fa-car"></i><span>Vehículos</span></a></li>
        <!--Pilotos -->
        <li><a href="pilotos.php"><i class="fa fa-user"></i><span>Pilotos</span></a></li>
        <!--Asignaciones -->
        <li class="active"><a href="asignaciones.php"><i class="fa fa-edit"></i><span>Asignaciones</span></a></li>
        <!--Mantenimientos -->
        <li><a href="mantenimientos.php"><i class="fa fa-wrench"></i><span>Mantenimientos</span></a></li>
        <!--Combustible -->
        <li class=" treeview">
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
            <small>Asignaciones</small>
          </h3>
        </div>
         <div class="col-md-2">
          <a href="" class="btn btn-info" data-target="#nuevaAsig" data-toggle='modal' title="Nueva Asignacion"><i class="fa fa-plus"></i> Nuevo</a>
          <a class="btn btn-warning"   target=_blank href='pdf_vehi_masivo.php' title="Imprimir asignaciones"><span class="glyphicon glyphicon-print"></span></a>
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
            <h3 class="box-title"><b>Asignaciones activas</b></h3>
          </div>
          <div class="box-body" >
            
              <?php
              while ($fila = mysqli_fetch_array ($sedes)) {//Saca datos de las sedes y los muestra
                echo "
              <div class='box box-default collapsed-box'>
                <div class='box-header with-border'><!--empieza encabezado-->
                  <h3 class='box-title'>".$fila['Depto']."<small> ".$fila['total']." Asignaciones activas</small></h3> 
                  <div class='box-tools pull-right'>
                    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-plus'></i>
                    </button>
                  </div>
                </div><!--Termina encabezado--->
                <div class='box-body'>
                <div style='overflow: scroll; width: 100%'>
                <table class ='table table-hover'>
                  <thead>
                    <tr>
                      <th>Vehículo</th>
                      <th>Piloto</th>
                      <th>Canal</th>
                      <th></th>
                    <tr>
                  </thead>
                ";
                //query que extrae los datos de las asignaciones activas
                $vehi=mysqli_query($conexion, "SELECT a.Id_Asignacion,a.Id_depto,a.Id_equipo,v.Marca,v.Modelo,v.Equipo,a.Id_usuario,s.Usuario,a.canal,d.Depto,a.Id_Asignacion,a.Estado_asig,a.ruta
                    FROM asignacion_vehiculo a
                    LEFT JOIN usuarios s ON a.Id_usuario=s.Id_usuario
                    LEFT JOIN vehiculo v ON v.Id_equipo=a.Id_equipo
                    LEFT JOIN depto d ON d.Id_depto=a.Id_depto
                    WHERE a.Id_depto = ".$fila['Id_depto']." and a.Estado_asig='ACTIVO'
                    ORDER BY canal");
                    while($fila = mysqli_fetch_array ($vehi)){ //subquery, saca datos segun la sede obtenida 
                    if ($fila['ruta']=='N') {
                      $mostrar='';
                    }else{
                      $mostrar="style='display: none;'";
                    }
                    echo"
                        <tr >
                        <td >".$fila['Id_equipo']."</br>".$fila['Marca']."</td>
                        <td >".$fila['Usuario']."</td>
                        <td >".$fila['canal']."</td>
                        <td style='display:none;'>".$fila['Id_usuario']."</td>
                        <td> 
                          <a  
                            class='btn btn-warning' 
                            target=_blank 
                            href= 'pdf_hojavehi.php?placa=".$fila['Id_equipo']."&ID=".$fila['Id_Asignacion']."'>
                            <span class='glyphicon glyphicon-print'></span>
                          </a>
                          <a onclick=\"elimina_asig(".$fila ['Id_Asignacion'].",'".$fila ['Id_equipo']."',".$fila['Id_usuario'].",'".$fila['Depto']."' )\"
                            class='btn btn-danger' 
                        >
                              <span class='glyphicon glyphicon-remove' ></span>
                          </a>
                          <a class='btn btn-info' title='Agregar como ruta' data-target='#AddRuta' data-toggle='modal'
                            data-placa='".$fila['Id_equipo']."'
                            data-piloto='".$fila['Usuario']."'
                            data-canal='".$fila['canal']."'
                            data-depto='".$fila['Id_depto']."'
                            data-tipo='".$fila['Equipo']."'
                            data-sede='".$fila['Depto']."'
                            data-asig='".$fila['Id_Asignacion']."'
                          $mostrar>
                          <span class='glyphicon glyphicon-road'></span>
                          </a>
                        </td>
                        </tr>
                        ";
                      }
                echo"
               </table>
               </div>
              </div>
               ";
              }
              ?>
            
          </div><!--Termina box body-->
        </div>
        

    </section>
    <!-- /.Finaliza content ---------------------------------------------------->
  </div>
  <!-- /.content-wrapper -->
  <!--Inicia ventanas emergentes ------------------------------------->
 <!-- *************Form ingreso Asignacion******************** -->
      
    <div class="modal" id="nuevaAsig" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nueva asignación</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="../../consultas/asignacion_vehi_guarda.php" method="POST">
                              <div class="form-group">
                                <label for="depto">Seleccione Sede:</label>
                                <SELECT  name="depto" class="form-control" >

                                  <?php 
                                      while($fila=mysqli_fetch_row($Result)){
                                          echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                                      }
                                  ?>
                                </SELECT>
                              </div>
                              <div class="form-group">
                                <label for="canal">Seleccione Canal:</label>
                                <SELECT  name="canal" class="form-control" id="canal" onchange="vendido();" >
                                  <?php
                                    while ($fila_canal=mysqli_fetch_array($canal)) {
                                      echo "
                                        <option value=".$fila_canal['canal'].">".$fila_canal['canal']."</option>
                                      ";
                                    }
                                  ?>
                                </SELECT>
                              </div>
                              <div class="row" id="venta" style="display: none;">
                                <div class="col-md-4">
                                  <label for="p_venta">Precio venta:</label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                    <input type="number" step="0.01" name="p_venta" id="p_venta"  class="form-control">
                                  </div>
                                </div>
                            </div>
                              <div class="form-group">
                                <label for="equip">Seleccione Placa:</label>
                                <SELECT name="equip" id="equip" class="form-control "  onchange="cargafotosf(this.value);" >
                                  <option>Seleccione vehiculo...</option>
                                  <?php 
                                      while($fila2=mysqli_fetch_row($Resultequip)){
                                          echo "<option value='".$fila2['0']."'>".$fila2['0']."</option>";
                                      }
                                  ?>
                                </SELECT>
                              </div>
                              <div class="form-group">
                                <label for="usua">Piloto</label>
                                <SELECT  name="usua" id='usua' class="form-control" style="width: 100%;">
                                  <option value="64">Seleccione piloto... </option>
                                  <?php 
                                      while($fila3=mysqli_fetch_row($Resultusua)){
                                          echo "<option value='".$fila3['0']."'>".$fila3['1']."</option>";
                                      }
                                  ?>
                                </SELECT>
                              </div>
                              <div class="form-group">
                                <label for="fecha">Fecha asignación:</label>
                                <input  type="Date" name="fecha" value="<?php echo date('Y-m-d') ?>" class="form-control" >
                              </div>
                              <div class="form-group" name="facc" id="facc">
                                <label for="fecha" >Fecha revisión accesorios:</label>
                                <select    class="form-control" name="faccs" id="faccs" ></select>
                              </div>
                              <div class="form-group">
                                <label for="fecha" >Fecha fotos:</label>
                                <select  name="fotosf" id="fotosf"  class="form-control" ></select>
                                <div id="respuesta"></div>
                              </div>
                             
                                  <input class="btn btn-primary pull-right" type="Submit" name="guardar" value="Guardar" >
                                  
                                  <br/>
                                  <br/>

                          </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso asignación******************** -->
 <!-- *************Form agregar nueva ruta******************** -->
    <div class="modal" id="AddRuta" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Agregar como ruta</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="../../consultas/rutas_guardaasig.php" method="POST" >

                        <div class="form-group">
                          <label >Ruta:</label>
                          <input type="text" name="ruta" id="ruta" required="" placeholder="Descripción de ruta" class="form-control" maxlength="100">
                        </div>

                         <div class="form-group">
                          <label >Piloto:</label>
                          <input type="text" name="piloto" id="piloto" readonly="" placeholder="Piloto" class="form-control" maxlength="200">
                        </div>

                        <div class="form-group">
                          <label >Tipo vehi:</label>
                          <input type="text" name="tipo" id="tipo"  readonly="" class="form-control"  >
                        </div>

                        <div class="form-group">
                          <label >Placa:</label>
                          <input type="text" name="placa" id="placa" readonly="" placeholder="P-000XXX" class="form-control" maxlength="11">
                        </div>
                        
                         <div class="form-group">
                                <label for="canal">Canal</label>
                                <input type="text" name="canal" id="canal" readonly="" class="form-control" id="canal"  >
                          </div>

                          <div class="form-group">
                                <label for="depto">Sede</label>
                                <input type="text"  name="sede" readonly="" id="sede"class="form-control" >
                                <input type="text" style="display: none;" name="depto" id="depto"class="form-control" >
                                <input type="text" style="display: none;" name="asig" id="asig"class="form-control" >
                          </div>
                                  <button type="submit" name="guardar" class="btn btn-success">Guardar</button>
                </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form agregar nueva ruta******************** -->
    
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
<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Controles de pagina -->
<script src="../../controllers/asignaciones.js"></script>


<script >


    $(function(){
    $('.select2').select2()
  });

///////////////////////////////
 function nuevoAjax(){ 
    /* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
    lo que se puede copiar tal como esta aqui */
    var xmlhttp=false;
    try{
        // Creacion del objeto AJAX para navegadores no IE
        xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e){
        try{
            // Creacion del objet AJAX para IE
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(E){
            if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
        }
    }
    return xmlhttp; 
}
 //carga fechas de fotos y accesorios para incluirlas en la asignación del vehiculo
function cargafechas(idSelectOrigen){
    // Obtengo el select que el usuario modifico
    var selectOrigen=document.getElementById(idSelectOrigen);
    // Obtengo la opcion que el usuario selecciono
    var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
    // Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona estado..."
    if(opcionSeleccionada==0)
    {
        var selectActual=null;
        if(idSelectOrigen == "equip")
            selectActual=document.getElementById("facc");
        selectActual.length=0;
        var nuevaOpcion=document.createElement("option"); 
        nuevaOpcion.value=0; 
        nuevaOpcion.innerHTML="Seleccione placa";
        selectActual.appendChild(nuevaOpcion);  
        selectActual.disabled=true;

    }
    // Compruebo que el select modificado no sea el ultimo de la cadena
    else{
        if(idSelectOrigen == "equip")
            var selectDestino=document.getElementById("facc");
       
        // Creo el nuevo objeto AJAX y envio al servidor la opcion seleccionada del select origen
        var ajax=nuevoAjax();
        ajax.open("GET", "../../consultas/asignacion_fechasacc.php?opcion="+opcionSeleccionada+"&select="+idSelectOrigen, true);
        ajax.onreadystatechange=function() 
        { 
            if (ajax.readyState==1)
            {
                // Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
                selectDestino.length=0;
                var nuevaOpcion=document.createElement("option"); 
                nuevaOpcion.value=0; 
                nuevaOpcion.innerHTML="Cargando...";
                selectDestino.appendChild(nuevaOpcion); 
                selectDestino.disabled=true;

                  
            }
            if (ajax.readyState==4)
            {
                selectDestino.parentNode.innerHTML=ajax.responseText;

                
            } 
        }
        ajax.send(null);
    }


}
///////////////////////////////////////////////////
function cargafotosf(val)
{
    $('#respuesta').html("Cargando...");    
    $.ajax({
        type: "POST",
        url: '../../consultas/asignacion_fechasfotos.php',
        data: 'placa='+val,
        success: function(resp){
            $('#fotosf').html(resp);
            $('#respuesta').html("");
        }
    });

    $.ajax({
        type: "POST",
        url: '../../consultas/asignacion_fechasacc.php',
        data: 'placa='+val,
        success: function(resp){
            $('#faccs').html(resp);
            $('#respuesta').html("");
        }
    });
}
function vendido(){
  var valor = document.getElementById("canal");
  var valorseleccionado = valor.options[valor.selectedIndex].value;
  var valorseleccionado = valor.options[valor.selectedIndex].text;
  if (valorseleccionado == 'VENDIDO') {
    document.getElementById('venta').style.display='block';
  }else{
    document.getElementById('venta').style.display='none';
  }
}

$('#AddRuta').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato1 = button.data('piloto')
      var dato2 = button.data('tipo')
      var dato3 = button.data('placa')
      var dato4 = button.data('canal')
      var dato5 = button.data('depto')
      var dato6 = button.data('sede')
      var dato7 = button.data('asig')
      

      var modal = $(this)
      modal.find('.modal-body #piloto').val(dato1)
       modal.find('.modal-body #tipo').val(dato2)
       modal.find('.modal-body #placa').val(dato3)
       modal.find('.modal-body #canal').val(dato4)
       modal.find('.modal-body #depto').val(dato5)
       modal.find('.modal-body #sede').val(dato6)
       modal.find('.modal-body #asig').val(dato7)
       
    })
</script>  
</body>
</html>