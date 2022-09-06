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
		 
		 $columnas = 	" movimiento_banco.id_mov_banco, movimiento_banco.fecha_movimiento, bancos.nombre_cuenta, clientes.nombre_cliente,movimiento_banco.descripcion_entrada,
		 				movimiento_banco.descripcion_salida,movimiento_banco.valor_entrada_banco,movimiento_banco.valor_salida_banco,salida_banco.id_salida_banco, entrada_banco.id_entrada_banco FROM movimiento_banco";
		 $coincidencias= " LEFT JOIN clientes ON movimiento_banco.id_cliente=clientes.id_cliente 
		 				LEFT JOIN salida_banco ON movimiento_banco.id_salida_banco=salida_banco.id_salida_banco 
		 				LEFT JOIN entrada_banco ON movimiento_banco.id_entrada_banco=entrada_banco.id_entrada_banco 
						LEFT JOIN bancos ON movimiento_banco.id_banco=bancos.id_banco ";
		 $sTable = " movimiento_banco,clientes ";
		 $sWhere1="";
		 $sWhere = "";
		 $sWhere1.=" WHERE movimiento_banco.id_cliente=clientes.id_cliente ";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " WHERE (clientes.nombre_cliente like '%$q%' )";
		$sWhere1.= " AND (clientes.nombre_cliente like '%$q%' )";
		}
		$sWhere.=" AND movimiento_banco.fecha_movimiento between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere1.=" AND movimiento_banco.fecha_movimiento between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere.=" ORDER BY movimiento_banco.fecha_movimiento desc";
		/*include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$sql1="SELECT count(*) AS numrows FROM $sTable  $sWhere1";
		//echo $sql1;
		$count_query   = mysqli_query($con, $sql1);
		//echo $sWhere;
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		//$total_pages = ceil($numrows/$per_page);
		$reload = './mov_bancos.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql="SELECT $columnas $coincidencias $sWhere ";
		//echo $sql;

		 /*$sTable = " movimiento_banco,bancos,usuarios ";
		 $sWhere = "";
		 $sWhere.=" WHERE bancos.id_banco=movimiento_banco.id_banco and movimiento_banco.id_usuario=usuarios.id_usuario ";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " AND (bancos.nombre_cuenta like '%$q%' )";
			
		}
		$sWhere.=" AND movimiento_banco.fecha_movimiento between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere.=" order by movimiento_banco.id_mov_banco desc";*/
		/*include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		/*$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere1");
		//echo $sWhere;
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		//$total_pages = ceil($numrows/$per_page);
		$reload = './mov_bancos.php';*/
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		//$sql="SELECT * FROM  $sTable $sWhere ";
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
					<th>Nombre de Cuenta</th>
					<th>Cliente</th>					
					<th>Descripción</th>
					<th class='text-right'>Entrada</th>
					<th class='text-right'>Salida</th>
					<th class='text-right'>Saldo</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					//print_r(array_values($row));
						$id_mov_banco=$row['id_mov_banco'];
						//$numero_compra=$row['numero_compra'];
						$fecha=date("d/m/Y", strtotime($row['fecha_movimiento']));
						//$nombre_cliente=$row['nombre_cliente'];
						$nombre_cuenta=$row['nombre_cuenta'];
						//$telefono_cliente=$row['telefono_cliente'];
						//$nit_cliente=$row['nit_cliente'];
						$valor_entrada=$row['valor_entrada_banco'];
						$valor_salida=$row['valor_salida_banco'];
						$descripcion=$row['descripcion_entrada'].$row['descripcion_salida'];
						$saldo=$saldo+$valor_entrada-$valor_salida;
						$nombre_cliente=$row['nombre_cliente'];
						if (empty($row['nombre_cliente'])) {
							# code...						
						if (!empty($row['id_entrada_banco'])) {

							$nombre_cliente=" SALIDA CAJA (Ver Entrada Banco ".$row['id_entrada_banco'].")";
						}
						if (!empty($row['id_salida_banco'])) {

							$nombre_cliente=" ENTRADA CAJA (Ver Salida Banco ".$row['id_salida_banco'].")";
						}

						}

						/*$estado_compra=$row['estado_compra'];
						if ($estado_compra==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}*/
						//$valor_caja=$row['valor'];
					?>
					<tr>
						<td><?php echo $id_mov_banco; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href='#' ><?php echo $nombre_cuenta;?></a></td>
						<td><a href='#' ><?php echo $nombre_cliente; ?></a></td>
						<td><?php echo $descripcion; ?></td>
						<td class='text-right'><?php echo number_format ($valor_entrada,0,",", "."); ?></td>					
						<td class='text-right'><?php echo number_format ($valor_salida,0,",", "."); ?></td>					
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