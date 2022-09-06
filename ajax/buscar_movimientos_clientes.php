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
	/*SELECT  movimiento_cliente.id_mov_cliente, movimiento_cliente.fecha_movimiento, clientes.nombre_cliente, ventas.id_venta, compras.id_compra, 
	entrada.id_entrada,salida.id_salida,entrada_banco.id_entrada_banco,salida_banco.id_salida_banco,movimiento_cliente.descripcion,movimiento_cliente.valor_entrada,
	movimiento_cliente.valor_salida FROM movimiento_cliente LEFT JOIN clientes ON movimiento_cliente.id_cliente=clientes.id_cliente 
	LEFT JOIN ventas ON movimiento_cliente.id_venta=ventas.id_venta LEFT JOIN compras ON movimiento_cliente.id_compra=compras.id_compra 
	LEFT JOIN entrada ON movimiento_cliente.id_entrada=entrada.id_entrada LEFT JOIN salida ON movimiento_cliente.id_salida=salida.id_salida 
	LEFT JOIN entrada_banco ON movimiento_cliente.id_entrada_banco=entrada_banco.id_entrada_banco 
	LEFT JOIN salida_banco ON movimiento_cliente.id_salida_banco=salida_banco.id_salida_banco ORDER BY movimiento_cliente.id_mov_cliente desc*/
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $fecha_inicial = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_inicial'], ENT_QUOTES)));
         $fecha_final = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_final'], ENT_QUOTES)));
         $valor_inicial = mysqli_real_escape_string($con,(strip_tags($_REQUEST['valor_inicial'], ENT_QUOTES)));         
		 
		 $columnas = 	" movimiento_cliente.id_mov_cliente, movimiento_cliente.fecha_movimiento, clientes.nombre_cliente, ventas.id_venta, compras.id_compra, 
						entrada.id_entrada,salida.id_salida,entrada_banco.id_entrada_banco,salida_banco.id_salida_banco,movimiento_cliente.descripcion,movimiento_cliente.valor_entrada,
						movimiento_cliente.valor_salida,bancos.nombre_cuenta,productos.nombre_producto FROM movimiento_cliente";
		 $coincidencias= " LEFT JOIN clientes ON movimiento_cliente.id_cliente=clientes.id_cliente 
						LEFT JOIN ventas ON movimiento_cliente.id_venta=ventas.id_venta LEFT JOIN compras ON movimiento_cliente.id_compra=compras.id_compra 
						LEFT JOIN entrada ON movimiento_cliente.id_entrada=entrada.id_entrada LEFT JOIN salida ON movimiento_cliente.id_salida=salida.id_salida 
						LEFT JOIN entrada_banco ON movimiento_cliente.id_entrada_banco=entrada_banco.id_entrada_banco 
						LEFT JOIN salida_banco ON movimiento_cliente.id_salida_banco=salida_banco.id_salida_banco 
						LEFT JOIN productos ON movimiento_cliente.id_producto=productos.id_producto 
						LEFT JOIN bancos ON movimiento_cliente.id_banco=bancos.id_banco";
		 $sTable = " movimiento_cliente,clientes ";
		 $sWhere1="";
		 $sWhere = " WHERE 1";
		 $sWhere1.=" WHERE movimiento_cliente.id_cliente=clientes.id_cliente ";
		//if ( $_GET['q'] != "" )
		//{
		$sWhere.= " AND (clientes.nombre_cliente like '$q' )";
		$sWhere1.= " AND (clientes.nombre_cliente like '$q' )";
		//}
		$sWhere.=" AND movimiento_cliente.fecha_movimiento between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere1.=" AND movimiento_cliente.fecha_movimiento between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere.=" ORDER BY movimiento_cliente.fecha_movimiento desc";
		/*include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere1");
		//echo $sWhere;
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		//$total_pages = ceil($numrows/$per_page);
		$reload = './mov_clientes.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql="SELECT $columnas $coincidencias $sWhere ";
		$query = mysqli_query($con, $sql);

		//echo $sql;
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
					<th>Nombre de Cliente</th>
					<th>Movimiento</th>
					<th>Descripción</th>
					<th class='text-right'>Entrada</th>
					<th class='text-right'>Salida</th>
					<th class='text-right'>Saldo</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					//print_r(array_values($row));
						$id_mov_cliente=$row['id_mov_cliente'];
						//$numero_compra=$row['numero_compra'];
						$fecha=date("d/m/Y", strtotime($row['fecha_movimiento']));
						//$nombre_cliente=$row['nombre_cliente'];
						$nombre_cliente=$row['nombre_cliente'];
						//$telefono_cliente=$row['telefono_cliente'];
						//$nit_cliente=$row['nit_cliente'];
						$descripcion1="";
						if (!empty($row['id_venta'])) {
							# code...
							$detalle=" VENTA ".$row['id_venta'];
							$descripcion1=" ".$row['nombre_producto'];
						}
						if (!empty($row['id_compra'])) {
							# code...
							$detalle=" COMPRA ".$row['id_compra'];
							$descripcion1= " ".$row['nombre_producto'];
						}
						if (!empty($row['id_entrada'])) {
							# code...
							$detalle=" ENTRADA CAJA ".$row['id_entrada'];
						}
						if (!empty($row['id_salida'])) {
							# code...
							$detalle=" SALIDA CAJA ".$row['id_salida'];
						}
						if (!empty($row['id_entrada_banco'])) {
							# code...
							$detalle=" ENTRADA BANCO ".$row['nombre_cuenta'];
						}
						if (!empty($row['id_salida_banco'])) {
							# code...
							$detalle=" SALIDA BANCO ".$row['nombre_cuenta'];
						}
						$valor_entrada=$row['valor_entrada'];
						$valor_salida=$row['valor_salida'];
						$descripcion=$row['descripcion'].$descripcion1;
						$saldo=$saldo+$valor_entrada-$valor_salida;
						//$nombre_usuario=$row['nombre']." ".$row['apellido'];
						/*$estado_compra=$row['estado_compra'];
						if ($estado_compra==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}*/
						//$valor_caja=$row['valor'];
					?>
					<tr>
						<td><?php echo $id_mov_cliente; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href='#'><?php echo $nombre_cliente;?></a></td>
						<td><?php echo $detalle; ?></td>
						<td><?php echo $descripcion; ?></td>
						<td class='text-right'><?php echo number_format ($valor_salida,0,",", "."); ?></td>					
						<td class='text-right'><?php echo number_format ($valor_entrada,0,",", "."); ?></td>					
						<td class="text-right"><?php echo number_format ($saldo,0,",", "."); ?></td>						
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