<?php
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}else{
include ("../conexion.php");
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y-m-d");

$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
$id_usuario=$_POST['id_usuario'];


$est_asp=mysqli_query($conexion,"SELECT estado FROM usuarios WHERE Id_usuario='$id_usuario'");
$rest_asp=mysqli_fetch_array($est_asp);
$estado=$rest_asp['estado'];

if ($estado=='ACTIVO') {//Inicia If 0


	//catalogo  estado P="Pendiente", esto para poder editarlo
	$insert_pp=mysqli_query($conexion,"
	INSERT INTO pm_pruebapiloto (
		Id_usuario,
		USUARIO,
		estatus,
		fecha_ingresa,
		codigo_pais
	)
	VALUES
		('$id_usuario', '$usuario', 'P','$fecha_actual', '$pais')

	");
	if ($insert_pp) {//inicia if 1
		$id=mysqli_query($conexion,"SELECT id_prueba FROM pm_pruebapiloto ORDER BY id_prueba DESC LIMIT 1");
		$rid=mysqli_fetch_array($id);
		$idt=$rid['id_prueba'];

		//Inserta datos en detalle para evaluar preguntas según ID de prueba
		$insert_dp=mysqli_query($conexion,"
		INSERT INTO pm_pruebapiloto_detalle SELECT
			'$idt',
			id_pregunta,
			' '
		FROM
			pm_pregunta
		WHERE
			estatus = 'A'

		");

		$update=mysqli_query($conexion,"UPDATE usuarios SET estado='PENDIENTE' WHERE Id_usuario='$id_usuario'");




	}//finaliza if 1
	else
	{
		PRINT "Ocurrio error mientras se insertaba registro.";
	}//finaliza eslse if 1
echo $id_usuario;
}//finaliza If 0
else
{
	echo "F";
}//finaliza Else If 0


mysqli_close($conexion);
}