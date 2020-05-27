<?php
include("../../conexion.php");
require_once("../../plugins/dompdf/autoload.inc.php");
session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
$depto=$_SESSION['usuario']['Id_depto'];
/***************************************************/
$ID=$_GET['ID'];
/****************************************************/
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/**************************************************************/
$gl=mysqli_query($conexion,"SELECT * FROM gasolinera WHERE codigo_pais='$pais' AND Id_depto='$depto' and estatus='A' ");
$gasolinera=mysqli_fetch_array($gl);
/**************************************************************/
$f=mysqli_query($conexion, "SELECT fecha FROM combustible_solicitud WHERE id_solicitud = '$ID'");
$f_solicitud=mysqli_fetch_array($f);
$fecha_solicitud=$f_solicitud['fecha'];
$fecha_solicitud=date_format(new datetime($fecha_solicitud),"d/m/Y");
/***************************************************************/
$ruta=mysqli_query($conexion,
  "
SELECT
  c.id_solicitud,
  c.id_depto,
  c.id_ruta,
  r.ruta,
  r.piloto,
  r.tipo_vehi,
  r.id_equipo,
  r.canal,
  c.tipo_combustible,
  tc.descripcion,
  c.galones,
  c.precio,
  c.total,
  c.asignado_gal,
  c.restantes_gal,
  l.orden
FROM
  combustible_detalle c,
  ruta r,
  canal l,
  tipo_combustible tc
WHERE c.id_ruta=r.id_ruta
AND tc.id_tipocombustible=c.id_tipocombustible  
AND c.id_solicitud=$ID
AND l.canal=c.canal
order by l.orden,c.ruta
  ");
date_default_timezone_set('America/Guatemala');
    
    $fecha_actual= " ".Date("d")." de ".Date("M")." del ".Date("Y");
$codigohtml='
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SICOEP</title>
 <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
 <link rel="shortcut icon" href="../../dist/img/logo.ico" />
</head>
<body>
<div>
	<!--<img src="../../dist/img/favicon.png" height="100px" ALIGN=RIGHT>-->
 <div align="center">Solicitud No.  '.$ID.'</div> </div>
<p align="right">'.$fecha_solicitud.'</p>
<p>CONDICIONES Y TERMINACIONES DEL SIGUIENTE LISTADO DE COMBUSTIBLE PARA ABASTECER <br>'.$gasolinera['descripcion'].'</p>
	

          <table class="table table-bordered">
                <thead>
                  <tr>               
                  <th><font size=1>Ruta</font></th>
                  <th><font size=1>Piloto</font></th>
                  <th><font size=1>Tipo vehi.</font></th>
                  <th><font size=1>Placa</font></th>
                  <th><font size=1>Canal</font></th>
                  <th><font size=1>tipo combustible</font></th>
                  
                  <th><font size=1>Galones</th>
                  <th><font size=1>Total</th>
                  
                  
                </tr>   
                </thead>
                <tbody>';
                $total=0;
                $galones=0;
                while ($fila=mysqli_fetch_array($ruta)) {
                    $codigohtml.='
                    
                    <tr>
                      <td><font size=1>'.$fila['ruta'].'</font></td>
                      <td><font size=1>'.$fila['piloto'].'</font></td>
                      <td><font size=1>'.$fila['tipo_vehi'].'</font></td>
                      <td><font size=1>'.$fila['id_equipo'].'</font></td>
                      <td><font size=1>'.$fila['canal'].'</font></td>
                      <td><font size=1>'.$fila['descripcion'].'</font></td>
                      
                      <td><font size=1>'.$fila['galones'].'</font></td>
                      <td><font size=1>'.$rps['moneda'].number_format($fila['total'],2,'.',',').'</font></td>                      
                    </tr>
                    ';
                    $total=$total+$fila['total'];
                    $galones=$galones+$fila['galones'];
                  }  
                $codigohtml.='
                </tbody>
                <tfoot>
                	<tr>
                		<th colspan="6" >Total</th>
                		<th>'.$galones.'</th>
                		<th>'.$rps['moneda'].number_format($total,2,'.',',').'</th>
                	</tr>
                </tfoot>
          </table>



<p>DEBO INDICAR QUE EL SIGUIENTE LISTADO DE COMBUSTIBLE SE ENCUENTRA REVISADO Y VALIDADO POR JOSUE ARMANDO ALVAREZ DAVILA, ENCARGADO DE TRANSPORTE ('.$gasolinera['empresa'].') EL CUAL PONGO A SU CONOCIMIENTO PARA PROCEDER CON EL ABASTECIMIENTO DE COMBUSTIBLE QUE SE REFLEJA EN LISTADO, ESTE PROCEDIMIENTO ES APLICABLE PARA ('.$gasolinera['ubicacion'].') PARA QUE SE LE DE PRIORIDAD EN LA ESTACIÓN DE SERVICIO AL PRESENTAR ESTE DETALLE</p><br>
<p align="center"><img src="../../dist/img/firma.png" height="50px"><br>
ARMANDO ALVAREZ</p>
</body>
</html>
';

mysqli_close($conexion);
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf -> load_html(($codigohtml));
ini_set("memory_limit","1024M");
$dompdf -> render();
$dompdf -> stream('Solicitud'.$ID.'.pdf', array("Attachment" => 0));

?>