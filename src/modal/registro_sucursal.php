<?php
if (isset($con)) {

    ?>


	<!-- Modal -->
	<div class="modal fade" id="nuevoSucursal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Nueva Sucursal</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_sucursales" name="guardar_sucursales">
			<div id="resultados_ajax_sucursales"></div>

			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre Sucursal</label>
				<div class="col-sm-9">
					<input type="text" class="form-control delete" id="nombresucursal" name="nombresucursal" placeholder="Nombre Sucursal"  maxlength="100"  required>

				</div>
			  </div>

			    <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Celular</label>
				<div class="col-sm-9">
						<input type="text" class="form-control delete" id="direccion" name="direccion" placeholder="Celular"  maxlength="9"  required>
				</div>
			  </div>

			  <div class="form-group">
				<label for="direccion_real" class="col-sm-3 control-label">Direccion</label>
				<div class="col-sm-9">
						<input type="text" class="form-control delete" id="direccion_real" name="direccion_real" placeholder="Direccion"  required>
				</div>
			  </div>

			 <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Código Dirección Fiscal</label>
				<div class="col-sm-9">
						<input type="text" class="form-control delete" id="fiscal" name="fiscal" placeholder="Código Fiscal"  maxlength="4" pattern="[a-zA-Z0-9]{2,64}" required>
				</div>
			  </div>

			    <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Serie Factura Encomienda</label>
				<div class="col-sm-9">
					<input type="text" class="form-control delete" id="seriefactura" name="seriefactura" placeholder="Serie Factura Encomienda"  maxlength="4" pattern="[a-zA-Z0-9]{2,64}" required>
				</div>
			  </div>

			      <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Serie Boleta Encomienda</label>
				<div class="col-sm-9">
					<input type="text" class="form-control delete" id="serieboleta" name="serieboleta" placeholder="Serie Boleta Encomienda" maxlength="4" pattern="[a-zA-Z0-9]{2,64}" required>
				</div>
			  </div>
			   <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Serie Boleta Viaje</label>
				<div class="col-sm-9">
					<input type="text" class="form-control delete" id="serieboleta_viaje" name="serieboleta_viaje" placeholder="Serie Boleta Viaje" maxlength="4" pattern="[a-zA-Z0-9]{2,64}" required>
				</div>
			  </div>
			   <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Serie Factura Viaje</label>
				<div class="col-sm-9">
					<input type="text" class="form-control delete" id="seriefactura_viaje" name="seriefactura_viaje" placeholder="Serie Factura Viaje" maxlength="4" pattern="[a-zA-Z0-9]{2,64}" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Hora de Viaje</label>
				<div class="col-sm-9">
					<input type="time" class="form-control delete" id="horaviaje" name="horaviaje" placeholder="Serie Boleta" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="porcentaje" class="col-sm-3 control-label">% de Ganancia</label>
				<div class="col-sm-9">
						<input type="number" class="form-control delete" id="porcentaje" name="porcentaje" placeholder="porcentaje"  required>
				</div>
			  </div>

			  <!--div class="form-group">
				<label for="estados" class="col-sm-2 control-label">Estado</label>
				<div class="col-sm-4">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="-1" selected>Selecciona Estado</option>
					<option value="1">Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>

			  </div-->


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