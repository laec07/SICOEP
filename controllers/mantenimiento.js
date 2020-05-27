function muestra_contenido() {
	var parametros = {};
	 $.ajax({
            url: "../../views/mantenimientos_alertas.php",
            type:"POST",
            
            data:parametros,
            beforeSend: function(){
              document.getElementById("contenido").innerHTML="<img src = '../../dist/images/loading4.gif' width='50px'  >"
            },
            success: function(data){
            
              $("#contenido").html(data);        
            }
        })

    }

//Editar kilometraje mantenimiento
function actualizar_km(km,placa){

	$.ajax({
		url:"../../consultas/mante_vehi_km.php",
		type:"POST",
		dataType:"html",
		data:{km:km,placa:placa},
		beforeSend: function(){
              document.getElementById("contenido").innerHTML="<img src = '../../dist/images/loading4.gif' width='50px'  >"
            },
            success: function(data){
            
              muestra_contenido();       
            }
	})
}
$(document).on("blur","#km",function(){
	var km =$(this).text();
	var placa = $(this).data("placa");

	actualizar_km(km,placa)
})

//Editar kilometra vehículo
function actualizar_kilometraje(km,placa){

  $.ajax({
    url:"../../consultas/mante_vehi_km.php",
    type:"POST",
    dataType:"html",
    data:{km:km,placa:placa},
    beforeSend: function(){
              document.getElementById("contenido").innerHTML="<img src = '../../dist/images/loading4.gif' width='50px'  >"
            },
            success: function(data){
            
              muestra_contenido();       
            }
  })
}
$(document).on("blur","#kilometraje",function(){
  var km =$(this).text();
  var placa = $(this).data("id");

  actualizar_km(km,placa)
})

function km_dianterior_edita(placa){

  $.ajax({
    url:"../../views/mante_kmanterior.php",
    type:"POST",
    dataType:"html",
    data:{placa:placa},
    beforeSend: function(){
      document.getElementById("datos").innerHTML="<img src = '../../dist/images/loading4.gif' width='50px'  >"
    },
    success: function(data){
       $("#datos").html(data);
    }
  })
}
//suma kilometros al editar kilometraje actual para que usuario corrobore si datos son correctos
function suma_km(){

    var a = document.getElementById('kilometraje_e').value
  var b = document.getElementById('km_salida').value
  var total = document.getElementById('km_recorrido').value=parseFloat(a) - parseFloat(b);

}

function guarda_kmeditado(){
  var placa = document.getElementById('placa').value
  var km = document.getElementById('kilometraje_e').value

  $.ajax({
    url:"../../consultas/vehi_kmeditado.php",
    type:"POST",
    dataType:"html",
    data:{placa:placa,km:km},
    success: function(data){
      muestra_contenido();
    }
  })
}

