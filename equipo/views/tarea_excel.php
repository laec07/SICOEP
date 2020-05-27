<?php
include ("../../conexion.php");
session_start();
$pais=$_GET['pais'];
$area=$_GET['area'];
$usuario=$_GET['usuario'];
$f1=$_GET['fecha1'];
$f2=$_GET['fecha2'];
/*******************************************************************/
header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=tareas_sistemas_".$usuario.".xls");
header("Pragma: no-cache");
header("Expires: 0");
/***********************************************************************/
$resp=mysqli_query($conexion,"SELECT * FROM usuario WHERE USUARIO='$usuario'");
$respon=mysqli_fetch_array($resp);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>
    <table>
        
        <tr>
            <th></th>
            <th>Responsable:</th>
            <td><?php echo $respon['NOMBRE']; ?></td>   
        </tr>
        <tr>
            <th></th>
            <th>Del:</th>
            <td><?php echo $f1; ?></td>
        </tr>
        <tr>
            <th></th>
            <th>Al:</th>
            <td><?php echo $f2; ?></td>
        </tr>
            <tr>
            </tr>
        
    </table>
<table>
            <tr>
                <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">ID Tarea</th>
                <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Tarea</th>
                <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Descripción</th>
                <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Fecha Programada</th>
                <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Estatus</th>
                <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Fecha Realizado</th>
                <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Fecha Reprogramado</th>
                <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Observaciones</th>
                
            </tr>
            <?php
            $datos=mysqli_query($conexion,"SELECT t.ID as idt, t.tarea, t.fecha_programada, m.ID, m.estatus, m.fecha_realizado, m.Observaciones, t.mensaje,t.cod_area, m.fecha_reprogramado 
              FROM mov_tarea m, tarea t
             WHERE m.ID IN (SELECT ID
                            FROM (  SELECT MAX(ID) AS id, id_tarea, MAX(fecha_mov) as fecha
                                      FROM mov_tarea 
                                  GROUP BY id_tarea) a)
            AND t.ID=m.ID_tarea AND t.usuario_asignado='$usuario' AND t.fecha_programada BETWEEN '$f1' AND '$f2' ORDER BY t.fecha_programada desc
            
            ");

            while ($fila=mysqli_fetch_array($datos)) {
            	if ($fila['fecha_reprogramado']=='0000-00-00') {
            		$fila['fecha_reprogramado']='';
            	}
            	if ($fila['fecha_realizado']=='0000-00-00') {
            		$fila['fecha_realizado']='';
            	}
            	if ($fila['estatus']=='PENDIENTE') {
            		$rojo='border:1px solid #000;background: #CC0033;color:#fff;';
            	}else{
            		$rojo='border:1px solid #000;';
            	}
                echo "
                <tr>
                    <td style='border:1px solid #000;padding: 10px'>".$fila['idt']."</td>
                    <td style='border:1px solid #000;padding: 10px'>".$fila['tarea']."</td>
                    <td style='border:1px solid #000;padding: 10px'>".$fila['mensaje']."</td>
                    <td style='border:1px solid #000;padding: 10px'>".$fila['fecha_programada']."</td>
                    <td style='".$rojo."'>".$fila['estatus']."</td>
                    <td style='border:1px solid #000;padding: 10px'>".$fila['fecha_realizado']."</td>
                    <td style='border:1px solid #000;padding: 10px'>".$fila['fecha_reprogramado']."</td>
                    <td style='border:1px solid #000;padding: 10px'>".$fila['Observaciones']."</td>
                    
                </tr>
                ";
            }
            ?>

        </table>
</body>
</html>
