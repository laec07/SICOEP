<?php
include ("../conexion.php");

$placa=$_POST['placa'];

$x=mysqli_query($conexion,"SELECT MAX(ID) as id FROM mov_diario where id_equipo='$placa' and km_entrada>0 AND km_recorrido>0");
$idu=mysqli_fetch_array($x);
$id=$idu['id'];


if (mysqli_num_rows($x)>0) {

$id_u=mysqli_query($conexion,"SELECT * FROM mov_diario where  ID='$id'");
	$id_ul=mysqli_fetch_array($id_u);
$km_salida=$id_ul['km_salida'];
$km_entrada=$id_ul['km_entrada'];
$km_recorrido=$id_ul['km_recorrido'];
?>
<hr>
<label>Datos kilometraje anterior:</label>

<div class="row">

	<div class="col-md-4">
		<label>km salida</label>
		<input type="number" name="km_salida" id="km_salida" class="form-control" value="<?php echo $km_salida ?>" readonly>
	</div>
	<div class="col-md-4">
		<label>km entrada</label>
		<input type="number" name="km_entrada" id="km_entrada" class="form-control" value="<?php echo $km_entrada ?>" readonly>
	</div>
	<div class="col-md-4">
		<label>km recorrido</label>
		<input type="number" name="km_recorrido" id="km_recorrido" class="form-control" value="<?php echo $km_recorrido ?>" readonly>
	</div>
	<div></div>
</div>
<?php	
}else{
	echo "No existe registro de movimiento diario para placa seleccionada.";

	
}
?>

