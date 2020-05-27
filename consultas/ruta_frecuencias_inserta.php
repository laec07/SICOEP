<?php
include("../conexion.php");
session_start();

  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}
$pais=$_SESSION['usuario']['codigo_pais'];
$nombre_f=$_POST['n_f'];
$km_f=$_POST['km_f'];
$cl_f=$_POST['cl_f'];
$ruta=$_POST['ruta'];
$r_f=$_POST['r_f'];

$b_fre=mysqli_query($conexion,"SELECT * FROM rutas_frecuencia where ruta='$ruta' and frecuencia='$nombre_f' and codigo_pais='$pais'");
$json = array();

if (mysqli_num_rows($b_fre)==0) {
	$inserta=mysqli_query($conexion,"INSERT INTO rutas_frecuencia (ruta, frecuencia, km, clientes,recorrido, codigo_pais) VALUES ('$ruta', '$nombre_f', '$km_f', '$cl_f','$r_f', '$pais')");

		if ($inserta) {
			$json['success'] = true;
    		$json['message'] = 'Lista guardada';
    		$json['data'] = 'Datos encontados ';
		}else{
			$json['success'] = false;
  			$json['message'] = 'Error al ingresar los datos, comuniquese con el administrador del sistema.';
  			$json['data'] = null;
		}	
}else{
	$json['success'] = false;
  	$json['message'] = "Ya existe registro con mismo nombre para esta ruta, verifique!!";
  	$json['data'] = "Ya existe registro con mismo nombre para esta ruta, verifique!!";
  	mysqli_free_result( $b_fre);
}

//Liberar la conexión
mysqli_close( $conexion );

//Retornamos el nuestro arreglo en formato JSON, recuerda agregar el encabezado, es indispensable para el navegador
//Saber que tipo de información estas enviando
header('Content-Type: application/json');
echo json_encode( $json );




?>