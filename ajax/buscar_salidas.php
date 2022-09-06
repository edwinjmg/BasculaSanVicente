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
		//$del2="delete from detalle_compra where numero_compra='".$numero_compra."'";
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
         //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $fecha_inicial = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_inicial'], ENT_QUOTES)));
         $fecha_final = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_final'], ENT_QUOTES)));
		 $sTable = "salida LEFT JOIN bancos ON salida.id_banco=bancos.id_banco LEFT JOIN clientes ON salida.id_cliente=clientes.id_cliente";
		 $sWhere = "";
		 $sWhere.=" LEFT JOIN usuarios ON salida.id_usuario=usuarios.id_usuario ";
		/*if ( $_GET['q'] != "" )
		{
			
		}*/
		$sWhere.=" WHERE salida.fecha_salida between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere.=" order by salida.id_salida desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 50; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		//echo $sTable.$sWhere;
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './salidas.php';
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
					<th>Cliente o Cuenta Banco</th>
					<th>Descripción</th>
					<th class='text-right'>Valor</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_salida=$row['id_salida'];
						//$numero_compra=$row['numero_compra'];
						$fecha=date("d/m/Y", strtotime($row['fecha_salida']));
						$nombre_cliente=$row['nombre_cliente'];
						$nombre_cuenta=$row['nombre_cuenta'];
						$numero_cuenta=$row['numero_cuenta'];
						$telefono_cliente=$row['telefono_cliente'];
						$nit_cliente=$row['nit_cliente'];
						$descripcion=$row['descripcion'];
						$id_cliente=$row['id_cliente'];
						$id_banco=$row['id_banco'];
						//$nombre_vendedor=$row['nombre']." ".$row['apellido'];
						/*$estado_compra=$row['estado_compra'];
						if ($estado_compra==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}*/
						$valor_salida=$row['valor_salida'];
					?>
					<input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_salida;?>">
					<input type="hidden" value="<?php echo $nombre_cuenta;?>" id="nombre_cuenta<?php echo $id_salida;?>">
					<input type="hidden" value="<?php echo $descripcion;?>" id="descripcion<?php echo $id_salida;?>">
					<input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_salida;?>">
					<input type="hidden" value="<?php echo $id_banco;?>" id="id_banco<?php echo $id_salida;?>">
					<input type="hidden" value="<?php echo number_format($valor_salida,2,'.','');?>" id="valor_salida<?php echo $id_salida;?>">

					<tr>
						<td><?php echo $id_salida; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $nit_cliente.$numero_cuenta;?>" ><?php echo $nombre_cliente.$nombre_cuenta;?></a></td>
						<td><?php echo $descripcion; ?></td>
						<td class='text-right'><?php echo number_format ($valor_salida,2, ",", "."); ?></td>					
					<td class="text-right">
						<a href="#" class='btn btn-default' title='Editar salida' onclick="obtener_datos('<?php echo $id_salida;?>');" data-toggle="modal" data-target="#editarsalida"><i class="glyphicon glyphicon-edit"class="glyphicon glyphicon-edit"></i></a> 
						<a href="#" class='btn btn-default' title='Descargar salida' onclick="imprimir_salida('<?php echo $id_salida;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						<!--<a href="#" class='btn btn-default' title='Borrar salida' onclick="eliminar('<?php echo $id_salida; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>-->
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
			</div>
			<?php
		}
	}
?>