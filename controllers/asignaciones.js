function elimina_asig(Id_Asignacion,Id_equipo,Id_usuario,Sede) {
	


    var opcion = confirm("¿Desea eliminar asginación de vehículo "+Id_equipo+" - "+Sede+" ?");
    if (opcion == true) {
		$.ajax({
			url:"../../consultas/asignacion_vehi_elimina.php",
			type:"POST",
			dataType:'html',
			data:{Id_Asignacion:Id_Asignacion,Id_equipo:Id_equipo,Id_usuario:Id_usuario,Sede:Sede},
			beforeSend: function(){
	              
	            },
			success: function(data){
				  location.href="asignaciones.php";
			}
		})        
	} else {
	    
	}





}