<?php
 include ("../conexion.php");  
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}   
$em=$_SESSION['usuario']['id_empresa'];
$busca_foto=$_SESSION['usuario']['foto'];
if ($busca_foto=="") {
  $foto='../../dist/img/sin_foto.jpg';
}else{
  $foto=$_SESSION['usuario']['foto'];
}

/****************************************************/
$datos_empresa=mysqli_query($conexion,"SELECT * FROM empresa where id_empresa='$em'");
$empresa=mysqli_fetch_array($datos_empresa);
/************************************************/
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/*************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y/m/d");
$mes_actual= Date("m");
$año_actual= date("Y");
//////////////////////////////////////////////
$id_solicitud=$_POST['ID'];
/**********************************************/
$cs=mysqli_query($conexion,"SELECT YEAR(fecha) as year ,MONTH(fecha) as month FROM combustible_solicitud where id_solicitud='$id_solicitud'");
$rcs=mysqli_fetch_array($cs);
$year=$rcs['year'];
$month=$rcs['month'];
/////////////////////////////////////////////////
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
  c.id_tipocombustible,
  c.galones,
  c.precio,
  c.total,
  c.asignado_gal,
  c.restantes_gal,
  c.extra_gal,
  c.observaciones,
  r.restantes_gal AS resto,
  t1.consumido,
  l.orden,
  tc.descripcion
FROM
  combustible_detalle c
INNER JOIN ruta r ON c.id_ruta = r.id_ruta
INNER JOIN tipo_combustible tc ON c.id_tipocombustible = tc.id_tipocombustible
INNER JOIN canal l ON l.canal = c.canal
LEFT JOIN (
  SELECT
    cd.id_depto,
    cd.id_ruta,
    sum(cd.galones) AS consumido
  FROM
    combustible_detalle cd
    JOIN combustible_solicitud cs ON cs.id_solicitud=cd.id_solicitud
  WHERE
    YEAR (cd.fecha) = '$year'
  AND MONTH (cd.fecha) = '$month'
  AND cs.estatus='APROBADO'
  GROUP BY
    cd.id_ruta
) AS t1 ON t1.id_ruta = c.id_ruta
AND t1.id_depto = c.id_depto
WHERE
  c.id_solicitud = '$id_solicitud'
ORDER BY
  l.orden,
  c.ruta
  ");
/****************************************************/
$dt=mysqli_query($conexion,"SELECT Depto FROM depto d,combustible_solicitud c WHERE c.id_solicitud='$id_solicitud' AND c.id_depto=d.Id_depto");
$depto=mysqli_fetch_array($dt);
/***************************************************/
$ts=mysqli_query($conexion,"SELECT sum(total) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total=mysqli_fetch_array($ts);
/******************************************************/
$ts_g=mysqli_query($conexion,"SELECT sum(galones) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total_g=mysqli_fetch_array($ts_g);
/**************************************************************/

?>



  <!-- Content Wrapper. Contains page content -->

    <section class="content-header">
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
          
      </div>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
     
      
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
      <div class='box box-warning'>
        <div class='box-header with-border''>
          
          <div class='row'>
            <div class='col-md-3'>
              <h3 class='box-title'><?php echo $depto['Depto'];?> -</h3><small>Solicitud No. <?php echo $id_solicitud; ?> </small>
            </div>
          </div>
          <button type='button' class=' btn btn-danger pull-right' data-dismiss='alert' onclick="cerrar_soliaprobada();" aria-hidden='true'>Cerrar</button>
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
                  <th>Gal. Excedidos</th>
                  <th></th>
                </tr>   
                </thead>
                <tbody>
                <?php
               

                while ($fila=mysqli_fetch_array($ruta)) {

                  if ($fila['id_tipocombustible']==2) {
                      $selected_r='selected="selected"';
                      $selected_S='';
                      $selected_d='';
                      $selected_g='';
                  }
                  else if ($fila['id_tipocombustible']==1) {
                     $selected_S='selected="selected"';
                     $selected_r='';
                     $selected_d='';
                      $selected_g='';
                  }
                  else if ($fila['id_tipocombustible']==3) {
                    $selected_d='selected="selected"';
                    $selected_S='';
                    $selected_g='';
                    $selected_r='';
                  }
                  else if ($fila['id_tipocombustible']==4) {
                     $selected_g='selected="selected"';
                     $selected_S='';
                     $selected_r='';
                     $selected_d='';

                  }
                  /***********************/
                  $a=$fila['restantes_gal'];
                  $b=$fila['asignado_gal'];
                  $c=$b/2;
                 
                   if ($a > $c) {
                    $clase="class='label label-success' title='Combustile restante arriba del 50%'";
                    $exs="--";
                  }else if($a <= $c and $a > 0 ) {
                    $clase="class='label label-warning' title='Combustile restante abajo del 50%'";
                    $exs="--";
                  }else{
                    $clase="class='label label-danger' title='Sin combustible'";
                    $exs=$fila['consumido']-$b;
                  }
                  /****************************/
                  if ($fila['extra_gal']=='S') {
                    $clase_2="class='danger'";
                    $comentario="<a data-toggle='modal' data-target='#comentarioVer' data-comen='".$fila['observaciones']."'><span class='fa fa-commenting' title='".$fila['observaciones']."'></span></a>";
                    $bnt_a="<a class='btn btn-info' title='Editar galones'
                          data-target='#Mascombustible' data-toggle='modal'
                          data-id_solicitud_e='".$fila['id_solicitud']."'
                          data-id_ruta_e='".$fila['id_ruta']."'
                          data-id_depto_e='".$fila['id_depto']."'
                          data-cantidad='".$fila['galones']."'
                          data-motivo='".$fila['observaciones']."'
                        ><span class='fa fa-minus-square'></span> </a>";
                  }else{
                    $clase_2="";
                     $comentario="";
                     $bnt_a="";
                  }

                    echo "
                    
                    <tr $clase_2 >
                      <td>".$fila['ruta']."</td>
                      <td>".$fila['piloto']."</td>
                      <td>".$fila['tipo_vehi']."</td>
                      <td>".$fila['id_equipo']."</td>
                      <td>".$fila['canal']."</td>
                      <td>
                       ".$fila['descripcion']."
                      </td>
                      <td 
                        id='gal_a'
                        data-id_ruta='".$fila['id_ruta']."' 
                        data-id_depto='".$fila['id_depto']."'
                        data-id_solicitud='".$fila['id_solicitud']."'
                        data-restante='".$fila['restantes_gal']."'
                        data-resto='".$fila['resto']."'
                        data-motivo='".$fila['observaciones']."'
                      >".$fila['galones']." </td>
                      <td>".$fila['precio']."</td>
                      <td>".$fila['total']."</td>
                      <td><span $clase >".$fila['restantes_gal']." </span>$comentario</td>
                      <td>".$fila['asignado_gal']."</td>
                      <td>$exs</td>
                      <td><a class='btn btn-danger' title='Quitar ruta'
                          onclick='remover_b(".$fila['id_ruta'].",".$fila['id_depto'].",".$fila['id_solicitud'].")';
                          
                        ><span class='fa fa-remove'></span> </a>
                        
                        </td>
                    </tr>
                    
                    ";
                  }  
                ?>
                </tbody>
          </table>
            </div>
            <div class='modal-footer'>
            
            <button type='button' class=' btn btn-danger pull-right' data-dismiss='alert' onclick="cerrar_soliaprobada();" aria-hidden='true'>Cerrar</button>
            </div>
          </div><!--Termina box body-->
                  
        </div>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- *************Rechazo******************** -->
   <div class="modal modal-danger fade" id="RechaSolicitud">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Motivo rechazo:</h4>
              </div>
              <div class="modal-body">
                <form action='../../consultas/solicitud_autorizar.php' method="POST">
                    <div class="form-group">
                      <label for="motivo">Describa motivo:</label>
                      <textarea class="form-control" name="motivo"></textarea>
                      <input type='hidden' value=<?php echo $id_solicitud;?> name='id_solicitud'  >
                      <input type="hidden" name="estado" value="RECHAZADO">
                    </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Aplicar</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- *************./Rechazo******************** -->

<!--******************** Editar galonaje extra *************-->
<div class='modal' id='Mascombustible' tabindex='-1' role='dialog' aria-labellebdy='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h4>Editar combustible adicional</h4>                       
                    </div>
                    <div class='modal-body'>
                       <FORM >    
                          <div id='d_gal'>
                            <label>Galones:</label>
                            <input type='number' name='cant_e' id='cant_e' step='0.01' min='0.01' max='99' class='form-control' placeholder='0.00' >
                            <span style='display: none;' class='help-block' id='gal_error'>(*) Campo obligatorio</span> 
                          </div> 
                          <div id='d_motivo'>
                            <label>Motivo:</label>
                            <textarea class='form-control' name='motivo' id='motivo' maxlength='100' placeholder='Describa motivo por el cual necesita combustible adicional a lo asignado' ></textarea>
                            <span style='display: none;' class='help-block' id='motivo_error'>(*) Campo obligatorio</span>
                          </div>
                          <input type='hidden' name='id_ruta_e' id='id_ruta_e' placeholder='Id_ruta' >
                          <input type='hidden' name='id_ruta_e' id='id_depto_e' placeholder='id_depto' >
                          <input type='hidden' name='id_solicitud_e' id='id_solicitud_e' placeholder='Id_solicitud' >
                          

                          
                            </br>
                    <input type='reset' value='Procesar' id='btn_add' onclick='gal_adicional_e();'  data-dismiss='modal' class='btn btn-success'>
                </FORM>
                    </div>
                    <div class='modal-footer'>
                        <button type='button'  data-dismiss='modal' class='btn btn-warning'>Cerrar</button>
                    </div>
                </div>
            </div>
          </div>
<!--********************./ Editar galonaje extra *************-->
<!-- ///////////////////// Comentario //////////////////// -->
<div class="modal fade" id="comentarioVer">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Observaciones:</h4>
              </div>
              <div class="modal-body">
                <input type="text" name="comen" id="comen" readonly="" class="form-control" >
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- ///////////////////// ./ Comentario //////////////////// -->
<script>
   //trae datos para agregar gal
 $('#Mascombustible').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('id_solicitud_e')
      var recipient1 = button.data('id_ruta_e')
      var recipient2 = button.data('id_depto_e')
      var recipient3 = button.data('cantidad')
      var recipient4 = button.data('motivo')     
      

      
       

      var modal = $(this)    
      modal.find('.modal-body #id_solicitud_e').val(recipient0)
      modal.find('.modal-body #id_ruta_e').val(recipient1)
      modal.find('.modal-body #id_depto_e').val(recipient2)
      modal.find('.modal-body #cant_e').val(recipient3)
      modal.find('.modal-body #motivo').val(recipient4)

    });
//valida que no se deje em blanco motivo en solicitud extra
$(document).on("keyup", "#motivo", function(){
  var motivo = document.getElementById('motivo').value
  var cant_e = document.getElementById('cant_e').value;

        if (motivo=="") {
        $('#d_motivo').addClass("form-group has-error")
        $('#motivo_error').show();
      }else{
        $('#d_motivo').removeClass("form-group has-error")
        $('#motivo_error').hide();
      }

      if (motivo=="" || cant_e=="") {
        document.getElementById('btn_add').disabled=true;
      }else{
        document.getElementById('btn_add').disabled=false;
      }
    })
//valida que no se deje em blanco galones en solicitud extra
$(document).on("keyup", "#cant_e", function(){
  var motivo = document.getElementById('motivo').value
  var cant_e = document.getElementById('cant_e').value;

        if (cant_e=="") {
        $('#d_gal').addClass("form-group has-error")
        $('#gal_error').show();
      }else{
        $('#d_gal').removeClass("form-group has-error")
        $('#gal_error').hide();
      }

      if (motivo=="" || cant_e=="") {
        document.getElementById('btn_add').disabled=true;
      }else{
        document.getElementById('btn_add').disabled=false;
      }
    })
   //trae observaciones al modal
 $('#comentarioVer').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('comen')

      var modal = $(this)    
      modal.find('.modal-body #comen').val(recipient0)

    });
 
</script>