<?php
session_start();
  if(isset($_SESSION['usuario'])){
    if($_SESSION['usuario']['TIPO'] == "Administrador"){
      header('Location: ../menu.php');  
    } else if ($_SESSION['usuario']['TIPO'] == "Admin_carros") {
      header('Location: ../pages/vehiculo/');
    }
  }

if (isset($_COOKIE['usuario']) AND isset($_COOKIE['clave'])) {
  require 'conexion.php';
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
 if($_SESSION['usuario']['TIPO'] == "Admin_equipo"){
      header('Location: ../../menu_equip.php');  
    } else if ($_SESSION['usuario']['TIPO'] == "Admin_carros") {
      header('Location: ../pages/vehiculo/');
    }

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
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SICOEP</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    
    <link rel="stylesheet"  href="css/font.css">
    <link rel="shortcut icon" href="img/logo.ico" />
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

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
    background-color: #E74F4F;
    position: relative;
    top: 0;
    padding: 10px 0 ;
    border-radius:  0 0 5px 5px;
    color: #fff;
    width: 100%;
    text-align: center;
    display: none;
}

* {
  
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  user-select:none;
}

body {
  
  
}
footer {
  background-color: white;
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 40px;
  color: black;
}

.login {
  position: relative;
  top: 50%;
  left: 50%;
  margin: -10rem 0 0 -10rem;
  width: 25rem;
  height: 25rem;
  padding: 3em;
  background: hsla(255,255%,255%,1);
  border-radius: 50%;
  overflow: hidden;
  transition:all 1s ease;
}
.login:hover > .header, .login.clicked > .header {
  width: 2rem;
}
.login:hover > .header > .text, .login.clicked > .header > .text {
  font-size: 1rem;
  -webkit-transform: rotate(-90deg);
  transform: rotate(-90deg);
}
.login.loading > .header {
  width: 20rem;
  transition:all 1s ease;
}
.login.loading > .header > .text {
  display: none;
}
.login.loading > .header > .loader {
  display: block;
}
.header {
  position: absolute;
  left: 0;
  top: 0;
  z-index: 1;
  width: 25rem;
  height: 25rem;
  background: hsla(0, 5%, 0%, 1);
  transition: width 0.5s ease-in-out;
}
.header > .text {
  display: block;
  width: 100%;
  height: 100%;
  font-size: 5rem;
  text-align: center;
  line-height: 20rem;
  color: hsla(255,255%,255%,1);
  transition: all 0.5s ease-in-out;
}
.header > .loader {
  display: none;
  position: absolute;
  left: 5rem;
  top: 5rem;
  width: 10rem;
  height: 10rem;
  border-left: 10px solid hsla(255, 255%, 255%, 1);
  border-bottom:10px solid hsla(255,255%,255%,1);
  border-right:10px solid hsla(255,255%,255%,1);
  border-top: 8px solid hsla(255,255%,255%,1);
  border-radius: 50%;
  box-shadow:inset 2px 2px 2px 2px hsla(0, 5%, 0%, 1);
  animation: loading 2s linear infinite;
}
.header > .loader:after {
  content: "";
  position: absolute;
  left: 4.15rem;
  top: -0.5rem;
  width: 1rem;
  height: 1rem;
  background: hsla(1, 75%, 55%, 1);
  border-radius: 50%;
  border-right: 1px solid hsla(1, 75%, 55%, 1);
  
}
.header > .loader:before {
  content: "";
  position: absolute;
  left: 3.4rem;
  top: -0.5rem;
  width: 0;
  height: 0;
  border-right: 1rem solid hsla(1, 75%, 55%, 1);
  border-top: 0.5rem solid transparent;
  border-bottom: 0.5rem solid transparent;
}

@keyframes loading {
  50% {
  border-left: 10px solid hsla(1, 95%, 25%, 1);
  border-bottom:10px solid hsla(1, 95%, 25%, 1);
  border-right:10px solid hsla(1, 95%, 25%, 1);
  border-top:8px solid hsla(1, 95%, 25%, 1);  
  }

  100% {
    transform: rotate(360deg);
  }
}


.input {
  display: block;
  width: 100%;
  font-size: 2rem;
  padding: 0.5rem 1rem;
  box-shadow: none;
  border-color: hsla(0, 5%, 0%, 1);
  border-width: 0 0 3px 0;
  transition: all .5s ease-in;
  outline:transparent;
  color: #000;
}
.input + .input {
  margin: 10px 0 0;
}
.input:focus {
  border-bottom: 3px solid hsla(1, 75%, 55%, 1);
}

.btn {
  position: absolute;
  right: 7.8rem;
  bottom: 3rem;
  width: 4rem;
  height: 4rem;
  border: none;
  background: hsla(255, 255%, 255%, 1);
  font-size: 0;
  border: none;
  transition: all 0.3s ease-in-out;
}
.btn:after {
  content: "";
  position: absolute;
  left: 1.4rem;
  top: 1rem;
  width: 0;
  height: 0;
  border-left: 1.6rem solid hsla(1, 75%, 55%, 1);
  border-top: .8rem solid transparent;
  border-bottom: .8rem solid transparent;
  transition: border 0.3s ease-in-out 0s;
}
.btn:hover, .btn:focus, .btn:active {
  outline: none;
  
}
.btn:hover:after, .btn:focus:after, .btn:active:after {
  border-left-color: hsla(0, 5%, 0%, 1);
}
.resetbtn{
  margin:1%;
  border:none;
  padding:.5em;
  width:5em;
  background:hsla(0,0%,0%,1);
  color:hsla(255,255%,255%,1);
  font-size:1.5em;
  border-radius:2px;
  transition:all 1s ease-in-out;
  outline:none;
  box-shadow:0 0 1px 1px hsla(0,0%,0%,0.2);
}
.resetbtn:hover, .resetbtn:focus{
  background:hsla(255,255%,255%,1);
  color:hsla(0,0%,0%,1);
  outline:5px solid hsla(0,0%,0%,1);
}
.form label{
color: 000000;
}

</style>

<div id="skipnav" ><a href="#maincontent">Skip to main content</a></div>

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom" style="background: #dd4b39;">
        <div class="container">
        <div class="error">
          <span>Datos no válidos, intentelo de nuevo por favor</span>
        </div>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll" >
                
                <a class="navbar-brand" href="#page-top"><h4 style="color: white;">SISTEMA ACTIVOS -CRECE- </h4></a>
            </div>
            <div class="page-scroll navbar-right">
                        <a href="../../help.php" style="color: white;"><span class="icon-display"></span> Ayuda!!</a>
                    </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>

        <div class="container" id="maincontent" tabindex="-1">
            <div class="row">
                <div class="col-lg-12">

                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                
                
            
                

                    <div class="login" style="">
                        <header class="header">
                            <img class="img-responsive"   src="img/claro.png" alt="">

                            <span class="loader"></span>
                            
                        </header>
                        <form class="form" id="formlg"  name="formlg">  
                            <input class="input" type="text", name="usuariolog"  placeholder="Username" value="<?php if(isset($_COOKIE['usuario'])){echo $_COOKIE['usuario']; }?>">
                            <input class="input" type="password", name="passlg" pattern="[A-Za-z0-9_-]{1,15}", placeholder="Password" value="<?php if(isset($_COOKIE['clave'])){echo $_COOKIE['clave']; }?>">
                            
                            <!--<label style="color: #000000;" ><input type="checkbox" name="remember"><small >Recuerdame</small></label>-->
                            <button class="btn" type="submit"></button>
                         </form>
                    </div>
                    
                    <div class="intro-text" align="center">
                        <h1 class="name">SICOEP</h1>
                        <hr class="star-light">
                        <span class="skills">Inventario - Mantenimiento - Control equipo - Vehículos</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
   
<body>


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
                        
                        &#169; 2017 by laec
                    </div>
                    
       
            <div class="container">
                <div class="row">
                    
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
