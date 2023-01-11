<?php
		if (isset($con))
		{

	?>

	<!-- Modal -->
	<div class="modal fade" id="modal_reserva_fac" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Emitir Documentos Electronicos</h4>
		  </div>

		  <div class="modal-body" >
			<form class="form-horizontal" method="post" id="save_reservafacbol">

			<h3 id="tituloreserca" style="text-align: center;"></h3>
			<br>
			<div class="form-group">
				<label for="tel1" class="col-md-3 control-label">N. Doc</label>
					<div class="col-md-8">
						<input type="text" class="form-control input-sm" 
						id="Didentidads" value="" placeholder="Ingresar Numero de documento">
						
					</div>
				
			</div>
			<div class="form-group">
				<label for="nombre_cliente" class="col-md-3 control-label">Cliente</label>
				<div class="col-md-8">
				  <input type="text" class="form-control input-sm" id="nombre_cliente" readonly  >
				  <input id="id_cliente" name="id_cliente" type='hidden'>	
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_cliente" class="col-md-3 control-label">Precio</label>
				<div class="col-md-8">
				  <input type="text" class="form-control input-sm" id="precio" name="precio">
				  <!-- <input id="id_cliente" name="id_cliente" type='hidden'>	 -->
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_cliente" class="col-md-3 control-label">Facturado</label>
				<div class="col-md-8">
				  <input type="text" class="form-control input-sm" id="facturado" name="facturado">
				  <!-- <input id="id_cliente" name="id_cliente" type='hidden'>	 -->
				</div>
			</div>
			<input type="hidden" name="codigo" id="codigo">
			<input type="hidden" name="tipodocumento" id="tipodocumento">
			 
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary" id="save_resfacbol">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>