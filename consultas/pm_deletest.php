<?php 
include'../conexion.php';

$id=$_POST['id'];

$query=mysqli_query($conexion,"UPDATE pm_pruebapiloto SET estatus='D' WHERE id_prueba='$id'");

mysqli_close($conexion);
?>