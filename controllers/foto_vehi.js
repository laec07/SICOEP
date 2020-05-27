function show(placa) {

	$.ajax({
		url:"../../views/vehi_fotos.php",
		type:"post",
		dataType:"html",
		data:{placa:placa},
		beforeSend: function (){
			document.getElementById("muestra_fotos").innerHTML="<img class='img-thumbnail' src = '../../dist/images/loading4.gif' width='50px'  >"
		},
		success: function (data){
			$("#muestra_fotos").html(data);
		}
	});
}
var i=1;
function comparar(ruta){

if (i==1) {
	document.getElementById("foto1").innerHTML="<img src='"+ruta+"' width='500px' >";
	i++;
} else if (i==2) {
	document.getElementById("foto2").innerHTML="<img src='"+ruta+"' width='500px' >";
	i--;
}
}