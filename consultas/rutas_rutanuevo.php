<?php
include("../conexion.php");
session_start();
if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
}else{
$ruta=$_POST['ruta'];
$sede=$_POST['sede'];
$canal=$_POST['canal'];


$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
$rp=mysqli_query($conexion,"SELECT * FROM rutas where ruta='$ruta' and id_depto='$sede'");



if ($rp-> num_rows == 0) {//Si no existe
    if($inserta=mysqli_query($conexion,"INSERT rutas (ruta,id_depto,codigo_pais,estado,canal) VALUES ('$ruta','$sede','$pais','ACTIVO','$canal')")){

        print"
        <META HTTP-EQUIV='refresh' CONTENT='0; URL=../pages/vehiculo/rutas.php'> 
    ";  
    }else{
        print"
        <script LANGUAGE='javascript'>
        'No fue posible insertar esta ruta ';
        history.go(-1);
        </script>
    ";  
    }

}else{//Si existe
print"
        <script LANGUAGE='javascript'>
        alert('Ya existe ruta ".$ruta." en la misma sede !!');
        history.go(-1);
        </script>
    ";  
}//Si no  existe

mysqli_close($conexion);
} 

?>