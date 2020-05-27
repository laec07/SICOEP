<?php 
include'../conexion.php';
 session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
$placa=$_POST['placa'];
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
    $ruta="files/".$placa."/";
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
        $insertar=mysqli_query($conexion,"INSERT INTO foto_vehi (id_equipo,foto1,fecha, usuario) VALUES ('$placa','$archivo','$fecha_actual','$usuario')");
        $alerta= "Foto1 Guardado";
      } else{
        $alerta= "Foto1 no guardado";
      }
    }else{
      $alerta= "Foto1 ya existe";
    }
  } else{
    $alerta= "Foto 1 no permitido o excede el tamaño";
  }
}

//FOTO 2
if($_FILES["archivo2"]["error"]>0){
  
} else {
  $permitidos2 = array("image/JPG", "image/jpeg","image/png","image/gif",);
  $limite_kb2=8000;
  if(in_array($_FILES["archivo2"]["type"], $permitidos2) && $_FILES["archivo2"]["size"] <= $limite_kb2 * 1024){
    $ruta2="files/".$placa."/";
    //variable que suma
    $ls+=1;
    //incluye variable que suma para no repetir nombre imagen
    $archivo2=$ruta2.$_FILES["archivo2"]["name"].$fecha_actual.$ls.".jpg";
    //abrir la foto  (COMPRIMIR IMAGEN ---- COMPRIMIR IMAGEN)*********************************
    $temporal2= $_FILES["archivo2"]["tmp_name"];
    $original2= imagecreatefromjpeg($temporal2);
    $ancho_original2= imagesx($original2);
    $alto_original2= imagesy($original2);
    // crear lienzo
    $ancho_nuevo2=$hdy;
    $alto_nuevo2=round($ancho_nuevo2 * $alto_original2 / $ancho_original2);
    $copia2= imagecreatetruecolor($ancho_nuevo2, $alto_nuevo2);
    
    //copia originarl -> copia
    //1-2 destino-original
    //3-4 eje x_y pegado -->0,0
    //5-6 eje x_y original -->0,0
    //7-8 ancho alto destino 
    //9-10 ancho-alto original ---> WIDHT HEIGTH 
    imagecopyresampled($copia2, $original2, 0, 0, 0, 0, $ancho_nuevo2, $alto_nuevo2, $ancho_original2, $alto_original2);
    //FIN COMPRIMIR IMAGEN***************************************************************************
    
    if (!file_exists($archivo2)) {
      //TRASLADA IMAGEN AL SERVIDOR 
      $resultado2=imagejpeg($copia2,$archivo2,75);
      

      if ($resultado2) {
        $insertar2=mysqli_query($conexion,"INSERT INTO foto_vehi (id_equipo,foto1,fecha, usuario) VALUES ('$placa','$archivo2','$fecha_actual','$usuario')");
        $alerta2 ="Foto2 Guardado";
      } else{
        $alerta2= "Foto2 no guardado";
      }
    }else{
      $alerta2="Foto2 ya existe";
    }
  } else{
    $alerta2="Foto2 no permitido o excede el tamaño";
  }
}

//FOTO 3
if($_FILES["archivo3"]["error"]>0){
  
} else {
  $permitidos3 = array("image/JPG", "image/jpeg","image/png","image/gif",);
  $limite_kb3=8000;
  if(in_array($_FILES["archivo3"]["type"], $permitidos3) && $_FILES["archivo3"]["size"] <= $limite_kb3 * 1024){
    $ruta3="files/".$placa."/";
     //variable que suma
    $ls+=1;
    //incluye variable que suma para no repetir nombre imagen
    $archivo3=$ruta3.$_FILES["archivo3"]["name"].$fecha_actual.$ls.".jpg";
    //abrir la foto  (COMPRIMIR IMAGEN ---- COMPRIMIR IMAGEN)*********************************
    $temporal3= $_FILES["archivo3"]["tmp_name"];
    $original3= imagecreatefromjpeg($temporal3);
    $ancho_original3= imagesx($original3);
    $alto_original3= imagesy($original3);
    // crear lienzo
    $ancho_nuevo3=$hdy;
    $alto_nuevo3=round($ancho_nuevo3 * $alto_original3 / $ancho_original3);
    $copia3= imagecreatetruecolor($ancho_nuevo3, $alto_nuevo3);
    
    //copia originarl -> copia
    //1-2 destino-original
    //3-4 eje x_y pegado -->0,0
    //5-6 eje x_y original -->0,0
    //7-8 ancho alto destino 
    //9-10 ancho-alto original ---> WIDHT HEIGTH 
    imagecopyresampled($copia3, $original3, 0, 0, 0, 0, $ancho_nuevo3, $alto_nuevo3, $ancho_original3, $alto_original3);
    //FIN COMPRIMIR IMAGEN***************************************************************************
    
    if (!file_exists($archivo3)) {
      //TRASLADA IMAGEN AL SERVIDOR 
      $resultado3=imagejpeg($copia3,$archivo3,75);
      

      if ($resultado3) {
        $insertar3=mysqli_query($conexion,"INSERT INTO foto_vehi (id_equipo,foto1,fecha, usuario) VALUES ('$placa','$archivo3','$fecha_actual','$usuario')");
        $alerta3= "Foto3 Guardado";
      } else{
        $alerta3="Foto3 no guardado";
      }
    }else{
      $alerta3="Foto3 ya existe";
    }
  } else{
    $alerta3= "Foto3 no permitido o excede el tamaño";
  }
}

//FOTO 4
if($_FILES["archivo4"]["error"]>0){
  
} else {
  $permitidos4 = array("image/JPG", "image/jpeg","image/png","image/gif",);
  $limite_kb4=8000;
  if(in_array($_FILES["archivo4"]["type"], $permitidos4) && $_FILES["archivo4"]["size"] <= $limite_kb4 * 1024){
    $ruta4="files/".$placa."/";
    //variable que suma
    $ls+=1;
    //incluye variable que suma para no repetir nombre imagen
    $archivo4=$ruta4.$_FILES["archivo4"]["name"].$fecha_actual.$ls.".jpg";
    //abrir la foto  (COMPRIMIR IMAGEN ---- COMPRIMIR IMAGEN)*********************************
    $temporal4= $_FILES["archivo4"]["tmp_name"];
    $original4= imagecreatefromjpeg($temporal4);
    $ancho_original4= imagesx($original4);
    $alto_original4= imagesy($original4);
    // crear lienzo
    $ancho_nuevo4=$hdy;
    $alto_nuevo4=round($ancho_nuevo4 * $alto_original4 / $ancho_original4);
    $copia4= imagecreatetruecolor($ancho_nuevo4, $alto_nuevo4);
    
    //copia originarl -> copia
    //1-2 destino-original
    //3-4 eje x_y pegado -->0,0
    //5-6 eje x_y original -->0,0
    //7-8 ancho alto destino 
    //9-10 ancho-alto original ---> WIDHT HEIGTH 
    imagecopyresampled($copia4, $original4, 0, 0, 0, 0, $ancho_nuevo4, $alto_nuevo4, $ancho_original4, $alto_original4);
    //FIN COMPRIMIR IMAGEN***************************************************************************
    
    if (!file_exists($archivo4)) {
      //TRASLADA IMAGEN AL SERVIDOR 
      $resultado4=imagejpeg($copia4,$archivo4,75);
      

      if ($resultado4) {
        $insertar4=mysqli_query($conexion,"INSERT INTO foto_vehi (id_equipo,foto1,fecha, usuario) VALUES ('$placa','$archivo4','$fecha_actual','$usuario')");
        $alerta4= "Foto4 Guardado";
      } else{
        $alerta4="Foto4 no guardado";
      }
    }else{
      $alerta4="Foto4 ya existe";
    }
  } else{
    $alerta4= "Foto4 no permitido o excede el tamaño";
  }
}

//FOTO 5
if($_FILES["archivo5"]["error"]>0){
  
} else {
  $permitidos5 = array("image/JPG", "image/jpeg","image/png","image/gif",);
  $limite_kb5=8000;
  if(in_array($_FILES["archivo5"]["type"], $permitidos5) && $_FILES["archivo5"]["size"] <= $limite_kb5 * 1024){
    $ruta5="files/".$placa."/";
    //variable que suma
    $ls+=1;
    //incluye variable que suma para no repetir nombre imagen
    $archivo5=$ruta5.$_FILES["archivo5"]["name"].$fecha_actual.$ls.".jpg";
    //abrir la foto  (COMPRIMIR IMAGEN ---- COMPRIMIR IMAGEN)*********************************
    $temporal5= $_FILES["archivo5"]["tmp_name"];
    $original5= imagecreatefromjpeg($temporal5);
    $ancho_original5= imagesx($original5);
    $alto_original5= imagesy($original5);
    // crear lienzo
    $ancho_nuevo5=$hdy;
    $alto_nuevo5=round($ancho_nuevo5 * $alto_original5 / $ancho_original5);
    $copia5= imagecreatetruecolor($ancho_nuevo5, $alto_nuevo5);
    
    //copia originarl -> copia
    //1-2 destino-original
    //3-4 eje x_y pegado -->0,0
    //5-6 eje x_y original -->0,0
    //7-8 ancho alto destino 
    //9-10 ancho-alto original ---> WIDHT HEIGTH 
    imagecopyresampled($copia5, $original5, 0, 0, 0, 0, $ancho_nuevo5, $alto_nuevo5, $ancho_original5, $alto_original5);
    //FIN COMPRIMIR IMAGEN***************************************************************************
    
    if (!file_exists($archivo5)) {
      //TRASLADA IMAGEN AL SERVIDOR 
      $resultado5=imagejpeg($copia5,$archivo5,75);
      

      if ($resultado5) {
        $insertar5=mysqli_query($conexion,"INSERT INTO foto_vehi (id_equipo,foto1,fecha, usuario) VALUES ('$placa','$archivo5','$fecha_actual','$usuario')");
        $alerta5= "Foto5 Guardado";
      } else{
        $alerta5="Foto5 no guardado";
      }
    }else{
      $alerta5="Foto5 ya existe";
    }
  } else{
    $alerta5= "Foto5 no permitido o excede el tamaño";
  }
}

/*if ($subido) {
  
            $insertar=mysqli_query($conexion,"UPDATE foto_vehi SET foto1='$destino', foto2='$destino2', foto3='$destino3', foto4='$destino4', foto5='$destino5', foto6='$destino6', foto7='$destino7' where id_equipo='$placa' ");
 */ print"
  <SCRIPT LANGUAGE='javascript'> 
            alert('Fotos de  $placa \\n$alerta \\n $alerta2 \\n $alerta3 \\n $alerta4 \\n $alerta5' ); 
            </SCRIPT> 
            <META HTTP-EQUIV='Refresh' CONTENT='0; URL=../pages/vehiculo/vehi_foto.php?placa=$placa'>";
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
