<?php
	session_start();
	if (isset($_SESSION['usuario'])) {
		if($_SESSION['usuario']['TIPO'] !="Usuario"){
			header("Location:admin.php");
		}
	}else{
		header('Location:index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>usuario</title>
</head>
<body>
<h1>BIENVENIDO USUARIO <?php echo $_SESSION['usuario']['NOMBRE']?></h1>
<a href="layout.php">Cerrar sesión</a>
</body>
</html>