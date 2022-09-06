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
	$titulo="Caja | Deposito La Fortuna";
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
				<a  href="salidas.php" class="btn btn-info"><span class="glyphicon glyphicon-list" ></span> Salidas</a>
			</div>
			<div class="btn-group pull-right">
				&nbsp;
			</div>
			<div class="btn-group pull-right">
				<a  href="entradas.php" class="btn btn-info"><span class="glyphicon glyphicon-list" ></span> Entradas</a>
			</div>
			<div class="btn-group pull-right">
				&nbsp;
			</div>
			<div class="btn-group pull-right">
				<button type='button' class="btn btn-info" id="actualizar_saldo"><span class="glyphicon glyphicon-refresh" ></span> Actualizar Saldo</button>
			</div>
			<div class="btn-group pull-right">
				&nbsp;
			</div>
			<!--<div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#editarSaldo"><span class="glyphicon glyphicon-edit" ></span> Editar Saldo</button>
			</div>-->
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Movimientos</h4>
			<!--<button onclick="myFunction()">Print this page</button>-->
		</div>
			<div class="panel-body">
			<?php
				include("modal/registrar_saldo.php");
				include("modal/editar_saldo.php");
			?>
				<form class="form-horizontal" role="form" id="datos_caja">
						<div class="container">
							
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
					<div class="col-md-2">
						<div class="form-group row">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
						</div>
						</div>

				<div class="form-group">
				<label for="valor_inicial" class="col-md-1 control-label">Valor Inicial</label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="valor_inicial" name="valor_inicial" value="0" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="12">
				</div>
					<label for="valor_final" class="col-md-1 control-label" disabled>Valor Final</label>
				<div class="col-md-4">
				  <input type="text" class="form-control" id="valor_final" name="valor_final" placeholder="Valor Final de Caja" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="12">
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
	<script type="text/javascript" src="js/caja.js"></script>

  </body>
</html>