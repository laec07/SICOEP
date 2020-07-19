
<?php
include("../conexion.php");

$id_prueba=$_POST['id_prueba'];

$crit=mysqli_query($conexion,"
SELECT
	id_criterio,
	descripcion,
	calificacion,
	estatus
FROM
	pm_criterio

");

//selecciona criterio 1
$crit1=mysqli_query($conexion,"
SELECT
	*
FROM
	pm_pregunta
WHERE
	estatus = 'A'
AND id_criterio = '1'

");
//Declara variables para obtener total valor pregunta
$c1_1=0;
$c1_2=0;
//Ciclo que permite sumar total pregunta
while ($f1=mysqli_fetch_array($crit1)) {
	if ($f1['id_tipopregunta']==1) {
		$c1_1=$c1_1+3;
	} else if ($f1['id_tipopregunta']==2) {
		$c1_2=$c1_2+1;
	}

}

$t_c1=$c1_1+$c1_2;

//selecciona criterio 2
$crit2=mysqli_query($conexion,"
SELECT
	*
FROM
	pm_pregunta
WHERE
	estatus = 'A'
AND id_criterio = '2'
");
//Declara variables para obtener total valor pregunta
$c2_1=0;
$c2_2=0;
//Ciclo que permite sumar total pregunta
while ($f2=mysqli_fetch_array($crit2)) {
	if ($f2['id_tipopregunta']==1) {
		$c2_1=$c2_1+3;
	} else if ($f2['id_tipopregunta']==2) {
		$c2_2=$c2_2+1;
	}
}
$t_c2=$c2_1+$c2_2;
//selecciona criterio 1
$crit3=mysqli_query($conexion,"
SELECT
	*
FROM
	pm_pregunta
WHERE
	estatus = 'A'
AND id_criterio = '3'
");
//Declara variables para obtener total valor pregunta
$c3_1=0;
$c3_2=0;
//Ciclo que permite sumar total pregunta
while ($f2=mysqli_fetch_array($crit3)) {
	if ($f2['id_tipopregunta']==1) {
		$c3_1=$c3_1+3;
	} else if ($f2['id_tipopregunta']==2) {
		$c3_2=$c3_2+1;
	}
}
$t_c3=$c3_1+$c3_2;

$t_g=$t_c1+$t_c2+$t_c3;
$total1=0;
$total2=0;
$total3=0;
//Comparar los resultados totales vrs los obtenidos
while ($fila=mysqli_fetch_array($crit)) {
	//Validaciones para criterio 1 si esta activado
	if ($fila['id_criterio']==1 && $fila['estatus']=='A' ) {
		$qcr1=mysqli_query($conexion,"
			SELECT
				p.id_criterio,
				SUM(pd.total) as total
			FROM
				pm_pruebapiloto_detalle pd
			INNER JOIN pm_pregunta p ON p.id_pregunta = pd.id_pregunta
			WHERE
				pd.id_prueba = '$id_prueba'
			AND p.id_criterio=1
			");
		$qcr1v=mysqli_fetch_array($qcr1);
		$t_qcr1=$qcr1v['total'];
		//Regla de 3 para sacar porcentaje de total obtenido
		$total_c1=($t_qcr1*100)/$t_c1;
		//Regla de 3 para sacar total de criterio
		$total1=($total_c1*$fila['calificacion'])/100;
		
	}else{
		$total=0;
	}
	//Validaciones para criterio 1 si esta activado
	if (($fila['id_criterio']==2) and ($fila['estatus']=='A') ) {
		$qcr2=mysqli_query($conexion,"
			SELECT
				p.id_criterio,
				SUM(pd.total) as total
			FROM
				pm_pruebapiloto_detalle pd
			INNER JOIN pm_pregunta p ON p.id_pregunta = pd.id_pregunta
			WHERE
				pd.id_prueba = '$id_prueba'
			AND p.id_criterio=2
			");
		$qcr2v=mysqli_fetch_array($qcr2);
		$t_qcr2=$qcr2v['total'];
		//Regla de 3 para sacar porcentaje de total obtenido
		$total_c2=($t_qcr2*100)/$t_c2;
		//Regla de 3 para sacar total de criterio
		$total2=($total_c2*$fila['calificacion'])/100;
		

	}

	//Validaciones para criterio 1 si esta activado
	if ($fila['id_criterio']==3 && $fila['estatus']=='A' ) {
		$qcr3=mysqli_query($conexion,"
			SELECT
				p.id_criterio,
				SUM(pd.total) as total
			FROM
				pm_pruebapiloto_detalle pd
			INNER JOIN pm_pregunta p ON p.id_pregunta = pd.id_pregunta
			WHERE
				pd.id_prueba = '$id_prueba'
			AND p.id_criterio=3
			");
		$qcr3v=mysqli_fetch_array($qcr3);
		$t_qcr3=$qcr3v['total'];
		//Regla de 3 para sacar porcentaje de total obtenido
		$total_c3=($t_qcr3*100)/$t_c3;
		//Regla de 3 para sacar total de criterio
		$total3=($total_c3*$fila['calificacion'])/100;
		
	}else{
		$total3=0;
	}
//Finaliza While
}
$total_g=$total1+$total2+$total3;



$actualiza=mysqli_query($conexion,"UPDATE pm_pruebapiloto SET criterio1='$total1', criterio2='$total2', criterio3='$total3', total='$total_g' WHERE id_prueba='$id_prueba' ");



mysqli_close($conexion);
?>