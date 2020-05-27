<?php
 include ("../conexion.php");
 session_start();
 $pais=$_SESSION['usuario']['codigo_pais'];
 $ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
 /////////////////////////////////////////////
$f1=$_POST['f1'];
$f2=$_POST['f2'];
$depto=$_POST['depto'];
$check=$_POST['check'];
////////////////////////////////////////////////////
$in_depto=mysqli_query($conexion,"SELECT * FROM depto where Id_depto='$depto'");
$inf_depto=mysqli_fetch_array($in_depto);
$info_depto="-".$inf_depto['Depto'];
///////////////////////////////////////////////////////
if ($depto=='TODOS') {
  $f_depto='';
  $info_depto='';
}else{
  $f_depto="AND cd.id_depto='$depto'";
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
  tc.descripcion,
  cd.precio,
  cd.idp,
  cd.total_sin_idp,
  cd.base,
  cd.total,
  cd.observaciones,
  cs.estatus
FROM
  combustible_detalle cd
LEFT JOIN depto d ON d.Id_depto = cd.id_depto
LEFT JOIN ruta r ON r.id_ruta = cd.id_ruta
LEFT JOIN combustible_solicitud cs ON cs.id_solicitud=cd.id_solicitud
JOIN tipo_combustible tc ON tc.id_tipocombustible = cd.id_tipocombustible
WHERE
  cd.fecha BETWEEN '$f1'
AND '$f2'
$f_depto
AND cs.estatus='APROBADO'
ORDER BY Depto,canal,ruta,fecha
  ");

if ($check=='true') {
    $th_idp="
              <th>IDP</th>
              <th>Total sin IDP</th>
              <th>Base</th>
    ";
}else{
    $th_idp="        
    ";
}

echo "
    <div class='box box-info'>
      <div class='box-header with-border'>
      
        <h4 class='box-title'> General  ".$info_depto." - <small>Del: ".date_format(new Datetime($f1),'d/m/Y')." Al: ".date_format(new Datetime($f2),'d/m/Y')."</small></h4>
        <a href='../../views/combustible_gExcel.php?f1=$f1&f2=$f2&depto=$depto&check=$check' class='btn btn-success pull-right' title='Descargar reporte'><i class='fa fa-file-excel-o'></i></a>
      </div>
      <div class='box-body'>
      <div style='overflow:scroll;height: 100%  ' >
        <table class='table table-hover table-bordered table-striped' id='example2'>
          <thead>
            <tr>
              <th>Depto</th>
              <th># solicitud</th>
              <th>Ruta</th>
              <th>Piloto</th>
              <th>Tipo Vehi</th>
              <th>Placas</th>
              <th>Canal</th>
              <th>Fecha</th>
              <th>Tipo Comb.</th>
              <th>Cant. Gal.</th>
              <th>Precio</th>
              $th_idp
              <th>Total</th>
              <th>Observaciones</th>
            </tr>
          </thead>
          <tbody>
           ";
          
            while ($f_rpt=mysqli_fetch_array($rpt_depto)) {
              if ($check=='true') {
                
 

                  $td_idp="
                                <td>".$rps['moneda'].number_format($f_rpt['idp'],2,'.',',')." </td>
                                <td>".$rps['moneda'].number_format($f_rpt['total_sin_idp'],2,'.',',')." </td>
                                <td>".$rps['moneda'].number_format($f_rpt['base'],2,'.',',')." </td>
                  ";
                  
              }else{
                  $td_idp="          
                  ";
              }
              echo "
                <tr>
                  <td>".$f_rpt['Depto']." </td>
                  <td>".$f_rpt['id_solicitud']." </td>
                  <td>".$f_rpt['ruta']." </td>
                  <td>".$f_rpt['piloto']." </td>
                  <td>".$f_rpt['tipo_vehi']." </td>
                  <td>".$f_rpt['id_equipo']." </td>
                  <td>".$f_rpt['canal']." </td>
                  <td>".$f_rpt['fecha']." </td>
                  <td>".$f_rpt['descripcion']." </td>
                  <td>".$f_rpt['galones']." </td>
                  <td>".$rps['moneda'].number_format($f_rpt['precio'],2,'.',',')." </td>
                  $td_idp
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