<?php
include('../../conexion.php');
session_start();

$tarea=$_POST['tarea'];
$date=$_POST['date'];
$usuario=$_SESSION['usuario']['USUARIO'];
$area=$_SESSION['usuario']['cod_area'];


if ($tarea!="") {
	mysqli_query($conexion,"INSERT INTO tarea (tarea,fecha_programada,estatus,cod_area,usuario_asignado,usuario_asigno) VALUES ('$tarea', '$date','PENDIENTE','$area','$usuario','$usuario')");
	$ID=mysqli_query($conexion,"SELECT ID from tarea order by id desc limit 1");
	$rID=mysqli_fetch_array($ID);
	$idt= $rID['ID'];

	$mov=mysqli_query($conexion,"INSERT INTO mov_tarea(ID_tarea, estatus, usuario )VALUES('$idt','PENDIENTE','$usuario' )");
	if ($mov) {
		# code...
	}else{
	print"
        <SCRIPT LANGUAGE='javascript'> 
            alert('Error al ingresar movimientos, consulte con el administrador del sistemas')
            history.go(-1);; 
            </SCRIPT> 
			}
			 ";	
				}
	}
else
{
print"
        <SCRIPT LANGUAGE='javascript'> 
            alert('Describa la tarea a programar')
            history.go(-1);; 
            </SCRIPT> 
}
 ";
 }
 ?>