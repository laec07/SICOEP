<?php
include("../../conexion.php");
session_start();
if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
} 
$pais=$_SESSION['usuario']['codigo_pais'];
$empresa=$_SESSION['usuario']['id_empresa'];
///////////////////////////////////////////
$nombre=$_POST['nombre'];
$usuario=$_POST['usuario'];
$clave=$_POST['clave'];
$tipo=$_POST['tipo'];
$estado=$_POST['estado'];
$correo=$_POST['correo'];


$busca=mysqli_query($conexion,"SELECT * FROM usuario where USUARIO='$usuario'");
$json = array();
if ($busca-> num_rows ==1) {
            $json['success'] = false;
            $json['message'] = 'El usuario '.$usuario.' ya existe, verifique por favor!!';
            $json['data'] = null;

}else{
    $inserta=mysqli_query($conexion,"INSERT  usuario (NOMBRE,USUARIO,CLAVE,TIPO,codigo_pais,id_empresa,estado,correo ) VALUES ('$nombre','$usuario','$clave','$tipo','$pais','$empresa','$estado','$correo')");
    if ($inserta) {
        if ($tipo=='Oper_carros') {
             $permiso=mysqli_query($conexion,"INSERT permiso_usuario (id_permiso,usuario) values ('1','$usuario')");
        }
            $json['success'] = true;
            $json['message'] = 'Actualizado correctamente.';
            $json['data'] = null; 

    }else{

            $json['success'] = false;
            $json['message'] = 'Error al insertar usuario!!'.mysqli_error($conexion);
            $json['data'] = null;
    }
}

mysqli_close($conexion);
//Retornamos el nuestro arreglo en formato JSON, recuerda agregar el encabezado, es indispensable para el navegador
//Saber que tipo de información estas enviando
header('Content-Type: application/json');
echo json_encode( $json );
?>