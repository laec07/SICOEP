//Muestra listado de gasolineras
function lista_gasolinera(){
	$.ajax({
		url:"../../views/gasolinera.php",
		type:"POST",
		data:{},
		success: function(data){
			$("#contenido").html(data);
			
		}
	})
}

//ejecuta función
lista_gasolinera();

//para borrar todos los datos que tenga los input, textareas, select.
$('#frm_ingreso').on('show.bs.modal', function(){ 
  
    $(this).find('form')[0].reset(); 

  });

//Ingreso de gasolinera
function inserta_gasolinera(){
	var id_depto = document.getElementById('depto').value
	var descrip = document.getElementById('descrip').value
	var ubic = document.getElementById('ubic').value
	var empre = document.getElementById('empre').value
	$.ajax({
		url:"../../consultas/gasolinera_inserta.php",
		type:"POST",
		data:{id_depto:id_depto,descrip:descrip,ubic:ubic,empre:empre},
		beforeSend: function(){
			document.getElementById("contenido").innerHTML="<img src = '../../dist/images/loading4.gif' width='50px'  >"
		},
		success: function(data){
		lista_gasolinera();
			
		}
	})
}

//edita de gasolinera
function edita_gasolinera(){
	var id_gasolinera_e = document.getElementById('id_gasolinera_e').value
	var id_depto_e = document.getElementById('id_depto_e').value
	var descripcion_e = document.getElementById('descripcion_e').value
	var ubicacion_e = document.getElementById('ubicacion_e').value
	var empresa_e = document.getElementById('empresa_e').value
	$.ajax({
		url:"../../consultas/gasolinera_edita.php",
		type:"POST",
		data:{id_gasolinera_e:id_gasolinera_e,id_depto_e:id_depto_e,descripcion_e:descripcion_e,ubicacion_e:ubicacion_e,empresa_e:empresa_e},
		beforeSend: function(){
			document.getElementById("contenido").innerHTML="<img src = '../../dist/images/loading4.gif' width='50px'  >"
		},
		success: function(data){
			//ejecuta función
			lista_gasolinera();
			
		}
	})
}

//trae datos para editar producto
 $('#EditaGas').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('id_gasolinera_e');
      var recipient1 = button.data('id_depto_e');
      var recipient3 = button.data('descripcion_e');
      var recipient5 = button.data('ubicacion_e');
      var recipient6 = button.data('empresa_e');
      


      var modal = $(this)    
      modal.find('.modal-body #id_gasolinera_e').val(recipient0)
      modal.find('.modal-body #id_depto_e').val(recipient1)
      modal.find('.modal-body #descripcion_e').val(recipient3)
      modal.find('.modal-body #ubicacion_e').val(recipient5)
      modal.find('.modal-body #empresa_e').val(recipient6)

    });

// Elimina registro
function elimina_gasolinera(id_gasolinera){

var preg = confirm("¿Esta seguro de eliminar gasolinera ID  " + id_gasolinera+"?");

if (preg==true) {
		var parametros = {id_gasolinera:id_gasolinera};
	   $.ajax({
            url: "../../consultas/gasolinera_elimina.php",
            type:"POST",
            data:parametros,
            beforeSend: function(){
              document.getElementById("contenido").innerHTML="<img src = '../../dist/images/loading4.gif' width='50px'  >"
            },
            success: function(data){
			//ejecuta función
			lista_gasolinera();      
            }
        })
}else{
	
}


}