<?php
include("../conexion.php");
$usuario=$_POST['usuario'];
$id_permiso=$_POST['id_permiso'];
$accion=$_POST['accion'];

if ($accion=='add') {

	$inserta=mysqli_query($conexion,"INSERT INTO permiso_usuario (id_permiso, usuario) VALUES ('$id_permiso', '$usuario')");

}else if ($accion=='delete') {

	$elimina=mysqli_query($conexion,"DELETE FROM permiso_usuario WHERE usuario='$usuario' AND id_permiso='$id_permiso'");
}

?>