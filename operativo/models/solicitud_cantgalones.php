<?php

include("../../conexion.php");
$gal=$_POST['gal'];
$id_ruta=$_POST['id_ruta'];
$id_depto=$_POST['id_depto'];
$id_solicitud=$_POST['id_solicitud'];
/////////////////////////////////////////////
//////////////////////////////////////////////
////////////////////////////////////////////////
$rt=mysqli_query($conexion,"SELECT restantes_gal FROM ruta WHERE id_ruta='$id_ruta'");
$rtas=mysqli_fetch_array($rt);
$ruta=$rtas['restantes_gal'];
//////////////////////////////////////////////
///se agrega consulta para IDP////
$cidp=mysqli_query($conexion,"
SELECT
  tc.idp
FROM
  tipo_combustible tc
INNER JOIN combustible_detalle cd ON tc.id_tipocombustible = cd.id_tipocombustible
WHERE
  cd.id_solicitud = '$id_solicitud'
AND cd.id_ruta = '$id_ruta'
AND id_depto = '$id_depto'
 ");
$ridp=mysqli_fetch_array($cidp);
$idp=$ridp['idp'];
////////////////////////////////////
if (!$_POST['motivo']) {
  mysqli_query($conexion,"UPDATE combustible_detalle
SET 
    galones='$gal',
    total=round(precio*galones),
    restantes_gal='$ruta'-'$gal',
    idp=$idp*$gal,
    total_sin_idp=total-idp,
    base=total_sin_idp/1.12
WHERE
  id_solicitud = '$id_solicitud'
AND id_depto = '$id_depto'
AND id_ruta = '$id_ruta'");
}else{
  if ($ruta>=$gal) {
    mysqli_query($conexion,"UPDATE combustible_detalle
SET 
    galones='$gal',
    total=round(precio*galones),
    restantes_gal='$ruta'-'$gal',
    idp=$idp*$gal,
    total_sin_idp=total-idp,
    base=total_sin_idp/1.12
WHERE
  id_solicitud = '$id_solicitud'
AND id_depto = '$id_depto'
AND id_ruta = '$id_ruta'");
  }else{
    $motivo=$_POST['motivo'];
   mysqli_query($conexion,"UPDATE combustible_detalle
SET 
    galones='$gal',
    idp='$idp'*'$gal',
    total=round(precio*galones),
    observaciones='$motivo',
    extra_gal='S',
    cant_extra='$gal'-restantes_gal,
    total_sin_idp=total-idp,
    base=total_sin_idp/1.12
WHERE
  id_solicitud = '$id_solicitud'
AND id_depto = '$id_depto'
AND id_ruta = '$id_ruta'");
  }
  
}
?>