<?php
include ("../conexion.php"); 
session_start();

	$id = $_GET['id'];
	$foto=mysqli_query($conexion,"SELECT foto1 FROM foto_vehi where ID='$id'");
	$rfoto=mysqli_fetch_array($foto);
	$borra=$rfoto['foto1'];
		
		
		if (unlink($borra)){
			$sql = mysqli_query($conexion,"DELETE from foto_vehi where ID='$id'");	
			print"
				<SCRIPT LANGUAGE='javascript'>
	 			
	 			 history.go(-1);
	 			</SCRIPT>
	 			
	";
		}else{
			print"
				<SCRIPT LANGUAGE='javascript'>
	 			alert('Foto no encontrada')
	 			history.go(-1);
	 			</SCRIPT>
	 			
	";
		}
	
?>
