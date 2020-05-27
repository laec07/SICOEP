function permisos_usarios(usuario) {
	$.ajax({
		url:"models/permisos_menu.php",
		data:{usuario:usuario},
		type:"POST",
		success:function(data){
			$("#datos_menu").html(data);
		}
	})
}