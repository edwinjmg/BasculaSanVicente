		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_bancos.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el producto")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_bancos.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
$( "#guardar_banco" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_banco.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_bancos").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_bancos").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_banco" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_banco.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			var id_producto = $("#id_producto"+id).val();
			var nombre_producto = $("#nombre_producto"+id).val();
			var precio_producto = $("#precio_producto"+id).val();
			$("#mod_id").val(id_producto);
			$("#mod_nombre").val(nombre_producto);
			$("#mod_precio").val(precio_producto);
		}	
		
		

