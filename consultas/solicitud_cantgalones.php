<?php
include("../conexion.php");
session_start();
$gal=$_POST['gal'];
$id_ruta=$_POST['id_ruta'];
$id_depto=$_POST['id_depto'];
$id_solicitud=$_POST['id_solicitud'];
/////////////////////////////////////////////
////////////////////////////////////////////////
$rt=mysqli_query($conexion,"SELECT restantes_gal FROM ruta WHERE id_ruta='$id_ruta' and estado='ACTIVO'");
$rtas=mysqli_fetch_array($rt);
$ruta=$rtas['restantes_gal'];
//////////////////////////////////////////////
if (!$_POST['motivo']) {
  mysqli_query($conexion,"UPDATE combustible_detalle
SET 
    galones='$gal',
    total=round(precio*galones),
    restantes_gal='$ruta'-'$gal'
WHERE
  id_solicitud = '$id_solicitud'
AND id_depto = '$id_depto'
AND id_ruta = '$id_ruta'");
}else{
  $motivo=$_POST['motivo'];
   $var=mysqli_query($conexion,"UPDATE combustible_detalle
    SET 
        galones='$gal',
        total=round(precio*galones),
        observaciones='$motivo',
        extra_gal='S',
        cant_extra='$gal'-restantes_gal
    WHERE
      id_solicitud = '$id_solicitud'
    AND id_depto = '$id_depto'
    AND id_ruta = '$id_ruta'");
   if ($var) {
    echo"
      <script>
        alert('nitido');
      </script>
    "; 
   }else{
    echo"
      <script>
        alert('fallo');
      </script>
    ";
   }

}





mysqli_close($conexion);
?>