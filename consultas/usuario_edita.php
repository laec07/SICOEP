<?php
include("../conexion.php");
session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
$empresa=$_SESSION['usuario']['id_empresa'];
///////////////////////////////////////////
$nombre=$_POST['nombre_e'];
$usuario=$_POST['usuario_e'];
$clave=$_POST['clave_e'];
$tipo=$_POST['tipo_e'];
$sede=$_POST['sede_e'];
$estado=$_POST['estado_e'];
$correo=$_POST['correo_e'];
$alerta_man=$_POST['alerta_man_e'];
$alerta_com=$_POST['alerta_com_e'];

if ($tipo=='Admin_carros') {
    $sede=0;
}

$actualiza=mysqli_query($conexion,"
    UPDATE 
        usuario 
    SET
        NOMBRE='$nombre',
        CLAVE='$clave',
        TIPO='$tipo',
        Id_depto='$sede',
        estado='$estado',
        correo='$correo',
        autoriza_combustible='$alerta_com',
        alerta_mantenimiento='$alerta_man'
    WHERE 
        USUARIO='$usuario'
            ");

if ($actualiza) {
    echo"
        <script>
            history.go(-1)
        </script>
    ";
}else{
    echo"
        <script>
            alert('Error al actualizar, consulte con el administrador del sistema')
             history.go(-1)
        </script>
    ";
}

mysqli_close($conexion);
?>