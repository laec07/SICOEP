<?php
include("../../conexion.php");
session_start();
$pais=$_SESSION['usuario']['codigo_pais'];
/***********************************************************/

header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=vehiculos_sicoep.xls");
header("Pragma: no-cache");
header("Expires: 0");
/***********************************************************/
$vehiculo=mysqli_query($conexion, "SELECT * FROM   vehiculo where codigo_pais='$pais'");
/***********************************************************/
?>
<!DOCTYPE html>
<html>
<head>
	<title>SICOEP</title>
	<meta charset="utf-8">
</head>
<body>
<table >
                <thead>
                  <tr>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Placa</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Marca</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Tipo</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Año</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Estado</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Tipo gas.</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >Kilometraje</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >IZ. D.</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >DER. D.</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >IZ. T.</th>
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;" >DER. T.</th>   
                    <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Poliza</th>  
                   <th style="border:1px solid #000;background: #CC0033;color:#fff;text-align: center;">Vin</th> 
                    
                  </tr>
                </thead>
                <tbody>
                   <?php 
                      $suma=0;
                      while($rvehiculo=mysqli_fetch_array($vehiculo)){
                      echo "
                      <tr>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['Id_equipo']."</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['Marca']."</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['Equipo']."</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['Modelo']."</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['Estado_equipo']."</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['combustible']."</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['Kilometraje']."</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['llanta_iz_delantera']."%</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['llanta_der_delantera']."%</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['llanta_iz_trasera']."%</td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['llanta_der_trasera']."%</td> 
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['poliza']." </td>
                        <td style='border:1px solid #000;padding: 10px' >".$rvehiculo['chasis_vin']."</td>                    
                        
                      </tr>
                      ";
                      }
                      $numero=mysqli_num_rows($vehiculo);
                  ?>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
</body>
</html>