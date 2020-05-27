<?php
include ("../conexion.php"); 
//////////////////////////////////
session_start();
$sede=$_POST['sede'];
$del=$_POST['del'];
$al=$_POST['al'];
//////////////////////////////
if ($sede=='TODOS') {
	$sede_b="";
}else{
	$sede_b="AND mv.id_depto = '$sede'";
}

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
	mv.id_depto,
	d.Depto,
	mv.id_equipo,
	sum(mv.km_recorrido) as km_recorrido,
	t1.total,
	t1.galones
FROM
	mov_diario mv
LEFT JOIN depto d ON d.Id_depto = mv.id_depto
LEFT JOIN (
	SELECT
		Id_equipo,
		sum(total) AS total,
		sum(galones) AS galones
	FROM
		combustible_detalle
	WHERE
		fecha BETWEEN  '$del'
AND '$al'
	GROUP BY
		Id_equipo
) AS t1 ON t1.Id_equipo = mv.id_equipo
WHERE
	mv.Fecha BETWEEN '$del'
AND '$al'
$sede_b

AND mv.codigo_pais='$pais'

GROUP BY
	mv.id_equipo
	");

$query=mysqli_query($conexion,"
SELECT
	mv.id_depto,
	d.Depto,
	mv.id_equipo,
	sum(mv.km_recorrido) as km_recorrido,
	t1.total,
	t1.galones
FROM
	mov_diario mv
LEFT JOIN depto d ON d.Id_depto = mv.id_depto
LEFT JOIN (
	SELECT
		Id_equipo,
		sum(total) AS total,
		sum(galones) AS galones
	FROM
		combustible_detalle
	WHERE
		fecha BETWEEN  '$del'
AND '$al'
	GROUP BY
		Id_equipo
) AS t1 ON t1.Id_equipo = mv.id_equipo
WHERE
	mv.Fecha BETWEEN '$del'
AND '$al'
$sede_b

AND mv.codigo_pais='$pais'

GROUP BY
	mv.id_equipo
	");
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="chart-container" style="position: relative; height:40vh; width:80vw">
	<div id="chart_div" ></div>
</div>
	
<div class="box">
	<div class="box-header">
		<h4>Km recorridos <small>Del:<?php echo date_format(New datetime($del),"d/m/Y"); ?> Al: <?php echo date_format(New datetime($al),"d/m/Y"); ?>  </small></h4>
	</div>
	<div class="box-body">
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped" id="tabla_a">
			<thead>
				<tr>
					<th>Sede</th>
					<th>Placa</th>
					<th>km recorridos</th>
					<th>Galones consumido</th>
					<th>Total</th>
					<th>Rendimiento estimado</th>
				</tr>
			</thead>
			<tbody>
	<?php
		while ($row=mysqli_fetch_array($query)) {
			if ($row['galones']>0) {
				$rendimiento=$row['km_recorrido']/$row['galones'];
				$rendimiento=ROUND($rendimiento,2)." Km/Gal";
			}else{
				$rendimiento="--";
			}
			
			echo "
				<tr>
					<td>".$row['Depto']."</td>
					<td>".$row['id_equipo']."</td>
					<td>".number_format($row['km_recorrido'],0,'.',',')." <a class='fa fa-eye pull-right' title='Ver detalle' onclick=\"lista_mov('".$row['id_equipo']."')\" href='#datos'></a></td>
					<td>".$row['galones']."</td>
					<td>".number_format($row['total'],2,'.',',')."</td>
					<td>".$rendimiento." </td>

				</tr>
			";
			
			}
			mysqli_data_seek($query, 0);
	?>
			</tbody>
		</table>		
	</div>

	</div>
</div>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
	//Hace funcionar los componentes de la tabla
    $(function () {

    $('#tabla_a').DataTable({
      'paging'      : false,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true
    })
  });


      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Año', 'Km/galon',{ role: 'style' } ],
         <?php
        while ($row_g=mysqli_fetch_array($query)) {
        	if ($row_g['galones']>0) {
				$rendimiento=$row_g['km_recorrido']/$row_g['galones'];
				$rendimiento=ROUND($rendimiento,2);
			}else{
				$rendimiento="0";
			}
        	echo "
        		 ['".$row_g['id_equipo']."',  ".$rendimiento.",'color: red'      ],
        	";
        }


         ?>
           
        ]);

        var options = {
          title: 'Rendimineto km vrs galones',
          curveType: 'function',
          legend: { position: 'none' }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      $(window).resize(function(){
drawChart();

});
</script>
</body>
</html>



