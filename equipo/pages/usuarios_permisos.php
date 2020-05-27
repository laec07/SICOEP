<?php
include ("../../conexion.php");  
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../"
</script>';
} 
$pais=$_SESSION['usuario']['codigo_pais'];
$li_usuarios=mysqli_query($conexion, "SELECT * FROM usuario where estado='ACTIVO' and codigo_pais='$pais' and TIPO IN ('Admin_equipo','Ticket_user') ");
?>
     <!---Estilo para checkbox-->
  <link rel="stylesheet" type="text/css" href="../dist/css/checkbox.css">
      <div class="box box-primary">
        <div class="box-header">
          
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <label>Usuario</label>
              <select class="form-control" id="lista_usuario" onchange="bpermisos_usuario();">
                <option>Seleccione usuario</option>
            <?php
              while ($f_usuarios=mysqli_fetch_array($li_usuarios)) {
                echo "
                  <option value='".$f_usuarios['USUARIO']."' >".$f_usuarios['USUARIO']." </option>

                ";
              }
            ?>
              </select>
            </div>

          </div>
        </div>
      </div>
      <div class="box">
        <div class="box-header">
          <h4>Permisos usuario Administradores</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div id="permisosApp"></div>
            </div>
          </div>
          
        </div>
      </div>
<script src="controllers/usuarios.js"></script>
