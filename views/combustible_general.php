<?php
 include ("../conexion.php");
 session_start();
 $pais=$_SESSION['usuario']['codigo_pais'];
 $ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
 /////////////////////////////////////////////
$f1=$_POST['f1'];
$f2=$_POST['f2'];


if (isset($_POST['depto'])) {
  $depto= implode("','", $_POST['depto']);
}else{

  $depto= "TODOS";
}




//$ruta=$_POST['ruta'];
///////////////////////////////////////////////////////
if ($depto=="TODOS") {
  $f_depto='';
}else{
  $f_depto="AND c.id_depto in ('$depto')";
}
//////////////////////////////////////////////////////

/////////////////////////////////////////////////////
$rpt_depto=mysqli_query($conexion,"
SELECT
  c.id_depto,
  d.Depto,
  SUM(c.total) AS total,
  SUM(c.galones) AS galones
FROM
  combustible_detalle c
LEFT JOIN depto d ON c.id_depto = d.Id_depto
LEFT JOIN combustible_solicitud cs ON c.id_solicitud = cs.id_solicitud
WHERE
  c.codigo_pais = '$pais'
AND c.fecha BETWEEN '$f1'
AND '$f2'
AND cs.estatus = 'APROBADO'
$f_depto 
GROUP BY
  c.id_depto
");

echo "
    <div class='box box-info'>
      <div class='box-header with-border'>
      
        <h4 class='box-title'>General <small>Del: ".date_format(new Datetime($f1),'d/m/Y')." Al: ".date_format(new Datetime($f2),'d/m/Y')."</small></h4>
      </div>
      <div class='box-body'>
        <table class='table table-hover table-bordered table-striped'>
          <thead>
            <tr>
              <th>Depto</th>
              <th>Galones</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
           ";
           $total=0;
           $galones=0;
            while ($f_rpt=mysqli_fetch_array($rpt_depto)) {
              echo "
                <tr>
                  <td>".$f_rpt['Depto']." </td>
                  <td>".$f_rpt['galones']." </td>
                  <td>".$rps['moneda'].number_format($f_rpt['total'],2,'.',',')." </td>
                  <td><a onclick='buscar_d(".$f_rpt['id_depto'].");'title='Ver detalles' ><li class='fa fa-eye'></li></a></td>
                </tr>
              ";
              $total += $f_rpt['total'];
              $galones += $f_rpt['galones'];
            }
         echo "  
          </tbody>
          <tfoot>
            <tr>
              <th>Total:</th>
              <th>".number_format($galones,2,'.',',')."</th>
              <th>".$rps['moneda'].number_format($total,2,'.',',')."</th>
            </tr>
          </tfoot>
        </table>
        </div>
    </div>
		";

 ?>