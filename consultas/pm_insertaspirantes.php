	<?php
			include ("../conexion.php");  

			session_start();
			$pais=$_SESSION['usuario']['codigo_pais'];

			$us=$_POST['nombre'];
			$corr=$_POST['email'];
			$tl=$_POST['tel'];
			$dir=$_POST['dir'];
            $dp=$_POST['dpi'];
			$no=$_POST['tipo'];
            $lic=$_POST['numlic'];
            $pil='Aspirante';
            $estado='ACTIVO';
            $fecha_venci=$_POST['fecha_venci'];
            $experiencia=$_POST['experiencia'];
            
            
            
            
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
            	 echo"
            	
        <SCRIPT LANGUAGE='javascript'> 
            alert('Error al ingresar piloto'); 
          
            </SCRIPT> 
            

            ";

            }

            } 
            else 
            {
            	print"
        <SCRIPT LANGUAGE='javascript'> 
            alert('Seleccione Tipo licencia')
             
            </SCRIPT> 
           
        ";
            }
            
        
        mysqli_close($conexion);
			
	?>	

