<?php
include("../conexion.php");
session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);

$sql=mysqli_query($conexion,
"
SELECT
	r.id_ruta,
	d.Depto,
	r.ruta,
	r.id_equipo,
	r.piloto,
  r.id_depto,
	max(pd. MONTH) as mes
FROM
	ruta r
LEFT JOIN pago_deducible pd ON r.ruta = pd.ruta
LEFT JOIN depto d ON d.Id_depto=r.id_depto 
WHERE
	r.canal = 'MASIVO'
AND r.codigo_pais = '$pais'
AND r.estado = 'ACTIVO'
GROUP BY
	r.id_ruta
ORDER BY
	r.id_depto,r.ruta
")
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<div>
	<table class="table table-striped table-hover table-bordered tabla-condensed">
		<thead>
			<tr>
				<th>Id asig.</th>
				<th>Sede</th>
				<th>Ruta</th>
				<th>Placa</th>
				<th>Pilto</th>
				<th>Último pago</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>
		<?php
		while ($row=mysqli_fetch_array($sql)) {
			echo "
			<tr>
				<td>".$row['id_ruta']."</td>
				<td>".$row['Depto']."</td>
				<td>".$row['ruta']."</td>
				<td>".$row['id_equipo']."</td>
				<td>".$row['piloto']."</td>
				<td>".$row['mes']."</td>
				<td><a 
						class='btn btn-success' 
						data-toggle='modal' 
						data-target='#pago_ded' 
						data-id_ruta='".$row['id_ruta']."'
						data-ruta='".$row['ruta']."'
						data-placa='".$row['id_equipo']."'
						data-piloto='".$row['piloto']."'
            data-id_depto='".$row['id_depto']."'
					>
					<span class='fa fa-money'></span></a></td>
			</tr>
			";
			}	
		?>
			</tr>
		</tbody>
		
	</table>
</div>

        <div class="modal fade" id="pago_ded">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo pago deducible</h4>
              </div>
              <div class="modal-body">
              	<input type="text" name="id_ruta" id="id_ruta" style="display: none;">
                <input type="text" name="id_depto" id="id_depto" style="display: none;">
                <div class="row"> 
                	<div class="col-md-3">
                		<label>Ruta:</label>
                		<input type="text" name="ruta" id="ruta"  class="form-control" readonly="" >
                	</div>
                	<div class="col-md-3">
                		<label>Placa:</label>
                		<input type="text" name="placa" id="placa" class="form-control" readonly="" >
                	</div>
                	<div class="col-md-6">
                		<label>Piloto:</label>
                		<input type="text" name="piloto" id="piloto" class="form-control" readonly="" >
                	</div>
                </div>
                <div class="row">
                	<div class="col-md-4">
                		<label>Monto:</label>
                		<div class="input-group">
                			<div class="input-group-addon">
                				<?php echo $rps['moneda']; ?>
                			</div>
                			<input type="number" name="monto" id="monto" class="form-control">
                		</div>
                	</div>
                	<div class="col-md-8">
                		<label>Mes:</label>
                		<input type="month" name="mes"  id="mes" class="form-control">
                	</div>
                </div>
                  <div class="form-group">
                    <label for="">Descripcion</label>
                    <input type="textarea" name="descripcion" id="descripcion" required="" maxlength="100" class="form-control">
                  </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick='deducible_guarda_pago()'>Guardar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
 <script>
 $('#pago_ded').on('show.bs.modal', function (event) {
 	var button = $(event.relatedTarget)
 	var dato0 = button.data('id_ruta')
 	var dato1 = button.data('ruta')
 	var dato2 = button.data('placa')
 	var dato3 = button.data('piloto')
  var dato4 = button.data('id_depto')

 	var modal = $(this)
 	modal.find('.modal-body #id_ruta' ).val(dato0)
 	modal.find('.modal-body #ruta' ).val(dato1)
 	modal.find('.modal-body #placa' ).val(dato2)
 	modal.find('.modal-body #piloto' ).val(dato3)
  modal.find('.modal-body #id_depto' ).val(dato4)
 })	
 </script>
</body>
</html>
