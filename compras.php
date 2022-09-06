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
	$titulo="Compras | Deposito La Fortuna";
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

?>
<!DOCTYPE html>
<html lang="es">
  <head>
	<?php 
		include("encabezado.php");
	?>
  </head>
  <body>
	<?php
		include("navbar.php");
	?>
	<div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">
			<div class="btn-group pull-right">
				<a  href="nueva_compra.php" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nueva Compra</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Compras</h4>
		</div>
			<div class="panel-body">
			<?php
				//include("modal/registro_compras.php");
				include("modal/editar_clientes.php");
			?>
				<form class="form-horizontal" role="form" id="datos_compras">
						<div class="container">
							<div class='col-md-5'>
        					<div class="form-group">
							<label for="fecha_inicial" class="col-md-2 control-label">Fecha Inicial</label>
							<div class="col-md-6 input-group date" data-provide="datepicker" >
								<input type="text" id="fecha_inicial" name="fecha_inicial" class="form-control">
								<div class="input-group-addon">
        							<span class="glyphicon glyphicon-th"></span>
    							</div>
							</div>
						</div>
					</div>
					<div class='col-md-5'>
        					<div class="form-group">
							<label for="fecha_final" class="col-md-2 control-label">Fecha Final</label>
							<div class="col-md-6 input-group date" data-provide="datepicker">
								<input type="text" id="fecha_final" name="fecha_final" class="form-control">
								<div class="input-group-addon">
        							<span class="glyphicon glyphicon-th"></span>
    							</div>
							</div>
						</div>
					</div>
						</div>
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Cliente o # de Compra</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre del cliente o # de Compra" onkeyup='load(1);'>
							</div>

							<div class="col-md-2">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							<label for="promedio" class="col-md-1 control-label">Promedio</label>
							<div class="col-md-2 " >
								<input type="text" id="promedio" name="promedio" style="font-size:12pt;text-align:right;font-weight: bold;" class="form-control" readonly>
							</div>
						</div>

							<div class="form-group row">
								<label for="producto" class="col-md-offset-1 col-md-1 control-label">Producto</label>
								<div class="col-md-3">
									<select class="form-control input-sm" id="id_producto" name='id_producto'>
										<option value="">Todos</option>
										<?php
											$sql_producto=mysqli_query($con,"select * from productos order by nombre_producto");
											while ($rw=mysqli_fetch_array($sql_producto)){
												$id_producto=$rw["id_producto"];
												$nombre_producto=$rw["nombre_producto"];
												$selected="";
										?>
											<option value="<?php echo $id_producto?>" <?php echo $selected;?>><?php echo $nombre_producto?></option>
											<?php
											}
											?>
									</select>
							</div>
							<div class="form-group">
							<label for="peso_total" class="col-md-1 control-label">Peso Total</label>
							<div class="col-md-2 " >
								<input type="text" id="peso_total" name="peso_total" style="font-size:12pt;text-align:right;font-weight: bold;" class="form-control" readonly>
							</div>
							<label for="valor_total" class="col-md-1 control-label">Valor Total</label>
							<div class="col-md-2 " >
								<input type="text" id="valor_total" name="valor_total" style="font-size:12pt;text-align:right;font-weight: bold;" class="form-control" readonly>
							</div>

						</div>
						</div>
			</form>
				<!--<div id="resultados"></div> Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
		</div>
	</div>
	<?php
	include("pie_pagina.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/compras.js"></script>

  </body>
</html>