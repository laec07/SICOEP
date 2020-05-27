<?php
include("../conexion.php");
$id_ruta=$_POST['id'];
$gal=$_POST['gal'];
$actualiza=mysqli_query($conexion,"UPDATE ruta SET asignado_gal='$gal' WHERE id_ruta='$id_ruta'");

$b=mysqli_query($conexion,"SELECT restantes_gal FROM ruta where id_ruta='$id_ruta'");
$busca=mysqli_fetch_array($b);
$restante=$busca['restantes_gal'];
if ($restante == 0 ) {
	mysqli_query($conexion,"UPDATE ruta SET restantes_gal='$gal' WHERE id_ruta='$id_ruta'");
}



mysqli_close($conexion);
?>