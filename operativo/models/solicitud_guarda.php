<?php
include("../../conexion.php");
require_once('../../plugins/class.phpmailer.php');
require_once('../../plugins/class.smtp.php');
session_start();
///////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
////////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
///////////////////////////////////////////////
$id_solicitud=$_POST['id_solicitud'];
////////////////////////////////////////////
$ts=mysqli_query($conexion,"SELECT sum(total) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total_e=mysqli_fetch_array($ts);
$total_efectivo=$total_e['total'];
////////////////////////////////////////////
$ts=mysqli_query($conexion,"SELECT sum(galones) as galones FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total_g=mysqli_fetch_array($ts);
$total_galones=$total_g['galones'];
///////////////////////////////////////////
$actualiza=mysqli_query($conexion,"UPDATE combustible_solicitud SET estatus='PENDIENTE',total_efectivo='$total_efectivo',total_galones='$total_galones' WHERE id_solicitud='$id_solicitud'");
/////////////////////////////////////////
if ($actualiza) {
  //Busca a quién envía correo////////////////////////////
  $b_correo=mysqli_query($conexion,"SELECT NOMBRE,correo FROM usuario where autoriza_combustible='S' and codigo_pais='$pais'");
  //$bs_correo=mysqli_fetch_array($b_correo);
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
    $asunto="Solicitud No. ".$id_solicitud." Ingresada ".$sede['Depto'];
    $nombre_rem=$_SESSION['usuario']['NOMBRE'];
    $correo_rem=$bs_remitente['correo'];
    /////////************/////////////////////////////
        ///////**********Usuario y clave para envío de correos configurado desde bd******************///////
    $d_cor=mysqli_query($conexion,"SELECT correo,clave FROM correo");
    $dato_cor=mysqli_fetch_array($d_cor);
    $server_correo=$dato_cor['correo'];
    $server_correoPass=$dato_cor['clave'];
    ///////////////////////////////////////////////
    $mail = new PHPMailer();
    //indico a la clase que use SMTP
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $server_correo;                 // SMTP username
    $mail->Password = $server_correoPass;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; 

    $mensaje="Solicitud No. ".$id_solicitud." ingresada por ".$nombre_rem." - ".$sede['Depto'] ." con ".$total_galones." galones y un total de ".$rps['moneda'].$total_efectivo."<br> ingrese a https://www.sicoep.creceactivaciones.com para mas detalles.";

    $mail->setFrom($correo_rem, $nombre_rem);
    $mail->addReplyTo($correo_rem,$nombre_rem);
    $mail->Subject = $asunto;
    
    $mail->Body    = $mensaje;
    $mail->AltBody = $mensaje;
    //indico destinatario
    while ($row=mysqli_fetch_array($b_correo)) {

      $mail->addAddress($row['correo'],$row['NOMBRE']);
    }
                   // Name is optional
    
    if(!$mail->send()) {
    echo 'Error al enviar: ' . $mail->ErrorInfo;
    } else {
    echo "Mensaje enviado!";
    }


  echo "
  <script>
  alert('Solicitud procesada satisfactoriamente');
  </script>
  
  ";

}else{
   echo "
  <script>
  alert('No fue posible procesar la solicitud, puede seguir editando la solicitud');
  </script>
  
  ";
}
mysqli_close($conexion);
?>