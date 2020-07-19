	<?php
			include ("../conexion.php");  
			error_reporting(0);
			session_start();
			$pais=$_SESSION['usuario']['codigo_pais'];

			$us=$_GET['nombre'];
			$corr=$_GET['email'];
			$tl=$_GET['tel'];
			$dir=$_GET['dir'];
            $dp=$_GET['dpi'];
			$no=$_GET['tipo'];
            $lic=$_GET['numlic'];
            $pil='Piloto';
            $estado='ACTIVO';
            $fecha_venci=$_GET['fecha_venci'];
            $experiencia=$_GET['experiencia'];
            
            
            
            
            if ($no!='Seleccione tipo licencia') 
            {

            	if(mysqli_query($conexion, "INSERT INTO usuarios (Usuario, DPI, Telefono, Correo_electronico, Direccion, tipo, Licencia, tipo_usu, codigo_pais, estado,fecha_vencimiento, experiencia) Values ('$us','$dp','$tl','$corr','$dir','$no','$lic', '$pil','$pais', '$estado','$fecha_venci','$experiencia')"))
            	{
            	 print"
            	
        <SCRIPT LANGUAGE='javascript'> 
            alert('Piloto Ingresado'); 
            history.go(-1);
            </SCRIPT> 
            

            ";
            } 
            else 
            {
            	 print"
            	
        <SCRIPT LANGUAGE='javascript'> 
            alert('Error al ingresar piloto'); 
            history.go(-1);
            </SCRIPT> 
            

            ";

            }

            } 
            else 
            {
            	print"
        <SCRIPT LANGUAGE='javascript'> 
            alert('Seleccione Tipo licencia')
            history.go(-1);; 
            </SCRIPT> 
           
        ";
            }
            
        
        mysqli_close($conexion);
			
	?>	

