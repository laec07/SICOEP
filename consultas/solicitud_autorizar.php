<?php
include("../conexion.php");
session_start();
$usuario=$_SESSION['usuario']['USUARIO'];
$id_solicitud=$_POST['id_solicitud'];
$estado=$_POST['estado'];
$motivo=$_POST['motivo'];

/*****************************************************/
$ts=mysqli_query($conexion,"SELECT sum(total) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total_e=mysqli_fetch_array($ts);
$total_efectivo=$total_e['total'];
$ts=mysqli_query($conexion,"SELECT sum(galones) as galones FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total_g=mysqli_fetch_array($ts);
$total_galones=$total_g['galones'];
/****************************************************************/

$estado_a=mysqli_query($conexion,"UPDATE combustible_solicitud SET estatus='$estado',total_efectivo='$total_efectivo',total_galones='$total_galones',descripcion='$motivo', usuario_aprueba='$usuario' where id_solicitud='$id_solicitud' ");
if ($estado_a) {
		if ($estado=='APROBADO') {//actualiza los galones disponible de ruta para despues ser restados en el query $actualiza, esto para evitar numeros negativos.
			$gal_extra=mysqli_query($conexion, "UPDATE ruta r
									INNER JOIN combustible_detalle c ON r.id_ruta = c.id_ruta and r.id_depto=c.id_depto and r.codigo_pais=c.codigo_pais
									SET r.restantes_gal = c.galones
									WHERE
										c.id_solicitud = '$id_solicitud' AND r.estado ='ACTIVO' and c.extra_gal='S'");

			$actualiza=mysqli_query($conexion,
					"UPDATE ruta r
						INNER JOIN combustible_detalle c ON r.id_ruta = c.id_ruta and r.id_depto=c.id_depto and r.codigo_pais=c.codigo_pais
						SET r.restantes_gal = r.restantes_gal - c.galones
						WHERE
							c.id_solicitud = '$id_solicitud' AND r.estado ='ACTIVO' ");		
		}


	echo"
	<script>
		alert('Solicitud procesada');
	</script>
	<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../pages/vehiculo/solicitudes.php'>
	";

}else{
	echo"
	<script>
		alert('Ocurrio un problema mientras se procesaba solicitud, intentelo más tarde o comuniquese con el administrador del sistema.');
		history.go(-1);
	</script>
	";
}

mysqli_close($conexion);

?>