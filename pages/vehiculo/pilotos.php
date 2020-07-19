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
$fecha_actual= Date("Y-m-d");

/**********************************************************************************************************/ 

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
       
        <li ><a href="vehiculo.php"><i class="fa fa-car"></i><span>Vehículos</span></a></li>
        <li class="active"><a href="pilotos.php"><i class="fa fa-user"></i><span>Pilotos</span></a></li>
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
            <small>Piloto</small>
          </h3>
        </div>
         <div class="col-md-1">
          <a href="" class="btn btn-info" data-target="#nuevoUsu" data-toggle='modal' title="Nuevo Piloto"><i class="fa fa-plus"></i> Piloto</a>
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
            <h3 class="box-title">Pilotos</h3>
          </div>
          <div class="box-body">
            <div style="overflow:scroll;height: 100%  ">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                  <th colspan="2" >Piloto</th>
                  
                 
                  <th><?php echo $rps['doc'];?></th>
                  <th>Licencia</th>
                  <th>Tipo</th>
                  <th><span class="glyphicon glyphicon-wrench"></span></th>
                </tr>   
                </thead>

                  
              <?php
                  $consulta= mysqli_query($conexion,"SELECT * FROM usuarios where tipo_usu='Piloto' and codigo_pais='$pais' and (estado='ACTIVO' or estado ='ASIGNADO')");
                while ($fila = mysqli_fetch_row($consulta)) 
                  { 
                  if (empty($fila[14])) {
                            $fila[14]='files/vacio2.jpg';
                          };
                    if (empty($fila[12])) {
                            $fila[12]='files/id_card.png';
                            };
                    if (empty($fila[13])) {
                              $fecha='';
                              $label='';
                              $titulo='';
                            }else{
                              $fecha=date_format(New datetime($fila[13]),"d/m/Y");

                              if ($fila[13]<=$fecha_actual ) {
                                $label="class='label label-danger'";
                                $titulo="title='Piloto con lincencia vencida'";
                              }else if ($fila[13]>$fecha_actual and $fila[13]<= date("Y-m-d",strtotime($fecha_actual."+ 2 month"))  ){
                                $label="class='label label-warning'";
                                $titulo="title='Queda menos de dos meses para renovación de licencia'";
                              }else if ($fila[13]>$fecha_actual) {
                               $label="class='label label-success'";
                                $titulo="title='Licencia activa'";
                              }
                              
                            }        
                    echo "<tr>";
                    echo "<td>
                            <div class='div-imagen'>
                              
                                <div >
                                  <a data-target='#editPick' data-toggle='modal' title='Editar' data-id_piloto='" .$fila[0] ."' >
                                    <p>Editar</p>
                                  </a>
                                </div>

                                <a  href='../../consultas/".$fila[14]."' data-lightbox='roadtrip'>
                                    <img  src='../../consultas/$fila[14]' >
                                </a>
                            </div>
                          </td>

                    <td>$fila[1]<br><b>E-mail: </b>$fila[2]<br><b>Tel.: </b>$fila[3]<br><b>Dir.: </b>$fila[4]</td>
                    <td>$fila[5]</td>
                    <td>
                      <div class='div-imagen'>
                        <div >
                          <a data-target='#editLic' data-toggle='modal' title='Editar' data-id_piloto='" .$fila[0] ."' >
                            <p>Editar</p>
                          </a>
                        </div>
                          <a  href='../../consultas/".$fila[12]."' data-lightbox='roadtrip'>
                            <img  src='../../consultas/$fila[12]' >
                          </a>
                      </div>
                      $fila[6]<br>
                      <label $label $titulo>".$fecha."</label>
                    </td>
                    <td>$fila[8] <br>$fila[15] Años</td>";  
                    echo"<td>";           
                      echo "<a data-toggle='modal' data-target='#editUsu' 
                               data-id='" .$fila[0] ."' 
                               data-nombre='" .$fila[1] ."' 
                               data-email='" .$fila[2] ."' 
                               data-tel='" .$fila[3] ."'
                               data-direccion='" .$fila[4] ."' 
                               data-dpi='" .$fila[5] ."'
                               data-lic='" .$fila[6] ."'
                               data-tipo='" .$fila[8] ."' 
                               data-fecha_venci='".$fila[13]."'
                               data-experiencia_e='".$fila[15]."' 

                               class='btn btn-warning'><span class='glyphicon glyphicon-pencil'></span></a> ";      
                    echo "<a class='btn btn-danger' href='../../consultas/piloto_elimina.php?id=" .$fila[0] ."' onclick=\"return confirm('¿Esta seguro de  eliminar al piloto ".$fila[1] ." ? ')\" ><span class='glyphicon glyphicon-remove'></span></a>";   
                    echo "</td>";
                    echo "</tr>";
                  }
                  $consulta->close();
      
            
      
  

?>
          </table>
            </div>
          </div><!--Termina box body-->
        </div>
        

    </section>
    <!-- /.Finaliza content ---------------------------------------------------->
  </div>
  <!-- /.content-wrapper -->
  <!--Inicia ventanas emergentes ------------------------------------->
 <!-- *************Form ingreso piloto******************** -->
      
    <div class="modal" id="nuevoUsu" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nuevo Piloto</h4>                       
                    </div>
                    <div class="modal-body">
                       <form action="../../consultas/piloto_insertar.php" method="GET">                  
                          <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input class="form-control" id="nombre" required="" name="nombre" type="text" placeholder="Nombre" maxlength="50" ></input>
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
                        
                        <option>Seleccione tipo licencia</option>
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

              <input type="submit" class="btn btn-success" value="Guardar"></input>
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso pilotos******************** -->
    <!-- *************Form Edita pilotos******************** -->
        <div class="modal" id="editUsu" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Editar Piloto</h4>
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
                        <option>Tipo Licencia...</option>

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
                          <input type="date" name="fecha_venci_e" id="fecha_venci_e" class="form-control"  ?>">
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
  <!-- *************./Form ingreso fotos******************** --> 
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
<!-- ligthbox -->
<script src="../../dist/js/lightbox.js"></script>


<script >
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
  })

//trae datos para editar usuario
 $('#editUsu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('id')
      var recipient1 = button.data('nombre')
      var recipient2 = button.data('email')
      var recipient3 = button.data('direccion')
      var recipient4 = button.data('tel')
      var recipient5 = button.data('dpi')
      var recipient6 = button.data('lic')
      var recipient7 = button.data('tipo')
      var recipient8 = button.data('fecha_venci')
      var recipient9 = button.data('experiencia_e')

      var modal = $(this)    
      modal.find('.modal-body #id').val(recipient0)
      modal.find('.modal-body #nombre').val(recipient1)
      modal.find('.modal-body #email').val(recipient2)
      modal.find('.modal-body #direccion').val(recipient3)  
      modal.find('.modal-body #tel').val(recipient4)
      modal.find('.modal-body #dpi').val(recipient5)
      modal.find('.modal-body #lic').val(recipient6)
      modal.find('.modal-body #tipo').val(recipient7)
      modal.find('.modal-body #fecha_venci_e').val(recipient8)
      modal.find('.modal-body #experiencia_e').val(recipient9)   
    });
//tae datos para guardar foto
 $('#editPick').on('show.bs.modal',function(event){
  var button = $(event.relatedTarget)
  var dato0 = button.data('id_piloto')

  var modal = $(this)
  modal.find('.modal-body #id_piloto').val(dato0)

 });
  $('#editLic').on('show.bs.modal',function(event){
  var button = $(event.relatedTarget)
  var dato0 = button.data('id_piloto')

  var modal = $(this)
  modal.find('.modal-body #id_piloto').val(dato0)

 });
//Visualizar imagen piloto
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
    function filePreview(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e){
          $('#imagePreview2').html("<img src='"+e.target.result+"'/ class= 'img2'>");
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#files2').change(function(){
      filePreview(this);
    })
  })();
</script>  
</body>
</html>