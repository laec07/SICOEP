<?php
require_once("../../plugins/dompdf/autoload.inc.php");
include("../../conexion.php");
session_start();
$p=$_SESSION['usuario']['codigo_pais'];
$f=mysqli_query($conexion,"SELECT
  a.Id_equipo,
  a.Id_Asignacion,
  v.codigo_pais
FROM
  asignacion_vehiculo a,
  vehiculo v
WHERE
  a.Estado_asig = 'ACTIVO'
AND v.Id_equipo = a.Id_equipo
AND v.codigo_pais='$p' ");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>SICOEP</title>
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<?php
while ($fila0=mysqli_fetch_array($f)) {
  $pl=$fila0['Id_equipo'];
  $ID=$fila0['Id_Asignacion'];



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







echo '

<p align="center">INVENTARIO DE VEH&Iacute;CULO</p>

<p align="right">Fecha asignación:</br>'.$rpais['pais'].' '.date_format(new Datetime( $rcarro['Fecha']),'d-m-Y').'
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
      <img src="../../consultas/'.$foto_vehi['foto1'].'" HEIGHT=75px;   /><br>
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
  echo'
  <tr><td>'.$row['accesorios'].'</td>';
 if($i==2)
  echo'<td>'.$row['accesorios'].'</td>'; 
 if($i==3){
  echo'<td>'.$row['accesorios'].'</td></tr>';
 $i=0;}
 $i++;
}
//luego para cerrar bien la tabla fuera del while:

if($i==1)
 echo'</table>';

if($i==2)
 echo'<td></td><td></td></tr></table>';

if($i==3)
 echo'<td></td></tr></table>'; 


echo'</table>

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
  echo'
  <tr><td style="padding:1px;"><img src=../../consultas/'.$row['foto1'].'   HEIGHT=150></td>';
 if($i==2){
  echo'<td style="padding:1px;"><img src=../../consultas/'.$row['foto1'].'  HEIGHT=150></td>'; 
 
 $i=0;}
 $i++;
}
//luego para cerrar bien la tabla fuera del while:

if($i==1)
 echo'</table>';



if($i==2)
 echo'<td></td></tr></table>'; 


echo'</table>
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
';
}
echo'
 </body>
</html>';





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


