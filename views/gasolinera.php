<?php
 include ("../conexion.php");  
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}
////////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
////////////////////////////////////////////
$listado=mysqli_query($conexion,"
SELECT
	g.id_gasolinera,
	g.codigo_pais,
	g.Id_depto,
	d.Depto,
	g.descripcion,
	g.ubicacion,
	g.empresa,
	g.estatus
FROM
	gasolinera g
JOIN depto d ON d.Id_depto = g.Id_depto
WHERE
	g.codigo_pais = '$pais'
AND g.estatus='A'
	");
////////////////////////////////////////////
////////////////////////////////////////////
////////////////////////////////////////////
////////////////////////////////////////////
////////////////////////////////////////////
////////////////////////////////////////////
////////////////////////////////////////////
?>

         <div class="box">
          <div class="box-header">
            <h3 class="box-title">Gasolineras</h3>
            
          </div>
          <div class="box-body">
            <div style="overflow:scroll;height:100%;width:100%;">
            <table  id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th >ID</th>
                    <th >Depto</th>
                    <th >Descripción</th>
                    <th >Ubicación</th>
                    <th >Empresa</th>
                       
                    <th ><span class="glyphicon glyphicon-wrench"></span></th>
                  </tr>
                </thead>
                <tbody>
                	<?php
                	while ($fila=mysqli_fetch_array($listado)) {

         
                		echo "
                		<tr>
                			<td>".$fila['id_gasolinera']."</td>
                			<td>".$fila['Depto']."</td>
                			<td>".$fila['descripcion']."</td>
                			<td>".$fila['ubicacion']."</td>
                			<td>".$fila['empresa']."</td>

                			<td>
                				<a class='btn btn-warning' title='Editar' data-target='#EditaGas' data-toggle='modal'
                					data-id_gasolinera_e='".$fila['id_gasolinera']."'
                					data-id_depto_e='".$fila['Id_depto']."'
                					data-descripcion_e='".$fila['descripcion']."'
                					data-ubicacion_e='".$fila['ubicacion']."'
                					data-empresa_e='".$fila['empresa']."'

                				>
	                				<SPAN class='fa fa-edit'>
	                            	</SPAN>
                            	</a>
                				<a class='btn btn-danger' title='Editar' onclick='elimina_gasolinera(".$fila['id_gasolinera'].");' data-toggle='modal'>
	                				<SPAN class='fa fa-trash'>
	                            	</SPAN>
                            	</a>  
                			</td>
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