<?php 
require 'conexion.php';
sleep(1);
session_start();
/**************************************************/

	$usuario=$_POST['usuariolog'];
	$clave=$_POST['passlg'];


/**************************************************/

$usuarios= mysqli_query($conexion,
	"SELECT 
		NOMBRE, 
		USUARIO, 
		CLAVE, 
		TIPO, 
		codigo_pais, 
		Id_depto, 
		cod_area, 
		id_empresa,
		foto 
	FROM 
		usuario 
	WHERE 
		USUARIO = '$usuario' 
	AND CLAVE = '$clave'
	");

if($usuarios-> num_rows == 1){ 
	$datos = $usuarios->fetch_assoc();
	$_SESSION['usuario'] = $datos;
	$hola='hola';
	setcookie('usuario',$_SESSION['usuario']['USUARIO'],time()+60*60*7);
	setcookie('clave',$_SESSION['usuario']['CLAVE'],time()+60*60*7);
	echo json_encode(array('error' => false, 'TIPO' => $datos['TIPO']));

}else{
	echo json_encode(array('error' => true , ));
}
;


?>