<?php
include("../conexion.php");
require_once('../plugins/class.phpmailer.php');
require_once('../plugins/class.smtp.php');
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}
//////////////////////////////////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
//////////////////////////////////////////////////////////////////////
/*************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y-m-d");
$mes_actual= Date("m");
$año_actual= date("Y");
//$fecha_actual="2018-11-21";
/*************************************************/
//busca vehiculos que necesiten mantenimiento
$query=mysqli_query($conexion,"
SELECT
	em.id_equipo,
	em.kilosugerido,
	v.Kilometraje,
	em.kilosugerido - v.Kilometraje AS resta,
	av.Estado_asig,
	av.Id_depto,
	d.Depto
FROM
	estado_mantenimiento em
JOIN vehiculo v ON v.id_equipo = em.id_equipo
JOIN asignacion_vehiculo av ON av.Id_equipo = v.Id_equipo
JOIN depto d ON d.Id_depto=av.Id_depto
WHERE
	(
		em.kilosugerido - v.Kilometraje
	) <= 200
AND v.codigo_pais = '$pais'
AND av.Estado_asig = 'ACTIVO'
GROUP BY v.Id_equipo
	");
/////////////////////////BUSCA DESTINATARIO PRINCIPAL CORREO//////////////////////////////////////////////////////////////////
 $b_correo=mysqli_query($conexion,"SELECT NOMBRE,correo FROM usuario where codigo_pais='$pais' and TIPO='Admin_carros' and alerta_mantenimiento='S' ");
 //$bs_correo=mysqli_fetch_array($b_correo);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//verifica vehículo por vehículo si no se ha mandado alerta
while ($fila=mysqli_fetch_array($query)) {
	$placa=$fila['id_equipo'];
	$agencia=$fila['Depto'];
	$resta=$fila['resta'];
	$id_depto=$fila['Id_depto'];
	//verifica vehículo por vehículo si no se ha mandado alerta
	$verif_placa=mysqli_query($conexion,"SELECT placa,fecha FROM mantenimiento_alertas WHERE placa='$placa' and fecha='$fecha_actual'");
	//si no se ha envíado alerta, inserta dato para que no se envíe mas durante el día
	if ($verif_placa-> num_rows==0) {
			//Busca los remitentes según sede a la que pertenece vehículo 
			$busca_cc=mysqli_query($conexion,"SELECT NOMBRE,correo FROM usuario where codigo_pais='$pais' and TIPO='Oper_carros' and alerta_mantenimiento='S' and Id_depto='$id_depto' ");

			$inserta=mysqli_query($conexion,"INSERT mantenimiento_alertas (placa,fecha) VALUES ('$placa','$fecha_actual')");
			/*************************Envía correo *************************************/
		    //$destinatariodess=$bs_correo['correo'];
		    //$nombredess=$bs_correo['NOMBRE'];
		    $asunto="Alerta mantenimiento ".$placa." - ". $agencia;
		    $nombre_rem="SICOEP";
		    $correo_rem=$bs_remitente['correo'];
		    /////////************/////////////////////////////
		    		///////**********Usuario y clave para envío de correos configurado desde bd******************///////
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
		    $mail->Password = $server_correoPass;                           // SMTP password
		    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 587; 

		    $mensaje="El vehículo placas No.".$placa." asignado a ".$agencia. " necesita programar mantenimiento preventivo. <br> Kilometros restantes para mantenimiento ".$resta;

		    $mail->setFrom($correo_rem, $nombre_rem);
		    $mail->addReplyTo($correo_rem,$nombre_rem);
		    $mail->Subject = $asunto;
		    //imprime todos los correos a los que va copiado según usuarios asignados a esa sede para resibir correo
		    while ($fila_cc=mysqli_fetch_array($busca_cc)) {
		    	$mail->addCC($fila_cc['correo']);
		    }
		    
		    
		    
		    $mail->Body    = $mensaje;
		    $mail->AltBody = $mensaje;
		    //indico destinatario
		    
		    while ($row=mysqli_fetch_array($b_correo)) {
      					$mail->addAddress($row['correo'],$row['NOMBRE']);
    				}              // Name is optional
		    
		    if(!$mail->send()) {
		    echo 'Error al enviar: ' . $mail->ErrorInfo;
		    } else {
		    echo "Mensaje enviado!";
    /*************************Envía correo *************************************/
    }
		}	
}




mysqli_close($conexion);
?>