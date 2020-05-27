<?php
	include'../conexion.php';
	session_start();
	 $Id=$_POST['Id'];
          
            $mr=$_POST['mar'];
            $md=$_POST['modelo'];
            $gas=$_POST['combustible'];
            $kl=$_POST['kilo'];
            
          
            $pro=$_POST['propietario'];
            $pol=$_POST['poliza'];
            $chasis=$_POST['chasis'];

            $d_iz=$_POST['d_iz'];
            $d_de=$_POST['d_de'];
            $t_iz=$_POST['t_iz'];
            $t_de=$_POST['t_de'];
            
        $carro=mysqli_query($conexion, 
            "
            UPDATE 
                vehiculo 
            SET   
                 
               
                Modelo='$md', 
                Kilometraje='$kl', 
                combustible='$gas', 
                propietario='$pro', 
                poliza='$pol', 
                chasis_vin='$chasis',
                llanta_iz_delantera='$d_iz',
                llanta_iz_trasera='$t_iz',
                llanta_der_trasera='$t_de',
                llanta_der_delantera='$d_de' 
            WHERE 
                Id_equipo='$Id'
                ");

        

        if (!$carro) {
            print
            "<SCRIPT LANGUAGE='javascript'> 
            alert('Error al guardar los datos, datos no guardados');
            history.go(-1); 
            </SCRIPT> 
            ";
        }
        else
        {
            mysqli_query($conexion, "UPDATE estado_mantenimiento set  km_actual='$kl' where    Id_equipo='$Id'");
            mysqli_close($conexion);
            print
        "<SCRIPT LANGUAGE='javascript'> 
            
            history.go(-1); 
            </SCRIPT> 
            ";    
        }
  ?>
 