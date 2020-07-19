
<?php
include("../conexion.php");
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y-m-d");

$id_prueba=$_POST['id_prueba'];


$query=mysqli_query($conexion,"UPDATE pm_pruebapiloto SET estatus='A', fecha_aprueba='$fecha_actual' WHERE id_prueba='$id_prueba'");

mysqli_close($conexion);
?>