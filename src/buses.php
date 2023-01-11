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
	$active_productos="active";
	$active_clientes="";
	$active_usuarios="";	
	$title="Buses | HUARI TOURS";
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
		    <!--  <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" id="repo_buses" data-target="#reporte_buses"><span class="glyphicon glyphicon-book" ></span> Reporte Bus</button>
			</div> -->
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Buses</h4>
		</div>
		<div class="panel-body">
		
			
			
			<?php
			include("modal/registro_productos.php");
			include("modal/editar_productos.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Nombre o placa</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre o placa del bus" pattern="[^'\x22]+"  maxlength="255" onkeyup='load(1); '>
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
	<script type="text/javascript" src="js/productos.js"></script>
  </body> 
</html>
<script>
$( "#guardar_producto" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax_productos").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			//$("#resultados_ajax_productos").html(datos);
			$('#guardar_datos').attr("disabled", false);
			$('#nuevoProducto').modal('hide');
			$('.delete').val("");
			nom = (datos =="El bus ha sido ingresado satisfactoriamente.") ? "success" : "error";
			Swal(
			  'Mensaje',
			  datos,
			  nom
			)
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_producto" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			//$("#resultados_ajax2").html(datos);
			$('#myModal2').modal('hide');
			$('#actualizar_datos').attr("disabled", false);
			nom = (datos =="El bus ha sido actualizado satisfactoriamente.") ? "success" : "error";
			Swal(
			  'Mensaje',
			  datos,
			  nom
			)
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			
			var nombre = $("#nombre"+id).val(); 
			var fila1 = $("#filas1"+id).val();
			var fila2 = $("#filas2"+id).val();
			var caracteristica = $("#caracteristica"+id).val();
			var placa = $("#placa"+id).val();
			//var fecha = $("#date"+id).val();

			$("#codigobus").val(id);
			$("#nombre_bus").val(nombre);
			$("#asiento1").val(fila1);
			$("#asiento2").val(fila2);
			$("#caracteristicas").val(caracteristica);
			$("#placa").val(placa);
		}
</script>
