<?php
include("../conexion.php");
session_start();
///////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
////////////////////////////////////////////
$id_solicitud=$_POST['id_solicitud'];
////////////////////////////////////////////
$ts=mysqli_query($conexion,"SELECT sum(total) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total_e=mysqli_fetch_array($ts);
$total_efectivo=$total_e['total'];

$ts=mysqli_query($conexion,"SELECT sum(galones) as galones FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total_g=mysqli_fetch_array($ts);
$total_galones=$total_g['galones'];

$actualiza=mysqli_query($conexion,"UPDATE combustible_solicitud SET estatus='PENDIENTE',total_efectivo='$total_efectivo',total_galones='$total_galones' WHERE id_solicitud='$id_solicitud'");

if ($actualiza) {
  echo "
  <script>
  alert('Solicitud procesada satisfactoriamente');
  </script>
  <META HTTP-EQUIV='Refresh' CONTENT='0; URL=../pages/vehiculo/solicitudes.php'>
  ";

}else{
   echo "
  <script>
  alert('No fue posible procesar la solicitud, puede seguir editando la solicitud');
  </script>
  <META HTTP-EQUIV='Refresh' CONTENT='0; URL=../pages/vehiculo/solicitudes.php'>
  ";
}
mysqli_close($conexion);
?>

  