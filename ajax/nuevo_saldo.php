<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
if (empty($_POST['fecha_saldo'])){
			$errors[] = "Fecha de Caja se encuentra vacia";
		} else if(empty($_POST['valor_saldo'])){
			$errors[] = "Valor Saldo Inicial se encuentra vacio";
		} else if (
			!empty($_POST['fecha_saldo']) &&
			!empty($_POST['valor_saldo'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha_saldo"],ENT_QUOTES)));
		$valor=mysqli_real_escape_string($con,(strip_tags($_POST["valor_saldo"],ENT_QUOTES)));
		$sql="INSERT INTO saldo (fecha_registro,fecha_saldo, valor) VALUES (now(),str_to_date('$fecha','%d/%m/%Y'),'$valor')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "El Saldo Inicial ha sido ingresado satisfactoriamente.";
			} else{
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