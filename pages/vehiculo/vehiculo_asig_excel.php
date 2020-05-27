<?php
include("../../conexion.php");
session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
/***********************************************************/

header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=h_asig_sicoep.xls");
header("Pragma: no-cache");
header("Expires: 0");
/***********************************************************/
$placa=$_GET['placa'];
/***************************************************************/
$asignaciones=mysqli_query($conexion,"
SELECT
  a.Fecha,
  d.Depto,
  a.canal,
  u.Usuario,
  a.fecha_accesorios,
  a.fecha_fotos,
  a.llanta_der_delantera,
  a.llanta_der_trasera,
  a.llanta_iz_delantera,
  a.llanta_iz_trasera,
  a.Observaciones,
  a.kilometraje,
  a.Estado_asig,
  a.fecha_baja
FROM
  asignacion_vehiculo a, depto d,usuarios u
WHERE
  Id_equipo = '$placa'
AND d.Id_depto=a.Id_depto AND a.Id_usuario=u.Id_usuario ORDER BY Fecha DESC

  ");
/***********************************************************/
?>
<!DOCTYPE html>
<html>
<head>
	<title>SICOEP</title> 
	<meta charset="utf-8">
</head>
<body>
<table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Fecha</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Depto</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Canal</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Usuario</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >F.accesorios</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >F.fotos</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;"  >IZ. D.</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;"  >DER. D.</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;"  >IZ. T.</th>
                    <th   style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >DER. T.</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Obs.</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Kilometraje</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Estado Asig.</th>
                    <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Fecha baja</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while ($fila=mysqli_fetch_array($asignaciones)) {
                      echo "
                        <tr>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['Fecha']."</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['Depto']."</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['canal']."</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['Usuario']."</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['fecha_accesorios']."</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['fecha_fotos']."</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['llanta_iz_delantera']."%</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['llanta_der_delantera']."%</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['llanta_iz_trasera']."%</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['llanta_der_trasera']."%</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['Observaciones']."</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['kilometraje']."</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['Estado_asig']."</td>
                          <td style='border:1px solid #000;padding: 10px' >".$fila['fecha_baja']."</td>
                        </tr>


                      ";
                    }
                  ?>
                </tbody>

          </table>
</body>
</html>