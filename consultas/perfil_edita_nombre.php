<?php
include ("../conexion.php"); 
session_start();

$nombre=$_POST['nombre'];
$usuario=$_SESSION['usuario']['USUARIO'];

if (mysqli_query($conexion,"UPDATE usuario SET NOMBRE='$nombre' WHERE USUARIO='$usuario'")) {
	echo "
	<script>
	history.go(-1);
	</script>
	";
}


?>
