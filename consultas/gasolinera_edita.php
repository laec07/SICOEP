<?php
include("../conexion.php");
session_start();
///////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
////////////////////////////////////////////
$id_gasolinera_e=$_POST['id_gasolinera_e'];
$id_depto_e=$_POST['id_depto_e'];
$descripcion_e=$_POST['descripcion_e'];
$ubicacion_e=$_POST['ubicacion_e'];
$empresa_e=$_POST['empresa_e'];
////////////////////////////////////////////
$edita=mysqli_query($conexion,"
UPDATE gasolinera
SET Id_depto = '$id_depto_e',
 descripcion = '$descripcion_e',
 ubicacion = '$ubicacion_e',
 empresa = '$empresa_e'
WHERE
  id_gasolinera = '$id_gasolinera_e'
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

  