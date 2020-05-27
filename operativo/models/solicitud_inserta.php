<?php
include("../../conexion.php");
session_start();
///////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];
////////////////////////////////////////////
$depto=$_POST['depto'];
$fecha=$_POST['fecha'];
$super=$_POST['super'];
$regular=$_POST['regular'];
$diesel=$_POST['diesel'];
$gas=$_POST['gas'];
$cn="'". implode("','", $_POST['canal_n'])."'";

/////////////////////////////////////////////
if ($cn=="'TODOS'") {
  $canal="";
}else{
  
  $canal="AND r.canal in  ($cn)";
}
/////////////////////////////////////////////
$año=date_format(New datetime($fecha),'Y');
$mes=date_format(New datetime($fecha),'m');
////////////////////////////////////////////
$dt=mysqli_query($conexion,"SELECT Depto FROM depto WHERE id_depto='$depto'");
$depto_r=mysqli_fetch_array($dt);
/////////////////////////////////////////
$nextm=mysqli_query($conexion,"SELECT count(*) as cuenta from combustible_solicitud where id_depto='$depto' and MONTH(fecha)='$mes' and YEAR(fecha)='$año'");
$nt=mysqli_fetch_array($nextm);
$cuenta=$nt['cuenta'];
//////////////////////////////////////////////
$resta=mysqli_query($conexion,"SELECT SUM(restantes_gal)*100 / SUM(asignado_gal) as porcentaje FROM ruta WHERE id_depto = '$depto' AND estado='ACTIVO'");
$st=mysqli_fetch_array($resta);
$porcentaje=$st['porcentaje'];


/////////////////////////////////////////////////////////////////////
if (($cuenta==0) && ($porcentaje<100) ) {
	echo 'NO';
	
}else{
	//inserta solicitud
	if (mysqli_query($conexion,"INSERT combustible_solicitud (fecha,id_depto,usuario_solicita,codigo_pais) VALUES('$fecha','$depto','$usuario','$pais')" )) {
		//si fue insertado correctamente, busca el ID con el cual fue insertado
		$d=mysqli_query($conexion,"SELECT id_solicitud from combustible_solicitud order by id_solicitud desc limit 1");
		$rd=mysqli_fetch_array($d);
		$ID= $rd['id_solicitud'];

		//inserta el precio combustible
		$precio=mysqli_query($conexion,"INSERT precio_combustible (fecha,super,regular,diesel,gas,id_depto,codigo_pais,usuario,id_solicitud) VALUES ('$fecha','$super','$regular','$diesel','$gas','$depto','$pais','$usuario','$ID')");
		if ($precio) {
			//inserta detalle los cuales se mostraran en la página solicitud
			$detalle=mysqli_query($conexion,
											"
											INSERT INTO combustible_detalle SELECT
												'$ID',
												r.id_depto,
												r.id_ruta,
												'$fecha',
												r.Id_equipo,
												'0',
												'2',
												'',
												p.id_precio,
												'$regular',
												'0',
												'0',
												'0',
												'0',
												'$usuario',
												'$pais',
						                      r.asignado_gal,
						                      r.restantes_gal,
						                      r.canal,
						                      r.ruta,
						                      '',
						                      '',
						                      ''
											FROM
												ruta r,
												precio_combustible p
											WHERE
												p.id_solicitud = '$ID'
											AND r.id_depto = p.id_depto
											AND r.id_depto = '$depto'
											AND r.estado='ACTIVO'
											$canal
											");
			//si inserta correctamente
				if ($detalle) {
						 echo $ID;
						
				}else{
					//Error si falla la insercción de detalle
					print"
			        <script LANGUAGE='javascript'>
			        alert('Ocurrio un problema mientras se procesaba detalle solicitud, intentelo nuevamente más tarde, si persiste el problema, comuniquese con el administrador del sistema.');
			        history.go(-1);
			        </script>
			    ";
				}
			  
		}else{
			//Error si falla la insercción de precio
			print"
	        <script LANGUAGE='javascript'>
	        alert('Ocurrio un problema mientras se procesaba precio combustible, intentelo nuevamente más tarde, si persiste el problema, comuniquese con el administrador del sistema.');
	        history.go(-1);
	        </script>
	    ";
		}	
		 //si no se logra insertad solicitud, no procesa nada 
	}else{
		print"
	        <script LANGUAGE='javascript'>
	        alert('Ocurrio un problema mientras se procesaba la solicitud, intentelo nuevamente más tarde, si persiste el problema, comuniquese con el administrador del sistema.');
	        history.go(-1);
	        </script>
	    ";  
	}
}/*


*/
?>
