<?php 
include'../conexion.php';
 session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
$id_piloto=$_POST['id_piloto'];
 date_default_timezone_set('America/Guatemala');
    $fecha_actual= Date("Ymd");
echo $fecha_actual;
$hdy=400;
$ls=0;
//recibir imágen
/*echo '<pre>';
print_r($_FILES['archivo']);
echo '</pre>';*/

//FOTO 1
if($_FILES["archivo"]["error"]>0){
 
} else {
  $permitidos = array("image/JPG", "image/jpeg","image/png","image/gif",);
  $limite_kb=8000;

  if(in_array($_FILES["archivo"]["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024){
    $ruta="files/".$id_piloto."/";
    //variable que suma
    $ls+=1;
    //incluye variable que suma para no repetir nombre imagen
    $archivo=$ruta.$_FILES["archivo"]["name"].$fecha_actual.$ls.".jpg";
    //abrir la foto  (COMPRIMIR IMAGEN ---- COMPRIMIR IMAGEN)*********************************
    $temporal= $_FILES["archivo"]["tmp_name"];
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
    if(!file_exists($ruta)){
      mkdir($ruta);
    }
    

    if (!file_exists($archivo)) {
      //TRASLADA IMAGEN AL SERVIDOR 
      $resultado=imagejpeg($copia,$archivo,75);

      if ($resultado) {
        $b_foto=mysqli_query($conexion,"SELECT foto_piloto FROM usuarios WHERE Id_usuario='$id_piloto'");
        $rfoto=mysqli_fetch_array($b_foto);
        $borra=$rfoto['foto_piloto'];
        unlink($borra);

        $insertar=mysqli_query($conexion,"UPDATE usuarios SET foto_piloto='$archivo' where Id_usuario='$id_piloto'");
        $alerta= "Foto Guardada";
      } else{
        $alerta= "Foto no guardada";
      }
    }else{
      $alerta= "Foto ya existe";
    }
  } else{
    $alerta= "Foto  no permitido o excede el tamaño";
  }
}



/*if ($subido) {
  
            $insertar=mysqli_query($conexion,"UPDATE foto_vehi SET foto1='$destino', foto2='$destino2', foto3='$destino3', foto4='$destino4', foto5='$destino5', foto6='$destino6', foto7='$destino7' where id_equipo='$id_piloto' ");
 */ print"
  <SCRIPT LANGUAGE='javascript'> 
            alert('Estado de operación \\n$alerta ' ); 
            history.go(-1);
            </SCRIPT> 
          ";
/*}
else
{
print"
  <SCRIPT LANGUAGE='javascript'> 
            alert('No se logro cargar fotos, por favor intente de nuevo'); 
            </SCRIPT> 
            <META HTTP-EQUIV='Refresh' CONTENT='0; URL=../foto_vehi.php'>";
}
*/
?>
