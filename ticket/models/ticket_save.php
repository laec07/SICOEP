<?php
include('../../conexion.php');
require_once('../../plugins/class.phpmailer.php');
require_once('../../plugins/class.smtp.php');
  date_default_timezone_set('America/Guatemala');
$date= Date("Y-m-d");
$pais=$_POST['pais'];
$categoria=$_POST['categoria'];
$descripcion=$_POST['descripcion'];
$solicitante=$_POST['solicitante'];
$mail_e=$_POST['mail_e'];
$priory=$_POST['priory'];
$mensaje=$_POST['mensaje'];
$depto=$_POST['depto'];
$usuario_solicita=$_POST['usuario_solicita'];
$hdy=800;
$ls=0;


//busca depto para insertarlo en el mensaje.
$sd=mysqli_query($conexion,"SELECT Depto FROM depto WHERE codigo_pais='$pais' and Id_depto='$depto' ");
$sde=mysqli_fetch_array($sd);
$sede=$sde['Depto'];
$mensaje_="Depto: ".$sede."<br>".$mensaje;

	if(mysqli_query($conexion,"INSERT INTO tarea (tarea,fecha_programada,estatus,solicitante,id_tipotarea,codigo_pais,email,prioridad,mensaje,usuario_solicita) VALUES ('$descripcion', '$date','SIN ATENDER','$solicitante','$categoria','$pais','$mail_e','$priory','$mensaje_','$usuario_solicita')")){

		$ID=mysqli_query($conexion,"SELECT ID from tarea order by id desc limit 1");
		$rID=mysqli_fetch_array($ID);
		$idt= $rID['ID'];

		mysqli_query($conexion,"INSERT INTO mov_tarea(ID_tarea, estatus )VALUES('$idt','SIN ASIGNAR' )");
/***************Envío correo***********************************************************************************/
		//busca destinatarios según país.
		$b_correo=mysqli_query($conexion,"SELECT NOMBRE,correo FROM usuario where codigo_pais='$pais' and TIPO='Admin_equipo' ");

		

		$asunto="Ticket No. ".$idt." ".$descripcion;
		$nombre_=$solicitante;
		///////****************************///////
		$d_cor=mysqli_query($conexion,"SELECT correo,clave FROM correo");
		$dato_cor=mysqli_fetch_array($d_cor);
		$server_correo=$dato_cor['correo'];
		$server_correoPass=$dato_cor['clave'];

		/////////************/////////////////////////////
		$mail = new PHPMailer();
		//indico a la clase que use SMTP
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $server_correo;                 // SMTP username
		//datos de correo utilizado para el envío de correos.
		$correo=$server_correo;
		$mail->Password = $server_correoPass;                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587; 

		$mail->setFrom($mail_e, $nombre_);
		$mail->addReplyTo($mail_e,$nombre_);
		$mail->Subject = $asunto;



		$mail->Body    = "Depto: ".$sede."<br> Solicitante: ".$solicitante."<br>".$mensaje;
		$mail->AltBody =  "Depto: ".$sede."<br> Solicitante: ".$solicitante.$mensaje;
		//indico destinatario

		while ($row=mysqli_fetch_array($b_correo)) 
			{
      			$mail->addAddress($row['correo'],$row['NOMBRE']);
    		}

		//$address = $destinatario;
    		$mail->send();
    		/*
		if(!$mail->send()) {
		echo 'Error al enviar: ' . $mail->ErrorInfo;
		} else {
		echo "Mensaje enviado!";
		}
*/

		//$copia=$correo;

		

		//$encabezados = "MIME-Version: 1.0\n";
		//$encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
		//$encabezados .= "From: $nombre_ <$correo>\n";
		//$encabezados .= "CC: <$mail>\n"; //aqui fijo el CC
		//$encabezados .= "X-Mailer: PHP\n";
		//$encabezados .= "X-Priority: 1\n"; // fijo prioridad

		

		//$enviado=mail($destinatario, $asunto, $mensaje,$encabezados);
//foto/////////////////////////////***************//////////////////////////////////
/*if ($_FILES["adjunto"]) {
	

		if($_FILES["adjunto"]["error"]>0){
 
				} else {
				  $permitidos = array("image/JPG", "image/jpeg","image/png","image/gif",);
				  $limite_kb=8000;

				  if(in_array($_FILES["adjunto"]["type"], $permitidos) && $_FILES["adjunto"]["size"] <= $limite_kb * 1024){
				    $ruta="fotos_ticket/".$idt."/";
				    //variable que suma
				    $ls+=1;
				    //incluye variable que suma para no repetir nombre imagen
				    $archivo=$ruta.$_FILES["adjunto"]["name"].$fecha_actual.$ls.".jpg";
				    //abrir la foto  (COMPRIMIR IMAGEN ---- COMPRIMIR IMAGEN)*********************************
				    $temporal= $_FILES["adjunto"]["tmp_name"];
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
				        $insertar=mysqli_query($conexion,"UPDATE tarea set foto='$archivo' where ID='$idt'");
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




		
	}*/
}
	
echo $idt;

?>