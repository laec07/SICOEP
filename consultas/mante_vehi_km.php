<?php
include ("../conexion.php"); 
$placa=$_POST['placa'];
$km=$_POST['km'];

$actualiza=mysqli_query($conexion,"UPDATE estado_mantenimiento SET kilosugerido='$km' WHERE id_equipo='$placa'");
if ($actualiza) {
	print"
				<SCRIPT LANGUAGE='javascript'>
	 			 alert('Actualizado correctamente');
	 			</SCRIPT>";
}else{
	print"
				<SCRIPT LANGUAGE='javascript'>
	 			 alert('Error al actualizar');
	 			</SCRIPT>";
}		
	
mysqli_close($conexion);	
?>
