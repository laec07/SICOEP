// muestra aspirantes ingresados
function Show_data() {
	
	$.ajax({
		url:"../../views/pm_aspirantes.php",
		type:"POST",
		dataType:"",
		data:{},
		beforeSend: function(){
			$("#contenido").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			$("#contenido").html(data);
		}

	})
}
Show_data()

// inserta aspirantes
function insert_data() {
  
var nombre = document.getElementById('nombre').value
var email = document.getElementById('email').value
var tel = document.getElementById('tel').value
var dir = document.getElementById('dir').value
var dpi = document.getElementById('dpi').value
var tipo = document.getElementById('tipo').value
var numlic = document.getElementById('numlic').value
var fecha_venci = document.getElementById('fecha_venci').value
var experiencia = document.getElementById('experiencia').value

  $.ajax({
    url:"../../consultas/pm_insertaspirantes.php",
    type:"POST",
    dataType:"",
    data:{nombre:nombre,email:email,tel:tel,dir:dir,dpi:dpi,tipo:tipo,numlic:numlic,fecha_venci:fecha_venci,experiencia:experiencia},
    beforeSend: function(){
      $("#contenido").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
    },
    success: function(data){
      Show_data();
    }

  })
}



  //Hace funcionar los componentes de la tabla
    $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })

//trae datos para editar usuario
 $('#editUsu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient0 = button.data('id')
      var recipient1 = button.data('nombre')
      var recipient2 = button.data('email')
      var recipient3 = button.data('direccion')
      var recipient4 = button.data('tel')
      var recipient5 = button.data('dpi')
      var recipient6 = button.data('lic')
      var recipient7 = button.data('tipo')
      var recipient8 = button.data('fecha_venci')
      var recipient9 = button.data('experiencia_e')

      var modal = $(this)    
      modal.find('.modal-body #id').val(recipient0)
      modal.find('.modal-body #nombre').val(recipient1)
      modal.find('.modal-body #email').val(recipient2)
      modal.find('.modal-body #direccion').val(recipient3)  
      modal.find('.modal-body #tel').val(recipient4)
      modal.find('.modal-body #dpi').val(recipient5)
      modal.find('.modal-body #lic').val(recipient6)
      modal.find('.modal-body #tipo').val(recipient7)
      modal.find('.modal-body #fecha_venci_e').val(recipient8)
      modal.find('.modal-body #experiencia_e').val(recipient9)  
    });
//tae datos para guardar foto
 $('#editPick').on('show.bs.modal',function(event){
  var button = $(event.relatedTarget)
  var dato0 = button.data('id_piloto')

  var modal = $(this)
  modal.find('.modal-body #id_piloto').val(dato0)

 });
  $('#editLic').on('show.bs.modal',function(event){
  var button = $(event.relatedTarget)
  var dato0 = button.data('id_piloto')

  var modal = $(this)
  modal.find('.modal-body #id_piloto').val(dato0)

 });
//Visualizar imagen piloto
  (function(){
    function filePreview(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e){
          $('#imagePreview1').html("<img src='"+e.target.result+"'/ class= 'img2'>");
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#files1').change(function(){
      filePreview(this);
    })
  })();

    (function(){
    function filePreview(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e){
          $('#imagePreview2').html("<img src='"+e.target.result+"'/ class= 'img2'>");
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#files2').change(function(){
      filePreview(this);
    })
  })();