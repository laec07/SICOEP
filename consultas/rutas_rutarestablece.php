<?php
include("../conexion.php");
session_start();
$id_ruta=$_POST['id_ruta'];

mysqli_query($conexion,"UPDATE ruta SET restantes_gal=asignado_gal where id_ruta='$id_ruta' ");

echo "
        <script>
        		
            history.go(-1);
        </script>
";

mysqli_close($conexion);
?>