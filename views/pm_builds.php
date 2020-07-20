<?php
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}
else
{//inicio session

include ("../conexion.php");
$pais=$_SESSION['usuario']['codigo_pais'];

$query=mysqli_query($conexion,"
SELECT
	p.id_prueba,
	p.Id_usuario,
	u.Usuario,
	p.criterio1,
	p.criterio2,
	p.criterio3,
	p.total,
	p.estatus
FROM
	pm_pruebapiloto p
INNER JOIN usuarios u ON p.Id_usuario=u.Id_usuario
WHERE
	p.estatus = 'P'
AND p.codigo_pais = '$pais'
	");

$query_f=mysqli_query($conexion,"
SELECT
	p.id_prueba,
	p.Id_usuario,
	u.Usuario,
	p.criterio1,
	p.criterio2,
	p.criterio3,
	p.total,
	p.estatus,
	u.tipo_usu
FROM
	pm_pruebapiloto p
INNER JOIN usuarios u ON p.Id_usuario=u.Id_usuario
WHERE
	p.estatus = 'A'
AND p.codigo_pais = '$pais'
LIMIT 20
	");

?>
<div class="box box-danger ">
	<div class="box-header">
		<h3>Pendientes</h3>

	</div>
	<div class="box-header">
		<div class="table-responsive">
			<table class="table">
				<thead>			
					<tr>
						<th>Id prueba</th>
						<th>Aspirante</th>
						<th>Criterio 1</th>
						<th>Criterio 2</th>
						<th>Criterio 3</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
				
				while ($fila=mysqli_fetch_array($query)) {
					echo "
					<tr>
						<th>".$fila['id_prueba']."</th>
						<th>".$fila['Usuario']."</th>
						<th>".$fila['criterio1']."</th>
						<th>".$fila['criterio2']."</th>
						<th>".$fila['criterio3']."</th>
						<th>".$fila['total']."</th>
						<th>
							<a class='btn btn-primary' onclick='show_data(".$fila['id_prueba'].")'  ><span class='fa fa-eye'></span></a>
							<a class='btn btn-danger' onclick='delete_test(".$fila['id_prueba'].")' ><span class='fa fa-trash'></span></a>
						</th>
					</tr>
					";
				}
				  ?>	
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="box box-danger ">
	<div class="box-header">
		<h3>Finalizados</h3>

	</div>
	<div class="box-header">
		<div class="table-responsive">
			<table class="table">
				<thead>			
					<tr>
						<th>Id prueba</th>
						<th>Aspirante</th>
						<th>Criterio 1</th>
						<th>Criterio 2</th>
						<th>Criterio 3</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
				
				while ($fila_f=mysqli_fetch_array($query_f)) {

					if ($fila_f['total']>60 && $fila_f['tipo_usu']=='Aspirante') {
						$ctr="<a class='btn btn-primary' onclick='contrata(".$fila_f['Id_usuario'].")' ><span class='fa fa-chevron-circle-right'></span></a>";
					}else{
						$ctr="";
					}

					echo "
					<tr>
						<th>".$fila_f['id_prueba']."</th>
						<th>".$fila_f['Usuario']."</th>
						<th>".$fila_f['criterio1']."</th>
						<th>".$fila_f['criterio2']."</th>
						<th>".$fila_f['criterio3']."</th>
						<th>".$fila_f['total']."</th>
						<th>
							<a class='btn btn-warning' target=_blank href='../../views/pm_pdf.php?id=".$fila_f['id_prueba']."'><span class='fa fa-print'></span></a>
							<a class='btn btn-danger' onclick='delete_test(".$fila_f['id_prueba'].")' ><span class='fa fa-trash'></span></a>
							$ctr
						</th>
					</tr>
					";
				}
				  ?>	
				</tbody>
			</table>
		</div>
	</div>
</div>




<?php  
mysqli_close($conexion);
}//fin session  
?>