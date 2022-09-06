<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (!empty($_POST['fecha_final'])) {
           
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha_final"],ENT_QUOTES)));
		$fecha1=date_create_from_format('d/m/Y',$fecha);
		$fecha2=date_format($fecha1,'Y-m-d');
		/*$nueva_fecha = strtotime ( '-1 day' , strtotime ( $fecha2 ) ) ;
		$nueva_fecha = date ( 'Y-m-d' , $nueva_fecha );
		echo $nueva_fecha;
		echo '<br>';*/
		echo 'fecha ';
		echo $fecha2;
		$sql_fecha="SELECT * from saldo where fecha_saldo<'".$fecha2."' order by fecha_saldo desc limit 1";
		$query_fecha=mysqli_query($con,$sql_fecha);
		$fecha_anterior_saldo=mysqli_fetch_array($query_fecha);
		echo '<br> fecha anterior';
		echo $fecha_anterior_saldo['fecha_saldo'];
		echo '<br> saldo anterior';
		echo $fecha_anterior_saldo['valor'];
		//$valor=mysqli_real_escape_string($con,(strip_tags($_POST["mod_valor_saldo"],ENT_QUOTES)));
		$sql_entradas="SELECT sum(valor_entrada) as total_entradas FROM caja WHERE fecha_caja BETWEEN '".$fecha_anterior_saldo['fecha_saldo']."' and '".$fecha2."'";
		$query_entradas=mysqli_query($con,$sql_entradas);
		$suma_entradas=mysqli_fetch_array($query_entradas);
		echo '<br> suma entradas';
		echo $suma_entradas['total_entradas'];
		
		$sql_salidas="SELECT sum(valor_salida) as total_salidas FROM caja WHERE fecha_caja BETWEEN '".$fecha_anterior_saldo['fecha_saldo']."' and '".$fecha2."'";
		$query_salidas=mysqli_query($con,$sql_salidas);
		$suma_salidas=mysqli_fetch_array($query_salidas);
		echo '<br> suma salidas';
		echo ($suma_salidas['total_salidas']); 
		
		$sql_saldo_anterior="SELECT valor FROM saldo WHERE fecha_saldo='".$fecha_anterior_saldo['fecha_saldo']."'";
		$query_saldo_anterior=mysqli_query($con,$sql_saldo_anterior);
		$saldo_anterior=mysqli_fetch_array($query_saldo_anterior);


		$sql_saldo="SELECT valor FROM saldo WHERE fecha_saldo='".$fecha2."'";
		$query_saldo=mysqli_query($con,$sql_saldo);
		$saldo=mysqli_fetch_array($query_saldo);
		$nuevo_saldo=$saldo_anterior['valor']+$suma_entradas['total_entradas']-$suma_salidas['total_salidas'];
		if ($saldo) {
			
			$sql="UPDATE saldo SET   valor='".$nuevo_saldo."' WHERE fecha_saldo='".$fecha2."'";
			$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "El Saldo ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		}else{
			$sql="INSERT INTO saldo (fecha_registro,fecha_saldo, valor) VALUES (now(),'$fecha2','$nuevo_saldo')";
			$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "El Saldo Inicial ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
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
			}
			mysqli_close($con);
			echo $_POST['fecha_final'];
			echo 'saldo <br>';
			echo $nuevo_saldo;
			//echo $sql_salidas;
			?>
