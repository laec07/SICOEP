<?php

include ("../../conexion.php");
session_start();
if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
}else{
	/*************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("d/m/Y");
$mes_actual= Date("m");
$año_actual= date("Y");
$fecha_actual_= Date("Y-m-d");
/************************************************/
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
//////////////////////////////////////////////////////////////
//condicion para traer dos deptos con un usuario (caso san lucas y san pedro juntos)
$sd=$_SESSION['usuario']['Id_depto'];
if ($sd=='3080') {
  $condicion="Id_depto in (3080,1090)";
  $condicion1="AND c.id_depto in (3080,1090)";
  $condicion2="AND id_depto in (3080,1090)";
  $condicion4="AND id_depto in (3080,1090)";
}else{
   $condicion="Id_depto='$sd'";
   $condicion1="AND c.id_depto='$sd'";
   $condicion2="AND id_depto='$sd'";
   $condicion4="AND id_depto='$sd'";
}
$sde=mysqli_query($conexion,"SELECT * FROM depto where $condicion order by Id_depto desc");

/***************Borra solicitudes no procesadas de un día anterior**********************************/
$br=mysqli_query($conexion,"SELECT id_solicitud FROM combustible_solicitud where estatus is null and fecha < '$fecha_actual_'");
while ($fila_borra=mysqli_fetch_row($br)) {
  $dato=$fila_borra['0'];
  mysqli_query($conexion,"DELETE FROM combustible_detalle where id_solicitud='$dato'");
  mysqli_query($conexion,"DELETE FROM combustible_solicitud where id_solicitud='$dato'");
};
/***************************************************/
$pendiente=mysqli_query($conexion,"SELECT
  c.id_solicitud,
  c.fecha,
  c.id_depto,
  d.Depto,
  c.total_galones,
  c.total_efectivo,
  c.usuario_solicita,
  c.estatus,
  c.codigo_pais
FROM
  combustible_solicitud c,depto d
WHERE
  estatus = 'PENDIENTE'
AND c.id_depto=d.Id_depto
$condicion1
AND c.codigo_pais='$pais'
order by c.fecha desc
");
$c_pendiente=mysqli_query($conexion,"SELECT
  count(*) as total
FROM
  combustible_solicitud 
WHERE
  estatus = 'PENDIENTE'
AND codigo_pais='$pais'
$condicion2
");
$cuenta_p=mysqli_fetch_array($c_pendiente);
/****************************************************/
$aprobados=mysqli_query($conexion,"SELECT
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
$condicion1
AND MONTH(fecha)='$mes_actual' 
AND YEAR(c.fecha)='$año_actual'
order by c.fecha desc
");

$c_aprobados=mysqli_query($conexion,"SELECT
  count(*) as total
FROM
  combustible_solicitud
WHERE
  estatus = 'APROBADO'
AND MONTH(fecha)='$mes_actual'
AND YEAR(fecha)='$año_actual'
AND codigo_pais='$pais'
$condicion2

");
$cuenta_a=mysqli_fetch_array($c_aprobados);
/***************************************************/
$rechazados=mysqli_query($conexion,"SELECT
  c.id_solicitud,
  c.fecha,
  c.id_depto,
  d.Depto,
  c.total_galones,
  c.total_efectivo,
  c.usuario_solicita,
  c.estatus,
  c.descripcion
FROM
  combustible_solicitud c,depto d
WHERE
  estatus = 'RECHAZADO'
AND c.id_depto=d.Id_depto
AND MONTH(c.fecha)='$mes_actual'
$condicion1
AND YEAR(c.fecha)='$año_actual'
order by c.fecha desc
");
$c_rechazados=mysqli_query($conexion,"SELECT
  count(*) as total
FROM
  combustible_solicitud
WHERE
  estatus = 'RECHAZADO'
AND MONTH(fecha)='$mes_actual'
AND YEAR(fecha)='$año_actual'
AND codigo_pais='$pais'
$condicion2
");
$cuenta_r=mysqli_fetch_array($c_rechazados);
/******************************************************/
$ts=mysqli_query($conexion,"SELECT sum(total_efectivo) as total FROM combustible_solicitud WHERE  estatus = 'APROBADO' AND codigo_pais='$pais' $condicion4 and MONTH(fecha)='$mes_actual' and YEAR(fecha)='$año_actual' ");
$total=mysqli_fetch_array($ts);
/******************************************************/
$ts_g=mysqli_query($conexion,"SELECT sum(total_galones) as total FROM combustible_solicitud WHERE  estatus = 'APROBADO' AND codigo_pais='$pais' $condicion4 and MONTH(fecha)='$mes_actual' and YEAR(fecha)='$año_actual'");
$total_g=mysqli_fetch_array($ts_g);
}
/******************************************************/
$canal=mysqli_query($conexion,"SELECT * FROM canal where estado='A'");
/**********************************************************/
//$emergente=mysqli_query($conexion,"");
?>
<!DOCTYPE html>
<html>
<head>
  <title>SICOEP</title>
  <meta charset="utf-8">

</head>
<body>
<div class="row">
<div class='col-md-3'>
      <div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <div class="row">
          <div class="col-md-6">
            <h4>Total: <?php echo $rps['moneda']. number_format($total['total'],2,'.',',');?></h4> 
          </div>
          <div class="col-md-2">
            <h4>Galones: <?php echo  number_format($total_g['total'],2,'.',',');?></h4> 
          </div>
        </div>
                 
    </div>
  </div>
  
         <div class="col-md-4">
          <a href="" class="btn btn-info" data-target="#NuevaSolicitud" data-toggle='modal' title="Nueva Solicitud"><i class="fa fa-plus"></i> Nuevo</a>
          
        </div>
      </div>

<div id="solicitud_muestra" ></div>
      <div class="box box-danger">
        <p style="display: none; width: 300px; color: white; background-color: red;" class="help-block" id="aviso" >No tiene suficientes galones disponibles.</p>
        <div id="mostrardatos" >
          <!--Se muestran los datos de la solicitud-->
        </div>                  
      </div>
      <!--Muestra solicitud no procesada para seguir editando-->
    <div id="borrador"></div>
      <!--Pendientes de aprobar-->
        <div class="box box-danger ">
          <div class="box-header">
            <h4 class="box-title">Pendientes de Aprobar <small><?php echo $cuenta_p['total']; ?></small></h4>
            <div class='box-tools pull-right'>
            
          </div>
          </div>
          <div class="box-body">
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
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($fila=mysqli_fetch_array($pendiente)) {
                    echo "
                    <tr>
                      <td>".date_format(date_create($fila['fecha']),'d/m/Y')."</td>
                      <td>".$fila['id_solicitud']."</td>
                      <td>".$fila['Depto']."</td>
                      <td>".$fila['total_galones']."</td>
                      <td>".$rps['moneda'].number_format($fila['total_efectivo'],2,'.',',')."</td>
                      <td>".$fila['usuario_solicita']."</td>
                      <td>
                        <a class='btn btn-warning' onclick='muestra_solicitud(".$fila['id_solicitud'].")'  title='Editar'>
                          <span class='fa fa-edit'> </span>
                        </a>
                        <a class='btn btn-danger' onclicK='confirm_e(".$fila['id_solicitud'].")' title='Eliminar solicitud' >
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
        <!-- /. Pendientes de aprobar-->
        <!--Aprobados mes-->
        <div class="box box-success ">
          <div class="box-header">
            <h4 class="box-title">Aprobados mes actual <small><?php echo $cuenta_a['total']; ?></small></h4>
            <div class='box-tools pull-right'>
            
          </div>
          </div>
          <div class="box-body">
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
                      <td><a class='btn btn-warning' target=_blank title='Imprimir solicitud' href='views/pdf_solicitud.php?ID=".$fila['id_solicitud']."'><span class='fa fa-print'></span></a></td>                       
                    </tr>

                    ";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!--/. Aprobados mes-->
        <!--Rechazados mes-->
        <div class="box box-default ">
          <div class="box-header">
            <h4 class="box-title">Rechazados mes actual <small><?php echo $cuenta_r['total']; ?></small></h4>
            <div class='box-tools pull-right'>
            
          </div>
          </div>
          <div class="box-body">
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
                    <th>Motivo</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($fila_2=mysqli_fetch_array($rechazados)) {
                    echo "
                    <tr>
                      <td>".date_format(date_create($fila_2['fecha']),'d/m/Y')."</td>
                      <td>".$fila_2['id_solicitud']."</td>
                      <td>".$fila_2['Depto']."</td>
                      <td>".$fila_2['total_galones']."</td>
                      <td>".$rps['moneda'].number_format($fila_2['total_efectivo'],2,'.',',')."</td>
                      <td>".$fila_2['usuario_solicita']."</td>
                      <td>".$fila_2['descripcion']."</td>                       
                    </tr>

                    ";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- *************Form ingreso nueva solicitud******************** -->
    <div class="modal" id="NuevaSolicitud" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nueva solicitud</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM id='nuevasolicitud_' method="POST" >    
                          <div class="form-group">
                              <label for="depto">SEDE:</label>
                              <select name="depto" id="depto" class="form-control">
                                <?php
                                  while ($fila_depto=mysqli_fetch_array($sde)) {
                                    echo"
                                      <option value='".$fila_depto['Id_depto']."' >".$fila_depto['Depto']."</option>
                                    ";
                                  }
                                ?>
                              </select>
                              
                              
                              </div>
                          <div class="form-group">
                            <label>CANAL</label>
                            <select name="canal_n" id="canal_n" class="form-control  select2" data-style="btn-info" multiple="multiple" data-placeholder="Seleccione canal" style="width: 100%;  ">
                              <option selected="selected">TODOS</option>
                            <?php
                              while ($fila_n=mysqli_fetch_array($canal)) {
                                echo"
                                  <option value='".$fila_n['canal']."'>".$fila_n['canal']." </option>
                                ";
                              }
                            ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label >Fecha:</label>
                            <input type="date" name="fecha"  id="fecha" class="form-control" value="<?php echo date("Y-m-d");?>">
                          </div>

                          <div class="form-group">
                            <label>Precio combustible:</label>
                            <div class="row"> 

                              <div class="col-md-3">
                                <label>Super</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                  <input type="number" step="0.01" min="1" max="100" name="super" id="super"  placeholder="0.00" required="" class="form-control">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <label>Regular</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                  <input type="number" step="0.01" min="1" max="100" name="regular" id="regular"   placeholder="0.00" required="" class="form-control">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <label>Diesel</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                  <input type="number" step="0.01" name="diesel" id="diesel"  value="0.00"  class="form-control">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <label>Gas</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><?php echo $rps['moneda']; ?></span>
                                  <input type="number" step="0.01" name="gas" id="gas"  value="0.00"  class="form-control">
                                </div>
                              </div>
                              
                            </div>
                          </div>
                            
                    <input type="reset" value="Procesar" onclick="buscar();"  data-dismiss="modal" class="btn btn-success">
                </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  data-dismiss="modal" class="btn btn-warning">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso nueva solicitud******************** -->
<!-- Select2 -->
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="controllers/solicitudes.js"></script>
<script>
  $('.select2').select2()
  get_erase(<?php echo $sd ?>);

</script>
</body>
</html>
