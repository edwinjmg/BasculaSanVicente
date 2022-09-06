<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$id_venta= $_SESSION['id_venta'];
	/*Inicia validacion del lado del servidor
	if (empty($_POST['id_cliente'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['id_usuario'])) {
           $errors[] = "Selecciona el usuario";
        } else if (empty($_POST['condiciones'])){
			$errors[] = "Selecciona forma de pago";
		} else if ($_POST['estado_venta']==""){
			$errors[] = "Selecciona el estado de la venta";
		} else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_usuario']) &&
			!empty($_POST['condiciones']) &&
			$_POST['estado_venta']!="" 
		){
		Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		//$id_cliente=intval($_POST['id_cliente']);
		//$id_usuario=intval($_POST['id_usuario']);
		//$condiciones=intval($_POST['condiciones']);

		//$estado_venta=intval($_POST['estado_venta']);
		$id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST["id_cliente"],ENT_QUOTES)));
		$id_usuario=mysqli_real_escape_string($con,(strip_tags($_POST["id_usuario"],ENT_QUOTES)));
		$id_producto=mysqli_real_escape_string($con,(strip_tags($_POST["id_producto"],ENT_QUOTES)));
		$condiciones=mysqli_real_escape_string($con,(strip_tags($_POST["condiciones1"],ENT_QUOTES)));
		$peso_bruto=mysqli_real_escape_string($con,(strip_tags($_POST["peso_bruto"],ENT_QUOTES)));
		$sacos=mysqli_real_escape_string($con,(strip_tags($_POST["sacos"],ENT_QUOTES)));
		$tara=mysqli_real_escape_string($con,(strip_tags($_POST["tara1"],ENT_QUOTES)));
		$peso_venta=mysqli_real_escape_string($con,(strip_tags($_POST["peso_venta"],ENT_QUOTES)));
		$precio_venta=mysqli_real_escape_string($con,(strip_tags($_POST["precio_venta"],ENT_QUOTES)));
		$total_venta=mysqli_real_escape_string($con,(strip_tags($_POST["total_venta"],ENT_QUOTES)));

		
		$sql="UPDATE ventas SET id_cliente='".$id_cliente."', id_usuario='".$id_usuario."', id_producto='".$id_producto."', peso_bruto='".$peso_bruto."', sacos='".$sacos."', tara='".$tara."', peso_venta='".$peso_venta."', precio_venta='".$precio_venta."', total_venta='".$total_venta."' WHERE id_venta='".$id_venta."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
		$sql_producto="UPDATE movimiento_producto SET id_cliente='".$id_cliente."', id_producto='".$id_producto."', salida='".$peso_venta."' WHERE id_venta='".$id_venta."'";
		$query_producto = mysqli_query($con,$sql_producto);
		$sql_cliente="UPDATE movimiento_cliente SET id_cliente='".$id_cliente."', valor_salida='".$total_venta."' WHERE id_venta='".$id_venta."'";
		$query_cliente = mysqli_query($con,$sql_cliente);
		if ($condiciones==1) {
			# code...
		$sql_entrada="UPDATE entrada SET id_cliente='".$id_cliente."', valor_entrada='".$total_venta."' WHERE id_venta='".$id_venta."'";
		$query_entrada = mysqli_query($con,$sql_entrada);
		$sql="SELECT id_entrada from entrada WHERE id_venta='".$id_venta."'";
    	$sql_query= mysqli_query($con,$sql);
    	$row= mysqli_fetch_array($sql_query);
		$id_entrada = $row['id_entrada'];	

		$sql_caja="UPDATE caja SET id_cliente='".$id_cliente."', valor_entrada='".$total_venta."' WHERE id_entrada='".$id_entrada."'";
		$query_caja = mysqli_query($con,$sql_caja);

		$sql_ciente="UPDATE movimiento_cliente SET id_cliente='".$id_cliente."', valor_entrada='".$total_venta."' WHERE id_entrada='".$id_entrada."'";
		$query_cliente = mysqli_query($con,$sql_cliente);

		}

				$messages[] = "La Venta ha sido actualizada satisfactoriamente.";
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