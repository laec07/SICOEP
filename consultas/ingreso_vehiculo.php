<?php
include('../conexion.php');
session_start();
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y-m-d");
            
            $pais=$_SESSION['usuario']['codigo_pais'];
			$Id=$_POST['placa'];
            $nom=$_POST['nom'];
            $mr=$_POST['mar'];
            $md=$_POST['modelo'];
            $gas=$_POST['combustible'];
            $kl=$_POST['kilo'];
            $cara=$_POST['Caracteristicas'];
            $obs=$_POST['Observaciones'];
            $esteq="ACTIVO";
            $pro=$_POST['propietario'];
            $poli=$_POST['poliza'];
            $chasis=$_POST['chasis'];

$vehi=mysqli_query($conexion,"SELECT * FROM vehiculo where Id_equipo='$Id'");

if ($vehi-> num_rows == 1) {
    echo "
    <SCRIPT LANGUAGE='javascript'> 
        alert('Ya existe un registro con este número de placa!!'); 
        history.go(-1);
    </SCRIPT> 
    ";
}else{
    mysqli_query($conexion, "INSERT INTO vehiculo (Id_equipo, Equipo, Marca, Modelo, Kilometraje, Caracteristicas, Observaciones, Estado_equipo,combustible,accesorio,codigo_pais, propietario, poliza, chasis_vin  ) Values ('$Id','$nom','$mr','$md','$kl','$cara','$obs','$esteq','$gas','N','$pais', '$pro', '$poli', '$chasis')");

    mysqli_query($conexion,"INSERT INTO estado_mantenimiento (id_equipo, codigo_pais, km_actual) Values ('$Id','$pais','$kl' )");
    

    mysqli_close($conexion);
  echo
    "
        <SCRIPT LANGUAGE='javascript'> 
            alert('Dato Guardado exitosamente'); 
            history.go(-1);
        </SCRIPT> 
            
    ";
 




}
?>
