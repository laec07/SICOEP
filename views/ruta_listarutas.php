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
$rts=mysqli_query($conexion,"
SELECT 
  r.id,
  r.ruta,
  r.Id_depto,
  d.Depto,
  r.estado,
  r.codigo_pais,
  r.canal
FROM 
  rutas r
 JOIN depto d on r.Id_depto=d.Id_depto

WHERE 
  r.estado='ACTIVO' 
and r.codigo_pais='$pais'  
ORDER BY 
  r.ruta,r.id_depto
  ");

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table id='tabal_rutas' class='table table-bordered table-striped table-hover table table-condensed' >
                <thead>
                  <tr>
                    <th>Ruta</th>
                    <th>Depto.</th>

              
                    <th><span class="glyphicon glyphicon-wrench"></th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  while ($fila_r=mysqli_fetch_array($rts)) {
                    echo "
                    <tr>
                      <td>".$fila_r['ruta']."</td>
                      <td>".$fila_r['Depto']."</td>
                      
                      <td>
                        <a class='btn btn-warning'  title='Editar' data-target='#EditaRutaN' data-toggle='modal'
                          data-id_ruta='".$fila_r['id']."'
                          data-ruta='".$fila_r['ruta']."'
                          data-depto='".$fila_r['Id_depto']."'
                          data-canal1='".$fila_r['canal']."'
                         

                          >
                          <span class='glyphicon glyphicon-pencil '>
                          </span>
                        </a>
                      </td>
                    </tr>

                    ";
                  }
                ?>
                </tbody>
              </table>
 <!-- *************Form Edita ruta******************** -->
    <div class="modal" id="EditaRutaN" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Editar Ruta</h4>                       
                    </div>
                    <div class="modal-body">
                       <FORM action="" method="" >    
                        <div class="form-group">
                          <input type="text" name="id_ruta_e" id="id_ruta_e" style="display: none;" >
                          <label >Ruta:</label>
                          <input type="text" name="ruta_e" id="ruta_e" placeholder="Descripción de ruta" class="form-control" maxlength="100">
                        </div>
                    <!-- -------------------------------------------------------------------------------------------- -->
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="depto">Seleccione Sede:</label>
                              <SELECT  name="depto_e" id="depto_e" class="form-control" >
                              <?php 
                                while($fila=mysqli_fetch_row($depto_f)){
                                    echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                                }
                                  ?>
                              </SELECT>
                          </div>
                          </div>
                          <div class="col-md-6">
                              <label>Canal:</label>
                              <select class="form-control" id="tipo_canal_e" name="tipo_canal_e">
                                <option>OTROS</option>
                                <option>MASIVO</option>
                              </select>
                          </div>

                        </div>                          
                            <hr>
                      <!-- -------------------------------------------------------------------------------------------- -->
                      
                    <!-- -------------------------------------------------------------------------------------------- -->
                          
                               <input type='reset' value='Guardar' onclick='rutas_rutaedita();'  data-dismiss='modal' class='btn btn-success'>

                      </FORM>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 
  <!-- *************Form ingreso nueva ruta******************** -->
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function(){
   $('#tabal_rutas').DataTable() 
  })
  //////////////////////////////////////////////////////////
$('#EditaRutaN').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato1 = button.data('id_ruta')
      var dato2 = button.data('depto')
      var dato3 = button.data('canal1')
     
      var dato13 = button.data('ruta')
     

      var modal = $(this)
      modal.find('.modal-body #id_ruta_e').val(dato1)
       modal.find('.modal-body #depto_e').val(dato2)
       modal.find('.modal-body #tipo_canal_e').val(dato3)
      
       modal.find('.modal-body #ruta_e').val(dato13)

       var a = document.getElementById('tipo_canal_e').value
 
       
    })


</script>

</body>
</html>
