<?php
include ("../conexion.php");

$id_ruta=$_POST['id_ruta'];
$id_depto=$_POST['id_depto'];
$id_solicitud=$_POST['id_solicitud'];
$gal=$_POST['gal'];

$actualiza=mysqli_query($conexion,"UPDATE combustible_detalle SET extra_gal='N' WHERE id_solicitud='$id_solicitud' AND id_depto='$id_depto' AND id_ruta='$id_ruta' ");
$restante

if ($quita) {
	echo $id_solicitud;
}else{
	echo"
		<script>
			alert('Error al eliminar ruta, consulte con el administrador del sistema');
		</script>

	";
}
mysqli_close($conexion);
?>