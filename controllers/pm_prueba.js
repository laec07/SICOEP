function insert_data() {

	var id_usuario =document.getElementById('id_usuario').value
	
	$.ajax({

		url:"../../consultas/pm_insert_data.php",
		type:"POST",
		data:{id_usuario:id_usuario},
		beforeSend: function(){
			$("#content_test").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(datos){

			if (datos == 'F') {//no procesa si no se han restablecido galones a las rutas
              alert('Aspirante ya tiene asignado prueba, por favor editelo en pruebas pendientes');
             
    
            }else{//muestra solicitud procesada
              show_data(datos);
             
            }

		}
	})
}

function show_data(id){

	$.ajax({
		url:"../../views/pm_prueba.php",
		type:"POST",
		data:{id:id},
		beforeSend: function(){
			$("#content_test").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			$("#content_test").html(data);
		}
	})
}



function califica_insert(opcion,id_prueba,id_pregunta){
	$.ajax({
		url:"../../consultas/califica_insert.php",
		type:"POST",
		dataType:"html",
		data:{opcion:opcion,id_prueba:id_prueba,id_pregunta:id_pregunta},
		success:function(data){
			
			
			
		}
	})	
}

$(document).on("change", "#calificaP", function(){
    var id_prueba = $(this).data("id_prueba");
    var id_pregunta = $(this).data("id_pregunta");

    //obtiene fila selecciona y extra dato del select de esa fila       
    var opcion = $(this).parents("td").find('#calificaP').val();
    califica_insert(opcion,id_prueba,id_pregunta);

})

$(document).on("change", "#calificaP0", function(){
    var id_prueba0 = $(this).data("id_prueba0");
    var id_pregunta0 = $(this).data("id_pregunta0");

    //obtiene fila selecciona y extra dato del select de esa fila       
    var opcion0 = $(this).parents("td").find('#calificaP0').val();
    califica_insert(opcion0,id_prueba0,id_pregunta0);

})

function view_prev(id_prueba){
//muestra pantalla previa con datos obtenidos
	$.ajax({
		url:"../../views/pm_calificaPrev.php",
		type:"POST",
		dataType:"html",
		data:{id_prueba:id_prueba},
		beforeSend: function(){
			$("#content_test").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			$("#content_test").html(data);
		}
	})
}

//realiza todo el calculo de los resultados obtenidos
function save_prev(id_prueba){

	$.ajax({
		url:"../../consultas/pm_calificaprev.php",
		type:"POST",
		dataType:"html",
		data:{id_prueba:id_prueba},
		beforeSend: function(){
			$("#content_test").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success:function(data){
			
			view_prev(id_prueba);
		}
	})
}
//guarda definitivamente
function save_test(id_prueba){
	$.ajax({
		url:"../../consultas/pm_calificasave.php",
		type:"POST",
		dataType:"html",
		data:{id_prueba:id_prueba},
		beforeSend: function(){
			$("#content_test").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success:function(data){
			alert('Información guardada exitosamente!!!');
			body_test();
		}
	})

}

function body_test(){

	$.ajax({
		url:"../../views/pm_builds.php",
		type:"POST",
		dataType:"html",
		data:{},
		beforeSend: function(){
			$("#content_test").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success:function(data){
			$("#content_test").html(data);
		}
	})
}

body_test();

function delete_test(id){

	var preg = confirm ("¿Esta seguro de eliminar prueba ID  "+ id +"?")

	if (preg==true) {

		$.ajax({
			url:"../../consultas/pm_deletest.php",
			type:"POST",
			dataType:"html",
			data:{id:id},
			beforeSend: function(){
				$("#content_test").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
			},
			success:function(data){
				$("#content_test").html(data);
				body_test()
			}
		})
	}else{

	}
}

function contrata(id){

	var preg = confirm ("¿Esta seguro cambiar estado de aspirante a piloto?")

	if (preg==true) {

		$.ajax({
			url:"../../consultas/pm_contrata.php",
			type:"POST",
			dataType:"html",
			data:{id:id},
			beforeSend: function(){
				$("#content_test").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
			},
			success:function(data){
				$("#content_test").html(data);
				body_test()
			}
		})
	}else{

	}
}

