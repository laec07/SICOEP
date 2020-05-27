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
 			<label>Sede:</label>
            <select class="form-control" name="parameter_g" id="parameter_g">
              <option>TODOS</option>
               <?php 
                  while($fila=mysqli_fetch_row($Result)){
                    echo "<option value='".$fila['0']."'>".$fila['1']."</option>";
                    }
                ?>
            </select>
