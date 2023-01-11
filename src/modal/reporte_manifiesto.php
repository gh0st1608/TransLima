<?php
if (isset($con)) {
	$queryquery = "SELECT correlativo FROM correlativos where id_correlativo = 1";
 	$query   = mysqli_query($con, $queryquery);
  	$row= mysqli_fetch_array($query);
  	$correlativo = $row['correlativo'];



    ?>

	<!-- Modal -->
	<div class="modal fade" id="reporte_mani" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Reporte Manifiesto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_sucursales" name="guardar_sucursales">
			<div id="resultados_ajax_sucursales"></div>

				<div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">N°</label>
					<div class="col-sm-9">
							<input type="number" class="form-control" value="<?php echo $correlativo ?>" id="correlativo_" name="correlativo_" required>
					</div>
				</div>


			    <div class="form-group">
					<label for="sucursal_partida" class="col-sm-3 control-label">Fecha</label>
					<div class="col-sm-9">
						<input type="date" class="form-control delteimputs" id="fecha_reporte_n" value="<?php echo date("Y-m-d");  ?>" name="fecha_reporte_n"  required>
					</div>
			  	</div>

			 	<div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">Bus</label>
					<div class="col-sm-9">
							<input type="text" class="form-control delete" id="nombus_n" name="nombus_n" required>
							<input id="idbus_n" name="idbus_n" type='hidden' class="">
					</div>
				</div>
					<div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">Tarjeta de Circulacion</label>
					<div class="col-sm-9">
							<input type="text" class="form-control delete" id="tarjeta" name="tarjeta" required>
					</div>
				</div>

				<div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">Piloto</label>
					<div class="col-sm-5">
							<input type="text" class="form-control" id="piloto" name="piloto" required>
					</div>
					<label for="nombus" style="text-align: left !important; padding-left: 0px !important;" class="col-sm-1 control-label">L.C</label>
					<div class="col-sm-3">
							<input type="text" class="form-control" id="lc_piloto" name="lc_piloto" required>
					</div>
				</div>

				<div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">Copiloto</label>
					<div class="col-sm-5">
							<input type="text" class="form-control" id="copiloto" name="copiloto" required>
					</div>
					<label for="nombus" style="text-align: left !important; padding-left: 0px !important;" class="col-sm-1 control-label">L.C</label>
					<div class="col-sm-3">
							<input type="text" class="form-control" id="lc_copiloto" name="lc_copiloto" required>
					</div>
				</div>
				<div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">Axiliar</label>
					<div class="col-sm-5">
							<input type="text" class="form-control" id="axiliar" name="axiliar" required>
					</div>
					<label for="nombus" style="text-align: left !important; padding-left: 0px !important;" class="col-sm-1 control-label">D.N.I</label>
					<div class="col-sm-3">
							<input type="text" class="form-control" id="dni_axiliar" name="dni_axiliar" required>
					</div>
				</div>
				<div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">Origen</label>
					<div class="col-sm-4">
							<input type="text" class="form-control" id="origen" name="origen" required>
					</div>
					<label for="nombus" style="text-align: left !important; padding-left: 0px !important;" class="col-sm-1 control-label">Destino</label>
					<div class="col-sm-4">
							<input type="text" class="form-control" id="destino" name="destino" required>
					</div>
				</div>

				
				<!-- <div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">Destino</label>
					<div class="col-sm-9">
							<input type="text" class="form-control " id="sucursal_llegada" placeholder="Ingrese Sucursal Destino" required>
						<input id="sucursales" name="id_sucu_llegada" type='hidden' class="">
					</div>
				</div> -->
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			<button type="button" class="btn btn-primary"  id="pdf_mani">Generar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
}
?>
