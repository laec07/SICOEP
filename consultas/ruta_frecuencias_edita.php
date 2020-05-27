<?php
include("../conexion.php");

$ruta=$_POST['ruta'];
$texto=$_POST['texto'];
$campo=$_POST['campo'];
$pais=$_POST['pais'];
$frec=$_POST['frec'];

$actualiza=mysqli_query($conexion,"UPDATE rutas_frecuencia SET $campo='$texto' WHERE ruta='$ruta' AND frecuencia='$frec' AND codigo_pais='$pais'");

if ($actualiza) {
	echo "Actualizado";
}else{
	echo "Error".mysqli_error($conexion);
}
?>