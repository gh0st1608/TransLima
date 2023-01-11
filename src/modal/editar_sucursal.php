<?php
if (isset($con)) {

    ?>


	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Sucursal</h4>
		  </div>
		  <div class="modal-body id_sucursal" id="">
			<form class="form-horizontal" method="post" id="editar_producto" name="editar_producto">
			<div id="resultados_ajax2"></div>

			   <div class="form-group">
				<div class="col-sm-9">
					<input type="text" type="hidden"  class="form-control" id="id_sucursal" name="id_sucursal" style=" display: none;">
				</div>
			  </div>

			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre Sucursal</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="mod_nombresucursal" name="mod_nombresucursal" placeholder="Nombre Sucursal" maxlength="100" required>

				</div>
			  </div>

			   <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Celular</label>
				<div class="col-sm-9">
						<input type="text" class="form-control" id="mod_direccion" name="mod_direccion" placeholder="Celular" maxlength="9" required>
				</div>
			  </div>

			    <div class="form-group">
				<label for="direccion_real" class="col-sm-3 control-label">Direccion</label>
				<div class="col-sm-9">
						<input type="text" class="form-control" id="mod_direccion_real" name="mod_direccion_real" placeholder="Direccion" required>
				</div>
			  </div>

			 <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Código Dirección Fiscal</label>
				<div class="col-sm-9">
						<input type="text" class="form-control" id="mod_fiscal" name="mod_fiscal" placeholder="Código Fiscal" maxlength="4" required>
				</div>
			  </div>

			    <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Serie Factura Encomienda</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="mod_seriefactura" name="mod_seriefactura" placeholder="Serie Factura encomienda" maxlength="4" required>
				</div>
			  </div>

			      <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Serie Boleta Encomienda</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="mod_serieboleta" name="mod_serieboleta" placeholder="Serie Boleta encomienda" maxlength="4" required>
				</div>
			  </div>

			   <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Serie Factura Viaje</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="mod_seriefactura_viaje" name="mod_seriefactura_viaje" placeholder="Serie Factura viaje" maxlength="4" required>
				</div>
			  </div>

			      <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Serie Boleta Viaje</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="mod_serieboleta_viaje" name="mod_serieboleta_viaje" placeholder="Serie Boleta viaje" maxlength="4" required>
				</div>
			  </div>
				<div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">Hora de Viaje</label>
					<div class="col-sm-9">
						<input type="time" class="form-control" id="mod_horaviaje" name="mod_horaviaje" placeholder="Serie Boleta viaje" maxlength="4" required>
					</div>
				</div>
				<div class="form-group">
					<label for="porcentaje" class="col-sm-3 control-label">% de Ganancia</label>
					<div class="col-sm-9">
							<input type="number" class="form-control delete" id="mod_porcentaje" name="mod_porcentaje" placeholder="porcentaje"  required>
					</div>
			  	</div>


		  </div>
		  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
}
?>