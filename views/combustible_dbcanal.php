<?php
 include ("../conexion.php");
 session_start();
 $pais=$_SESSION['usuario']['codigo_pais'];
 $ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
 /////////////////////////////////////////////
$f1=$_POST['f1'];
$f2=$_POST['f2'];
$canal=$_POST['canal'];
///////////////////////////////////////////////////////

//////////////////////////////////////////////////////
$rpt_canal=mysqli_query($conexion,
	"SELECT
  c.canal,
  c.id_depto,
  d.Depto as hd,
  SUM(c.total) AS total
FROM
  combustible_detalle c,
  depto d
WHERE
  c.codigo_pais = '$pais'
AND c.fecha BETWEEN '$f1'
AND '$f2'
AND c.id_depto = d.Id_depto
AND canal='$canal'
GROUP BY
  c.canal,c.id_depto");
echo "
<div class='box box-info'>
	<div class='box-header'>
		<h4 class='box-title'>".$canal." <small>Del: ".date_format(new Datetime($f1),'d/m/Y')." Al: ".date_format(new Datetime($f2),'d/m/Y')."</small></h4>
	</div>
        <table class='table table-hover table-bordered table-striped'>
          <thead>
            <tr>
              
              <th>Sede</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
           ";
            $total=0;
            while ($f_rpc=mysqli_fetch_array($rpt_canal)) {
              $cl=$f_rpc['hd'];
              echo "
                <tr>
                  
                  <td>".$f_rpc['hd']." </td>
                  <td>".$rps['moneda'].number_format($f_rpc['total'],2,'.',',')." </td>
                  <td><a onclick=\"buscar_ccanal(".$f_rpc['id_depto'].",'".$f_rpc['canal']."');\" title='Ver detalles' ><li class='fa fa-eye'></li></a></td>
                </tr>
              ";
               $total += $f_rpc['total'];
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