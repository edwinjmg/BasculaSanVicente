		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_cartera.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

$( "#actualizar_cartera" ).click(function( event ) {
		 $.ajax({
					type: "POST",
					url: "ajax/actualizar_cartera.php",
					 beforeSend: function(objeto){
					  },
					success: function(datos){
						load(1);								
				  }
				
			});

			 event.preventDefault();
})