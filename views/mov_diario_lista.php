<?php
include ("../conexion.php"); 
//////////////////////////////////
session_start();
$placa=$_POST['placa'];
$del=$_POST['del'];
$al=$_POST['al'];

 $pais=$_SESSION['usuario']['codigo_pais'];
 $ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
//////////////////////////////

//////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
//////////////
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y-m-d");
$mes_actual= Date("m");
$año_actual= date("Y");
///////////////////////////////
$query=mysqli_query($conexion,"
SELECT
	md.id_equipo,
	md.Fecha,
	md.km_salida,
	md.km_entrada,
	md.km_recorrido,
	d.Depto,
	md.observaciones,
  md.timestamp
FROM
	mov_diario md
LEFT JOIN depto d ON md.id_depto=d.Id_depto
WHERE
 md.Fecha BETWEEN '$del' AND '$al'
AND	md.codigo_pais = '$pais'
AND md.id_equipo='$placa'
ORDER BY md.Fecha,md.km_salida
	");
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
        <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body>
<div class="box box-info">
	<div class="box-header">
		<!--<a href="../../views/mov_diario_listaExcel.php?sede=<?php /*echo $sede?>&del=<?php echo $del?>&al=<?php echo $al*/?>" class="btn btn-success pull-right" title="Descargar"><i class="fa fa-file-excel-o" ></i></a>-->
		<h4>Detalle movimiento <?php echo $placa?></h4>
	</div>
	<div class="box-body ">
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped" id="tabla_h">
				<thead>
					<tr>
						
						<th>Fecha</th>
						<th>Sede</th>
						<th>km salida</th>
						<th>Km Entrada</th>
						<th>Total</th>
						<th>Observaciones</th>
            <th>Fecha ingreso registro</th>
					</tr>
				</thead>
				<tbody>
		<?php
    $i=0;
			while ($row=mysqli_fetch_array($query)) {
				echo "
					<tr>
						
						<td>".date_format(new datetime($row['Fecha']),"d/m/Y")."</td>
						<td>".$row['Depto']."</td>
						<td>".$row['km_salida']."</td>
						<td>".$row['km_entrada']."</td>
						<td>".$row['km_recorrido']."</td>
						<td>".$row['observaciones']."</td>
            <td>".date_format(new datetime($row['timestamp']),"d/m/Y H:i:s")."</td>
					</tr>
				";
        $i=$i+$row['km_recorrido'];
				}
		?>
				</tbody>
        <tfoot>
          <tr>
            <th colspan="4">Total</th>
            <th><?php echo $i; ?></th>
          </tr>
        </tfoot>
			</table>
		</div>

	</div>
</div>
<?php
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
AND c.fecha BETWEEN '$del'
AND '$al'

AND c.id_equipo='$placa'
AND cs.estatus='APROBADO'

AND c.total>0
ORDER BY c.fecha
");
echo "
<div class='box box-info'>
	<div class='box-header'>
		<h4 class='box-title'>Detalle combustible - ".$placa." <small>Del: ".date_format(new Datetime($del),'d/m/Y')." Al: ".date_format(new Datetime($al),'d/m/Y')  ."</small></h4>
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
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
	//Hace funcionar los componentes de la tabla
    $(function () {

    $('#tabla_h').DataTable({
      'paging'      : false,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true
    })
  });
</script>
</body>
</html>



