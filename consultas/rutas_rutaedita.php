<?php
include("../conexion.php");
session_start();
if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
}else{
$id_ruta=$_POST['id_ruta'];
$ruta=$_POST['ruta'];
$sede=$_POST['sede'];
$canal=$_POST['canal'];



$edita=mysqli_query($conexion,"
UPDATE rutas
SET ruta = '$ruta',
 Id_depto = '$sede',
 canal='$canal'
 
WHERE
    id = '$id_ruta'

    ");

mysqli_close($conexion);
} 

?>