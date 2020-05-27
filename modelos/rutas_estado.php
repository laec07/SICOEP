<?php
include("../conexion.php");
$id_ruta=$_POST['id_ruta'];
$opcion=$_POST['opcion'];

$actualiza=mysqli_query($conexion,"UPDATE ruta set estado='$opcion' where id_ruta='$id_ruta'");


mysqli_close($conexion);
?>