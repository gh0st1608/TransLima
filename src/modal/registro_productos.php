	<?php
		if (isset($con))
		{

	?>


	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo producto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			
			 <!--div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Codigo Bus</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control delete" id="Ccodigobus" readonly="" name="codigobus">
				</div>
			  </div-->

			   <div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control delete" id="Cnombre_bus" placeholder="nombre" name="nombre_bus" maxlength="100" required="">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Placa</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control delete" id="Cplaca" name="placa" placeholder="placa" maxlength="10" required="">
				</div>
			  </div>			  

			  <div class="form-group">
				<label for="mod_codigo" class="col-sm-2 control-label">Piso 1</label>
				
				
				<label for="fila1" class="col-sm-2 control-label">Filas</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control delete" id="Cfila1" name="fila1" placeholder="Filas" maxlength="3" required>
				</div>

				<label for="asiento1" class="col-sm-2 control-label">Asientos</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control delete" disabled="" id="Casiento1" name="" placeholder="Asientos" maxlength="3" required>
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_codigo" class="col-sm-2 control-label">Piso 2</label>
				
				
				<label for="fila2" class="col-sm-2 control-label">Filas</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control delete" id="Cfila2" name="fila2" placeholder="Filas" maxlength="3">
				</div>

				<label for="asiento2" class="col-sm-2 control-label">Asientos</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control delete" disabled="" id="Casiento2" name="" placeholder="Asientos"  maxlength="3" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Caracteristicas</label>
				<div class="col-sm-9">
					<textarea class="form-control delete" id="Ccaracteristicas" name="caracteristicas" placeholder="Caracteristicas" maxlength="255" ></textarea>			  
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