//header
function header(){


	$.ajax({
		url:"../../views/header.php",
		type:"POST",
		data:{},
		beforeSend: function(){
			$("#general_header").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			//ejecuta función
			$("#general_header").html(data);
			
		}
	})
}
 header()

//header
function footer(){


	$.ajax({
		url:"../../views/header.php",
		type:"POST",
		data:{},
		beforeSend: function(){
			$("#general_footer").html("<img src = '../../dist/images/loading4.gif' width='50px'  >");
		},
		success: function(data){
			//ejecuta función
			$("#general_footer").html(data);
			
		}
	})
}