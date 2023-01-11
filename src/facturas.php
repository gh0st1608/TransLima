<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	 
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Facturacion | Expreso Lima E.I.R.L";
?>
<!DOCTYPE html>
<html lang="es">
<link rel="icon"  href="img/expreso.jpg">
  <head>
	<?php include("head.php");?>

  </head>
  <style type="text/css">
  	#bs-example-navbar-collapse-1{
  		margin-top: -20px;
  	}
  </style>
  <body>
	<?php
	include("navbar.php");
	include("modal/reporte_buses.php");
	include("modal/reporte_manifiesto.php");
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
<!-- <a  href="dashboard.php" class="btn btn-info" style="margin-left: 11px;"><span class="glyphicon glyphicon-plus" ></span>DashBoard</a> 
<a  href="crecimiento.php" class="btn btn-info" style="margin-left: 11px;"><span class="glyphicon glyphicon-plus" ></span>Reporte Crecimiento de Venta</a>
<a  href="productividad.php" class="btn btn-info" style="margin-left: 11px;"><span class="glyphicon glyphicon-plus" ></span>Reporte Productividad de Venta</a>-->
				<a  href="nueva_factura.php?d=01" class="btn btn-info" style="margin-left: 11px;"><span class="glyphicon glyphicon-plus" ></span> Nueva Factura Electronica</a>

				<a  href="nueva_factura.php?d=03" class="btn btn-info" style="margin-left: 11px;"><span class="glyphicon glyphicon-plus" ></span> 
				Nueva Boleta Electronica</a>
				
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> BUSCAR FACTURAS</h4>
		</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<a>
							<i class='glyphicon glyphicon-search'></i> Buscar Documentos
							</a>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre del cliente o # de factura" onkeyup='load(1);'>
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
	include("footer.php");
	?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!-- <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->
    
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/facturas.js"></script>
  </body>
</html>