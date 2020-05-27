<?php
include ("../conexion.php");  
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/****************************************/
$depto_f=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais' and usa_vehi='S'" );
/***************************************/
$canal3=mysqli_query($conexion,"SELECT * FROM canal where estado='A'");
/****************************************/
/*************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
$mes_actual= Date("m");
$año_actual= date("Y");
/*************************************************/
$depto_rutas=mysqli_query($conexion,"
SELECT
  r.id_depto,
  d.Depto,
  COUNT(r.ruta) AS total,
  SUM(r.asignado_gal) AS asignado,
  SUM(r.restantes_gal) AS restante,
  SUM(r.restantes_gal) * 100 / SUM(r.asignado_gal) AS porcentaje,
  c1.consumido 
FROM
  ruta r
JOIN depto d ON r.id_depto = d.Id_depto
LEFT JOIN (SELECT
  c.id_depto,
  SUM(c.galones) as consumido
FROM
  combustible_detalle c,
  combustible_solicitud cs
WHERE
  cs.id_solicitud = c.id_solicitud
AND cs.estatus = 'APROBADO'
AND MONTH(cs.fecha)='$mes_actual'
AND YEAR(cs.fecha)='$año_actual'
GROUP BY c.id_depto) as c1 ON c1.id_depto=d.Id_depto
WHERE
 d.codigo_pais = '$pais'
AND r.estado = 'ACTIVO'
GROUP BY
  d.id_depto
  ");
/******************************************/

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
 <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
   
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
</head>
<body>
  <?php
$i=1;

while ($fila_d=mysqli_fetch_array($depto_rutas)) {
  
  if ($fila_d['porcentaje'] >= 50.00) {
    $labe='class="label label-success"';
    $box='class="box box-primary collapsed-box"';
  }else if($fila_d['porcentaje'] < 50 && $fila_d['porcentaje'] >0){
      $labe='class="label label-warning"';
      $box='class="box box-warning collapsed-box"';
  }else if ($fila_d['porcentaje'] <=0) {
    $labe='class="label label-danger"';
    $box='class="box box-danger collapsed-box"';
  }
  
    $cms=$fila_d['consumido']-$fila_d['restante'];
  if (($cms >=0) && ($fila_d['restante']=0) ) {
    $excedidos="<label class='label label-danger'>|| Excedidos " .$fila_d['consumido']."</label>";
  }else{
    $excedidos="";
  }

  echo '
    <div '.$box.' >
  <div class="box-header with-border">
    '.$fila_d['Depto'].' ||<label class="label label-info"> '.$fila_d['total'].' Rutas activas </label> || '.$fila_d['asignado'].' Asignados || '.$fila_d['restante'].' Restantes <label '.$labe.'>'.round($fila_d['porcentaje']).'%</label> || '.$fila_d['consumido'].'  Comsumidos  '.$excedidos.'

    <div class="box-tools pull-right">

      <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse"><i class="fa fa-plus"></i></button>
      <a href="../../consultas/rutas_restablece.php?id_depto='.$fila_d['id_depto'].'" class="btn btn-success" title="Restablece Galones disponible según lo asignado" onclick="return confirm(\'Esta acción reiniciar los galones disponibles según lo asignado a cada ruta activa en '.$fila_d['Depto'].', ¿Desea continuar?\')"><span class="fa fa-history"></span></a>
    </div>
  </div>
  <div class="box-body">
    <div style="overflow: scroll; width: 100%">
  ';
  $c_depto=$fila_d['id_depto'];

  $ruta=mysqli_query($conexion,
  "
SELECT
  r.id_ruta,
  r.ruta,
  r.id_equipo,
  r.piloto,
  r.canal,
  r.id_depto,
  d.Depto,
  r.tipo_vehi,
  r.estado,
  r.asignado_gal,
  r.restantes_gal,
  c.consumido,
  rs.canal as canal_r,
  rs.frecuencia1,
  rs.frecuencia2,
  rs.frecuencia3,
  rs.km1,
  rs.km2,
  rs.km3,
  rs.clientes1,
  rs.clientes2,
  rs.clientes3
FROM
  ruta r
INNER JOIN depto d ON r.id_depto = d.Id_depto
INNER JOIN canal l ON l.canal = r.canal
LEFT JOIN rutas rs ON rs.ruta=r.ruta and r.id_depto=rs.Id_depto
LEFT JOIN (
  SELECT
    cd.id_ruta,
    SUM(galones) AS consumido
  FROM
    combustible_detalle cd,
    combustible_solicitud cs
  WHERE
    cs.id_solicitud = cd.id_solicitud
  AND cs.estatus = 'APROBADO'
  AND MONTH (cs.fecha) = '$mes_actual'
  AND YEAR (cs.fecha) = '$año_actual'
  GROUP BY
    cd.id_ruta
) AS c ON c.id_ruta = r.id_ruta
WHERE
  r.codigo_pais = '$pais'
AND r.estado IN ('ACTIVO', 'INACTIVO')
AND r.id_depto = '$c_depto'
ORDER BY
  r.estado,
  d.Depto,
  l.orden,
  r.ruta
  ");
  
echo '
                <table id="example'.$i.'" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th>id asig.</th>               
                          <th>Ruta</th>
                          <th>Piloto</th>
                          <th>Tipo vehi.</th>
                          <th>Placa</th>
                          <th>Canal</th>
                          <th>Sede</th>
                          <th>Estado</th>
                          <th>Gal. Asig.</th>
                          <th>Gal. Disponibles.</th>
                          <th>Consumidos</th>
                          <th>Excedido</th>
                          <th><span class="glyphicon glyphicon-wrench"></span></th>
                        </tr>   
                    </thead>
                    <tbody>
';
$i++;
                while ($fila=mysqli_fetch_array($ruta)) {
                  /*****************************/
                  if ($fila['estado']=="ACTIVO") {
                    $selected_a='selected="selected"';
                    $selected_b='';
                    $color_fila='';
                  }else{
                    $selected_a='';
                    $selected_b='selected="selected"';
                    $color_fila='class="danger"';
                  }
                  /*******************************/
                    $ex=$fila['consumido']-$fila['asignado_gal'];
                    if (($ex>0)&& ($fila['restantes_gal']==0) ) {
                      $exs="<label class='label label-danger'>".$ex."</label>";
                    }else{
                        $exs="--";
                    }
                  /***********************************/
                  $a=$fila['restantes_gal'];
                  $b=$fila['asignado_gal'];
                  $c=$b/2;
                  /*************************************/
                  if ($fila['canal_r']=='MASIVO') {
                    
                    $total_clientes=$fila['clientes1']+$fila['clientes2']+$fila['clientes3'];
                    $total_kilometros=$fila['km1']+$fila['km2']+$fila['km3'];
                    $ver_frecuencia="<a class='fa fa-eye' data-target='#MuestraFrecuencia' data-toggle='modal' 
                                            data-ruta='".$fila['ruta']."' 
                                            data-f1='".$fila['frecuencia1']."'
                                            data-f2='".$fila['frecuencia2']."'
                                            data-f3='".$fila['frecuencia3']."'
                                            data-km1='".$fila['km1']."'
                                            data-km2='".$fila['km2']."'
                                            data-km3='".$fila['km3']."'
                                            data-cl1='".$fila['clientes1']."'
                                            data-cl2='".$fila['clientes2']."'
                                            data-cl3='".$fila['clientes3']."'
                                            data-tkm='".$total_kilometros."'
                                            data-tcl='".$total_clientes."'

                                    ></a>";
                  }else{
                     $ver_frecuencia="";
                  }
                 
                  if ($a > $c) {
                    $status="<i class='fa fa-circle text-success' title='Combustile restante arriba del 50%'></i>";
                    $clase="class='label label-success' title='Combustile restante arriba del 50%'";
                  }else if($a <= $c and $a > 0 ) {
                    $status="<i class='fa fa-circle text-warning' title='Combustile restante abajo del 50%'></i>";
                    $clase="class='label label-warning' title='Combustile restante abajo del 50%'";
                  }else{
                     $status="<i class='fa fa-circle text-danger' title='Sin combustible'></i>";
                     $clase="class='label label-danger' title='Sin combustible'";
                  }
                  /*****************************************************/
                    echo "
                    <tr $color_fila>
                      <td>".$fila['id_ruta']."</td>
                      <td>".$fila['ruta']."".$ver_frecuencia."</td>
                      <td>".$fila['piloto']."</td>
                      <td>".$fila['tipo_vehi']."</td>
                      <td>".$fila['id_equipo']."</td>
                      <td>".$fila['canal']."</td>
                      <td>".$fila['Depto']."</td>
                      <td>
                          <select id='iactivar' 
                                data-id_ruta='".$fila['id_ruta']."'
                              >
                              <option $selected_a>ACTIVO</option>
                              <option $selected_b>INACTIVO</option>
                          </select>
                      </td>
                      <td contenteditable
                        id='gal'
                        data-id_ruta='".$fila['id_ruta']."'
                      >".$fila['asignado_gal']."</td>
                      <td><label $clase>".$fila['restantes_gal']."</label></td>
                      <td>".$fila['consumido']."</td>
                      <td>".$exs."</td>
                      <td><a class='btn btn-warning' title='Editar' data-target='#EditaRuta' data-toggle='modal'
                            data-id_ruta='".$fila['id_ruta']."'
                            data-ruta='".$fila['ruta']."'
                            data-estado='".$fila['estado']."'
                            data-piloto='".$fila['piloto']."'
                            data-tipo='".$fila['tipo_vehi']."'
                            data-placa='".$fila['id_equipo']."'
                            data-canal='".$fila['canal']."'

                          ><span class='glyphicon glyphicon-pencil '></span></a>
                          <a class='btn btn-success' title='Restablecer galones ruta' onclick='rutas_restablece(".$fila['id_ruta'].");' ><span class='fa fa-history'></span></a>
                      </td>

                    </tr>

                    ";
                  }
  echo '
              </tbody>
          </table>
    </div>
  </div>
</div>
  ';
}
  ?>
<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>