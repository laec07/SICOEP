<?php
include ("../conexion.php"); 
session_start();
 if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}else{
$placa=$_POST['placa'];
$ruta=$_POST['ruta'];
$id_ruta=$_POST['id_ruta'];
$id_depto=$_POST['id_depto'];
$mes=$_POST['mes'];
$monto=$_POST['monto'];
$descripcion=$_POST['descripcion'];
$usuario=$_SESSION['USUARIO']['USUARIO'];
$pais=$_SESSION['usuario']['codigo_pais'];


$inserta = mysqli_query($conexion,
	"
INSERT INTO pago_deducible (
	id_equipo,
	id_ruta,
	month,
	
	ruta,
	monto,
	descripcion,
	codigo_pais,
	id_depto,
	usuario
)
VALUES
	(
		'$placa',
		'$id_ruta',
		'$mes',

		'$ruta',
		'$monto',
		'$descripcion',
		'$pais',
		'$id_depto',
		'$usuario'
	)
	");

if ($inserta) {
	echo "Insertado correctamente";
}else{
	echo "error al insertar";
}

} 



?>