<?php
if (isset($con)) {

    ?>

	<!-- Modal -->
	<div class="modal fade" id="reporte_buses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Reporte Bus</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" action="ajax/Reporte_Cuadro_Bus.php" method="post" id="guardar_sucursales" name="guardar_sucursales">
			<div id="resultados_ajax_sucursales"></div>
			    <div class="form-group">
					<label for="sucursal_partida" class="col-sm-3 control-label">Fecha</label>
					<div class="col-sm-9">
						<input type="date" class="form-control delteimputs" id="fecha_reporte" value="<?php echo date("Y-m-d");  ?>" name="fecha_reporte"  required>
					</div>
			  	</div>

			 	<div class="form-group">
					<label for="nombus" class="col-sm-3 control-label">Bus</label>
					<div class="col-sm-9">
							<input type="text" class="form-control delete" id="nombus" name="nombus" placeholder="Bus" required>
							<input id="idbus" name="idbus" type='hidden' class="">
					</div>
				</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary">VER</button>
			<button type="button" class="btn btn-primary"  id="mostrar_reporte">Generar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
}
?>
