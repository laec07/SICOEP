//trae archivos ya cargados.
function contenido(){
  var placa = document.getElementById('placa').value

  $.ajax({
    url:"../../views/vehi_archivos.php",
    type:"POST",
    dataType:"html",
    data:{placa:placa},
    beforeSend: function(){
      $("#contenido").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
    },
    success: function(data){
      $("#contenido").html(data);
    }
  })

}

//toma acción de formulario
document.addEventListener("DOMContentLoaded",() => {
  let form = document.getElementById('form_subir');

  form .addEventListener("submit", function(event)  {
    event.preventDefault();
    subir_archivos(this);
  })
})

//funcion para subir archivo
function subir_archivos(form){
  let barra_estado = form.children[1].children[0],
      span = barra_estado.children[0],
      boton_cancelar = form.children[2].children[0].children[1].children[0];

  barra_estado.classList.remove('barra_verde', 'barra_roja');

  //Peticion
  let peticion = new XMLHttpRequest();

  //Progreso
  peticion.upload.addEventListener("progress",(event)=>{
    let porcentaje = Math.round((event.loaded / event.total) * 100);

    console.log(porcentaje);

    barra_estado.style.width = porcentaje +'%';
    $("#perct").text( porcentaje+'%'); 
  });

  //finalizad
  peticion.addEventListener("load", () => {
    barra_estado.classList.add('barra_verde');
    span.innerHTML = "Proceso Completo";

    contenido();
  });

  //enviar datos
  peticion.open('POST','../../consultas/vehi_archivos.php');
  peticion.send(new FormData (form));
  console.log(peticion.getAllResponseHeaders());

  //cancelar
  boton_cancelar.addEventListener("click", () => {
    peticion.abort();
    barra_estado.classList.remove('barra_verde');
    barra_estado.classList.add('barra_roja');
    span.innerHTML = "Proceso Cancelado";
  })

  

}



contenido();

//Borra archivos.
function borra(id){

var preg = confirm("Eliminar documneto, ¿desea continuar?");
if (preg==true) {


  $.ajax({
    url:"../../consultas/vehi_archivos_elimina.php",
    type:"POST",
    dataType:"html",
    data:{id:id},
    beforeSend: function(){
      $("#contenido").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
    },
    success: function(data){
      contenido();
    }
  })

}else{
  
}  


}















// Style input

var inputs = document.querySelectorAll('.file-input')

for (var i = 0, len = inputs.length; i < len; i++) {
  customInput(inputs[i])
}

function customInput (el) {
  const fileInput = el.querySelector('[type="file"]')
  const label = el.querySelector('[data-js-label]')
  
  fileInput.onchange =
  fileInput.onmouseout = function () {
    if (!fileInput.value) return
    
    var value = fileInput.value.replace(/^.*[\\\/]/, '')
    el.className += ' -chosen'
    label.innerText = value
  }
}