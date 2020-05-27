<?php
include ("../../conexion.php");
session_start();
if (!$_SESSION){
echo '<script language = javascript>
alert("Su sesión ha expirado")
self.location = "login"
</script>';
}
  //Obtiene la IP del cliente
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    $ip="mi.ip.";
        $new_ip=get_client_ip();


    //Obtiene la info de la IP del cliente desde geoplugin

    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }
//tra ip encontrada en la funcion
 $t=ip_info();
error_reporting(0);
//convierte los datos a json
$array = json_encode($t);
//transforma datos array para utilizarse
$info = json_decode($array);
//se almacena pais en la variable
$pais=$info->country;
//se almacena codigo pais en la variable
$codigo_pais=$info->country_code;
//se extra los datos del pais
/*$bdtos=mysqli_query($conexion,"SELECT codigo_pais,pais FROM pais WHERE country_code='$cpaisU'");
$dts=mysqli_fetch_array($bdtos);
$c_pais=$dts['codigo_pais'];*/

$nombre= $_SESSION['usuario']['NOMBRE'];
$correo=$_SESSION['usuario']['correo'];
$usuario_solicita=$_SESSION['usuario']['USUARIO'];
$cpaisU= $_SESSION['usuario']['codigo_pais'];

$bdtos=mysqli_query($conexion,"SELECT codigo_pais,pais FROM pais WHERE codigo_pais='$cpaisU'");
$dts=mysqli_fetch_array($bdtos);
$c_pais=$dts['codigo_pais'];
$cu_pais=$dts['pais'];


?>
<div class="box">

    <div class="box-header with-border box-danger">
        <h4 class="box-tittle" >Abrir Ticket</h4>         
        
    </div>

    <div class="box-body col-xs-12 main-content">
        <form enctype="multipart/form-data" class="form-horizontal" role="form">
                        <div class="form-group">
                

                
            </div>
            <div class="form-group">
                <!--Se oculta porque por default llevara el usuario que solicita-->
                <label class="col-sm-3 control-label"  >Solicitante:</label>
                <!--<label class="col-sm-3 control-label"  >Dirección Email:</label>-->
                <div class="col-sm-4" id="nombre_f">
                    <div  id="mail_f">
                        <input type="email" name="mail" id="mail" maxlength="50" class="form-control" required="" value="<?php echo $correo ?>"  readonly="" style="display: none;" >
                        <span style="display: none;" class="help-block" id="mail_error"></span>
                    </div>
                    <input type="text" name="usuario_solicita" id="usuario_solicita" value="<?php echo $usuario_solicita ?> "  style="display: none;" >
                    <input type="text" name="solicitante" id="solicitante" maxlength="50"  value="<?php echo $nombre ?> " class="form-control" required="" name="soli" readonly="" >
                    <span style="display: none;" class="help-block" id="nombre_error"></span>
                </div>
                <label class="col-sm-2 control-label"  >Pais:</label>
                <div class="col-sm-2">
                    
                    <input type="text" name="ps" id="ps" class="form-control" readonly="" value="<?php echo $cu_pais ?>"  >
                    <input type="text" name="pais" id="pais" readonly="" class="form-control" value="<?php echo $cpaisU ?> "  style="display: none;">
                </div>
                
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3">Sede/Tienda:</label>
                <div class="col-sm-3" id="sede_f">
                    <select  name="depto"  id="depto" class="form-control ">
                        <option>Seleccione Sede/Tienda</option>
                        <!--<option value="4010">Chimaltenango</option>-->
                        
                    <?php $sede=mysqli_query($conexion,"SELECT * FROM depto WHERE codigo_pais='$cpaisU' and usa_compu='S' ORDER BY Tipo "); 
                        while ($row=mysqli_fetch_row($sede)) {
                            echo "
                                <option value=".$row[0].">".$row[1]."</option>
                            ";
                        }
                    ?> 
                    </select>
                    <span style="display: none;" class="help-block" id="sede_error"></span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label"  >Asunto:</label>
                <div class="col-md-9">
                    <input type="text" name="descripcion" id="descripcion"  class="form-control" name="descripcion" maxlength="100" required="">
                </div>
                
            </div>
            <hr>
            <div class="form-group">
                <label class="col-sm-3 control-label"  >Tipo falla:</label>
                <div class="col-md-2">
                    <select  name="categoria" id="categoria"   class="form-control"  name="categoria">
                    <?php
                        $tarea=mysqli_query($conexion,"SELECT * FROM tipo_tarea ");
                        while ($fila_tarea=mysqli_fetch_row($tarea)) {
                            echo "
                            <option value=".$fila_tarea[0].">".$fila_tarea[1]."</option>
                            ";
                        };
                    ?>
                    </select>
                </div>
                
            </div>
            
            <div class="form-group">
                <!--<label class="col-sm-3 control-label"  >Prioridad:</label>-->
                <div class="col-md-2">
                    <select type="text" name="priory" id="priory" maxlength="50" class="form-control" value='MEDIA' style="display: none;" >
                        <option>ALTA</option>
                        <option selected="selected">MEDIA</option>
                        <option>BAJA</option>
                    </select>
                </div>
                
            </div>
        
            <div class="form-group">
                <label class="col-sm-3 control-label"  >Mensaje:</label>
                <div class="col-md-9">
                    <textarea name="mensaje" id="mensaje" maxlength="255" class="form-control"  > </textarea>
                </div>
                
            </div>
            <hr>
            <!--
            <div class="form-group">
                <label class="col-sm-3 control-label" >Adjuntos:</label>
                <div class="col-md-9">
                    <input type="file" name="adjunto"  class="form-control">
                </div>
            </div>
        	-->
    </div>
    <div class="box-footer">
        <button class="btn btn-primary pull-right" onclick="ticket_save();" >Generar ticket</button>
        <br>
    </div>
    </form>
</div>
<!-- ckeditor -->
<script src="../plugins/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replace("mensaje");


</script>