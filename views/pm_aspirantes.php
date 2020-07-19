<?php
 include ("../conexion.php");  
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}  
$em=$_SESSION['usuario']['id_empresa'];
$busca_foto=$_SESSION['usuario']['foto'];
if ($busca_foto=="") {
  $foto='../../dist/img/sin_foto.jpg';
}else{
   $foto='../../consultas/'.$_SESSION['usuario']['foto'];
}
/*******************************************************************************************/
$datos_empresa=mysqli_query($conexion,"SELECT * FROM empresa where id_empresa='$em'");
$empresa=mysqli_fetch_array($datos_empresa);
$pais=$_SESSION['usuario']['codigo_pais'];
$sede=$_SESSION['usuario']['Id_depto'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
/*******************************************************************************************************/
date_default_timezone_set('America/Guatemala');
$fecha_actual= Date("Y-m-d");

/**********************************************************************************************************/ 
?>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Aspirantes</h3>
          </div>
          <div class="box-body">
            <div style="overflow:scroll;height: 100%  ">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                  <th colspan="2" >Aspirante</th>
                  
                 
                  <th><?php echo $rps['doc'];?></th>
                  <th>Licencia</th>
                  <th>Tipo</th>
                  <th><span class="glyphicon glyphicon-wrench"></span></th>
                </tr>   
                </thead>

                  
              <?php
                  $consulta= mysqli_query($conexion,"SELECT * FROM usuarios where tipo_usu='Aspirante' and codigo_pais='$pais' and (estado='ACTIVO')");
                while ($fila = mysqli_fetch_row($consulta)) 
                  { 
                  if (empty($fila[14])) {
                            $fila[14]='files/vacio2.jpg';
                          };
                    if (empty($fila[12])) {
                            $fila[12]='files/id_card.png';
                            };
                    if (empty($fila[13])) {
                              $fecha='';
                              $label='';
                              $titulo='';
                            }else{
                              $fecha=date_format(New datetime($fila[13]),"d/m/Y");

                              if ($fila[13]<=$fecha_actual ) {
                                $label="class='label label-danger'";
                                $titulo="title='Piloto con lincencia vencida'";
                              }else if ($fila[13]>$fecha_actual and $fila[13]<= date("Y-m-d",strtotime($fecha_actual."+ 2 month"))  ){
                                $label="class='label label-warning'";
                                $titulo="title='Queda menos de dos meses para renovación de licencia'";
                              }else if ($fila[13]>$fecha_actual) {
                               $label="class='label label-success'";
                                $titulo="title='Licencia activa'";
                              }
                              
                            }        
                    echo "<tr>";
                    echo "<td>
                            <div class='div-imagen'>
                              
                                <div >
                                  <a data-target='#editPick' data-toggle='modal' title='Editar' data-id_piloto='" .$fila[0] ."' >
                                    <p>Editar</p>
                                  </a>
                                </div>

                                <a  href='../../consultas/".$fila[14]."' data-lightbox='roadtrip'>
                                    <img  src='../../consultas/$fila[14]' >
                                </a>
                            </div>
                          </td>

                    <td>$fila[1]<br><b>E-mail: </b>$fila[2]<br><b>Tel.: </b>$fila[3]<br><b>Dir.: </b>$fila[4]</td>
                    <td>$fila[5]</td>
                    <td>
                      <div class='div-imagen'>
                        <div >
                          <a data-target='#editLic' data-toggle='modal' title='Editar' data-id_piloto='" .$fila[0] ."' >
                            <p>Editar</p>
                          </a>
                        </div>
                          <a  href='../../consultas/".$fila[12]."' data-lightbox='roadtrip'>
                            <img  src='../../consultas/$fila[12]' >
                          </a>
                      </div>
                      $fila[6]<br>
                      <label $label $titulo>".$fecha."</label>
                    </td>
                    <td>$fila[8]<br>$fila[15] Años</td>";  
                    echo"<td>";           
                      echo "<a data-toggle='modal' data-target='#editUsu' 
                                data-id='" .$fila[0] ."' 
                                data-nombre='" .$fila[1] ."' 
                                data-email='" .$fila[2] ."' 
                                data-tel='" .$fila[3] ."'
                                data-direccion='" .$fila[4] ."' 
                                data-dpi='" .$fila[5] ."'
                                data-lic='" .$fila[6] ."'
                                data-tipo='" .$fila[8] ."' 
                                data-fecha_venci='".$fila[13]."'
                                data-experiencia_e='".$fila[15]."'
                                 
                              class='btn btn-warning'><span class='glyphicon glyphicon-pencil'></span></a> ";

                    echo "<a class='btn btn-danger' href='../../consultas/piloto_elimina.php?id=" .$fila[0] ."' onclick=\"return confirm('¿Esta seguro de  eliminar al piloto ".$fila[1] ." ? ')\" ><span class='glyphicon glyphicon-remove'></span></a>";   
                    echo "</td>";
                    echo "</tr>";
                  }
                  $consulta->close();
      
            
      
  

?>
          </table>
            </div>
          </div><!--Termina box body-->
        </div>