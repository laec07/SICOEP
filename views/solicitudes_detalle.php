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
  c.asignado_gal,
  c.restantes_gal,
  r.restantes_gal as resto,
  l.orden
FROM
  combustible_detalle c,
  ruta r,
  canal l
WHERE c.id_ruta=r.id_ruta 
AND c.id_solicitud=$id_solicitud
AND l.canal=c.canal
order by l.orden,c.ruta
  ");
/****************************************************/
$dt=mysqli_query($conexion,"SELECT d.id_depto,d.Depto FROM depto d,combustible_solicitud c WHERE c.id_solicitud='$id_solicitud' AND c.id_depto=d.Id_depto");
$depto=mysqli_fetch_array($dt);
$sd=$depto['id_depto'];
/***************************************************/
$ts=mysqli_query($conexion,"SELECT sum(total) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total=mysqli_fetch_array($ts);
/******************************************************/
$ts_g=mysqli_query($conexion,"SELECT sum(galones) as total FROM combustible_detalle WHERE id_solicitud=$id_solicitud");
$total_g=mysqli_fetch_array($ts_g);
/******************************************************/
$lista_ruta=mysqli_query($conexion,"SELECT * FROM rutas where id_depto='$sd' AND canal= ('MASIVO') AND estado='ACTIVO'");
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
                  
                  <th></th>
                </tr>   
                </thead>
                <tbody>
                <?php
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
                  if ($fila['ruta']=="EMERGENTE") {
                    $dato="<a data-id_ruta='".$fila['id_ruta']."' data-ruta='".$fila['ruta']."' data-piloto='".$fila['piloto']."' data-id_solicitud='".$fila['id_solicitud']."' data-id_depto='".$fila['id_depto']."' title='Cambiar ruta' data-target='#CambiaRuta' data-toggle='modal'><span class='fa fa-cogs' ></span></a>";
                  }else{
                    $dato="";
                  }
                  /*******************************/
                   $a=$fila['restantes_gal'];
                  $b=$fila['asignado_gal'];
                  $c=$b/2;
                 
                  if ($a > $c) {
                    $clase="class='label label-success' title='Combustile restante arriba del 50%'";
                  }else if($a <= $c and $a > 0 ) {
                    $clase="class='label label-warning' title='Combustile restante abajo del 50%'";
                  }else{
                    $clase="class='label label-danger' title='Sin combustible'";
                  }
                  /**************************************/
                  

                    echo "
                    <tr>
                      <td>".$fila['ruta']." $dato</td>
                      <td>".$fila['piloto']."</td>
                      <td>".$fila['tipo_vehi']."</td>
                      <td>".$fila['id_equipo']."</td>
                      <td>".$fila['canal']."</td>
                      <td>
                        <select 
                          id='tipogas_e'                        
                          data-id_ruta='".$fila['id_ruta']."' 
                          data-id_depto='".$fila['id_depto']."'
                          data-id_solicitud='".$fila['id_solicitud']."'
                          data-restante='".$fila['restantes_gal']."'
                          data-resto='".$fila['resto']."' 
                          >
                          <option $selected_r value='REGULAR'>REGULAR</option>
                          <option $selected_S value='SUPER'>SUPER</option>
                          <option $selected_d value='DIESEL'>DIESEL</option>
                          <option $selected_g value='GAS'>GAS</option>
                        </select>
                      </td>
                      <td contenteditable 
                        id='gal_e'
                        data-id_ruta='".$fila['id_ruta']."' 
                        data-id_depto='".$fila['id_depto']."'
                        data-id_solicitud='".$fila['id_solicitud']."'
                        data-restante='".$fila['restantes_gal']."'
                        data-resto='".$fila['resto']."'
                      >".$fila['galones']."</td>
                      <td>".$fila['precio']."</td>
                      <td>".$fila['total']."</td>
                      <td><span $clase>".$fila['restantes_gal']."</span></td>
                      <td>".$fila['asignado_gal']."</td>

                      <td>
                        <a title='Quitar ruta' class='btn btn-danger'
                          onclick='remover(".$fila['id_ruta'].",".$fila['id_depto'].",".$fila['id_solicitud'].")';
                          
                        ><span class='fa fa-remove'></span> </a>
                        <a title='Solicitar más combustible de lo asignado' class='btn btn-info'  data-target='#Mascombustible' data-toggle='modal' data-id_solicitud_e='".$fila['id_solicitud']."' data-id_ruta_e='".$fila['id_ruta']."' data-id_depto_e='".$fila['id_depto']."'>
                          <span class='fa fa-plus-square' ></span></a>
                      </td>
                    </tr>

                    ";
                  }  
                ?>
                </tbody>
          </table>
            </div>
            <div class='modal-footer'>
            <form method='POST' action='../../consultas/solicitud_guarda.php'>
            <input type='hidden' value="<?php echo $id_solicitud ?>" name='id_solicitud' id='id_solicitud' >
            <input type='submit' value='Procesar'  class='btn btn-success'>
            </form>
            
            </div>
          </div><!--Termina box body-->
                  
        </div>
  <div class='modal' id='CambiaRuta' tabindex='-1' role='dialog' aria-labellebdy='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h4>Cubrir ruta EMERGENTE</h4>                       
                    </div>
                    <div class='modal-body'>
                       <FORM >    
                          <div class='form-group'>
                            <label>Ruta:</label>
                            <select name='ruta_h' id='ruta_h' class='form-control'>
                              <?php
                            while ($fila_l=mysqli_fetch_array($lista_ruta)) {
                              echo "<option value='".$fila_l['ruta']."'>".$fila_l['ruta']."</option>";
                            }
                              ?>
                            </select>
                          </div> 
                          <div>
                            <label>Piloto</label>
                            <input name='piloto_h' id='piloto_h'  class='form-control' readonly="">
                          </div>
                          <input type='hidden' name='id_ruta_h' id='id_ruta_h' placeholder='Id_ruta' >
                          <input type='hidden' name='id_solicitud_h' id='id_solicitud_h' placeholder='Id_solicitud' >
                          <input type='hidden' name='id_depto_h' id='id_depto_h' placeholder='Id_solicitud' >

                          
                            </br>
                    <input type='reset' value='Procesar' onclick='cambiar_rutas_();'  data-dismiss='modal' class='btn btn-success'>
                </FORM>
                    </div>
                    <div class='modal-footer'>
                        <button type='button'  data-dismiss='modal' class='btn btn-warning'>Cerrar</button>
                    </div>
                </div>
            </div>
          </div>
<!----------------------------------------------------------------------------------------------------------------->
  <div class='modal' id='Mascombustible' tabindex='-1' role='dialog' aria-labellebdy='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h4>Solicitar combustible adicional</h4>                       
                    </div>
                    <div class='modal-body'>
                       <FORM >    
                          <div id="d_gal">
                            <label>Galones:</label>
                            <input type="number" name="cant_e" id="cant_e" step="0.01" min="0.01" max="99" class="form-control" placeholder="0.00" required="">
                            <span style="display: none;" class="help-block" id="gal_error">(*) Campo obligatorio</span> 
                          </div> 
                          <div id="d_motivo">
                            <label>Motivo:</label>
                            <textarea class="form-control" name="motivo" id='motivo' maxlength="100" placeholder="Describa motivo por el cual necesita combustible adicional a lo asignado" required="" ></textarea>
                            <span style="display: none;" class="help-block" id="motivo_error">(*) Campo obligatorio</span>
                          </div>
                          <input type='hidden' name='id_ruta_e' id='id_ruta_e' placeholder='Id_ruta' >
                          <input type='hidden' name='id_ruta_e' id='id_depto_e' placeholder='id_depto' >
                          <input type='hidden' name='id_solicitud_e' id='id_solicitud_e' placeholder='Id_solicitud' >
                          

                          
                            </br>
                    <input type='reset' value='Procesar' id="btn_add" onclick='gal_adicional();'  data-dismiss='modal' class='btn btn-success'>
                </FORM>
                    </div>
                    <div class='modal-footer'>
                        <button type='button'  data-dismiss='modal' class='btn btn-warning'>Cerrar</button>
                    </div>
                </div>
            </div>
          </div>

        
  <!-- *************Form ingreso nueva solicitud******************** -->    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
//trae datos para cambiar emergente
 $('#CambiaRuta').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('id_solicitud')
      var recipient1 = button.data('id_ruta')
      var recipient2 = button.data('piloto')
      var recipient3 = button.data('ruta')
       var recipient4 = button.data('id_depto')
      

      var modal = $(this)    
      modal.find('.modal-body #id_solicitud_h').val(recipient0)
      modal.find('.modal-body #id_ruta_h').val(recipient1)
      modal.find('.modal-body #piloto_h').val(recipient2)
      modal.find('.modal-body #ruta_h').val(recipient3)
      modal.find('.modal-body #id_depto_h').val(recipient4)

      
    });

 //trae datos para agregar gal
 $('#Mascombustible').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('id_solicitud_e')
      var recipient1 = button.data('id_ruta_e')
      var recipient2 = button.data('id_depto_e')     
      

      
        $('#d_motivo').addClass("form-group has-error")
        $('#motivo_error').show();
        

        $('#d_gal').addClass("form-group has-error")
        $('#gal_error').show();

      document.getElementById('btn_add').disabled=true;

      var modal = $(this)    
      modal.find('.modal-body #id_solicitud_e').val(recipient0)
      modal.find('.modal-body #id_ruta_e').val(recipient1)
      modal.find('.modal-body #id_depto_e').val(recipient2)

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

 </script>
