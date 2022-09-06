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
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $fecha_inicial = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_inicial'], ENT_QUOTES)));
         $fecha_final = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_final'], ENT_QUOTES)));
         $valor_inicial = mysqli_real_escape_string($con,(strip_tags($_REQUEST['valor_inicial'], ENT_QUOTES)));         
		 $sTable = " movimiento_producto,productos,clientes ";
		 $sWhere = "";
		 $sWhere.=" WHERE movimiento_producto.id_producto=productos.id_producto and movimiento_producto.id_cliente=clientes.id_cliente";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  productos.nombre_producto like '$q%' ";
			
		}
		$sWhere.=" and movimiento_producto.fecha_movimiento between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere.=" order by movimiento_producto.fecha_movimiento desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		//echo $sWhere;
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		//$total_pages = ceil($numrows/$per_page);
		$reload = './mov_productos.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql="SELECT * FROM  $sTable $sWhere ";
		$query = mysqli_query($con, $sql);

		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			$saldo=$valor_inicial;
			?>
			<div class="table-responsive">
			
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Movimiento</th>
					<th>Producto</th>
					<th class='text-right'>Entrada</th>
					<th class='text-right'>Salida</th>
					<th class='text-right'>Saldo</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					//print_r(array_values($row));
						$detalle="";
						$id_mov=$row['id_mov_producto'];
						//$numero_compra=$row['numero_compra'];
						$fecha=date("d/m/Y", strtotime($row['fecha_movimiento']));
						$nombre_cliente=$row['nombre_cliente'];
						//$nombre_cuenta=$row['nombre_cuenta'];
						$telefono_cliente=$row['telefono_cliente'];
						$nit_cliente=$row['nit_cliente'];
						$valor_entrada=$row['entrada'];
						$valor_salida=$row['salida'];
						$producto=$row['nombre_producto'];
						$saldo=$saldo+$valor_entrada-$valor_salida;
						//$nombre_vendedor=$row['nombre']." ".$row['apellido'];
						/*$estado_compra=$row['estado_compra'];
						if ($estado_compra==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}*/
						//$valor_caja=$row['valor'];
						if (empty($row['id_compra'])) {
							# code...
							$detalle="VENTA ".$row['id_venta'];
						}else{
							$detalle="COMPRA ".$row['id_compra'];
						}

					?>
					<tr>
						<td><?php echo $id_mov; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $nit_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						<td><?php echo $detalle; ?></td>
						<td><?php echo $producto; ?></td>
						<td class='text-right'><?php echo number_format ($valor_entrada,1,",", "."); ?></td>					
						<td class='text-right'><?php echo number_format ($valor_salida,1,",", "."); ?></td>					
						<td class="text-right"><?php echo number_format ($saldo,1,",", "."); ?></td>						
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