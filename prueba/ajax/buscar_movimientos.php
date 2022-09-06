<?php

	/*-------------------------
	Autor: Edwin Medina
	Mail: edwin.jmg@gmail.com
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';


	

	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         //$fecha_inicial = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_inicial'], ENT_QUOTES)));
         $fecha_final = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_final'], ENT_QUOTES)));
         $valor_inicial = mysqli_real_escape_string($con,(strip_tags($_REQUEST['valor_inicial'], ENT_QUOTES)));         
		 $sTable = " caja LEFT JOIN bancos ON caja.id_banco=bancos.id_banco LEFT JOIN clientes ON caja.id_cliente=clientes.id_cliente";
		 $sWhere = "";
		 $sWhere.=" LEFT JOIN usuarios ON caja.id_usuario=usuarios.id_usuario  ";
		/*if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' or caja.id_caja like '%$q%')";
			
		}*/
		$sWhere.=" WHERE caja.fecha_caja between '$fecha_final' and '$fecha_final 23:59:59'";
		$sWhere.=" order by caja.id_caja desc";
		/*include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		//echo $sWhere;
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		//$total_pages = ceil($numrows/$per_page);
		$reload = './cajas.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql="SELECT * FROM  $sTable $sWhere ";
		$query = mysqli_query($con, $sql);
		$sql_saldo="SELECT valor FROM saldo WHERE fecha_saldo='$fecha_final' ";
		$query_saldo=mysqli_query($con,$sql_saldo);
		$saldo_inicial=mysqli_fetch_array($query_saldo);
		//loop through fetched data
		?>
		<input type="hidden" name="saldo_inicial" id="saldo_inicial" value="<?php echo number_format ($saldo_inicial['valor'],0); ?>">
		<?php
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			$saldo=$saldo_inicial['valor'];
			?>
			<div class="table-responsive">
			
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Fecha</th>
					<!--<th>Cliente ó Nombre de Cuenta</th>-->
					<th>Descripción</th>
					<th class='text-right'>Entrada</th>
					<th class='text-right'>Salida</th>
					<th class='text-right'>Saldo</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					//print_r(array_values($row));
						$id_caja=$row['id_caja'];
						//$numero_compra=$row['numero_compra'];
						$fecha=date("d/m/Y", strtotime($row['fecha_caja']));
						$nombre_cliente=$row['nombre_cliente'];
						$nombre_cuenta=$row['nombre_cuenta'];
						$telefono_cliente=$row['telefono_cliente'];
						$nit_cliente=$row['nit_cliente'];
						$valor_entrada=$row['valor_entrada'];
						$valor_salida=$row['valor_salida'];
						$descripcion=$row['descripcion_entrada'].$row['descripcion_salida'];
						$saldo=$saldo+$valor_entrada-$valor_salida;
						//$nombre_vendedor=$row['nombre']." ".$row['apellido'];
						/*$estado_compra=$row['estado_compra'];
						if ($estado_compra==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}*/
						//$valor_caja=$row['valor'];
					?>
					<tr>
						<td><?php echo $id_caja; ?></td>
						<td><?php echo $fecha; ?></td>
						<!--<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $nit_cliente;?>" ><?php echo $nombre_cliente.$nombre_cuenta;?></a></td>
						--><td><?php echo $descripcion?><a href="#"><?php echo " - ".$nombre_cliente.$nombre_cuenta; ?></a></td>
						<td class='text-right'><?php echo number_format ($valor_entrada,0, ",", "."); ?></td>					
						<td class='text-right'><?php echo number_format ($valor_salida,0, ",", "."); ?></td>					
						<td class="text-right"><?php echo number_format ($saldo,0, ",", "."); ?></td>						
					</tr>
				

					<?php
				}

				?>
				<input type="hidden" value="<?php echo number_format ($saldo,0,",", ".");?>" id="saldo_final" name="saldo_final">
				<!--<tr>

					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?>
				</span></td>
				</tr>-->
			  </table>
			  <br>
			  <br>
			</div>
			<?php
		}
	}
?>