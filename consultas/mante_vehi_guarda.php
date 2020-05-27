<?php  

include'../conexion.php';
 session_start();
 if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
}else{
$pais=$_SESSION['usuario']['codigo_pais'];
$bs=$_POST['idequip'];
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
$ca=mysqli_query($conexion,"SELECT
	Id_equipo,
	canal,
	Fecha,
	Estado_asig
FROM
	asignacion_vehiculo
WHERE
	Estado_asig = 'Activo'
AND Id_equipo = '$bs'");
$canal=mysqli_fetch_array($ca);
/*$rcanal=$canal['canal'];
echo  $canal['canal'];
while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1];
}*/
//suma la fecha ingresada en la variable $fe
$fecha = new DateTime($fe);
$fecha->add(new DateInterval('P180D'));
$f=$fecha->format('Y-m-d') . "\n";
//suma 5000 kilometros para próximo mantenimiento

//$nuevafecha= date('Y-m-d', strtotime($fecha));

if ($bs!='Seleccione placa..') {
	
	if ($ti!='Eliga tipo mantenimiento...') {
		if ($ti == '8') {
			$sumakil=$kl + 5000;
			mysqli_query($conexion, "UPDATE estado_mantenimiento set fechasugerida='$f', kilosugerido='$sumakil' where id_equipo='$bs'");
		}
		$resultado=mysqli_query($conexion, "INSERT INTO mantenimiento_vehiculo 
		(Id_equipo,Fecha,id_tipomantenimiento,Kilometrajem,Observaciones,costo,codigo_pais, serie_fact, no_fact, id_proveedor, costo_unitario,canal)
	 	VALUES 
	 	('$bs','$fechasql','$ti','$kl','$obs','$cs','$pais','$sfact','$nofact','$pro','$costou','".$canal['canal']."')"); 

		//mysqli_query($conexion, "UPDATE vehiculo set Kilometraje='$kl' where 	Id_equipo='$bs'");
		//mysqli_query($conexion, "UPDATE estado_mantenimiento set km_actual='$kl' where 	Id_equipo='$bs'");
		print"
        	<SCRIPT LANGUAGE='javascript'> 
            alert('mantenimiento ingresado'); 
            </SCRIPT> 
            <META HTTP-EQUIV='Refresh' CONTENT='0; URL=../pages/vehiculo/mantenimientos.php'>
            
        ";

	}
	else
	{
	print"
        <SCRIPT LANGUAGE='javascript'> 
            alert('Seleccione tipo mantenimiento');
            history.go(-1); 
            </SCRIPT> 
            
        ";	
	}
}
else{
	print"
        <SCRIPT LANGUAGE='javascript'> 
            alert('Selecciones Placa vehiculo'); 
            history.go(-1);
            </SCRIPT> 
            
        ";
}



mysqli_close($conexion);
}
?>
<!--<SCRIPT LANGUAGE="javascript"> 
            alert("Dato Guardado exitosamente"); 
            </SCRIPT> 
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../mantenimiento_vehi.php">