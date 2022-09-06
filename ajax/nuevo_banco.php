<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
if (empty($_POST['nombre'])){
			$errors[] = "Nombre de la Cuenta vacío";
		} else if(empty($_POST['numero'])){
			$errors[] = "Numero de Cuenta vacío";
		} else if (
			!empty($_POST['nombre']) &&
			!empty($_POST['numero'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$numero=mysqli_real_escape_string($con,(strip_tags($_POST["numero"],ENT_QUOTES)));
		$sql="INSERT INTO bancos (nombre_cuenta, numero_cuenta) VALUES ('$nombre','$numero')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "La Cuenta ha sido ingresada satisfactoriamente.";
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