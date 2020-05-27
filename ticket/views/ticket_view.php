<?php
include("../../conexion.php");
session_start();
$id=$_POST['id'];
$pais=$_SESSION['usuario']['codigo_pais'];
$sn=mysqli_query($conexion,"SELECT count(ID) as total FROM tarea where (estatus ='SIN ATENDER' or estatus ='PENDIENTE' ) and codigo_pais='$pais'");
$tl=mysqli_fetch_array($sn);
$total=$tl['total'];
?>
<button class="btn btn-primary" onclick="ticket_open();" >Nuevo Ticket</button><br>
<div class="alert alert-success alert-dismissible" >

    <h4><i class="icon fa fa-check"></i> Ticket #<?php echo $id ?></h4>
    Ticket #<?php echo $id ?> ingresado correctamente, a la brevedad personal del departamento de sistemas te estará brindado apoyo.
</div>

<div class="box">
  <div class="box-header  with-border">
    <h4 class="box-title">Descripción Ticket</h4> 
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
        </button>
    </div>
  </div>
  <div class="box-body">
    <?php
     $sin_asignar=mysqli_query($conexion,"SELECT t.ID,t.tarea,m.fecha_mov,a.tipo_tarea,t.email,t.mensaje,t.prioridad,t.solicitante,t.estatus FROM tarea t,mov_tarea m,tipo_tarea a WHERE t.ID=m.ID_tarea AND t.id_tipotarea=a.id_tipotarea AND m.ID_tarea='$id' ");

    $fila_sin=mysqli_fetch_array($sin_asignar);
    ?>
    <h4><b> <?php echo $fila_sin['tarea'] ;?> </b></h4>
    <div class="help-block">
     <small> <b>#: </b><?php echo $fila_sin['ID'] ;?> | 
              <?php echo $fila_sin['fecha_mov'] ;?> | 
              <?php echo $fila_sin['solicitante'] ;?> |
              <?php echo $fila_sin['tipo_tarea'] ;?>
      </small>
    </div>
    <div class="box box-success">
      <h3>Descripción: </h3>
      <?php echo $fila_sin['mensaje'] ;?>
    </div>
    <b>Estado: </b><?php echo $fila_sin['estatus'] ;?>
  </div>
</div>

<?php
if ($total>0) {
?>
<div class="alert alert-danger col-md-6">
  Existen <?php echo $total; ?> Ticket en proceso, suplicamos su paciencia.
</div>
<?php
}
?>