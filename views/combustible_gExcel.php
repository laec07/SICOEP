<?php
 include ("../conexion.php");
 session_start();
 $pais=$_SESSION['usuario']['codigo_pais'];
 $ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
 /////////////////////////////////////////////
$f1=$_GET['f1'];
$f2=$_GET['f2'];
$depto=$_GET['depto'];
$check=$_GET['check'];
////////////////////////////////////////////////////
$in_depto=mysqli_query($conexion,"SELECT * FROM depto where Id_depto='$depto'");
$inf_depto=mysqli_fetch_array($in_depto);
$info_depto=$inf_depto['Depto'];
$info_depto="-".$inf_depto['Depto'];
///////////////////////////////////////////////////////
if ($depto=='TODOS') {
  $f_depto='';
  $info_depto='';
}else{
  $f_depto="AND cd.id_depto='$depto'";
}
//////////////////////////////////////////////////////
  /*******************************************************************************************/
header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=ReporteCombustibleSede.xls");
header("Pragma: no-cache");
header("Expires: 0");
 /***********************************************************************************/
/////////////////////////////////////////////////////
$rpt_depto=mysqli_query($conexion,"
SELECT
  cd.id_depto,
  d.Depto,
  cd.id_solicitud,
  cd.id_ruta,
  cd.ruta,
  r.piloto,
  r.tipo_vehi,
  r.id_equipo,
  cd.canal,
  cd.fecha,
  cd.galones,
  cd.tipo_combustible,
  tp.descripcion,
  cd.precio,
  cd.idp,
  cd.total_sin_idp,
  cd.base,
  cd.total,
  cd.observaciones,
  cs.estatus
FROM
  combustible_detalle cd
LEFT JOIN depto d ON d.Id_depto = cd.id_depto
LEFT JOIN ruta r ON r.id_ruta = cd.id_ruta
LEFT JOIN combustible_solicitud cs ON cs.id_solicitud=cd.id_solicitud
JOIN tipo_combustible tp ON tp.id_tipocombustible=cd.id_tipocombustible
WHERE
  cd.fecha BETWEEN '$f1'
AND '$f2'
$f_depto
AND cs.estatus='APROBADO'
ORDER BY Depto,canal,ruta,fecha
  ");

if ($check=='true') {
    $th_idp="
              <th style='border:1px solid #000;background: #CC0033;color:#fff;text-align: center;'>IDP</th>
              <th style='border:1px solid #000;background: #CC0033;color:#fff;text-align: center;'>Total sin IDP</th>
              <th style='border:1px solid #000;background: #CC0033;color:#fff;text-align: center;'>Base</th>
    ";
}else{
    $th_idp="        
    ";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>SICOEP</title>
  <meta charset="utf-8">
</head>
<body>
  <div >
      <div >
        <h3>Reporte combustibe -SICOEP-</h3>
        <h4 class='box-title'> General - <?php echo $info_depto;?> - <small>Del: <?php echo date_format(new Datetime($f1),'d/m/Y');?> Al: <?php echo date_format(new Datetime($f2),'d/m/Y');?></small></h4>
       
      </div>
      <div >
      
        <table >
          <thead>
            <tr>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Depto</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" ># solicitud</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Ruta</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Piloto</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Tipo Vehi</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Placas</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Canal</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Fecha</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Tipo Comb.</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Cant. Gal.</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Precio</th>
              <?php echo $th_idp;?>
              
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Total</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Observaciones</th>
            </tr>
          </thead>
          <tbody>
           <?php
       
            while ($f_rpt=mysqli_fetch_array($rpt_depto)) {

              if ($check=='true') {
                


                  $td_idp="
                                <td style='border:1px solid #000;padding: 10px'>".$rps['moneda'].number_format($f_rpt['idp'],2,'.',',')." </td>
                                <td style='border:1px solid #000;padding: 10px'>".$rps['moneda'].number_format($f_rpt['total_sin_idp'],2,'.',',')." </td>
                                <td style='border:1px solid #000;padding: 10px'>".$rps['moneda'].number_format($f_rpt['base'],2,'.',',')." </td>
                  ";
                  
              }else{
                  $td_idp="          
                  ";
              }

              echo "
                <tr>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['Depto']."</td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['id_solicitud']."  </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['ruta']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['piloto']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['tipo_vehi']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['id_equipo']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['canal']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['fecha']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['descripcion']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['galones']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$rps['moneda'].number_format($f_rpt['precio'],2,'.',',')."  </td>
                  $td_idp
                  
                  <td style='border:1px solid #000;padding: 10px' >".$rps['moneda'].number_format($f_rpt['total'],2,'.',',')." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['observaciones']." </td>
                </tr>
              ";
           
            }
            ?>
           
          </tbody>
          
        </table>
        
        </div>
    </div>
    
</body>
</html>
    

 ?>

