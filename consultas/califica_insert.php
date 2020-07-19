<?php
include("../conexion.php");

$id_prueba=$_POST['id_prueba'];
$id_pregunta=$_POST['id_pregunta'];
$opcion=$_POST['opcion'];


$actualiza=mysqli_query($conexion,"
UPDATE pm_pruebapiloto_detalle
SET total = '$opcion'
WHERE
	id_prueba = '$id_prueba'
AND id_pregunta = '$id_pregunta'

	");

mysqli_close($conexion);
?>