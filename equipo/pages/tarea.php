<?php
include ("../../conexion.php");  
session_start();
       
    if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "login/index.php"
</script>';
}
$area=$_SESSION['usuario']['cod_area'];
$fecha_actual= Date("d-m-Y");
$pais=$_SESSION['usuario']['codigo_pais'];
$usuario=$_SESSION['usuario']['USUARIO'];


$pendientes_1=mysqli_query($conexion,"SELECT m.estatus, COUNT(m.estatus) as total
                  FROM mov_tarea m, tarea t
                 WHERE m.ID IN (SELECT ID
                                FROM (  SELECT MAX(ID) AS id, id_tarea, MAX(fecha_mov) as fecha
                                          FROM mov_tarea 
                                      GROUP BY id_tarea) a)
                AND t.ID=m.ID_tarea AND t.codigo_pais='$pais' and t.usuario_asignado='$usuario' AND (m.estatus='PENDIENTE' or m.estatus='REPROGRAMAR' ) GROUP BY m.estatus");
$re_pendientes=mysqli_fetch_array($pendientes_1);
  $pendientes_2=mysqli_query($conexion,"SELECT t.tarea
                    FROM mov_tarea m, tarea t
                   WHERE m.ID IN (SELECT ID
                                  FROM (  SELECT MAX(ID) AS id, id_tarea, MAX(fecha_mov) as fecha
                                            FROM mov_tarea 
                                        GROUP BY id_tarea) a)
                  AND t.ID=m.ID_tarea AND t.codidgo_pais='$pais' AND m.estatus='PENDIENTE' GROUP BY m.estatus");
//$re_pendientes2=mysqli_fetch_array($pendientes_2);



$pendientes_3=mysqli_query($conexion,"SELECT m.estatus, COUNT(m.estatus) as total
                  FROM mov_tarea m, tarea t
                 WHERE m.ID IN (SELECT ID
                                FROM (  SELECT MAX(ID) AS id, id_tarea, MAX(fecha_mov) as fecha
                                          FROM mov_tarea 
                                      GROUP BY id_tarea) a)
                AND t.ID=m.ID_tarea AND t.codigo_pais='$pais'  and  m.estatus='SIN ASIGNAR' GROUP BY m.estatus");
$re_pendientes3=mysqli_fetch_array($pendientes_3);
/*if ($re_pendientes['total']>0) {
  
  echo'
<script>
  Push.create("Nueva tarea asignada!", {
    body: "Tiene '.$re_pendientes['total'].' tarea(s) en estado Pendiente",
    icon: "img/logo.ico",
    timeout: 4000,
    onClick: function () {
        window.focus();
        this.close();
    }
});
</script>

';
}*/
?>
<style type="text/css">  
span.red {
  background: red;
   border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
}

span.grey {
  background: #cccccc;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #fff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
}

span.green {
  background: #5EA226;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
}

span.blue {
  background: #5178D0;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
}

span.pink {
  background: #EF0BD8;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
}
p {
  font-size: 12px;
  margin: 0px;
}
</style>
<div class="row">
  <div class="col-md-4">
            <a data-toggle="modal" data-target="#nuevaTarea" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span> Nuevo</a> 
           <a data-toggle="modal" data-target="#rangoFechas" class="btn btn-success">Descargar</a>
           
          </div>
</div>


<div class="box box-default ">
  <div class="box-header  with-border">
    <h4 class="box-title">SIN ATENDER<span class="red"><?php echo $re_pendientes3['total']; ?></span></h4> 
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
        </button>
    </div>
  </div>
  <div class="box-body">
    <table class="table tables table-hover table-condensed">
              <thead>
                <tr>
                  <th>ID</th>
                  <th >Asunto</th>
                  <th>Descripción</th>
                  <th>Fecha</th>
                  <th>Categoría</th>
                  <th>solicitante</th>
                  <th>Foto</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

              <?php
              $sin_asignar=mysqli_query($conexion,"SELECT 
                                                      t.ID,
                                                      t.tarea,
                                                      m.fecha_mov,
                                                      a.tipo_tarea,
                                                      t.email,
                                                      t.mensaje,
                                                      t.prioridad,
                                                      t.foto,
                                                      t.solicitante,
                                                      t.estatus
                                                    FROM
                                                      tarea t,
                                                      mov_tarea m,
                                                      tipo_tarea a
                                                    WHERE
                                                      t.ID=m.ID_tarea
                                                    AND t.id_tipotarea=a.id_tipotarea
                                                    AND t.estatus='SIN ATENDER'
                                                    AND t.codigo_pais='$pais'");
              while ($fila_sin=mysqli_fetch_array($sin_asignar)) {
                echo "
                  <tr>
                    <td>".$fila_sin['ID']."</td>
                    <td>".$fila_sin['tarea']."</td>
                    <td >".$fila_sin['mensaje']."</td>
                    <td>".$fila_sin['fecha_mov']."</td>
                    <td>".$fila_sin['tipo_tarea']."</td>
                    <td>".$fila_sin['solicitante']."</td>
                    <td><a href='../../consultas/".$fila_sin['foto']."' data-lightbox='roadtrip'><img src='../../consultas/".$fila_sin['foto']."' height='25px' ></td>
                    <td><a onclick=atender(".$fila_sin['ID']."); class='btn btn-info' title='Atender'><span class='glyphicon glyphicon-chevron-left' ></span></a></td>
                  </tr>

                " ;
              }
              ?>
              
              </tbody>
            </table>
  </div>
</div>

<div class="box box-default ">
  <div class="box-header  with-border">
    <h4 class="box-title">Pendientes<span class="red"><?php echo $re_pendientes['total']; ?></span></h4> 
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
        </button>
    </div>
  </div>
  <div class="box-body">
    <table class="table tables table-hover table-condensed">
                <tr>
                    <th>ID</th>
                    <th>Tarea</th>
                    <th>Descripción</th>
                    <th>Fecha Programada</th>
                    <th>Estatus</th>
                    <th></th>
                    <th>Fecha Realizado</th>
                    <th>Fecha Reprogramado</th>
                    <th>Observaciones</th>
                    <th><span class="glyphicon glyphicon-new-window"></span></th>
                </tr>
                <?php

                $datos=mysqli_query($conexion,"SELECT t.ID as idt, t.tarea, t.fecha_programada, m.ID,t.mensaje, m.estatus, m.fecha_realizado, m.Observaciones, t.cod_area, m.fecha_reprogramado 
                  FROM mov_tarea m, tarea t
                 WHERE m.ID IN (SELECT ID
                                FROM (  SELECT MAX(ID) AS id, id_tarea, MAX(fecha_mov) as fecha
                                          FROM mov_tarea 
                                      GROUP BY id_tarea) a)
                AND t.ID=m.ID_tarea AND t.usuario_asignado='$usuario'  AND (m.estatus='PENDIENTE' or m.estatus='REPROGRAMAR' ) ORDER BY t.ID desc
                LIMIT 100
                ");

                while ($fila=mysqli_fetch_array($datos)) {
                  if ($fila['fecha_reprogramado']=='0000-00-00') {
                    $fila['fecha_reprogramado']='';
                  }
                  if ($fila['fecha_realizado']=='0000-00-00') {
                    $fila['fecha_realizado']='';
                  }
                  if ($fila['estatus']=='PENDIENTE') {
                    $rojo='red';
                  }
                  else if ($fila['estatus']=='REALIZADO') {
                    $rojo='green';
                  } else if ($fila['estatus']=='REPROGRAMAR') {
                    $rojo='pink';
                  }
                    echo "
                    <tr>
                        <td>".$fila['idt']."</td>
                        <td>".$fila['tarea']."</td>
                        <td>".$fila['mensaje']."</td>
                        <td>".$fila['fecha_programada']."</td>
                        <td>".$fila['estatus']."</td>
                        <td><span class='".$rojo."'>!</span></td>
                        <td>".$fila['fecha_realizado']."</td>
                        <td>".$fila['fecha_reprogramado']."</td>
                        <td>".$fila['Observaciones']."</td>
                        <td><a data-toggle='modal' data-target='#TareaMov' class='btn btn-danger'
                          data-id_tarea=".$fila['idt']."
                          data-tarea_des=".$fila['tarea']."
                        ><span class='glyphicon glyphicon-new-window'></span></a></td>
                    </tr>
                    ";
                }
                ?>
            </table>
  </div>
</div>

<div class="box box-default">
  <div class="box-header  with-border">
    <h4 class="box-title">Atendidos</h4> 
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
        </button>
    </div>
  </div>
  <div class="box-body">
    <div class="table-responsive" >
      <div height="100px">
        
      
    <table class="table tables table-hover table-condensed" >
                <tr>
                    <th>ID</th>
                    <th>Tarea</th>
                    <th>Descripción</th>
                    <th>Fecha Programada</th>
                    <th>Estatus</th>
                    <th>Fecha Realizado</th>
                    <th>Fecha Reprogramado</th>
                    <th>Observaciones</th>
                    
                </tr>
                <?php

                $datos=mysqli_query($conexion,"SELECT t.ID as idt, t.tarea, t.fecha_programada, m.ID, m.estatus, m.fecha_realizado, m.Observaciones,t.mensaje, t.cod_area, m.fecha_reprogramado 
                  FROM mov_tarea m, tarea t
                 WHERE m.ID IN (SELECT ID
                                FROM (  SELECT MAX(ID) AS id, id_tarea, MAX(fecha_mov) as fecha
                                          FROM mov_tarea 
                                      GROUP BY id_tarea) a)
                AND t.ID=m.ID_tarea AND t.usuario_asignado='$usuario' AND m.estatus='REALIZADO' ORDER BY t.ID desc
                LIMIT 100
                ");

                while ($fila=mysqli_fetch_array($datos)) {
                  
                    echo "
                    <tr>
                        <td>".$fila['idt']."</td>
                        <td>".$fila['tarea']."</td>
                        <td>".$fila['mensaje']."</td>
                        <td>".$fila['fecha_programada']."</td>
                        <td>".$fila['estatus']."</td>
                        
                        <td>".$fila['fecha_realizado']."</td>
                        <td>".$fila['fecha_reprogramado']."</td>
                        <td>".$fila['Observaciones']."</td>
                        
                    </tr>
                    ";
                }
                ?>
            </table>
            </div>
    </div>
  </div>
</div>

<!--inician modales -->
   <!--rango Fechas --------------------------------------------------------------- --> 
   <div class="modal fade" id="rangoFechas">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rango de fechas</h4>
              </div>
              <div class="modal-body">
                <!-- Inicia el data picker -->
                <form action="views/tarea_excel.php" method="GET">
                  <input type="text" name="area" style="display: none;" value="<?php echo $area; ?>"  >
                  <input type="text" name="pais" style="display: none;" value="<?php echo $pais; ?>">
                  <input type="text" name="usuario" style="display: none;" value="<?php echo $usuario; ?>">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" class="form-control pull-right" id="fecha1" name="fecha1" value="<?php echo date("Y-m-d");?>">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" class="form-control pull-right" id="fecha2" name="fecha2" value="<?php echo date("Y-m-d");?>">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Procesar</button>
                </form>
                <!-- /.Data picker finaliza-->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <!--Finaliza modal rango de fechas ----------------------------------------------------------->
  <!--rango Fechas --------------------------------------------------------------- --> 
   <div class="modal fade" id="rangoFechas_e">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Enviar tareas</h4>
              </div>
              <div class="modal-body">
                <!-- Inicia el data picker -->
                <form action="tarea_envia.php" method="GET">
                  <span>Se enviará link para descargar reporte en Excel según fecha seleccionada a los correos pedro.pineda@interamercon.com y jose.zan@interamercon.com.</span>
                  <hr>
                   <input type="text" name="area" style="display: none;" value="<?php echo $area; ?>"  >
                  <input type="text" name="pais" style="display: none;" value="<?php echo $pais; ?>">
                  <input type="text" name="usuario" style="display: none;" value="<?php echo $usuario; ?>">
                <div class="row">
                    <div class="col-md-5">
                      <label>Del:</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" class="form-control pull-right" id="fecha1" name="fecha1" value="<?php echo date("Y-m-d");?>">
                        </div>
                    </div>
                    <div class="col-md-5">
                      <label>Al:</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" class="form-control pull-right" id="fecha2" name="fecha2" value="<?php echo date("Y-m-d");?>">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Procesar</button>
                </form>
                <!-- /.Data picker finaliza-->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <!--Finaliza modal rango de fechas ----------------------------------------------------------->
         <!-- /.Movimientos tareas -->
         <div class="modal" id="TareaMov" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Movimiento</h4>
              </div>
              <div class="modal-body">
                <!-- Inicia el data picker -->
                <form  method="POST">
                  <div class="form-group">
                    <label for="id_tarea">ID:</label>
                    <input type="text" name="id_tarea" id="id_tarea" readonly="" class="form-control">
                  </div>
                  
                  <div class="form-group">
                    <label for="status">Cambiar Estatus:</label>
                     <select id="status" name="status" onchange="fecha();" class="form-control">
                         <option value="REALIZADO">Realizado</option>
                         <option value="REPROGRAMAR">Reprogramar</option>
                         <option value="DESCARTADO">Descartado</option>
                     </select>
                  </div>
                  <div id="fecha" style="display: none;">
                    <div class="form-group">
                      <label for="date">Fecha a reprogramar: </label>
                      <input  type="date" name="fecha_r" id="fecha_r" placeholder="Fecha Programada" value="<?php echo date("Y-m-d");?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="obs">Observaciones:</label>
                    <textarea name="obs" id="obs" placeholder="Observaciones" class="form-control"></textarea>
                  </div>
                  <div class="row">
                          <div class="form-group">
                           
                           <div class="col-md-2">
                            <label for="date">Fecha:</label>
                             <div class="input-group date">
                               <div class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </div>
                                <input required="" type="date" name="date_i" id="date_i" placeholder="Fecha Programada" class="form-control" value="<?php echo date("Y-m-d");?>"> 
                           </div>
                           </div>
                        </div>
                        </div>
                   <button  class="btn btn-primary pull-rigth" onclick="atendido();" data-dismiss="modal">Procesar</button>
                </form>
               
                <!-- /.Data picker finaliza-->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.Finaliza movimiento tarea -->
        <!-- /.Inicia nueva tarea -->
        <div class="modal" id="nuevaTarea">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva Tarea</h4>
              </div>
              <div class="modal-body">
                <!-- Inicia el data picker -->
                 <FORM action="" method="POST"  >
                    <div class="box-body">
                        <div class="form-group">
                            <textarea placeholder="Descripción Tarea" name="tarea" id="tarea" class="form-control"></textarea>
                        </div>
                        <div class="row">
                          <div class="form-group">
                           <label>Fecha programada:</label>
                           <div class="col-md-2">
                             <div class="input-group date">
                               <div class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </div>
                                <input required="" type="date" name="date" id="date" placeholder="Fecha Programada" class="form-control" value="<?php echo date("Y-m-d");?>"> 
                           </div>
                           </div>
                        </div>
                        </div>
                        
                        
                    </div>
                    <div class="modal-footer">
               <button type="reset"  data-dismiss="modal" onclick="guarda();" class="btn btn-success">Guardar</button>
              </div>
                </FORM>       
                <!-- /.Data picker finaliza-->
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->  
<script >
    function fecha(){
        var lista = document.getElementById("status");
        var valorSeleccionado = lista.options[lista.selectedIndex].value;
        var valorSeleccionado = lista.options[lista.selectedIndex].text;
         if (valorSeleccionado=='Reprogramar') {
            document.getElementById('fecha').style.display='block';
         }else {
             document.getElementById('fecha').style.display='none';
         }
    };
    $('#TareaMov').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var dato0 = button.data('id_tarea')
      var dato1 = button.data('tarea_des')

      var modal = $(this)
      modal.find('.modal-body #id_tarea').val(dato0)
      modal.find('.modal-body #tarea_des').val(dato1)
    });

   
</script>