<?php
include("../conexion.php");
session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
$empresa=$_SESSION['usuario']['id_empresa'];
///////////////////////////////////////////
$nombre=$_POST['nombre'];
$usuario=$_POST['usuario'];
$clave=$_POST['clave'];
$tipo=$_POST['tipo'];
$sede=$_POST['sede'];
$estado=$_POST['estado'];
$alerta_com=$_POST['alerta_com'];
$alerta_man=$_POST['alerta_man'];
$correo=$_POST['correo'];


if ($tipo=='Admin_carros') {
    $sede=0;
}

if ($tipo=='Oper_carros') {
    $alerta_com='N';
}
$busca=mysqli_query($conexion,"SELECT * FROM usuario where USUARIO='$usuario'");

if ($busca-> num_rows ==1) {
    echo"
        <script>
        alert('El usuario ".$usuario." ya existe, verifique por favor!!');
        history.go(-1);
        </script>
    ";
}else{
    $inserta=mysqli_query($conexion,"INSERT  usuario (NOMBRE,USUARIO,CLAVE,TIPO,codigo_pais,Id_depto,id_empresa,estado,correo,autoriza_combustible,alerta_mantenimiento ) VALUES ('$nombre','$usuario','$clave','$tipo','$pais','$sede','$empresa','$estado','$correo','$alerta_com','$alerta_man')");
    if ($inserta) {
        if ($tipo=='Oper_carros') {
             $permiso=mysqli_query($conexion,"INSERT permiso_usuario (id_permiso,usuario) values ('1','$usuario')");
        }
       
       echo"
        <script>
        history.go(-1);
        </script>
    "; 
    }else{
        echo"
        <script>
        alert('Ocurrio un proble al insertar los datos, contacte al administrador de sistemas!!');
        history.go(-1);
        </script>
    ";
    }
}

mysqli_close($conexion);
?>