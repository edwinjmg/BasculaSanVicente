<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$sql="UPDATE clientes ,( SELECT id_cliente, (SUM(valor_entrada)-SUM(valor_salida)) saldo FROM movimiento_cliente GROUP BY id_cliente ) T2 SET clientes.saldo = T2.saldo WHERE clientes.id_cliente = T2.id_cliente;";
			$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "La Cartera ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		

		if (isset($errors)){
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Error!</strong>
				<?php
				foreach ($errors as $error) {
					echo $error;
				}
				?>
				</div>
				<?php
			}
			if (isset($messages)){
				?>
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>¡Bien hecho!</strong>
					<?php
					foreach ($messages as $message) {
						echo $message;
					}
					?>
					</div>
					<?php
				}
			
			mysqli_close($con);
			//echo $sql_salidas;
			?>