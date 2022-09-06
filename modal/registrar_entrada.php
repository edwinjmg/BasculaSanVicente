	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevaEntrada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Nueva Entrada</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_entrada" name="guardar_entrada">
			<div id="resultados_ajax_entradas"></div>
		  <div class="form-group row">
  					<label for="busqueda" class="col-sm-3 control-label">Seleccione</label>
					<div class="col-sm-8">  					
						<input type="radio" id="busqueda_cliente" name="busqueda" value="0" checked> Cliente<br>
  						<input type="radio" id="busqueda_banco" name="busqueda" value="1"> Banco<br>
					</div>
				</div>
		  <div id="form_cliente" class="form-group row">
					<label for="nombre_cliente" class="col-sm-3 control-label">Cliente</label>
					<div class="col-sm-8">
						<input type="text" class="form-control input-sm" id="nombre_cliente" name="nombre_cliente" placeholder="Selecciona un cliente" >
						<input id="id_cliente" name="id_cliente" type='hidden'>	
						</div>
					<label for="saldo_cliente1" class="col-sm-3 control-label"  style="font-size:16px">SALDO</label>
					<div class="col-sm-8">
						<input type="text" class="form-control input-sm" id="saldo_cliente1" name="saldo_cliente1"  style="font-size:16px;text-align: right;font-weight:bold" placeholder="SALDO" readonly>
					</div>
					

				</div>
		  <div id="form_banco" class="form-group row" hidden>
					<label for="nombre_cuenta" class="col-sm-3 control-label">Nombre de Cuenta</label>
					<div class="col-sm-8">
						<input class="form-control input-sm" id="nombre_cuenta" name="nombre_cuenta" placeholder="Selecciona una Cuenta" >
						<input id="id_banco" name="id_banco" type='hidden'>	
					</div>
				</div>
			  <div class="form-group">
				<label for="detalle" class="col-sm-3 control-label">Detalle</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="detalle" name="detalle" placeholder="Descripción de la Entrada" required maxlength="255" ></textarea>
				  
				</div>
			  </div>
			  
			  
			  <div class="form-group">
				<label for="valor" class="col-sm-3 control-label">Valor</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="valor" name="valor" placeholder="Valor de la Entrada" required pattern="^[0-9]{1,16}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="16">
				</div>
			  </div>
			 
			 <div class="form-group row">
					<label for="usuario" class="col-sm-3 control-label">Usuario</label>
					<div class="col-sm-8">
						<select class="form-control input-sm" id="id_usuario" name="id_usuario">
							<?php
							$sql_usuario=mysqli_query($con,"select * from usuarios order by apellido");
							while ($rw=mysqli_fetch_array($sql_usuario)){
								$id_usuario=$rw["id_usuario"];
								$nombre_usuario=$rw["nombre"]." ".$rw["apellido"];
								if ($id_usuario==$_SESSION['id_usuario']){
									$selected="selected";
								} else {
									$selected="";
								}
							?>
							<option value="<?php echo $id_usuario?>" <?php echo $selected;?>><?php echo $nombre_usuario?></option>
							<?php
								}
							?>
						</select>
					</div>
				</div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>