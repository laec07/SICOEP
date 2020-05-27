<?php
include ("../conexion.php"); 
session_start();
if(isset($_SESSION['usuario']))
{
	$id = $_GET['id'];
	$row=mysqli_query($conexion, "SELECT Id_usuario FROM asignacion_vehiculo where Id_usuario='$id' and Estado_asig='ACTIVO'");
	if($row-> num_rows >= 1){
		print"
        <SCRIPT LANGUAGE='javascript'> 
            alert('Usuario tiene uno o más asignaciones, no es posible eliminarlo');
            history.go(-1); 
            </SCRIPT> 
            
        ";
	}else{
		
	$sql = mysqli_query($conexion,"UPDATE usuarios SET estado='BAJA' where Id_usuario='$id'");	
	print"
        <SCRIPT LANGUAGE='javascript'> 
            alert('Piloto dado de baja');
            history.go(-1); 
            </SCRIPT> 
            
        ";
	}
}
else
	{
			print"
        <SCRIPT LANGUAGE='javascript'> 
            alert(No tiene permisos para realizar esta acción');
            history.go(-1); 
            </SCRIPT> 
            
        ";
	}		 

?>