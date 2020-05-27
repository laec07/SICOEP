<?php
 include ("../conexion.php");


 /////////////////////////////////////////////
$canal=mysqli_query($conexion,"SELECT * FROM canal where estado='A'");
///////////////////////////////////////////////////////

//////////////////////////////////////////////////////

 ?>
            <label>Canal:</label>
            <select class="form-control" name="parameter" id="parameter">
              <option>TODOS</option>
              <?php
                while ($fila_canal=mysqli_fetch_array($canal)) {
                  if ($fila_canal['canal']=='MASIVO') {
                   
                  }
                  echo "
                    <option value=".$fila_canal['canal']." >".$fila_canal['canal']."</option>
                  ";
                }
              ?>
            </select>