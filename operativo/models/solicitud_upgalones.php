<?php
include("../../conexion.php");
$opcion=$_POST['opcion'];
$id_ruta=$_POST['id_ruta'];
$id_depto=$_POST['id_depto'];
$id_solicitud=$_POST['id_solicitud'];
////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
$dt=mysqli_query($conexion,"SELECT id_precio,super,regular,diesel,gas,fecha FROM precio_combustible where id_solicitud='$id_solicitud'");
$dato=mysqli_fetch_array($dt);
if ($opcion==1) {
	$precio=$dato['super'];
	
}else if ($opcion==2) {
	$precio=$dato['regular'];
	
}else if($opcion==3){
	$precio=$dato['diesel'];
	
}else if($opcion==4){
	$precio=$dato['gas'];
	
}
///////////////////////////////////////////////////////////////
$ts=mysqli_query($conexion,"SELECT sum(total) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total=mysqli_fetch_array($ts);
///////////////////////////////////////////////////////////////
///se agrega consulta para IDP////
$cidp=mysqli_query($conexion,"
SELECT
	*
FROM
	tipo_combustible
WHERE
	id_tipocombustible = '$opcion'
 ");
$ridp=mysqli_fetch_array($cidp);
$idp=$ridp['idp'];
echo $idp ;
////////////////////////////////////
mysqli_query($conexion,"UPDATE combustible_detalle
SET 
	id_tipocombustible ='$opcion',
	precio='$precio',
	total=round(precio*galones),
	idp=$idp*galones,
	total_sin_idp=total-idp,
	base=total_sin_idp/1.12
WHERE
  id_solicitud = '$id_solicitud'
AND id_depto = '$id_depto'
AND id_ruta = '$id_ruta'");
?>