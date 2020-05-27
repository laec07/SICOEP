<?php
include("../../conexion.php");
////////////////////////////////////////////
$id_solicitud=$_POST['ID'];
////////////////////////////////////////////
  mysqli_query($conexion,"DELETE FROM combustible_detalle where id_solicitud='$id_solicitud'");
  mysqli_query($conexion,"DELETE FROM combustible_solicitud where id_solicitud='$id_solicitud'");
mysqli_close($conexion);
?>