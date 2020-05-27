$(document).on("change","#select_sede", function() {
	var sede = $("#select_sede").val();

	$.ajax({
		url:"../../views/vehi_listaplacas.php",
		type:"POST",
		data:{sede:sede},
		beforeSend: function(){
			$('#select_placa').html("<img src='../../dist/images/loading1.gif' width='50px' >");
			//document.getElementById("select_placa").innerHTML="<img src='../../dist/images/loading1.gif' width='50px' >"
		},
		success: function(data){
			$('#select_placa').html(data);
		}
	})
})

function lista_hllantas(){
	var placa = document.getElementById('lst_placas').value;
	$.ajax({
		url:"../../views/vehi_hllantas.php",
		type:"POST",
		data:{placa:placa},
		beforeSend: function(){
			$('#hllantas').html("<img src='../../dist/images/loading4.gif' width='50px' >");
			
		},
		success: function(data){
			$('#hllantas').html(data);
		}
	})
}