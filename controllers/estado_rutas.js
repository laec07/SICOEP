//cambia estado de la ruta
    function cambia_estado(opcion,id_ruta){
        $.ajax({
            url: "../../modelos/rutas_estado.php",
            type:"POST",
            dataType:'html',
            data:{opcion:opcion,id_ruta:id_ruta},
            success: function(data){
            
            
             
            }
        })
    }

    $(document).on("change", "#iactivar", function(){
        var id_ruta = $(this).data("id_ruta");
        //obtiene fila selecciona y extrae dato del select de esa fila       
        var opcion = $(this).parents("td").find('#iactivar').val();
        cambia_estado(opcion,id_ruta );

    })