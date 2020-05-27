<?php
include ("../../conexion.php");
//Obtenemos usuario
$usuario=$_POST['usuario'];
//verificamos que se seleccione usuario
if ($usuario=='Seleccione usuario') {
	//si no selecciona no mostramos nada
	echo "";
}else{//si selecciona
	//Busca que usuario sea oper_Carros
	$b=mysqli_query($conexion,"
	SELECT
		*
	FROM
		usuario
	WHERE
		TIPO = 'Admin_equipo'
	AND USUARIO ='$usuario'
	AND estado = 'ACTIVO'
		");
	//evalua si es operativo
	if (mysqli_num_rows($b)==0) {
		//mensaje si no es operativo, no puede agregar permisos generales a operativo o viceversa 
	echo"Usuario no es Administrador";

	}else{
		
			//Si es oper carros, buscamos que permisos tiene habilitado
		$b_usuario=mysqli_query($conexion,"
		SELECT
			p.id_permiso,
			p.descripcion,
			pu.usuario
		FROM
			permiso p
		LEFT JOIN permiso_usuario pu ON pu.id_permiso = p.id_permiso 
		AND pu.usuario='$usuario'
		WHERE
			p.tipo = 'equipo'
		AND p.estatus = 'A'
			");
	?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Permiso</th>
				</tr>
			</thead>
			<tbody>
		<?php
		//contador sirve para ver en que estado esta el check
		$i=0;
		while ($row=mysqli_fetch_array($b_usuario)) {
				//si no encuentra usuario en el permiso, mostrará check deshabilitado
			 	if ( empty($row['usuario'])) {
		 			$check='';
		 		}else {
		 			$check='checked';
		 			
		 		}

			echo "
				<tr>
					<td>".$row['descripcion']."</td>
					<td><input type='checkbox' id='checkapp_".$i."' value='' $check onclick=\"permisos_addless(".$i.",'".$usuario."',".$row['id_permiso'].");\" ></td>
				</tr>
			";
			$i++;
		}
			
		?>
			</tbody>	
		</table>
	<?php
	}	
}



?>