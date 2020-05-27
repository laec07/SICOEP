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
$ruta=mysqli_query($conexion,
  "
SELECT
  r.id_ruta,
  r.ruta,
  r.id_equipo,
  r.piloto,
  r.canal,
  r.id_depto,
  d.Depto,
  r.tipo_vehi,
  r.estado,
  r.asignado_gal,
  r.restantes_gal,
  l.orden
FROM
  ruta r,
  depto d,
  canal l
WHERE
  r.codigo_pais = '$pais'
AND r.id_depto = d.Id_depto
AND l.canal=r.canal
AND r.estado in ('ACTIVO','INACTIVO')
ORDER BY r.estado,r.id_depto,l.orden,r.ruta
  ");
/***************************************************/
$canal=mysqli_query($conexion,"SELECT * FROM canal where estado='A'");
$canal2=mysqli_query($conexion,"SELECT * FROM canal where estado='A'");
$canal3=mysqli_query($conexion,"SELECT * FROM canal where estado='A'");
/****************************************************/
$Result=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais' and usa_vehi='S'" );
/***************************************************/
$depto_f=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais' and usa_vehi='S'" );
/******************************************************/
$rts=mysqli_query($conexion,"SELECT r.id,r.ruta,r.Id_depto,d.Depto,r.estado,r.codigo_pais,r.canal FROM rutas r, depto d WHERE r.estado='ACTIVO' and r.codigo_pais='$pais' AND r.Id_depto=d.Id_depto ORDER BY r.ruta,r.id_depto");
//////////////////////////////////////////////////////////////////////////////////////////////
$ruts=mysqli_query($conexion,"SELECT r.id,r.ruta,r.Id_depto,d.Depto,r.estado,r.codigo_pais FROM rutas r, depto d WHERE r.estado='ACTIVO' and r.codigo_pais='$pais' AND r.Id_depto=d.Id_depto ORDER BY r.id_depto,r.ruta");
$ruts_e=mysqli_query($conexion,"SELECT r.id,r.ruta,r.Id_depto,d.Depto,r.estado,r.codigo_pais FROM rutas r, depto d WHERE r.estado='ACTIVO' and r.codigo_pais='$pais' AND r.Id_depto=d.Id_depto ORDER BY r.id_depto,r.ruta");


$depto_rutas=mysqli_query($conexion,"
SELECT
  r.id_depto,
  d.Depto,
  COUNT(r.ruta) AS total,
  SUM(r.asignado_gal) AS asignado,
  SUM(r.restantes_gal) AS restante,
  SUM(r.restantes_gal) * 100 / SUM(r.asignado_gal) AS porcentaje,
  c1.consumido 
FROM
  ruta r
JOIN depto d ON r.id_depto = d.Id_depto
LEFT JOIN (SELECT
  c.id_depto,
  SUM(c.galones) as consumido
FROM
  combustible_detalle c,
  combustible_solicitud cs
WHERE
  cs.id_solicitud = c.id_solicitud
AND cs.estatus = 'APROBADO'
AND MONTH(cs.fecha)='$mes_actual'
AND YEAR(cs.fecha)='$año_actual'
GROUP BY c.id_depto) as c1 ON c1.id_depto=d.Id_depto
WHERE
 d.codigo_pais = '$pais'
AND r.estado = 'ACTIVO'
GROUP BY
  d.id_depto
  ");
$rutas_f=mysqli_query($conexion,"
SELECT
  r.ruta,
  d.Depto
FROM
  rutas r
LEFT JOIN depto d ON d.Id_depto = r.Id_depto
WHERE
  r.canal = 'MASIVO'
AND r.codigo_pais ='$pais'
and r.estado='ACTIVO'
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
      <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->


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
         <li class=" treeview">
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
            <li><a href="solicitudes.php"><i class="fa  fa-check-square"></i>Solicitudes</a></li>
            <li class="active"><a href="rutas.php"><i class="fa  fa-car"></i>Rutas</a></li>
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
        <div class="col-md-8">
          <h3>
            <?php echo $empresa['empresa']; ?>
            <small>Rutas</small>
          </h3>
           
        </div>
        
         <div class="col-md-4">
          <a href="" class="btn btn-info" data-target="#NuevaRuta" data-toggle='modal' title="Nueva Ruta"><i class="fa fa-plus"></i> Agregar</a>
          
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
     
      
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
    <div class="box box-success collapsed-box">
     
          <div class="box-header">
            <h4 class="box-title">Configuración rutas <small></small></h4>
                        <div class='box-tools pull-right'>
              
            <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-plus'></i></button>
          </div>
          </div>
          <div class="box-body">
      <!--   pestaña opciones  --->
            <ul class="nav nav-tabs">
              <li class="active"><a href="#rutas_whow" data-toggle="tab" >Rutas    </a> </li>
              <li><a href="#frecuencias_show" data-toggle="tab" > Frecuencias   </a> </li>
            </ul>
      <!--   pestaña opciones  ---> 
            <div class="tab-content"><!--   Inicia panel de opciones  ---> 
              <div class="tab-pane fade in active " id="rutas_whow"><!--   Inicia panel 1  --->
                <a class="btn btn-success pull-right"  data-target="#NuevaRutas" data-toggle='modal'>Nuevo</a>
                <div class="table-responsive">
                  <div id="lista_rutas" ></div><!--   Muestra informacion rutas  --->
                </div>
              </div><!--   Finaliza panel 1  --->
              <div class="tab-pane fade" id="frecuencias_show"><!--   Inicia panel 2  --->
                <div class="row">
                  <div class="col-md-6">
                    <label>Ruta</label>
                    <select class="form-control" id="ruta_fs" onchange="show_frecuencias()">
                      <option>Seleccione ruta</option>
              <?php  
                while ($row_f=mysqli_fetch_array($rutas_f)) {
                  echo "
                    <option value='".$row_f['ruta']."'>".$row_f['ruta']." -".$row_f['Depto']." </option>
                  ";
                }
              ?>
                    </select>
                  </div>

                </div>
                <hr>
                <div style="height: 500px;">
                  <div class="row">
<div id="alert_delete" class="alert alert-danger col-md-6" style="display: none; " >
  Dato eliminado correctamente!
</div>
<div id="alert_insert" class="alert alert-success col-md-6" style="display: none;" >
  Dato insertado correctamente!
</div>
<div id="alert_edit" class="alert alert-danger col-md-6" style="display: none;" >
  Dato actualizado correctamente!
</div>
</div>
                  <div id="lista_frecuencia"></div><!--   Muestra informacion frecuencias  ---> 
                </div>
              </div><!--   Finaliza panel 2  --->
            </div><!--   Finaliza panel de opciones  ---> 

          </div>
        </div>

      <div id="lista_rutasasignadas"></div>
<?php
$i=1;

while ($fila_d=mysqli_fetch_array($depto_rutas)) {
  
  if ($fila_d['porcentaje'] >= 50.00) {
    $labe='class="label label-success"';
    $box='class="box box-primary collapsed-box"';
  }else if($fila_d['porcentaje'] < 50 && $fila_d['porcentaje'] >0){
      $labe='class="label label-warning"';
      $box='class="box box-warning collapsed-box"';
  }else if ($fila_d['porcentaje'] <=0) {
    $labe='class="label label-danger"';
    $box='class="box box-danger collapsed-box"';
  }
  
    $cms=$fila_d['consumido']-$fila_d['restante'];
  if (($cms >=0) && ($fila_d['restante']=0) ) {
    $excedidos="<label class='label label-danger'>|| Excedidos " .$fila_d['consumido']."</label>";
  }else{
    $excedidos="";
  }

  echo '
    <div '.$box.' >
  <div class="box-header with-border">
    '.$fila_d['Depto'].' ||<label class="label label-info"> '.$fila_d['total'].' Rutas activas </label> || '.$fila_d['asignado'].' Asignados || '.$fila_d['restante'].' Restantes <label '.$labe.'>'.round($fila_d['porcentaje']).'%</label> || '.$fila_d['consumido'].'  Comsumidos  '.$excedidos.'

    <div class="box-tools pull-right">

      <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse"><i class="fa fa-plus"></i></button>
      <a href="../../consultas/rutas_restablece.php?id_depto='.$fila_d['id_depto'].'" class="btn btn-success" title="Restablece Galones disponible según lo asignado" onclick="return confirm(\'Esta acción reiniciar los galones disponibles según lo asignado a cada ruta activa en '.$fila_d['Depto'].', ¿Desea continuar?\')"><span class="fa fa-history"></span></a>
    </div>
  </div>
  <div class="box-body">
    <div style="overflow: scroll; width: 100%">
  ';
  $c_depto=$fila_d['id_depto'];

  $ruta=mysqli_query($conexion,
  "
SELECT
  r.id_ruta,
  r.ruta,
  r.id_equipo,
  r.piloto,
  r.canal,
  r.id_depto,
  d.Depto,
  r.tipo_vehi,
  r.estado,
  r.asignado_gal,
  r.restantes_gal,
  c.consumido,
  rs.canal as canal_r
FROM
  ruta r
INNER JOIN depto d ON r.id_depto = d.Id_depto
INNER JOIN canal l ON l.canal = r.canal
LEFT JOIN rutas rs ON rs.ruta=r.ruta and r.id_depto=rs.Id_depto
LEFT JOIN (
  SELECT
    cd.id_ruta,
    SUM(galones) AS consumido
  FROM
    combustible_detalle cd,
    combustible_solicitud cs
  WHERE
    cs.id_solicitud = cd.id_solicitud
  AND cs.estatus = 'APROBADO'
  AND MONTH (cs.fecha) = '$mes_actual'
  AND YEAR (cs.fecha) = '$año_actual'
  GROUP BY
    cd.id_ruta
) AS c ON c.id_ruta = r.id_ruta
WHERE
  r.codigo_pais = '$pais'
AND r.estado IN ('ACTIVO', 'INACTIVO')
AND r.id_depto = '$c_depto'
ORDER BY
  r.estado,
  d.Depto,
  l.orden,
  r.ruta
  ");
  
echo '
                <table id="example'.$i.'" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th>id asig.</th>               
                          <th>Ruta</th>
                          <th>Piloto</th>
                          <th>Tipo vehi.</th>
                          <th>Placa</th>
                          <th>Canal</th>
                          <th>Sede</th>
                          <th>Estado</th>
                          <th>Gal. Asig.</th>
                          <th>Gal. Disponibles.</th>
                          <th>Consumidos</th>
                          <th>Excedido</th>
                          <th><span class="glyphicon glyphicon-wrench"></span></th>
                        </tr>   
                    </thead>
                    <tbody>
';
$i++;
                while ($fila=mysqli_fetch_array($ruta)) {
                  /*****************************/
                  if ($fila['estado']=="ACTIVO") {
                    $selected_a='selected="selected"';
                    $selected_b='';
                    $color_fila='';
                  }else{
                    $selected_a='';
                    $selected_b='selected="selected"';
                    $color_fila='class="danger"';
                  }
                  /*******************************/
                    $ex=$fila['consumido']-$fila['asignado_gal'];
                    if (($ex>0)&& ($fila['restantes_gal']==0) ) {
                      $exs="<label class='label label-danger'>".$ex."</label>";
                    }else{
                        $exs="--";
                    }
                  /***********************************/
                  $a=$fila['restantes_gal'];
                  $b=$fila['asignado_gal'];
                  $c=$b/2;
                  /*************************************/
                  if ($fila['canal_r']=='MASIVO') {
                    

                    $ver_frecuencia="<a class='fa fa-eye' data-target='#MuestraFrecuencia' data-toggle='modal' 
                                            
                        data-ruta='".$fila['ruta']."'
                        data-pais='".$pais."'
                                    ></a>";
                  }else{
                     $ver_frecuencia="";
                  }
                 
                  if ($a > $c) {
                    $status="<i class='fa fa-circle text-success' title='Combustile restante arriba del 50%'></i>";
                    $clase="class='label label-success' title='Combustile restante arriba del 50%'";
                  }else if($a <= $c and $a > 0 ) {
                    $status="<i class='fa fa-circle text-warning' title='Combustile restante abajo del 50%'></i>";
                    $clase="class='label label-warning' title='Combustile restante abajo del 50%'";
                  }else{
                     $status="<i class='fa fa-circle text-danger' title='Sin combustible'></i>";
                     $clase="class='label label-danger' title='Sin combustible'";
                  }
                  /*****************************************************/
                    echo "
                    <tr $color_fila>
                      <td>".$fila['id_ruta']."</td>
                      <td>".$fila['ruta']."".$ver_frecuencia."</td>
                      <td>".$fila['piloto']."</td>
                      <td>".$fila['tipo_vehi']."</td>
                      <td>".$fila['id_equipo']."</td>
                      <td>".$fila['canal']."</td>
                      <td>".$fila['Depto']."</td>
                      <td>
                          <select id='iactivar' 
                                data-id_ruta='".$fila['id_ruta']."'
                              >
                              <option $selected_a>ACTIVO</option>
                              <option $selected_b>INACTIVO</option>
                          </select>
                      </td>
                      <td contenteditable
                        id='gal'
                        data-id_ruta='".$fila['id_ruta']."'
                      >".$fila['asignado_gal']."</td>
                      <td><label $clase>".$fila['restantes_gal']."</label></td>
                      <td>".$fila['consumido']."</td>
                      <td>".$exs."</td>
                      <td><a class='btn btn-warning' title='Editar' data-target='#EditaRuta' data-toggle='modal'
                            data-id_ruta='".$fila['id_ruta']."'
                            data-ruta='".$fila['ruta']."'
                            data-estado='".$fila['estado']."'
                            data-piloto='".$fila['piloto']."'
                            data-tipo='".$fila['tipo_vehi']."'
                            data-placa='".$fila['id_equipo']."'
                            data-canal='".$fila['canal']."'

                          ><span class='glyphicon glyphicon-pencil '></span></a>
                          <a class='btn btn-success' title='Restablecer galones ruta' onclick='rutas_restablece(".$fila['id_ruta'].");' ><span class='fa fa-history'></span></a>
                      </td>

                    </tr>

                    ";
                  }
  echo '
              </tbody>
          </table>
    </div>
  </div>
</div>
  ';
}
?>

    


    
          
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <!-- *************Form ingreso nueva ruta******************** -->
    <div class="modal" id="NuevaRuta" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nueva Ruta</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="../../consultas/rutas_guardanuevo.php" method="POST" >    
                        <div class="form-group">
                          <label >Ruta:</label>
                          <select  name="ruta"  class="form-control" >
                            <?php
                              while ($f_r=mysqli_fetch_array($ruts)) {
                                echo "
                                  <option value='".$f_r['ruta']."'>".$f_r['ruta']."-".$f_r['Depto']."</option>
                                ";
                              }
                            ?>
                          </select>
                        </div>
                         <div class="form-group">
                          <label >Piloto:</label>
                          <input type="text" name="piloto" placeholder="Piloto" class="form-control" maxlength="200">
                        </div>
                        <div class="form-group">
                          <label >Tipo vehi:</label>
                          <SELECT  name="tipo" id="tipo"  class="form-control"  >
                            <option value="PICKUP">PICKUP</option>
                            <option value="PANEL">PANEL</option>
                            <option value="CAMION">CAMION</option>
                            <option value="PARTICULAR">PARTICULAR</option>
                            <option selected="selected" value="MOTOCICLETA">MOTOCICLETA</option>
                            <option value="MICROBUS">MICROBUS</option>
                          </SELECT>
                        </div>
                        <div class="form-group">
                          <label >Placa:</label>
                          <input type="text" name="placa" placeholder="P-000XXX" class="form-control" maxlength="11">
                        </div>
                        
                         <div class="form-group">
                                <label for="canal">Seleccione Canal:</label>
                                <SELECT  name="canal" class="form-control" id="canal"  >
                                  <?php
                                    while ($fila_canal=mysqli_fetch_array($canal)) {
                                      if ($fila_canal['canal']=='MASIVO') {
                                        $selected='selected="selected"';
                                      }
                                      echo "
                                        <option value=".$fila_canal['canal']." $selected>".$fila_canal['canal']."</option>
                                      ";
                                    }
                                  ?>
                                </SELECT>
                              </div>
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

                       
                        
                        
                           

                        
                                  <button type="submit" name="guardar" class="btn btn-success">Guardar</button>
                </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso nueva ruta******************** -->
  <!-- *************Form Editar ruta******************** -->
        <div class="modal fade" id="EditaRuta">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar ruta</h4>
              </div>
              <div class="modal-body">
                <FORM action="../../consultas/rutas_edita.php" method="POST">
                      <div class="form-group">
                          <label >Ruta:</label>
                          <input type="hidden" name="id_ruta" id="id_ruta" >
                          <select  name="ruta"  class="form-control" id="ruta" >
                            <?php
                              while ($f_r=mysqli_fetch_array($ruts_e)) {
                                echo "
                                  <option value='".$f_r['ruta']."'>".$f_r['ruta']."-".$f_r['Depto']."</option>
                                ";
                              }
                            ?>
                          </select>
                        </div>

                    
                    <div class="form-group">
                          <label >Piloto:</label>
                          <input type="text" name="piloto" id="piloto" placeholder="Piloto" class="form-control" maxlength="200">
                        </div>
                   
                  <div class="form-group">
                          <label >Tipo vehi:</label>
                          <SELECT  name="tipo" id="tipo"  class="form-control"  >
                            <option value="PICKUP">PICKUP</option>
                            <option value="PANEL">PANEL</option>
                            <option value="CAMION">CAMION</option>
                            <option value="PARTICULAR">PARTICULAR</option>
                            <option selected="selected" value="MOTOCICLETA">MOTOCICLETA</option>
                            <option value="MICROBUS">MICROBUS</option>
                          </SELECT>
                        </div>
                        <div class="form-group">
                          <label >Placa:</label>
                          <input type="text" name="placa" id="placa" placeholder="P-000XXX" class="form-control" maxlength="11">
                        </div>
                        
                         <div class="form-group">
                                <label for="canal">Seleccione Canal:</label>
                                <SELECT  name="canal" id="canal" class="form-control" id="canal"  >
                                  <?php
                                    while ($fila_canal2=mysqli_fetch_array($canal2)) {
                                      if ($fila_canal2['canal']=='MASIVO') {
                                        $selected='selected="selected"';
                                      }
                                      echo "
                                        <option value=".$fila_canal2['canal']." $selected>".$fila_canal2['canal']."</option>
                                      ";
                                    }
                                  ?>
                                </SELECT>
                            </div>
                            <div class="form-group" >
                              <label for="estado">Estado</label>
                              <select  name="estado" id="estado" class="form-control" >
                                <option>ACTIVO</option>
                                <option>INACTIVO</option>
                              </select>
                   </div>
                  <div class="modal-footer">
              
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
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
  <!-- *************Form Editar de rutas******************** -->
 <!-- *************Form ingreso nueva ruta******************** -->
    <div class="modal" id="NuevaRutas" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nueva Ruta</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="" method="" >    
                        <div class="form-group">
                          <label >Ruta:</label>
                          <input type="text" name="ruta_n" id="ruta_n" placeholder="Descripción de ruta" class="form-control" maxlength="100">
                        </div>
                    <!-- -------------------------------------------------------------------------------------------- -->
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="depto">Seleccione Sede:</label>
                              <SELECT  name="depto_n" id="depto_n" class="form-control" >
                              <?php 
                                while($fila=mysqli_fetch_row($depto_f)){
                                    echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                                }
                                  ?>
                              </SELECT>
                          </div>
                          </div>
                          <div class="col-md-6">
                            <label>Canal:</label>
                            <select class="form-control" id="tipo_canal" name="tipo_canal">
                              <option>OTROS</option>
                              <option>MASIVO</option>
                            </select>
                          </div>
                        </div>                          
                            <hr>
                      <!-- -------------------------------------------------------------------------------------------- -->

                    <!-- -------------------------------------------------------------------------------------------- -->
                          
                               <input type='reset' value='Guardar' onclick='rutas_rutanuevo();'  data-dismiss='modal' class='btn btn-success'>

                      </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso nueva ruta******************** -->
    <!-- *************Form Muestra frecuencia Masivo******************** -->
        <div class="modal fade" id="MuestraFrecuencia">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Frecuencia</h4>
              </div>
              <div class="modal-body">
                  <div id="listafreRutas"></div>

                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <!-- *************Form Editar de rutas******************** -->

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
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../../controllers/estado_rutas.js"></script>
<script src="../../controllers/ruta.js"></script>


<script>
   //Hace funcionar los componentes de la tabla
    $(function () {
    $('#example1').DataTable({'ordering'    : false})
    $('#example2').DataTable({'ordering'    : false})
    $('#example3').DataTable({'ordering'    : false})
    $('#example4').DataTable({'ordering'    : false})
    $('#example5').DataTable({'ordering'    : false})
    $('#example6').DataTable({'ordering'    : false})
    $('#tabal_rutas').DataTable()
    
  });
//actualiza galones asignados al mes
function actualizar_gal(id,gal){
        $.ajax({
            url: "../../consultas/rutas_galones.php",
            type:"POST",
            dataType:'html',
            data:{id: id, gal: gal},
            success: function(data){
                
            }
        })
    }
    $(document).on("blur", "#gal", function(
        ){
        var id=$(this).data("id_ruta");
        var gal=$(this). text();
       
        actualizar_gal(id, gal);
    })

//////////////////////////////////////////////////////////
$('#EditaRuta').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato1 = button.data('id_ruta')
      var dato2 = button.data('ruta')
      var dato3 = button.data('estado')
      var dato4 = button.data('piloto')
      var dato5 = button.data('tipo')
      var dato6 = button.data('placa')
      var dato7 = button.data('canal')
     

      var modal = $(this)
      modal.find('.modal-body #id_ruta').val(dato1)
       modal.find('.modal-body #ruta').val(dato2)
       modal.find('.modal-body #estado').val(dato3)
       modal.find('.modal-body #piloto').val(dato4)
       modal.find('.modal-body #tipo').val(dato5)
       modal.find('.modal-body #placa').val(dato6)
       modal.find('.modal-body #canal').val(dato7)
       
    })
///////////////////////////////////////////////////////Muestra datos para agregar frecuencia en caso sea masivo el canal

///////////////////////////////////////////////////////Muestra frecuencias
$('#MuestraFrecuencia').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato1 = button.data('ruta')
      var dato2 = button.data('pais')


     

      var modal = $(this)
      listafreRutas(dato1,dato2);

       
    })
</script>
</body>
</html>