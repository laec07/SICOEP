<?php
include("../conexion.php");
$usuario=$_POST['usuario'];
$id_canal=$_POST['id_canal'];
$accion=$_POST['accion'];

if ($accion=='add') {
	$inserta=mysqli_query($conexion,"INSERT INTO canal_usuario (USUARIO, id_canal) VALUES ('$usuario', '$id_canal')");
}else if ($accion=='delete') {
	$elimina=mysqli_query($conexion,"DELETE FROM canal_usuario WHERE USUARIO='$usuario' AND id_canal='$id_canal'");
}

?>