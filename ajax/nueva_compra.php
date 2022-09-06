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
		$id_producto=mysqli_real_escape_string($con,(strip_tags($_POST["id_producto"],ENT_QUOTES)));
		//$nombre_producto=mysqli_real_escape_string($con,(strip_tags($_POST["nombre_producto"],ENT_QUOTES)));
		$peso_bruto=mysqli_real_escape_string($con,(strip_tags($_POST["peso_bruto"],ENT_QUOTES)));
		$saco_fibra=mysqli_real_escape_string($con,(strip_tags($_POST["saco_fibra"],ENT_QUOTES)));
		$saco_fique=mysqli_real_escape_string($con,(strip_tags($_POST["saco_fique"],ENT_QUOTES)));
		$tara_fibra=mysqli_real_escape_string($con,(strip_tags($_POST["tara_fibra"],ENT_QUOTES)));
		$tara_fique=mysqli_real_escape_string($con,(strip_tags($_POST["tara_fique"],ENT_QUOTES)));
		$peso_compra=mysqli_real_escape_string($con,(strip_tags($_POST["peso_compra"],ENT_QUOTES)));
		$precio_compra=mysqli_real_escape_string($con,(strip_tags($_POST["precio_compra"],ENT_QUOTES)));
		$total_compra=mysqli_real_escape_string($con,(strip_tags($_POST["total_compra"],ENT_QUOTES)));
		$condiciones=mysqli_real_escape_string($con,(strip_tags($_POST["condiciones"],ENT_QUOTES)));
		$estado_compra=1;
		date_default_timezone_set('America/Bogota');
		$fecha_compra=date("Y-m-d H:i:s");

		$sql_compra="INSERT INTO compras (id_cliente,id_usuario,id_producto,peso_bruto,saco_fibra,saco_fique,tara_fibra,tara_fique,peso_compra,precio_compra,total_compra,condiciones,estado_compra,fecha_compra) VALUES ('$id_cliente','$id_usuario','$id_producto','$peso_bruto','$saco_fibra','$saco_fique','$tara_fibra','$tara_fique','$peso_compra','$precio_compra','$total_compra','$condiciones','$estado_compra','$fecha_compra')";
		$query_compra = mysqli_query($con,$sql_compra);
		if ($query_compra){
				$ultima_compra = mysqli_insert_id($con);
		$sql_producto="INSERT INTO movimiento_producto (fecha_movimiento,id_producto,id_cliente,id_compra,entrada) VALUES ('$fecha_compra','$id_producto','$id_cliente','$ultima_compra','$peso_compra')";
    	$query_mov_producto=mysqli_query($con,$sql_producto);
		$sql_cliente="INSERT INTO movimiento_cliente (fecha_movimiento,id_producto,id_cliente,id_compra,descripcion,valor_entrada) VALUES ('$fecha_compra','$id_producto','$id_cliente','$ultima_compra','COMPRA ','$total_compra')";
    	$query_mov_cliente=mysqli_query($con,$sql_cliente);

    	//echo "New record created successfully. Last inserted ID is: " . $last_id;
    	if ($condiciones==1){
    		$sql_salida="INSERT INTO salida (fecha_salida,id_cliente,id_usuario,id_compra,descripcion,valor_salida) VALUES ('$fecha_compra','$id_cliente' ,'$id_usuario','$ultima_compra','COMPRA $ultima_compra','$total_compra')";
    	$query_salida=mysqli_query($con,$sql_salida);
    	if ($query_salida){
				$ultima_salida = mysqli_insert_id($con);
    	//echo "New record created successfully. Last inserted ID is: " . $last_id;

    	$sql_caja="INSERT INTO caja (fecha_caja,id_cliente,id_usuario,id_salida,descripcion_salida,valor_salida) VALUES ('$fecha_compra','$id_cliente' ,'$id_usuario','$ultima_salida','COMPRA $ultima_compra','$total_compra')";
    			$query_caja = mysqli_query($con,$sql_caja);

 		$sql_cliente="INSERT INTO movimiento_cliente (fecha_movimiento,id_producto,id_cliente,id_salida,descripcion,valor_salida) VALUES ('$fecha_compra','$id_producto','$id_cliente','$ultima_salida','PAGO COMPRA $ultima_compra','$total_compra')";
    	$query_mov_cliente=mysqli_query($con,$sql_cliente);
   			
    	}
    	
    		}
				$messages[] = "Compra ha sido ingresada satisfactoriamente.";
			} else{
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