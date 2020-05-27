/*Migrando de main.js todo lo relacionado con solicitudes combustible*/
//Guarda la solicitud previa a editar
function buscar(){
  var depto = document.getElementById("depto").value;
  var fecha = document.getElementById("fecha").value;
  var supers = document.getElementById("super").value;
  var regular = document.getElementById("regular").value;
  var diesel = document.getElementById("diesel").value;
  var gas = document.getElementById("gas").value;
  //trae un string, con varios canales
  var canal_n =$('#canal_n').val(); 
    
     $.ajax({
            url: "models/solicitud_inserta.php",
            type:"POST",
            dataType:'html',
            data:{depto:depto,fecha:fecha,super:supers,regular:regular,diesel:diesel,gas:gas,canal_n:canal_n},
            beforeSend: function(){
              document.getElementById("mostrardatos").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"
            },
            success: function(datos){

            if (datos == 'NO') {//no procesa si no se han restablecido galones a las rutas
              alert('No puede insertar solicitudes hasta que reseteen galones asignados a las rutas, contacte al encargado de la flotilla.');
              alerta_restablecer(depto);//llama a función para alertar a encargado sobre el reseteo
              $("#mostrardatos").html('');
            }else{//muestra solicitud procesada
              muestra_solicitud(datos);
              //get_erase(id_depto); 
            }
              
              
            }
        })
    }
//Muestra la solicitud para poder editar
function muestra_solicitud(datos){
  var datos_ = parseInt(datos);
    $.ajax({
      url: "views/solicitud_editable.php",
      type:"POST",
      dataType:'html',
      data:{ID:datos_},
      success: function(datos){
        $("#mostrardatos").html(datos);
      }
    })
}

//actualizar cantidad galones de la solicitud cargada
    function actualizar_gal_r(gal,id_ruta,id_depto,id_solicitud,restante,resto){
      var actual=resto - gal;

        if (actual < 0) {
          

          alert('No tiene suficiente galones para asignar, Solicite adicional en el botón (+) ubicado al final de la fila de cada ruta');
          
        }else{
           ///////////////////////////////////
        $.ajax({
            url: "models/solicitud_cantgalones.php",
            type:"POST",
            dataType:'html',
            data:{gal:gal,id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            beforeSend: function(){
              $('#div_espera').addClass('overlay');
              $('#espera_1').addClass('fa fa-refresh fa-spin')
            },
            success: function(data){
             $('#div_espera').removeClass('overlay');
              $('#espera_1').removeClass('fa fa-refresh fa-spin')
             muestra_solicitud(id_solicitud);
             get_erase(id_depto) 

            }
        })
        ///////////////////////////////
       
          
        }
       
    }
    //esto carga los datos si necesidad de colocar nombre de función en elemento DOM
    $(document).on("blur", "#gal_r", function(
        ){
        var gal=$(this). text();
        var id_ruta = $(this).data("id_ruta");
        var id_depto = $(this).data("id_depto");
        var id_solicitud = $(this).data("id_solicitud");
        var restante = $(this).data("restante");
        var resto = $(this).data("resto");
        actualizar_gal_r(gal,id_ruta,id_depto,id_solicitud,restante,resto);
    })
/*********************************************************************************************************/
//actualizar tipo combustible
function tipo_gas_r(opcion,id_ruta,id_depto,id_solicitud){
    $.ajax({
        url: "models/solicitud_upgalones.php",
        type:"POST",
        dataType:'html',
        data:{opcion:opcion,id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
        beforeSend: function(){
          $('#div_espera').addClass('overlay');
          $('#espera_1').addClass('fa fa-refresh fa-spin')
        },
        success: function(data){
        $('#div_espera').removeClass('overlay');
          $('#espera_1').removeClass('fa fa-refresh fa-spin')
        muestra_solicitud(id_solicitud);
        get_erase(id_depto) 
         
        }
    })
}

$(document).on("change", "#tipogas_r", function(){
    var id_ruta = $(this).data("id_ruta");
    var id_depto = $(this).data("id_depto");
    var id_solicitud = $(this).data("id_solicitud");
    //obtiene fila selecciona y extra dato del select de esa fila       
    var opcion = $(this).parents("td").find('#tipogas_r').val();
    tipo_gas_r(opcion,id_ruta,id_depto,id_solicitud );

})
/*****************************************/
//Guarda solicitud con estado pendiente para su posterior aprobación
function guarda_s(val){
   //evita submit formulario
  event.preventDefault();

  $.ajax({
    url:"models/solicitud_guarda.php",
    type:"POST",
    dataType:'html',
    data:{id_solicitud:val},
    success: function(data){
      solicitud();
    }
  })
}
/************************************************/
function confirm_e(val) {
//Ingresamos un mensaje a mostrar
var mensaje_e = confirm("¿Esta seguro de eliminar solicitud No."+ val+"?");
//Detectamos si el usuario acepto el mensaje
if (mensaje_e) {
eliminas_s(val)
}
//Detectamos si el usuario denegó el mensaje
else {

}
}

/*********************************************************/
function eliminas_s(val){
  $.ajax({
    url:"models/solicitud_elimina.php",
    type:"POST",
    dataType:"html",
    data: {ID:val},
    success: function(data){

      solicitud();
    }
  })
}
/****************Remueve ruta******************************/
function remover(id_ruta,id_depto,id_solicitud){
        $.ajax({
            url:"models/solicitud_remueveruta.php",
            type:"POST",
            dataType:"html",
            data:{id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(datos){
                muestra_solicitud(id_solicitud);
                get_erase(id_depto) 
            }
        })
    }

/****************Remueve ruta******************************/
function cambiar_rutas_(){
  //evita submit formulario
  event.preventDefault();
  var id_ruta= document.getElementById('id_ruta_h').value;
  var ruta = document.getElementById('ruta_h').value;
  var id_solicitud = document.getElementById('id_solicitud_h').value;
  var id_depto = document.getElementById('id_depto_h').value;
  var piloto = document.getElementById('piloto_h').value
        $.ajax({
            url:"models/solicitud_emergente.php",
            type:"POST",
            dataType:"html",
            data:{id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud,ruta:ruta,piloto:piloto},
            success: function(datos){
               muestra_solicitud(id_solicitud);
               get_erase(id_depto) 
            }
        })
    }
//Solicitud detalle
function gal_adicional(){
    event.preventDefault();
    var cant_e = document.getElementById('cant_e').value;
    var motivo = document.getElementById('motivo').value;
    var id_solicitud = document.getElementById('id_solicitud_e').value;
    var id_ruta= document.getElementById('id_ruta_e').value;
    var id_depto= document.getElementById('id_depto_e').value;

    
    $.ajax({
        url: "models/solicitud_cantgalones.php",
        type:"POST",
        dataType:"html",
        data:{gal:cant_e,motivo:motivo,id_solicitud:id_solicitud,id_ruta:id_ruta,id_depto:id_depto},
        success: function(datos){
        muestra_solicitud(id_solicitud);
        get_erase(id_depto)  
        }
    })
}
//alerta encargado de flotilla para restablecer galones a rutas (Inicio mes)
function alerta_restablecer(depto){
  $.ajax({
    url:"models/alerta_restablecer.php",
    type:"POST",
    dataType:"html",
    data:{depto:depto},
    success: function(datos){

    }
  })
}

//Trae solicitudes no procesadas durante el día (borradores)
function get_erase(depto){
	$.ajax({
		url:"models/solicitud_borrador.php",
		type:"POST",
		data:{depto:depto},
		success: function(data){
			$("#borrador").html(data);
		}
	})
}