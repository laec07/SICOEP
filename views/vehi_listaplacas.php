<?php
include ("../conexion.php");
$sede=$_POST['sede'];

$placa=mysqli_query($conexion,"SELECT Id_equipo FROM asignacion_vehiculo WHERE Id_depto='$sede' AND Estado_asig='ACTIVO'")

?>

<div class="form-group">
	<label>Placas:</label>
	<select class="form-control" id="lst_placas" onchange="lista_hllantas();">
		<option>Seleccione placa</option>
		<?php
		while ($row_placa=mysqli_fetch_array($placa)) {
			echo "
				<option value='".$row_placa['Id_equipo']."'>".$row_placa['Id_equipo']."</option>
			";
		}
		?>
	</select>
</div>