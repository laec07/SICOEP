<?php
include("../../conexion.php");
session_start();
//////////////////////////////////////////////////
$pais=$_SESSION['usuario']['codigo_pais'];
$depto=$_SESSION['usuario']['Id_depto'];
$ps=mysqli_query($conexion, "SELECT * FROM pais where codigo_pais='$pais'");
$rps=mysqli_fetch_array($ps);

?>
<div id="mostrardatos"></div>
        <div class="box box-danger ">
          <div class="box-header">
            <div class="row">
              <div class="col-md-3">
                <h4 class="box-title">Aprobados <small><?php  ?></small></h4>
              </div>
              <div class="col-md-3">
                <h4>Total:</h4><?php echo $rps['moneda']; ?><label id="show_total"></label>
              </div>
              <div class="col-md-3">
                <h4>Galones:</h4><label id="show_galones"></label>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="input-group">
                  <input type="month" id="mes_busqueda" value="<?php echo date("Y-m") ?>">
                  
                    <button class="btn btn-primary"  onclick="solicitudes_aprobadas();"><span class="fa fa-search"></span></button>
                  
                </div>
                    
                </div>
                
            </div>
             
             <div id="solicitudes_aprobadas">
               
             </div> 
           

          </div>
        </div>

<script>
	solicitudes_aprobadas();
</script>