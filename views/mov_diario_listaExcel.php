<?php
include ("../conexion.php"); 
//////////////////////////////////
session_start();
$sede=$_GET['sede'];
$del=$_GET['del'];
$al=$_GET['al'];
//////////////////////////////
/**************************************/

header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=Movimiento.xls");
header("Pragma: no-cache");
header("Expires: 0");
 /*******************************************************************************************/
/////////////////////////////////
if ($sede=='TODOS') {
	$buscasede="";
}else{
	$buscasede="AND md.Id_depto='$sede'";
	
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
	md.id_equipo,
	md.Fecha,
	md.km_salida,
	md.km_entrada,
	md.km_recorrido,
	d.Depto
FROM
	mov_diario md
LEFT JOIN depto d ON md.id_depto=d.Id_depto
WHERE
 md.Fecha BETWEEN '$del' AND '$al'
AND	md.codigo_pais = '$pais'
$buscasede
ORDER BY d.Depto
	");
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

</head>
<body>
<div class="box">
	<div class="box-header">
		<h4>Reporte Movimiento diario</h4>
		<small>Del: <?php echo $del; ?> Al:<?php echo $al; ?></small>
		<br>
	</div>
	<div class="box-body">
		<table class="table" id="tabla_h">
			<thead>
				<tr>
					<th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Sede</th>
					<th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Fecha</th>
					<th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Placa</th>
					<th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >km salida</th>
					<th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Km Entrada</th>
					<th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Total</th>
				</tr>
			</thead>
			<tbody>
	<?php
		while ($row=mysqli_fetch_array($query)) {
			echo "
				<tr>
					<td style='border:1px solid #000;padding: 10px' >".$row['Depto']."</td>
					<td style='border:1px solid #000;padding: 10px' >".$row['Fecha']."</td>
					<td style='border:1px solid #000;padding: 10px' >".$row['id_equipo']."</td>
					<td style='border:1px solid #000;padding: 10px' >".$row['km_salida']."</td>
					<td style='border:1px solid #000;padding: 10px' >".$row['km_entrada']."</td>
					<td style='border:1px solid #000;padding: 10px' >".$row['km_recorrido']."</td>
				</tr>
			";
			}
	?>
			</tbody>
		</table>
	</div>
</div>

</body>
</html>



