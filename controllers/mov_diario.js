function resumen_mov(){
	var sede = document.getElementById('sede').value
	var del = document.getElementById('del').value
	var al = document.getElementById('al').value
	$.ajax({
		url:"../../views/mov_diario_resumen.php",
		type:"POST",
		data:{sede:sede,del:del,al:al},
		beforeSend: function(){
			$("#datos").html('');
		},
		success: function(data){
			$("#resumen").html(data);
		}
	})
}


function lista_mov(placa) {
	var sede = document.getElementById('sede').value
	var del = document.getElementById('del').value
	var al = document.getElementById('al').value

	$.ajax({
		url:"../../views/mov_diario_lista.php",
		type:"POST",
		data:{sede:sede,del:del,al:al,placa:placa},
		success: function(data){
			$("#datos").html(data);
		}
	})
}