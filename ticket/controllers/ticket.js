//Trae formulario para ingresar ticket
function ticket_open() {
	$.ajax({
		url:"views/ticket_open.php",
		type:"POST",
		dataType:"html",
		data:{},
		beforeSend: function(){
			document.getElementById("datos").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"
		},
		success: function (data){
			
			$("#datos").html(data); 
		}
	})
}

//Guarda ticket
function ticket_save(mensaje_e) {
	var pais = document.getElementById('pais').value;
	var categoria = document.getElementById('categoria').value;
	var descripcion = document.getElementById('descripcion').value;
	var solicitante = document.getElementById('solicitante').value;
	var mail_e = document.getElementById('mail').value;
	var priory = document.getElementById('priory').value;
	var usuario_solicita = document.getElementById('usuario_solicita').value;
	//Obtiene el valor utilizado por CKEDITOR, sin esto el textarea no pasa nada
	var mensaje = CKEDITOR.instances['mensaje'].getData() 
	var depto = document.getElementById('depto').value;
	
	var error=0;
  	$("div").removeClass("has-error");//obligado en todos
	$( ".help-block").hide("slow");//obligado en todos	

if (depto=='Seleccione Sede/Tienda') {
  //si no se selecciona muestra mensaje
    $('#sede_error').show("slow");
    $("#sede_error").text('* Seleccione Sede/Tienda valido ')
    $('#sede_f').addClass("has-error")
   error=error+1; 
}

if (solicitante=="") {
	  //si no se selecciona muestra mensaje
$('#nombre_error').show("slow");
$("#nombre_error").text('* Campo obligatorio ')
$('#nombre_f').addClass("has-error")
error=error+1; 
}

//valida que campo correosea correcto: ejemplo@corre.com
/*  Se utiliza para validar correo, pero se extra de la bd ahora
var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
if (regex.test($('#mail').val().trim())) {      
    } else {
$('#mail_error').show("slow");
$("#mail_error").text('Ingrese email valido ejemplo@correo.com ')
$('#mail_f').addClass("has-error")
error=error+1; 
}*/

	if (error==0) {

		
		$.ajax({
			url:"models/ticket_save.php",
			type:"POST",
			dataType:"html",
			data:{pais:pais,categoria:categoria,descripcion:descripcion,
				solicitante:solicitante,mail_e:mail_e,priory:priory,
				mensaje:mensaje,depto:depto,usuario_solicita:usuario_solicita},
					beforeSend: function(){
			document.getElementById("datos").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"
		},
			success: function (data){
				ticket_view(data);
				 
			}
		})	
	}
			
}

//Muestra ticket guardado
function ticket_view(id){
	$.ajax({
		url:"views/ticket_view.php",
		type:"POST",
		dataType:"html",
		data:{id:id},
		success: function (data){
			$("#datos").html(data); 
		}
	})
}

//Muestra pagina historial ticket
function ticket_history() {
	$.ajax({
		url:"views/ticket_history.php",
		type:"POST",
		dataType:"html",
		data:{},
		beforeSend: function(){
			document.getElementById("datos").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"
		},
		success: function (data){
			
			$("#datos").html(data); 
		}
	})
}

//Muestra datos historial ticket según fecha
function ticket_history() {
var fecha = document.getElementById('mes_busqueda').value;
//extrae año y mes de fecha que trae formato yyyy-mm
var year = fecha.slice(0,4);
var month = fecha.slice(5,7)
	$.ajax({
		url:"views/ticket_history.php",
		type:"POST",
		dataType:"html",
		data:{year:year,month:month},
		beforeSend: function(){
			document.getElementById("data_ticket").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"
		},
		success: function (data){
			
			$("#datos").html(data); 
		}
	})
}

