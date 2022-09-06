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

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_compras="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$titulo="Bancos | Deposito La Fortuna";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include("encabezado.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoBanco"><span class="glyphicon glyphicon-plus" ></span> Nuevo Banco</button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Bancos</h4>
		</div>
		<div class="panel-body">
		
			
			
			<?php
			include("modal/registro_bancos.php");
			include("modal/editar_bancos.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Nombre ó Número de Cuenta</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre ó Número de Cuenta" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			
		
	
			
			
			
  </div>
</div>
		 
	</div>
	<hr>
	<?php
	include("pie_pagina.php");
	?>
	<script type="text/javascript" src="js/bancos.js"></script>
  </body>
</html>
<script>
	function obtener_datos(id){
			var nombre_cuenta = $("#nombre_cuenta"+id).val();
			var numero_cuenta = $("#numero_cuenta"+id).val();
			$("#mod_id").val(id);
			$("#mod_nombre").val(nombre_cuenta);
			$("#mod_numero").val(numero_cuenta);
		}	
</script>