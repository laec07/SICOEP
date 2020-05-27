<?php
include('../../conexion.php');
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
} 
date_default_timezone_set('America/Guatemala');
$usuario=$_SESSION['usuario']['USUARIO'];
$area=$_SESSION['usuario']['cod_area'];
$pais=$_SESSION['usuario']['cod_pais'];
$fecha_actual= Date('Y-m-d');
$ID=$_POST['ID'];
$obs=mysqli_query($conexion,"SELECT * FROM tarea WHERE ID='$ID'");
$tarea=mysqli_query($conexion,"
					UPDATE tarea
					SET
						estatus='PENDIENTE',
						cod_area='$area',
						usuario_asignado='$usuario',
						usuario_asigno='$usuario'
					WHERE
						ID='$ID'

					");
if ($tarea) {
	$mov=mysqli_query($conexion,"
					INSERT mov_tarea
					(ID_tarea,estatus,usuario,cod_area)
					values
					('$ID','PENDIENTE','$usuario','$area')

	");
	if ($mov) {
		print"
	       <META HTTP-EQUIV='Refresh' CONTENT='0; URL=../../pages/equipo/tarea.php'> 
		
	 			";
	}else{
		print"
	        <SCRIPT LANGUAGE='javascript'> 
	            alert('Error en tabla mov_tarea, contacte al administrador de sistemas')
	            history.go(-1);; 
	            </SCRIPT> 
		
	 			";
	}

}else{
	print"
	        <SCRIPT LANGUAGE='javascript'> 
	            alert('Error al asignar tarea, revise')
	            history.go(-1);; 
	            </SCRIPT> 
		
	 			";
}

?>