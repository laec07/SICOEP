
<?php
include ("../conexion.php");
$id=$_POST['id'];

$cris=mysqli_query($conexion,"
SELECT
  p.id_criterio
FROM
  pm_pruebapiloto_detalle pd
INNER JOIN pm_pregunta p ON p.id_pregunta = pd.id_pregunta
WHERE
  id_prueba = '$id'
GROUP BY
  p.id_criterio
	");

$aspirante=mysqli_query($conexion,"
SELECT
  pp.Id_usuario,
  U.Usuario,
  U.foto_piloto
FROM
  pm_pruebapiloto pp
INNER JOIN usuarios u ON pp.Id_usuario=U.Id_usuario
WHERE
  pp.id_prueba = '$id'
  ");

$asp=mysqli_fetch_array($aspirante);
$name=$asp['Usuario'];
$foto=$asp['foto_piloto'];

if (empty($foto)) {
        $foto='files/vacio2.jpg';
      };
?>
  <div class="box">
    
  
    <div class="row">
            <div class="col-md-3 " >
              <img  style="width: 200px;" src="../../consultas/<?php echo $foto ?>"  class='img'  />
            </div>
            <div class="col-md-3 ">
              <h3><?php echo $name ?></h3>
            </div>

    </div>
  </div> 
<?php
while ($fila_0=mysqli_fetch_array($cris)) {


$id_cirterio=$fila_0['id_criterio'];


$query=mysqli_query($conexion,"
SELECT
	ppd.id_prueba,
	ppd.id_pregunta,
	p.id_criterio,
	p.titulo,
	p.descripcion,
	p.id_tipopregunta,
  ppd.total
FROM
	pm_pruebapiloto_detalle ppd
JOIN pm_pregunta p ON p.id_pregunta = ppd.id_pregunta
WHERE ppd.id_prueba='$id'
AND p.id_criterio='$id_cirterio'
	");

?>
 
         <div class="box">
          <div class="box-header">
          	<div class="alert alert-danger text-center">
          		<h3 class="box-title "><?php echo $fila_0['descripcion']."  - ".round($fila_0['calificacion']) ."%"  ;  ?> </h3>
			</div>
            
            
          </div>
          <div class="box-body">
            <div style="overflow:scroll;height:100%;width:100%;">
            <table  id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th >Titulo</th>
                    <th >Descripción</th>
                    <th >Calificación</th>

                       

                  </tr>
                </thead>
                <tbody>
                	<?php
                	while ($fila=mysqli_fetch_array($query)) {

         			$tipo_preg=$fila['id_tipopregunta'];

         			if ($tipo_preg=='2') {

                  if ($fila['total']==1) {
                    $selected1='selected="selected"';
                  }else{
                    $selected1='';
                  }
         					$tp="
         					<select 

         						id='calificaP0' 
                          		
                          		data-id_prueba0='".$fila['id_prueba']."' 
                          		data-id_pregunta0='".$fila['id_pregunta']."'


         					class='form-control'>



         						<option value='0'>NO</option>
							  	<option $selected1 value='1'>SI</option> 
							</select>
         					";
         				}else if ($tipo_preg=='1') {

                  if ($fila['total']==1) {
                    $selected2='selected="selected"';
                    $selected3='';
                    $selected4='';
                    $selected0='';
                  }else if ($fila['total']==2) {
                    $selected3='selected="selected"';
                    $selected2='';
                    $selected4='';
                    $selected0='';
                  }else if ($fila['total']==3) {
                    $selected4='selected="selected"';
                    $selected2='';
                    $selected3='';
                    $selected0='';
                  }else{
                    $selected4='';
                    $selected2='';
                    $selected3='';
                    $selected0='selected="selected"';
                  }

         					$tp="
         					<select 

         						id='calificaP' 
                          		
                          		data-id_prueba='".$fila['id_prueba']."' 
                          		data-id_pregunta='".$fila['id_pregunta']."'

         						class='form-control'>
         				<option $selected0 value='0'>0</option>
							  <option $selected2 value='1'>1</option>
							  <option $selected3 value='2'>2</option>
							  <option $selected4 value='3'>3</option>
							</select>
							";         					
         				}
                		echo "
                		<tr>
                			<td>".$fila['titulo']."</td>
                			<td>".$fila['descripcion']."</td>
                			<td>".$tp."</td>
                			
                		</tr>
                		";
                	}
                	?> 
              	</tbody>
              	<tfoot>
              	</tfoot>
            </table>
          </div>
        </div>
        </div>  

<?php	
}

?>

<div >
	<a class="btn btn-primary btn-block" onclick="save_prev(<?php echo $id ?>);" >Guardar</a>
  <a class="btn btn-danger btn-block" onclick="body_test()">Cancelar</a>
</div>

<?php 
mysqli_close($conexion);
?>
