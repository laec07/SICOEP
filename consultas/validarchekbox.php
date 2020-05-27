<meta charset="utf-8" http-equiv="Content-Type" content="text/html;" />
<?php
require("../conexion.php");

$eqp=$_POST['equip'];
$obs=$_POST['obs'];
$idel=$_POST['idel'];
$ddel=$_POST['ddel'];
$itra=$_POST['itra'];
$dtra=$_POST['dtra'];
$kilo=$_POST['kilometraje'];


if ($obs!="") {
	mysqli_query($conexion, "UPDATE vehiculo set Observaciones='$obs' WHERE Id_equipo = '$eqp' ");
}


$actualiza=mysqli_query($conexion,"UPDATE vehiculo SET accesorio = 'S',  llanta_iz_delantera='$idel', llanta_iz_trasera='$itra', 	llanta_der_trasera='$dtra', llanta_der_delantera='$ddel', 	Kilometraje='$kilo' WHERE Id_equipo = '$eqp'");
mysqli_query($conexion, "UPDATE estado_mantenimiento SET km_actual='$kilo' where Id_equipo='$eqp'");

if ($_POST['checkbox'] !="")
{
		if(is_array($_POST['checkbox']))
		{
			while(list($key,$value)=each($_POST['checkbox']))
			{
				$sql=mysqli_query($conexion,"INSERT INTO accesorios (Id_accesorio, Id_equipo) VALUES ('$value','$eqp')");
				
			}
		}
}

if(!$sql){
	print"<SCRIPT languaje='javascript'> 
            alert('Error, Datos no guardados');
           	history.go(-1);
            </SCRIPT> 
            ";
}
else
{
print"<SCRIPT languaje='javascript'> 
            alert('Datos insertados correctamente'); 
            history.go(-1);	
            </SCRIPT> 
     ";       
}

?>