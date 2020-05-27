<?php
include ("../../conexion.php");

$id_ruta=$_POST['id_ruta'];
$id_depto=$_POST['id_depto'];
$id_solicitud=$_POST['id_solicitud'];
$ruta=$_POST['ruta'];
$piloto=$_POST['piloto'];

$busca=mysqli_query($conexion,"SELECT * FROM ruta WHERE ruta='$ruta' and estado='ACTIVO'");
$dtb=mysqli_fetch_array($busca);
$restante=$dtb['restantes_gal'];
$asignado=$dtb['asignado_gal'];
$asignacion=$dtb['id_ruta'];

if ($busca -> num_rows > 1) {//si existe mas de dos
	echo"
		<script>
			alert('Existen más de 1 ruta ".$ruta."' en estado ACTIVO, verifique!!);
		</script>

	";	
}else if ($busca -> num_rows == 0){//si no existe
	echo"
		<script>
			alert('La ruta ".$ruta." no tiene asignacion en estado ACTIVO, verifique!!');
		</script>

		";	
}else if ($busca -> num_rows == 1){//realizar operacion si datos son correctos
	//busca asignacion de ruta para no volverla a ingresar
	$busca_asignacion=mysqli_query($conexion,"SELECT * from ruta where piloto='$piloto' AND id_depto='$id_depto' and ruta='$ruta'");
	///////////////***************
	if ($busca_asignacion-> num_rows ==1) {
		
		# si encuentra solo actualiza
		$actualiza_asignacion=mysqli_query($conexion,"UPDATE ruta SET restantes_gal='$restante',asignado_gal='$asignado' where piloto='$piloto' AND id_depto='$id_depto' and ruta='$ruta' ");
		$bda=mysqli_fetch_array($busca_asignacion);
		$id_asignacion=$bda['id_ruta'];

	}else{

		# Si no encuentra inserta	
		$inserta=mysqli_query($conexion,"INSERT ruta
		SELECT 0,'$ruta',id_equipo,piloto,canal,tipo_vehi,codigo_pais,id_depto,NULL,usuario,'$asignado',NULL,'$restante' FROM ruta WHERE ruta='EMERGENTE' and piloto='$piloto' and estado='ACTIVO'
		");
		if ($inserta) {
			$d=mysqli_query($conexion,"SELECT id_ruta from ruta order by id_ruta desc limit 1");
			$rd=mysqli_fetch_array($d);
			$id_asignacion= $rd['id_ruta'];
		}else{
			echo"
				<script>
					alert('No fue posible insertar la nueva asignacion, verifique!!);
				</script>

		";
		}

	}
	///////////////***************
	$inserta_detalle=mysqli_query($conexion,"INSERT combustible_detalle
												SELECT id_solicitud,id_depto,'$id_asignacion',fecha,Id_equipo,galones,tipo_combustible,id_precio,precio,total,usuario,codigo_pais,'$asignado','$restante',canal,'$ruta','Ruta Emergente cubre ruta ".$ruta."','','' from combustible_detalle WHERE id_solicitud='$id_solicitud' and id_ruta='$id_ruta'
								");
	if ($inserta_detalle) {
		$quita_emergente=mysqli_query($conexion,"DELETE FROM combustible_detalle where id_solicitud='$id_solicitud' AND id_depto='$id_depto' and id_ruta='$id_ruta' ");
		$quita_rutacubierta=mysqli_query($conexion,"DELETE FROM combustible_detalle where id_solicitud='$id_solicitud' AND id_depto='$id_depto' and id_ruta='$asignacion' ");
	}

}

mysqli_close($conexion);
?>