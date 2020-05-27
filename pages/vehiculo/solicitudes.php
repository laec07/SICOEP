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
$depto=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais' and usa_vehi='S'" );
/*************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y/m/d");
$mes_actual= Date("m");
$año_actual= date("Y");
/***************Borra solicitudes no procesadas de un día anterior**********************************/
$br=mysqli_query($conexion,"SELECT id_solicitud FROM combustible_solicitud where estatus is null and fecha < '$fecha_actual'");
while ($fila_borra=mysqli_fetch_row($br)) {
  $dato=$fila_borra['0'];
  mysqli_query($conexion,"DELETE FROM combustible_detalle where id_solicitud='$dato'");
  mysqli_query($conexion,"DELETE FROM combustible_solicitud where id_solicitud='$dato'");
};
/**************Trae las Sedes*************************************/
$Result=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais' and usa_vehi='S'" );
/*************Muestra solicitudes pendientes**************************************/
$pendiente=mysqli_query($conexion,"SELECT
  c.id_solicitud,
  c.fecha,
  c.id_depto,
  d.Depto,
  c.total_galones,
  c.total_efectivo,
  c.usuario_solicita,
  c.estatus,
  c.codigo_pais
FROM
  combustible_solicitud c,depto d
WHERE
  estatus = 'PENDIENTE'
AND c.id_depto=d.Id_depto
AND c.codigo_pais='$pais'
order by c.fecha desc
");
$c_pendiente=mysqli_query($conexion,"SELECT
  count(*) as total
FROM
  combustible_solicitud 
WHERE
  estatus = 'PENDIENTE'
AND codigo_pais='$pais'
");
$cuenta_p=mysqli_fetch_array($c_pendiente);
/**************Muestr solicitudes aprobadas**************************************/
/***************************/
$c_aprobados=mysqli_query($conexion,"SELECT
  count(*) as total
FROM
  combustible_solicitud
WHERE
  estatus = 'APROBADO'
AND MONTH(fecha)='$mes_actual'
AND YEAR(fecha)='$año_actual'
AND codigo_pais='$pais'
");
$cuenta_a=mysqli_fetch_array($c_aprobados);
/******************muestra solicitudes rechazadas*********************************/
$rechazados=mysqli_query($conexion,"SELECT
  c.id_solicitud,
  c.fecha,
  c.id_depto,
  d.Depto,
  c.total_galones,
  c.total_efectivo,
  c.usuario_solicita,
  c.estatus,
  c.descripcion
FROM
  combustible_solicitud c,depto d
WHERE
  estatus = 'RECHAZADO'
AND c.id_depto=d.Id_depto
AND MONTH(c.fecha)='$mes_actual'
AND YEAR(c.fecha)='$año_actual'
AND c.codigo_pais='$pais'
order by c.fecha desc
");
$c_rechazados=mysqli_query($conexion,"SELECT
  count(*) as total
FROM
  combustible_solicitud
WHERE
  estatus = 'RECHAZADO'
AND MONTH(fecha)='$mes_actual'
AND YEAR(fecha)='$año_actual'
AND codigo_pais='$pais'
");
$cuenta_r=mysqli_fetch_array($c_rechazados);
/************trae total acumulado mes******************************************/
$ts=mysqli_query($conexion,"SELECT sum(total_efectivo) as total FROM combustible_solicitud WHERE  estatus = 'APROBADO' AND codigo_pais='$pais' and MONTH(fecha)='$mes_actual' AND YEAR(fecha)='$año_actual'  ");
$total=mysqli_fetch_array($ts);
/*******************traé total galones acumulado mes***********************************/
$ts_g=mysqli_query($conexion,"SELECT sum(total_galones) as total FROM combustible_solicitud WHERE  estatus = 'APROBADO' AND codigo_pais='$pais' and MONTH(fecha)='$mes_actual' AND YEAR(fecha)='$año_actual'");
$total_g=mysqli_fetch_array($ts_g);
/***********************traer canal*******************************/
$canal=mysqli_query($conexion,"SELECT * FROM canal where estado='A'");
//////////////Trae procentaje general para mostrarlo en reloj
$porc=mysqli_query($conexion,"SELECT sum(asignado_gal) as asignado,sum(restantes_gal) as restante from ruta where codigo_pais='$pais' and estado='ACTIVO'");
$porcent=mysqli_fetch_array($porc);
$porcentaje =($porcent['restante'] * 100) / $porcent['asignado'];

?>
<!DOCTYPE html>

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
  <!-- Select2 -->
  <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="../../dist/css/skins/skin-red.min.css">
  <link rel="shortcut icon" href="../../dist/img/logo.ico" />

      <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
        <div class="col-md-2">
          <h3>
            <?php echo $empresa['empresa']; ?>
            <small>Solicitudes combustible</small>
          </h3>
           
        </div>
        <div class='col-md-3'>
          <div class='alert alert-info alert-dismissible'>
            <h4>Acumulado mes</h4>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <div class="row">
              <div class="col-md-5">
                <h4>Total: <?php echo $rps['moneda']. number_format($total['total'],2,'.',',');?></h4> 
              </div>
              <div class="col-md-2">
                <h4>Galones: <?php echo  number_format($total_g['total'],2,'.',',');?></h4> 
              </div>
            </div>   
          </div>
        </div>
  <div class='col-md-2 text-center'>
    
       <div id="test">
    <?php echo round($porcentaje)?>

    </div>
    
  </div>
         <div class="col-md-4">
          <a href="" class="btn btn-info" data-target="#NuevaSolicitud" data-toggle='modal' title="Nueva Solicitud"><i class="fa fa-plus"></i> Nuevo</a>
          
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
     
     
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
      <div class="box">
        <p style="display: none; width: 300px; color: white; background-color: red;" class="help-block" id="aviso" >No tiene suficientes galones disponibles.</p>
        <div id="mostrardatos">    
          <!--Se muestran los datos de la solicitud-->
        </div>                  
      </div>
      <!--Pendientes de aprobar-->
        <div class="box box-danger collapsed-box">
          <div class="box-header">
            <h4 class="box-title">Pendientes de Aprobar <small><?php echo $cuenta_p['total']; ?></small></h4>
            <div class='box-tools pull-right'>
            <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-plus'></i></button>
          </div>
          </div>
          <div class="box-body">
            <div style='overflow:scroll;height: 100% '>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>ID</th>
                    <th>Depto.</th>
                    <th>Galones</th>
                    <th>Total</th>
                    <th>Solicitante</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($fila=mysqli_fetch_array($pendiente)) {
                    echo "
                    <tr>
                      <td>".date_format(date_create($fila['fecha']),'d/m/Y')."</td>
                      <td>".$fila['id_solicitud']."</td>
                      <td>".$fila['Depto']."</td>
                      <td>".$fila['total_galones']."</td>
                      <td>".$rps['moneda'].number_format($fila['total_efectivo'],2,'.',',')."</td>
                      <td>".$fila['usuario_solicita']."</td>
                      <td><a class='btn btn-success' onclick='solicitud_editable(".$fila['id_solicitud'].")'  title='Ver detalle'><span class='fa fa-eye'> </span></a></td>                       
                    </tr>

                    ";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /. Pendientes de aprobar-->
        <!--Aprobados mes-->
        <div class="box box-success collapsed-box">
          <div class="box-header">
            <h4 class="box-title">Aprobados mes actual <small><?php echo $cuenta_a['total']; ?></small></h4>
            <div class='box-tools pull-right'>
              <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-plus'></i></button>      
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-sm-2">Mes:</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="month" id="mes_busqueda" value="<?php echo date("Y-m") ?>"  >     
                  </div>
            
                </div>
                    
                </div>
                <div class="col-md-3">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-labe">Sede:</label> 
                      <div class="col-sm-10">
                        <select class="form-control" id="sede_b" >
                          <option>TODOS</option>
                                                            <?php 
                                      while($fila=mysqli_fetch_row($depto)){
                                          echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                                      }
                                  ?>
                        </select>                        
                      </div>

                  </div>                   
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary btn-block"  onclick="solicitudes_aprobadas();"><span class="fa fa-search"></span></button>                  
                </div>

            </div>
             
             <div id="solicitudes_aprobadas">
               
             </div> 
           

          </div>
        </div>
        <!--/. Aprobados mes-->
        <!--Rechazados mes-->
        <div class="box box-default collapsed-box">
          <div class="box-header">
            <h4 class="box-title">Rechazados mes actual <small><?php echo $cuenta_r['total']; ?></small></h4>
            <div class='box-tools pull-right'>
            <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-plus'></i></button>
          </div>
          </div>
          <div class="box-body">
            <div style='overflow:scroll;height: 100% '>
              <table id='example3' class='table table-bordered table-striped'>
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>ID</th>
                    <th>Depto.</th>
                    <th>Galones</th>
                    <th>Total</th>
                    <th>Solicitante</th>
                    <th>Motivo</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($fila_2=mysqli_fetch_array($rechazados)) {
                    echo "
                    <tr>
                      <td>".date_format(date_create($fila['fecha']),'d/m/Y')."</td>
                      <td>".$fila['id_solicitud']."</td>
                      <td>".$fila_2['Depto']."</td>
                      <td>".$fila_2['total_galones']."</td>
                      <td>".$rps['moneda'].number_format($fila_2['total_efectivo'],2,'.',',')."</td>
                      <td>".$fila_2['usuario_solicita']."</td>
                      <td>".$fila_2['descripcion']."</td>                       
                    </tr>

                    ";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!--/. Rechazados mes-->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <!-- *************Form ingreso nueva solicitud******************** -->
    <div class="modal" id="NuevaSolicitud" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nueva solicitud</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM id='nuevasolicitud' method="POST" >    
                          <div class="form-group">
                              <label for="depto">Seleccione Sede:</label>
                              <SELECT  name="depto" id="depto" class="form-control" >
                                 <?php 
                                      while($fila=mysqli_fetch_row($Result)){
                                          echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                                      }
                                  ?>
                                </SELECT>
                              </div>
                          <div class="form-group">
                            <label>CANAL</label>
                            <select name="canal_n" id="canal_n" class="form-control  select2"  multiple="multiple" data-placeholder="Seleccione canal" style="width: 100%;  ">
                              <option selected >TODOS</option>
                            <?php
                              while ($fila_n=mysqli_fetch_array($canal)) {
                                echo"
                                  <option value='".$fila_n['canal']."'>".$fila_n['canal']." </option>
                                ";
                              }
                            ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label >Fecha:</label>
                            <input type="date" name="fecha"  id="fecha" class="form-control" value="<?php echo date("Y-m-d");?>">
                          </div>

                          <div class="form-group">
                            <label>Precio combustible:</label>
                            <div class="row"> 

                              <div class="col-md-3">
                                <label>Super</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                  <input type="number" step="0.01" name="super" id="super"  placeholder="0.00" required="" class="form-control">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <label>Regular</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                  <input type="number" step="0.01" name="regular" id="regular"   placeholder="0.00" required="" class="form-control">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <label>Diesel</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                  <input type="number" step="0.01" name="diesel" id="diesel"  value="0.00"  class="form-control">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <label>Gas</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                  <input type="number" step="0.01" name="gas" id="gas"  value="0.00"  class="form-control">
                                </div>
                              </div>
                              
                            </div>
                          </div>
                            
                    <input type="reset" value="Procesar" onclick="buscar();"  data-dismiss="modal" class="btn btn-success">
                </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  data-dismiss="modal" class="btn btn-warning">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso nueva solicitud******************** -->
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
<script src="../../controllers/solicitud_busqueda.js"></script>
<script src="../../controllers/solicitud_guarda.js"></script>
<script src="../../bower_components/speedometer.js/excanvas-modified.js"></script>
<script src="../../bower_components/speedometer.js/jquery.speedometer.js"></script>
<script src="../../bower_components/speedometer.js/jquery.jqcanvas-modified.js"></script>
<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>  

<script src="../../controllers/solicitudes.js"></script>

<script >

</script>
</body>
</html>