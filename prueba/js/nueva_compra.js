
		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			/*$.ajax({
				url:'./ajax/productos_compra.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})*/
		}

	function agregar (id)
		{
			var precio_venta=document.getElementById('precio_venta_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
			//Inicia validacion
			if (isNaN(cantidad))
			{
			alert('Esto no es un numero');
			document.getElementById('cantidad_'+id).focus();
			return false;
			}
			if (isNaN(precio_venta))
			{
			alert('Esto no es un numero');
			document.getElementById('precio_venta_'+id).focus();
			return false;
			}
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});
		}
		
			function eliminar (id)
		{
			
			$.ajax({
        type: "GET",
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		
		/*$("#datos_compra").submit(function(){
		  var id_cliente = $("#id_cliente").val();
		  var id_usuario = $("#id_usuario").val();
		  //var condiciones = $("#condiciones").val();
		  
		  if (id_cliente==""){
			  alert("Debes seleccionar un cliente");
			  $("#nombre_cliente").focus();
			  return false;
		  }
		 VentanaCentrada('./pdf/documentos/compra_pdf.php?id_cliente='+id_cliente+'&id_usuario='+id_usuario/*+'&condiciones='+condiciones*//*,'Compra','','1024','768','true');
	 	});*/
		
		$( "#guardar_cliente" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
		 console.log(parametros);
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_cliente.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})
		
		$( "#guardar_producto" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_productos").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_productos").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})

	$( "#guardar_compra" ).submit(function( event ) {
		  $('#registrar').attr("disabled", true);
		  
		 var parametros1 = $(this).serialize();

		 //console.log(parametros1);
			 $.ajax({
					type: "POST",
					url: "ajax/nueva_compra.php",
					data: parametros1,
					 beforeSend: function(objeto){
						$("#resultados_ajax_compra").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_compra").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})

	$( "#nit_cliente" ).keypress(function(e) {
       if(e.which == 13) {
       	var nit=$( "#nit_cliente" ).val();
          // Acciones a realizar, por ej: enviar formulario.
			 $.ajax({
					type: "GET",
					url: "ajax/nit.php",
					data: {nit},
					 beforeSend: function(objeto){
					  },
					success: function(datos){
								var respuesta=JSON.parse(datos);
								if (respuesta === undefined || respuesta.length == 0) {
									alert("El cliente no esta Registrado \nRegistrelo en NUEVO CLIENTE");
								$('#id_cliente').value="";
								$('#id_cliente1').value="";
								$('#nombre_cliente').value="";
								$('#telefono_cliente').value="";
								$('#saldo_cliente').value="";
								//$('#nit_cliente').value="";
								}else{
								$('#id_cliente').val(respuesta[0].id_cliente);
								$('#id_cliente1').val(respuesta[0].id_cliente);
								$('#nombre_cliente').val(respuesta[0].nombre_cliente);
								$('#telefono_cliente').val(respuesta[0].telefono_cliente);
								$('#saldo_cliente').val(respuesta[0].saldo_cliente);
								$('#nit_cliente').val(respuesta[0].nit_cliente);
								//console.log(respuesta[0]);
				  }
				}
			});
       }
    });
		 //console.log(parametros1);


$("#imprimir").click(function(){
				VentanaCentrada('./pdf/documentos/compra_pdf.php?','Compra','','1024','768','true');
				location.reload();
})
