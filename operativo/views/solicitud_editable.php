<?php
include("../../conexion.php");
session_start();
$sd=$_SESSION['usuario']['Id_depto'];
$ID=$_POST['ID'];
/**********************************************************************/
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/////////////////////////////////////////////
$ts=mysqli_query($conexion,"SELECT sum(total) as total FROM combustible_detalle WHERE id_solicitud=$ID");
$total_e=mysqli_fetch_array($ts);
$total_efectivo=$total_e['total'];

$ts=mysqli_query($conexion,"SELECT sum(galones) as galones FROM combustible_detalle WHERE id_solicitud=$ID");
$total_g=mysqli_fetch_array($ts);
$total_galones=$total_g['galones'];
/**********************************************************************/
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
AND c.id_solicitud=$ID
AND l.canal=c.canal
order by l.orden,c.ruta
  ");
/****************************************************************************/
$lista_ruta=mysqli_query($conexion,"SELECT r.id,r.ruta,r.Id_depto,r.estado,r.codigo_pais,r.canal FROM rutas r, combustible_detalle c where r.canal= ('MASIVO') AND   r.estado='ACTIVO' AND r.ruta=c.ruta and r.Id_depto=c.id_depto  and c.id_solicitud='$ID'");
/******************************************************************************/
echo "
          <div class='box-header'>
            <h4> <span class='alert alert-info'>Total: ".$rps['moneda'].$total_efectivo."  Galones: ".$total_galones."</span><small> Solicitud No. ".$ID."</small></h4>
           <!--<a href='#'  class='btn btn-success pull-right'><i class='fa fa-file-excel-o'></i></a>-->
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
                  
                  
                  
                  
                  
                  <th><span class='glyphicon glyphicon-wrench'></span></th>
                </tr>   
                </thead>
                <tbody>";
                
                while ($fila=mysqli_fetch_array($ruta)) {

                  $a=$fila['restantes_gal'];
                  $b=$fila['asignado_gal'];
                  $c=$b/2;
                 
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

                  if ($fila['ruta']=="EMERGENTE") {
                    $dato="<a data-id_ruta='".$fila['id_ruta']."' data-ruta='".$fila['ruta']."' data-piloto='".$fila['piloto']."' data-id_solicitud='".$fila['id_solicitud']."' data-id_depto='".$fila['id_depto']."' title='Cambiar ruta' data-target='#CambiaRuta' data-toggle='modal'><span class='fa fa-cogs' ></span></a>";
                  }else{
                    $dato="";
                  }

                  

                    echo "
                    <form >
                    <tr>
                      <td><span $clase > </span>".$fila['ruta']." $dato</td>
                      <td>".$fila['piloto']."</td>
                      <td>".$fila['tipo_vehi']."</td>
                      <td>".$fila['id_equipo']."</td>
                      <td>".$fila['canal']."</td>
                      <td>
                        <select 
                          id='tipogas_r' 
                          data-id_ruta='".$fila['id_ruta']."' 
                          data-id_depto='".$fila['id_depto']."'
                          data-id_solicitud='".$fila['id_solicitud']."' 
                          >
                          <option $selected_r value='2'>REGULAR</option>
                          <option $selected_S value='1'>SUPER</option>
                          <option $selected_d value='3'>DIESEL</option>
                          <option $selected_g value='4'>GAS</option>
                        </select>
                        </td>
                      <td contenteditable
                        id='gal_r' 
                        data-id_ruta='".$fila['id_ruta']."' 
                        data-id_depto='".$fila['id_depto']."'
                        data-id_solicitud='".$fila['id_solicitud']."'
                        data-restante='".$fila['restantes_gal']."'
                        data-resto='".$fila['resto']."'
                      >".$fila['galones']."</td>
                      <td>".$fila['precio']."</td>

                      <td>".$fila['total']."</td>
                      
                      
                      
                      
                      <td>
                        <a title='Quitar ruta' onclick='remover(".$fila['id_ruta'].",".$fila['id_depto'].",".$fila['id_solicitud'].")'; class='btn btn-danger'>
                          <span class='fa fa-remove'></span> 
                        </a>
                        <a title='Solicitar más combustible de lo asignado' class='btn btn-info'  data-target='#Mascombustible' data-toggle='modal' data-id_solicitud_e='".$fila['id_solicitud']."' data-id_ruta_e='".$fila['id_ruta']."' data-id_depto_e='".$fila['id_depto']."'>
                          <span class='fa fa-plus-square' ></span>
                        </a>
                      </td>
                    </tr>

                    ";
                  }  
                echo "
                </tbody>
          </table>
          </form>
          </div><!--Termina box body-->
            <div class='' id='div_espera'>
            <i id='espera_1' class=''></i> 
          </div>
          <div class='modal-footer'>
            <form method='POST' action='../../consultas/solicitud_guarda.php'>
            <input type='hidden' value='".$ID."'  name='id_solicitud_e' id='id_solicitud_e' >
            <input type='button' value='Procesar'  class='btn btn-success' onclick='guarda_s(".$ID.");'>
            <button type='button'  onclick='solicitud()' class='btn btn-warning'>Cerrar</button>
            </form>
            
            </div>

   
    <div class='modal' id='CambiaRuta' tabindex='-1' role='dialog' aria-labellebdy='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h4>Nueva solicitud</h4>                       
                    </div>
                    <div class='modal-body'>
                       <FORM  >    
                          <div class='form-group'>
                            <label>Ruta:</label>
                            <select name='ruta_h' id='ruta_h' class='form-control'>
                            ";while ($fila_l=mysqli_fetch_array($lista_ruta)) {
                              echo "<option value='".$fila_l['ruta']."'>".$fila_l['ruta']."</option>";
                            }
                              echo"
                            </select>
                          </div> 
                          <div>
                            <label>Piloto</label>
                            <input name='piloto_h' id='piloto_h'  class='form-control' readonly></input>
                          </div>
                          <input type='hidden' name='id_ruta_h' id='id_ruta_h' placeholder='Id_ruta' ></input>
                          <input type='hidden' name='id_solicitud_h' id='id_solicitud_h' placeholder='Id_solicitud' ></input>
                          <input type='hidden' name='id_depto_h' id='id_depto_h' placeholder='Id_solicitud' ></input>

                          
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
  <!-- *************Combustible adicional******************** -->         
  <div class='modal' id='Mascombustible' tabindex='-1' role='dialog' aria-labellebdy='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h4>Solicitar combustible adicional</h4>                       
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
                    <input type='reset' value='Procesar' id='btn_add' onclick='gal_adicional();'  data-dismiss='modal' class='btn btn-success'>
                </FORM>
                    </div>
                    <div class='modal-footer'>
                        <button type='button'  data-dismiss='modal' class='btn btn-warning'>Cerrar</button>
                    </div>
                </div>
            </div>
          </div>

        
  <!-- *************Combustible adicional******************** -->            


";
mysqli_close($conexion);
?>
<script>
//trae datos para editar usuario
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