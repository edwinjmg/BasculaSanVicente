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
			var q= $("#q").val();
			var fecha_inicial=$("#fecha_inicial").val();
			var fecha_final=$("#fecha_final").val();
			var id_producto=$("#id_producto").val();
			//console.log($("#id_producto").val());
			fecha_inicial=fecha_inicial.split("/");
			fecha_inicial.reverse();
			fecha_inicial=fecha_inicial.join("/");
			fecha_final=fecha_final.split("/");
			fecha_final.reverse();
			fecha_final=fecha_final.join("/");
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_ventas.php?action=ajax&page='+page+'&q='+q+'&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&id_producto='+id_producto,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true});
					$('#peso_total').val($('#suma_peso').val());
					$('#valor_total').val($('#suma_total').val());				
				}
			})
		}
$("#id_producto").change(function(){
	//alert("han cambiado mi valor por  "+ $("#id_producto option:selected").text() + "  y el codigo de producto es " + $("#id_producto").val());
	load(1);
})

		function imprimir_venta(id_venta){
			VentanaCentrada('./pdf/documentos/ver_venta.php?id_venta='+id_venta,'Venta','','1024','768','true');
		}