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

$fi=$_GET['inicio'];
$ff=$_GET['fin'];
$v_tipo=$_GET['tipo'];
$v_placa=$_GET['idequip'];
$sede=$_GET['sede'];
 /*******************************************************************************************/
 if ($v_tipo=='Todos') {

  $var2_tipo="";
}else{

  $var2_tipo="AND id_tipomantenimiento='$v_tipo'";
}
if ($v_placa=='Todos') {

  $var2_placa="";
}else{

  $var2_placa="AND Id_equipo='$v_placa'";
}

if ($sede=='TODOS') {
  $sede_b2="";
}else{
  $sede_b2="AND Id_depto='$sede' ";
}
 /*******************************************************************************************/
header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=por_gasto_sicoep.xls");
header("Pragma: no-cache");
header("Expires: 0");
 /*******************************************************************************************/
$tipo=mysqli_query($conexion, "SELECT
    ve.id_equipo,
    a.llantas,
    b.baterias,
    c.servicio_correctivo,
    d.Reparacion,
    e.Servicio_Preventivo,
    f.Inversion,
    g.Enderezado_y_pintura,
    h.Servicio_Mayor,
    i.deducible_siniestro,
    ve.codigo_pais
FROM
    (
        (
            vehiculo ve
            LEFT JOIN (
                SELECT
                    mv.id_equipo,
                    sum(mv.costo) llantas,
                    mv.Fecha
                FROM
                    mantenimiento_vehiculo mv
                LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
                AND a.Estado_asig = 'ACTIVO'
                WHERE
                    id_tipomantenimiento = '4'
                AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
                GROUP BY
                    id_equipo
            ) a ON ve.id_equipo = a.id_equipo
        )
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Baterias,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '1'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) b ON ve.id_equipo = b.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Servicio_correctivo,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '6'
            AND mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) c ON ve.id_equipo = c.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Reparacion,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '5' 
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) d ON ve.id_equipo = d.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Servicio_Preventivo,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '8'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) e ON ve.id_equipo = e.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Inversion,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '3'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) f ON ve.id_equipo = f.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Enderezado_y_pintura,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '2'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) g ON ve.id_equipo = g.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) Servicio_Mayor,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '7'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY 
                id_equipo
        ) h ON ve.id_equipo = h.id_equipo
        LEFT JOIN (
            SELECT
                mv.id_equipo,
                sum(mv.costo) deducible_siniestro,
                mv.Fecha
            FROM
                mantenimiento_vehiculo mv
            LEFT JOIN asignacion_vehiculo a ON a.Id_equipo = mv.Id_equipo
            AND a.Estado_asig = 'ACTIVO'
            WHERE
                id_tipomantenimiento = '9'
            AND  mv.Fecha BETWEEN '$fi' AND '$ff' $var_placa $sede_b2
            GROUP BY
                id_equipo
        ) i ON ve.id_equipo = i.id_equipo

)
WHERE ve.codigo_pais='$pais'
");

 /*******************************************************************************************/
 /*******************************************************************************************/
 /*******************************************************************************************/ 
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">	<td  >
	<title>sicoep</title>
<meta charset="utf-8">
</head>
<body>
<table >
      <thead>
          <tr>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Placa</th>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Llantas</th>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Batería</th>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Serv.correctivo</th>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Serv.Preventivo</th>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Reparación</th>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Inversión</th>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">End. y Pintura</th>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Serv.Mayor</th>
              <th  style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Total</th>    
          </tr>
      </thead>
  
<?php 
    $fila=0;
    $llantas=0;
    $bater=0; 
    $scorec=0;
    $spre=0;
    $rep=0;
    $inver=0;
    $ende=0;
    $smayor=0; 
    $gene=0;
    while ($rquery=mysqli_fetch_array($tipo)) {
        $fila=($rquery['llantas']+$rquery['baterias']+$rquery['servicio_correctivo']+$rquery['Servicio_Preventivo']+$rquery['Reparacion']+$rquery['Inversion']+$rquery['Enderezado_y_pintura']+$rquery['Servicio_Mayor']);
       if ($fila > 0) {
        echo "
            <tr>
            <td style='border:1px solid #000;padding: 10px'>".$rquery['id_equipo']."</td>
            <td style='border:1px solid #000;padding: 10px'>".$rquery['llantas']."</td>
            <td style='border:1px solid #000;padding: 10px'>".$rquery['baterias']."</td>
            <td style='border:1px solid #000;padding: 10px'>".$rquery['servicio_correctivo']."</td>
            <td style='border:1px solid #000;padding: 10px'>".$rquery['Servicio_Preventivo']."</td>
            <td style='border:1px solid #000;padding: 10px'>".$rquery['Reparacion']."</td>
            <td style='border:1px solid #000;padding: 10px'>".$rquery['Inversion']."</td>
            <td style='border:1px solid #000;padding: 10px'>".$rquery['Enderezado_y_pintura']."</td>
            <td style='border:1px solid #000;padding: 10px'>".$rquery['Servicio_Mayor']."</td>
            <td style='border:1px solid #000;padding: 10px'>".$fila."</td>
            </tr>
        ";
        }
       $llantas += $rquery['llantas'];
       $bater += $rquery['baterias'];
       $scorec += $rquery['servicio_correctivo'];
       $spre += $rquery['Servicio_Preventivo'];
       $rep += $rquery['Reparacion'];
       $inver += $rquery['Inversion'];
       $ende += $rquery['Enderezado_y_pintura'];
       $smayor += $rquery['Servicio_Mayor'];
       $gene += $fila;
    }
    echo "
        <tfoot>
            <th style='border:1px solid #000;padding: 10px'>Total General</th>
            <th style='border:1px solid #000;padding: 10px'>".$llantas."</th>
            <th style='border:1px solid #000;padding: 10px'>".$bater."</th>
            <th style='border:1px solid #000;padding: 10px'>".$scorec."</th>
            <th style='border:1px solid #000;padding: 10px'>".$spre."</th>
            <th style='border:1px solid #000;padding: 10px'>".$rep."</th>
            <th style='border:1px solid #000;padding: 10px'>".$inver."</th>
            <th style='border:1px solid #000;padding: 10px'>".$ende."</th>
            <th style='border:1px solid #000;padding: 10px'>".$smayor."</th>
            <th style='border:1px solid #000;padding: 10px'>".$gene."</th>
            
        </tfoot>
        ";

?>
       
  </table>
</body>
</html>