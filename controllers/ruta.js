//Muestra las rutas
function ruta_muestra() {
	$.ajax({
		url:"../../views/ruta_listarutas.php",
		type:"POST",
		dataType:'html',
		data:{},
		beforeSend: function(){
              document.getElementById("lista_rutas").innerHTML="<img src = '../../dist/images/loading4.gif' width='50px'  >"
            },
		success: function(data){
			 $("#lista_rutas").html(data);
		}
	})
}
ruta_muestra();
//guarda la nueva ruta
function rutas_rutanuevo() {
	  //evita submit formulario
  		event.preventDefault();
	var ruta = document.getElementById("ruta_n").value;
	var sede = document.getElementById("depto_n").value;
	var canal= document.getElementById('tipo_canal').value
	
	$.ajax({
		url:"../../consultas/rutas_rutanuevo.php",
		type:"POST",
		dataType:'html',
		data:{ruta:ruta,sede:sede,canal:canal},
		success: function(){
			ruta_muestra();
		}
	})
}
//Edita ruta
function rutas_rutaedita() {
	  //evita submit formulario
  		event.preventDefault();
  	var id_ruta = document.getElementById("id_ruta_e").value
	var ruta = document.getElementById("ruta_e").value;
	var sede = document.getElementById("depto_e").value;
	var canal= document.getElementById('tipo_canal_e').value
	
	$.ajax({
		url:"../../consultas/rutas_rutaedita.php",
		type:"POST",
		dataType:'html',
		data:{id_ruta:id_ruta,ruta:ruta,sede:sede,canal:canal},
		success: function(){
			ruta_muestra();
		}
	})
}

function rutas_restablece(id_ruta){

var a = confirm('¿Realmente desea restablecer galones disponibles según lo asignado?')
if (a==true) {
	$.ajax({
		url:"../../consultas/rutas_rutarestablece.php",
		type:"POST",
		dataType:"html",
		data:{id_ruta:id_ruta},
		success: function(){
			location.reload(true);
		}
	})
}else{

}
	
}

function ruta_listarutasasignadas(){
	$.ajax({
		url:"../../views/ruta_listarutasasignadas.php",
		type:"POST",
		dataType:"html",
		data:{},
		success:function(data){
			
		}
	})
}

function show_frecuencias(){
	var ruta = document.getElementById('ruta_fs').value;
	$.ajax({
		url:"../../views/ruta_frecuencias.php",
		type:"POST",
		dataType:"html",
		data:{ruta:ruta},
		success:function(data){
			$("#lista_frecuencia").html(data);
		}
	})
}

$(document).on("click","#add_frecuencia", function(){
	var n_f = $("#nombre_frecuencia").text();
	var km_f = $("#km_frecuencia").text();
	var cl_f = $("#clientes_frecuencia").text();
	var r_f = $("#reccorrido_frecuencia").text();

	var ruta = document.getElementById('ruta_fs').value

	if ((n_f=="") || (km_f=="") || (cl_f=="")) {
		$('#error_frecuencia').addClass("danger")
		alert("Inserte datos por favor!!.")
		setTimeout(function(){ $('#error_frecuencia').removeClass("danger"); }, 3000);
	}else{
		$.ajax({
			url:"../../consultas/ruta_frecuencias_inserta.php",
			type:"POST",

			data:{n_f:n_f,km_f:km_f,cl_f:cl_f,ruta:ruta,r_f:r_f},
			success:function(data){

				if( !data.success ){
	                  //Como el JSON trae un mensaje, lo puedes imprimir
	                  alert( data.message );
	              }

	              else{
	                  //Si te regresa un TRUE entonces ya puedes recargar
	                  $('#alert_insert').show("slow")
					setTimeout(function(){ $('#alert_insert').hide("slow"); }, 1500);
	                  show_frecuencias()
	                  
	              }
				
			}
		})		
	}

	
})

function del_frecuencia(ruta,frecuencia,pais){
	$.ajax({
		url:"../../consultas/ruta_frecuencias_delete.php",
		type:"POST",
		dataType:"html",
		data:{ruta:ruta,frecuencia:frecuencia,pais:pais},
		success:function(data){
			
			show_frecuencias()
			$('#alert_delete').show("slow")
			setTimeout(function(){ $('#alert_delete').hide("slow"); }, 1500);
		}
	})
}

function edit_frecuencia(ruta,texto,frec,campo,pais){
	$.ajax({
		url:"../../consultas/ruta_frecuencias_edita.php",
		type:"POST",
		dataType:"html",
		data:{ruta:ruta,texto:texto,frec:frec,campo:campo,pais:pais},
		success:function(data){
			
			show_frecuencias()
			
		}
	})	
}

$(document).on("blur","#nfrecuencia_e", function(){
	var ruta = $(this).data("ruta");
	var frec = $(this).data("frec");
	var pais = $(this).data("pais");
	var texto = $(this).text();

	edit_frecuencia(ruta,texto,frec,"frecuencia",pais)
})

$(document).on("blur","#kmfrecuencia_e", function(){
	var ruta = $(this).data("ruta");
	var frec = $(this).data("frec");
	var pais = $(this).data("pais");
	var texto = $(this).text();

	edit_frecuencia(ruta,texto,frec,"km",pais)
})

$(document).on("blur","#clfrecuencia_e", function(){
	var ruta = $(this).data("ruta");
	var frec = $(this).data("frec");
	var pais = $(this).data("pais");
	var texto = $(this).text();

	edit_frecuencia(ruta,texto,frec,"clientes",pais)
})

$(document).on("blur","#rfrecuencia", function(){
	var ruta = $(this).data("ruta");
	var frec = $(this).data("frec");
	var pais = $(this).data("pais");
	var texto = $(this).text();

	edit_frecuencia(ruta,texto,frec,"recorrido",pais)
})

function listafreRutas(ruta,pais){
	$.ajax({
		url:"../../views/rutas_listafre.php",
		type:"POST",
		dataType:"html",
		data:{ruta:ruta,pais:pais},
		beforeSend: function(data){

		},
		success:function(data){
			
			$("#listafreRutas").html(data)
			
		}
	})	
} 