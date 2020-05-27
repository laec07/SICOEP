<?php
include("../conexion.php");
session_start();
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
$mes_actual= Date("m");
$año_actual= date("Y");
$año_anterior =$año_actual-1;
///////////////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$actual=mysqli_query($conexion,
	"
SELECT
	YEAR (mv.Fecha) actual_year,
	sum(mv.costo) AS costo_anterior,
	MONTH (mv.Fecha) AS mes,
	t1.anterior AS costo_actual,
	t1.anterior_year
FROM
	mantenimiento_vehiculo mv
LEFT JOIN (
	SELECT
		YEAR (Fecha) AS anterior_year,
		sum(costo) AS anterior,
		MONTH (Fecha) AS mes
	FROM
		mantenimiento_vehiculo
	WHERE
		codigo_pais = '$pais'
	AND YEAR (Fecha) = '$año_actual'
	GROUP BY
		YEAR (Fecha),
		MONTH (Fecha)
) t1 ON t1.mes = MONTH (mv.Fecha)
WHERE
	codigo_pais = '$pais'
AND YEAR (Fecha) ='$año_anterior'
AND MONTH (Fecha) <= '$mes_actual'
GROUP BY
	YEAR (Fecha),
	MONTH (Fecha)
	");
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p class="text-center">
                    <strong>Mantenimientos: <?php echo $año_anterior ; ?> - <?php echo $año_actual ; ?></strong>
                  </p>
<div id="costos_mante"></div>

<script>
	google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mes','<?php echo $año_anterior ; ?> ', '<?php echo $año_actual ; ?>'],
     <?php
     while ($row_g=mysqli_fetch_array($actual)) {
     	echo "
     		['".$row_g['mes']."',  ".$row_g['costo_anterior'].",       ".$row_g['costo_actual'].",],
     	";
     }
          
       
    ?>
        ]);

        var options = {
          title: '',
          hAxis: {title: 'Mes',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('costos_mante'));
        chart.draw(data, options);
      }
      $(window).resize(function(){
		drawChart();

		});
</script>
</body>
</html>