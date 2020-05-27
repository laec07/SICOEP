//comprueba los vehiculos que necesitan mantenimientos
    function vehiculos_mante(){
        $.ajax({
            url: "../modelos/mantenimientos_alertar.php",
            type:"POST",
            dataType:'html',
            data:{},
            success: function(data){             
            }
        })
    }

vehiculos_mante();