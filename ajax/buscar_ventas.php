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
		$id_venta=intval($_GET['id']);
		$del1="delete from ventas where id_venta='".$id_venta."'";
		//$del2="delete from detalle_venta where numero_venta='".$numero_venta."'";
		if ($delete1=mysqli_query($con,$del1) /*and $delete2=mysqli_query($con,$del2)*/)
		{
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
		 $sTable = "ventas, clientes, usuarios,productos";
		 $sWhere = "";
		 $sWhere.=" WHERE ventas.id_cliente=clientes.id_cliente and ventas.id_usuario=usuarios.id_usuario and ventas.id_producto=productos.id_producto";
		if ( $_GET['id_producto'] != "" )
		{
		$sWhere.= " and  ventas.id_producto='$id_producto'";
			
		}
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' or ventas.id_venta like '%$q%')";
			
		}
		$sWhere.=" and ventas.fecha_venta between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere.=" order by ventas.fecha_venta desc";

		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");

		$peso_total=mysqli_query($con, "SELECT sum(peso_venta) AS peso_total FROM $sTable  $sWhere");
		$peso=mysqli_fetch_array($peso_total);

		$valor_total=mysqli_query($con, "SELECT sum(total_venta) AS valor_total FROM $sTable  $sWhere");
		$valor=mysqli_fetch_array($valor_total);

		//echo $sWhere;
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './ventas.php';
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
						$id_venta=$row['id_venta'];
						//$numero_venta=$row['numero_venta'];
						$fecha=date("d/m/Y", strtotime($row['fecha_venta']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$nit_cliente=$row['nit_cliente'];
						$nombre_producto=$row['nombre_producto'];
						$peso_venta=$row['peso_venta'];
						$precio_venta=$row['precio_venta'];
						//$nombre_vendedor=$row['nombre']." ".$row['apellido'];
						/*$estado_venta=$row['estado_venta'];
						if ($estado_venta==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}*/
						$total_venta=$row['total_venta'];
					?>
					<tr>
						<td><?php echo $id_venta; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $nit_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						<td><?php echo $nombre_producto; ?></td>
						<td class='text-right'><?php echo number_format ($peso_venta,1, ",", "."); ?></td>
						<td class='text-right'><?php echo number_format ($precio_venta,0, ",", "."); ?></td>
						<td class='text-right'><?php echo number_format ($total_venta,0, ",", "."); ?></td>					
					<td class="text-right">
						<a href="editar_venta.php?id_venta=<?php echo $id_venta;?>" class='btn btn-default' title='Editar venta' ><i class="glyphicon glyphicon-edit"></i></a> 
						<a href="#" class='btn btn-default' title='Descargar venta' onclick="imprimir_venta('<?php echo $id_venta;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						<!--<a href="#" class='btn btn-default' title='Borrar venta' onclick="eliminar('<?php echo $id_venta; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>-->
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
			  <input type="hidden" value="<?php echo number_format ($peso['peso_total'],0,",", ".");?>" id="suma_peso" name="suma_peso">
			  <input type="hidden" value="<?php echo number_format ($valor['valor_total'],0,",", ".");?>" id="suma_total" name="suma_total">
			</div>
			<?php
		}
	}
?>