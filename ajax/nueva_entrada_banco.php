<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	/*if (empty($_POST['nombre'])) {
           $errors[] = "Nombre vacío";
        } else if (!empty($_POST['nombre'])){*/
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST["id_cliente1"],ENT_QUOTES)));
		$id_usuario=mysqli_real_escape_string($con,(strip_tags($_POST["id_usuario1"],ENT_QUOTES)));
		$id_banco=mysqli_real_escape_string($con,(strip_tags($_POST["id_banco1"],ENT_QUOTES)));
		/*$peso_bruto=mysqli_real_escape_string($con,(strip_tags($_POST["peso_bruto"],ENT_QUOTES)));
		$sacos=mysqli_real_escape_string($con,(strip_tags($_POST["saco"],ENT_QUOTES)));
		$tara=mysqli_real_escape_string($con,(strip_tags($_POST["tara1"],ENT_QUOTES)));
		$peso_venta=mysqli_real_escape_string($con,(strip_tags($_POST["peso_venta"],ENT_QUOTES)));
		$precio_venta=mysqli_real_escape_string($con,(strip_tags($_POST["precio_venta"],ENT_QUOTES)));*/
		$descripcion=mysqli_real_escape_string($con,(strip_tags($_POST["detalle1"],ENT_QUOTES)));
		$valor_entrada=mysqli_real_escape_string($con,(strip_tags($_POST["valor1"],ENT_QUOTES)));
		date_default_timezone_set('America/Bogota');
		$fecha_entrada=date("Y-m-d H:i:s");
		$sql_entrada="INSERT INTO entrada_banco (fecha_entrada_banco,id_cliente,id_banco,id_usuario,descripcion,valor_entrada_banco) VALUES ('$fecha_entrada','$id_cliente' ,'$id_banco', '$id_usuario','$descripcion','$valor_entrada')";
    	$query_entrada=mysqli_query($con,$sql_entrada);

		if ($query_entrada){
    					$id_entrada_banco = mysqli_insert_id($con);
   						$sql="INSERT INTO movimiento_banco (fecha_movimiento,id_banco,id_cliente,id_usuario,id_entrada_banco,descripcion_entrada,valor_entrada_banco) VALUES ('$fecha_entrada','$id_banco', '$id_cliente' ,'$id_usuario','$id_entrada_banco','$descripcion','$valor_entrada')";
    					$query_new_insert = mysqli_query($con,$sql);
    				
		//echo $sql;

			if ($query_new_insert){
    				$sql_cliente="INSERT INTO movimiento_cliente (fecha_movimiento,id_cliente,id_banco,id_entrada_banco,descripcion,valor_entrada) VALUES ('$fecha_entrada','$id_cliente','$id_banco','$id_entrada_banco','$descripcion','$valor_entrada')";
    				$query_cliente = mysqli_query($con,$sql_cliente);
				
    				
    			}

    			$messages[] = "Entrada ha sido ingresada satisfactoriamente.";
    		} 

    		else {
    			$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
    		}

		/*} else {
			$errors []= "Error desconocido.";
		}*/
		
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

?>