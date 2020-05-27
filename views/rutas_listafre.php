<?php
include ("../conexion.php"); 

$ruta=$_POST['ruta'];
$pais=$_POST['pais'];

$b=mysqli_query($conexion,"SELECT ruta,frecuencia,km,clientes FROM rutas_frecuencia WHERE ruta='$ruta' and codigo_pais='$pais'");


?>

<div >
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Frecuencia</th>
					<th>Kilometros</th>
					<th>Clientes</th>
				</tr>
			</thead>
			<tbody>
		<?php
		$km_f=0;
		$cli_f=0;
			while ($row=mysqli_fetch_array($b)) {
			echo "
				<tr>
					<td>".$row['frecuencia']."</td>
					<td>".$row['km']."</td>
					<td>".$row['clientes']."</td>
				</tr>
			";
			$km_f=$km_f+$row['km'];
			$cli_f=$cli_f+$row['clientes'];
			}
		?>
			</tbody>
			<tfoot>
				<tr>
		<?php
				echo "
					<th>Total</th>
					<th>".$km_f." km</th>
					<th>".$cli_f."</th>
				";
		?>
				</tr>
			</tfoot>
		</table>
	</div>
</div>