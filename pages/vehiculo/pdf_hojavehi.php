<?php
require_once("../../plugins/dompdf/autoload.inc.php");
include("../../conexion.php");

$pl=$_GET['placa'];
$ID=$_GET['ID'];
session_start();
$p=$_SESSION['usuario']['codigo_pais'];
$hpais=mysqli_query($conexion, "SELECT pais, doc FROM pais where codigo_pais='$p'");

$usuarios=mysqli_query($conexion,"SELECT usuario,DPI,Licencia,foto_piloto FROM `usuarios` JOIN asignacion_vehiculo on usuarios.Id_usuario = asignacion_vehiculo.Id_usuario  WHERE  asignacion_vehiculo.Id_Asignacion='$ID'");
$carro=mysqli_query($conexion, "SELECT v.Equipo,v.Id_equipo,a.kilometraje,v.Modelo,a.llanta_iz_delantera,a.llanta_iz_trasera,a.llanta_der_trasera,a.llanta_der_delantera,v.Marca,a.Observaciones,a.Fecha FROM vehiculo v JOIN asignacion_vehiculo a ON v.Id_equipo = a.Id_equipo WHERE  a.Id_Asignacion = '$ID'");
$canal=mysqli_query($conexion, "SELECT canal,Id_Asignacion,Observaciones,fecha_accesorios,fecha_fotos FROM asignacion_vehiculo WHERE  Id_Asignacion='$ID'");
$depto=mysqli_query($conexion, "SELECT Depto FROM depto JOIN asignacion_vehiculo on asignacion_vehiculo.Id_depto = depto.Id_depto WHERE  asignacion_vehiculo.Id_Asignacion='$ID' ");




$rpais=mysqli_fetch_array($hpais);
$rdepto=mysqli_fetch_array($depto);
$rcanal=mysqli_fetch_array($canal);
$rusuario=mysqli_fetch_array($usuarios);
$rcarro=mysqli_fetch_array($carro);



date_default_timezone_set('America/Guatemala');
    
    $fecha_actual= " ".Date("d")." de ".Date("M")." del ".Date("Y");
    $fecha_acc=$rcanal['fecha_accesorios'];
    $fecha_fotos=$rcanal['fecha_fotos'];
$f_vehi=mysqli_query($conexion,"SELECT f.foto1,f.fecha FROM vehiculo v LEFT JOIN foto_vehi f ON f.id_equipo = v.Id_equipo WHERE v.id_equipo='$pl' and f.fecha='$fecha_fotos' GROUP BY v.Id_equipo");
$foto_vehi=mysqli_fetch_array($f_vehi);
if (empty($foto_vehi['foto1'])) {
              $foto_vehi['foto1']='files/vacio.jpg';
                  };
if (empty($rusuario['foto_piloto'])) {
          $rusuario['foto_piloto']='files/vacio2.jpg';
          };

$codigohtml='
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>HOJA RESPONSABILIDAD VEHI</title>
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<p align="center">INVENTARIO DE VEH&Iacute;CULO</p>
<p align="right">'.$rpais['pais'].' '.date_format(new Datetime( $rcarro['Fecha']),'d-m-Y').'
</p>
<p>&nbsp; </p>
<table  width="100%" border="0">
  <tr>
    <td>
      <img src="../../consultas/'.$rusuario['foto_piloto'].'" HEIGHT=75px; align=left />
      <small> <b>Nombre: </b>'. $rusuario['usuario'].'</small><br>
      <small><b>No. licencia: </b>'. $rusuario['Licencia'].'</small><br>
      <small><b>No. '.$rpais['doc'].': </b>'.$rusuario['DPI'].'</small>
    </td>

    <td>
      <img src="../../consultas/'.$foto_vehi['foto1'].'" HEIGHT=75px; style="float:left"  /><br>
       <small><b>'.$rcarro['Id_equipo'].'</b></small><br>
      <small>'.$rcarro['Marca'].' '.$rcarro['Modelo'].'</small>
     
    </td>

  </tr>

  <tr>
    <td colspan="2">
    <br>
      <small><b>Depto: </b>'. $rdepto['Depto'].'</u></small><br>
      <small><b>Canal: </b>'.$rcanal['canal'].'</u></small><br> 
      <small><b>Kilometraje:</b>'.$rcarro['kilometraje'].'</small> 
    </td
  </tr>
 
</table>


<hr />
<p>Para efectos se procede a levantar el inventario actual del veh&iacute;culo, detallando a continuaci&oacute;n los elementos entregados. </p><p>
<p align="right" >Fecha revisi&oacute;n '.$fecha_acc.' </p>
<table border="1" width=100% align="center">
';


	$i=1;
	$acc=mysqli_query($conexion, "SELECT
  accesorios,
  ID,
  DATE_FORMAT(fecha_ingreso, '%d-%m-%Y') AS fecha
FROM
  lista_accesorios
JOIN accesorios ON lista_accesorios.Id_accesorio = accesorios.Id_accesorio
WHERE
  accesorios.Id_equipo = '$pl'
AND DATE_FORMAT(fecha_ingreso, '%Y-%m-%d') = '$fecha_acc'");

	while ($row=mysqli_fetch_array($acc)) {
		if($i==1)
  $codigohtml.='
  <tr><td>'.$row['accesorios'].'</td>';
 if($i==2)
  $codigohtml.='<td>'.$row['accesorios'].'</td>'; 
 if($i==3){
  $codigohtml.='<td>'.$row['accesorios'].'</td></tr>';
 $i=0;}
 $i++;
}
//luego para cerrar bien la tabla fuera del while:

if($i==1)
 $codigohtml.='</table>';

if($i==2)
 $codigohtml.='<td></td><td></td></tr></table>';

if($i==3)
 $codigohtml.='<td></td></tr></table>'; 


$codigohtml.='</table>

</p>



<div style="page-break-after:always;"></div>
<div>
<p>Estado del vehículo:</p>
</br>
</div>

</br>
</br>
</br>
<div >
<table  align="center">
';


  $i=1;
  $foto=mysqli_query($conexion, "SELECT * FROM foto_vehi WHERE id_equipo='$pl' and fecha='$fecha_fotos'");
  while ($row=mysqli_fetch_array($foto)) {
    if($i==1)
  $codigohtml.='
  <tr><td style="padding:1px;"><img src=../../consultas/'.$row['foto1'].'   HEIGHT=150></td>';
 if($i==2){
  $codigohtml.='<td style="padding:1px;"><img src=../../consultas/'.$row['foto1'].'  HEIGHT=150></td>'; 
 
 $i=0;}
 $i++;
}
//luego para cerrar bien la tabla fuera del while:

if($i==1)
 $codigohtml.='</table>';



if($i==2)
 $codigohtml.='<td></td></tr></table>'; 


$codigohtml.='</table>
 </div>
 <p>Observaciones:</p><p>'.$rcanal['Observaciones'].'</p>
<p>Ciclo de vida llantas</p>
<table align="center" border="1" text-align="center" width=75%>
<tr>
<td  align="center">Delantera izquierda</td>
<td  align="center">Delantera derecha</td>
<td  align="center">Trasera izquierda</td>
<td  align="center">Trasera derecha</td>
</tr>
<tr>
<td align="center" >'.$rcarro['llanta_iz_delantera'].'%</td>
<td  align="center">'.$rcarro['llanta_iz_trasera'].'%</td>
<td  align="center">'.$rcarro['llanta_der_trasera'].'%</td>
<td  align="center">'.$rcarro['llanta_der_delantera'].'%</td>
</tr>
</table>
 <div style="page-break-after:always;"></div>
  <p><b>Recepci&oacute;n del veh&iacute;culo asignado</b></p>
  <ul> 
<li>A la recepci&oacute;n del veh&iacute;culo, el empleado deber&aacute; recabar la tarjeta o autenticaci&oacute;n respecticva, placas, accesorios, y carta de autorizaci&oacute;n de uso de veh&iacute;culo.</li> 
</ul>

<p><b>Multas y p&eacute;rdidas de accesorios:</b></p>
<ul>
1)  Asumir todos los costos de reparaci&oacute;n por mal uso del veh&iacute;culo<br>
2)  Asumir la responsabilidad por p&eacute;rdida o robo de herramientas ocualquier tipo de accesorio del veh&iacute;culo o negligencia.
</ul>

<p><b>Limpieza y mantenimiento:</b></p>
<ul>
1)  El empleado se compromete diariamente a revisar el buen funcionamiento del veh&iacute;culo antes de salir de las instalaciones de la compañ&iacute;a (niveles de aceite, agua, etc.)<br>
2)  El empleado se compromete a mantener limpio el interior y exterior del veh&iacute;culo.<br>
3)  El empleado se compromete a cumplir con el mantenimiento preventivo cada 5,000 kil&oacute;metros para tal efecto, notificar con 48 horas de anticipaci&oacute;n, dicho cumplimiento a fin de coordinar en taller autorizado, de lo contrario el empleado acepta que se cargue a su cuenta el 50% de dicho costo, si este se efect&uacute;a posterior al Kilometraje definido.
</ul>

<hr />

<p><b>Recepci&oacute;n del veh&iacute;culo asignado<b></p>
<ul> 
<li>El veh&iacute;culo asignado es exclusivamente para fines laborales y para cumplimiento de tareas en beneficio de la compañía, bajo ning&uacute;n motivo el empleado est&aacute; autorizado a realizar actividades de inter&eacute;s personal usando dicho veh&iacute;culo.</li> <br><br>

</ul>
<p><b>Inventario del veh&iacute;culo</b><p>
<ul> 

<li>Para el efecto se procede a levantar el inventario actual del vehículo, con los elementos antes detallados entregados al empleado, teniendo por enterado que cualquier pérdida o daño causado por imprudencia del conductor tanto en la parte física del vehículo, así mismo en el motor que sean por negligencia por no velar por el buen funcionamiento, será descontado de su salario, el 100% al conductor que tenga asignado el vehículo, sobre cualquier daño ocasionado al recurso de la empresa. </li> 
</ul>
<p>Una vez le&iacute;da y aprobada en su integridad por quienes firman, se da por finalizada y se firma para constancia</p>
<p><br></br></p>
<p align="center">____________________________________<br>
</br>'.$rusuario['usuario'].'<br>
</br>'.$rpais['doc'].':'.$rusuario['DPI'].'</p>

<table align="center" WIDTH=100%>
<tr>
<td>
<p align="center">___________________________
<br></br>Encargado de transporte
</p></td>
<td></td>
<td><p align="center">___________________________
<br></br>Vo.Bo.
</p></td>
</tr>
</table>



</body>
</html>';

use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf -> load_html(($codigohtml));
ini_set("memory_limit","128M");
$dompdf -> render();
$dompdf -> stream('HojaResponVehi.pdf', array("Attachment" => 0));

Mysqli_free_result($hpais);
Mysqli_free_result($depto);
Mysqli_free_result($canal);
Mysqli_free_result($usuarios);
Mysqli_free_result($carro);
Mysqli_free_result($foto);

mysqli_close($conexion);
/*
*/
?>


