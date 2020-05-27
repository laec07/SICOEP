<?php
include("../conexion.php");
session_start();
$opcion=$_POST['opcion'];
$id_ruta=$_POST['id_ruta'];
$id_depto=$_POST['id_depto'];
$id_solicitud=$_POST['id_solicitud'];
////////////////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/////////////////////////////////////////////////////////////////////
$dts=mysqli_query($conexion,"SELECT Depto FROM depto WHERE id_depto='$id_depto'");
$depto=mysqli_fetch_array($dts);
///////////////////////////////////////////////////////////////////
$dt=mysqli_query($conexion,"SELECT id_precio,super,regular,diesel,gas,fecha FROM precio_combustible where id_solicitud='$id_solicitud'");
$dato=mysqli_fetch_array($dt);
if ($opcion=='SUPER') {
	$precio=$dato['super'];
}else if ($opcion=='REGULAR') {
	$precio=$dato['regular'];
}else if($opcion=='DIESEL'){
	$precio=$dato['diesel'];
}else if($opcion=='GAS'){
	$precio=$dato['gas'];
}
///////////////////////////////////////////////////////////////
$ts=mysqli_query($conexion,"SELECT sum(total) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total=mysqli_fetch_array($ts);
///////////////////////////////////////////////////////////////
mysqli_query($conexion,"UPDATE combustible_detalle
SET tipo_combustible = '$opcion',precio='$precio',total=round(precio*galones)
WHERE
  id_solicitud = '$id_solicitud'
AND id_depto = '$id_depto'
AND id_ruta = '$id_ruta'");
//////////////////////////////////////////////////////////////////

$ruta=mysqli_query($conexion,
  "
SELECT
  c.id_solicitud,
  c.id_depto,
  c.id_ruta,
  r.ruta,
  r.piloto,
  r.tipo_vehi,
  r.id_equipo,
  r.canal,
  c.tipo_combustible,
  c.galones,
  c.precio,
  c.total,
  r.asignado_gal,
  r.restantes_gal
FROM
  combustible_detalle c,
  ruta r
WHERE c.id_ruta=r.id_ruta 
AND c.id_solicitud=$id_solicitud
  ");

echo "
<div class='box-header'>
  <div class='row'>
    <div class='col-md-3'>
      <h3 class='box-title'>".$depto['Depto']." -</h3><small>Solicitud No. ".$id_solicitud." </small>
    </div>
    <div class='col-md-3'>
      <div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4>Total: ".$rps['moneda']. number_format($total['total'],2,'.',',')."</h4>          
    </div>
  </div>
</div>
            
<div class='box-body'>
            <div style='overflow:scroll;height: 100% '>
              <table id='example2' class='table table-bordered table-striped'>
                <thead>
                  <tr>               
                  <th>Ruta</th>
                  <th>Piloto</th>
                  <th>Tipo vehi.</th>
                  <th>Placa</th>
                  <th>Canal</th>
                  <th>tipo combustible</th>
                  <th>Galones</th>
                  <th>Precio</th>
                  <th>Total</th>
                  <th>Gal. disponibles</th>
                  <th>Gal. Asignados</th>
                  <th><span class='glyphicon glyphicon-wrench'></span></th>
                </tr>   
                </thead>
                <tbody>";
                
                while ($fila=mysqli_fetch_array($ruta)) {

                  if ($fila['tipo_combustible']=='REGULAR') {
                      $selected_r='selected="selected"';
                      $selected_S='';
                      $selected_d='';
                      $selected_g='';
                  }
                  else if ($fila['tipo_combustible']=='SUPER') {
                     $selected_S='selected="selected"';
                     $selected_r='';
                     $selected_d='';
                      $selected_g='';
                  }
                  else if ($fila['tipo_combustible']=='DIESEL') {
                    $selected_d='selected="selected"';
                    $selected_S='';
                    $selected_g='';
                    $selected_r='';
                  }
                  else if ($fila['tipo_combustible']=='GAS') {
                     $selected_g='selected="selected"';
                     $selected_S='';
                     $selected_r='';
                     $selected_d='';

                  }

                    echo "
                    <tr>
                      <td>".$fila['ruta']."</td>
                      <td>".$fila['piloto']."</td>
                      <td>".$fila['tipo_vehi']."</td>
                      <td>".$fila['id_equipo']."</td>
                      <td>".$fila['canal']."</td>
                      <td>
                        <select 
                          id='tipogas'                        
                          data-id_ruta='".$fila['id_ruta']."' 
                          data-id_depto='".$fila['id_depto']."'
                          data-id_solicitud='".$fila['id_solicitud']."'
                          data-restante='".$fila['restantes_gal']."' 
                          >
                          <option $selected_r value='REGULAR'>REGULAR</option>
                          <option $selected_S value='SUPER'>SUPER</option>
                          <option $selected_d value='DIESEL'>DIESEL</option>
                          <option $selected_g value='GAS'>GAS</option>
                        </select>
                      </td>
                      <td contenteditable
                      	id='gal' 
                      	data-id_ruta='".$fila['id_ruta']."' 
                        data-id_depto='".$fila['id_depto']."'
                        data-id_solicitud='".$fila['id_solicitud']."'
                      >".$fila['galones']."</td>
                      <td>".$fila['precio']."</td>
                      <td>".$fila['total']."</td>
                      <td>".$fila['restantes_gal']."</td>
                      <td>".$fila['asignado_gal']."</td>
                      <td></td>
                    </tr>

                    ";
                    
                  }  
                echo "
                </tbody>
          </table>
            </div>
            <div class='modal-footer'>
            <form method='POST' action='../../consultas/solicitud_guarda.php'>
            <input type='hidden' value='".$id_solicitud."' name='id_solicitud' id='id_solicitud' >
            <input type='submit' value='Procesar'  class='btn btn-success'>
            </form>
            
            </div>
          </div><!--Termina box body-->


";

mysqli_close($conexion);
?>