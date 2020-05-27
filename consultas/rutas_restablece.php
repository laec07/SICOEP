<?php
include("../conexion.php");
session_start();
$id_depto=$_GET['id_depto'];

mysqli_query($conexion,"UPDATE ruta SET restantes_gal=asignado_gal where id_depto='$id_depto' ");

echo "
        <script>
        		
            history.go(-1);
        </script>
";

mysqli_close($conexion);
?>