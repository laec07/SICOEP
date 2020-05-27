function lista_usuarios(){
	$.ajax({
		url:"../../views/usuario_lista.php",
		type:"POST",
		data:{},
		success: function(data){
			$("#general_usuarios").html(data);
			
		}
	})
}

function show_permission(usuario) {
	$.ajax({
		url:"../../views/usuario_permisos.php",
		type:"POST",
		data:{usuario:usuario},
		success: function(data){
			document.getElementById("show_permission_").innerHTML=data;
		}
	})
}

function checkbox(no,usuario,id_canal){
	if($("#check_"+no).is(':checked')) {
		var accion='add';
      $.ajax({
		url:"../../modelos/usuario_permisos.php",
		type:"POST",
		data:{id_canal:id_canal,usuario:usuario,accion:accion},
		success: function(data){
			
		}
	})
    } else {
    	var accion='delete';
      $.ajax({
		url:"../../modelos/usuario_permisos.php",
		type:"POST",
		data:{id_canal:id_canal,usuario:usuario,accion:accion},
		success: function(data){
			
		}
	})
    }
}

function permisosApp(no,usuario,id_permiso){
	if($("#checkapp_"+no).is(':checked')) {
		var accion='add';
      $.ajax({
		url:"../../modelos/usuario_permisosApp.php",
		type:"POST",
		data:{id_permiso:id_permiso,usuario:usuario,accion:accion},
		success: function(data){
			
		}
	})
    } else {
    	var accion='delete';
      $.ajax({
		url:"../../modelos/usuario_permisosApp.php",
		type:"POST",
		data:{id_permiso:id_permiso,usuario:usuario,accion:accion},
		success: function(data){
			
		}
	})
    }
}



function bpermisos_usuario(){
var usuario2 = document.getElementById('lista_usuario').value

	$.ajax({
		url:"../../views/usolo_permisos.php",
		type:"POST",
		data:{usuario:usuario2},
		success: function(data){
			$("#permisosApp").html(data);
		}
	})
}

function fotoUsuario_guarda(){
	event.preventDefault();
	var usuario_f=document.getElementById('usuario_f').value

	
	var dato_archivo = $('#imagen').prop("files")[0];
	var form_data = new FormData();
	form_data.append("imagen", dato_archivo);
	form_data.append("usuario_f",usuario_f)
	/*var frmdata = new FormData;
	frmdata.append("imagen",$("#imagen")[0].files[0]);*/

	$.ajax({
		url:"../../consultas/fotos_usuarios.php",
		type:"POST",
		data:form_data,
		processData:false,
		contentType:false,
		cache:false,
		beforeSend:function(data){
			
		},
		success: function(data){
			lista_usuarios()
		}
	})

	}
