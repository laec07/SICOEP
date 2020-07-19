<?php
include ("../conexion.php"); 
session_start();

		
	
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$email =  $_POST['email'];
	$tel =  $_POST['tel'];
	$dir =  $_POST['direccion'];
	$dpi =  $_POST['dpi'];
	$lic =  $_POST['lic'];
	$tp =  $_POST['tipo'];
	$fvenci = $_POST['fecha_venci_e'];
	$experiencia_e = $_POST['experiencia_e'];	

	$sql = mysqli_query($conexion,"UPDATE usuarios set Usuario='$nombre', Correo_electronico='$email', Telefono='$tel', 	Direccion='$dir', DPI='$dpi', Licencia='$lic',	tipo='$tp',fecha_vencimiento='$fvenci', experiencia='$experiencia_e' where Id_usuario='$id'");
?>	

	 <SCRIPT LANGUAGE="javascript"> 
         
         history.go(-1);
     </SCRIPT> 
    


