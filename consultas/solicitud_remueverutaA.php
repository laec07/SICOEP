<?php
include ("../conexion.php");

$id_ruta=$_POST['id_ruta'];
$id_depto=$_POST['id_depto'];
$id_solicitud=$_POST['id_solicitud'];

$busca=mysqli_query($conexion,"SELECT id_ruta,galones,total,asignado_gal,restantes_gal,extra_gal from combustible_detalle where id_solicitud='$id_solicitud' and id_ruta='$id_ruta'");

$dato=mysqli_fetch_array($busca);

$galones=$dato['galones'];
$total=$dato['total'];
$extra_gal=$dato['extra_gal'];

$update_solicitud=mysqli_query($conexion,"UPDATE combustible_solicitud SET total_galones=total_galones-'$galones',total_efectivo=total_efectivo-'$total' where id_solicitud='$id_solicitud'");



	if ($extra_gal=='S') {
	}else{
		$update_ruta=mysqli_query($conexion,"UPDATE ruta set restantes_gal=restantes_gal+'$galones' WHERE id_ruta='$id_ruta' ");
	}

	$quita=mysqli_query($conexion,"DELETE FROM combustible_detalle where id_solicitud='$id_solicitud' AND id_depto='$id_depto' and id_ruta='$id_ruta' ");



if ($quita) {
	echo $id_solicitud;
}else{
	echo"
		
			Error al eliminar ruta, consulte con el administrador del sistema
		

	";
}
mysqli_close($conexion);
?>