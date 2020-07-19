function cont_header() {
	
	$.ajax({
		url:"../../views/pm_config_criterio.php",
		type:"POST",
		dataType:"",
		data:{},
		beforeSend: function(){
			$("#cont_header").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			$("#cont_header").html(data);
		}

	})
}
cont_header()

//edita 
function edita_criterio(){
	var id_criterio = document.getElementById('id_criterio').value
	var descripcion = document.getElementById('descripcion').value
	var calificacion = document.getElementById('calificacion').value
	var estado = document.getElementById('estado').value

	$.ajax({
		url:"../../consultas/pm_editaCriterio.php",
		type:"POST",
		data:{id_criterio:id_criterio,descripcion:descripcion,calificacion:calificacion,estado:estado},
		beforeSend: function(){
			$("#cont_header").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			//ejecuta función
			cont_header();
			
		}
	})
}

//trae datos para editar 
 $('#edita_criterio').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('id_criterio');
      var recipient1 = button.data('descripcion');
      var recipient3 = button.data('calificacion');
      var recipient5 = button.data('estado');
     
      


      var modal = $(this)    
      modal.find('.modal-body #id_criterio').val(recipient0)
      modal.find('.modal-body #descripcion').val(recipient1)
      modal.find('.modal-body #calificacion').val(recipient3)
      modal.find('.modal-body #estado').val(recipient5)


    });
 // finaliza configuración criterio

 function cont_body() {
	
	$.ajax({
		url:"../../views/pm_config_preguntas.php",
		type:"POST",
		dataType:"",
		data:{},
		beforeSend: function(){
			$("#cont_body").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			$("#cont_body").html(data);
		}

	})
}
cont_body()

//para borrar todos los datos que tenga los input, textareas, select.
$('#Addquest').on('show.bs.modal', function(){ 
  
    $(this).find('form')[0].reset(); 

  });


//Inserta pregunta 
function insert_quest(){
	var ins_criterio = document.getElementById('ins_criterio').value
	var ins_tipo_pregunta = document.getElementById('ins_tipo_pregunta').value
	var ins_titulo = document.getElementById('ins_titulo').value
	var ins_descripcion = document.getElementById('ins_descripcion').value

	$.ajax({
		url:"../../consultas/pm_insertquest.php",
		type:"POST",
		data:{ins_criterio:ins_criterio,ins_tipo_pregunta:ins_tipo_pregunta,ins_titulo:ins_titulo,ins_descripcion:ins_descripcion},
		beforeSend: function(){
			$("#cont_body").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			//ejecuta función
			cont_body();
			
		}
	})
}

//trae datos para editar 
 $('#Editquest').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('id_quest');
      var recipient1 = button.data('edit_criterio');
      var recipient3 = button.data('edit_tipo_pregunta');
      var recipient5 = button.data('edit_titulo');
      var recipient6 = button.data('edit_descripcion');
     
      


      var modal = $(this)    
      modal.find('.modal-body #id_quest').val(recipient0)
      modal.find('.modal-body #edit_criterio').val(recipient1)
      modal.find('.modal-body #edit_tipo_pregunta').val(recipient3)
      modal.find('.modal-body #edit_titulo').val(recipient5)
      modal.find('.modal-body #edit_descripcion').val(recipient6)

    });

 //Edita pregunta 
function edit_quest(){
	var id_quest = document.getElementById('id_quest').value
	var edit_criterio = document.getElementById('edit_criterio').value
	var edit_tipo_pregunta = document.getElementById('edit_tipo_pregunta').value
	var edit_titulo = document.getElementById('edit_titulo').value
	var edit_descripcion = document.getElementById('edit_descripcion').value
	var edit_estatus = document.getElementById('edit_estatus').value

	$.ajax({
		url:"../../consultas/pm_editquest.php",
		type:"POST",
		data:{id_quest:id_quest,edit_criterio:edit_criterio,edit_tipo_pregunta:edit_tipo_pregunta,edit_titulo:edit_titulo,edit_descripcion:edit_descripcion,edit_estatus:edit_estatus},
		beforeSend: function(){
			$("#cont_body").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			//ejecuta función
			cont_body();
			
		}
	})
}

 //Elimina pregunta 
function delete_quest(id_quest){

var preg = confirm("¿Esta seguro de eliminar pregunta ID  " + id_quest+"? No podrá utilizarlo nuevamente.");

if (preg==true) {
		var parametros = {id_quest:id_quest};
	   $.ajax({
            url: "../../consultas/pm_deletequest.php",
            type:"POST",
            data:parametros,
            beforeSend: function(){
              $("#cont_body").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
            },
            success: function(data){
			//ejecuta función
			cont_body();      
            }
        })
}else{
	
}

}