<?php
session_start();
  if(isset($_SESSION['usuario'])){

     header('Location: ../home.php');
  }

if (isset($_COOKIE['usuario']) AND isset($_COOKIE['clave'])) {
  require '../../conexion.php';
    $usuario=$_COOKIE['usuario'];
  $clave=$_COOKIE['clave'];
/**************************************************/
$usuarios= mysqli_query($conexion,
  "SELECT 
    NOMBRE, 
    USUARIO, 
    CLAVE, 
    TIPO, 
    codigo_pais, 
    Id_depto, 
    cod_area, 
    id_empresa,
    foto 
  FROM 
    usuario 
  WHERE 
    USUARIO = '$usuario' 
  AND CLAVE = '$clave'
  ");

if($usuarios-> num_rows == 1){ 
  $datos = $usuarios->fetch_assoc();
  $_SESSION['usuario'] = $datos;
  session_start();
header('Location: ../home.php');

}else{
  echo"
  <script>
  alert('Los datos de inicio de sesión cambiaron desde la última vez que ingreso.');
  </script>
  header('Location: layout.php');
  ";
}
;

}
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login página ticket">
    <meta name="author" content="Luis Estrada">

    <title>Ticket | LOGIN </title>


<!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <link rel="shortcut icon" href="../../dist/img/logo.ico" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

</style>
<body id="page-top" class="index">
   <style >
   .error{
    background-color: #fff;
    position: relative;
    top: 0;
    padding: 10px 0 ;
    border-radius:  0 0 5px 5px;
    color: #000000;
    width: 100%;
    text-align: center;
    display: none;
}


</style>
    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom" style="background: #dd4b39;">
        <div class="container">
            <div class="error">
              <span>Datos no válidos, intentelo de nuevo por favor</span>
            </div>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll" >
                
                <a class="navbar-brand" href="#page-top"><h4 style="color: white;">SISTEMA TICKET -CRECE- </h4></a>
            </div>
            <div class="page-scroll navbar-right">
                        <a href="../../" style="color: white;"><span class="icon-display"></span> Salir </a>
                    </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            
            <!-- /.navbar-collapse -->

        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>



    </header>
   
<body>

<div class="login-box">
  <div class="login-logo">
    <br>
    <br>

  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login:</p>

    <form  method="POST" id="formlg">
      <div class="form-group has-feedback">
        <input name="usuariolog" id="usuariolog" class="form-control" placeholder="Usuario" maxlength="25" autofocus="" value="<?php if(isset($_COOKIE['clave'])){echo $_COOKIE['clave']; }?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" pattern="[A-Za-z0-9_-]{1,15}" name="passlg" id="passlg" placeholder="contraseña" value="<?php if(isset($_COOKIE['clave'])){echo $_COOKIE['clave']; }?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
         
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>





  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery -->
   <script src="jquery-3.2.1.js"></script>
<script src="jquery-3.2.1.min.js"></script>
<script src="login.js"></script>

   
     <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!--<h3>Location</h3>-->
                        
                      
                    </div>
                    
       
            <div class="container">
                <div class="row">
                    
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
