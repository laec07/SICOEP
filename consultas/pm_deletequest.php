<?php
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}else{
include ("../conexion.php");
$pais=$_SESSION['usuario']['codigo_pais'];


$id_quest=$_POST['id_quest'];
$edit_criterio=$_POST['edit_criterio'];
$edit_tipo_pregunta=$_POST['edit_tipo_pregunta'];
$edit_titulo=$_POST['edit_titulo'];
$edit_descripcion=$_POST['edit_descripcion'];
$edit_estatus=$_POST['edit_estatus'];

$insert=mysqli_query($conexion,"
UPDATE pm_pregunta
SET 
 estatus = 'D'
WHERE
    id_pregunta = '$id_quest'

    ") or die (mysql_error($conexion));

echo $id_quest;



mysqli_close($conexion);
} 
?>