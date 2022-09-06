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
	//console.log (fecha_hoy);
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
			var q= $("#q").val();
			var fecha_inicial=$("#fecha_inicial").val();
			var fecha_final=$("#fecha_final").val();
			var valor_inicial=$("#valor_inicial").val();
			//console.log(valor_inicial);
			fecha_inicial=fecha_inicial.split("/");
			fecha_inicial.reverse();
			fecha_inicial=fecha_inicial.join("/");
			fecha_final=fecha_final.split("/");
			fecha_final.reverse();
			fecha_final=fecha_final.join("/");
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_movimientos_bancos.php?action=ajax&page='+page+'&q='+q+'&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&valor_inicial='+valor_inicial,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('#valor_final').val($('#saldo').val());					
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					$('#valor_final').val($('#saldo_final').val());
				}
			})
		}
						/*$("#q").autocomplete({
							source: "./ajax/autocomplete/bancos.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#telefono_cliente').val(ui.item.telefono_cliente);
								$('#nit_cliente').val(ui.item.nit_cliente);
								console.log(ui);								
								
							 }

						});*/


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
	$( "#guardar_entrada" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros1 = $(this).serialize();
		 console.log(parametros1);
			 $.ajax({
					type: "POST",
					url: "ajax/nueva_entrada.php",
					data: parametros1,
					 beforeSend: function(objeto){
						$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					cargar_entradas(1);
				  }
			});
		  event.preventDefault();
		})
	$('#valor_inicial').change(function(){
		load(1);
	});