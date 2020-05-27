<?php
include ("../../conexion.php");
$placa=$_POST['placa'];
$bs=mysqli_query($conexion,"SELECT MAX(km_salida) as km FROM mov_diario WHERE id_equipo='$placa'");
$bsr=mysqli_fetch_array($bs);
$klm=$bsr['km'];
?>

<label>Kilometraje anterior:</label>
<input type="number" name="kilo_ant" id="kilo_ants" placeholder="Anterior" step="1" class="form-control" value="<?php echo $klm  ?>" readonly >