<?php
include ("../conexion.php");
session_start();
$usuario=$_SESSION['usuario']['USUARIO']; 
/*****************************************************/
$ID = $_GET['ID'];
$motivo=$_GET['motivo'];
$p_venta=$_GET['p_venta'];
/******************************************************/ 
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y/m/d");
/****************************************************/
$e_v=mysqli_query($conexion,"SELECT Estado_equipo FROM vehiculo WHERE Id_equipo='$ID'");
$e_vehi=mysqli_fetch_array($e_v);
$estado_vehi=$e_vehi['Estado_equipo'];
if ($estado_vehi=='ASIGNADO') {
    print"
        <SCRIPT LANGUAGE='javascript'>
        alert('Este vehículo se encuentra asignado, no es posible darle de baja, elimine la asignación o asignelo como VENDIDO')
        history.go(-1);
        </SCRIPT>
        ";
}else if ($estado_vehi=='VENDIDO') {
    if ($actualiza=mysqli_query($conexion,"UPDATE vehiculo SET fecha_baja='$fecha_actual',Estado_equipo='BAJA',usuario='$usuario',motivo_baja='$estado_vehi' WHERE Id_equipo='$ID' ")) {
        print"
            <SCRIPT LANGUAGE='javascript'>
            alert('Vehículo de baja')
            history.go(-1);
            </SCRIPT>
            ";
    }else{
        print"
            <SCRIPT LANGUAGE='javascript'>
            alert('Ocurrio un error mientras se le deba de baja, intentelo nuevamente.')
            history.go(-1);
            </SCRIPT>
            "; 
    }
}else if($estado_vehi=='ACTIVO'){
    if ($actualiza=mysqli_query($conexion,"UPDATE vehiculo SET fecha_baja='$fecha_actual',Estado_equipo='BAJA',usuario='$usuario',motivo_baja='$motivo',precio_venta='$p_venta' WHERE Id_equipo='$ID' ")) {
        print"
            <SCRIPT LANGUAGE='javascript'>
            alert('Vehículo de baja')
            history.go(-1);
            </SCRIPT>
            ";
    }else{
        print"
            <SCRIPT LANGUAGE='javascript'>
            alert('Ocurrio un error mientras se le deba de baja, intentelo nuevamente.')
            history.go(-1);
            </SCRIPT>
            "; 
    }
}else if($estado_vehi=='BAJA') {
    print"
<SCRIPT LANGUAGE='javascript'>
alert('Este vehículo ya ha sido dado de baja')
history.go(-1);
</SCRIPT>
";
}else{
   print"
<SCRIPT LANGUAGE='javascript'>
alert('No se cumplio con ningún criterio')
history.go(-1);
</SCRIPT>
"; 
}


?>