<?php
include ("../conexion.php"); 
session_start();

$clave_nueva=$_POST['c_confirm'];
$clave_vieja=$_SESSION['usuario']['CLAVE'];
$clave_actual=$_POST['c_actual'];
$usuario=$_SESSION['usuario']['USUARIO'];
if ($clave_vieja==$clave_actual) {
	if (mysqli_query($conexion,"UPDATE usuario SET CLAVE='$clave_nueva' WHERE USUARIO='$usuario'")) {
	echo "
	<script>
	alert('Se actualizo correctamente su Clave.');
	history.go(-1);
	</script>
	";
}else{
	echo "
	<script>
	alert('Error al actualizar Clave, intentelo nuevamente.');
	history.go(-1);
	</script>
	";
}
	
}else{
	echo "
	<script>
	alert('Clave actual no coincide');
	history.go(-1);
	</script>
	";
}
/*

*/

?>
