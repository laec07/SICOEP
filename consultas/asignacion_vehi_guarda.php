<?php 
include'../conexion.php';
 session_start();
 /*********************************************/
$pais=$_SESSION['usuario']['codigo_pais'];
/********************************************/
$dto=$_POST['depto'];
$eqp=$_POST['equip'];
$usa=$_POST['usua'];
$fch=$_POST['fecha'];    
$cnn=$_POST['canal'];
$p_venta=$_POST['p_venta'];
if (isset($_POST['faccs'])) {
   $facc=$_POST['faccs']; 
}else{
   $facc='0000-00-00'; 
}

if (isset($_POST['fotosf'])) {
    $fotosf=$_POST['fotosf'];
}else{
    $fotosf='0000-00-00';
}
/*****************************************/
$fchsql=date('Y-m-d', strtotime($fch));
/**************************************/
$busca=mysqli_query($conexion,"SELECT llanta_iz_delantera,llanta_iz_trasera,llanta_der_trasera,llanta_der_delantera,Observaciones,Kilometraje FROM vehiculo WHERE Id_equipo='$eqp'");
$llantas=mysqli_fetch_array($busca);
$iz_d=$llantas['llanta_iz_delantera'];
$iz_t=$llantas['llanta_iz_trasera'];
$de_d=$llantas['llanta_der_delantera'];
$de_t=$llantas['llanta_der_trasera'];
$obs=$llantas['Observaciones'];
$kt=$llantas['Kilometraje'];
/*****************************************/
$bcanal=mysqli_query($conexion,"SELECT * FROM canal WHERE canal='$cnn' ");
$canal=mysqli_fetch_array($bcanal);


if ($fotosf=='0000-00-00' or $facc=='0000-00-00' ) {
    print"
        <SCRIPT LANGUAGE='javascript'> 
            alert('No puede asignar vehiculos sin antes subir fotos o realizar revision de accesorios.');
            history.go(-1) 
            </SCRIPT> 
                    ";
}else{


    if ($canal['estado']=='A') {
        $estado='ASIGNADO';
    }else{
        $estado=$canal['canal'];
    }


        if ( $eqp=='Seleccione vehiculo...') {
            print"
                <SCRIPT LANGUAGE='javascript'> 
                    alert('Seleccione vehículo por favor');
                    history.go(-1) 
                    </SCRIPT> 
                            ";
        }else{
           if(mysqli_query($conexion,"INSERT INTO asignacion_vehiculo(Id_depto,Id_equipo,Id_usuario,Fecha,Observaciones,Estado_asig,canal,fecha_accesorios,fecha_fotos,llanta_iz_delantera,llanta_iz_trasera,llanta_der_trasera,llanta_der_delantera,kilometraje,ruta) VALUES ('$dto','$eqp','$usa','$fchsql','$obs','ACTIVO','$cnn','$facc','$fotosf','$iz_d','$iz_t','$de_t','$de_d','$kt','N')")){
                mysqli_query($conexion,"UPDATE vehiculo SET Estado_equipo = '$estado',precio_venta='$p_venta' WHERE Id_equipo = '$eqp'");
                mysqli_query($conexion,"UPDATE usuarios SET estado = 'ASIGNADO' WHERE Id_usuario = '$usa'");
                print"
                <SCRIPT LANGUAGE='javascript'> 
                    alert('Asignado exitosamente');
                    history.go(-1) 
                    </SCRIPT> 
                    
                ";
             }else{
                print"
                <SCRIPT LANGUAGE='javascript'> 
                    alert('No fue posible la asignacion, por favor revise datos ingresados');
                    history.go(-1); 
                    </SCRIPT> 
                    
                ";
         }
    }
}


   
    

    mysqli_close($conexion);
    
    
     ?>
    