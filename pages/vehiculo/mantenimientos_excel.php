<?php
 include ("../../conexion.php");
 session_start();
 /*******************************************************************************************/
 $em=$_SESSION['usuario']['id_empresa'];
$datos_empresa=mysqli_query($conexion,"SELECT * FROM empresa where id_empresa='$em'");
$empresa=mysqli_fetch_array($datos_empresa);
$pais=$_SESSION['usuario']['codigo_pais'];
$sede=$_SESSION['usuario']['Id_depto'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
 /*******************************************************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
$mes_actual= Date("m");
$año_actual= date("Y");
/*
$fi=$_POST['inicio'];
$ff=$_POST['fin'];
$v_tipo=$_POST['tipo'];
$v_placa=$_POST['idequip'];
 /*******************************************************************************************/

header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=bitacora_sicoep.xls");
header("Pragma: no-cache");
header("Expires: 0");
 /*******************************************************************************************/
$query=mysqli_query($conexion,
  " 
SELECT
  mv.ID,
  mv.Id_equipo,
  v.Equipo,
  v.Modelo,
  v.Marca,
  mv.Fecha,
  t.tipo_mantenimiento,
  mv.Observaciones,
  mv.Kilometrajem,
  mv.serie_fact,
  mv.no_fact,
  mv.costo,
  mv.codigo_pais,
  p.proveedor,
  mv.canal,
  a.Id_depto,
  d.Depto
FROM
  mantenimiento_vehiculo mv
INNER JOIN vehiculo v ON v.Id_equipo = mv.Id_equipo
LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
AND a.Estado_asig = 'ACTIVO'
LEFT JOIN depto d ON d.Id_depto = a.Id_depto
LEFT JOIN proveedor p ON p.id_proveedor = mv.id_proveedor
LEFT JOIN tipo_mantenimiento t ON t.id_tipomantenimiento=mv.id_tipomantenimiento
WHERE
mv.codigo_pais='$pais'
AND MONTH(mv.Fecha)='$mes_actual' and YEAR(mv.Fecha)='$año_actual'
  ");
 /*******************************************************************************************/
 /*******************************************************************************************/
 /*******************************************************************************************/ 
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">	
	<title>sicoep</title>
<meta charset="utf-8">
</head>
<body>
<table >
                <thead>
                  <tr>               
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Fecha</th>
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Placa.</th>
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Tipo</th>
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Marca.</th>

                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Canal</th>
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Depto</th>
                  
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Tipo mantenimiento</th>
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Obs. Mantenimiento</th>
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Proveedor</th>
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Serie Fact.</th>
                  <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">No. Fact.</th>
                 <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Costo</th>
                  
                </tr>   
                </thead>
                <tbody>
                <?php
               
                  while ($fila=mysqli_fetch_array($query)) {
                    echo"
                    <tr>
                      <td style='border:1px solid #000;padding: 10px' >".date_format(new Datetime($fila['Fecha']),'Y/m/d' )."</td>
                      <td style='border:1px solid #000;padding: 10px' >".$fila['Id_equipo']."</td>
                      <td style='border:1px solid #000;padding: 10px' >".$fila['Equipo']."</td>
                      <td style='border:1px solid #000;padding: 10px' >".$fila['Marca']."</td>
                      <td style='border:1px solid #000;padding: 10px' >".$fila['canal']."</td>
                      <td style='border:1px solid #000;padding: 10px' >".$fila['Depto']."</td>
                      <td style='border:1px solid #000;padding: 10px' >".$fila['tipo_mantenimiento']."</td>
                      <td style='border:1px solid #000;padding: 10px' >".$fila['Observaciones']."</td>
                      <td style='border:1px solid #000;padding: 10px' >".$fila['proveedor']."</td>
                      <td style='border:1px solid #000;padding: 10px'>".$fila['serie_fact']."</td>
                      <td style='border:1px solid #000;padding: 10px'>".$fila['no_fact']."</td>
                      <td style='border:1px solid #000;padding: 10px' >".$fila['costo']."</td>

                    </tr>

                    ";
                  
                  }
                  
                ?>
                </tbody>

          </table>
</body>
</html>