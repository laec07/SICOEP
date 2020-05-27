<?php
include("../../conexion.php");

$usuario=$_POST['usuario_f'];
$hdy=400;
$ls=0;

$ruta_carpeta="../../consultas/fotos_usuarios/";
$nombre_archivo="usuario_".date("Ymdis").".".pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
$ruta_guardar_archivo=$ruta_carpeta.$nombre_archivo;

    //abrir la foto  (COMPRIMIR IMAGEN ---- COMPRIMIR IMAGEN)*********************************
    $temporal= $_FILES["imagen"]["tmp_name"];
    $original= imagecreatefromjpeg($temporal);
    $ancho_original= imagesx($original);
    $alto_original= imagesy($original);
    // crear lienzo
    $ancho_nuevo=$hdy;
    $alto_nuevo=round($ancho_nuevo * $alto_original / $ancho_original);
    $copia= imagecreatetruecolor($ancho_nuevo, $alto_nuevo);
    //copia originarl -> copia
    //1-2 destino-original
    //3-4 eje x_y pegado -->0,0
    //5-6 eje x_y original -->0,0
    //7-8 ancho alto destino 
    //9-10 ancho-alto original ---> WIDHT HEIGTH 
    imagecopyresampled($copia, $original, 0, 0, 0, 0,$ancho_nuevo, $alto_nuevo, $ancho_original, $alto_original);
    //FIN COMPRIMIR IMAGEN***************************************************************************


if (imagejpeg($copia, $ruta_guardar_archivo,100)) {
	//busca ruta de foto anterior
	$b=mysqli_query($conexion,"SELECT USUARIO,foto FROM usuario WHERE USUARIO = '$usuario'");
	$b_f=mysqli_fetch_array($b);
	$foto_busca=$b_f['foto'];
	//borra foto anterior
	if (isset($foto_busca)) {
		unlink($foto_busca);
	}
	//actualiza en bd foto nueva
	$actualiza=mysqli_query($conexion,"UPDATE usuario SET foto='$ruta_guardar_archivo' WHERE USUARIO='$usuario'");

}else{
	echo "Fail";
}

?>