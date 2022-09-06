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
		///$nombre_producto=mysqli_real_escape_string($con,(strip_tags($_POST["nombre_producto"],ENT_QUOTES)));
		$peso_bruto=mysqli_real_escape_string($con,(strip_tags($_POST["peso_bruto"],ENT_QUOTES)));
		$sacos=mysqli_real_escape_string($con,(strip_tags($_POST["saco"],ENT_QUOTES)));
		$tara=mysqli_real_escape_string($con,(strip_tags($_POST["tara1"],ENT_QUOTES)));
		$peso_venta=mysqli_real_escape_string($con,(strip_tags($_POST["peso_venta"],ENT_QUOTES)));
		$precio_venta=mysqli_real_escape_string($con,(strip_tags($_POST["precio_venta"],ENT_QUOTES)));
		$total_venta=mysqli_real_escape_string($con,(strip_tags($_POST["total_venta"],ENT_QUOTES)));
		$condiciones=mysqli_real_escape_string($con,(strip_tags($_POST["condiciones"],ENT_QUOTES)));
		$estado_venta=1;
		date_default_timezone_set('America/Bogota');
		$fecha_venta=date("Y-m-d H:i:s");
		//echo $fecha_venta;

		$sql_venta="INSERT INTO ventas (id_cliente,id_usuario,id_producto,peso_bruto,sacos,tara,peso_venta,precio_venta,total_venta,condiciones,estado_venta,fecha_venta) VALUES ('$id_cliente','$id_usuario','$id_producto','$peso_bruto','$sacos','$tara','$peso_venta','$precio_venta','$total_venta','$condiciones','$estado_venta','$fecha_venta')";
		$query_venta = mysqli_query($con,$sql_venta);
			if ($query_venta){
				$ultima_venta = mysqli_insert_id($con);
		$sql_producto="INSERT INTO movimiento_producto (fecha_movimiento,id_producto,id_cliente,id_venta,salida) VALUES ('$fecha_venta','$id_producto','$id_cliente','$ultima_venta','$peso_venta')";
    	$query_mov_producto=mysqli_query($con,$sql_producto);
		$sql_cliente="INSERT INTO movimiento_cliente (fecha_movimiento,id_producto,id_cliente,id_venta,descripcion,valor_salida) VALUES ('$fecha_venta','$id_producto','$id_cliente','$ultima_venta','VENTA','$total_venta')";
    	$query_mov_cliente=mysqli_query($con,$sql_cliente);
    	//echo "New record created successfully. Last inserted ID is: " . $last_id;
    	if ($condiciones==1) {
    		$sql_entrada="INSERT INTO entrada (fecha_entrada,id_cliente,id_usuario,id_venta,descripcion,valor_entrada) VALUES ('$fecha_venta','$id_cliente' ,'$id_usuario','$ultima_venta','VENTA $ultima_venta','$total_venta')";
    	$query_entrada=mysqli_query($con,$sql_entrada);
    	if ($query_entrada){
				$ultima_entrada = mysqli_insert_id($con);
    	//echo "New record created successfully. Last inserted ID is: " . $last_id;

    	$sql_caja="INSERT INTO caja (fecha_caja,id_cliente,id_usuario,id_entrada,descripcion_entrada,valor_entrada) VALUES ('$fecha_venta','$id_cliente' ,'$id_usuario','$ultima_entrada','VENTA $ultima_venta','$total_venta')";
    			$query_caja= mysqli_query($con,$sql_caja);
  		$sql_cliente="INSERT INTO movimiento_cliente (fecha_movimiento,id_producto,id_cliente,id_entrada,descripcion,valor_entrada) VALUES ('$fecha_venta','$id_producto','$id_cliente','$ultima_entrada','PAGO VENTA $ultima_venta','$total_venta')";
  				//echo $sql_cliente;
    	$query_mov_cliente=mysqli_query($con,$sql_cliente);
   	}
    	
    		}
				$messages[] = "Venta ha sido ingresada satisfactoriamente.";
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