<?php
include ("../conexion.php");
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
  u.foto
FROM
  usuario u
LEFT JOIN depto d ON u.Id_depto = d.Id_depto
WHERE
  u.TIPO IN (
    'Admin_carros',
    'Oper_carros'
  )
AND u.codigo_pais = '$pais'
AND u.USUARIO NOT IN ('adming', 'admins')
");
?>
            <div class="table-responsive">
            <table class="table table-bordered table-over table-striped table-hover" id="example2" >
              <thead>
                <tr>
                  <th><img src="" height="" width="5px"> Nombre</th>
                  <th>Usuario</th>
                  
                  <th>Tipo</th>
                  
                  <th>Alerta Combust.</th>
                  <th>Alerta Mante.</th>
                  <th>Estado</th> 
                  <th></th>
                </tr>
              </thead>
              <tbody>
                
                <?php
                while ($fila=mysqli_fetch_array($l_usuarios)) {
                  //////////////////////////////////////////
                  if ($fila['estado']=="ACTIVO") {
                    $clase="class='label label-success'";
                  }else{
                    $clase="class='label label-danger'";
                  }
                  ////////////////////////////////////////
                  if ($fila['TIPO']=="Admin_carros") {
                    $h='ADMINISTRADOR';
                  }
                  ////////////////////////////////////
                  if ($fila['TIPO']=="Oper_carros") {
                    $h='OPERATIVO';
                  }
                  ///////////////////////////////////////
                  if ($fila['autoriza_combustible']=='S') {
                    $com='SI';
                  }else if ($fila['autoriza_combustible']=='N') {
                    $com='NO';
                  }else {
                    $com='--';
                  }
                  ///////////////////////////////////////
                  if ($fila['alerta_mantenimiento']=='S') {
                    $man='SI';
                  }else if ($fila['alerta_mantenimiento']=='N') {
                    $man='NO';
                  }else{
                    $man='--';
                  }
                  ///////////////////////////////////

                    if ($fila['foto']=="") {
                      $foto_u='../../dist/img/sin_foto.jpg';
                    }else{
                      $foto_u='../../consultas/'.
                      $fila['foto'];
                    }
                  echo "
                  <tr>
                    <td>
                      <div class='div-imagen' id='div-imagen_1'>
                        <div>
                          <a data-target='#editPick' data-toggle='modal' title='Editar' data-usuario='" .$fila['USUARIO']."' >
                                <p>Editar</p>
                          </a>
                        </div>
                         <a href='".$foto_u."' data-lightbox='roadtrip'>
                         <div id='fotop'>
                          <img src='".$foto_u."' height='25%' >
                         </div>
                            
                         </a>
                          
                      </div>
                      

                      <br><b>Nombre: </b>".$fila['NOMBRE']." <br><b>Email: </b>".$fila['correo']."<br>".$fila['Depto']."</td>
                    <td>".$fila['USUARIO']."</td>
                    
                    <td>".$h."</td>
                    
                    <td>".$com."</td>
                    <td>".$man."</td>
                    <td><span $clase>".$fila['estado']."</span></td>
                    <td>
                      <a data-toggle='modal' data-target='#EditarUsuario' class='btn btn-warning'
                        data-usuario_e='".$fila['USUARIO']."'
                        data-nombre_e='".$fila['NOMBRE']."'
                        data-clave_e='".$fila['CLAVE']."'
                        data-tipo_e='".$fila['TIPO']."'
                        data-depto_e='".$fila['Id_depto']."'
                        data-estado_e='".$fila['estado']."'
                        data-alerta_com='".$fila['autoriza_combustible']."'
                        data-alerta_man='".$fila['alerta_mantenimiento']."'
                        data-correo='".$fila['correo']."'
                      ><span class='fa fa-edit'></span></a>

                      <a data-toggle='modal' data-target='#EditaPermisos' class='btn btn-success' title='Editar permisos'
                        data-usuario='".$fila['USUARIO']."'
                      >
                      <span class='fa fa-minus-circle'></span>
                      </a>
                    </td>
                  </tr>
                  ";
                }
                ?>
                
              </tbody>  
            </table>
            </div>
