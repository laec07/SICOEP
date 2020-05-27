<?php
include ("../conexion.php");
$placa=$_POST['placa'];
$busca=mysqli_query($conexion,"SELECT * FROM vehiculo_llantas where Id_equipo='$placa'");

?>
<div>
	<a class="btn btn-success">Agregar</a>
<?php
if (mysqli_num_rows($busca)>0) {
?>
<table class="table">
	<thead>
		<tr>
			<th>Fecha</th>
			<th>IZ.D</th>
			<th>DER.D</th>
			<th>IZ.T</th>
			<th>DER.T</th>
			<th>Tipo</th>
			<th>Observaciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while ($row_h=mysqli_fetch_array($busca)) {
	if ($row_h['tipo']=="N") {
		$tipo='NUEVO';
	}else{
		$tipo='REVISIÓN';
	}
	echo "
		<tr>
			<td>".$row_h['fecha']."</td>
			<td>".$row_h['llanta_iz_delantera']."%</td>
			<td>".$row_h['llanta_der_delantera']."%</td>
			<td>".$row_h['llanta_iz_trasera']."%</td>
			<td>".$row_h['llanta_der_trasera']."%</td>
			<td>".$tipo."</td>
			<td>".$row_h['observaciones']."</td>
		</tr>
	";
}
	
?>	
	</tbody>
</table>
<?php
}else{
	echo " </br>No se encontraron registros";
}
?>
</div>