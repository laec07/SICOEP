//Muestra pagina movimiento diario
function mov(){
      var parametros = {};
      $( "#mov_m" ).addClass( "active" );
      $( "#dash_m" ).removeClass( "active treeview" );
      $( "#solicitud_m" ).removeClass( "active" );
      $("#reporte_m").removeClass( "active" );
      $( "#body").removeClass("hold-transition skin-blue sidebar-mini sidebar-open");
      $( "#body").addClass("hold-transition skin-blue sidebar-mini");

      $("#seccion").text('Movimientos diarios');     

      $.ajax({
            url: "views/mov_diario.php",
            type:"POST",
            
            data:parametros,
            beforeSend: function(){
              document.getElementById("contenido").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"
            },
            success: function(data){
            
              $("#contenido").html(data);        
            }
        })

    }
//Muestra pagina solicitud combustible
function solicitud(){

    var sede = document.getElementById('dato_depto').value
      var parametros = {};
      $( "#mov_m" ).removeClass( "active" );
      $( "#dash_m" ).removeClass( "active treeview" );
      $("#reporte_m").removeClass( "active" );
      $( "#solicitud_m" ).addClass( "active" );
      $( "#body").removeClass("hold-transition skin-blue sidebar-mini sidebar-open");
      $( "#body").addClass("hold-transition skin-blue sidebar-mini");
      $("#seccion").text('Solicitudes /' + sede);     

      $.ajax({
            url: "views/solicitudes.php",
            type:"POST",
            
            data:parametros,
            beforeSend: function(){
             
             
              document.getElementById("contenido").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"
              
      
            },
            success: function(data){
              
              $("#contenido").html(data);        
            }
        })

    }

//Muestra pagina reportes
function reportes(){
    var sede = document.getElementById('dato_depto').value
    $( "#reporte_m" ).addClass( "active" );
      $( "#mov_m" ).removeClass( "active" );
      $( "#dash_m" ).removeClass( "active treeview" );
      $( "#solicitud_m" ).removeClass( "active" );
      
      $( "#body").removeClass("hold-transition skin-blue sidebar-mini sidebar-open");
      $( "#body").addClass("hold-transition skin-blue sidebar-mini");
      $("#seccion").text('Reportes /' + sede);

  $.ajax({
    url:"views/reportes.php",
    type:"POST",
    data:{},
    beforeSend:function(){
      document.getElementById("contenido").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"
    },
    success:function(data){
      $("#contenido").html(data);
    }
  })
}
//Guarda datos de mov Diario
function guarda_diario(){
  //evita submit formulario
  event.preventDefault();
  //obtiene variables

  var placa = document.getElementById('placa').value
  var fecha = document.getElementById('fecha').value
  var kilometraje = document.getElementById('kilometraje').value
  var kilo_ants = document.getElementById('kilo_ants').value
  var observaciones = document.getElementById('observaciones').value
  //compara para kilometraje menor
  var menor = kilometraje-kilo_ants
  //inserta variables en parametros
  var parametros = {placa:placa,fecha:fecha,kilometraje:kilometraje,observaciones:observaciones};
  //verifica que se seleccione placa

  if (placa =='Seleccione placa') {
  //si no se selecciona muestra mensaje
    $('#kilo_error').hide("slow");
    $("#placa_error").text('Seleccione placa valida');
    $('#placa_f').removeClass("form-group")
    $('#placa_f').addClass("form-group has-error")
    $('#placa_error').show("slow");
    $('#kilo_f').addClass("form-group")
    $('#kilo_f').removeClass("form-group has-error")
  }else{
    //evita que se deje kilometraje a 0
    if (kilometraje==0) {
      $('#placa_error').hide("slow");
      $('#kilo_f').removeClass("form-group")
      $('#kilo_f').addClass("form-group has-error")
      $('#kilo_error').show("slow");
      $('#placa_f').addClass("form-group")
      $('#placa_f').removeClass("form-group has-error")
    }else{
//evita que se inserta datos menores a kiletraje dia anterior
      if (menor < 0) {
        $('#placa_f').addClass("form-group")
        $('#placa_f').removeClass("form-group has-error")
        $('#placa_error').hide("slow");
        $("#kilo_error").text('No puede ingresar kilometraje menor al del día anterior');
        $('#kilo_f').removeClass("form-group")
        $('#kilo_f').addClass("form-group has-error")
        $('#kilo_error').show("slow");
      }else{
        //Evita que se inserten datos mayor al kilometraje soportado por los vehículos
        if (kilometraje>999999) {
          $('#placa_f').addClass("form-group")
          $('#placa_f').removeClass("form-group has-error")
          $('#placa_error').hide("slow");
          $('#obs_error').hide("slow")
          $('#obs_f').removeClass("form-group has-error")
          $('#obs_f').addClass("form-group")
          $("#kilo_error").text('Kilometraje no valido');
          $('#kilo_f').removeClass("form-group")
          $('#kilo_f').addClass("form-group has-error")
          $('#kilo_error').show("slow");
        }else{
          //evita que observaciones vaya vacío 
          if (observaciones=='') {
              $('#obs_f').removeClass("form-group")
              $('#obs_f').addClass("form-group has-error")
              $('#obs_error').text('Describa cuadrante realizado día anterior')
              $('#obs_error').show("slow")
              $('#placa_f').removeClass("form-group has-error")
              $('#placa_f').addClass("form-group")
              $('#placa_error').hide("slow");
              $("#kilo_error").text('Kilometraje no valido');
              $('#kilo_f').removeClass("form-group has-error")
              $('#kilo_f').addClass("form-group")
              $('#kilo_error').hide("slow");
          }else{
             //traslada información para que se procese datos insertados
            $.ajax({
              url:"models/guarda_diario.php",
              type:"POST",
              cache: false,
              data:parametros,
              beforeSend: function(){
                document.getElementById("contenido").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"  
                    },
              success: function(data){
                      
                         $("#contenido").html(data);

                         mov();       
                      }
                  })
          }//else observaciones
         

          
        }

        
      }//else >999999
      
    }//else menor <0
  }//primer else  
}//Finaliza función movimiento diario

function suma_km(a,b){
  var total = document.getElementById('total').value= parseFloat(a) - parseFloat(b);
  if (total >=1000) {
    
    $('#total_a').removeClass("form-group")
    $('#total_a').addClass("form-group has-error")
    $('#total_error').show("slow");
    $("#total_error").text('Kilometraje recorrido excede los 1,000 km');
  }else if (total < 0) {
    $('#total_error').show("slow");
      $('#total_a').removeClass("form-group")
      $('#total_a').addClass("form-group has-error")
      $("#total_error").text('Kilometraje no valido');
    }else if (!a) {
      $('#total_error').hide("slow");
      $('#total_a').removeClass("form-group has-error")
      $('#total_a').removeClass("form-group has-success")
      $('#total_a').addClass("form-group")
    }else{
      $('#total_error').hide("slow");
      $('#total_a').removeClass("form-group")
      $('#total_a').removeClass("form-group has-error")
      $('#total_a').addClass("form-group has-success")
    }
}

  $(document).on("keyup","#kilometraje", function(){
     var a = document.getElementById('kilometraje').value
    var b = document.getElementById('kilo_ants').value
    
    suma_km(a,b)
  })
  ///////////////////


//////////////////////////////////////////////////////
/////////////////////////////////////////////////////

//carga kilometraje anterior pagina movimiento
function kilo_anterior(val){
  $('#kil_a').html("");
$.ajax({
        type: "POST",
        url: 'models/kilo_anterior.php',
        data: 'placa='+val,
        success: function(resp){
            $('#kil_a').html(resp);
            
        }
    });
}






/////////////Trae las solicitudes aprobadas mostradas en reporte --> Modulo operativo
function solicitudes_aprobadas() {
  var fecha = document.getElementById('mes_busqueda').value
  //extrae año y mes de fecha que trae formato yyyy-mm
  var year = fecha.slice(0,4);
  var month = fecha.slice(5,7)
  
  $.ajax({
    url:"views/solicitudes_aprobadas.php",
    type:"POST",
    dataType:"html",
    data:{year:year,month:month},
    beforeSend: function(){
      document.getElementById("solicitudes_aprobadas").innerHTML="<img src = '../dist/images/loading4.gif' width='50px'  >"
    },
    success: function(data){
      $("#solicitudes_aprobadas").html(data);
      $("#show_total").text(number_format(cuenta,2));
      $("#show_galones").text(number_format(galones,2));
    }
  })
}
//carga solicitud ya aprobada para ser editada
function editar_soliaprobada(val){
    $.ajax({
        url:"views/solicitudes_editaaprobada.php",
        type:"POST",
        dataType:'html',
        data:{ID:val},
        success: function (datos){
            $("#mostrardatos").html(datos);
        }
    })
}
//Quitar ruta de solicitud ya aprobada
function remover_b(id_ruta,id_depto,id_solicitud){
    var preg = confirm("Esta acción ajustará el total de la solicitud y no puede revertirse ¿Esta seguro en eliminar ruta?");

    if (preg==true) {
        $.ajax({
            url:"models/solicitud_remueverutaA.php",
            type:"POST",
            dataType:"html",
            data:{id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(datos){
                editar_soliaprobada(id_solicitud);
                solicitudes_aprobadas();
            }
        })
    }else{
    }

    }
function cerrar_soliaprobada(){
    $("#mostrardatos").html("");
}

//Funcion para pasar a formato de miles y decimales los numeros traidos con ajax
function number_format(amount, decimals) {
    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
    decimals = decimals || 0; // por si la variable no fue fue pasada
    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);
    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);
    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;
    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
    return amount_parts.join('.');
}