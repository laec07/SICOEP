<?php
 include ("../conexion.php");
 session_start();
 $pais=$_SESSION['usuario']['codigo_pais'];
 $ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
 /////////////////////////////////////////////
$f1=$_POST['f1'];
$f2=$_POST['f2'];
$depto=$_POST['id'];
$canal=$_POST['canal'];
///////////////////////////////////////////////////////
$dt=mysqli_query($conexion,"SELECT Depto FROM depto where id_depto='$depto'");
$rdt=mysqli_fetch_array($dt);
//////////////////////////////////////////////////////
$rpt_depto=mysqli_query($conexion,
	"
SELECT
  c.id_depto,
  d.Depto,
  c.canal,
  c.ruta,
  c.Id_equipo,
  SUM(c.total) AS total,
  SUM(c.galones) AS galones
FROM
  combustible_detalle c
LEFT JOIN depto d ON c.id_depto = d.Id_depto
INNER JOIN combustible_solicitud cs ON cs.id_solicitud=c.id_solicitud 
WHERE
  c.codigo_pais = '$pais'
AND c.fecha BETWEEN '$f1'
AND '$f2'
AND c.id_depto='$depto'
AND c.canal='$canal'
AND cs.estatus='APROBADO'
GROUP BY c.id_depto,c.canal,c.ruta
");
echo "
<div class='box box-info'>
	<div class='box-header'>
		<h4 class='box-title'>".$rdt['Depto']." - ".$canal."<small>Del: ".date_format(new Datetime($f1),'d/m/Y')." Al: ".date_format(new Datetime($f2),'d/m/Y')."</small></h4>
	</div>
        <table class='table table-hover table-bordered table-striped'>
          <thead>
            <tr>
              
              <th>Ruta</th>
              <th>Placa</th>
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
                  
                  <td>".$f_rpt['ruta']." </td>
                  <td>".$f_rpt['Id_equipo']."</td>
                  <td>".$f_rpt['galones']." </td>

                  <td>".$rps['moneda'].number_format($f_rpt['total'],2,'.',',')." </td>
                  <td><a onclick=\"buscar_r(".$f_rpt['id_depto'].",'".$f_rpt['canal']."','".$f_rpt['ruta']."');\" title='Ver detalles' ><li class='fa fa-eye'></li></a></td>
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
		";

 ?>