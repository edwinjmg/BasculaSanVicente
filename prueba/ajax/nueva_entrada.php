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
		$valor_entrada=mysqli_real_escape_string($con,(strip_tags($_POST["valor"],ENT_QUOTES)));
		date_default_timezone_set('America/Bogota');
		$fecha_entrada=date("Y-m-d H:i:s");
		$sql_entrada="INSERT INTO entrada (fecha_entrada,id_cliente,id_banco,id_usuario,id_venta,descripcion,valor_entrada) VALUES ('$fecha_entrada','$id_cliente' ,'$id_banco', '$id_usuario','0','$descripcion','$valor_entrada')";
    	$query_entrada=mysqli_query($con,$sql_entrada);

		
		//echo $sql;

			if ($query_entrada){
				$id_entrada = mysqli_insert_id($con);
     			$sql_caja="INSERT INTO caja (fecha_caja,id_cliente,id_banco,id_usuario,id_entrada,descripcion_entrada,valor_entrada) VALUES ('$fecha_entrada','$id_cliente' , '$id_banco', '$id_usuario','$id_entrada','$descripcion','$valor_entrada')";
    			$query_caja = mysqli_query($con,$sql_caja);
				$id_caja = mysqli_insert_id($con);
    	
    			if (empty($id_banco)){
    				$sql_cliente="INSERT INTO movimiento_cliente (fecha_movimiento,id_cliente,id_entrada,descripcion,valor_entrada) VALUES ('$fecha_entrada','$id_cliente','$id_entrada','$descripcion','$valor_entrada')";
    				$query_cliente = mysqli_query($con,$sql_cliente);
					$id_mov_cliente = mysqli_insert_id($con);
				} 
				
				else {
					$sql="INSERT INTO salida_banco (fecha_salida_banco,id_banco,id_usuario,id_entrada_caja,descripcion,valor_salida_banco) VALUES ('$fecha_entrada','$id_banco' ,'$id_usuario','$id_entrada','$descripcion','$valor_entrada')";
    				$query_new_insert = mysqli_query($con,$sql);
    				
    				if ($query_new_insert){
    					$id_salida_banco = mysqli_insert_id($con);
   						$sql="INSERT INTO movimiento_banco (fecha_movimiento,id_banco,id_usuario,id_salida_banco,descripcion_salida,valor_salida_banco) VALUES ('$fecha_entrada','$id_banco' ,'$id_usuario','$id_salida_banco','$descripcion','$valor_entrada')";
    					$query_new_insert = mysqli_query($con,$sql);
    				}
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