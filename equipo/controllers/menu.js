function tarea(){
      var parametros = {};
      $( "#tarea_m" ).addClass( "active" );
      $( "#dash_m" ).removeClass( "active treeview" );
      $( "#equipo_m" ).removeClass( "active" );
      $( "#asignaciones_m" ).removeClass( "active" );
      $( "#mantenimientos_m" ).removeClass( "active" );
      $( "#problemas_m" ).removeClass( "active" );
      $( "#dash_m" ).addClass( "treeview" );
      $( "#configuracion" ).removeClass( "active treeview" );
      $( "#configuracion" ).addClass( "treeview" );      
      $( "#usuarios_m" ).removeClass( "active" );

      $("#seccion").text('Tareas');     

      $.ajax({
            url: "pages/tarea.php",
            type:"POST",
            cache: false,
            data:parametros,
            success: function(data){
            
              $("#contenido").html(data);        
            }
        })

    }

    function equipo(){
      var parametros = {};
      $( "#tarea_m" ).removeClass( "active" );
      $( "#dash_m" ).removeClass( "active treeview" );
      $( "#equipo_m" ).addClass( "active" );
      $( "#asignaciones_m" ).removeClass( "active" );
      $( "#mantenimientos_m" ).removeClass( "active" );
      $( "#problemas_m" ).removeClass( "active" );
      $( "#dash_m" ).addClass( "treeview" );
      $( "#configuracion" ).removeClass( "active treeview" );
      $( "#configuracion" ).addClass( "treeview" );      
      $( "#usuarios_m" ).removeClass( "active" );

      $("#seccion").text('Equipo');     

      $.ajax({
            url: "pages/construccion.php",
            type:"POST",
            cache: false,
            data:parametros,
            success: function(data){
            
              $("#contenido").html(data);        
            }
        })

    }

     function asignaciones(){
      var parametros = {};
      $( "#tarea_m" ).removeClass( "active" );
      $( "#dash_m" ).removeClass( "active treeview" );
      $( "#equipo_m" ).removeClass( "active" );
      $( "#asignaciones_m" ).addClass( "active" );
      $( "#mantenimientos_m" ).removeClass( "active" );
      $( "#problemas_m" ).removeClass( "active" );
      $( "#dash_m" ).addClass( "treeview" );
      $( "#configuracion" ).removeClass( "active treeview" );
      $( "#configuracion" ).addClass( "treeview" );      
      $( "#usuarios_m" ).removeClass( "active" );

      $("#seccion").text('Asignaciones');     

      $.ajax({
            url: "pages/construccion.php",
            type:"POST",
            cache: false,
            data:parametros,
            success: function(data){
            
              $("#contenido").html(data);        
            }
        })

    }

     function mantenimientos(){
      var parametros = {};
      $( "#tarea_m" ).removeClass( "active" );
      $( "#dash_m" ).removeClass( "active treeview" );
      $( "#equipo_m" ).removeClass( "active" );
      $( "#asignaciones_m" ).removeClass( "active" );
      $( "#mantenimientos_m" ).addClass( "active" );
      $( "#problemas_m" ).removeClass( "active" );
      $( "#dash_m" ).addClass( "treeview" );
      $( "#configuracion" ).removeClass( "active treeview" );
      $( "#configuracion" ).addClass( "treeview" );      
      $( "#usuarios_m" ).removeClass( "active" );

      $("#seccion").text('Mantenimientos');     

      $.ajax({
            url: "pages/construccion.php",
            type:"POST",
            cache: false,
            data:parametros,
            success: function(data){
            
              $("#contenido").html(data);        
            }
        })

    }

    function problemas(){
      var parametros = {};
      $( "#tarea_m" ).removeClass( "active" );
      $( "#dash_m" ).removeClass( "active treeview" );
      $( "#equipo_m" ).removeClass( "active" );
      $( "#asignaciones_m" ).removeClass( "active" );
      $( "#mantenimientos_m" ).removeClass( "active" );
      $( "#problemas_m" ).addClass( "active" );
      $( "#dash_m" ).addClass( "treeview" );
      $( "#configuracion" ).removeClass( "active treeview" );
      $( "#configuracion" ).addClass( "treeview" );      
      $( "#usuarios_m" ).removeClass( "active" );

      $("#seccion").text('Problemas');     

      $.ajax({
            url: "pages/construccion.php",
            type:"POST",
            cache: false,
            data:parametros,
            success: function(data){
            
              $("#contenido").html(data);        
            }
        })

    }

     function usuarios(){
      var parametros = {};
      $("li").removeClass("active");//obligado en todos
      $( "#body").removeClass("sidebar-open");//obligado en todos
      
      $( "#usuarios_m" ).addClass( "active" );
      $( "#configuracion" ).addClass( "active" );
      $("#seccion").text('Usuarios');     

      $.ajax({
            url: "pages/usuarios.php",
            type:"POST",
            cache: false,
            data:parametros,
            success: function(data){
            
              $("#contenido").html(data);        
            }
        })

    }
function usuarios_permisos(){
      var parametros = {};

  $("li").removeClass("active");//obligado en todos
  $( "#body").removeClass("sidebar-open");//obligado en todos

  $( "#configuracion" ).addClass( "active" );//activa menu
  $( "#usuariosP_m" ).addClass( "active" );//activa opcion seleccionada
  $("#seccion").text('Usuarios Permisos');     

      $.ajax({
            url: "pages/usuarios_permisos.php",
            type:"POST",
            cache: false,
            data:parametros,
            success: function(data){
            
              $("#contenido").html(data);        
            }
        })

    }


function usuarios_paises(){
  var parametros = {};
  $("li").removeClass("active");//obligado en todos
  $( "#body").removeClass("sidebar-open");//obligado en todos
  
  $( "#usuarios_pais" ).addClass( "active" );
  $( "#configuracion" ).addClass( "active" );
  $("#seccion").text('Usuarios paises');     

  $.ajax({
        url: "pages/usuarios_paises.php",
        type:"POST",
        cache: false,
        data:parametros,
        success: function(data){
        
          $("#contenido").html(data);        
        }
    })

}

    function atender(ID){
      var parametros = {ID:ID};

      $.ajax({
            url: "models/atender_tarea.php",
            type:"POST",
            cache: false,
            data:parametros,
            success: function(data){
            
              tarea();        
            }
        })

    }

    function guarda(){
      var date = document.getElementById("date").value
      var tarea1 = document.getElementById("tarea").value

      var parametros = {date:date,tarea:tarea1};

      $.ajax({
            url: "models/guarda_tarea.php",
            type:"POST",
            dataType:'html',
            data:parametros,
            success: function(data){
              
              tarea();        
            }
        })

    }

