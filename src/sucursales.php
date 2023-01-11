<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

/* Connect To Database*/
require_once "config/db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "config/conexion.php"; //Contiene funcion que conecta a la base de datos

$active_facturas   = "";
$active_productos  = "";
$active_clientes   = "";
$active_usuarios   = "";
$active_sucursales = "active";
$title             = "Sucursal | Expreso Lima E.I.R.L";
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

    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" id="nuevosucursal" data-target="#nuevoSucursal"><span class="glyphicon glyphicon-plus" ></span> Nueva Sucursal</button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Sucursal</h4>
		</div>
		<div class="panel-body">



			<?php
include "modal/registro_sucursal.php";
include "modal/editar_sucursal.php";
?>
			<form class="form-horizontal" role="form" id="datos_sucursales">

						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Nombre o Celular</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre  o Celular de la sucursal" onkeyup='load(1); '  pattern="[^'\x22]+" title="Busqueda por NOMBRE DE LA SUCURSAL o Celular"  maxlength="255">
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
	<script type="text/javascript" src="js/sucursales.js"></script>
  </body>
</html>
<script>
$( "#guardar_sucursales" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_sucursal.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax_sucursales").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			//$("#resultados_ajax_sucursales").html(datos);
			$('#guardar_datos').attr("disabled", false);
			$('#nuevoSucursal').modal('hide');
			$('.delete').val("");
			//document.getElementById("estado").options[0].selected = true;
			datos = datos.trim();
			nom = (datos =="Sucursal ha sido ingresado satisfactoriamente.") ? "success" : "error";
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
			url: "ajax/editar_sucursal.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			//$("#resultados_ajax2").html(datos);
			$('#myModal2').modal('hide');
			$('#actualizar_datos').attr("disabled", false);
			datos = datos.trim();
			nom = (datos =="La sucursal ha sido actualizado satisfactoriamente.") ? "success" : "error";
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
			var direccion_fiscal = $("#direccion_fiscal"+id).val();
			var codigo_sucursal = $("#codigo_sucursal"+id).val();
			var nombre_sucursal = $("#nombre_sucursal"+id).val();
			var serie_boleta = $("#serie_boleta"+id).val();
			var serie_factura = $("#serie_factura"+id).val();
			var direccion = $("#direccion"+id).val();
			var horaviaje = $("#horaviaje"+id).val();
			var porcentaje = $("#porcentaje"+id).val();
			$(".id_sucursal").attr("id",codigo_sucursal);


			var serie_factura_viaje = $("#serie_factura_viaje"+id).val();
			var serie_boleta_viaje = $("#serie_boleta_viaje"+id).val();

			//var estado = $("#estado"+id).val();
			//console.log(horaviaje);
			// $("#mod_id").val(id);
			// $("#mod_codigo").val(codigo_sucursal);
			$("#id_sucursal").val(codigo_sucursal);
			$("#mod_nombresucursal").val(nombre_sucursal);
			$("#mod_direccion").val(direccion);
			$("#mod_fiscal").val(direccion_fiscal);
			$("#mod_seriefactura").val(serie_factura);
			$("#mod_serieboleta").val(serie_boleta);
			$("#mod_horaviaje").val(horaviaje);
			$("#mod_porcentaje").val(porcentaje);

			$("#mod_seriefactura_viaje").val(serie_factura_viaje);
			$("#mod_serieboleta_viaje").val(serie_boleta_viaje);
			//$("#mod_estado").val(estado);
			// $("#mod_codigosunat").val(codigo_sunat);
		}
</script>