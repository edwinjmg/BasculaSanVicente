<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['mod_id_cliente'])) {
			$errors[] = "Nombre del Cliente ";
        } else if (empty($_POST['mod_id_banco'])) {
			$errors[] = "Numero de Cuenta Vacio ";			
		} else if (empty($_POST['mod_detalle'])){
			$errors[] = "Descripcion Vacia";
		} else if (empty($_POST['mod_valor'])){
			$errors[] = "Valor de Entrada vacío";
		} else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_detalle']) &&
			!empty($_POST['mod_valor'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$descripcion=mysqli_real_escape_string($con,(strip_tags($_POST["mod_detalle"],ENT_QUOTES)));
		$id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST["mod_id_cliente"],ENT_QUOTES)));
		$id_banco=mysqli_real_escape_string($con,(strip_tags($_POST["mod_id_banco"],ENT_QUOTES)));
		$valor_entrada=floatval($_POST['mod_valor']);
		$id_entrada=$_POST['mod_id'];
		$sql="UPDATE entrada_banco SET  id_cliente='".$id_cliente."', id_banco='".$id_banco."', descripcion='".$descripcion."', valor_entrada_banco='".$valor_entrada."' WHERE id_entrada_banco='".$id_entrada."'";
		$query_update = mysqli_query($con,$sql);
			
			if ($query_update){

    				$sql_cliente="UPDATE movimiento_cliente SET id_cliente='".$id_cliente."', id_banco='".$id_banco."', descripcion='".$descripcion."', valor_entrada='".$valor_entrada."' WHERE id_entrada_banco='".$id_entrada."'";
    				$query_cliente = mysqli_query($con,$sql_cliente);

   				//echo $id_salida_banco;
   						$sql="UPDATE movimiento_banco SET id_banco='".$id_banco."', id_cliente='".$id_cliente."',descripcion_entrada='".$descripcion."' ,valor_entrada_banco='".$valor_entrada."' WHERE id_entrada_banco='".$id_entrada."'";
    					$query_new_insert = mysqli_query($con,$sql);
    				
				$messages[] = "Entrada ha sido actualizada satisfactoriamente.";
			}else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
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