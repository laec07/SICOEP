<?php
include("../conexion.php");
$placa=$_POST['placa'];
$km=$_POST['km'];

$ult=mysqli_query($conexion,"SELECT MAX(ID) as id FROM mov_diario where id_equipo='$placa'");
$idult=mysqli_fetch_array($ult);
$id_ultimo=$idult['id'];
///////////////////////////////////////////////////////////
$ant=mysqli_query($conexion,"SELECT MAX(ID) as id FROM mov_diario where id_equipo='$placa' and km_entrada>0 AND km_recorrido>0");
$idant=mysqli_fetch_array($ant);
$id_anterior=$idant['id'];
///////////////////////////////////////////////////////
//actualiza ultimo registro de mov diaro
$update_ultimo=mysqli_query($conexion,"UPDATE mov_diario SET km_salida='$km' WHERE ID='$id_ultimo'");
//actualiza km entrada registro anterior para sumar km recorridos
$update_anterior=mysqli_query($conexion,"UPDATE mov_diario SET km_entrada='$km',km_recorrido=km_entrada-km_salida WHERE ID='$id_anterior'");
//actualiza km en tabla vehiculo
$update_vehi=mysqli_query($conexion,"UPDATE vehiculo SET Kilometraje='$km' where Id_equipo='$placa'");
//actualiza km actual en estado mantenimiento (se utiliza km vehiculo como km actual)
$update_mante=mysqli_query($conexion,"UPDATE estado_mantenimiento SET km_actual='$km' where id_equipo='$placa'");

?>