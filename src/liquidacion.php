<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

/* Connect To Database*/
require_once "config/db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "config/conexion.php"; //Contiene funcion que conecta a la base de datos


$active_liquidacion = "active";
$title             = "Sucursal ";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include "head.php";?>
  </head>
  <body>
	<?php
include "navbar.php";
?>
<style type="text/css">
	.ui-autocomplete {
  z-index: 215000000 !important;
}
</style>
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" id="nuevosucursal" data-target="#nueva_liquidacion"><span class="glyphicon glyphicon-plus" ></span> Nueva Liquidacion</button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Liquidacion</h4>
		</div>
		<div class="panel-body">



			<?php
include "modal/generar_liquidacion.php";
?>
			<form class="form-horizontal" role="form" id="datos_sucursales">

						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">N° o Fecha</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="N° O Fecha" onkeyup='load(1); '  pattern="[^'\x22]+" title="Busqueda por N° O Fecha"  maxlength="255">
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>

						</div>



			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->






  </div>
</div>

	</div>
	<hr>
	<?php
include "footer.php";
?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript" src="js/liquidacion.js"></script>
  </body>
</html>
