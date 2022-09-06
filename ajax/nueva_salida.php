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
		$id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST["id_cliente"],ENT_QUOTES)));
		$id_usuario=mysqli_real_escape_string($con,(strip_tags($_POST["id_usuario"],ENT_QUOTES)));
		$id_banco=mysqli_real_escape_string($con,(strip_tags($_POST["id_banco"],ENT_QUOTES)));
		/*$peso_bruto=mysqli_real_escape_string($con,(strip_tags($_POST["peso_bruto"],ENT_QUOTES)));
		$sacos=mysqli_real_escape_string($con,(strip_tags($_POST["saco"],ENT_QUOTES)));
		$tara=mysqli_real_escape_string($con,(strip_tags($_POST["tara1"],ENT_QUOTES)));
		$peso_venta=mysqli_real_escape_string($con,(strip_tags($_POST["peso_venta"],ENT_QUOTES)));
		$precio_venta=mysqli_real_escape_string($con,(strip_tags($_POST["precio_venta"],ENT_QUOTES)));*/
		$descripcion=mysqli_real_escape_string($con,(strip_tags($_POST["detalle"],ENT_QUOTES)));
		$valor_salida=mysqli_real_escape_string($con,(strip_tags($_POST["valor"],ENT_QUOTES)));
		date_default_timezone_set('America/Bogota');
		$fecha_salida=date("Y-m-d H:i:s");
		$sql_salida="INSERT INTO salida (fecha_salida,id_cliente,id_banco,id_usuario,descripcion,valor_salida) VALUES ('$fecha_salida','$id_cliente' ,'$id_banco', '$id_usuario','$descripcion','$valor_salida')";
    	$query_salida=mysqli_query($con,$sql_salida);

		
		//echo $sql;

			if ($query_salida){
				$id_salida = mysqli_insert_id($con);
     			$sql_caja="INSERT INTO caja (fecha_caja,id_cliente,id_banco,id_usuario,id_salida,descripcion_salida,valor_salida) VALUES ('$fecha_salida','$id_cliente' , '$id_banco', '$id_usuario','$id_salida','$descripcion','$valor_salida')";
    			$query_caja = mysqli_query($con,$sql_caja);
				$id_caja = mysqli_insert_id($con);
    	
    			if (empty($id_banco)){
    				$sql_cliente="INSERT INTO movimiento_cliente (fecha_movimiento,id_cliente,id_salida,descripcion,valor_salida) VALUES ('$fecha_salida','$id_cliente','$id_salida','$descripcion','$valor_salida')";
    				$query_cliente = mysqli_query($con,$sql_cliente);
					$id_mov_cliente = mysqli_insert_id($con);
				} 
				
				else {
					$sql="INSERT INTO entrada_banco (fecha_entrada_banco,id_banco,id_usuario,id_salida_caja,descripcion,valor_entrada_banco) VALUES ('$fecha_salida','$id_banco' ,'$id_usuario','$id_salida','$descripcion','$valor_salida')";
    				$query_new_insert = mysqli_query($con,$sql);
    				
    				if ($query_new_insert){
    					$id_entrada_banco = mysqli_insert_id($con);
   						$sql="INSERT INTO movimiento_banco (fecha_movimiento,id_banco,id_usuario,id_entrada_banco,descripcion_entrada,valor_entrada_banco) VALUES ('$fecha_salida','$id_banco' ,'$id_usuario','$id_entrada_banco','$descripcion','$valor_salida')";
    					$query_new_insert = mysqli_query($con,$sql);
    				}
    			}

    			$messages[] = "Salida ha sido ingresada satisfactoriamente.";
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