
//Guarda la solicitud previa a editar
function buscar(){

	var depto = document.getElementById("depto").value;
	var fecha = document.getElementById("fecha").value;
	var supers = document.getElementById("super").value;
	var regular = document.getElementById("regular").value;
	var diesel = document.getElementById("diesel").value;
	var gas = document.getElementById("gas").value;
    var canal_n =$('#canal_n').val();
    
        $.ajax({
            url: "../../consultas/solicitud_guarda_depto.php",
            type:"POST",
            dataType:'html',
            data:{depto:depto,fecha:fecha,super:supers,regular:regular,diesel:diesel,gas:gas,canal_n:canal_n},
            success: function(datos){
            
            	ver_solicitud(datos);
             
            }
        })
    }

//carga solicitud para se editada
function ver_solicitud(val){
    $.ajax({
        url:"../../views/solicitudes_detalle.php",
        type:"POST",
        dataType:'html',
        data:{ID:val},
        success: function (datos){
            $("#mostrardatos").html(datos);
        }
    })
}
//Carga solicitud para ser editada por administrador mostrando las opciones de aprobar o rechazar
function solicitud_editable(val){
    $.ajax({
        url:"../../views/solicitudes_editable.php",
        type:"POST",
        dataType:'html',
        data:{ID:val},
        success: function (datos){
            $("#mostrardatos").html(datos);
        }
    })
}

//solicitud detalle -->actualizar cantidad galones 
    function actualizar_gal_e(gal,id_ruta,id_depto,id_solicitud,restante,resto){
      var actual=resto - gal;

        if (actual < 0) {
          

          alert('No tiene suficiente galones para asignar, puede solicitar galones adicionales en el botón de signo (+), ubicado al final de la fila de cada ruta.');
          
        }else{
           ///////////////////////////////////
        $.ajax({
            url: "../../consultas/solicitud_cantgalones.php",
            type:"POST",
            dataType:'html',
            data:{gal:gal,id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(data){
             ver_solicitud(id_solicitud);  
            }
        })
        ///////////////////////////////
        document.getElementById('aviso').style.display='none'
          
        }
       
    }
    //esto carga los datos si necesidad de colocar nombre de función en elemento DOM
    $(document).on("blur", "#gal_e", function(
        ){
        var gal=$(this). text();
        var id_ruta = $(this).data("id_ruta");
        var id_depto = $(this).data("id_depto");
        var id_solicitud = $(this).data("id_solicitud");
        var restante = $(this).data("restante");
        var resto = $(this).data("resto");
        actualizar_gal_e(gal,id_ruta,id_depto,id_solicitud,restante,resto);
    })
////////////////////////////////////////////////////////////////////////////////
    //solicitud detalle -->actualizar tipo combustible
    function tipo_gas_e(opcion,id_ruta,id_depto,id_solicitud){
        $.ajax({
            url: "../../operativo/models/solicitud_upgalones.php",
            type:"POST",
            dataType:'html',
            data:{opcion:opcion,id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(data){
            
            ver_solicitud(id_solicitud);
             
            }
        })
    }

    $(document).on("change", "#tipogas_e", function(){
        var id_ruta = $(this).data("id_ruta");
        var id_depto = $(this).data("id_depto");
        var id_solicitud = $(this).data("id_solicitud");
        //obtiene fila selecciona y extrae dato del select de esa fila       
        var opcion = $(this).parents("td").find('#tipogas_e').val();
        tipo_gas_e(opcion,id_ruta,id_depto,id_solicitud );

    })
//solicitud detelle
    function remover(id_ruta,id_depto,id_solicitud){
        $.ajax({
            url:"../../consultas/solicitud_remueveruta.php",
            type:"POST",
            dataType:"html",
            data:{id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(datos){
                ver_solicitud(id_solicitud);
            }
        })
    }
//solicitud detalle -->realiza operación cambio de ruta emergente 
function cambiar_rutas_(){
  //evita submit formulario
  event.preventDefault();
  var id_ruta= document.getElementById('id_ruta_h').value;
  var ruta = document.getElementById('ruta_h').value;
  var id_solicitud = document.getElementById('id_solicitud_h').value;
  var id_depto = document.getElementById('id_depto_h').value;
  var piloto = document.getElementById('piloto_h').value
        $.ajax({
            url:"../../consultas/solicitud_emergente.php",
            type:"POST",
            dataType:"html",
            data:{id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud,ruta:ruta,piloto:piloto},
            success: function(datos){
               ver_solicitud(id_solicitud);
               
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
        url: "../../consultas/solicitud_cantgalones.php",
        type:"POST",
        dataType:"html",
        data:{gal:cant_e,motivo:motivo,id_solicitud:id_solicitud,id_ruta:id_ruta,id_depto:id_depto},
        success: function(datos){
        ver_solicitud(id_solicitud);  
        }
    })
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//Solicitud detalle
function gal_adicional_e(){
    event.preventDefault();
    var cant_e = document.getElementById('cant_e').value;
    var motivo = document.getElementById('motivo').value;
    var id_solicitud = document.getElementById('id_solicitud_e').value;
    var id_ruta= document.getElementById('id_ruta_e').value;
    var id_depto= document.getElementById('id_depto_e').value;

    
    $.ajax({
        url: "../../consultas/solicitud_cantgalones.php",
        type:"POST",
        dataType:"html",
        data:{gal:cant_e,motivo:motivo,id_solicitud:id_solicitud,id_ruta:id_ruta,id_depto:id_depto},
        success: function(datos){
        solicitud_editable(id_solicitud);  
        //$("#mostrardatos").html(datos);
        }
    })
}
//solicitud editable -->actualizar cantidad galones 
    function actualizar_gal_a(gal,id_ruta,id_depto,id_solicitud,restante,resto,motivo){
      

      var actual=resto - gal;

        if (actual < 0) {
          

          alert('No tiene suficiente galones disponibles, Debe colocar cantidad galones a 0 para actualizar valor de galonaje disponible.');
          
        }else{
           ///////////////////////////////////
        $.ajax({
            url: "../../operativo/models/solicitud_cantgalones.php",
            type:"POST",
            dataType:'html',
            data:{gal:gal,id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(data){
             solicitud_editable(id_solicitud);  
            }
        })
        ///////////////////////////////
        document.getElementById('aviso').style.display='none'
          
        }
       
    }
    //esto carga los datos si necesidad de colocar nombre de función en elemento DOM
    $(document).on("blur", "#gal_a", function(
        ){
        var gal=$(this). text();
        var id_ruta = $(this).data("id_ruta");
        var id_depto = $(this).data("id_depto");
        var id_solicitud = $(this).data("id_solicitud");
        var restante = $(this).data("restante");
        var resto = $(this).data("resto");
        var motivo = $(this).data("motivo");
        actualizar_gal_a(gal,id_ruta,id_depto,id_solicitud,restante,resto,motivo);
    })

//solicitud editable
    function remover_a(id_ruta,id_depto,id_solicitud){
        $.ajax({
            url:"../../consultas/solicitud_remueveruta.php",
            type:"POST",
            dataType:"html",
            data:{id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(datos){
                solicitud_editable(id_solicitud);
            }
        })
    }
 //solicitud detalle -->actualizar tipo combustible
    function tipo_gas_a(opcion,id_ruta,id_depto,id_solicitud){
        $.ajax({
            url: "../../operativo/models/solicitud_upgalones.php",
            type:"POST",
            dataType:'html',
            data:{opcion:opcion,id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(data){
            solicitud_editable(id_solicitud);
             
            }
        })
    }   

    $(document).on("change", "#tipogas_a", function(){
        var id_ruta = $(this).data("id_ruta");
        var id_depto = $(this).data("id_depto");
        var id_solicitud = $(this).data("id_solicitud");
        //obtiene fila selecciona y extrae dato del select de esa fila       
        var opcion = $(this).parents("td").find('#tipogas_a').val();
        tipo_gas_a(opcion,id_ruta,id_depto,id_solicitud );

    })

//carga solicitud ya aprobada para ser editada
function editar_soliaprobada(val){
    $.ajax({
        url:"../../views/solicitudes_editaaprobada.php",
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
            url:"../../consultas/solicitud_remueverutaA.php",
            type:"POST",
            dataType:"html",
            data:{id_ruta:id_ruta,id_depto:id_depto,id_solicitud:id_solicitud},
            success: function(datos){
                editar_soliaprobada(id_solicitud);
            }
        })
    }else{
    }

    }
function cerrar_soliaprobada(){
    $("#mostrardatos").html("");
}
