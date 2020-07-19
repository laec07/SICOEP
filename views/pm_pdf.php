<?php
require_once("../plugins/dompdf/autoload.inc.php"); 
include'../conexion.php';
session_start();
/////////////////
$id=$_GET['id'];
//$id=6;
/////////////////
$p=$_SESSION['usuario']['codigo_pais'];
////////////////Trae datos de prueba y piloto
$query=mysqli_query($conexion,"
SELECT * FROM pm_pruebapiloto WHERE id_prueba='$id'
");
$f=mysqli_fetch_array($query);
$cr1=$f['criterio1'];
$cr2=$f['criterio2'];
$cr3=$f['criterio3'];
$total=$f['total'];
$fecha_aprueba=$f['fecha_aprueba'];
$aspirante=$f['Id_usuario'];
//////////////////Trae datos piloto
$consulta= mysqli_query($conexion,"SELECT * FROM usuarios where Id_usuario='$aspirante' ");
$rconsulta= mysqli_fetch_array($consulta);
$foto=$rconsulta['foto_piloto'];
$nombre=$rconsulta['Usuario'];
//////////////////////////////////
$crit=mysqli_query($conexion,"
SELECT
	id_criterio,
	descripcion,
	calificacion,
	estatus
FROM
	pm_criterio

");



if (empty($foto)) {
        $foto='../consultas/files/vacio2.jpg';
      };
 $codigohtml='


<!DOCTYPE html>
<html>
<head>
	<title>prueba de manejo PDF</title>
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="shortcut icon" href="../dist/img/logo.ico" />	
</head>
<body>


<div class="box box-danger" >
	<div class="box-header">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h3>PRUEBA DE MANEJO NO. '.$id.' </h3>
			</div>
			<div class="col-md-5 col-sm-5 col-xs-5  ">
				<h4 class="pull-right" > '. date_format(new datetime($fecha_aprueba),"d/m/Y") .'</h4>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-1  ">

			</div>
		</div>
		

   

	</div>
	<div class="box-body">
		<div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4" >
              <img  style="width: 100px;" src="../consultas/'.$foto.'"  class="img"  />
            </div>
			<div class="col-md-4 col-sm-4 col-xs-4" >


                      <h3><?php echo $nombre; ?></h3>
                     <table style="width: 100%">
                     	<tr>
                     		<th>No. Licencia:</th>
                     		<td>'.$rconsulta['Licencia'].' </td>
                     	</tr>
                     	<tr>
                     		<th>Tipo licencia:</th>
                     		<td>'.$rconsulta['tipo'].'</td>
                     	</tr>
                     	<tr>
                     		<th>Experiencia:</th>
                     		<td>'.$rconsulta['experiencia'].' Años</td>
                     	</tr>
                     </table>

			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" >
				<div class="well well-lg">
					<h1>'. $total.'</h1>
				</div>
			</div>
		</div>
	
			
		


		<div>
			<h4>Resumen criterios:</h4>
			<div class="col-md-6 col-sm-6 col-xs-6" >
				
				<table style="width: 100%" >

					'; 
while ($fc=mysqli_fetch_array($crit)) {

	if ($fc['id_criterio']==1 && $fc['estatus']=='A' ) {
		$fc1=$fc['descripcion'];

		$codigohtml.='
		<tr>
			<th>'.$fc1.' </th>
			<td>'.$cr1.' </td>
		</tr>
		';

	}

	if ($fc['id_criterio']==2 && $fc['estatus']=='A') {
		$fc2=$fc['descripcion'];
		$codigohtml.='
		<tr>
			<th>'.$fc2.' </th>
			<td>'.$cr2.' </td>
		</tr>
		';
	}
	if ($fc['id_criterio']==3 && $fc['estatus']=='A') {
		$fc3=$fc['descripcion'];

		$codigohtml.='
		<tr>
			<th>'.$fc3.' </th>
			<td>'.$cr3.' </td>
		</tr>
		';
	}
}

					$codigohtml.='



				</table>
			</div>			
		</div>
	</div>

</div>

<h4>Detalle:</h4>
';
$cris=mysqli_query($conexion,"
SELECT
	p.id_criterio,
	c.descripcion,
	c.calificacion
FROM
	pm_pruebapiloto_detalle pd
INNER JOIN pm_pregunta p ON p.id_pregunta = pd.id_pregunta
INNER JOIN pm_criterio c ON c.id_criterio=p.id_criterio
WHERE
	id_prueba = '$id'
GROUP BY
	p.id_criterio
	");

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

$codigohtml.='
 
         <div class="box">

          <div class="box-body">

            <table  class="table">
                <thead>
                <tr>
                	<th colspan="3" style="background-color:#FF0321; text-align: center ">'.$fila_0['descripcion']."  - ".round($fila_0['calificacion']) ."%" .' </th>
                </tr>	
                  <tr>
                    <th >Titulo</th>
                    <th >Descripción</th>
                    <th >Calificación</th>

                       

                  </tr>
                </thead>
                <tbody>
                ';
               
                	while ($fila=mysqli_fetch_array($query)) {

         			$tipo_preg=$fila['id_tipopregunta'];

         			if ($tipo_preg=='2') {

                  if ($fila['total']==1) {
                    $selected1='SI';

                  }else{

                    $selected1='NO';

                  }
         					$tp="
								<td>".$selected1."</td>
         					";
         				}else if ($tipo_preg=='1') {



         					$tp="
								<td>".round($fila['total'])."</td>
							";         					
         				}
                		$codigohtml.='
                		<tr>
                			<td>'.$fila['titulo'].'</td>
                			<td>'.$fila['descripcion'].'</td>
                			<td>'.$tp.'</td>
                			
                		</tr>
                		';
                	}
                	$codigohtml.='
              	</tbody>
              	<tfoot>
              	</tfoot>
            </table>

        </div>
        </div>  

';	
}

$codigohtml.='
<p>PRUEBA SE ENCUENTRA REVISADA Y VALIDADA POR JOSUE ARMANDO ALVAREZ DAVILA, ENCARGADO DE TRANSPORTE </p><br>
<p align="center"><img src="../dist/img/firma.jpg" height="50px"><br>
ARMANDO ALVAREZ</p>
</body>
</html>
';
mysqli_close($conexion);
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf -> load_html(($codigohtml));
ini_set("memory_limit","128M");
$dompdf -> render();
$dompdf -> stream('Prueba_manejo.pdf', array("Attachment" => 0));

Mysqli_free_result($hpais);
Mysqli_free_result($depto);
Mysqli_free_result($canal);
Mysqli_free_result($usuarios);
Mysqli_free_result($carro);
Mysqli_free_result($foto);

mysqli_close($conexion);
/*
*/