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
mysqli_set_charset($conexion,"utf8");
$datos_empresa=mysqli_query($conexion,"SELECT * FROM empresa where id_empresa='$em'");
$empresa=mysqli_fetch_array($datos_empresa);
$pais=$_SESSION['usuario']['codigo_pais'];
$sede=$_SESSION['usuario']['Id_depto'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/*******************************************************************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
$mes_actual= Date("m");
$año_actual= date("Y");
$fi=$_POST['inicio'];
$ff=$_POST['fin'];

$v_tipo="'". implode("','", $_POST['tipo'])."'";
$v_placa="'". implode("','", $_POST['idequip'])."'";
$sede="'". implode("','", $_POST['idsede'])."'";

/**********************************************************************************************************/
if ($v_tipo=="'Todos'") {
  $var_tipo="";
  $var2_tipo="";
}else{
  $var_tipo="AND t.id_tipomantenimiento in ($v_tipo)";
  $var2_tipo="AND id_tipomantenimiento in ($v_tipo)";
}

if ($v_placa=="'Todos'") {
  $var_placa="";
  $var2_placa="";
}else{
  $var_placa="AND mv.Id_equipo in ($v_placa)";
  $var2_placa="AND Id_equipo in ($v_placa)";
}

if ($sede=="'TODOS'") {
  $sede_b="";
  $sede_b2="";
}else{
  $sede_b="AND a.Id_depto in ($sede) ";
  $sede_b2="AND Id_depto in ($sede) ";
}

/**********************************************************************************************************/ 
////////////////////////////
$depto=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais' and usa_vehi='S'" );
///////////////////////////
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
mv.codigo_pais='$pais'
AND mv.Fecha BETWEEN '$fi' AND '$ff' 
$var_tipo 
$var_placa
$sede_b
  ");
$Resultequip=mysqli_query($conexion, "SELECT * FROM vehiculo where codigo_pais='$pais' AND Estado_equipo NOT IN ('BAJA')");
$placa=mysqli_query($conexion, "SELECT * FROM vehiculo where codigo_pais='$pais' and Estado_equipo NOT IN ('BAJA') ");
/*****************************************************************************************************/
$proveedor=mysqli_query($conexion,"SELECT * FROM proveedor WHERE cod_pais='$pais'");
$proveedor_e=mysqli_query($conexion,"SELECT * FROM proveedor WHERE cod_pais='$pais'");
/******************************************************************************************************/
$total=mysqli_query($conexion,"SELECT SUM(costo) as costo FROM mantenimiento_vehiculo mv LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo AND a.Estado_asig = 'ACTIVO' WHERE mv.codigo_pais ='$pais' AND mv.Fecha BETWEEN '$fi' AND '$ff' $var2_tipo $var_placa $sede_b ");
$rtotal=mysqli_fetch_array($total);
/******************************************************************************************************/
$tipo=mysqli_query($conexion, "SELECT
    ve.id_equipo,
    a.llantas,
    b.baterias,
    c.servicio_correctivo,
    d.Reparacion,
    e.Servicio_Preventivo,
    f.Inversion,
    g.Enderezado_y_pintura,
    h.Servicio_Mayor,
    i.deducible_siniestro,
    ve.codigo_pais
FROM
    (
        (
            vehiculo ve
            LEFT JOIN (
                SELECT
                    mv.id_equipo,
                    sum(mv.costo) llantas,
                    mv.Fecha
                FROM
                    mantenimiento_vehiculo mv
                LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
                AND a.Estado_asig = 'ACTIVO'
                WHERE
                    id_tipomantenimiento = '4'
                AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
                GROUP BY
                    id_equipo
            ) a ON ve.id_equipo = a.id_equipo
        )
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Baterias,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '1'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) b ON ve.id_equipo = b.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Servicio_correctivo,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '6'
            AND mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) c ON ve.id_equipo = c.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Reparacion,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '5' 
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) d ON ve.id_equipo = d.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Servicio_Preventivo,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '8'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) e ON ve.id_equipo = e.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Inversion,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '3'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) f ON ve.id_equipo = f.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Enderezado_y_pintura,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '2'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) g ON ve.id_equipo = g.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Servicio_Mayor,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '7'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY 
                id_equipo
        ) h ON ve.id_equipo = h.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) deducible_siniestro,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '9'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) i ON ve.id_equipo = i.id_equipo

)
WHERE ve.codigo_pais='$pais'
");
/**************************************************************************************************/
$area=mysqli_query($conexion,"
SELECT
  MONTH (mv.Fecha),
  SUM(costo) AS costo
FROM
  mantenimiento_vehiculo mv
LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
AND a.Estado_asig = 'ACTIVO'
WHERE
 mv.Fecha BETWEEN '$fi' AND '$ff'  $var2_placa  $var2_tipo  $sede_b2
AND codigo_pais = '$pais'
GROUP BY
  MONTH (mv.Fecha)

  ");
$barra=mysqli_query($conexion,"
SELECT
mv.Id_equipo,
  SUM(costo) AS costo
FROM
  mantenimiento_vehiculo mv
LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
AND a.Estado_asig = 'ACTIVO'
WHERE
  mv.Fecha BETWEEN '$fi' AND '$ff'  $var2_placa $var2_tipo $sede_b2
AND codigo_pais = '$pais'
GROUP BY
  Id_equipo

  ");
$etiqueta_barra=mysqli_query($conexion,"
SELECT
mv.Id_equipo
FROM
  mantenimiento_vehiculo mv
LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
AND a.Estado_asig = 'ACTIVO'
WHERE
  mv.Fecha BETWEEN '$fi' AND '$ff'  $var2_placa $var2_tipo $sede_b2
AND codigo_pais = '$pais'
GROUP BY
  Id_equipo
  ");
$mes_mate=mysqli_query($conexion,"
SELECT
  MONTH (mv.Fecha) as mes
FROM
  mantenimiento_vehiculo mv
LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
AND a.Estado_asig = 'ACTIVO'
WHERE
 mv.Fecha BETWEEN '$fi' AND '$ff'  $var2_placa $var2_tipo $sede_b2
AND codigo_pais = '$pais'
GROUP BY
  MONTH (mv.Fecha)
  ");
$tipo_mante=mysqli_query($conexion,"SELECT * from tipo_mantenimiento where estado='A'");
$tipo_mante_=mysqli_query($conexion,"SELECT * from tipo_mantenimiento where estado='A'");
$tipo_mante_e=mysqli_query($conexion,"SELECT * from tipo_mantenimiento where estado='A'");
?>
<!DOCTYPE html>


<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SICOEP</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width" name="viewport">
    <!-- Select2 -->
  <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
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
    <!-- daterange picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">



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
        <li class="active"><a href="mantenimientos.php"><i class="fa fa-wrench"></i><span>Mantenimientos</span></a></li>
        
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
        <div class="col-md-5">
          <h3>
            <?php echo $empresa['empresa']; ?>
            <small>Mantenimiento</small>
          </h3>
           
        </div>
        <div class="col-md-3">
          <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4>Acumulado <?php echo $rps['moneda']. number_format($rtotal['costo'],2,'.',','); ?></h4>
                
              </div>
 
        </div>
         <div class="col-md-4">
          <a href="" class="btn btn-info" data-target="#nuevoMante" data-toggle='modal' title="Nuevo Piloto"><i class="fa fa-plus"></i> Agregar</a>
          <a href="" class="btn btn-primary" data-target="#Historial" data-toggle='modal' title="Historial"><i class="fa fa-search"></i> Buscar</a>
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
            <h3 class="box-title">Bitácora</h3><small><?php echo " del ". date_format(new Datetime($fi),'d/m/Y')." al " .date_format(new datetime($ff),'d/m/Y'); ?></small>
            <?php
            echo"
            <a href='mantenimientos_excel_b.php?inicio=$fi&fin=$ff&tipo=$v_tipo&idequip=$v_placa&sede=$sede' class='btn btn-success pull-right'><i class='fa fa-file-excel-o'></i></a>
            ";
            ?>
           
          </div>
          <div class="box-body">
            <div style="overflow:scroll;height: 100%  ">
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
                  <th><span class="glyphicon glyphicon-wrench"></span></th>
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
                      <td><a data-toggle='modal' data-target='#editMante' class='btn btn-warning'
                         data-ide='".$fila['ID']."''
                          data-placa='".$fila['Id_equipo']."''
                          data-fecha='".$fila['Fecha']."''
                          data-tipo='".$fila['id_tipomantenimiento']."''
                          data-kilometro='".$fila['Kilometrajem']."''
                          data-obser='".$fila['Observaciones']."''
                          data-proveedor='".$fila['id_proveedor']."''
                          
                          data-costo='".$fila['costo']."''
                          data-costo_uni='".$fila['costo_unitario']."''
                          data-no_fact='".$fila['no_fact']."''
                          data-serie_fact='".$fila['serie_fact']."'

                      ><span class='glyphicon glyphicon-pencil'></span></a>
                      <a data-toggle='modal' href='../../consultas/mante_vehi_elimina.php?ID=".$fila['ID']."'onclick=\"return confirm('¿Esta seguro de  eliminar este gasto?')\" class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span></a></td>
                    </tr>

                    ";
                  
                  }
                  
                ?>
                </tbody>

          </table>
            </div>
          </div><!--Termina box body-->
          
        </div>
        <div class="box box-default collapsed-box"><!--inicia body tipo-->
            <div class="box-header whith-border">
                <h3 class="box-title">Gasto por tipo:</h3> <small> <?php echo " del ". date_format(new Datetime($fi),'d/m/Y')." al " .date_format(new datetime($ff),'d/m/Y'); ?></small>
                <div class="box-tools pull-right">
                  <?php
            echo"
            <a href='mante_tipo_excel_b.php?inicio=$fi&fin=$ff&tipo=$v_tipo&idequip=$v_placa&sede=$sede' class='btn btn-success'><i class='fa fa-file-excel-o'></i></a>
            ";
            ?>
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
              <div style="overflow:scroll;height: 100%  ">
                <table class="table">
      <thead>
          <tr>
              <th>Placa</th>
              <th>Llantas</th>
              <th>Batería</th>
              <th>Serv.correctivo</th>
              <th>Serv.Preventivo</th>
              <th>Reparación</th>
              <th>Inversión</th>
              <th>End. y Pintura</th>
              <th>Serv.Mayor</th>
              <th>Ded-Siniestro</th>
              <th>Total</th>    
          </tr>
      </thead>
  
<?php 
     $fila=0;
    $llantas=0;
    $bater=0; 
    $scorec=0;
    $spre=0;
    $rep=0;
    $inver=0;
    $ende=0;
    $smayor=0;
    $dsinis=0; 
    $gene=0;
    while ($rquery=mysqli_fetch_array($tipo)) {
        $fila=($rquery['llantas']+$rquery['baterias']+$rquery['servicio_correctivo']+$rquery['Servicio_Preventivo']+$rquery['Reparacion']+$rquery['Inversion']+$rquery['Enderezado_y_pintura']+$rquery['Servicio_Mayor']+$rquery['deducible_siniestro']);
       if ($fila > 0) {
        echo "
            <tr>
            <td>".$rquery['id_equipo']."</td>
            <td>".$rquery['llantas']."</td>
            <td>".$rquery['baterias']."</td>
            <td>".$rquery['servicio_correctivo']."</td>
            <td>".$rquery['Servicio_Preventivo']."</td>
            <td>".$rquery['Reparacion']."</td>
            <td>".$rquery['Inversion']."</td>
            <td>".$rquery['Enderezado_y_pintura']."</td>
            <td>".$rquery['Servicio_Mayor']."</td>
            <td>".$rquery['deducible_siniestro']."</td>
            <td>".$rps['moneda']."".$fila."</td>
            </tr>
        ";
        }
        
       $llantas += $rquery['llantas'];
       $bater += $rquery['baterias'];
       $scorec += $rquery['servicio_correctivo'];
       $spre += $rquery['Servicio_Preventivo'];
       $rep += $rquery['Reparacion'];
       $inver += $rquery['Inversion'];
       $ende += $rquery['Enderezado_y_pintura'];
       $smayor += $rquery['Servicio_Mayor'];
       $dsinis += $rquery['deducible_siniestro'];
       $gene += $fila;
    }
    echo "
        <tfoot>
            <th>Total General</th>
            <th>".$rps['moneda']."".$llantas."</th>
            <th>".$rps['moneda']."".$bater."</th>
            <th>".$rps['moneda']."".$scorec."</th>
            <th>".$rps['moneda']."".$spre."</th>
            <th>".$rps['moneda']."".$rep."</th>
            <th>".$rps['moneda']."".$inver."</th>
            <th>".$rps['moneda']."".$ende."</th>
            <th>".$rps['moneda']."".$smayor."</th>
            <th>".$rps['moneda']."".$dsinis."</th>
            <th>".$rps['moneda']."".$gene."</th>
            <tr>
            <th></th>
            <th>Llantas</th>
              <th>Batería</th>
              <th>Serv.correctivo</th>
              <th>Serv.Preventivo</th>
              <th>Reparación</th>
              <th>Inversión</th>
              <th>End. y Pintura</th>
              <th>Serv.Mayor</th>
              <th>Ded-Siniestro</th>
              <th>Total</th>  
            </tr>
        </tfoot>
        ";

?>
       
  </table>
    </div>
            </div>
          </div><!--finaliza body tipo-->
        <div class="row"><!--inicia gráficas-->
          <div class="col-md-6"><!--inicia área gráfica -->
            <div class="box box-primary">
              <div class="box-header whith-border">
                <h3 class="box-title">Gasto <?php echo " del ". date_format(new Datetime($fi),'d/m/Y')." al " .date_format(new datetime($ff),'d/m/Y'); ?></h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="areaChart" style="height:250px" ></canvas>
                </div>
              </div>
            </div>
          </div><!--/finaliza área gráfica -->
          <div class="col-md-6"><!--inicia donut gráfica -->
           <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Gasto vehículo <?php echo " del ". date_format(new Datetime($fi),'d/m/Y')." al " .date_format(new datetime($ff),'d/m/Y'); ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div><!--/finaliza donut gráfica -->
        </div><!--finaliza gráficas-->

    </section>
    <!-- /.Finaliza content ---------------------------------------------------->
  </div>
  <!-- /.content-wrapper -->
  <!--Inicia ventanas emergentes ------------------------------------->
 <!-- *************Form ingreso mantenimiento******************** -->
    <div class="modal" id="nuevoMante" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nuevo Mantenimiento</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="../../consultas/mante_vehi_guarda.php" method="POST" name="f1">
                        <div class="form-group">
                          <label for="idequip">Placa:</label>
                          <select name="idequip" class="form-control" >
                          <option>Seleccione placa..</option>
                            <?php 
                              while($fila1=mysqli_fetch_row($Resultequip)){
                                echo "<option value='".$fila1['0']."'>".$fila1['0']." - ".$fila1['2']." ".$fila1['6']."</option>";
                              }
                              mysqli_free_result($Resultequip);
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="fecha">Fecha:</label>
                          <input type="Date" name="fecha" id="fecha" required="" class="form-control" value="<?php echo date('Y-m-d') ?>">
                        </div>
                        <div class="form-group">
                          <label>Tipo mantenimiento:</label>
                          <select name="tipo" class="form-control">
                             
                               <?php
                                while ($fila_t=mysqli_fetch_array($tipo_mante)) {
                                  echo "
                                    <option value=".$fila_t['id_tipomantenimiento'].">".$fila_t['tipo_mantenimiento']." </option>
                                  ";
                                }
                               ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="kilometro">Kilometraje</label>
                          <input type="texto" name="kilometro" placeholder="Kilometraje..." class="form-control" >
                        </div>

                        <div class="form-group">
                          <label for="obser">Descripción:</label>
                          <textarea name="obser" placeholder="Describa trabajos realizados..." class="form-control"></textarea>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                          <label for="costo">Costo:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                            <input type="number" step="0.01" name="costo" id="costo"  required="" placeholder="0.00" class="form-control">
                          </div>
                        </div>
                        </div>
                        
                        
                           <div class="form-group">
                          <div class="row">
                            <div class="col-md-3"> 
                              <label>Serie Factura</label>
                              <input type="text" name="serie_fact" id="serie_fact"  placeholder="Serie Factura" class="form-control">
                            </div>
                            <div class="col-md-6">
                              <label>No. Factura</label>
                              <input type="text" name="no_fact" id="no_fact"  placeholder="00000" class="form-control" >
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label>Proveedor</label>
                          <div class="input-group margin">
                          <select  name="proveedor" id="proveedor"   class="form-control" >
                            <?php
                              while ($fila_p=mysqli_fetch_array($proveedor)) {
                                echo "
                                  <option value=".$fila_p['id_proveedor'].">".$fila_p['proveedor']."</option>
                                ";
                              }
                            ?>

                          </select>
                          <span class="input-group-btn">
                          <a class="btn btn-info btn-flat"  data-toggle="modal" data-target="#proveeNuevo">Nuevo</a>
                        </span>
                        </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-4">
                              <label>Costo unitario</label>
                              <div class="input-group">
                                <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                <input type="number" step="0.01" name="costo_uni" id="costo_uni"  placeholder="0.00" class="form-control" >
                              </div>
                            </div>
                          </div>
                          
                          
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
  <!-- *************Form ingreso mantenimientos******************** -->
 <!-- *************Form Edita Mante******************** -->
        <div class="modal" id="editMante" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Editar Mantenimiento</h4>
                    </div>
                    <div class="modal-body">                      
                       <form action="../../consultas/mante_vehi_edita.php" method="POST"> 

                        <div class="form-group">
                          <input type="text" name="ide" id="ide" style="display: none;">
                          <label for="placa">Placa:</label>
                          <input type="text" name="placa" id="placa" readonly class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="fecha">Fecha:</label>
                          <input type="Date" name="fecha" id="fecha" class="form-control" >
                        </div>
                        <div class="form-group">
                          <label for="tipo">Tipo mantenimiento:</label>
                          <select name="tipo" id="tipo" class="form-control">
                             <?php
                                while ($fila_t=mysqli_fetch_array($tipo_mante_e)) {
                                  echo "
                                    <option value=".$fila_t['id_tipomantenimiento'].">".$fila_t['tipo_mantenimiento']." </option>
                                  ";
                                }
                               ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="kilometro">Kilometraje</label>
                          <input type="number" step="1" name="kilometro" id="kilometro" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Trabajos realizados:</label>
                          <textarea name="obser" id="obser" class="form-control" ></textarea>
                        </div>
                       
                        <div class="row">
                          <div class="col-md-4">
                          <label for="costo">Costo:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                            <input type="number" step="0.01" name="costo" id="costo"  class="form-control">
                          </div>
                        </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-3"> 
                              <label>Serie Factura</label>
                              <input type="text" name="serie_fact" id="serie_fact"  placeholder="Serie Factura" class="form-control">
                            </div>
                            <div class="col-md-6">
                              <label>No. Factura</label>
                              <input type="text" name="no_fact" id="no_fact"  placeholder="00000" class="form-control" >
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="proveedor">Proveedor</label>
                          <select  name="proveedor" id="proveedor"  class="form-control" >
                            <?php
                              while ($fila_p=mysqli_fetch_array($proveedor_e)) {
                                echo "
                                  <option value=".$fila_p['id_proveedor'].">".$fila_p['proveedor']."</option>
                                ";
                              }
                            ?>
                          </select>
                        </div>

                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-4">
                              <label>Costo unitario</label>
                              <div class="input-group">
                                <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                <input type="number" step="0.01" name="costo_uni" id="costo_uni"   class="form-control" >
                              </div>
                            </div>
                          </div>
                        </div>
                  <input type="submit" class="btn btn-success" value="Guardar">             
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
    <!-- *************Form Edita Mante******************** -->
       <!-- *************Form nuevo proveedor******************** -->
   <div class="modal fade" id="proveeNuevo">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo proveedor</h4>
              </div>
              <div class="modal-body">
                <form action="../../consultas/proveedor_guarda.php" method="POST">
                  <div class="form-group">
                    <label for="prove">Nombre:</label>
                    <input type="text" name="prove" id="prove" class="form-control" maxlength="45" placeholder="Proveedor" required="">
                  </div>
                  <div class="form-group">
                    <label for="telefono">Telefono:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                        </div>
                    <input type="number" name="telefono" id="telefono" class="form-control" maxlength="45" placeholder="00000000" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="contacto">Contacto:</label>
                    <input type="text" name="contacto" id="contacto" class="form-control" maxlength="45" placeholder="Nombre contacto">
                  </div>
                  <div class="form-group">
                    <label for="cel_contacto">Cel. Contacto:</label>
                    <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                      </div>
                    <input type="number" name="cel_contacto" id="cel_contacto" class="form-control" maxlength="45" placeholder="000000" >
                    </div>
                  </div>
                  <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- *************./Form nuevo proveedor******************** -->
 <!-- *************Historial******************** -->
<!-- -------------------------------------------------------------- -->
   <div class="modal modal-default fade" id="Historial">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Historial</h4>
              </div>
              <div class="modal-body">
                <form action="mantenimientos_busqueda.php" method="POST" >

                  <div class="row"> 
                    <div class="col-md-4">
                        <label>Del:</label>
                        <input type="date" name="inicio" id="inicio" class="form-control" value="<?php echo $fi?>">
                        
                    </div>
                    <div class="col-md-4">
                      <label>Al:</label>
                      <input type="date" name="fin" id="fin" class="form-control" value="<?php echo $ff ?>">
                    </div>
                    <div class="col-md-4">
                      <label>Tipo mantenimiento:</label>
                      <select name="tipo[]" class="form-control  select2"  multiple="multiple" style="width: 100%;" >
                        <option selected>Todos</option>
                 <?php
                  while ($fila_t=mysqli_fetch_array($tipo_mante_)) {
                    echo "
                      <option value=".$fila_t['id_tipomantenimiento'].">".$fila_t['tipo_mantenimiento']." </option>
                    ";
                  }
                 ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                          <label for="idequip">Placa:</label>
                          <select name="idequip[]" class="form-control  select2"  multiple="multiple" style="width: 100%;">
                          <option selected>Todos</option>
                            <?php 
                              while($fila1=mysqli_fetch_row($placa)){
                                echo "<option value='".$fila1['0']."'>".$fila1['0']."</option>";
                              }
                              mysqli_free_result($Resultequip);
                            ?>
                          </select>
                        </div>
                    <div class="col-md-4">
                      <label>SEDE</label>
                      <SELECT name="idsede[]" class="form-control  select2"  multiple="multiple" style="width: 100%;" >
                        <OPTION selected>TODOS</OPTION>
                            <?php 
                              while($fila=mysqli_fetch_row($depto)){
                                  echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                              }
                            ?>
                      </SELECT>
                    </div>
                  </div>
                    
                 
                  <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Aplicar</button>
              </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- *************./Historial******************** -->
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
<!-- ChartJS -->
<script src="../../bower_components/chart.js/Chart.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- date-range-picker -->
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- ChartJS -->
<script src="../../bower_components/chart.js/Chart.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
<script >
  /////////Hace funcionar Select////////////
  $('.select2').select2()
  //Hace funcionar los componentes de la tabla
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
//trae datos para editar mantenimiento
 $('#editMante').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('ide')
      var recipient1 = button.data('placa')
      var recipient2 = button.data('fecha')
      var recipient3 = button.data('tipo')
      var recipient4 = button.data('kilometro')
      var recipient5 = button.data('obser')
      var recipient6 = button.data('costo')
      var recipient7 = button.data('serie_fact')
      var recipient8 = button.data('no_fact')
      var recipient9 = button.data('proveedor')
      var recipient10 = button.data('costo_uni')

      var modal = $(this)    
      modal.find('.modal-body #ide').val(recipient0)
      modal.find('.modal-body #placa').val(recipient1)
      modal.find('.modal-body #fecha').val(recipient2)
      modal.find('.modal-body #tipo').val(recipient3)  
      modal.find('.modal-body #kilometro').val(recipient4)
      modal.find('.modal-body #obser').val(recipient5)
      modal.find('.modal-body #costo').val(recipient6)
      modal.find('.modal-body #serie_fact').val(recipient7) 
      modal.find('.modal-body #no_fact').val(recipient8) 
      modal.find('.modal-body #proveedor').val(recipient9) 
      modal.find('.modal-body #costo_uni').val(recipient10)  
    });
//99999999999999999999999999999999999999999999
//Date range as a button
  $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Hoy'       : [moment(), moment()],
          'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
          'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
          'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
          'Mes pasado'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('D/M/YYYY') + ' - ' + end.format('D/M/YYYY'))
        document.getElementById("inicio").value =start.format('Y-MM-DD');
        document.getElementById("fin").value =end.format('Y-MM-DD');
        
      }
    );
   //--------------
    //- AREA CHART -
    //--------------

$(function () {
 // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : [
        <?php
          while ($fila_m=mysqli_fetch_array($mes_mate)) {
           
            echo "'".$fila_m['mes']."',";
          }

        ?>
      ],
      datasets: [
        
        {
          label               : 'Placa',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [
            <?php
              while ($fila_area=mysqli_fetch_array($area)) {
                echo $fila_area['costo'].",";
              }

            ?>

          ]
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }
        //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)
 //-------------
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = {
      labels  : [
      <?php
        while ($fila_etiquet=mysqli_fetch_array($etiqueta_barra)) {
          echo "'".$fila_etiquet['Id_equipo']."'," ;
        }
       ?>
      ],
      datasets: [
        
        {
          label               : 'Digital Goods',
          fillColor           : '#FA031A',
          strokeColor         : '#FA031A',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [
            <?php
              while ($fila_barra=mysqli_fetch_array($barra)) {
                echo $fila_barra['costo'].",";
              }

            ?>

          ]
        }
      ]
    }

    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)

});
   
</script>  
</body>
</html>