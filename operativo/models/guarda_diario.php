<?php
include ("../../conexion.php");
session_start();
date_default_timezone_set('America/Guatemala');
if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
}else{
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
$sede=$_SESSION['usuario']['Id_depto'];
////////////////////////////////////
$placa=$_POST['placa'];
$fecha=$_POST['fecha'];
$kilometraje=$_POST['kilometraje'];
$observaciones=$_POST['observaciones'];
$fecha_actual= Date("Y-m-d");
///////////////////////////////////
//Busca si no se ha insertado con fecha seleccionada


$ex=mysqli_query($conexion,"SELECT * FROM mov_diario WHERE Fecha='$fecha' and id_equipo='$placa'");

if ($ex-> num_rows ==1) {//alerta si ya se inserto
	echo"
		<script>
			alert('Ya existe registro del vehiculo placas ".$placa." con fecha ".$fecha.", Puede editar la información en el apartado de abajo.');
		</script>

	";
}else{
//busca si existe registro anterior para actualizar kilomentraje de entrada
$bs=mysqli_query($conexion,"
	SELECT
			MAX(ID) as id
		FROM
			mov_diario
		WHERE
			id_equipo = '$placa'");
//si existe actualiza kilometraje entrada y suma total kilometros recorridos del día anterior
if ($bs-> num_rows == 1) {
	$bs_id=mysqli_fetch_array($bs);
	$u_id=$bs_id['id'];

	$actualiza=mysqli_query($conexion,"UPDATE mov_diario SET km_entrada='$kilometraje',km_recorrido=km_entrada-km_salida, observaciones='$observaciones' WHERE ID='$u_id' and id_equipo='$placa'");
	if (!$actualiza) {
		echo"
	<script>
	alert('Error al actualizar dato');
	</scritp>
	";
	}
}
//inserta nuevo registro, exista o no exista anterior.
$inserta=mysqli_query($conexion,
"
INSERT mov_diario (
	id_equipo,
	Fecha,
	km_salida,
	codigo_pais,
	usuario,
	id_depto
)
VALUES
	('$placa',
	'$fecha',
	'$kilometraje',
	'$pais',
	'$usuario',
	'$sede'
	)
");
if ($inserta) {
	//Actualiza el kilometraje actual del vehículo
	$upd_vehi=mysqli_query($conexion,"UPDATE vehiculo SET Kilometraje='$kilometraje' WHERE id_equipo='$placa' ");
	if ($fecha<$fecha_actual) {
		echo"
		<script>
		alert('Registró movimiento de vehiculo con fecha menor a la de hoy, lo correcto es registrar movimiento del vehículo en fecha actual  Registro guardado.')
		</script>
		";
  
}

}else{
	echo"
	<script>
	alert('Error al insertar el dato');
	</scritp>
	";
}

}
}
?>