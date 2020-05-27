//Muestra rutas masivo para pago deducible
function datos_deducible() {
	$.ajax({
		url:"../../views/deducible_datos.php",
		type:"POST",
		dataType:"html",
		data:{},
		beforesend: function(){

		},
		success: function(data){
			$("#datos").html(data);
		}
	})
}

function deducible_guarda_pago(){
	var placa = document.getElementById('placa').value;
	var ruta = document.getElementById('ruta').value;
	var id_ruta = document.getElementById('id_ruta').value;
	var id_depto = document.getElementById('id_depto').value;
	var mes = document.getElementById('mes').value;
	var monto = document.getElementById('monto').value;
	var descripcion = document.getElementById('descripcion').value;

	$.ajax({
		url:"../../consultas/deducible_guarda_pago.php",
		type:"POST",
		dataType:"html",
		data:{placa:placa,ruta:ruta,id_ruta:id_ruta,id_depto:id_depto,mes:mes,monto:monto,descripcion:descripcion},
		beforesend:function(){

		},
		success: function(data){
			datos_deducible();
		}
	})
}
