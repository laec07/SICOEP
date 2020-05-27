<?php
include ("../conexion.php");
session_start();
$pais=$_SESSION['usuario']['codigo_pais'];

$prove=$_POST['prove'];
$telefono=$_POST['telefono'];
$contacto=$_POST['contacto'];
$cel_contacto=$_POST['cel_contacto'];

$inserta=mysqli_query($conexion,"INSERT proveedor (proveedor,telefono,contacto,cel,cod_pais) values ('$prove','$telefono','$contacto','$cel_contacto','$pais')");
if ($inserta) {
	echo "
	<script>
	history.go(-1);
	</script>


	";
}else{
	echo "
	<script>
	alert('Error al ingresar proveedor');
	history.go(-1);
	</script>
	";
}


?>