
		$(document).ready(function(){
			//load(1);
			TotalTara();
	PrecioCarga();
	PrecioKilo();
			//$( "#resultados" ).load( "ajax/editar_facturacion.php" );
		});

		/*function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/productos_factura.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}*/

	$( "#actualizar_venta" ).submit(function( event ) {
		  $('#actualizar').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/editar_venta.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_venta").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_venta").html(datos);
					$('#actualizar').attr("disabled", false);
				  }
			});
		  event.preventDefault();
		})

		function imprimir_venta(id_venta){
			VentanaCentrada('./pdf/documentos/ver_venta.php?id_venta='+id_venta,'Venta','','1024','768','true');
		}