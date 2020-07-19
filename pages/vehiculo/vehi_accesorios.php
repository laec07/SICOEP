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
/**********************************************************************************************************//*Datos de los accesorios*/ 
$acc=mysqli_query($conexion,"SELECT 
  Id_accesorio,
  fecha_ingreso AS fecha,
  id_equipo
FROM
  accesorios
WHERE
  id_equipo = '$placa'
GROUP BY
  fecha
ORDER BY
  fecha desc
  ");
/***********************************************************************************************************//*Datos para la foto*/
$f_vehi=mysqli_query($conexion,"SELECT 
  v.id_equipo,
v.Marca,
v.Modelo,
  v.codigo_pais,
  f.foto1,
  f.fecha
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


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

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
        <div class="col-md-8">
          <h3>
            <?php echo $empresa['empresa']; ?>
            <small>ACC. VEHICULO</small>
          </h3>
        </div>
        
         
                     
                        
                     
        
        <div class="col-md-2" >
    
            <img src="../../consultas/<?php echo $foto_vehi['foto1'] ?>" HEIGHT=80 />
            
            <p><font size="5"><?php echo $foto_vehi['id_equipo']; ?><br></font> <?php echo $foto_vehi['Marca']; ?>
          <?php echo $foto_vehi['Modelo']; ?></p>
                
                  
                
              
              
          
          </ul>
          
          
        </div>
         <div class="col-md-1">
          <a href="" class="btn btn-info" data-target='#AccVehi' data-toggle='modal' title="Agregar nuevo vehículo"><i class="fa fa-plus"></i> Nuevo</a>
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
            <h3 class="box-title">Accesorios vehículo</h3>
          </div>
          <div class="box-body">
            
              
            
            <!--insertar aca php-->
            <?php
            
            while ($fila=mysqli_fetch_array($acc)) {
              $i=1;
              $fe=$fila['fecha'];
              echo "
              <div class='box box-default collapsed-box'>
                <div class='box-header with-border'><!--empieza encabezado-->
                  <h3 class='box-title'>".date_format(new Datetime($fila['fecha']),'d-m-Y')."</h3>
                  <div class='box-tools pull-right'>
                    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-plus'></i>
                    </button>
                  </div>
                </div><!--Termina encabezado--->
                <div class='box-body'>
                <div style='overflow: scroll; width: 100%'>
                <table class ='table table-hover'>
                ";
                  $acc_lista=mysqli_query($conexion, "SELECT accesorios, ID, fecha_ingreso AS fecha FROM lista_accesorios JOIN accesorios ON lista_accesorios.Id_accesorio = accesorios.Id_accesorio WHERE accesorios.Id_equipo = '$placa' AND fecha_ingreso = '$fe' ");
                while ( $row=mysqli_fetch_array($acc_lista)) {
                  if($i==1)
                    echo "<tr><td>".$row['accesorios']."</td><td><a title='Eliminar' href='../../consultas/elimina_acc.php?ID=" .$row['ID'] ."' ><span class='fa fa-trash'></span></a></td>";
                  if($i==2)
                    echo "<td>".$row['accesorios']."</td><td><a title='Eliminar' href='../../consultas/elimina_acc.php?ID=" .$row['ID'] ."' ><span class='fa fa-trash'></span></a></td>";
                  if($i==3){
                    echo "<td>".$row['accesorios']."</td><td><a title='Eliminar' href='../../consultas/elimina_acc.php?ID=" .$row['ID'] ."' ><span class='fa fa-trash'></span></a></td></tr>";
                      $i=0;}
                  $i++;
                }
                if($i==1)
                echo "</table>";

                if($i==2)
                 echo "<td></td><td></td></tr></table>";

                if($i==3)
                 echo "<td></td></tr></table>"; 


                
               echo"
               </table>
               </div>
              </div>
               ";
                
              
            }
           

           ?>
           <!--finalizar aca php-->
            
          </div>
          </div>
        </div>
        

    </section>
    <!-- /.Finaliza content ---------------------------------------------------->
  </div>
  <!-- /.content-wrapper -->
  <!--Inicia ventanas emergentes ------------------------------------->
 <!-- *************Form ingreso fotos******************** -->
        <div class="modal fade" id="AccVehi">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Revisión de accesorios</h4>
              </div>
              <div class="modal-body">
                <FORM  action="../../consultas/validarchekbox.php"  method="POST">
                  <input type="text" name="equip" value="<?php echo $placa?>" style="display: none;" >
                  <button  name="guardar" type="submit" class="btn btn-primary btn-block">GUARDAR</button> 
                  <h4>ACCESORIOS</h4> 
                  <br />
              <!--Sección colapsada para categorías accesorios-------------------------------------------->
                  <div class='box box-default collapsed-box'>
                    <div class='box-header with-border'><!--empieza encabezado-->
                      <h3 class="box-title">Interior</h3>
                      <div class="box-tools pull-right"> 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" >
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                      <input type="checkbox" name="checkbox[]" value="2"  />
                        <label  for="checkbox[]" ><p>Espejo interior</p></label><br> 
                     
                     <label>
                      <input type="checkbox" name="checkbox[]" value="4" />
                      Tablero</label><br>
                      
                      <label>
                      <input type="checkbox" name="checkbox[]" value="5" />
                      Reloj</label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="6" />
                      Guanteras</label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="8" />
                      Perilla de mangos</label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="11" />
                      LLave</label><br>

                      <label>
                        <input type="checkbox" name="checkbox[]" value="12" />
                        Tarjeta de circulación</label><br>
                    
                      <label>
                        <input type="checkbox" name="checkbox[]" value="13" />
                        Descansa brazos</label><br>
                     
                      <label>
                        <input type="checkbox" name="checkbox[]" value="14" />
                        Parasoles</label><br>
                       
                      <label>
                        <input type="checkbox" name="checkbox[]" value="15" />
                        Manecilla puerta interna</label><br>
                     
                      <label>
                        <input type="checkbox" name="checkbox[]" value="16" />
                        Manecilla puerta externa</label><br>
                    
                      <label>
                        <input type="checkbox" name="checkbox[]" value="17" />
                        Manecilla de vidrios</label><br>
                       
                      <label>
                        <input type="checkbox" name="checkbox[]" value="18" />
                        Cinturon de seguridad</label><br>
                      
                      <label>
                        <input type="checkbox" name="checkbox[]" value="19" />
                        Aire acondicionado</label><br>
                     
                      <label>
                        <input type="checkbox" name="checkbox[]" value="20" />
                        Vidrios ruidos</label><br>
                      
                      <label>
                        <input type="checkbox" name="checkbox[]" value="21" />
                        Vidrios móviles</label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="39" />
                      Mangos</label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="40" />
                      Alfombra</label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="41" />
                        Cenicero</label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="42" />
                        Encendedor</label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="47" />
                        Controles &eacute;lectricos vidrios </label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="50" />
                        Seguros de puerta </label><br>
                      <label>

                      <input type="checkbox" name="checkbox[]" value="52" />
                        Acientos</label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="53" />
                        Manecillas acientos </label><br>

                      <label>
                      <input type="checkbox" name="checkbox[]" value="62" />
                        Extinguidor</label><br>
                  
                    </div>
                  </div>
              <!--/Sección colapsada para categorías accesorios-------------------------------------------->      
              <!--Sección colapsada para categorías accesorios-------------------------------------------->
                  <div class='box box-default collapsed-box'>
                    <div class='box-header with-border'><!--empieza encabezado-->
                      <h3 class="box-title">Exterior</h3>
                      <div class="box-tools pull-right"> 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" >
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">

                  <label>
                    <input type="checkbox" name="checkbox[]" value="3" />
                    Espejo exterior</label><br>
                  <label>
                    <input type="checkbox" name="checkbox[]" value="22" />
                    Bomper</label><br> 
                  <label>
                    <input type="checkbox" name="checkbox[]" value="29" />
                    Parilla bomper</label><br>
                  <label>
                    <input type="checkbox" name="checkbox[]" value="30" />
                    Emblemas</label><br> 
                  <label>
                    <input type="checkbox" name="checkbox[]" value="31" />
                    Parrilla techo</label><br>
                      <label>
                      <input type="checkbox" name="checkbox[]" value="35" />
                      Chapas</label><br> 
                      <label>
                      <input type="checkbox" name="checkbox[]" value="36" />
                        Bateria</label><br>
                      <label>
                      <input type="checkbox" name="checkbox[]" value="37" />
                        Tapa combustible </label><br>
                      <label>
                      <input type="checkbox" name="checkbox[]" value="38" />
                        Tapa aceite </label><br>
                     
                      
                  
                    </div>
                  </div>
              <!--/Sección colapsada para categorías accesorios-------------------------------------------->  
               <!--Sección colapsada para categorías accesorios-------------------------------------------->
                  <div class='box box-default collapsed-box'>
                    <div class='box-header with-border'><!--empieza encabezado-->
                      <h3 class="box-title">Luces</h3>
                      <div class="box-tools pull-right"> 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" >
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                                      
                      <label>
                        <input type="checkbox" name="checkbox[]" value="7" />
                        Perilla control de luces en volante</label><br>
                      
                      
                       
                      <label>
                        <input type="checkbox" name="checkbox[]" value="9" />
                        Botón Hazzar</label><br>
                      <label>
                        <input type="checkbox" name="checkbox[]" value="23" />
                        Luces delantera</label><br>
                      
                      <label>
                        <input type="checkbox" name="checkbox[]" value="24" />
                        Luces stop</label><br>
                       
                      <label>
                        <input type="checkbox" name="checkbox[]" value="25" />
                        Luces pidevia derecho delantera</label><br>
                    
                      <label>
                        <input type="checkbox" name="checkbox[]" value="26" />
                        Luces pidevia izquierdo delantera</label><br>
                     
                      <label>
                        <input type="checkbox" name="checkbox[]" value="27" />
                        Luces pidevia izquierdo trasero</label><br>
                     
                      <label>
                        <input type="checkbox" name="checkbox[]" value="28" />
                        Luces pidevia derecho trasero</label><br>                  
                      
                  
                    </div>
                  </div>
              <!--/Sección colapsada para categorías accesorios-------------------------------------------->
              <!--Sección colapsada para categorías accesorios-------------------------------------------->
                  <div class='box box-default collapsed-box'>
                    <div class='box-header with-border'><!--empieza encabezado-->
                      <h3 class="box-title">Audio</h3>
                      <div class="box-tools pull-right"> 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" >
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                      <label>
                        <input type="checkbox" name="checkbox[]" value="10" />
                        Bocina</label><br> 
                      <label>
                        <input type="checkbox" name="checkbox[]" value="32" />
                        Control remoto CD Player</label><br> 
                          <label>
                          <input type="checkbox" name="checkbox[]" value="43" />
                            CD player o radio </label><br> 
                     
                          <label>
                          <input type="checkbox" name="checkbox[]" value="44" />
                            Mixer</label><br> 
                     
                          <label>
                          <input type="checkbox" name="checkbox[]" value="45" />
                            Power</label><br> 
                     
                          <label>
                          <input type="checkbox" name="checkbox[]" value="46" />
                            Microfono</label><br> 
                          <label>
                          <input type="checkbox" name="checkbox[]" value="48" />
                            Cables de sonido </label><br> 
                    
                          <label>
                          <input type="checkbox" name="checkbox[]" value="49" />
                            Espigas audio </label><br> 
                    
                          <label>
                          <input type="checkbox" name="checkbox[]" value="51" />
                            Bocinas internas </label>  <br>                     
                     
                    </div>
                  </div>
              <!--/Sección colapsada para categorías accesorios-------------------------------------------->
              <!--Sección colapsada para categorías accesorios-------------------------------------------->
                  <div class='box box-default collapsed-box'>
                    <div class='box-header with-border'><!--empieza encabezado-->
                      <h3 class="box-title">Herramientas/Repuestos</h3>
                      <div class="box-tools pull-right"> 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" >
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                      

                      <input type="checkbox" name="checkbox[]" value="33" />
                        Cables pasa corriente</label><br> 
                  
                          <label>
                          <input type="checkbox" name="checkbox[]" value="34" />
                          LLanta de repuesto</label><br> 
                    
                          <label>
                          <input type="checkbox" name="checkbox[]" value="54" />
                            Triangulo</label><br> 
                     
                          <label>
                          <input type="checkbox" name="checkbox[]" value="55" />
                            Cono</label><br> 
                    
                          <label>
                          <input type="checkbox" name="checkbox[]" value="56" />
                            Gato manual </label><br> 
                     
                          <label>
                          <input type="checkbox" name="checkbox[]" value="57" />
                            Llave de gato </label><br> 
                      
                          <label>
                          <input type="checkbox" name="checkbox[]" value="58" />
                            Llave para tuercas llanta </label><br> 
                    
                          <label>
                          <input type="checkbox" name="checkbox[]" value="59" />
                          Destornilladores</label><br> 
                     
                          <label>
                          <input type="checkbox" name="checkbox[]" value="60" />
                            Llave cruz </label><br> 
                    
                          <label>
                          <input type="checkbox" name="checkbox[]" value="61" />
                            Llave L o plegable para llantas </label><br> 
                          <label>
                          <input type="checkbox" name="checkbox[]" value="63" />
                            Polea llanta de repuesto </label><br> 
                   
                          <label>
                          <input type="checkbox" name="checkbox[]" value="64" />
                            Tenaza</label><br> 
                     
                      
                  
                    </div>
                  </div>
              <!--/Sección colapsada para categorías accesorios-------------------------------------------->
              <!--Sección colapsada para categorías accesorios-------------------------------------------->
                  <div class='box box-default collapsed-box'>
                    <div class='box-header with-border'><!--empieza encabezado-->
                      <h3 class="box-title">Llantas</h3>
                      <div class="box-tools pull-right"> 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" >
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                     
                            <label>Estado llanta delantera izquierda %</label>
                            <input type="number" name="idel" required="" class="form-control">
                             <label>Estado llanta delantera derecha %</label>
                            <input type="number" name="ddel" required="" class="form-control">
                             <label>Estado llanta trasera izquierda %</label>
                            <input type="number" name="itra" required="" class="form-control">
                             <label>Estado llanta trasera derecha %</label>
                            <input type="number" name="dtra" required="" class="form-control" >                     
                      
                  
                    </div>
                  </div>
              <!--/Sección colapsada para categorías accesorios-------------------------------------------->
              <div class="form-group" >
                <label for="obs">Observaciones:</label>
                <textarea name="obs" class="form-control"></textarea> 
              </div>
          

              <div class="form-group">
                <label for="kilometraje">Kilometraje actual</label>
                <input type="text" name="kilometraje" placeholder="kilometraje actual..." class="form-control">
              </div>
          
          
   
  
    <button  name="guardar" type="submit" class="btn btn-primary btn-block">GUARDAR</button>
  </FORM>
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
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


</body>
</html>