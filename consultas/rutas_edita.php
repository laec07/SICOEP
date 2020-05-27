<?php
include("../conexion.php");
session_start();

$id_ruta=$_POST['id_ruta'];
$estado=$_POST['estado'];
$piloto=$_POST['piloto'];
$tipo=$_POST['tipo'];
$placa=$_POST['placa'];
$canal=$_POST['canal'];
$ruta=$_POST['ruta'];

mysqli_query($conexion,"
	UPDATE ruta 
	SET 
		ruta='$ruta',
		estado='$estado',
		piloto='$piloto',
		canal='$canal',
		tipo_vehi='$tipo',
		id_equipo='$placa' 
	WHERE 
		id_ruta='$id_ruta'");

echo "
        <script>
            history.go(-1);
        </script>
";

mysqli_close($conexion);
?>