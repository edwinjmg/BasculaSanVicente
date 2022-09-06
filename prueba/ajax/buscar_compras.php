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
	if (isset($_GET['id'])){
		$id_compra=intval($_GET['id']);
		$del1="delete from compras where id_compra='".$id_compra."'";
		$sql2="select id_salida from salida where id_compra='".$id_compra."'";
		$query_salida=mysqli_query($con,$sql2);
		$row=mysqli_fetch_array($query_salida);
		$del2="delete from salida where id_compra='".$id_compra."'";
		$del3="delete from caja where id_salida='".$row['id_salida']."'";
		if ($delete1=mysqli_query($con,$del1) /*and $delete2=mysqli_query($con,$del2)*/)
		{
			$del_salida=mysqli_query($con,$del2);
			$del_caja=mysqli_query($con,$del3);
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php
			
		}
	}
	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $fecha_inicial = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_inicial'], ENT_QUOTES)));
         $fecha_final = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_final'], ENT_QUOTES)));
         $id_producto=  mysqli_real_escape_string($con,(strip_tags($_REQUEST['id_producto'], ENT_QUOTES)));     
		 $sTable = "compras, clientes, usuarios,productos";
		 $sWhere = "";
		 $sWhere.=" WHERE compras.id_cliente=clientes.id_cliente and compras.id_usuario=usuarios.id_usuario and compras.id_producto=productos.id_producto";
		if ( $_GET['id_producto'] != "" )
		{
		$sWhere.= " and  compras.id_producto='$id_producto'";
			
		}
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' or compras.id_compra like '%$q%')";
			
		}
		$sWhere.=" and compras.fecha_compra between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere.=" order by compras.fecha_compra desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");

		$peso_total=mysqli_query($con, "SELECT sum(peso_compra) AS peso_total FROM $sTable  $sWhere");
		$peso=mysqli_fetch_array($peso_total);
		$valor_total=mysqli_query($con, "SELECT sum(total_compra) AS valor_total FROM $sTable  $sWhere");
		$valor=mysqli_fetch_array($valor_total);
		if ($peso['peso_total']!=0) {
			$promedio1=$valor['valor_total']/$peso['peso_total'];
			# code...
		} else {
			$promedio1=0;
			# code...
		}
		
		
				//echo $promedio1;
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './compras.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Producto</th>
					<th>Peso</th>
					<th>Precio</th>
					<th class='text-right'>Total</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_compra=$row['id_compra'];
						//$numero_compra=$row['numero_compra'];
						$fecha=date("d/m/Y", strtotime($row['fecha_compra']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$nit_cliente=$row['nit_cliente'];
						$nombre_producto=$row['nombre_producto'];
						$peso_compra=$row['peso_compra'];
						$precio_compra=$row['precio_compra'];
						//$nombre_vendedor=$row['nombre']." ".$row['apellido'];
						/*$estado_compra=$row['estado_compra'];
						if ($estado_compra==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}*/
						$total_compra=$row['total_compra'];
					?>
					<tr>
						<td><?php echo $id_compra; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $nit_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						<td><?php echo $nombre_producto; ?></td>
						<td><?php echo $peso_compra; ?></td>
						<td><?php echo $precio_compra; ?></td>
						<td class='text-right'><?php echo number_format ($total_compra,2 ,",", "."); ?></td>					
					<td class="text-right">
						<a href="editar_compra.php?id_compra=<?php echo $id_compra;?>" class='btn btn-default' title='Editar compra' ><i class="glyphicon glyphicon-edit"></i></a> 
						<a href="#" class='btn btn-default' title='Descargar compra' onclick="imprimir_compra('<?php echo $id_compra;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						<!--<a href="#" class='btn btn-default' title='Borrar compra' onclick="eliminar('<?php echo $id_compra; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>-->
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			  <input type="hidden" value="<?php echo number_format ($peso['peso_total'],1,",", ".");?>" id="suma_peso" name="suma_peso">
			  <input type="hidden" value="<?php echo number_format ($valor['valor_total'],0,",", ".");?>" id="suma_total" name="suma_total">
			  <input type="hidden" value="<?php echo number_format ($promedio1,2,",", ".");?>" id="promedio1" name="promedio1">
			</div>
			<?php
		}
	}
?>