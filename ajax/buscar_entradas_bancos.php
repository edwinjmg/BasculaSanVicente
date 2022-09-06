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
		 $sTable = "entrada_banco LEFT JOIN clientes ON entrada_banco.id_cliente=clientes.id_cliente LEFT JOIN salida ON entrada_banco.id_salida_caja=salida.id_salida 
		 LEFT JOIN bancos ON entrada_banco.id_banco=bancos.id_banco ";
		 $sWhere = "";
		 $sWhere.=" LEFT JOIN usuarios ON entrada_banco.id_usuario=usuarios.id_usuario ";
		/*if ( $_GET['q'] != "" )
		{
			
		}*/
		$sWhere.=" WHERE entrada_banco.fecha_entrada_banco between '$fecha_inicial' and '$fecha_final 23:59:59'";
		$sWhere.=" order by entrada_banco.fecha_entrada_banco desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		//echo $sTable.$sWhere;
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './entradas_bancos.php';
		//main query to fetch the data
		$sql="SELECT entrada_banco.id_entrada_banco, salida.id_salida, entrada_banco.fecha_entrada_banco,clientes.nit_cliente,
		clientes.nombre_cliente,clientes.telefono_cliente,bancos.nombre_cuenta,entrada_banco.descripcion,entrada_banco.id_cliente,
		entrada_banco.id_banco,entrada_banco.valor_entrada_banco 
		FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//$query1=mysqli_fetch_array($query);
		//print_r(array_values($query1));
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive"> 
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Fecha</th>
					<th>Nombre de Cuenta</th>
					<th>Cliente o Salida de Caja</th>
					<th>Descripción</th>
					<th class='text-right'>Valor</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
							//print_r(($row['descripcion']));

						$id_entrada_banco=$row['id_entrada_banco'];
						$id_salida_caja=$row['id_salida'];
						$fecha=date("d/m/Y", strtotime($row['fecha_entrada_banco']));
						$nombre_cliente=$row['nombre_cliente'];
						$nombre_cuenta=$row['nombre_cuenta'];
						$telefono_cliente=$row['telefono_cliente'];
						$nit_cliente=$row['nit_cliente'];
						$descripcion=$row['descripcion'];
						$id_cliente=$row['id_cliente'];
						$id_banco=$row['id_banco'];
						//$nombre_vendedor=$row['nombre']." ".$row['apellido'];
						/*$estado_compra=$row['estado_compra'];
						if ($estado_compra==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}*/
						$valor_entrada_banco=$row['valor_entrada_banco'];
					?>
					<input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_entrada_banco;?>">
					<input type="hidden" value="<?php echo $nombre_cuenta;?>" id="nombre_cuenta<?php echo $id_entrada_banco;?>">
					<input type="hidden" value="<?php echo $descripcion;?>" id="descripcion<?php echo $id_entrada_banco;?>">
					<input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_entrada_banco;?>">
					<input type="hidden" value="<?php echo $id_banco?>" id="id_banco<?php echo $id_entrada_banco;?>">
					<input type="hidden" value="<?php echo $id_entrada_banco;?>" id="id_entrada_banco<?php echo $id_entrada_banco;?>">
					<input type="hidden" value="<?php echo number_format($valor_entrada_banco,2,'.','');?>" id="valor_entrada_banco<?php echo $id_entrada_banco;?>">

					<tr>
						<td><?php echo $id_entrada_banco; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $nombre_cuenta; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $nit_cliente;?>" ><?php echo $nombre_cliente.$id_salida_caja?></a></td>
						<td><?php echo $descripcion; ?></td>
						<td class='text-right'><?php echo number_format ($valor_entrada_banco,2,",", "."); ?></td>					
					<td class="text-right">
						<a href="#" class='btn btn-default' title='Editar Entrada' onclick="obtener_datos('<?php echo $id_entrada_banco;?>');" data-toggle="modal" data-target="#editarEntradabancos"><i class="glyphicon glyphicon-edit"class="glyphicon glyphicon-edit"></i></a> 
						<a href="#" class='btn btn-default' title='Descargar Entrada' onclick="imprimir_entrada_banco('<?php echo $id_entrada_banco;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						<!--<a href="#" class='btn btn-default' title='Borrar Entrada' onclick="eliminar('<?php echo $id_entrada; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>-->
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