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
            <div class="row">
              <div class="col-md-6">
                <h4>Configuración preguntas</h4>    
              </div>
              <div class="col-md-5">
                <a class="btn btn-info pull-right"><span class="fa fa-plus" data-target='#Addquest' data-toggle='modal'> Agregar</span></a>
              </div>
              <div class="col-md-1">
                
              </div> 
            </div>
            
          <!-- ./ Head -->
          
          </div>
          <!--  Body -->
          <div class="box-body">


              <?php
              while ($fila = mysqli_fetch_array ($query)) {//Saca datos de las sedes y los muestra

                  if ($fila['estatus']=='A') {
                    $status='<label class="label label-success">Activo</label>';
                  }else{
                    $status='<label class="label label-danger">Inactivo</label>';
                  }

                echo "
              <div class='box box-primary '>
                <div class='box-header with-border'><!--empieza encabezado-->
                  <h3 class='box-title'>".$fila['descripcion']." -  ".$fila['calificacion']."% - ".$status."</h3> 
                  <div class='box-tools pull-right'>
                    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-plus'></i>
                    </button>
                  </div>
                </div><!--Termina encabezado--->
                <div class='box-body'>
                <div style='overflow: scroll; width: 100%'>
                <table class ='table table-hover'>
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Titulo</th>
                      <th>Descripción</th>
                      <th>Tipo</th>
                      <th>Estado</th>
                      <th></th>
                    <tr>
                  </thead>
                ";
                //query que extrae los datos de las asignaciones activas
                $query2=mysqli_query($conexion, "
                  SELECT
                      p.id_pregunta,
                      p.id_tipopregunta,
                      tp.descripcion AS descripcion_tipo,
                      p.id_criterio,
                      p.titulo,
                      p.descripcion,
                      p.estatus,
                      p.codigo_pais
                    FROM
                      pm_pregunta p
                    INNER JOIN pm_tipopregunta tp ON p.id_tipopregunta = tp.id_tipopregunta
                    WHERE p.id_criterio=".$fila['id_criterio']."
                    AND p.estatus in ('A','I')

                  ");
                    while($fila = mysqli_fetch_array ($query2)){ //subquery, saca datos segun la sede obtenida 
                      if ($fila['estatus']=='A') {
                        $estado='<label  class="label label-success">Activo</label >';
                      }else{
                        $estado='<label  class="label label-danger">Inactivo</label >';
                      }
                    echo"
                        <tr >
                        <td >".$fila['id_pregunta']."</td>
                        <td >".$fila['titulo']."</td>
                        <td >".$fila['descripcion']."</td>
                        <td >".$fila['descripcion_tipo']."</td>
                        <td >".$estado."</td>
                        
                        <td> 
                          <a  
                            class='btn btn-warning'
                            data-toggle='modal' data-target='#Editquest'
                            data-id_quest='".$fila['id_pregunta']."'
                            data-edit_criterio='".$fila['id_criterio']."'
                            data-edit_tipo_pregunta='".$fila['id_tipopregunta']."'
                            data-edit_titulo='".$fila['titulo']."'
                            data-edit_descripcion='".$fila['descripcion']."'
                            data-edit_estatus='".$fila['estatus']."'


                            >
                            <span class='fa fa-edit'></span>
                          </a>
                          <a onclick='delete_quest(".$fila['id_pregunta'].")'
                            class='btn btn-danger' 
                        >
                              <span class='fa fa-trash' ></span>
                          </a>
                         
                        </td>
                        </tr>
                        ";
                      }
                echo"
               </table>
               </div>
              </div>
              </br>
               ";
              }
              ?>
            <!--  ./ Body -->
          </div>
        <!-- ./ vista principal -->
        </div>