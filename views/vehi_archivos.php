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
$placa=$_POST['placa'];

$query=mysqli_query($conexion,"
SELECT * FROM vehi_archivo where Id_equipo='$placa'
  ");

?>  


 <!-- vista principal -->
        <div class=" box box-danger">
          <!-- Head -->
          <div class="box-head">
            <h4>Documentos cargados</h4>
          <!-- ./ Head -->
          </div>
          <!--  Body -->
          <div class="box-body">
            <div class="table-responsive">
             <table class="table table-hover table-condensed table-dark">
               <thead>
                 <tr>
                   <th>Archivo</th>
                   <th>Observaciones</th>
                   <th></th>
                 </tr>
               </thead>
               <tbody>
                <?php
                while ($fila=mysqli_fetch_array($query)) {
                  echo "
                   <tr>
                     <td>".$fila['name_file']."</td>
                     <td>".$fila['observaciones']."</td>
                     <td>
                      <a  href='../../consultas/".$fila['file']."' target='_blank' class='btn btn-primary'>
                       <span class='fa fa-download'></span>
                      </a>
                      <a class='btn btn-danger' onclick=borra('".$fila['id']."')>
                       <span class='fa fa-trash'></span>
                      </a>
                     </td>
                   </tr>
                  ";
                }

                ?>

<a href=""></a>
               </tbody>
             </table>               
            </div>

            <!--  ./ Body -->
          </div>
        <!-- ./ vista principal -->
        </div>