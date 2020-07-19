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



$ins_criterio=$_POST['ins_criterio'];
$ins_tipo_pregunta=$_POST['ins_tipo_pregunta'];
$ins_titulo=$_POST['ins_titulo'];
$ins_descripcion=$_POST['ins_descripcion'];

$insert=mysqli_query($conexion,"
INSERT INTO pm_pregunta (
    id_tipopregunta,
    id_criterio,
    titulo,
    descripcion,
    estatus,
    codigo_pais
)
VALUES
    (
        '$ins_tipo_pregunta',
        '$ins_criterio',
        '$ins_titulo',
        '$ins_descripcion',
        'A',
        '$pais'
    )

    ");

mysqli_close($conexion);
} 
?>