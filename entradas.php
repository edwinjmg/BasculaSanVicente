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
	$titulo="Nueva Entrada | Deposito La Fortuna";
	
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
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevaEntrada"><span class="glyphicon glyphicon-plus" ></span> Nueva Entrada</button>
			</div>
			<h4><i class='glyphicon glyphicon-edit'></i> Entradas</h4>
		</div>
				<div class="panel-body">
		<?php 
			include("modal/registrar_entrada.php");
			include("modal/editar_entrada.php")
		?>
			<!--<form class="form-horizontal" method="post" id="guardar_compra" name="guardar_compra">-->
				<form class="form-horizontal" role="form" id="datos_entradas">
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
							<div class="col-md-2">
						<div class="form-group row">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
						</div>		
						</div>
			</form>	
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		  <div class="row-fluid">
			<div class="col-md-12">
			<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>	
		 </div>
		</div>
	</div>		

	</div>
	<hr>
	<?php
	include("pie_pagina.php");
	?>
	<link rel="stylesheet" href="css/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/entradas.js"></script>

  </body>
</html>
