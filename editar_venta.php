<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: registro.php");
		exit;
        }
	$active_inicio="";
	$active_clientes="";
	$active_caja="";
	$active_ventas="";
	$active_ventas="";
	$active_productos="";
	$active_usuarios="";
	$titulo="Editar Venta | Deposito La Fortuna";
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	if (isset($_GET['id_venta']))
	{
		$id_venta=intval($_GET['id_venta']);
		$campos="clientes.id_cliente, clientes.nombre_cliente, clientes.telefono_cliente, clientes.nit_cliente, ventas.id_usuario, ventas.fecha_venta, ventas.condiciones, ventas.estado_venta,ventas.id_producto,ventas.peso_bruto,ventas.sacos,ventas.tara,ventas.peso_venta,ventas.precio_venta,ventas.total_venta,productos.id_producto,productos.nombre_producto";
		$sql_venta=mysqli_query($con,"select $campos from ventas,clientes,productos where ventas.id_cliente=clientes.id_cliente and productos.id_producto=ventas.id_producto and id_venta='".$id_venta."'");
		$count=mysqli_num_rows($sql_venta);
		if ($count==1)
		{
				$rw_venta=mysqli_fetch_array($sql_venta);
				$id_cliente=$rw_venta['id_cliente'];
				$nombre_cliente=$rw_venta['nombre_cliente'];
				$telefono_cliente=$rw_venta['telefono_cliente'];
				$nit_cliente=$rw_venta['nit_cliente'];
				$id_usuario_db=$rw_venta['id_usuario'];
				$fecha_venta=date("d/m/Y", strtotime($rw_venta['fecha_venta']));
				$condiciones=$rw_venta['condiciones'];
				$estado_venta=$rw_venta['estado_venta'];
				$id_producto_db=$rw_venta['id_producto'];
				$peso_bruto=$rw_venta['peso_bruto'];
				$sacos=$rw_venta['sacos'];
				$tara=$rw_venta['tara'];
				$peso_venta=$rw_venta['peso_venta'];
				$precio_venta=$rw_venta['precio_venta'];
				$total_venta=$rw_venta['total_venta'];
				$id_producto=$rw_venta['id_producto'];
				$nombre_producto=$rw_venta['nombre_producto'];
				$_SESSION['id_venta']=$id_venta;
				//$_SESSION['numero_venta']=$numero_venta;
		}	
		else
		{
			header("location: ventas.php");
			exit;	
		}
	} 
	else 
	{
		header("location: ventas.php");
		exit;
	}
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
				<a  href="ventas.php" class="btn btn-info"><span class="glyphicon glyphicon-list" ></span> Ver Ventas</a>
			</div>
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Venta</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" method="post" id="actualizar_venta" name="actualizar_venta">
				<div id="resultados_ajax_venta"></div>
				<div class="form-group row">
					<label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="nombre_cliente" id="nombre_cliente" placeholder="Selecciona un cliente" required value="<?php echo $nombre_cliente;?>">
						<input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">	
					</div>
					<label for="telefono_cliente" class="col-md-1 control-label">Teléfono</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="telefono_cliente" name="telefono_cliente" placeholder="Teléfono" readonly value="<?php echo $telefono_cliente;?>">
					</div>
					<label for="nit_cliente" class="col-md-offset-0 col-md-1 control-label">NIT</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="nit_cliente" name="nit_cliente" placeholder="NIT" readonly value="<?php echo $nit_cliente;?>">
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
								if ($id_usuario==$id_usuario_db){
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
								<select class="form-control input-sm" id="id_producto" name="id_producto">
									<?php
										$sql_producto=mysqli_query($con,"select * from productos order by nombre_producto");
										while ($rw=mysqli_fetch_array($sql_producto)){
											$id_producto=$rw["id_producto"];
											$nombre_producto=$rw["nombre_producto"];
											if ($id_producto==$id_producto_db){
												$selected="selected";
											} else {
												$selected="";
											}
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
								<select class='form-control input-sm' id="condiciones" name="condiciones" disabled>
									<option value="1" <?php if ($condiciones==1){echo "selected";}?>>Efectivo</option>
									<option value="2" <?php if ($condiciones==2){echo "selected";}?>>Crédito</option>
								</select>
								<input type="hidden" value="<?php echo $condiciones;?>" id="condiciones1" name="condiciones1">
							</div>
						</div>
				<div id="tara">
				<div class="form-group row">

				  <label for="peso_bruto" class="col-md-1 control-label">Peso Bascula</label>
				  <div class="col-md-2">
				  	<input type="number" min=0 step=0.5 class="form-control input-sm" id="peso_bruto" name="peso_bruto" value="<?php echo $peso_bruto;?>">
				  </div>				
				  <label for="sacos" class="col-md-offset-1 col-md-1 control-label">#Sacos</label>
				  <div class="col-md-1">
				  	<input type="number" class="form-control input-sm" id="sacos" name="sacos" value="<?php echo $sacos;?>">
				  </div>
				  <label for="tara1" class="col-md-offset-4 col-md-1 control-label">Tara</label>
				  <div class="col-md-1">
					<input type="number" min=0 step=0.05 class="form-control input-sm" id="tara1" name="tara1" value="<?php echo $tara;?>">
				  </div>
				 </div>
				
				<div class="form-group row">

				  <label for="peso_venta" class="col-md-1 control-label">Peso venta</label>
				  <div class="col-md-2">
				  	<input type="number" min=0 step 0.5 class="form-control input-sm" id="peso_venta" name="peso_venta" value="<?php echo $peso_venta;?>" readonly>
				  </div>				
				  <label for="total_tara" class="col-md-offset-1 col-md-1 control-label">Total Tara</label>
				  <div class="col-md-1">
					<input type="number" min=0 step=0.5 class="form-control input-sm" id="total_tara" name="total_tara" value="0" readonly>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="precio_venta" class="col-md-offset-0 col-md-1 control-label">Precio venta</label>
				  <div class="col-md-2">
				  	<input type="number" class="form-control input-sm" id="precio_venta" name="precio_venta" value="<?php echo $precio_venta;?>">
				  </div>
				  <label for="precio_carga" class="col-md-offset-1 col-md-1 control-label">Precio Carga</label>
				  <div class="col-md-3">
				  	<input type="number" class="form-control input-sm" id="precio_carga" name="precio_carga" value="<?php echo $precio_venta*125;?>" >
				  </div>
				  <label for="total_venta" class="col-md-offset-0 col-md-1 control-label">Total venta</label>
				  <div class="col-md-3">
				  	<input type="number" class="form-control input-sm" id="total_venta" name="total_venta" value="<?php echo $total_venta;?>" readonly>
				  </div>
				 </div>
				</div>
				<div class="col-md-12">
					<div class="pull-right">
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-refresh" id="actualizar"></span> Actualizar datos
						</button>
						<!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>-->
						<button type="button" class="btn btn-default" onclick="imprimir_venta('<?php echo $id_venta;?>')">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
				<div class="editar_venta" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("pie_pagina.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_venta.js"></script>
	<link rel="stylesheet" href="css/themes/smoothness/jquery-ui.css">
    <script src="js/jquery-ui.js"></script>
	<script>
		$(function() {
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#telefono_cliente').val(ui.item.telefono_cliente);
								$('#nit_cliente').val(ui.item.nit_cliente);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_cliente" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
						}
			});	

	$("input").focus(function(){
		this.select();
	});

	TotalTara();
	PrecioCarga();
	PrecioKilo();
	//Pesoventa();
	//ValorTotal();
	//console.log("probando");
function ValorTotal(){	$("#total_venta").val(parseFloat($("#peso_venta").val())*parseInt($("#precio_venta").val()));
}

function Pesoventa(){
	$("#peso_bruto").on("keyup", function(){
		$("#peso_venta").val(parseFloat($("#peso_bruto").val())-parseFloat($("#total_tara").val()));
		ValorTotal()	
	})
	$("#peso_venta").val(parseFloat($("#peso_bruto").val())-parseFloat($("#total_tara").val()));
	ValorTotal()
}
function TotalTara(){
	var tara2
	$("#tara").on("keyup", function(){
	tara2=(parseFloat($("#tara1").val())*parseFloat($("#sacos").val()));
	$("#total_tara").val(redondear(tara2));
	Pesoventa();
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
		$('#precio_venta').on('keyup', function(){
		$('#precio_carga').val(parseInt($(this).val())*125);
		ValorTotal();
		//console.log($(this).val());
		})
}
function PrecioKilo(){
	$('#precio_carga').on('keyup',function(){
		$('#precio_venta').val(parseInt($(this).val())/125);
		ValorTotal();
		//console.log($(this).val());
	})
}

	</script>

  </body>
</html>