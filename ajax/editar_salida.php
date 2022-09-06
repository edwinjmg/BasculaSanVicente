<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['mod_id_cliente']) && empty($_POST['mod_id_banco'])){
			$errors[] = "Nombre del Cliente ó Numero de Cuenta vacío";
		} else if (empty($_POST['mod_detalle'])){
			$errors[] = "Descripcion Vacia";
		} else if (empty($_POST['mod_valor'])){
			$errors[] = "Valor de Salida vacío";
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
		$valor_salida=floatval($_POST['mod_valor']);
		$id_salida=$_POST['mod_id'];
		$sql="UPDATE salida SET  id_cliente='".$id_cliente."', id_banco='".$id_banco."', descripcion='".$descripcion."', valor_salida='".$valor_salida."' WHERE id_salida='".$id_salida."'";
		$query_update = mysqli_query($con,$sql);
			
			if ($query_update){
     			$sql_caja="UPDATE caja SET id_cliente='".$id_cliente."', id_banco='".$id_banco."', descripcion_salida='".$descripcion."', valor_salida='".$valor_salida."' WHERE id_salida='".$id_salida."'";
    			$query_caja = mysqli_query($con,$sql_caja);
    	
    			if (empty($id_banco)){

    				$sql_cliente="UPDATE movimiento_cliente SET id_cliente='".$id_cliente."', descripcion='".$descripcion."', valor_salida='".$valor_salida."' WHERE id_salida='".$id_salida."'";
    				$query_cliente = mysqli_query($con,$sql_cliente);
				} 
				
				else {
					$sql="UPDATE entrada_banco SET id_banco='".$id_banco."',descripcion='".$descripcion."' ,valor_entrada_banco='".$valor_salida."' WHERE id_salida_caja='".$id_salida."'";
    				$query_new_insert = mysqli_query($con,$sql);
    				$sql="SELECT id_entrada_banco from entrada_banco WHERE id_salida_caja='".$id_salida."'";
    				$sql_query= mysqli_query($con,$sql);
    				$row= mysqli_fetch_array($sql_query);
					$id_entrada_banco = $row['id_entrada_banco'];
   				//echo $id_salida_banco;
   						$sql="UPDATE movimiento_banco SET id_banco='".$id_banco."',descripcion_entrada='".$descripcion."' ,valor_entrada_banco='".$valor_salida."' WHERE id_entrada_banco='".$id_entrada_banco."'";
    					$query_new_insert = mysqli_query($con,$sql);
    				}
				$messages[] = "Salida ha sido actualizada satisfactoriamente.";
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