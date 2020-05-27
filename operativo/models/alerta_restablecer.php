<?php
include ("../../conexion.php");
require_once('../../plugins/class.phpmailer.php');
require_once('../../plugins/class.smtp.php');
$depto=$_POST['depto'];
session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];

$sd=mysqli_query($conexion,"SELECT * FROM depto where Id_depto='$depto'");
$sed=mysqli_fetch_array($sd);
$sede=$sed['Depto'];


//Correo

//Busca a quién envía correo////////////////////////////
  $b_correo=mysqli_query($conexion,"SELECT NOMBRE,correo FROM usuario where autoriza_combustible='S' and codigo_pais='$pais'");
  $bs_correo=mysqli_fetch_array($b_correo);
//////////////////////////////////////////////////////////
$b_remitente =mysqli_query($conexion,"SELECT NOMBRE,correo FROM usuario where USUARIO='$usuario'");  
$bs_remitente = mysqli_fetch_array($b_remitente); 
////////////////////////////////////////////////////////
$sd=$_SESSION['usuario']['Id_depto'];
$sde=mysqli_query($conexion,"SELECT * FROM depto where Id_depto='$sd'");
$sede=mysqli_fetch_array($sde);
///////////////////////////////////////////////////////////////////////
/*************************Envía correo *************************************/
    $destinatariodess=$bs_correo['correo'];
    $nombredess=$bs_correo['NOMBRE'];
    $asunto="Restablecer galones rutas - ".$sede['Depto'];
    $nombre_rem=$_SESSION['usuario']['NOMBRE'];
    $correo_rem=$bs_remitente['correo'];
    /////////************/////////////////////////////
            ///////**********Usuario y clave para envío de correos configurado desde bd******************///////
        $d_cor=mysqli_query($conexion,"SELECT correo,clave FROM correo");
        $dato_cor=mysqli_fetch_array($d_cor);
        $server_correo=$dato_cor['correo'];
        $server_correoPass=$dato_cor['clave'];
/////////////////////////////////////////////////////////////
    $mail = new PHPMailer();
    //indico a la clase que use SMTP
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $server_correo;                 // SMTP username
    $mail->Password = $server_correoPass;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; 

    $mensaje=$sede['Depto']." Solicita combustible, pero aún no se han restablecido los galones asignados para cada ruta <br><br> Restablezca galonaje asignado de -".$sede['Depto']. "- para que puedan solicitar combustible en fecha seleccionada.";

    $mail->setFrom($correo_rem, $nombre_rem);
    $mail->addReplyTo($correo_rem,$nombre_rem);
    $mail->Subject = $asunto;
    
    $mail->Body    = $mensaje;
    $mail->AltBody = $mensaje;
    //indico destinatario
    
    $mail->addAddress($destinatariodess,$nombredess);               // Name is optional
    
    if(!$mail->send()) {
    echo 'Error al enviar: ' . $mail->ErrorInfo;
    } else {
    echo "Mensaje enviado!";
    }


?>
