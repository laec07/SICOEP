<?php  

include'../conexion.php';
 session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
$bs=$_POST['placa'];
$fe=$_POST['fecha'];
$ti=$_POST['tipo'];
$kl=$_POST['kilometro'];
$obs=$_POST['obser'];
$cs=$_POST['costo'];
$sfact=$_POST['serie_fact'];
$nofact=$_POST['no_fact'];
$pro=$_POST['proveedor'];
$costou=$_POST['costo_uni'];
$fechasql= date('Y-m-d', strtotime($fe));
$ID=$_POST['ide'];
/*ver variables obtenidas
while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1];
}*/
//suma la fecha ingresada en la variable $fe
$fecha = new DateTime($fe);
$fecha->add(new DateInterval('P180D'));
$f=$fecha->format('Y-m-d') . "\n";
//suma 5000 kilometros para próximo mantenimiento
$sumakil=$kl + 5000;
//$nuevafecha= date('Y-m-d', strtotime($fecha));
/*if ($ti == 'Servicio Preventivo') {
	mysqli_query($conexion, "UPDATE estado_mantenimiento set fechasugerida='$f', kilosugerido='$sumakil' where id_equipo='$bs'");
}*/ //se deja de forma manual el kilometraje del proximo mantenimiento
$resultado=mysqli_query($conexion, 
	"UPDATE mantenimiento_vehiculo 
		set Fecha='$fechasql', id_tipomantenimiento='$ti', Observaciones='$obs',  costo='$cs', serie_fact='$sfact', no_fact='$nofact', id_proveedor='$pro', costo_unitario='$costou' where ID = '$ID' "); 


if ($resultado) {
	//mysqli_query($conexion, "UPDATE vehiculo set Kilometraje='$kl' where 	Id_equipo='$bs'");
mysqli_query($conexion, "UPDATE estado_mantenimiento set km_actual='$kl' where 	Id_equipo='$bs'");



echo "
<SCRIPT LANGUAGE='javascript'> 
history.go(-1); 
</SCRIPT>

";
}else{
	echo "
<SCRIPT LANGUAGE='javascript'> 
alert('Error al actualizar datos!');
history.go(-1); 
</SCRIPT>

";
}

mysqli_close($conexion);

?>
 
