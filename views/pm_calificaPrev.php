
<?php
include("../conexion.php");

$id_prueba=$_POST['id_prueba'];

$query=mysqli_query($conexion,"
SELECT * FROM pm_pruebapiloto WHERE id_prueba='$id_prueba'
");
$f=mysqli_fetch_array($query);
$cr1=$f['criterio1'];
$cr2=$f['criterio2'];
$cr3=$f['criterio3'];
$total=$f['total'];
$aspirante=$f['Id_usuario'];

$consulta= mysqli_query($conexion,"SELECT * FROM usuarios where Id_usuario='$aspirante' ");

$rconsulta= mysqli_fetch_array($consulta);
$foto=$rconsulta['foto_piloto'];
$nombre=$rconsulta['Usuario'];

$crit=mysqli_query($conexion,"
SELECT
	id_criterio,
	descripcion,
	calificacion,
	estatus
FROM
	pm_criterio

");
while ($fc=mysqli_fetch_array($crit)) {
	if ($fc['id_criterio']==1) {
		$fc1=$fc['descripcion'];
	}
	if ($fc['id_criterio']==2) {
		$fc2=$fc['descripcion'];
	}
	if ($fc['id_criterio']==3) {
		$fc3=$fc['descripcion'];
	}
}


if (empty($foto)) {
        $foto='files/vacio2.jpg';
      };

mysqli_close($conexion);
?>
<div class="box box-danger" >
	<div class="box-header">
		<h3>Resultados obtenidos</h3>	
	</div>
	<div class="box-body">
		<div class="row">
            <div class="col-md-3" >
              <img  style="width: 200px;" src="../../consultas/<?php echo $foto ?>"  class='img'  />
            </div>

		</div>
		<div>
			<div class="col-md-3" >
				<table style="width: 100%" >
					<tr>

                      <th><?php echo $nombre; ?></th>
                    </tr>

				</table>
			</div>			
		</div>
		<br>
		<hr>
		<div>
			<div class="col-md-3" >
				<table style="width: 100%" >

					<tr>
						<th><?php echo $fc1; ?></th>
						<td><?php echo $cr1; ?></td>
					</tr>
					<tr>
						<th><?php echo $fc2; ?></th>
						<td><?php echo $cr2; ?></td>
					</tr>
					<tr>
						<th><?php echo $fc3; ?></th>
						<td><?php echo $cr3; ?></td>
					</tr>
					<tr>
						<th><h3>Total</h3> </th>
						<td><h3><?php echo $total; ?></h3></td>
					</tr>
				</table>
			</div>			
		</div>
	</div>
	<div class="box-footer">
		<div class="col-md-3">
			<a class="btn btn-primary btn-block" onclick="save_test(<?php echo $id_prueba; ?>);" >Guardar</a>
			<a class="btn btn-danger btn-block" onclick="body_test()">Cancelar</a>
		</div>
	</div>
</div>
