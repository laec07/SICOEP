//Lista opciones según criterio seleccionado
function buscar_por(){
  var a = document.getElementById('buscapor').value
  if (a==1) {//lista datos Sede
    $.ajax({
            url: "../../views/combustible_listasede.php",
            type:"POST",
            dataType:'html',
            data:{},
            beforeSend: function(){
              document.getElementById("buscado").innerHTML="<img src='../../dist/images/loading1.gif' width='50px' >"
            },
            success: function(data1){
            
              $("#buscado").html(data1);        
            }
        })

  }else if (a==2) {
    $.ajax({//Lista datos canal
            url: "../../views/combustible_listacanal.php",
            type:"POST",
            dataType:'html',
            data:{},
            beforeSend: function(){
              document.getElementById("buscado").innerHTML="<img src='../../dist/images/loading1.gif' width='50px' >"
            },
            success: function(data1){
            
              $("#buscado").html(data1);        
            }
        })
  }
}
//ejecuta funcion al cargar la página
buscar_por();

//accion del boton buscar en detalle
 function buscar(){
  var f1 = document.getElementById("f1").value;
  var f2 = document.getElementById("f2").value;
  var a = document.getElementById('buscapor').value
  
if (a==1) {//Busca datos según sedes seleccionadas
  var b =$("#parameter").val();//trae string de campo sedes por select2 multiple
  $.ajax({
            url: "../../views/combustible_general.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,depto:b},
            beforeSend: function(){
              document.getElementById("mostrardatos").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
              document.getElementById("mostrardetaller").innerHTML=""
              document.getElementById("mostrardetalle1").innerHTML=""
              document.getElementById("mostrardetallec").innerHTML=""
            },
            success: function(datos){
            
              $("#mostrardatos").html(datos);        
            }
        })
}else if (a==2) {//tra datos segun canal seleccionado
  var b = document.getElementById("parameter").value;
  $.ajax({
            url: "../../views/combustible_generalcanal.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,canal:b},
            beforeSend: function(){
              document.getElementById("mostrardatos").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
              document.getElementById("mostrardetaller").innerHTML=""
              document.getElementById("mostrardetalle1").innerHTML=""
              document.getElementById("mostrardetallec").innerHTML=""
            },
            success: function(datos){
            
              $("#mostrardatos").html(datos);        
            }
        })
} 
    }
//Busca detalle datos obtenidos por SEDE  
    function buscar_d(id){
      var f1 = document.getElementById("f1").value;
      var f2 = document.getElementById("f2").value;

      $.ajax({
            url: "../../views/combustible_detalledepto.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,id:id},
            beforeSend: function(){
              document.getElementById("mostrardetalle1").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
               document.getElementById("mostrardetaller").innerHTML=""
              document.getElementById("mostrardetallec").innerHTML=""
            },
            success: function(data){
            
              $("#mostrardetalle1").html(data);        
            }
        })
    }
//busca totales canal obtenidos por SEDE
    function buscar_c(id,canal){
      var f1 = document.getElementById("f1").value;
      var f2 = document.getElementById("f2").value;

      $.ajax({
            url: "../../views/combustible_detallecanal.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,id:id,canal:canal},
            beforeSend: function(){
              document.getElementById("mostrardetallec").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
              document.getElementById("mostrardetaller").innerHTML=""
            },
            success: function(data1){
            
              $("#mostrardetallec").html(data1);        
            }
        })

    }
//busca detalles ruta obtenidos por SEDE
    function buscar_r(id,canal,ruta){
      var f1 = document.getElementById("f1").value;
      var f2 = document.getElementById("f2").value;

      $.ajax({
            url: "../../views/combustible_detalleruta.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,id:id,canal:canal,ruta:ruta},
            beforeSend: function(){
              document.getElementById("mostrardetaller").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
            },
            success: function(data1){
            
              $("#mostrardetaller").html(data1);        
            }
        })
    }
//Busca detalle datos obtenidos por CANAL  
    function buscar_dcanal(canal){
      var f1 = document.getElementById("f1").value;
      var f2 = document.getElementById("f2").value;

      $.ajax({
            url: "../../views/combustible_dbcanal.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,canal:canal},
            beforeSend: function(){
              document.getElementById("mostrardetalle1").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
            },
            success: function(data){
            
              $("#mostrardetalle1").html(data);        
            }
        })
    }
//busca totales canal obtenidos por CANAL
    function buscar_ccanal(id,canal){
      var f1 = document.getElementById("f1").value;
      var f2 = document.getElementById("f2").value;

      $.ajax({
            url: "../../views/combustible_rutascanal.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,id:id,canal:canal},
            beforeSend: function(){
              document.getElementById("mostrardetallec").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
            },
            success: function(data1){
            
              $("#mostrardetallec").html(data1);        
            }
        })

    }
//busca detalles ruta obtenidos por SEDE
    function buscar_rcanal(id,canal,ruta){
      var f1 = document.getElementById("f1").value;
      var f2 = document.getElementById("f2").value;

      $.ajax({
            url: "../../views/combustible_canaldetalleruta.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,id:id,canal:canal,ruta:ruta},
            beforeSend: function(){
              document.getElementById("mostrardetaller").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
            },
            success: function(data1){
            
              $("#mostrardetaller").html(data1);        
            }
        })
    }

/********************************************/
/*******************************************/
//Lista opciones según criterio seleccionado general
function g_buscar_por(){
  var a = document.getElementById('g_buscapor').value
  if (a==1) {//lista datos Sede
    $.ajax({
            url: "../../views/combustible_listasede_g.php",
            type:"POST",
            dataType:'html',
            data:{},
            beforeSend: function(){
              document.getElementById("g_buscado").innerHTML="<img src='../../dist/images/loading1.gif' width='50px' >"
            },
            success: function(data1){
            
              $("#g_buscado").html(data1);        
            }
        })

  }else if (a==2) {
    $.ajax({//Lista datos canal
            url: "../../views/combustible_listacanal_g.php",
            type:"POST",
            dataType:'html',
            data:{},
            beforeSend: function(){
              document.getElementById("g_buscado").innerHTML="<img src='../../dist/images/loading1.gif' width='50px' >"
            },
            success: function(data1){
            
              $("#g_buscado").html(data1);        
            }
        })
  }
}
//ejecuta funcion al cargar la página
g_buscar_por();
//accion del boton buscar General
 function g_buscar(){
  var f1 = document.getElementById("g_f1").value;
  var f2 = document.getElementById("g_f2").value;
  var a = document.getElementById('g_buscapor').value
  var b = document.getElementById("parameter_g").value;
  var check = document.getElementById("check_idp").checked;

if (a==1) {
  $.ajax({
            url: "../../views/combustible_general_g.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,depto:b,check:check},
            beforeSend: function(){
              document.getElementById("muestratabla").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
              
            },
            success: function(datos){
            
              $("#muestratabla").html(datos);        
            }
        })
}else if (a==2) {
  $.ajax({
            url: "../../views/combustible_generalcanal_g.php",
            type:"POST",
            dataType:'html',
            data:{f1:f1,f2:f2,canal:b},
            beforeSend: function(){
              document.getElementById("muestratabla").innerHTML="<img src='../../dist/images/loading4.gif' width='50px' >"
              
            },
            success: function(datos){
            
              $("#muestratabla").html(datos);        
            }
        })
} 
    }