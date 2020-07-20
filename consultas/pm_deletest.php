<?php 
include'../conexion.php';

$id=$_POST['id'];

$query=mysqli_query($conexion,"UPDATE pm_pruebapiloto SET estatus='D' WHERE id_prueba='$id'");

$bsca=mysqli_query($conexion,"
SELECT Id_usuario FROM pm_pruebapiloto where id_prueba='$id'
	");

$bs=mysqli_fetch_array($bsca);
$id_piloto=$bs['Id_usuario'];

$query_piloto=mysqli_query($conexion,"UPDATE usuarios SET estado='ACTIVO' WHERE Id_usuario='$id_piloto'");



mysqli_close($conexion);
?>