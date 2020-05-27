<?php
include("../../conexion.php");
$p=mysqli_query($conexion,"SELECT * FROM pais");
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

<div class="help-block">
  Sección para cambio de país del usuario, para que los cambios surtan efecto, deberán cerrar sesión y volver a iniciarla.<br>
  Utilice esta opción solo si es administrador del sistema, ya que los cambios pueden afectar funciones ligadas a código país de cada usuario.
</div>
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

</div>
</div>









<div id="general_usuarios">
	
</div>

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
                          <select id="cod_pais_e" class="form-control">
                        <?php
                          while ($row=mysqli_fetch_array($p)) {
                            echo "
                            <option value='".$row['codigo_pais']."' >".$row['pais']."</option>
                            ";
                          }
                        ?>
                          </select>                          
                        </div>


                        <div class="form-group">
                          <label >TIPO:</label>
                          <SELECT  name="tipo_e" id="tipo_e"  class="form-control" onchange="tipo_fe();" >
                            <option value="Admin_equipo">ADMINISTRADOR</option>
                            <option value="Ticket_user">TICKET</option>
                          </SELECT>
                        </div>


                       

                                  <a class="btn btn-primary pull-right" id="boton_e" data-dismiss="modal" onclick="usuario_editaPais()" >Actualizar</a>
                </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************/. Form Editar usuario******************** -->


<script src="controllers/usuarios.js"></script>

<script>
lista_usuariosPaises();



 /////////////////////////////editar//////////////////////





$('#EditarUsuario').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato0 = button.data('usuario_e')
      var dato1 = button.data('nombre_e')
      var dato4 = button.data('tipo_e')
      var dato9 = button.data('pais_e')


      var modal = $(this)
      modal.find('.modal-body #usuario_e').val(dato0)
      modal.find('.modal-body #nombre_e').val(dato1)
      modal.find('.modal-body #tipo_e').val(dato4)


      modal.find('.modal-body #cod_pais_e').val(dato9)
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