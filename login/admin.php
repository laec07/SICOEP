<?php
	session_start();
	if (isset($_SESSION['usuario'])) {
		if($_SESSION['usuario']['TIPO'] !="Administrador"){
			header("Location:usuario.php");
		}
	}else{
		header('Location:index.php');
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>admin</title>
</head>
<body>
<H1>BIENVENIDO ADMINISTRADOR: <?php echo $_SESSION['usuario']['NOMBRE']?></H1>
<a href="layout.php">Cerrar sesión</a>

</body>
</html>