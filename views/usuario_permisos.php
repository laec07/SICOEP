<?php
include ("../conexion.php"); 
$usuario=$_POST['usuario'];

$cn=mysqli_query($conexion,"
SELECT
	c.id_canal,
	c.canal,
	c.estado,
	c.orden,
	cu.USUARIO
FROM
	canal c
LEFT JOIN (
	SELECT
		*
	FROM
		canal_usuario
	WHERE
		USUARIO = '$usuario'
) cu ON c.id_canal = cu.id_canal
WHERE
	c.estado = 'A'
GROUP BY
	c.id_canal
	");

?>
 <table class="table table-hover">
 	<thead>
 		<tr>
 			<th>Canal</th>
 			<th>Estado</th>
 		</tr>
 	</thead>
 	<tbody>
 	<?php
 	$i=0;
 	while ($fila=mysqli_fetch_array($cn)) {
 		if ( empty($fila['USUARIO'])) {
 			$check='';
 		}else {
 			$check='checked';
 			
 		}
 		echo "
		<tr>
 			<td>".$fila['canal']."</td>
 			<td><input type='checkbox' id='check_".$i."' value='' $check onclick=\"checkbox(".$i.",'".$usuario."',".$fila['id_canal'].");\" ></td>
 		</tr>
 		";
 		$i++;
 	}

 	?>
 		
 	</tbody>
 </table>

