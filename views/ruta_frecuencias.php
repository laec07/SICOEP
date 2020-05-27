<?php
include ("../conexion.php");
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}
$pais=$_SESSION['usuario']['codigo_pais'];
$ruta=$_POST['ruta'];

$query=mysqli_query($conexion,"
SELECT
	*
FROM
	rutas_frecuencia
WHERE
	ruta = '$ruta'
AND codigo_pais = '$pais'
	");

if ($ruta=="Seleccione ruta") {

}else{


?>


<div class="row">

	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Frecuencia</th>
					<th>Clientes</th>
					<th>Kilometros</th>
					<th>Recorrido</th>
					<th></th>	
				</tr>
				
			</thead>
			<tbody>
		<?php
			$km=0;
			$cliente=0;
			while ($row=mysqli_fetch_array($query)) {
			
			echo "
				<tr>
					<td contenteditable='' data-frec='".$row['frecuencia']."' data-ruta='".$row['ruta']."' data-pais='".$pais."' id='nfrecuencia_e'>".$row['frecuencia']."</td>
					<td contenteditable='' data-frec='".$row['frecuencia']."' data-ruta='".$row['ruta']."' data-pais='".$pais."' id='kmfrecuencia_e'>".$row['km']."</td>
					<td contenteditable=''  data-frec='".$row['frecuencia']."' data-ruta='".$row['ruta']."' data-pais='".$pais."' id='clfrecuencia_e'>".$row['clientes']."</td>
					<td contenteditable=''  data-frec='".$row['frecuencia']."' data-ruta='".$row['ruta']."' data-pais='".$pais."' id='rfrecuencia'>".$row['recorrido']."</td>
					<td><a class='btn btn-defalut' onclick=\"del_frecuencia('".$row['ruta']."','".$row['frecuencia']."','".$pais."');  \"><span class='fa fa-trash'></span></a></td>
				</tr>
			";
			$km=$km+$row['km'];
			$cliente=$cliente+$row['clientes'];

			}

				
		?>
			
		
				<tr id="error_frecuencia" class="">
					<td  id="nombre_frecuencia" contenteditable="" ></td>
					<td id="km_frecuencia" contenteditable=""></td>
					<td id="clientes_frecuencia" contenteditable=""></td>
					<td id="reccorrido_frecuencia" contenteditable=""></td>
					<td ><a class="btn btn-info" id="add_frecuencia">Agregar </a></td>
				</tr>
			
			</tbody>
			<tfoot>
				<tr>
					<th>Total</th>
				<?php


				if ($km>0) {
					$gal=$km/60;
				}else{
					$gal=0;
				}
				
				echo "
					<th>".$km."</th>
					<th>".$cliente."</th>
				";	

				?>
				</tr>
				<tr >
					<td>Combustible recomendado por semanda</td>
				<?php
				echo "
					<td>".round($gal,2) ." Gal.</td>
				";
					
				?>
					
				</tr>

			</tfoot>
		</table>		
	</div>
	<div class="col-md-6">
		
	</div>
</div>
<?php
}
?>