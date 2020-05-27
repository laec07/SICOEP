<?php
include ("../../conexion.php");
 session_start();
 $pais=$_SESSION['usuario']['codigo_pais'];
 $ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);

$l_usuarios=mysqli_query($conexion,"
  SELECT
  u.NOMBRE,
  u.USUARIO,
  u.CLAVE,
  u.TIPO,
  u.codigo_pais,
  u.Id_depto,
  d.Depto,
  u.estado,
  u.correo,
  u.autoriza_combustible,
  u.alerta_mantenimiento,
  u.foto,
  p.pais
FROM
  usuario u
LEFT JOIN depto d ON u.Id_depto = d.Id_depto
LEFT JOIN pais p ON p.codigo_pais=u.codigo_pais
WHERE
  u.TIPO IN (
    'Admin_equipo',
    'Ticket_user'
  )
AND u.USUARIO NOT IN ('adming', 'admins')
AND u.estado='ACTIVO'
order by u.TIPO
");
?>
<div class="box box-danger">
  <div class="box-header">
    
  </div>
  <div class="box-body">
    
  
</div>
            <div class="table-responsive">
            <table class="table table-bordered table-over table-striped table-hover" id="tabla_usuariosP" >
              <thead>
                <tr>
                  <th><img src="" height="" width="5px"> Nombre</th>
                  <th>Usuario</th>
                  <th>Tipo</th>
                  <th>Pais</th>
                  

                   
                  <th></th>
                </tr>
              </thead>
              <tbody>
                
                <?php
                while ($fila=mysqli_fetch_array($l_usuarios)) {
                  //////////////////////////////////////////

                  ////////////////////////////////////////
                  if ($fila['TIPO']=="Admin_equipo") {
                    $h='ADMINISTRADOR';
                  }else if ($fila['TIPO']=="Ticket_user") {
                    $h='Ticket';
                  }
                  ////////////////////////////////////
////////////////////////////////////


                  ///////////////////////////////////

                    if ($fila['foto']=="") {
                      $foto_u='../dist/img/sin_foto.jpg';
                    }else{
                      $foto_u='sicoep/'.
                      $fila['foto'];
                    }
                  echo "
                  <tr>
                    <td>
                      <div class='div-imagen' id='div-imagen_1'>

                         <a href='".$foto_u."' data-lightbox='roadtrip'>
                         <div id='fotop' class='user-header'>
                          <img src='".$foto_u."' height='1%' class='img-circle'>
                         </div>
                            
                         </a>
                          
                      </div>
                      

                      <br><b>".$fila['NOMBRE']." </b></td>
                      
                    <td>".$fila['USUARIO']."</td>

                    <td>".$h."</td>
                    

                    <td>".$fila['pais']."</td>
                    <td>
                      <a data-toggle='modal' data-target='#EditarUsuario' class='btn btn-warning'
                        data-usuario_e='".$fila['USUARIO']."'
                        data-nombre_e='".$fila['NOMBRE']."'
                        
                        data-tipo_e='".$fila['TIPO']."'
                        
                        
                        data-pais_e='".$fila['codigo_pais']."'
                      ><span class='fa fa-edit'></span></a>


                    </td>
                  </tr>
                  ";
                }
                ?>
                
              </tbody>  
            </table>
            </div>
</div>

<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
  $(function(){
   $('#tabla_usuariosP').DataTable() 
})

</script>