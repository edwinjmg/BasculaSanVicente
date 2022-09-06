<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$id_compra= $_SESSION['id_compra'];
	/*Inicia validacion del lado del servidor
	if (empty($_POST['id_cliente'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['id_usuario'])) {
           $errors[] = "Selecciona el usuario";
        } else if (empty($_POST['condiciones'])){
			$errors[] = "Selecciona forma de pago";
		} else if ($_POST['estado_compra']==""){
			$errors[] = "Selecciona el estado de la compra";
		} else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_usuario']) &&
			!empty($_POST['condiciones']) &&
			$_POST['estado_compra']!="" 
		){
		Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		//$id_cliente=intval($_POST['id_cliente']);
		//$id_usuario=intval($_POST['id_usuario']);
		//$condiciones=intval($_POST['condiciones']);

		//$estado_compra=intval($_POST['estado_compra']);
		$id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST["id_cliente"],ENT_QUOTES)));
		$id_usuario=mysqli_real_escape_string($con,(strip_tags($_POST["id_usuario"],ENT_QUOTES)));
		$id_producto=mysqli_real_escape_string($con,(strip_tags($_POST["id_producto"],ENT_QUOTES)));
		$condiciones=mysqli_real_escape_string($con,(strip_tags($_POST["condiciones1"],ENT_QUOTES)));
		$peso_bruto=mysqli_real_escape_string($con,(strip_tags($_POST["peso_bruto"],ENT_QUOTES)));
		$saco_fibra=mysqli_real_escape_string($con,(strip_tags($_POST["saco_fibra"],ENT_QUOTES)));
		$saco_fique=mysqli_real_escape_string($con,(strip_tags($_POST["saco_fique"],ENT_QUOTES)));
		$tara_fibra=mysqli_real_escape_string($con,(strip_tags($_POST["tara_fibra"],ENT_QUOTES)));
		$tara_fique=mysqli_real_escape_string($con,(strip_tags($_POST["tara_fique"],ENT_QUOTES)));
		$peso_compra=mysqli_real_escape_string($con,(strip_tags($_POST["peso_compra"],ENT_QUOTES)));
		$precio_compra=mysqli_real_escape_string($con,(strip_tags($_POST["precio_compra"],ENT_QUOTES)));
		$total_compra=mysqli_real_escape_string($con,(strip_tags($_POST["total_compra"],ENT_QUOTES)));

		
		$sql_compra="UPDATE compras SET id_cliente='".$id_cliente."', id_usuario='".$id_usuario."', id_producto='".$id_producto."', peso_bruto='".$peso_bruto."', saco_fibra='".$saco_fibra."', saco_fique='".$saco_fique."', tara_fibra='".$tara_fibra."', tara_fique='".$tara_fique."', peso_compra='".$peso_compra."', precio_compra='".$precio_compra."', total_compra='".$total_compra."' WHERE id_compra='".$id_compra."'";
		$query_compra = mysqli_query($con,$sql_compra);
			if ($query_compra){
		$sql_producto="UPDATE movimiento_producto SET id_cliente='".$id_cliente."', id_producto='".$id_producto."', entrada='".$peso_compra."' WHERE id_compra='".$id_compra."'";
		$query_producto = mysqli_query($con,$sql_producto);
		$sql_cliente="UPDATE movimiento_cliente SET id_cliente='".$id_cliente."', id_producto='".$id_producto."', valor_entrada='".$total_compra."' WHERE id_compra='".$id_compra."'";
		$query_cliente = mysqli_query($con,$sql_cliente);
		if ($condiciones==1) {
			# code...
		$sql_salida="UPDATE salida SET id_cliente='".$id_cliente."', valor_salida='".$total_compra."' WHERE id_compra='".$id_compra."'";
		$query_salida = mysqli_query($con,$sql_salida);
		$sql="SELECT id_salida from salida WHERE id_compra='".$id_compra."'";
    	$sql_query= mysqli_query($con,$sql);
    	$row= mysqli_fetch_array($sql_query);
		$id_salida = $row['id_salida'];	

		$sql_caja="UPDATE caja SET id_cliente='".$id_cliente."', valor_salida='".$total_compra."' WHERE id_salida='".$id_salida."'";
		$query_caja = mysqli_query($con,$sql_caja);

		$sql_ciente="UPDATE movimiento_cliente SET id_cliente='".$id_cliente."', id_producto='".$id_producto."', valor_salida='".$total_compra."' WHERE id_salida='".$id_salida."'";
		$query_cliente = mysqli_query($con,$sql_cliente);

		}
				$messages[] = "La Compra ha sido actualizada satisfactoriamente.";
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

?>