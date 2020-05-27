$(document).ready(function() {
  $('.input').on('focus', function() {
    $('.login').addClass('clicked');
  });
  $('.login').on('submit', function(e) {
    e.preventDefault();
    $('.login').removeClass('clicked').addClass('loading');
  });
  $('.resetbtn').on('click', function(e){
      e.preventDefault();
    
  });
});
jQuery(document).on('submit','#formlg',function (event) {
  event.preventDefault();

jQuery.ajax({
  url:'login.php',
  type: 'POST',
  dataType: 'json',
  data: $(this).serialize(),
  beforeSend: function () {
    $('.botonlg').val('Validando...');
  }

})
.done(function (respuesta) {
  console.log(respuesta);
  if(!respuesta.error){
    if(respuesta.TIPO == 'Administrador'){
      location.href = '../menu.php';

    } else if (respuesta.TIPO == 'Admin_carros'){
        location.href = '../pages/vehiculo';
    }else if (respuesta.TIPO == 'Admin_equipo'){
        location.href = '../equipo';
    }else if (respuesta.TIPO == 'Admin_sis'){
        location.href = '../equipo';
    }else if (respuesta.TIPO == 'Oper_carros'){
        location.href = '../operativo';
    }else if (respuesta.TIPO == 'Admin_gas'){
        location.href = '../s_combustible.php';
    }else if (respuesta.TIPO == 'Admin_inve'){
        location.href = '../menu_inventario.php';
    }else if (respuesta.TIPO == 'Ticket_user'){
        location.href = '../ticket';
    }

  }else{
    $('.error').slideDown('slow');
    setTimeout(function () {
      $('.error').slideUp('slow');
    },3000);
    $('.login').removeClass('loading');
  }
})
.fail(function (resp) {
  console.log(resp.responseText);
})
.always(function () {
  console.log("complete"); 
});
});