	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoSaldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Nuevo Saldo a Caja</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_saldo" name="guardar_saldo">
			<div id="resultados_ajax_saldo"></div>

        					<div class="form-group">
							<label for="fecha_saldo" class="col-md-3 control-label">Fecha de Caja</label>
							<div class="col-md-6 input-group date" data-provide="datepicker">
								<input type="text" id="fecha_saldo" name="fecha_saldo" class="form-control">
								<div class="input-group-addon">
        							<span class="glyphicon glyphicon-th"></span>
    							</div>
							</div>
						</div>
		  
			  <div class="form-group">
				<label for="valor_saldo" class="col-sm-3 control-label">Saldo Inicial</label>
				<div class="col-md-8">
				  <input type="text" class="form-control" id="valor_saldo" name="valor_saldo" placeholder="Saldo Inicial Caja" required >
				</div>
			  </div>
			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_nuevo_saldo">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>