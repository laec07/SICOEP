<?php
include ("../conexion.php");
$placa=$_POST['placa'];

$vehi=mysqli_query($conexion,"SELECT
  ID,
  id_equipo,
  foto1,
  fecha
FROM
  foto_vehi
WHERE
  id_equipo = '$placa'
ORDER BY
  fecha");
?>


	<div class="row">

	  <?php 
	    while ($fila=mysqli_fetch_row($vehi)) {
	      echo "
	      <div class='col-md-2'>
		      <a href='../../consultas/".$fila[2]."' data-lightbox='roadtrip'>  
		      	<img class='img-thumbnail' src=../../consultas/".$fila[2]."  WIDTH=141 HEIGHT=105.75>
		      </a><br>
		      <a onclick=\"comparar('../../consultas/".$fila[2]."')\">
		      	<span class='fa fa-eye'></span>
		      </a>
		      <small>".date_format (new DateTime($fila[3]), 'd-m-Y')."</small>
		      <a href='../../consultas/elimina_foto_vehi.php?id=" .$fila[0] ."' onclick=\"return confirm('¿Desea elimiar foto?')\">
		      	<span class='fa fa-trash'></span>
		      </a>
	        </div>
	        ";
	      }

	  ?>
	</div>
