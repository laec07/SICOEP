<?php
 include ("../conexion.php");
 session_start();
 $pais=$_SESSION['usuario']['codigo_pais'];
 $ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
 /////////////////////////////////////////////
$f1=$_GET['f1'];
$f2=$_GET['f2'];
$canal=$_GET['canal'];

//$ruta=$_POST['ruta'];
///////////////////////////////////////////////////////
if ($canal=='TODOS') {
  $f_canal='';

}else{
  $f_canal="AND cd.canal='$canal'";
}
//////////////////////////////////////////////////////
  /*******************************************************************************************/
header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=ReporteCombustibleCanal.xls");
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
  cd.precio,
  cd.total,
  cd.observaciones
FROM
  combustible_detalle cd
LEFT JOIN depto d ON d.Id_depto = cd.id_depto
LEFT JOIN ruta r ON r.id_ruta = cd.id_ruta
WHERE
  fecha BETWEEN '$f1'
AND '$f2'
$f_canal
ORDER BY Depto,canal,ruta,fecha
  ");
 ?>

    
<!DOCTYPE html>
<html>
<head>
  <title>SICOEP</title>
  <meta charset="utf-8">
</head>
<body>
<div class='box box-info'>
      <div class='box-header with-border'>
      <h3>Reporte combustibe -SICOEP-</h3>
        <h4 class='box-title'> General - <?php echo $canal;?> - <small>Del: <?php echo date_format(new Datetime($f1),'d/m/Y')?> Al: <?php echo date_format(new Datetime($f2),'d/m/Y')?></small></h4>
        <a href='combustible_cExcel.php?f1=$f1&f2=$f2&canal=$canal' class='btn btn-success pull-right' title='Descargar reporte'><i class='fa fa-file-excel-o'></i></a>
      </div>
      <div class='box-body'>
      <div style='overflow:scroll;height: 100%  ' >
        <table class='table table-hover table-bordered table-striped' id='example2'>
          <thead>
            <tr>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Canal</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" ># solicitud</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Ruta</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Piloto</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Tipo Vehi</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Placas</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Depto</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Fecha</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Tipo Comb.</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Cant. Gal.</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Precio</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Total</th>
              <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Observaciones</th>
            </tr>
          </thead>
          <tbody>
           
          <?php
            while ($f_rpt=mysqli_fetch_array($rpt_depto)) {
              echo "
                <tr>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['canal']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['id_solicitud']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['ruta']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['piloto']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['tipo_vehi']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['id_equipo']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['Depto']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".date_format(New datetime($f_rpt['fecha']),'d/m/Y')." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['tipo_combustible']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['precio']." </td>
                  <td style='border:1px solid #000;padding: 10px' >".$f_rpt['galones']." </td>
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
    </div>
</body>
</html>		


