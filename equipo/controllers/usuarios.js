function lista_usuarios(){
	$.ajax({
		url:"views/usuario_lista.php",
		type:"POST",
		data:{},
		success: function(data){
			$("#general_usuarios").html(data);
			
		}
	})
}

function lista_usuariosPaises(){
	$.ajax({
		url:"views/usuario_listaPaises.php",
		type:"POST",
		data:{},
		success: function(data){
			$("#general_usuarios").html(data);
			
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
		url:"models/usuario_fotos.php",
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

function usuario_guarda(){
	var nombre = document.getElementById('nombre').value;
	var usuario = document.getElementById('usuario').value;
	var correo = document.getElementById('correo').value;
	var clave = document.getElementById('clave').value;
	var tipo = document.getElementById('tipo').value;
	var estado = document.getElementById('estado').value;

	$.ajax({
		url:"models/usuario_guarda.php",
		type:"POST",
		data:{nombre:nombre,usuario:usuario,correo:correo,clave:clave,tipo:tipo,estado:estado},
		success: function(data){
			if (!data.success) {
                    //Imprime mensaje de JSON
                      alert( data.message );
            }else{
               
			lista_usuarios();
			$('#alert_insert').show("slow")
			setTimeout(function(){ $('#alert_insert').hide("slow"); }, 1500);
            }
            
			
		}
	})
}

function usuario_edita(){
	var nombre = document.getElementById('nombre_e').value;
	var usuario = document.getElementById('usuario_e').value;
	var correo = document.getElementById('correo_e').value;
	var clave = document.getElementById('clave_e').value;
	var tipo = document.getElementById('tipo_e').value;
	var estado = document.getElementById('estado_e').value;

	$.ajax({
		url:"models/usuario_edita.php",
		type:"POST",
		data:{nombre_e:nombre,usuario_e:usuario,correo_e:correo,clave_e:clave,tipo_e:tipo,estado_e:estado},
		success: function(data){
			if (!data.success) {
                    //Imprime mensaje de JSON
                      alert( data.message );
            }else{
			lista_usuarios();
			$('#alert_update').show("slow")
			setTimeout(function(){ $('#alert_update').hide("slow"); }, 1500);
            }
            
			
		}
	})
}

function usuario_editaPais(){
	var nombre = document.getElementById('nombre_e').value;
	var usuario = document.getElementById('usuario_e').value;
	var tipo = document.getElementById('tipo_e').value;
	var cod_pais_e = document.getElementById('cod_pais_e').value;

	$.ajax({
		url:"models/usuario_editaPais.php",
		type:"POST",
		data:{nombre_e:nombre,usuario_e:usuario,tipo_e:tipo,cod_pais_e:cod_pais_e},
		success: function(data){
			if (!data.success) {
                    //Imprime mensaje de JSON
                      alert( data.message );
            }else{
			lista_usuariosPaises();
			$('#alert_update').show("slow")
			setTimeout(function(){ $('#alert_update').hide("slow"); }, 1500);
            }
            
			
		}
	})
}

function bpermisos_usuario(){
var usuario2 = document.getElementById('lista_usuario').value

	$.ajax({
		url:"views/usuario_listpermisos.php",
		type:"POST",
		data:{usuario:usuario2},
		success: function(data){
			$("#permisosApp").html(data);
		}
	})
}

function permisos_addless(no,usuario,id_permiso){
	if($("#checkapp_"+no).is(':checked')) {
		var accion='add';
      $.ajax({
		url:"models/usuario_Permisosaddless.php",
		type:"POST",
		data:{id_permiso:id_permiso,usuario:usuario,accion:accion},
		success: function(data){
			
		}
	})
    } else {
    	var accion='delete';
      $.ajax({
		url:"models/usuario_Permisosaddless.php",
		type:"POST",
		data:{id_permiso:id_permiso,usuario:usuario,accion:accion},
		success: function(data){
			
		}
	})
    }
}