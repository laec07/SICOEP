<?php
include ("../../conexion.php");
session_start();
if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
}else{
$usuario=$_SESSION['usuario']['USUARIO'];
$id_ruta=$_POST['id_ruta'];
$id_depto=$_POST['id_depto'];
$id_solicitud=$_POST['id_solicitud'];

$busca=mysqli_query($conexion,"SELECT id_ruta,galones,total,asignado_gal,restantes_gal,extra_gal from combustible_detalle where id_solicitud='$id_solicitud' and id_ruta='$id_ruta'");

$dato=mysqli_fetch_array($busca);

$galones=$dato['galones'];
$total=$dato['total'];
$extra_gal=$dato['extra_gal'];
$observaciones="Se elimina datos de esta ruta con un total de: ".$total.", ".$galones." galones por ".$usuario;
$update_solicitud=mysqli_query($conexion,"UPDATE combustible_solicitud SET total_galones=total_galones-'$galones',total_efectivo=total_efectivo-'$total' where id_solicitud='$id_solicitud'");



	if ($extra_gal=='S') {
	}else{
		$update_ruta=mysqli_query($conexion,"UPDATE ruta set restantes_gal=restantes_gal+'$galones' WHERE id_ruta='$id_ruta' ");
	}

	$quita=mysqli_query($conexion,"UPDATE combustible_detalle SET galones=0,total=0,observaciones='$observaciones' where id_solicitud='$id_solicitud' AND id_depto='$id_depto' and id_ruta='$id_ruta' ");



if ($quita) {
	echo $id_solicitud;
}else{
	echo"
		
			Error al eliminar ruta, consulte con el administrador del sistema
		

	";
}
mysqli_close($conexion);
}
?>