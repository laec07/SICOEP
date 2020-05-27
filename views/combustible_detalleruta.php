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
$ruta=$_POST['ruta'];
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
  c.fecha,
  r.piloto,
  c.total,
  c.galones,
  c.observaciones
FROM
  combustible_detalle c
LEFT JOIN depto d ON c.id_depto = d.Id_depto
LEFT JOIN  ruta r ON r.id_ruta=c.id_ruta
LEFT JOIN combustible_solicitud cs ON cs.id_solicitud=c.id_solicitud
WHERE
  c.codigo_pais = '$pais'
AND c.fecha BETWEEN '$f1'
AND '$f2'
AND c.id_depto='$depto'
AND c.canal='$canal'
AND cs.estatus='APROBADO'
AND c.ruta='$ruta'
AND c.total>0
ORDER BY c.fecha
");
echo "
<div class='box box-info'>
	<div class='box-header'>
		<h4 class='box-title'>".$rdt['Depto']." | ".$canal." | ".$ruta."<small>Del: ".date_format(new Datetime($f1),'d/m/Y')." Al: ".date_format(new Datetime($f2),'d/m/Y')  ."</small></h4>
	</div>
        <table class='table table-hover table-bordered table-striped'>
          <thead>
            <tr>
              
              <th>Fecha</th>
              <th>Piloto</th>
              <th>Galones</th>
              <th>Total</th>
              <th>Observaciones</th>
              
            </tr>
          </thead>
          <tbody>
           ";
           $total=0;
           $galones=0;
            while ($f_rpt=mysqli_fetch_array($rpt_depto)) {
              echo "
                <tr>
                  
                  <td>".date_format(new Datetime($f_rpt['fecha']),'d/m/Y')." </td>
                  <td>".$f_rpt['piloto']." </td>
                  <td>".$f_rpt['galones']." </td>
                  <td>".$rps['moneda'].number_format($f_rpt['total'],2,'.',',')." </td>
                  <td>".$f_rpt['observaciones']."</td>
                  
                </tr>
              ";
              $total += $f_rpt['total'];
              $galones += $f_rpt['galones'];
            }
             
         echo "  
          </tbody>
          <tfoot>
            <tr>
              <th colspan='2'>Total:</th>
              <th >".$galones."</th>
              <th>".$rps['moneda'].number_format($total,2,'.',',')."</th>
            </tr>
          </tfoot>
        </table>
        </div>
		";

 ?>