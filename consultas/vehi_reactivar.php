<?php
include ("../conexion.php");
$placa=$_GET['placa'];

$reactiva=mysqli_query($conexion,"UPDATE vehiculo SET Estado_equipo='ACTIVO' where Id_equipo='$placa'");
if ($reactiva) {
    echo"
        <script>
            history.go(-1);
        </script>
    ";
}else{
    echo"
    <script>
            alert('Error al actualizar estado vehiculo');
            history.go(-1);
        </script>
    ";
}
?>