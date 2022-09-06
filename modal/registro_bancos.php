	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoBanco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Nueva Cuenta de Banco</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_banco" name="guardar_banco">
			<div id="resultados_ajax_bancos"></div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre de la Cuenta</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="nombre" name="nombre" placeholder="Nombre de la Cuenta" required maxlength="255" ></textarea>
				  
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Numero de Cuetna</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="numero" name="numero" placeholder="Numero de Cuenta" required >
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