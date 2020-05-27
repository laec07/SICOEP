<?php
 include ("../conexion.php");
 session_start();
 $pais=$_SESSION['usuario']['codigo_pais'];
 $ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
 /////////////////////////////////////////////
$f1=$_POST['f1'];
$f2=$_POST['f2'];
$canal=$_POST['canal'];

//$ruta=$_POST['ruta'];
///////////////////////////////////////////////////////
if ($canal=='TODOS') {
  $f_canal='';

}else{
  $f_canal="AND cd.canal='$canal'";
}
//////////////////////////////////////////////////////

/////////////////////////////////////////////////////
$rpt_depto=mysqli_query($conexion,"
SELECT
  cd.id_depto,
  d.Depto,
  cd.id_solicitud,
  cd.id_ruta,
  cd.ruta,
  r.piloto,
  r.tipo_vehi,
  r.id_equipo,
  cd.canal,
  cd.fecha,
  cd.galones,
  cd.tipo_combustible,
  cd.precio,
  cd.total,
  cd.observaciones
FROM
  combustible_detalle cd
LEFT JOIN depto d ON d.Id_depto = cd.id_depto
LEFT JOIN ruta r ON r.id_ruta = cd.id_ruta
WHERE
  fecha BETWEEN '$f1'
AND '$f2'
$f_canal
ORDER BY Depto,canal,ruta,fecha
  ");
echo "
    <div class='box box-info'>
      <div class='box-header with-border'>
      
        <h4 class='box-title'> General - ".$canal." - <small>Del: ".date_format(new Datetime($f1),'d/m/Y')." Al: ".date_format(new Datetime($f2),'d/m/Y')."</small></h4>
        <a href='../../views/combustible_cExcel.php?f1=$f1&f2=$f2&canal=$canal' class='btn btn-success pull-right' title='Descargar reporte'><i class='fa fa-file-excel-o'></i></a>
      </div>
      <div class='box-body'>
      <div style='overflow:scroll;height: 100%  ' >
        <table class='table table-hover table-bordered table-striped' id='example2'>
          <thead>
            <tr>
              <th>Canal</th>
              <th># solicitud</th>
              <th>Ruta</th>
              <th>Piloto</th>
              <th>Tipo Vehi</th>
              <th>Placas</th>
              <th>Depto</th>
              <th>Fecha</th>
              <th>Tipo Comb.</th>
              <th>Cant. Gal.</th>
              <th>Precio</th>
              <th>Total</th>
              <th>Observaciones</th>
            </tr>
          </thead>
          <tbody>
           ";
          
            while ($f_rpt=mysqli_fetch_array($rpt_depto)) {
              echo "
                <tr>
                  <td>".$f_rpt['canal']." </td>
                  <td>".$f_rpt['id_solicitud']." </td>
                  <td>".$f_rpt['ruta']." </td>
                  <td>".$f_rpt['piloto']." </td>
                  <td>".$f_rpt['tipo_vehi']." </td>
                  <td>".$f_rpt['id_equipo']." </td>
                  <td>".$f_rpt['Depto']." </td>
                  <td>".date_format(New datetime($f_rpt['fecha']),'d/m/Y')." </td>
                  <td>".$f_rpt['tipo_combustible']." </td>
                  <td>".$f_rpt['precio']." </td>
                  <td>".$f_rpt['galones']." </td>
                  <td>".$rps['moneda'].number_format($f_rpt['total'],2,'.',',')." </td>
                  <td>".$f_rpt['observaciones']." </td>
                </tr>
              ";
              
            }
         echo "  
          </tbody>
          
        </table>
        </div>
        </div>
    </div>
		";

 ?>
 <script>
//Hace funcionar los componentes de la tabla
    $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  });
 
</script>