<?php
include("../conexion.php");
session_start();
///////////////////////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
////////////////////////////////////////////////////////////
/*************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
$mes_actual= Date("m");
$año_actual= date("Y");
////////////////////////////////////////////////////////////////////////
$Result=mysqli_query($conexion, "SELECT
  r.id_depto,
  d.Depto,
  COUNT(r.ruta) AS total,
  SUM(r.asignado_gal) AS asignado,
  SUM(r.restantes_gal) AS restante,
  SUM(r.restantes_gal) * 100 / SUM(r.asignado_gal) AS porcentaje,
  c1.consumido,
  c1.total 
FROM
  ruta r
JOIN depto d ON r.id_depto = d.Id_depto
LEFT JOIN (SELECT
  c.id_depto,
  SUM(c.galones) as consumido,
  SUM(c.total) as total
FROM
  combustible_detalle c,
  combustible_solicitud cs
WHERE
  cs.id_solicitud = c.id_solicitud
AND cs.estatus = 'APROBADO'
AND MONTH(cs.fecha)='$mes_actual'
AND YEAR(cs.fecha)='$año_actual'
GROUP BY c.id_depto) as c1 ON c1.id_depto=d.Id_depto
WHERE
 d.codigo_pais = '$pais'
AND r.estado = 'ACTIVO'
GROUP BY
  d.id_depto" );
//saca todos los deptos que tienen asignado combustible
$Result1=mysqli_query($conexion, "
SELECT
	d.Id_depto,
	d.Depto
FROM
	depto d
JOIN ruta r ON d.Id_depto = r.id_depto
WHERE
	d.Tipo = 'SEDE'
AND d.codigo_pais = '$pais'
AND d.usa_vehi = 'S'
AND r.asignado_gal > 0
GROUP BY d.Id_depto
	" );
////////////////////////////////////////////////////////////////////////////
$i=1;
while ($row=mysqli_fetch_array($Result)) {
	$excedido=$row['asignado']-$row['consumido'];
	if ($excedido<0) {
		$ex=$excedido*-1;
	}else{
		$ex=0;
	}
	echo "
	<div class='col-md-3'>
		<div  id='chart_div".$i."'></div>

			<div align='center'><h3>".$row['Depto']."</h3></div>
			<div class='box-footer no-padding'>
				<ul class='nav nav-pills nav-stacked'>
					<li>Asignado:<span class='pull-right text-blue'>".$row['asignado']."</span></li>
					<li>Restante:<span class='pull-right text-green'>".$row['restante']."</span></li>
					<li>Comsumido:<span class='pull-right text-black'>".$row['consumido']."</span></li>
					<li>Excedidos:<span class='pull-right text-red'>".$ex."</span></li>
					<li>Total<span class='pull-right text-yellow'>".$rps['moneda']." ".number_format($row['total'],2,'.',',')."</span></li>
					
				</ul>
		</div>
		
	</div>
		
	";
	$i++;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


	
</div>


<script>
	google.charts.load('current', {'packages':['gauge']});
     google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

<?php
	$a=1;
	while ($fila=mysqli_fetch_array($Result1)) {
		$id_depto=$fila['Id_depto'];
		$dato=mysqli_query($conexion,"SELECT sum(asignado_gal) as asignado,sum(restantes_gal) as restante from ruta where codigo_pais='$pais' and estado='ACTIVO' and id_depto='$id_depto'  ");
		$porcent=mysqli_fetch_array($dato);
		$porcentaje =($porcent['restante'] * 100) / $porcent['asignado'];
	?>
	
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['',<?php echo number_format($porcentaje,2,".",",");?>]
                  ]);

        var options = {
          width: 200, height: 200,
          redFrom: 0, redTo: 10,
          yellowFrom:10, yellowTo: 50,
          greenFrom:50, greenTo: 100,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div<?php echo $a; ?>'));

        chart.draw(data, options);
<?php
$a++;
}
?>        
      }
</script>

</body>
</html>





<?php
mysqli_close($conexion);
?>
