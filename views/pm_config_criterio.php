<?php
include("../conexion.php");
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}

$pais=$_SESSION['usuario']['codigo_pais'];
$query=mysqli_query($conexion,"
SELECT * FROM pm_criterio where codigo_pais='$pais'
  ");

?>  


 <!-- vista principal -->
        <div class=" box box-danger">
          <!-- Head -->
          <div class="box-head">
            <h4>Categorías</h4>
          <!-- ./ Head -->
          </div>
          <!--  Body -->
          <div class="box-body">
            <div class="table-responsive">
             <table class="table table-hover table-condensed table-dark">
               <thead>
                 <tr>
                   <th>ID</th>
                   <th>Descripción</th>
                   <th>Calificación %</th>
                   <th>Estatus</th>
                   <th></th>
                 </tr>
               </thead>
               <tbody>
                <?php
                $a=0;
                while ($fila=mysqli_fetch_array($query)) {
                  if ($fila['estatus']=='A') {
                    $status='<label class="label label-success">Activo</label>';
                  }else{
                    $status='<label class="label label-danger">Inactivo</label>';
                  }

                  echo "
                   <tr>
                     <td>".$fila['id_criterio']."</td>
                     <td>".$fila['descripcion']."</td>
                     <td>".round($fila['calificacion']) ." %</td>
                     <td>".$status."</td>
                     <td>
                      <a   class='btn btn-warning' data-toggle='modal' data-target='#edita_criterio'
                        data-id_criterio='".$fila['id_criterio']."'
                        data-descripcion='".$fila['descripcion']."'
                        data-calificacion='".$fila['calificacion']."'
                        data-estado='".$fila['estatus']."'
                      >
                       <span class='fa fa-edit'></span>
                      </a>

                     </td>
                   </tr>
                  ";
                  if ($fila['estatus']=='A') {
                    $a=$a+$fila['calificacion'];
                  }
                  
                }
                  if ($a==100.00) {
                    $alerta='<div class="alert alert-success"><strong>Alerta!</strong> Configuración correcta.</div>';
                  }else{
                    $alerta='<div class="alert alert-danger"><strong>Alerta!</strong> Configuración incorrecta, criterios deben sumar 100%.</div>';
                  }
                ?>
                  <tr>
                    <th colspan="2" >Total</th>
                    <th><?php echo $a;  ?>%</th>
                    <th><?php echo $alerta;  ?></th>
                  </tr>

               </tbody>
             </table>               
            </div>

            <!--  ./ Body -->
          </div>
        <!-- ./ vista principal -->
        </div>