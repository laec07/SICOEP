<?php
	include'../conexion.php';
	session_start();
//***************************************/
	date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y-m-d");
$mes_actual= Date("m");
$año_actual= date("Y");
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
//////////////////////////////////////////////////////////////
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
} else{
$monto_presupuesto=$_POST['monto_presupuesto'];

$busca=mysqli_query($conexion,"SELECT * FROM mantenimiento_vehiculo_presupuesto where codigo_pais='$pais' and MONTH(fecha)='$mes_actual'");

if (mysqli_num_rows($busca)>0) {
	$updt=mysqli_query($conexion,"UPDATE mantenimiento_vehiculo_presupuesto SET monto='$monto_presupuesto',usuario_actualiza='$usuario' WHERE  codigo_pais='$pais' and month(fecha)='$mes_actual'");
	if ($updt) {
		echo "
			<script>
				alert('Actualizado correctamente');
				history.go(-1);
			</script>
		";

	}else{
		echo "Error al ctualizar";
	}
}else{
	$insert=mysqli_query($conexion,"INSERT INTO mantenimiento_vehiculo_presupuesto (fecha, monto, codigo_pais, usuario_actualiza) VALUES ('$fecha_actual', '$monto_presupuesto', '$pais', '$usuario')");
	if ($insert) {
		echo "
			<script>
			alert('Ingresado correctamente');
			history.go(-1);
			</script>
		";
	}else{
		echo "Error al ingresar";
	}
}



}  
?>