<?php
include("../../conexion.php");
session_start();
$codigo_pais=$_SESSION['usuario']['codigo_pais'];

$year=$_POST['year'];
$year=$_POST['fecha'];

 $sin_asignar=mysqli_query($conexion,"SELECT t.ID,t.tarea,m.fecha_mov,a.tipo_tarea,t.email,t.mensaje,t.prioridad,t.solicitante,t.estatus FROM tarea t,mov_tarea m,tipo_tarea a WHERE t.ID=m.ID_tarea AND t.id_tipotarea=a.id_tipotarea AND m.ID_tarea='$id' ");

?>