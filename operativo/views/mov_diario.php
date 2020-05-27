<?php
include ("../../conexion.php");
session_start();
if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
}else{
////////////////////////////////////////////////////
date_default_timezone_set('America/Guatemala');
$pais=$_SESSION['usuario']['codigo_pais'];
$sede=$_SESSION['usuario']['Id_depto'];
$dp=mysqli_query($conexion,"SELECT Depto FROM depto where Id_depto='$sede'");
$depto=mysqli_fetch_array($dp);
$fecha_actual= Date("Y-m-d");
$usuario=$_SESSION['usuario']['USUARIO'];
/////////////////////////////////////////////////
if ($pais=='503') {
	$depto_b="AND (a.Id_depto= '50301' or a.Id_depto='50303')";
	$depto_c="AND (a.Id_depto= '50301' or a.Id_depto='50303')";
}else{
	$depto_b="AND a.Id_depto= '$sede'";
	$depto_c="AND a.Id_depto= '$sede'";
}
/////////////////////////////////////////////////
$placa=mysqli_query($conexion, "
	SELECT
	v.Id_equipo,
	v.Equipo,
	v.Marca,
	v.Modelo,
	a.Id_depto,
	v.codigo_pais,
	max(d.Fecha) as fecha
FROM
	vehiculo v
LEFT JOIN	asignacion_vehiculo a ON a.Id_equipo = v.Id_equipo
LEFT JOIN	mov_diario d ON v.Id_equipo = d.Id_equipo
WHERE
	v.codigo_pais = '$pais'
$depto_b
AND a.Estado_asig = 'ACTIVO'
AND v.Id_equipo not in (select id_equipo from mov_diario where codigo_pais='$pais'  and Fecha='$fecha_actual')
AND a.canal in (select canal from canal_usuario cu, canal c where c.id_canal=cu.id_canal and usuario='$usuario')
GROUP BY v.Id_equipo,
	v.Equipo,
	v.Marca,
	v.Modelo,
	a.Id_depto,
	v.codigo_pais
	");
	
$insertados=mysqli_query($conexion,"
SELECT
	a.canal,
	md.id_equipo,
	md.Fecha,
	md.km_salida,
	es.kilosugerido,
	md.km_entrada,
	md.km_recorrido,
	md.Destino,
	md.codigo_pais,
	md.id_depto
FROM
	mov_diario md,
	estado_mantenimiento es,
	asignacion_vehiculo a
WHERE
	md.Fecha = '$fecha_actual'
AND es.id_equipo = md.id_equipo
AND a.Id_equipo=md.id_equipo and a.Estado_asig='ACTIVO'
AND a.canal in (select canal from canal_usuario cu, canal c where c.id_canal=cu.id_canal and usuario='$usuario')
$depto_b
GROUP BY md.id_equipo
");
$cuenta_insertados=mysqli_query($conexion,"
SELECT
	count(*) as total
FROM
	mov_diario md,
	estado_mantenimiento es,
	asignacion_vehiculo a
WHERE
	md.Fecha = '$fecha_actual'
AND es.id_equipo = md.id_equipo
AND a.Id_equipo=md.id_equipo and a.Estado_asig='ACTIVO'
AND a.canal in (select canal from canal_usuario cu, canal c where c.id_canal=cu.id_canal and usuario='$usuario')
$depto_c 

");
$rcuenta_insertado=mysqli_fetch_array($cuenta_insertados);
}
?>
<div class="row">
	<div class="col-md-6">
<div class="box box-danger">
	<div class="box-header with-border">
		<h3><?php echo $depto['Depto']; ?></h3>
		<h4> Registro de kilometraje diario</h4>
	</div>
	<div class="box-body">
		
			
				<form action="" method="">
					<div id="placa_f" class="form-group">
						<label>Placa:</label>
						<select class="form-control" id="placa" name="placa" onchange="kilo_anterior(this.value);" >
							<option>Seleccione placa</option>
							<?php 
                              while($fila1=mysqli_fetch_row($placa)){
                                echo "<option value='".$fila1['0']."'>".$fila1['0']." -".$fila1['1']."-".$fila1['2']."</option>";
                              }
                              
                            ?>
						</select>
						<span style="display: none;" class="help-block" id="placa_error"></span>
					</div>
					<div class="form-group">
						<label>Fecha:</label>
						<input class="form-control" type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" >
					</div>
					<div id="kilo_f" class="form-group">
						<label>Kilometraje:</label>
						<input type="number" name="kilometraje" id="kilometraje" placeholder="kilometraje" step="1" class="form-control" required="" max="999999" >
						<span style="display: none;" class="help-block" id="kilo_error">Debe ingresar kilometraje valido</span>
					</div>
					<div id="obs_f" class="form-group" >
						<label>Cuadrante: <small >(Recorrido día anterior)</small></label>
						<textarea name="observaciones" id="observaciones" class="form-control"></textarea>
						<span style="display: none;" class="help-block" id="obs_error"></span>
						
					</div>
					<div id="kil_a"  class="form-group">
						<label>Kilometraje anterior:</label>
						<input type="number" name="kilo_ant" id="kilo_ants" placeholder="Anterior" step="1" class="form-control" readonly="" >
						
					</div>
					<div id="total_a" class="form-group">
						<label>Total: <small >(Recorrido día anterior)</small></label>
						<input type="number" name="total" id="total" placeholder="total" step="1" class="form-control" readonly="">
						<span style="display: none;" class="help-block" id="total_error"></span>
					</div>
					<button class="btn btn-primary btn-block" onclick="guarda_diario();" >Aceptar</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h4>Registros insertados el día de hoy - <small>Total:<?php echo $rcuenta_insertado['total'] ?></small></h4>
			</div>
			<div class="box-body">
				<table class="table">
					<thead>
						<tr>
							<th>Placa</th>
							<th>Km</th>
							<th>Km servicio.</th>
							<th>Km faltante.</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
						while ($fila=mysqli_fetch_array($insertados)) {

							$restante=  $fila['kilosugerido'] - $fila['km_salida'];

				                if ($restante > 0 and $restante <=200 ) {
				                  $clase='class="label label-warning" title="Es necesario realizar servicio al vehículo"';
				                }else if ($restante < 0) {
				                  $clase='class="label label-danger" title="Menos de 200 km para servicio"';
				                }else{
				                  $clase='class="label label-info" title="" ';
				                }
							echo"
							<tr>
								<td>".$fila['id_equipo']."</td>
								<td>".$fila['km_salida']."</td>
								<td>".$fila['kilosugerido']."</td>
								<td><label $clase>".$restante."</label></td>
								<td></td>
							</tr>
							";
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


