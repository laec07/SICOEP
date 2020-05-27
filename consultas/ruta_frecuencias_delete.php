<?php
include("../conexion.php");

$pais=$_SESSION['usuario']['codigo_pais'];
$frecuencia=$_POST['frecuencia'];
$ruta=$_POST['ruta'];
$pais=$_POST['pais'];

$borra=mysqli_query($conexion,"DELETE FROM rutas_frecuencia WHERE (ruta='$ruta') AND (frecuencia='$frecuencia') AND (codigo_pais='$pais')");

?>