<?php 
include'../conexion.php';

$id=$_POST['id'];

$query=mysqli_query($conexion,"UPDATE usuarios SET tipo_usu='Piloto', estado='ACTIVO' WHERE Id_usuario='$id'");

mysqli_close($conexion);
?>