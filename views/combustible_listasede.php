<?php
 include ("../conexion.php");
session_start();

$pais=$_SESSION['usuario']['codigo_pais'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);
 /////////////////////////////////////////////
$Result=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais' and usa_vehi='S'" );
///////////////////////////////////////////////////////

//////////////////////////////////////////////////////


 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>

 </head>
 <body>
 <label>Sede:</label>
    <select class="form-control select2" style="width: 100%;" data-style="btn-info" name="parameter" id="parameter" multiple="multiple" >
        <option selected>TODOS</option>
    <?php 
	      while($fila=mysqli_fetch_row($Result)){
	        echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
	        }
	    ?>
	</select>

<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
	$('.select2').select2()
</script>
 </body>
 </html>
 			