	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Bus</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_producto" name="editar_producto">
			
			  <div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Codigo Bus</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="codigobus"  maxlength="11" readonly="" name="codigobus">
				</div>
			  </div>

			   <div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="nombre_bus"  maxlength="100" placeholder="nombre" name="nombre_bus">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Placa</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="placa" name="placa"  maxlength="10" placeholder="placa">
				</div>
			  </div>
	  

			  <div class="form-group">
				<label for="mod_codigo" class="col-sm-3 control-label">Piso 1</label>
		

				<label for="asiento1" class="col-sm-2 control-label">Asientos</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control"  readonly="" id="asiento1" name="" placeholder="Asientos" required=""  maxlength="3">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_codigo" class="col-sm-3 control-label">Piso 2</label>
				
				

				<label for="asiento2" class="col-sm-2 control-label">Asientos</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control" readonly="" id="asiento2" name="" placeholder="Asientos" required=""  maxlength="3">
				</div>
			  </div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Caracteristicas</label>
				<div class="col-sm-9">
					<textarea class="form-control" id="caracteristicas" name="caracteristicas" placeholder="Caracteristicas" maxlength="255" ></textarea>			  
				</div>
			  </div>

		
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Guardar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>