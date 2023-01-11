<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_reservas = "active";
	$active_clientes="";
	$active_usuarios="";
	$active_sucursales="";	
	$title="Reservas | Expreso Lima E.I.R.L";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<a  class="btn btn-info"  id="nuevosucursal" href="nueva_reserva.php"><span class="glyphicon glyphicon-plus" ></span> Nueva Reserva</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Reservas</h4>
		</div>
		<div class="panel-body">
		
			
			
			<?php
			include("modal/registro_Reservas.php");
			include("modal/editar_sucursal.php");
			?>
			<form class="form-horizontal" role="form" id="datos_sucursales">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Codigo o Nombre</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Codigo o Nombre" onkeyup='load(1); '  pattern="[^'\x22]+" >
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
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript" src="js/reserva.js"></script>
  </body>
</html>
<script>
	$(function() {

			buscarcliente();
		});

	function buscarcliente(){

		tipcli = ($('#tipodocumento').val() == '01') ? '01' : '03';

		console.log(tipcli);
			$("#Didentidads").autocomplete({
					source: "./ajax/autocomplete/clientes.php?d="+tipcli,
					minLength: 2,
					appendTo : " #modal_reserva_fac",
					select: function(event, ui) {
						event.preventDefault();
						console.log(ui.item);
						$('#id_cliente').val(ui.item.id_cliente);
						$('#nombre_cliente').val(ui.item.nombre_cliente);
						$('#Didentidads').val(ui.item.documentoidentidad);
					 }
				});
	}
</script>