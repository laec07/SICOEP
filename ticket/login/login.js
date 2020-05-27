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
  location.href = '../home.php';
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