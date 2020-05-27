<?php
include("../../conexion.php");
session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
$empresa=$_SESSION['usuario']['id_empresa'];
///////////////////////////////////////////
$nombre=$_POST['nombre_e'];
$usuario=$_POST['usuario_e'];
$clave=$_POST['clave_e'];
$tipo=$_POST['tipo_e'];
$estado=$_POST['estado_e'];
$correo=$_POST['correo_e'];


$json = array();

$actualiza=mysqli_query($conexion,"
    UPDATE 
        usuario 
    SET
        NOMBRE='$nombre',
        CLAVE='$clave',
        TIPO='$tipo',
        estado='$estado',
        correo='$correo'
    WHERE 
        USUARIO='$usuario'
            ");

if ($actualiza) {
            $json['success'] = true;
            $json['message'] = 'Actualizado correctamente.';
            $json['data'] = null; 
}else{
            $json['success'] = false;
            $json['message'] = 'No fue posible modificar los datos'.mysqli_error($conexion);
            $json['data'] = null;

}

mysqli_close($conexion);
//Retornamos el nuestro arreglo en formato JSON, recuerda agregar el encabezado, es indispensable para el navegador
//Saber que tipo de información estas enviando
header('Content-Type: application/json');
echo json_encode( $json );
?>