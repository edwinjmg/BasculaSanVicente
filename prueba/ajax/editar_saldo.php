<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_fecha_saldo'])) {
           $errors[] = "Fecha de Saldo Inicial vacia";
        } else if (empty($_POST['mod_valor_saldo'])){
			$errors[] = "Valor de Saldo Inicial Vacio";
		} else if (
			!empty($_POST['mod_fecha_saldo']) &&
			!empty($_POST['mod_valor_saldo']) 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$fecha=mysqli_real_escape_string($con,(strip_tags($_POST["mod_fecha_saldo"],ENT_QUOTES)));
		$valor=mysqli_real_escape_string($con,(strip_tags($_POST["mod_valor_saldo"],ENT_QUOTES)));
		$sql_verificar="SELECT valor FROM saldo WHERE fecha_saldo=str_to_date('".$fecha."','%d/%m/%Y')";
		$query_verificar=mysqli_query($con,$sql_verificar);
		$verificado=mysqli_fetch_array($query_verificar);
		//echo $verificado['valor'];
		if (($verificado['valor'])) {
			# code...
		$sql="UPDATE saldo SET   valor='".$valor."' WHERE fecha_saldo=str_to_date('".$fecha."','%d/%m/%Y')";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "El Saldo ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Primero cree un Saldo Inicial para el '".$fecha."'.";
		}
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