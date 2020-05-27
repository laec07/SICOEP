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
	"SELECT
  c.canal,
  c.id_depto,
  c.id_ruta,
  c.ruta,
  r.piloto,
  SUM(c.total) AS total
FROM
  combustible_detalle c, 
  ruta r
WHERE
  c.codigo_pais = '$pais'
AND c.fecha BETWEEN '$f1'
AND '$f2'
AND r.id_ruta=c.id_ruta
AND c.canal='$canal'
AND c.id_depto='$depto'
GROUP BY
  c.ruta");
echo "
<div class='box box-info'>
	<div class='box-header'>
		<h4 class='box-title'>".$rdt['Depto']." - ".$canal."<small>Del: ".date_format(new Datetime($f1),'d/m/Y')." Al: ".date_format(new Datetime($f2),'d/m/Y')."</small></h4>
	</div>
        <table class='table table-hover table-bordered table-striped'>
          <thead>
            <tr>
              
              <th>Ruta</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
           ";
           $total=0;
            while ($f_rpt=mysqli_fetch_array($rpt_depto)) {
              echo "
                <tr>
                  
                  <td>".$f_rpt['ruta']." </td>
                  <td>".$rps['moneda'].number_format($f_rpt['total'],2,'.',',')." </td>
                  <td><a onclick=\"buscar_rcanal(".$f_rpt['id_depto'].",'".$f_rpt['canal']."','".$f_rpt['ruta']."');\" title='Ver detalles' ><li class='fa fa-eye'></li></a></td>
                </tr>
              ";
              $total += $f_rpt['total'];
            }
         echo "  
          </tbody>
          <tfoot>
            <tr>
              <th>Total:</th>
              <th>".$rps['moneda'].number_format($total,2,'.',',')."</th>
            </tr>
          </tfoot>
        </table>
        </div>
		";

 ?>