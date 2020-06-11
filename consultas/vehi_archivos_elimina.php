<?php
include ("../conexion.php"); 
session_start();

	$id = $_POST['id'];
	$foto=mysqli_query($conexion,"SELECT * FROM vehi_archivo where ID='$id'");

	$rfoto=mysqli_fetch_array($foto);
	$borra=$rfoto['file'];
		
		
		if (unlink($borra)){
			$sql = mysqli_query($conexion,"DELETE from vehi_archivo where ID='$id'");	
			print"
				eliminado correcctamente
	";
		}else{
			print"
fallo ";
		}
	
?>
