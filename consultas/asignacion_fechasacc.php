<?php
include("../conexion.php");
session_start();
$placa=$_POST['placa'];
echo"
<label for='facc'>Fecha revisión accesorios:</label>
<select    class='form-control' id='faccs' name='facss' >
";

  $acc=mysqli_query($conexion,"
SELECT 
  Id_accesorio,
  fecha_ingreso AS fecha,
  id_equipo
FROM
  accesorios
WHERE
  id_equipo = '$placa'
GROUP BY
  fecha
ORDER BY
  fecha desc
    ");

    while ($filar=mysqli_fetch_array($acc)) {
      echo "
        <option value='".date_format(new Datetime($filar['fecha']),'Y-m-d')."'>".htmlentities(date_format(new Datetime($filar['fecha']),'d-m-Y'))."</option>
      ";
    }
    echo "</select>";
/*
$idSelectOrigen=$_GET['select'];
$opcionSeleccionada=$_GET['opcion'];
$usuario=$_SESSION['usuario'];
if($idSelectOrigen == "equip")
    echo "
<label for='facc'>Fecha accesorios :</label>
<select name='facc' id='facc' class='form-control'>
";


	$acc=mysqli_query($conexion,"
SELECT 
  Id_accesorio,
  fecha_ingreso AS fecha,
  id_equipo
FROM
  accesorios
WHERE
  id_equipo = '$opcionSeleccionada'
GROUP BY
  fecha
ORDER BY
  fecha desc
		");

    while ($filar=mysqli_fetch_array($acc)) {
    	echo "
    		<option value='".date_format(new Datetime($filar['fecha']),'Y-m-d')."'>".htmlentities(date_format(new Datetime($filar['fecha']),'d-m-Y'))."</option>
    	";
    }
*/

?>