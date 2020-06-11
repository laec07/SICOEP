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
$usuario=$_SESSION['usuario']['USUARIO'];
//datos importados
$placa=$_POST['placa'];
$descripcion=$_POST['descripcion'];
//datos archivo
$nombre_temporal = $_FILES['archivo']['tmp_name'];

$nombre = $_FILES['archivo']['name'];

$actual_name = pathinfo($nombre,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($nombre, PATHINFO_EXTENSION);
//Ruta a donde guardar archivo
$ruta="files/".$placa."/archivos/";
//Si no existe directorio, lo crea
if(!file_exists($ruta)){
     mkdir($ruta);
}
//archivo completo para validar si existe


$i = 1;
while(file_exists($ruta.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name."(".$i.")";
    $nombre = $actual_name.".".$extension;
    $i++;
}

$archivo=$ruta.$nombre;
//Traslada imagen de tem a servidor
move_uploaded_file($nombre_temporal, $ruta.$nombre);


$inserta=mysqli_query($conexion,"

INSERT INTO vehi_archivo (
	Id_equipo,
	name_file,
	file,
	observaciones,
	usuario,
	codigo_pais
)
VALUES
	('$placa', '$nombre', '$archivo', '$descripcion', '$usuario', '$pais')

	");



echo "Ingresado correctamente";






?> 