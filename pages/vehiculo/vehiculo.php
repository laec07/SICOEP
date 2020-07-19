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
$cont = date('Y') + 1;
$cont2 = date('Y') + 1;
/*******************************************************************************************/
$datos_empresa=mysqli_query($conexion,"SELECT * FROM empresa where id_empresa='$em'");
$empresa=mysqli_fetch_array($datos_empresa);
$pais=$_SESSION['usuario']['codigo_pais'];
/*******************************************************************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
/********************************************************************************************************/
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/********************************************************************************************************/
$vehiculo=mysqli_query($conexion, "SELECT v.*,f.foto1 FROM   vehiculo v LEFT JOIN foto_vehi f ON f.id_equipo=v.Id_equipo where v.codigo_pais='$pais' and v.Estado_equipo in ('ASIGNADO','ACTIVO') GROUP BY v.Id_equipo");
$depto=mysqli_query($conexion,"SELECT Depto FROM depto JOIN asignacion ON depto.Id_depto = asignacion.Id_depto");
/**********************************************************************************************************/ 
$prop=mysqli_query($conexion, "SELECT * FROM propietario_vehiculo where codigo_pais='$pais'");
$prop2=mysqli_query($conexion, "SELECT * FROM propietario_vehiculo where codigo_pais='$pais'");
$sedes=mysqli_query($conexion,"SELECT * FROM depto where Tipo='SEDE' AND codigo_pais='$pais' AND usa_vehi='S'");
?>
<!DOCTYPE html>
<!--

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
      <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. . -->
  <link rel="stylesheet" href="../../dist/css/skins/skin-red.min.css">
  <link rel="shortcut icon" href="../../dist/img/logo.ico" />

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
         <!--Dashboard    -->
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
       <!--Vehiculo    -->
        <li class="active"><a href="vehiculo.php"><i class="fa fa-car"></i><span>Vehículos</span></a></li>
        <!--pilotos    -->
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
        
        <!--Asignaciones    -->
        <li><a href="asignaciones.php"><i class="fa fa-edit"></i><span>Asignaciones</span></a></li>
        <!--Mantenimientos    -->
        <li><a href="mantenimientos.php"><i class="fa fa-wrench"></i><span>Mantenimientos</span></a></li>
        <!--Combustible    -->
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
        <!--Configuración    -->
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
        <!--Nuevo    -->
        <!--/Nuevo    -->
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
          <a href="" class="btn btn-primary" data-target='#NuevoVehi' data-toggle='modal' title="Agregar nuevo vehículo"><i class="fa fa-plus"></i> Nuevo</a>
        </div>
      </div>
    </section>
    <!-- Main content -->

    <section class="content container-fluid">
      <!--------------------------***************************************************************************************************************
        | Your Page Content Here |
        ------------------------------------------------------------------------------------------------------------------------------------->
<style >
  table tbody tr .punter:hover{
  box-shadow: inset 0 0 10px #000 ;
  cursor: pointer; 
}
</style>

<ul class="nav nav-tabs">
  <li class="active">
    <a href="#show_inventory" data-toggle="tab">Inventario</a> 
  </li>
  <!--<li>Opcion sin terminar, se deshabilita
    <a href="#show_tires" data-toggle="tab">Llantas</a>
  </li>-->
</ul>


<div class="tab-content">
  <div class="tab-pane fade in active" id="show_inventory"> <!--- Panel 1-->
         <div class="box">
          <div class="box-header">
            <h3 class="box-title">Vehículos</h3>
            <a href="vehiculo_excel.php" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i></a>
          </div>
          <div class="box-body">
            <div style="overflow:scroll;height:100%;width:100%;">
            <table  id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th >Placa</th>
                    <th >Tipo</th>
                    <th >Estado</th>
                    <th >Tipo gas.</th>
                    <th >Kilometraje</th>
                    <th >IZ. D.</th>
                    <th >DER. D.</th>
                    <th >IZ. T.</th>
                    <th >DER. T.</th>   
                    <th>Poliza</th>  
                   <th>Vin</th> 
                    <th ><span class="glyphicon glyphicon-wrench"></span></th>
                  </tr>
                </thead>
                <tbody>
                   <?php 
                      $suma=0;
                      while($rvehiculo=mysqli_fetch_array($vehiculo)){

                        if ($rvehiculo['Estado_equipo']=='ACTIVO') {
                          $clase_l="class='label label-success'";
                          $btn_react="";
                        }else if ($rvehiculo['Estado_equipo']=='ASIGNADO') {
                          $clase_l="class='label label-warning'";
                          $btn_react="";
                        }else if ($rvehiculo['Estado_equipo']=='BAJA') {
                          $clase_l="class='label label-danger'";
                          $btn_react="<a class='btn btn-primary' title='Reactivar Vehículo' href=../../consultas/vehi_reactivar.php?placa=".$rvehiculo['Id_equipo'].">
                            <SPAN class='glyphicon glyphicon-text-background '>
                            </SPAN>
                          </a>";
                        }

                        if ($rvehiculo['foto1']=="") {
                          $rvehiculo['foto1']='../../consultas/files/vacio.jpg';
                        }else{
                         $rvehiculo['foto1']='../../consultas/'.$rvehiculo['foto1'];
                        }

                      echo "
                      <tr  >
                        <td class='punter' onclick=location='vehi_ficha.php?placa=".$rvehiculo['Id_equipo']."' title='Ficha vehiculo' ><img src='".$rvehiculo['foto1']."' width='60px' > </img><br>".$rvehiculo['Id_equipo']." </td>
                        <td>".$rvehiculo['Marca']."</br><small>".$rvehiculo['Equipo']."</small></br><small>".$rvehiculo['Modelo']."</small></td>
                        <td><label $clase_l>".$rvehiculo['Estado_equipo']."</label></td>
                        <td>".$rvehiculo['combustible']."</td>
                        <td>".$rvehiculo['Kilometraje']."</td>
                        <td>".$rvehiculo['llanta_iz_delantera']."%</td>
                        <td>".$rvehiculo['llanta_der_delantera']."%</td>
                        <td>".$rvehiculo['llanta_iz_trasera']."%</td>
                        <td>".$rvehiculo['llanta_der_trasera']."%</td> 
                        <td>".$rvehiculo['poliza']." </td>
                        <td>".$rvehiculo['chasis_vin']."</td>                    
                        <td>
                          <a class='btn btn-warning' title='Editar' data-target='#EditaVehi' data-toggle='modal' 
                          data-id='".$rvehiculo['Id_equipo']."'
                          data-nom='".$rvehiculo['Equipo']."'
                          data-mar='".$rvehiculo['Marca']."'
                          data-modelo_a='".$rvehiculo['Modelo']."'
                          data-combustible='".$rvehiculo['combustible']."'
                          data-kilo='".$rvehiculo['Kilometraje']."'
                          data-poliza='".$rvehiculo['poliza']."'
                          data-chasis='".$rvehiculo['chasis_vin']."'
                          data-d_iz='".$rvehiculo['llanta_iz_delantera']."'
                          data-t_iz='".$rvehiculo['llanta_iz_trasera']."'
                          data-d_de='".$rvehiculo['llanta_der_delantera']."'
                          data-t_de='".$rvehiculo['llanta_der_trasera']."'
                          >
                            <SPAN class='glyphicon glyphicon-pencil '>
                            </SPAN>
                          </a>

                          <a class='btn btn-info' title='Fotos' href=vehi_foto.php?placa=".$rvehiculo['Id_equipo'].">
                            <SPAN class='glyphicon glyphicon-camera '>
                            </SPAN>
                          </a>

                          <a class='btn btn-success' title='Accesorios' href=vehi_accesorios.php?placa=".$rvehiculo['Id_equipo'].">
                            <SPAN class='glyphicon glyphicon-list '>
                            </SPAN>
                          </a>

                          <a class='btn btn-primary' title='Subir archivos' href=vehi_archivos.php?placa=".$rvehiculo['Id_equipo'].">
                            <SPAN class='fa fa-cloud-upload'>
                            </SPAN>
                          </a>
                          
                          <a class='btn btn-danger' title='Baja' data-toggle='modal' data-target='#BajaVehi'
                            data-id_b='".$rvehiculo['Id_equipo']."'>
                            <SPAN class='glyphicon glyphicon-trash '>
                            </SPAN>
                          </a>



                          $btn_react
                        </td>
                      </tr>
                      ";
                      }
                      $numero=mysqli_num_rows($vehiculo);
                  ?>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
        </div> 
      </div>  
  </div> <!--- ./ Panel 1-->
  <div class="tab-pane fade" id="show_tires"><!--- / Panel 2-->
    <div class="box">
      <div class="box-header">
        
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <label>Sede:</label>
            <select class="form-control" id="select_sede">
              <option>Seleccione sede</option>
          <?php
          while ($row_sede=mysqli_fetch_array($sedes)) {
            echo "
              <option value='".$row_sede['Id_depto']."'>".$row_sede['Depto']."</option>
            ";
          }
          ?>
            </select>
          </div>
          <div class="col-md-4">
            <div id="select_placa">
              <label>placas:</label>
              <select class="form-control">
                <option>Seleccione placa</option>
              </select>
            </div>
          </div>
        </div>
        <div id="hllantas"></div>
      </div>
    </div>
    
  </div><!--- ./ Panel 2-->
</div>



        
    </section>
    <!-- /.Finaliza content ---------------------------------------------------->
  </div>
  <!-- /.content-wrapper -->
  <!--Inicia ventanas emergentes ------------------------------------->
 <!-- *************Form ingreso vehiculo******************** -->
        <div class="modal fade" id="NuevoVehi">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo vehículo</h4>
              </div>
              <div class="modal-body">
                <FORM action="../../consultas/ingreso_vehiculo.php" method="POST">
                  <div class="form-group">
                    <label for="nom">Tipo</label>
                    <SELECT required="" name="nom" id="nom" onchange="tipo();" class="form-control">
                      <option value="0">Tipo...</option>
                      <option value="PICKUP">PICKUP</option>
                      <option value="PANEL">PANEL</option>
                      <option value="CAMION">CAMION</option>
                      <option value="PARTICULAR">PARTICULAR</option>
                      <option value="MOTOCICLETA">MOTOCICLETA</option>
                      <option value="MICROBUS">MICROBUS</option>
                    </SELECT>
                  </div>
                
                   <div class="form-group" >
                    <label for="Id">Placa</label>
                    <input required="" name="placa" id="placa" placeholder="Placa" maxlength="10" class="form-control">
                   </div>
                   <div class="form-group" >
                    <label for="mar">Marca/modelo</label>
                      <input required="" name="mar" placeholder="Marca/Modelo" class="form-control">
                   </div>
                   <div class="form-group" >
                    <label for="modelo">Año</label>
            
                       <select name="modelo" class="form-control">
                          <?php while ($cont >= 1990) { ?>
                            <option ><?php echo($cont); ?></option>
                              <?php $cont = ($cont-1); } ?> 
                        </select>
                   </div>
                   <div class="form-group" >
                    <label for="combustible">Tipo combustible</label>
                     <select  name="combustible" class="form-control" >
                      <option>GASOLINA</option>
                      <option>DIESEL</option>
                      <option>GAS</option>
                      <option>GAS/GASOLINA</option>
                     </select>
                   </div>
                   <div class="form-group">
                    <label for="kilo">Kilometraje</label>
                     <input type="number" name="kilo" placeholder="Kilometraje"  min="1" max="9000000" class="form-control">
                   </div>
                   <div class="form-group">
                    <label for="propietario">Propietario</label>
                     <select name="propietario" class="form-control" >
                          <?php
                          while ($propietario=mysqli_fetch_row($prop)) {
                              echo "
                                  <option value=".$propietario[0].">".$propietario[2]."</option>
                              ";
                          }
                          ?>
                      </select>
                   </div>
                   <div class="form-group">
                     <input type="text"  name="poliza" placeholder="Poliza" maxlength="20" class="form-control">
                   </div>
                   <div class="form-group">
                     <input type="text"  name="chasis" placeholder="Chasis/VIN" maxlength="20" class="form-control">
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
  <!-- *************Form Baja de vehículos******************** -->
  <div class="modal fade" id="BajaVehi">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Baja Vehículo</h4>
              </div>
              <div class="modal-body">
                <FORM action="../../consultas/vehi_baja.php" method="GET">
                  
                
                   <div class="form-group" >
                    <label for="Id">Placa</label>
                    <input required="" name="ID" id="ID_b" placeholder="Placa" maxlength="10" class="form-control" readonly="">
                   </div>
                   <div class="form-group">
                    <label for="chasis">Motivo:</label>
                     <select id="motivo" name="motivo" class="form-control">
                      <option>VENDIDO</option>
                      <option>OTROS</option> 
                     </select>
                   </div>
                   <div class="form-group">
                    <label for="chasis">Precio venta::</label>
                    <div class="input-group">
                      <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                     <input type="number"  name="p_venta" id="p_venta" step="0.01" placeholder="0.00" class="form-control">
                   </div>
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
   <!-- *************Form Editar vehiculo******************** -->
        <div class="modal fade" id="EditaVehi">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Vehículo</h4>
              </div>
              <div class="modal-body">
                <FORM action="../../consultas/editar_vehiculo.php" method="POST">
                  <div class="form-group">
                    <label for="nom">Tipo</label>
                    <SELECT required="" name="nom" id="nom" class="form-control" disabled >
                      <option value="0">Tipo...</option>
                      <option value="PICKUP">PICKUP</option>
                      <option value="PANEL">PANEL</option>
                      <option value="CAMION">CAMION</option>
                      <option value="PARTICULAR">PARTICULAR</option>
                      <option value="MOTOCICLETA">MOTOCICLETA</option>
                      <option value="MICROBUS">MICROBUS</option>
                    </SELECT>
                  </div>
                
                   <div class="form-group" >
                    <label for="Id">Placa</label>
                    <input required="" name="Id" id="Id" placeholder="Placa" maxlength="10" class="form-control" readonly="">
                   </div>
                   <div class="form-group" >
                    <label for="mar">Marca/modelo</label>
                      <input required="" name="mar" id="mar" placeholder="Marca/Modelo" class="form-control" >
                   </div>
                   <div class="form-group" >
                    <label for="modelo">Año</label>
                       <select name="modelo" id="modelo_a" class="form-control">
                          <?php while ($cont2 >= 1990) { ?>
                            <option ><?php echo($cont2); ?></option>
                              <?php $cont2 = ($cont2-1); } ?>   
                        </select>
                   </div>
                   <div class="form-group" >
                    <label for="combustible">Tipo combustible</label>
                     <select  name="combustible" id="combustible" class="form-control" >
                      <option>GASOLINA</option>
                      <option>DIESEL</option>
                      <option>GAS</option>
                      <option>GAS/GASOLINA</option>
                     </select>
                   </div>
                   <div class="form-group">
                    <label for="kilo">Kilometraje<!--<a href="mantenimientos_alertas.php"><label class="label-warning btn" title="Kilometraje se edita en alertas mantenimiento"><span class="fa fa-question"></span> </label></a>--></label>
                     <input type="number" name="kilo" id="kilo"  min="0" max="9000000" class="form-control" readonly="" title="Kilometraje se edita en alertas mantenimientos">
                   </div>
                   <div class="form-group">
                    <label for="propietario">Propietario</label>
                     <select name="propietario" class="form-control" id="propietario" >
                          <?php
                          while ($propietario2=mysqli_fetch_row($prop2)) {
                              echo "
                                  <option value=".$propietario2[0].">".$propietario2[2]."</option>
                              ";
                          }
                          ?>
                      </select>
                   </div>
                   <div class="form-group">
                    <label for="poliza">Poliza</label>
                     <input type="text"  name="poliza" id="poliza" maxlength="20" class="form-control">
                   </div>
                   <div class="form-group">
                    <label for="chasis">Chasis</label>
                     <input type="text"  name="chasis" id="chasis" maxlength="20" class="form-control">
                   </div>

                   <div class="box  box-default collapsed-box">
                     <div class="box-header">
                       <h4>Llantas</h4>
                       <div class="box-tools pull-right">
                         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                       </div>
                     </div>
                     <div class="box-body">
                       <div class="row">
                         <div class="col-md-3">
                           <label>D. Izquierda</label>
                          
                           <div class="input-group">
                             <input type="number" name="d_iz" id="d_iz" class="form-control">
                             <div class="input-group-addon">
                               <i>%</i>
                             </div>
                           </div>
                           
                         </div>
                         <div class="col-md-3">
                           <label>D. Derecha</label>
                           <div class="input-group">
                            <input type="number" name="d_de" id="d_de" class="form-control">
                             <div class="input-group-addon">
                               <i>%</i>
                             </div>
                           </div>
                           
                         </div>
                         <div class="col-md-3">
                           <label>T. Izquierda</label>
                           <div class="input-group">
                            <input type="number" name="t_iz" id="t_iz" class="form-control">
                             <div class="input-group-addon">
                               <i>%</i>
                             </div>
                           </div>
                           
                         </div>
                         <div class="col-md-3">
                           <label>T. Derecha</label>
                           <div class="input-group">
                            <input type="number" name="t_de" id="t_de" class="form-control">
                             <div class="input-group-addon">
                               <i>%</i>
                             </div>
                           </div>
                           
                         </div>
                       </div>
                     </div>
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
  <!-- *************Form Editar de vehículos******************** -->
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
<!-- Proceso bd -->
<script src="../../controllers/vehiculo.js"></script>
<script>
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
  })

    function tipo(){
        var tp= document.getElementById('nom').value;
            if (tp=='MOTOCICLETA') {
                tps='M-'
            }
            else if (tp=='CAMION') {
                tps='C-'
            } else   {
                tps='P-'
            }            
            document.getElementById('Id').value=tps; 
    }

    $('#EditaVehi').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato1 = button.data('id')
      var dato2 = button.data('nom')
      var dato3 = button.data('mar')
      var dato4 = button.data('modelo_a')
      var dato5 = button.data('combustible')
      var dato6 = button.data('kilo')
      var dato7 = button.data('poliza')
      var dato8 = button.data('chasis')
      var dato9 = button.data('d_iz')
      var dato10 = button.data('t_iz')
      var dato11 = button.data('d_de')
      var dato12 = button.data('t_de')

      var modal = $(this)
      modal.find('.modal-body #Id').val(dato1)
       modal.find('.modal-body #nom').val(dato2)
       modal.find('.modal-body #mar').val(dato3)
       modal.find('.modal-body #modelo_a').val(dato4)
       modal.find('.modal-body #combustible').val(dato5)
       modal.find('.modal-body #kilo').val(dato6)
       modal.find('.modal-body #poliza').val(dato7)
       modal.find('.modal-body #chasis').val(dato8)
       modal.find('.modal-body #d_iz').val(dato9)
       modal.find('.modal-body #t_iz').val(dato10)
       modal.find('.modal-body #d_de').val(dato11)
       modal.find('.modal-body #t_de').val(dato12)
    })

    $('#BajaVehi').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato1 = button.data('id_b')
      

      var modal = $(this)
      modal.find('.modal-body #ID_b').val(dato1)
       
    })


</script>
</body>
</html>