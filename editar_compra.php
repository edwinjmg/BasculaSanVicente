<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: registro.php");
		exit;
        }
	$active_inicio="";
	$active_clientes="";
	$active_caja="";
	$active_compras="";
	$active_ventas="";
	$active_productos="";
	$active_usuarios="";
	$titulo="Editar Compra | Deposito La Fortuna";
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	if (isset($_GET['id_compra']))
	{
		$id_compra=intval($_GET['id_compra']);
		$campos="clientes.id_cliente, clientes.nombre_cliente, clientes.telefono_cliente, clientes.nit_cliente, compras.id_usuario, compras.fecha_compra, compras.condiciones, compras.estado_compra,compras.id_producto,compras.peso_bruto,compras.saco_fibra,compras.saco_fique,compras.tara_fibra,compras.tara_fique,compras.peso_compra,compras.precio_compra,compras.total_compra,productos.id_producto,productos.nombre_producto";
		$sql_compra=mysqli_query($con,"select $campos from compras,clientes,productos where compras.id_cliente=clientes.id_cliente and productos.id_producto=compras.id_producto and id_compra='".$id_compra."'");
		$count=mysqli_num_rows($sql_compra);
		if ($count==1)
		{
				$rw_compra=mysqli_fetch_array($sql_compra);
				$id_cliente=$rw_compra['id_cliente'];
				$nombre_cliente=$rw_compra['nombre_cliente'];
				$telefono_cliente=$rw_compra['telefono_cliente'];
				$nit_cliente=$rw_compra['nit_cliente'];
				$id_usuario_db=$rw_compra['id_usuario'];
				$fecha_compra=date("d/m/Y", strtotime($rw_compra['fecha_compra']));
				$condiciones=$rw_compra['condiciones'];
				$estado_compra=$rw_compra['estado_compra'];
				$id_producto_db=$rw_compra['id_producto'];
				$peso_bruto=$rw_compra['peso_bruto'];
				$saco_fibra=$rw_compra['saco_fibra'];
				$saco_fique=$rw_compra['saco_fique'];
				$tara_fibra=$rw_compra['tara_fibra'];
				$tara_fique=$rw_compra['tara_fique'];
				$peso_compra=$rw_compra['peso_compra'];
				$precio_compra=$rw_compra['precio_compra'];
				$total_compra=$rw_compra['total_compra'];
				$id_producto=$rw_compra['id_producto'];
				$nombre_producto=$rw_compra['nombre_producto'];
				$_SESSION['id_compra']=$id_compra;
				//$_SESSION['numero_compra']=$numero_compra;
		}	
		else
		{
			header("location: compras.php");
			exit;	
		}
	} 
	else 
	{
		header("location: compras.php");
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
				<a  href="compras.php" class="btn btn-info"><span class="glyphicon glyphicon-list" ></span> Ver Compras</a>
			</div>
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Compra</h4>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" method="post" id="actualizar_compra" name="actualizar_compra">
				<div id="resultados_ajax"></div>
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
				  <label for="saco_fibra" class="col-md-offset-1 col-md-1 control-label">#Sacos Fibra</label>
				  <div class="col-md-1">
				  	<input type="number" class="form-control input-sm" id="saco_fibra" name="saco_fibra" value="<?php echo $saco_fibra;?>">
				  </div>
				  <label for="saco_fique" class="col-md-offset-2 col-md-1 control-label">#Sacos Fique</label>
				  <div class="col-md-1">
				  	<input type="number" class="form-control input-sm" id="saco_fique" name="saco_fique" value="<?php echo $saco_fique;?>">
				  </div>
				  <label for="tara_fibra" class="col-md-offset-4 col-md-1 control-label">Tara Fibra</label>
				  <div class="col-md-1">
					<input type="number" min=0 step=0.05 class="form-control input-sm" id="tara_fibra" name="tara_fibra" value="<?php echo $tara_fibra;?>">
				  </div>
				  <label for="tara_fique" class="col-md-offset-2 col-md-1 control-label">Tara Fique</label>
				  <div class="col-md-1">
					<input type="number" min=0 step=0.05 class="form-control input-sm" id="tara_fique" name="tara_fique" value="<?php echo $tara_fique;?>">
				  </div>
				 </div>
				
				<div class="form-group row">

				  <label for="peso_compra" class="col-md-1 control-label">Peso Compra</label>
				  <div class="col-md-2">
				  	<input type="number" min=0 step 0.5 class="form-control input-sm" id="peso_compra" name="peso_compra" value="<?php echo $peso_compra;?>" readonly>
				  </div>				
				  <label for="total_tara" class="col-md-offset-1 col-md-1 control-label">Total Tara</label>
				  <div class="col-md-1">
					<input type="number" min=0 step=0.5 class="form-control input-sm" id="total_tara" name="total_tara" value="<?php echo $peso_bruto-$peso_compra;?>" readonly>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="precio_compra" class="col-md-offset-0 col-md-1 control-label">Precio Compra</label>
				  <div class="col-md-2">
				  	<input type="number" class="form-control input-sm" id="precio_compra" name="precio_compra" value="<?php echo $precio_compra;?>">
				  </div>
				  <label for="precio_carga" class="col-md-offset-1 col-md-1 control-label">Precio Carga</label>
				  <div class="col-md-3">
				  	<input type="number" class="form-control input-sm" id="precio_carga" name="precio_carga" value="<?php echo $precio_compra*125;?>" >
				  </div>
				  <label for="total_compra" class="col-md-offset-0 col-md-1 control-label">Total Compra</label>
				  <div class="col-md-3">
				  	<input type="number" class="form-control input-sm" id="total_compra" name="total_compra" value="<?php echo $total_compra;?>" readonly>
				  </div>
				 </div>
				</div>
				<div class="col-md-12">
					<div class="pull-right">
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-refresh" id="actualizar"></span> Actualizar Datos
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
						<button type="button" class="btn btn-default" onclick="imprimir_compra('<?php echo $id_compra;?>')">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
				<div class="editar_compra" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("pie_pagina.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_compra.js"></script>
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