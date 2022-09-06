	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevaSalida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Nueva Salida Bancos</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_salida_banco" name="guardar_salida_banco">
			<div id="resultados_ajax_salidas"></div>
		  <div id="form_banco" class="form-group row" >
					<label for="nombre_cuenta" class="col-sm-3 control-label">Nombre de Cuenta</label>
					<div class="col-sm-8">
						<input class="form-control input-sm" id="nombre_cuenta1" name="nombre_cuenta1" placeholder="Selecciona una Cuenta" required>
						<input id="id_banco1" name="id_banco1" type='hidden'>	
					</div>
				</div>
		  <div id="form_cliente" class="form-group row">
					<label for="nombre_cliente1" class="col-sm-3 control-label">Cliente</label>
					<div class="col-sm-8">
						<input type="text" class="form-control input-sm" id="nombre_cliente1" name="nombre_cliente1" placeholder="Selecciona un cliente" required>
						<input id="id_cliente1" name="id_cliente1" type='hidden'>	
					</div>
				</div>
			  <div class="form-group">
				<label for="detalle" class="col-sm-3 control-label">Detalle</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="detalle1" name="detalle1" placeholder="Descripción de la Salida" required maxlength="255" ></textarea>
				  
				</div>
			  </div>
			  
			  
			  <div class="form-group">
				<label for="valor" class="col-sm-3 control-label">Valor</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="valor1" name="valor1" placeholder="Valor de la Salida" required pattern="^[0-9]{1,16}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="16">
				</div>
			  </div>
			 
			 <div class="form-group row">
					<label for="usuario" class="col-sm-3 control-label">Usuario</label>
					<div class="col-sm-8">
						<select class="form-control input-sm" id="id_usuario1" name="id_usuario1">
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