<?php
     include ("../conexion.php"); 
     $Ida = $_POST['Id_Asignacion'];
     $Ieq = $_POST['Id_equipo']; 
     $Iu = $_POST['Id_usuario'];
     date_default_timezone_set('America/Guatemala');
    $fecha_actual= Date("Y/m/d");
    $es=mysqli_query($conexion,"SELECT canal FROM asignacion_vehiculo  where Id_Asignacion='$Ida'");
    $estado=mysqli_fetch_array($es);
    if ($estado['canal']=='VENDIDO') {
         $var='VENDIDO';
    }else{
          $var='ACTIVO';
    }
     
     mysqli_query($conexion, "UPDATE asignacion_vehiculo SET Estado_asig='BAJA', fecha_baja='$fecha_actual' WHERE Id_Asignacion='$Ida'");
     mysqli_query($conexion, "UPDATE vehiculo SET Estado_equipo = '$var' WHERE Id_equipo = '$Ieq'");
     mysqli_query($conexion,"UPDATE usuarios SET estado='ACTIVO' where Id_usuario='$Iu' ");
     print"
				<SCRIPT LANGUAGE='javascript'>
	 			alert('Asignacion de baja')
	 			 history.go(-1);
	 			</SCRIPT>";
?>