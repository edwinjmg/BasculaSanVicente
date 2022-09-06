<?php
	/*-------------------------
	Autor: Edwin Medina
	Mail: edwin.jmg@gmail.com
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: registro.php");
		exit;
        }
	$active_compras="";
	$active_ventas="";
	$active_caja="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$titulo="Nueva Compra | Deposito La Fortuna";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include("encabezado.php");?>
    <style>
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
    	-webkit-appearance: none;
    	margin: 0;
    }
    input[type=number] {
    	-moz-appearance:textfield;
    }
    </style>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
	<div class="panel panel-info">

		<div class="panel-heading">
			<div class="btn-group pull-right">
				<a  href="compras.php" class="btn btn-info"><span class="glyphicon glyphicon-list" ></span> Ver Compras</a>
			</div>
			<?php
				$sql_ultima_compra=mysqli_query($con,"select * from compras order by id_compra desc");
				$id_ultimo=mysqli_fetch_array($sql_ultima_compra);
				?>

			<h4><i class='glyphicon glyphicon-edit'></i> Nueva Compra <?php echo $id_ultimo['id_compra']+1 ?></h4>
		
		</div>

		<div class="panel-body">
		<?php 
			//include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			//include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" method="post" id="guardar_compra" name="guardar_compra">
				<div id="resultados_ajax_compra"></div>
				<div class="form-group row">
					<label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required>
						<input id="id_cliente" name="id_cliente" type='hidden'>	
					</div>
					<div class="col-md-1"><input class="form-control input-sm" type="text" id="id_cliente1" name="id_cliente1" disabled></div>		
					
					<label for="telefono_cliente" class="col-md-1 control-label">Teléfono </label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="telefono_cliente" name="telefono_cliente" placeholder="Teléfono" readonly>
					</div>
					<label for="nit_cliente" class="col-md-offset-0 col-md-1 control-label">NIT</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-sm" id="nit_cliente" name="nit_cliente" placeholder="NIT" >
					</div>
					
					<label for="saldo_cliente" class="col-md-offset-1 col-md-1 control-label"  style="font-size:20px">SALDO</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-sm" id="saldo_cliente" name="saldo_cliente"  style="font-size:20px;text-align: right;font-weight:bold" placeholder="SALDO" readonly>
					</div>
				
				</div>
				<div class="form-group row">
					<label for="usuario" class="col-md-1 control-label">Usuario</label>
					<div class="col-md-3">
						<select class="form-control input-sm" id="id_usuario" name="id_usuario">
							<?php
							$sql_usuario=mysqli_query($con,"select * from usuarios order by apellido");
							while ($rw=mysqli_fetch_array($sql_usuario)){
								$id_usuario=$rw["id_usuario"];
								$nombre_usuario=$rw["nombre"]." ".$rw["apellido"];
								if ($id_usuario==$_SESSION['id_usuario']){
									$selected="selected";
								} else {
									$selected="";
								}
							?>
							<option value="<?php echo $id_usuario?>" <?php echo $selected;?>><?php echo $nombre_usuario?></option>
							<?php
								}
							?>
						</select>
					</div>
					<label for="producto" class="col-md-1 control-label">Producto</label>
							<div class="col-md-3">
								<select class="form-control input-sm" id="id_producto" name="id_producto" required>
									<option value="" >Seleccione un Producto</option>
									<?php
										$sql_producto=mysqli_query($con,"select * from productos order by nombre_producto");
										while ($rw=mysqli_fetch_array($sql_producto)){
											$id_producto=$rw["id_producto"];
											$nombre_producto=$rw["nombre_producto"];
											/*if ($id_vendedor==$_SESSION['id_usuario']){
												$selected="selected";
											} else {
												$selected="";
											}*/
											$selected="";
											?>
											<option value="<?php echo $id_producto?>" <?php echo $selected;?>><?php echo $nombre_producto?></option>
											<?php
										}
									?>
								</select>
							</div>
							
							<!--<label for="tel2" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="fecha" value="<?php echo date("d/m/Y");?>" readonly>
							</div>-->
							
							<label for="pago" class="col-md-1 control-label">Pago</label>
							<div class="col-md-3">
								<select class='form-control input-sm' id="condiciones" name="condiciones" required>
									<option value="" >Forma de Pago</option>
									<option value="1">Efectivo</option>
									<option value="2">Crédito</option>
								</select>
							</div>
						</div>
				<div id="tara">
				<div class="form-group row">

				  <label for="peso_bruto" class="col-md-1 control-label">Peso Bascula</label>
				  <div class="col-md-2">
				  	<input type="number" min=0 step=0.5 class="form-control input-sm" id="peso_bruto" name="peso_bruto" value="0">
				  </div>				
				  <label for="saco_fibra" class="col-md-offset-1 col-md-1 control-label">#Sacos Fibra</label>
				  <div class="col-md-1">
				  	<input type="number" class="form-control input-sm" id="saco_fibra" name="saco_fibra" value="0">
				  </div>
				  <label for="saco_fique" class="col-md-offset-2 col-md-1 control-label">#Sacos Fique</label>
				  <div class="col-md-1">
				  	<input type="number" class="form-control input-sm" id="saco_fique" name="saco_fique" value="0">
				  </div>
				  <label for="tara_fibra" class="col-md-offset-4 col-md-1 control-label">Tara Fibra</label>
				  <div class="col-md-1">
					<input type="number" min=0 step=0.05 class="form-control input-sm" id="tara_fibra" name="tara_fibra" value="0.25">
				  </div>
				  <label for="tara_fique" class="col-md-offset-2 col-md-1 control-label">Tara Fique</label>
				  <div class="col-md-1">
					<input type="number" min=0 step=0.05 class="form-control input-sm" id="tara_fique" name="tara_fique" value="0.75">
				  </div>
				 </div>
				
				<div class="form-group row">

				  <label for="peso_compra" class="col-md-1 control-label">Peso Compra</label>
				  <div class="col-md-2">
				  	<input type="number" min=0 step 0.5 class="form-control input-sm" id="peso_compra" name="peso_compra" value="0" readonly>
				  </div>				
				  <label for="total_tara" class="col-md-offset-1 col-md-1 control-label">Total Tara</label>
				  <div class="col-md-1">
					<input type="number" min=0 step=0.5 class="form-control input-sm" id="total_tara" name="total_tara" value="0" readonly>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="precio_compra" class="col-md-offset-0 col-md-1 control-label">Precio Compra</label>
				  <div class="col-md-2">
				  	<input type="number" class="form-control input-sm" id="precio_compra" name="precio_compra" value="0">
				  </div>
				  <label for="precio_carga" class="col-md-offset-1 col-md-1 control-label">Precio Carga</label>
				  <div class="col-md-3">
				  	<input type="number" class="form-control input-sm" id="precio_carga" name="precio_carga" value="0" >
				  </div>
				  <label for="total_compra" class="col-md-offset-0 col-md-1 control-label">Total Compra</label>
				  <div class="col-md-3">
				  	<input type="number" class="form-control input-sm" id="total_compra" name="total_compra" value="0" readonly>
				  </div>
				 </div>
				</div>
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="submit" class="btn btn-default" id="registrar">
						 <span class="glyphicon glyphicon-search"></span> Registrar
						</button>
						<button type="button" class="btn btn-default" id="imprimir" name="imprimir">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</form>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>
	</div>
	<hr>
	<?php
	include("pie_pagina.php");
	?>
	<link rel="stylesheet" href="css/themes/smoothness/jquery-ui.css">
    <script src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/nueva_compra.js"></script>

	<script>

		$(function() {
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#id_cliente1').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#telefono_cliente').val(ui.item.telefono_cliente);
								$('#saldo_cliente').val(ui.item.saldo_cliente);
								$('#nit_cliente').val(ui.item.nit_cliente);
								console.log(ui);								
								
							 }

						});

						
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

	//console.log("probando aca")

	$("input").focus(function(){
		this.select();
	});

	TotalTara();
	PrecioCarga();
	PrecioKilo();
	//PesoCompra();
	//ValorTotal();
	//console.log("probando");
function ValorTotal(){	$("#total_compra").val(parseFloat($("#peso_compra").val())*parseInt($("#precio_compra").val()));
}

function PesoCompra(){
	$("#peso_bruto").on("keyup", function(){
		$("#peso_compra").val(parseFloat($("#peso_bruto").val())-parseFloat($("#total_tara").val()));
		ValorTotal()	
	})
	$("#peso_compra").val(parseFloat($("#peso_bruto").val())-parseFloat($("#total_tara").val()));
	ValorTotal()
}
function TotalTara(){
	var tara
	$("#tara").on("keyup", function(){
	tara=(parseFloat($("#tara_fique").val())*parseFloat($("#saco_fique").val()))+(parseFloat($("#tara_fibra").val())*parseFloat($("#saco_fibra").val()));
	$("#total_tara").val(redondear(tara));
	PesoCompra();
	ValorTotal();
})
}
function redondear(valor) { 
   var converted = parseFloat(valor); 
   var decimal = (converted - parseInt(converted, 10)); 
   decimal = Math.round(decimal * 10); 
   if (decimal == 5) { return (parseInt(converted, 10)+0.5); } 
   if ( (decimal < 1) || (decimal > 5) ) { 
      return Math.round(converted); 
   } else {
      return (parseInt(converted, 10)+0.5); 
   } 
}
function PrecioCarga() {
		$('#precio_compra').on('keyup', function(){
		$('#precio_carga').val(parseInt($(this).val())*125);
		ValorTotal();
		//console.log($(this).val());
		})
}
function PrecioKilo(){
	$('#precio_carga').on('keyup',function(){
		$('#precio_compra').val(parseInt($(this).val())/125);
		ValorTotal();
		//console.log($(this).val());
	})
}

	</script>

  </body>
</html>