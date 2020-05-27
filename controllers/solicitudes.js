function solicitudes_aprobadas() {
	var fecha = document.getElementById('mes_busqueda').value
	//extrae año y mes de fecha que trae formato yyyy-mm
	var year = fecha.slice(0,4);
	var month = fecha.slice(5,7);
	var sede = document.getElementById('sede_b').value;
	
	$.ajax({
		url:"../../views/solicitudes_aprobadas.php",
		type:"POST",
		dataType:"html",
		data:{year:year,month:month,sede:sede},
		beforeSend: function(){
			document.getElementById("solicitudes_aprobadas").innerHTML="<img src = '../../dist/images/loading4.gif' width='50px'  >"
		},
		success: function(data){
			$("#solicitudes_aprobadas").html(data);
		}
	})
}


/////////Hace funcionar Select////////////
  $('.select2').select2()
//////////////////////
  $(function(){
      $('#test').speedometer();

      $('.changeSpeedometer').click(function(){
        $('#test').speedometer({ percentage: $('.speedometer').val() || 0 });
      });

    });
   //actualizar datos

//////////
    //actualizar tipo combustible
    function tipo_gas(opcion,id_ruta,id_depto,id_solicitud){
        $.ajax({
            url: "../../operativo/models/solicitud_upgalones.php",
            type:"POST",
            dataType:'html',
            data:{opcion:opcion,id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(data){
            
            $("#mostrardatos").html(data);
             
            }
        })
    }

    $(document).on("change", "#tipogas", function(){
        var id_ruta = $(this).data("id_ruta");
        var id_depto = $(this).data("id_depto");
        var id_solicitud = $(this).data("id_solicitud");
        //obtiene fila selecciona y extra dato del select de esa fila       
        var opcion = $(this).parents("td").find('#tipogas').val();
        tipo_gas(opcion,id_ruta,id_depto,id_solicitud );

    })
//actualizar cantidad galones

    function actualizar_gal(gal,id_ruta,id_depto,id_solicitud,restante){
      var actual=restante - gal;

        if (actual < 0) {
          

          alert('No tiene suficiente galones para asignar, consulte al encargado de la flotilla');
          
        }else{
           ///////////////////////////////////
        $.ajax({
            url: "../../consultas/solicitud_cantgalones.php",
            type:"POST",
            dataType:'html',
            data:{gal:gal,id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(data){
             $("#mostrardatos").html(data);  
            }
        })
        ///////////////////////////////
        document.getElementById('aviso').style.display='none'
          
        }
       
    }
    $(document).on("blur", "#gal", function(
        ){
        var gal=$(this). text();
        var id_ruta = $(this).data("id_ruta");
        var id_depto = $(this).data("id_depto");
        var id_solicitud = $(this).data("id_solicitud");
        var restante = $(this).data("restante");
        actualizar_gal(gal,id_ruta,id_depto,id_solicitud,restante);
    })



//muestra solicitudes aprobadas al cargar página
solicitudes_aprobadas();