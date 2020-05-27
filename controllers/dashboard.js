//comprueba los vehiculos que necesitan mantenimientos
    function vehiculos_mante(){
        $.ajax({
            url: "../../modelos/mantenimientos_alertar.php",
            type:"POST",
            dataType:'html',
            data:{},
            success: function(data){             
            }
        })
    }

vehiculos_mante();

//Trae relojes combustible por sede
function combustible_relojes(){
    $.ajax({
        url:"../../modelos/combustible_relojes.php",
        type:"POST",
        dataType:"HTML",
        data:{},
        success: function(data){
            $("#relojes").html(data);
        }
    })
}
combustible_relojes();

function mantenimiento_costos(){
    $.ajax({
        url:"../../modelos/mantenimientos_costos.php",
        type:"POST",
        dataType:"HTML",
        data:{},
        success: function(data){
            $("#costo_mantenimientos").html(data);
        }
    })
}

mantenimiento_costos();