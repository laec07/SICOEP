<?php
include ("../conexion.php");
/**********************************/
session_start();
/****************************/
$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);

/*******************************/
$sedes=mysqli_query($conexion, 
  "SELECT
  d.Id_depto,
  d.Depto,
  COUNT(a.Id_Asignacion) as total
FROM
  depto d,
  asignacion_vehiculo a
WHERE
a.Id_depto = d.Id_depto
AND d.Tipo = 'SEDE'
AND d.codigo_pais = '$pais'
AND a.Estado_asig='ACTIVO'
GROUP BY d.Id_depto,d.Depto
  ");

 

while ($fila=mysqli_fetch_array($sedes)) {
  $vehi=mysqli_query($conexion,"SELECT
  em.id_equipo,
  v.Equipo,
  v.Marca,
  v.Modelo,
  d.Depto,
  em.km_ultimomante,
  v.Kilometraje,
  em.kilosugerido,
  em.codigo_pais
FROM
  estado_mantenimiento em
JOIN vehiculo v ON em.id_equipo = v.Id_equipo
LEFT JOIN asignacion_vehiculo av ON av.Id_equipo = em.id_equipo
AND av.Estado_asig = 'ACTIVO'
JOIN depto d ON d.Id_depto=av.Id_depto
WHERE v.codigo_pais='$pais'
AND av.Id_depto='".$fila['Id_depto']."'
order by d.Depto 
");

  echo"
<div class='box box-danger'>
          <div class='box-header'>
            <h4>Configurar alertas - ".$fila['Depto']."</h4>
          </div>
          <div class='box-body'>
            <div class='table-responsive'>
            <table  class='table table-bordered table-striped' >
              <thead>
                <tr>
                  <th>Vehículo</th>
                  
                  <th>Km. Actual</th>
                  <th>Km. Mantenimiento</th>
                  <th>Km restantes</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>";
            
              while ($fila_vehi=mysqli_fetch_array($vehi)) {
                $restante=  $fila_vehi['kilosugerido'] - $fila_vehi['Kilometraje'];

                if ($restante > 0 and $restante <=200 ) {
                  $clase='class="label label-warning"';
                }else if ($restante < 0) {
                  $clase='class="label label-danger"';
                }else{
                  $clase='class="label label-info"';
                }

                echo "
                  <tr>
                  <td>".$fila_vehi['id_equipo']."<br>".$fila_vehi['Marca']."<br>".$fila_vehi['Equipo']." ".$fila_vehi['Modelo']."</td>
                  <td>".$fila_vehi['Kilometraje']."
                    <a class='pull-right' 
                        data-toggle='modal' 
                        data-target='#KilometrajeEdita' 
                        data-id_e='".$fila_vehi['id_equipo']."'
                        data-km_e='".$fila_vehi['Kilometraje']."'
                    >
                      <span class='fa fa-pencil'></span> 
                    </a></td>
                  <td contenteditable id='km' data-placa='".$fila_vehi['id_equipo']."'
                    >".$fila_vehi['kilosugerido']."  </td>
                  <td><label $clase>".$restante."</label></td>
                  <td></td>
                </tr>
                ";
              }
            echo"
                
              </tbody>
            </table>
          </div>
          </div>
        </div>
";
  
}




mysqli_close($conexion);
?>
   <!-- *************Form Editar kiometraje******************** -->
   <!DOCTYPE html>
   <html>
   <head>
     <title></title>
   </head>
   <body>
   <div class="modal fade" id="KilometrajeEdita">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Kilometraje</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Placa:</label>
                  <input type="text" name="placa" id="placa" class="form-control" readonly="">
                </div>
               <div class="form-group">
                 <label>Kilometraje actual</label>
                 
                 <input type="number" name="kilometraje_e" id="kilometraje_e" class="form-control" onkeyup="suma_km()"  >
               </div>
               <div id="datos">
                 
               </div>

              </div>
              <div class="modal-footer">
                <button class="btn btn-primary pull-right" data-dismiss="modal" onclick="guarda_kmeditado()">Guardar</button>
                <br>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<script>
  //trae datos para editar kilometraje
 $('#KilometrajeEdita').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('km_e')
      var recipient1 = button.data('id_e')


      var modal = $(this)    
      modal.find('.modal-body #kilometraje_e').val(recipient0)
      modal.find('.modal-body #placa').val(recipient1)

      km_dianterior_edita(recipient1);


    });
</script>

   </body>
   </html>
   
