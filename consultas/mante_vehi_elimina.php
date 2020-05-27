<?php
include ("../conexion.php"); 
session_start();

	$ID = $_GET['ID'];
	
		
		
		$delete=mysqli_query($conexion,"DELETE FROM mantenimiento_vehiculo where ID='$ID'");
		print"
				<SCRIPT LANGUAGE='javascript'>
	 			 history.go(-1);
	 			</SCRIPT>";
	 			
	
	
?>
