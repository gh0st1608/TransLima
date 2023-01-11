<?php
if (isset($con)) {

    ?>


	<!-- Modal -->
	<div class="modal fade" id="nueva_liquidacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Generar Liquidacion</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_sucursales" name="guardar_sucursales">
			<div id="resultados_ajax_sucursales"></div>
			    <!-- <div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">N°</label>
					<div class="col-sm-9">
						<input type="text" class="form-control delete" id="seriefactura" name="seriefactura" placeholder="Serie Factura Encomienda"  maxlength="4" pattern="[a-zA-Z0-9]{2,64}" required>
					</div>
			  	</div> -->
			  	<!-- <div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">Sucursal Partida</label>
					<div class="col-sm-9">
						<input type="text" class="form-control delete" id="sucursal_llegada" name="sucursal_llegada" placeholder="Sucursal Partida"  required>
						<input id="sucursal_par" name="sucursal_par" type='hidden' class="">
					</div>
			  	</div> -->

			    <div class="form-group">
					<label for="sucursal_partida" class="col-sm-3 control-label">Sucursal Destino</label>
					<div class="col-sm-9">
						<!-- <input type="text" class="form-control delete" id="sucursal_llegada" name="sucursal_llegada" placeholder="Sucursal Destino"  maxlength="9"  required> -->
						<input type="text" class="form-control" value="LIMA" readonly="">
						<!-- <input id="sucursal_lle" name="sucursal_lle" type='hidden' class=""> -->
					</div>
			  	</div>

			 	<div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">Bus</label>
					<div class="col-sm-9">
							<input type="text" class="form-control delete" id="nombus" name="nombus" placeholder="Bus" required>
							<input id="idbus" name="idbus" type='hidden' class="">
					</div>
				</div>

				<div class="form-group">
					<label for="nomgastos" class="col-sm-3 control-label">Gastos Operativos</label>
					<div class="col-sm-9">
							<input type="number" class="form-control delete" id="nomgastos" name="nomgastos" placeholder="Gastos Operativos" required>
					</div>
				</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			<button type="button" class="btn btn-primary"  id="guardar_datos">Generar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
}
?>