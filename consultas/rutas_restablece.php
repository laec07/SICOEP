<?php
include("../conexion.php");
session_start();
///////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
////////////////////////////////////////////
$id_depto=$_GET['id_depto'];

//busca ultima fecha de solicitud aprobada
$ul_f=mysqli_query($conexion,"
SELECT
	MONTH(fecha) as month,
	YEAR(fecha) as year
FROM
	combustible_solicitud
WHERE
	id_depto = '$id_depto'

AND estatus='APROBADO'
AND fecha = (
	SELECT
		MAX(fecha)
	FROM
		combustible_solicitud
	WHERE
		id_depto = '$id_depto'
)
GROUP BY
	id_depto
	");
$ul_fe=mysqli_fetch_array($ul_f);
$month=$ul_fe['month'];
$year=$ul_fe['year'];
///////////inserta registro en tabla para cierre de ruta
$inserta=mysqli_query($conexion,"
REPLACE INTO rutas_cierre
SELECT
  r.id_ruta,
  r.ruta,
  r.id_equipo,
  r.piloto,
  r.canal,
  r.id_depto,
  d.Depto,
  r.tipo_vehi,
  r.estado,
  r.asignado_gal,
  r.restantes_gal,
  c.consumido,
  rs.canal as canal_r,
	c.mes,
	c.anio,
	c.fecha_max
FROM
  ruta r
INNER JOIN depto d ON r.id_depto = d.Id_depto
INNER JOIN canal l ON l.canal = r.canal
LEFT JOIN rutas rs ON rs.ruta=r.ruta and r.id_depto=rs.Id_depto
INNER JOIN (
  SELECT
    cd.id_ruta,
    SUM(galones) AS consumido,
		max(cd.fecha) as fecha_max,
		MONTH (cs.fecha) as mes,
		YEAR (cs.fecha) as anio
  FROM
    combustible_detalle cd,
    combustible_solicitud cs
  WHERE
    cs.id_solicitud = cd.id_solicitud
  AND cs.estatus = 'APROBADO'
  AND MONTH (cs.fecha) = '$month'
  AND YEAR (cs.fecha) = '$year'
  GROUP BY
    cd.id_ruta
) AS c ON c.id_ruta = r.id_ruta
WHERE
  r.codigo_pais = '$pais'
AND r.estado IN ('ACTIVO')
AND r.id_depto = '$c_depto'
ORDER BY
  r.estado,
  d.Depto,
  l.orden,
  r.ruta
	");
/////Restablece rutas depto seleccionado.

if ($inserta) {
	mysqli_query($conexion,"UPDATE ruta SET restantes_gal=asignado_gal where id_depto='$id_depto' ");

	echo "
        <script>
        		
            history.go(-1);
        </script>
";
}else{
echo "
        <script>
        	alert('Ocurrio un error al insertar cierre de ruta, contacte al administrador de sistemas.');	
            history.go(-1);
        </script>
";
}

mysqli_close($conexion);
?>