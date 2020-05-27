<?php
include("../conexion.php");
session_start();
///////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
////////////////////////////////////////////
$id_gasolinera=$_POST['id_gasolinera'];

////////////////////////////////////////////
$edita=mysqli_query($conexion,"
UPDATE gasolinera
SET estatus='I'
WHERE
  id_gasolinera = '$id_gasolinera'
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

  