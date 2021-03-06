<?php 
include ("../../conexion.php");
session_start();
//////////////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$depto=$_SESSION['usuario']['Id_depto'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
///////////////////////////////////////////////
$mes=$_POST['month'];
$año=$_POST['year'];

$aprobados=mysqli_query($conexion,"
SELECT
  c.id_solicitud,
  c.fecha,
  c.id_depto,
  d.Depto,
  c.total_galones,
  c.total_efectivo,
  c.usuario_solicita,
  c.estatus,
  c.usuario_aprueba,
  c.codigo_pais
FROM
  combustible_solicitud c,depto d
WHERE
  estatus = 'APROBADO'
AND c.id_depto=d.Id_depto
AND MONTH(c.fecha)='$mes'
AND YEAR(c.fecha)='$año'
AND c.codigo_pais='$pais'
AND c.id_depto='$depto'
order by c.fecha desc
");
/***********************************/
$c_aprobados=mysqli_query($conexion,"SELECT
  sum(total_efectivo) as total
FROM
  combustible_solicitud
WHERE
  estatus = 'APROBADO'
AND MONTH(fecha)='$mes'
AND YEAR(fecha)='$año'
AND codigo_pais='$pais'
AND id_depto='$depto'
");
$cuenta_a=mysqli_fetch_array($c_aprobados);
/*********************************/
$cuenta=$cuenta_a['total'];

$c_galones=mysqli_query($conexion,"SELECT
  sum(total_galones) as total
FROM
  combustible_solicitud
WHERE
  estatus = 'APROBADO'
AND MONTH(fecha)='$mes'
AND YEAR(fecha)='$año'
AND codigo_pais='$pais'
AND id_depto='$depto'
");
$cuenta_g=mysqli_fetch_array($c_galones);
/*********************************/
$galones=$cuenta_g['total'];


if (mysqli_num_rows($aprobados)>0) {
?>
<div style='overflow:scroll;height: 100% '>
              <table id='example2' class='table table-bordered table-striped'>
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>ID</th>
                    <th>Depto.</th>
                    <th>Galones</th>
                    <th>Total</th>
                    <th>Solicitante</th>
                    <th>Aprobo</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($fila=mysqli_fetch_array($aprobados)) {
                    echo "
                    <tr>
                      <td>".date_format(date_create($fila['fecha']),'d/m/Y')."</td>
                      <td>".$fila['id_solicitud']."</td>
                      <td>".$fila['Depto']."</td>
                      <td>".$fila['total_galones']."</td>
                      <td>".$rps['moneda'].number_format($fila['total_efectivo'],2,'.',',')."</td>
                      <td>".$fila['usuario_solicita']."</td>
                      <td>".$fila['usuario_aprueba']."</td>
                      <td><a class='btn btn-default' onclick='editar_soliaprobada(".$fila['id_solicitud'].");'><span class='fa fa-eye'></span></a></td>                       
                    </tr>

                    ";
                  }
                  ?>
                </tbody>
              </table>
            </div>
<script >
	 //Hace funcionar los componentes de la tabla
    $(function () {
    
    $('#example2').DataTable({
      'paging'      : false,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  });

    var cuenta = <?php echo $cuenta; ?>;
    var galones  = <?php echo $galones; ?>;
</script>

<?php
}else{
?>
<div class="alert alert-warning alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-warning"></i> Alerta!</h4>
	No se encontraron registros para la fecha seleccionada!.
</div>
<?php
}

?>