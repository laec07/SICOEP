

function guarda(){

	var id_solicitud = document.getElementById("id_solicitud").value;

        $.ajax({
            url: "../../consultas/solicitud_guarda.php",
            type:"POST",
            dataType:'html',
            data:{id_solicitud:id_solicitud},
            success: function(datos){
            
            	alert('Solicitud procesada satisfactoriamente');
                
                location.href = '../pages/vehiculo/solicitudes.php'
                
             
            }
        })
    }

