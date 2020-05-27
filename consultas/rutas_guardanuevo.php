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
$piloto=$_POST['piloto'];
$tipo=$_POST['tipo'];
$placa=$_POST['placa'];
$canal=$_POST['canal'];
$depto=$_POST['depto'];
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
$rp=mysqli_query($conexion,"SELECT * FROM ruta where ruta='$ruta' and piloto='$piloto' and id_equipo='$placa'");

if ($rp-> num_rows == 0) {//Si no existe
	if($inserta=mysqli_query($conexion,"INSERT ruta (ruta,id_equipo,piloto,canal,tipo_vehi,codigo_pais,id_depto,usuario,estado,asignado_gal,restantes_gal) VALUES ('$ruta','$placa','$piloto','$canal','$tipo','$pais','$depto','$usuario','ACTIVO',0,0)")){

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
        alert('Ya existe ruta ".$ruta." con piloto ".$piloto." !!');
        history.go(-1);
        </script>
    ";	
}//Si no  existe

mysqli_close($conexion);
}
?>