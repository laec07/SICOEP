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
//$ruta=$_POST['ruta'];
///////////////////////////////////////////////////////

//////////////////////////////////////////////////////
if ($canal=='TODOS') {
  $f_canal='';
}else{
  $f_canal="AND c.canal='$canal'";
}
/////////////////////////////////////////////////////
$rpt_depto=mysqli_query($conexion,"SELECT c.canal,SUM(c.total) as total FROM combustible_detalle c,depto d WHERE c.codigo_pais='$pais' and c.fecha BETWEEN '$f1' AND '$f2' AND c.id_depto=d.Id_depto $f_canal GROUP BY c.canal");
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
                  <td>".$f_rpt['canal']." </td>
                  <td>".$rps['moneda'].number_format($f_rpt['total'],2,'.',',')." </td>
                  <td><a onclick=\"buscar_dcanal('".$f_rpt['canal']."')\" title='Ver detalles' ><li class='fa fa-eye'></li></a></td>
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
    </div>
		";

 ?>