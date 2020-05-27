<?php
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
} 
?>
  <!-- DataTables -->
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Estilo boton editar sobre foto -->
  <link rel="stylesheet"  href="../dist/css/imagen_hover.css">
  <!-- Estilo para fotos -->
  <link rel="stylesheet" href="../bower_components/foto/foto.css">
  <link rel="stylesheet"  href="../dist/css/lightbox.css">


<div class="row">
<div class="col-md-8">
      <div id="alert_insert" class="alert alert-success col-md-6" style="display: none;" >
  Dato insertado correctamente!
</div>
<div id="alert_update" class="alert alert-success col-md-6" style="display: none;" >
  Dato actualizado correctamente!
</div>
</div>
<div class="col-md-2">
  <a href="" class="btn btn-info" data-target="#NuevoUsuario" data-toggle='modal' title="Nueva Ruta"><i class="fa fa-plus"></i> Agregar</a>
</div>
</div>









<div id="general_usuarios">
	
</div>

 <!-- *************Form ingreso nuevo usuario******************** -->
    <div class="modal" id="NuevoUsuario" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nuevo usuario</h4>                       
                    </div>
                    <div class="modal-body">
  
                         <div class="form-group">
                          <label >NOMBRE:</label>
                          <input type="text" id="nombre"  placeholder="nombre" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label >USUARIO:</label>
                          <input type="text" id="usuario" placeholder="usuario" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label>CORREO:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                          <input type="email" class="form-control" placeholder="Email" id="correo">
                          </div>
                        </div>
                        <div class="form-group">
                          <label >CLAVE:</label>
                          <input type="password" name="clave" id="clave"  placeholder="******" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label >CONFIRMAR CLAVE:</label>
                          <input type="password" name="clave2"  id="clave2" placeholder="******" class="form-control" maxlength="200" onkeyup="repite();" required="">
                          <p style="display: none;" class="help-block" id="aviso" style="color: red;">Por favor repita su nueva contraseña</p>
                        </div>
                        <div class="form-group">
                          <label >TIPO:</label>
                          <SELECT  name="tipo" id="tipo"  class="form-control" onchange="tipo_f();" >
                            <option value="Admin_equipo">ADMINISTRADOR</option>
                            <option value="Ticket_user">TICKET</option>
                          </SELECT>
                        </div>
                       
                         <div class="form-group">
                            <label for="estado">ESTADO:</label>
                            <SELECT  name="estado" class="form-control" id="estado"  >
                              <option>ACTIVO</option>
                              <option>INACTIVO</option>
                            </SELECT>
                          </div>
                          <a   class="btn btn-primary pull-right" onclick="usuario_guarda();" data-dismiss="modal" id="boton" >Guardar</a>
                
 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso nuevo usuario******************** -->
  <!-- *************Form Editar usuario******************** -->
    <div class="modal" id="EditarUsuario" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>EDITAR USUARIO</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="" method="POST" >    
                         <div class="form-group">
                          <label >NOMBRE:</label>
                          <input type="text" id="nombre_e" name="nombre_e" placeholder="nombre" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label >USUARIO:</label>
                          <input type="text" id="usuario_e" name="usuario_e" placeholder="usuario" class="form-control" maxlength="200" readonly="">
                        </div>
                        <div class="form-group">
                          <label>CORREO:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                          <input type="email" class="form-control" placeholder="Email" name="correo_e" id="correo_e">
                          </div>
                        </div>
                        <div class="form-group">
                          <label >CLAVE:</label>
                          <input type="password" name="clave_e" id="clave_e" onkeyup="repite_e2();" placeholder="******" class="form-control" maxlength="200" required="">
                        </div>
                        <div class="form-group">
                          <label >CONFIRMAR CLAVE:</label>
                          <input type="password" name="clave2_e"  id="clave2_e" placeholder="******" class="form-control" maxlength="200" onkeyup="repite_e();" required="">
                          <p style="display: none;" class="help-block" id="aviso_e" style="color: red;">Por favor repita su nueva contraseña</p>
                        </div>
                        <div class="form-group">
                          <label >TIPO:</label>
                          <SELECT  name="tipo_e" id="tipo_e"  class="form-control" onchange="tipo_fe();" >
                            <option value="Admin_equipo">ADMINISTRADOR</option>
                            <option value="Ticket_user">TICKET</option>
                          </SELECT>
                        </div>
                        <div class="form-group" id="estatus_e" style="display: none;">
                            <label for="sede">SEDE:</label>
                            <SELECT  name="sede_e" id='sede_e' class="form-control" >
                            <?php 
                              while($fila=mysqli_fetch_row($Result2)){
                                  echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                              }
                            ?>
                            </SELECT>
                        </div>

                       
                         <div class="form-group">
                            <label for="estado">ESTADO:</label>
                            <SELECT  name="estado_e" id='estado_e' class="form-control" id="estado"  >
                              <option>ACTIVO</option>
                              <option>INACTIVO</option>
                            </SELECT>
                          </div>
                                  <a class="btn btn-primary pull-right" id="boton_e" data-dismiss="modal" onclick="usuario_edita()" >Actualizar</a>
                </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************/. Form Editar usuario******************** -->
    <!-- *************Form Editar permisos******************** -->
    <div class="modal" id="EditaPermisos" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>EDITAR PERMISOS USUARIO</h4>                       
                    </div>
                    <div class="modal-body">
                       <div id="show_permission_">Hola</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************/. Form Editar usuario******************** -->
  <!-- *************Form ingreso fotos******************** -->
        <div class="modal fade" id="editPick">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar foto</h4>
              </div>
              <div class="modal-body">
                <form >
                 
              <input type="text"  name="usuario_f" id="usuario_f" style="display: none;" >
               <input  type="file" id="imagen" name="imagen" class="input-file ng-pristine ng-valid ng-touched" files-model="" ng-model="project.fileList">
              <div  class="upload2" upload-image="" id="imagePreview1">
                <label for="imagen">
                  <span class="add-image">
                    Foto </br>1
                  </span>
                  <output id="list" for="imagePreview1"></output>
                </label>
              </div>
              <button onclick="fotoUsuario_guarda();" type="reset" class="btn btn-primary btn-block" data-dismiss="modal">Guardar</button>
            </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <!-- *************./Form ingreso fotos******************** --> 
<script src="controllers/usuarios.js"></script>

<script>
lista_usuarios();



  function repite(){
    var nueva = document.getElementById('clave').value
    var confirm=document.getElementById('clave2').value
    if (confirm==nueva) {
      document.getElementById('aviso').style.display='none'
      document.getElementById('aviso').style.color='red'
      document.getElementById('boton').disabled = false; 
    }else{
      document.getElementById('aviso').style.display='block'
      document.getElementById('aviso').style.color='red'
      document.getElementById('boton').disabled = true;
    }
  }
 /////////////////////////////editar//////////////////////
  function repite_e(){
    var nueva = document.getElementById('clave_e').value
    var confirm=document.getElementById('clave2_e').value
    if (confirm==nueva) {
      document.getElementById('aviso_e').style.display='none'
      document.getElementById('aviso_e').style.color='red'
      document.getElementById('boton_e').disabled = false; 
    }else{
      document.getElementById('aviso_e').style.display='block'
      document.getElementById('aviso_e').style.color='red'
      document.getElementById('boton_e').disabled = true;
    }
  }

  function repite_e2(){
    var nueva = document.getElementById('clave_e').value
    var confirm=document.getElementById('clave2_e').value
    if (confirm==nueva) {
      document.getElementById('aviso_e').style.display='none'
      document.getElementById('aviso_e').style.color='red'
      document.getElementById('boton_e').disabled = false; 
    }else{
      document.getElementById('aviso_e').style.display='block'
      document.getElementById('aviso_e').style.color='red'
      document.getElementById('boton_e').disabled = true;
    }
  }

  function tipo_fe(){
    var lista = document.getElementById('tipo_e')
    var opcion = lista.options[lista.selectedIndex].value;
    var opcion = lista.options[lista.selectedIndex].text;
  }

$('#EditarUsuario').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato0 = button.data('usuario_e')
      var dato1 = button.data('nombre_e')
      var dato2 = button.data('clave_e')
      var dato3 = button.data('clave_e')
      var dato4 = button.data('tipo_e')
      var dato5 = button.data('depto_e')
      var dato6 = button.data('estado_e')

      var dato9 = button.data('correo')


      var modal = $(this)
      modal.find('.modal-body #usuario_e').val(dato0)
      modal.find('.modal-body #nombre_e').val(dato1)
      modal.find('.modal-body #clave_e').val(dato2)
      modal.find('.modal-body #clave2_e').val(dato3)
      modal.find('.modal-body #tipo_e').val(dato4)
      modal.find('.modal-body #sede_e').val(dato5)
      modal.find('.modal-body #estado_e').val(dato6)

      modal.find('.modal-body #correo_e').val(dato9)
    });
$('#editPick').on('hidden.bs.modal', function(){ 

    $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
    $('#imagePreview1').html("<label for='imagen'><span class='add-image'>Foto </br>1</span><output id='list' for='imagePreview1'></output></label>");
  });
//trae datos para editar usuario
 $('#editPick').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('usuario')


      var modal = $(this)    
      modal.find('.modal-body #usuario_f').val(recipient0)

    });
//Visualizar imagen previa
  (function(){
    function filePreview(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e){
          $('#imagePreview1').html("<img src='"+e.target.result+"'/ class= 'img2'>");
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#imagen').change(function(){
      filePreview(this);
    })
  })();
</script>