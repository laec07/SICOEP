<?php
include("../conexion.php");
session_start();
$ruta=$_POST['ruta'];
$piloto=$_POST['piloto'];
$tipo=$_POST['tipo'];
$placa=$_POST['placa'];
$canal=$_POST['canal'];
$depto=$_POST['depto'];
$asig=$_POST['asig'];
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
$rp=mysqli_query($conexion,"SELECT * FROM ruta where ruta='$ruta' and id_equipo='$placa'");

if ($rp-> num_rows == 0) {//Si no existe
	if($inserta=mysqli_query($conexion,"INSERT ruta (ruta,id_equipo,piloto,canal,tipo_vehi,codigo_pais,id_depto,usuario,estado) VALUES ('$ruta','$placa','$piloto','$canal','$tipo','$pais','$depto','$usuario','ACTIVO')")){

        $actualiza=mysqli_query($conexion,"UPDATE asignacion_vehiculo set ruta='S' where Id_Asignacion='$asig'");
        if ($actualiza) {
            print"
        <META HTTP-EQUIV='refresh' CONTENT='0; URL=../pages/vehiculo/asignaciones.php'> 
            ";
        }else{
          print"
        <script LANGUAGE='javascript'>
        alert('Vehiculo asignado a ruta, No fue posible actualizar asignación!!');
        history.go(-1);
        </script>
    ";  
        }

		print"
        <META HTTP-EQUIV='refresh' CONTENT='0; URL=../pages/vehiculo/asignaciones.php'> 
    ";	
	}else{
		print"
        <script LANGUAGE='javascript'>
        alert('No fue posible insertar esta ruta ');
        history.go(-1);
        </script>
    ";	
	}

}else{//Si existe
print"
        <script LANGUAGE='javascript'>
        alert('Ya existe ruta ".$ruta." con placa ".$placa." !!');
        history.go(-1);
        </script>
    ";	
}//Si no  existe

mysqli_close($conexion);
?>