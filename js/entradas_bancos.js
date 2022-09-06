$(document).ready(function(){

	$.fn.datepicker.dates['en'] = {
    days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
    daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
    daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
    today: "Hoy",
    clear: "Limpiar",
    format: "dd/mm/yyyy",
    titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
    weekStart: 0
	};
	$('#fecha_inicial')
		.datepicker().on('change', function(){
        $('.datepicker').hide();
        load(1)
    });
	$('#fecha_final').datepicker().on('change', function(){
        $('.datepicker').hide();
        load(1)
    });
	var fecha_hoy= new Date();
	var fecha_anterior= new Date();
	fecha_hoy=fecha_hoy.getDate()+'/'+(fecha_hoy.getMonth()+1)+'/'+fecha_hoy.getFullYear();
	fecha_anterior.setDate(fecha_anterior.getDate()-7);
	fecha_anterior=fecha_anterior.getDate()+'/'+(fecha_anterior.getMonth()+1)+'/'+fecha_anterior.getFullYear();
	//console.log(fecha_hoy);
	//console.log(fecha_anterior);
	$('#fecha_inicial').val(fecha_anterior);
	$('#fecha_final').val(fecha_hoy);
	load(1);
});
		
		function load(page){
			var q= $("#nombre_cuenta1").val();
			var fecha_inicial=$("#fecha_inicial").val();
			var fecha_final=$("#fecha_final").val();
			//console.log($("#id_producto").val());
			fecha_inicial=fecha_inicial.split("/");
			fecha_inicial.reverse();
			fecha_inicial=fecha_inicial.join("/");
			fecha_final=fecha_final.split("/");
			fecha_final.reverse();
			fecha_final=fecha_final.join("/");
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_entradas_bancos.php?action=ajax&page='+page+'&q='+q+'&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}
						$("#nombre_cliente1").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente1').val(ui.item.id_cliente);
								$('#nombre_cliente1').val(ui.item.nombre_cliente);
								//$('#telefono_cliente').val(ui.item.telefono_cliente);
								//$('#nit_cliente').val(ui.item.nit_cliente);
								console.log(ui);								
								
							 }

						});
						
						$("#mod_nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#mod_id_cliente').val(ui.item.id_cliente);
								$('#mod_nombre_cliente').val(ui.item.nombre_cliente);
								//$('#telefono_cliente').val(ui.item.telefono_cliente);
								//$('#nit_cliente').val(ui.item.nit_cliente);
								console.log(ui);								
								
							 }

						});

						$("#mod_nombre_cuenta").autocomplete({
							source: "./ajax/autocomplete/bancos.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#mod_id_banco').val(ui.item.id_banco);
								$('#mod_nombre_cuenta').val(ui.item.nombre_cuenta);
								//$('#mod_telefono_cliente').val(ui.item.telefono_cliente);
								//$('#mod_nit_cliente').val(ui.item.nit_cliente);
								console.log(ui);								
								
							 }

						});

						$("#nombre_cuenta1").autocomplete({
							source: "./ajax/autocomplete/bancos.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_banco1').val(ui.item.id_banco);
								$('#nombre_cuenta1').val(ui.item.nombre_cuenta);
								$('#numero_cuenta').val(ui.item.numero_cuenta);
								console.log(ui);								
								
							 }

						});

						$("#mod_nombre_cuenta1").autocomplete({
							source: "./ajax/autocomplete/bancos.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#mod_id_banco').val(ui.item.id_banco);
								$('#mod_nombre_cuenta').val(ui.item.nombre_cuenta);
								$('#mod_numero_cuenta').val(ui.item.numero_cuenta);
								console.log(ui);								
								
							 }

						});
	
	$("#nombre_cliente" ).on( "keydown", function( event ) {

						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#nit" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#nit" ).val("");
						}


			});
	$( "#guardar_entrada_banco" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros1 = $(this).serialize();
		 console.log(parametros1);
			 $.ajax({
					type: "POST",
					url: "ajax/nueva_entrada_banco.php",
					data: parametros1,
					 beforeSend: function(objeto){
						$("#resultados_ajax_entradas").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_entradas").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
					location.reload();
				  }
			});
		  event.preventDefault();
		});

$( "#editar_entrada_banco" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_entrada_banco.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_entradas2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_entradas2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
			location.reload();
		  }
	});
  event.preventDefault();
})

    	function obtener_datos(id){
			var nombre_cliente = $("#nombre_cliente"+id).val();
			var nombre_cuenta=$("#nombre_cuenta"+id).val();
			var id_cliente = $("#id_cliente"+id).val();
			var id_banco=$("#id_banco"+id).val();
			var descripcion=$("#descripcion"+id).val();
			var valor_entrada = $("#valor_entrada_banco"+id).val();
			//alert(nombre_cliente);
			$("#mod_id").val(id);
			$("#mod_id_cliente").val(id_cliente);
			$("#mod_id_banco").val(id_banco);
			$("#mod_detalle").val(descripcion);
			$("#mod_valor").val(valor_entrada);
			$("#mod_nombre_cliente").val(nombre_cliente);
			$("#mod_nombre_cuenta").val(nombre_cuenta);
		}
		function imprimir_entrada_banco(id_entrada){
			VentanaCentrada('./pdf/documentos/ver_entrada_banco.php?id_entrada='+id_entrada,'Entrada_Banco','','1024','768','true');
		}