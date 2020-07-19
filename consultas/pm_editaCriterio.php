<?php
include("../conexion.php");
session_start();
///////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
////////////////////////////////////////////
$id_criterio=$_POST['id_criterio'];
$descripcion=$_POST['descripcion'];
$calificacion=$_POST['calificacion'];
$estado=$_POST['estado'];
////////////////////////////////////////////
$edita=mysqli_query($conexion,"
UPDATE pm_criterio
SET descripcion = '$descripcion',
 calificacion = '$calificacion',
 estatus = '$estado'
WHERE
	id_criterio = '$id_criterio'
  ");

if ($edita) {
  echo "
    Actualizado correctamente
  ";

}else{
   echo "
    Error en la actualización, verifique!!
  ";
}

mysqli_close($conexion);
?>

  