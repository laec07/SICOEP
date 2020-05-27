<?php
include("../conexion.php");
session_start();
///////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
////////////////////////////////////////////
$id_depto=$_POST['id_depto'];
$descrip=$_POST['descrip'];
$ubic=$_POST['ubic'];
$empre=$_POST['empre'];
////////////////////////////////////////////
$busca=mysqli_query($conexion,"SELECT * FROM gasolinera where id_depto='$id_depto' and estatus='A' ");

$inserta=mysqli_query($conexion,"
INSERT INTO gasolinera (
  codigo_pais,
  Id_depto,
  descripcion,
  ubicacion,
  empresa,
  estatus
)
VALUES
  (
    '$pais',
    '$id_depto',
    '$descrip',
    '$ubic',
    '$empre',
    'A'
  )

  ");

if ($inserta) {
  echo "SI";

}else{
   echo "ERROR";
}






mysqli_close($conexion);
?>

  