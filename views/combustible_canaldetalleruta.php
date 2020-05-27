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
	"SELECT
	c.id_depto,
	d.Depto,
	c.canal,
	c.ruta,
	c.fecha,
  r.piloto,
	c.total
FROM
	combustible_detalle c,
	depto d,
  ruta r
WHERE
	c.codigo_pais = '$pais'
AND c.fecha BETWEEN '$f1'
AND '$f2'
AND c.id_depto = d.Id_depto
AND r.id_ruta=c.id_ruta
AND c.id_depto='$depto'
AND c.canal='$canal'
AND c.ruta='$ruta'
ORDER BY c.fecha
");
echo "
<div class='box box-info'>
	<div class='box-header'>
		<h4 class='box-title'>".$rdt['Depto']." - ".$canal." - R# ".$ruta."<small>Del: ".date_format(new Datetime($f1),'d/m/Y')." Al: ".date_format(new Datetime($f2),'d/m/Y')  ."</small></h4>
	</div>
        <table class='table table-hover table-bordered table-striped'>
          <thead>
            <tr>
              
              <th>Fecha</th>
              <th>Piloto</th>
              <th>Total</th>
              
            </tr>
          </thead>
          <tbody>
           ";
           $total=0;
            while ($f_rpt=mysqli_fetch_array($rpt_depto)) {
              echo "
                <tr>
                  
                  <td>".date_format(new Datetime($f_rpt['fecha']),'d/m/Y')." </td>
                  <td>".$f_rpt['piloto']." </td>
                  <td>".$rps['moneda'].number_format($f_rpt['total'],2,'.',',')." </td>
                  
                </tr>
              ";
              $total += $f_rpt['total'];
            }
             
         echo "  
          </tbody>
          <tfoot>
            <tr>
              <th colspan='2' >Total:</th>
              <th>".$rps['moneda'].number_format($total,2,'.',',')."</th>
            </tr>
          </tfoot>
        </table>
        </div>
		";

 ?>