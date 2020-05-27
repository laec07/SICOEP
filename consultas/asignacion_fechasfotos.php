<?php
include("../conexion.php");
session_start();
$placa=$_POST['placa'];
echo"
<label for='facc'>Fecha fotos:</label>
<select    class='form-control'  >
";
  $foto=mysqli_query($conexion,"
SELECT
  fecha
FROM
  foto_vehi
WHERE
  id_equipo = '$placa'
GROUP BY
  fecha
ORDER BY
  fecha DESC
    ");

    while ($fila=mysqli_fetch_array($foto)) {
      echo "
        <option value='".date_format(new Datetime($fila['fecha']),'Y-m-d')."'>".htmlentities(date_format(new Datetime($fila['fecha']),'d-m-Y'))."</option>
      ";
    }
echo "</select>";

?>