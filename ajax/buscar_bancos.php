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
		$id_banco=intval($_GET['id']);
		$query=mysqli_query($con, "select * from movimiento_banco where id_banco='".$id_banco."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM bancos WHERE id_banco='".$id_banco."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar ésta cuenta. Existen Movimientos vinculados a ésta cuenta. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('numero_cuenta', 'nombre_cuenta');//Columnas de busqueda
		 $sTable = "bancos";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by id_banco desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './bancos.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Código</th>
					<th>Nombre Cuenta</th>
					<th class='text-right'>Número Cuenta</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_banco=$row['id_banco'];
						//$codigo_producto=$row['codigo_producto'];
						$nombre_cuenta=$row['nombre_cuenta'];
						//$status_producto=$row['status_producto'];
						//if ($status_producto==1){$estado="Activo";}
						//else {$estado="Inactivo";}
						//$fecha_registro= date('d/m/Y', strtotime($row['fecha_registro']));
						$numero_cuenta=$row['numero_cuenta'];
					?>
					
					<input type="hidden" value="<?php echo $id_banco;?>" id="id_banco<?php echo $id_banco;?>">
					<input type="hidden" value="<?php echo $nombre_cuenta;?>" id="nombre_cuenta<?php echo $id_banco;?>">
					<input type="hidden" value="<?php echo $numero_cuenta;?>" id="numero_cuenta<?php echo $id_banco;?>">
					<tr>
						
						<td><?php echo $id_banco; ?></td>
						<td ><?php echo $nombre_cuenta; ?></td>
						<!--<td><?php echo $estado;?></td>
						<td><?php echo $fecha_registro;?></td>-->
						<td><?php echo $numero_cuenta;?></td>
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar Banco' onclick="obtener_datos('<?php echo $id_banco;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Borrar Banco' onclick="eliminar('<?php echo $id_banco; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>