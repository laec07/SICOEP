<?php
include("../../conexion.php");
session_start();
$depto=$_POST['depto'];
if ($depto=='3080') {
  $condicion="AND c.id_depto in (3080,1090)";
}else{
   $condicion="AND c.id_depto='$depto'";

}
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
$datos=mysqli_query($conexion," 
SELECT
  c.id_solicitud,
  c.fecha,
  c.id_depto,
  d.Depto,
  sum(cd.galones) as total_galones,
  sum(cd.total) as total_efectivo,
  c.usuario_solicita,
  c.estatus,
  c.usuario_aprueba,
  c.codigo_pais
FROM
  combustible_solicitud c,depto d,combustible_detalle cd
WHERE
  estatus is NULL
AND c.id_depto=d.Id_depto
AND cd.id_solicitud=c.id_solicitud
$condicion
GROUP BY c.id_solicitud
order by c.fecha desc

	");
if (mysqli_num_rows($datos)>0){
?>
<div class="box box-warning">
	<div class="box-header">
		<h4>Borradores </h4>
		<span class="help-block">Un borrador te permite conservar una solicitud que aún no está listo para procesarse.</span>
	</div>
	<div class="box-body">
		<div class="table-responsive">
              <table id='example2' class='table table-bordered table-striped'>
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>ID</th>
                    <th>Depto.</th>
                    <th>Galones</th>
                    <th>Total</th>
                    <th>Solicitante</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($fila=mysqli_fetch_array($datos)) {
                    echo "
                    <tr>
                      <td>".date_format(date_create($fila['fecha']),'d/m/Y')."</td>
                      <td>".$fila['id_solicitud']."</td>
                      <td>".$fila['Depto']."</td>
                      <td>".$fila['total_galones']."</td>
                      <td>".$rps['moneda'].number_format($fila['total_efectivo'],2,'.',',')."</td>
                      <td>".$fila['usuario_solicita']."</td>

                      <td>
                      	<a class='btn btn-default' onclick='muestra_solicitud(".$fila['id_solicitud'].")'  title='Editar'>
                          <span class='fa fa-edit'> </span>
                        </a>
                        <a class='btn btn-default' onclicK='confirm_e(".$fila['id_solicitud'].")' title='Eliminar solicitud' >
                          <span class='fa fa-trash' ></span>
                        </a>
                      </td>                       
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
}

?>