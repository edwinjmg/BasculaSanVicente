	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="editarEntrada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Entrada</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_entrada" name="editar_entrada">
			<div id="resultados_ajax2"></div>
		  <div class="form-group row" >
		  					<input type="hidden" name="mod_id" id="mod_id">
  					<label for="mod_busqueda" class="col-sm-3 control-label">Seleccione</label>
					<div class="col-sm-8">  					
						<input type="radio" id="mod_busqueda_cliente" name="mod_busqueda" value="0" disabled> Cliente<br>
  						<input type="radio" id="mod_busqueda_banco" name="mod_busqueda" value="1" disabled> Banco<br>
					</div>
				</div>
		  <div id="mod_form_cliente" class="form-group row">
					<label for="mod_nombre_cliente" class="col-sm-3 control-label">Cliente</label>
					<div class="col-sm-8">
						<input type="text" class="form-control input-sm" id="mod_nombre_cliente" name="mod_nombre_cliente" placeholder="Selecciona un cliente">
						<input id="mod_id_cliente" name="mod_id_cliente" type='hidden'>	
					</div>
				</div>
			  <div id="mod_form_banco" class="form-group row" hidden>
					<label for="nombre_cuenta" class="col-sm-3 control-label">Nombre de Cuenta</label>
					<div class="col-sm-8">
						<input class="form-control input-sm" id="mod_nombre_cuenta" name="mod_nombre_cuenta" placeholder="Selecciona una Cuenta" >
						<input id="mod_id_banco" name="mod_id_banco" type='hidden'>	
					</div>
				</div>
			  <div class="form-group">
				<label for="detalle" class="col-sm-3 control-label">Detalle</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="mod_detalle" name="mod_detalle" placeholder="Descripción de la Entrada" required maxlength="255" ></textarea>
				  
				</div>
			  </div>
			  
			  
			  <div class="form-group">
				<label for="valor" class="col-sm-3 control-label">Valor</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_valor" name="mod_valor" placeholder="Valor de la Entrada" required pattern="^[0-9]{1,16}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="16">
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
			<button type="submit" class="btn btn-primary" id="actualizar_entrada">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>