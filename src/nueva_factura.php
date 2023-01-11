<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
    $documento = $_GET['d'];
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title= ($documento == 01) ? "Nueva Factura Electronica | Expreso Lima E.I.R.L" : "Nueva Boleta Electronica | Expreso Lima E.I.R.L";
	$doc= ($documento == 01) ? "Nueva Factura Electronica" : "Nueva Boleta Electronica";
	$tipDoc = ($documento == 01) ? "RUC" : "DNI";

	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/conexion.php");
	$variable = ($documento==01) ? "serie_factura_viaje" : "serie_boleta_viaje";

	$count_query   = mysqli_query($con, "SELECT $variable FROM tb_sucursales WHERE id_sucursal = '".$_SESSION['idsucursal']."'");
	$serie= mysqli_fetch_array($count_query);

	$count_query   = mysqli_query($con, "SELECT count(*) filas FROM tb_facturacion_cab WHERE id_tipo in (3,1) and id_sucursal = '".$_SESSION['idsucursal']."' and id_tipo_documento=".$documento);
	$row= mysqli_fetch_array($count_query);
	$filas = ($row['filas'] == 0) ? 1 : $row['filas']+1;
	$Ndocumento = $serie[$variable]."-".str_pad($filas, 8, "0", STR_PAD_LEFT);

	$query ="SELECT * FROM tb_sucursales";
	$fetch = mysqli_query($con,$query);

	$querya ="SELECT * FROM tb_buses ORDER BY placa";
	$fetcha = mysqli_query($con,$querya);
?>
<!DOCTYPE html>
<html lang="en">
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
				<a class="btn btn-info" href="facturas.php"><span class="glyphicon glyphicon-circle-arrow-left" ></span> Regresar</a>
			</div>
			<h4><i class='glyphicon glyphicon-edit'></i> <?php echo $doc?></h4>			
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			//include("modal/modal_bus_50.php");
		?>
			<form class="form-horizontal" role="form" id="datos_factura">
			<div id="diseño_bus"></div>
			<br>
			<div class="form-group row">
				<input hidden="true"  type="text" id="codigo" name="codigo"   value="" required>
					<label for="mail" class="col-md-1 control-label">N° Doc.</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" name="n_documento" id="ndocumento" value="<?php echo $Ndocumento; ?>">
						<input type="hidden" id="tipdoc" name="id_tipo_documento" value="<?php echo $documento ?>">
						<input type="hidden" id="piso" name="piso" value="">
					</div>
					<label for="tel1" class="col-md-1 control-label"><?php echo $tipDoc?></label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="Didentidad" value="" placeholder="Ingresar Numero de documento" >
					</div>
				  	<label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				  	<div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" readonly  >
					  <input id="id_cliente" name="id_cliente" type='hidden'>	
				  	</div>
				  	
					
				</div>
				<div class="form-group row">
					<label for="empresa" class="col-md-1 control-label">Dirección</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="direcc" value="" readonly>
					</div>
					<label for="tel2" class="col-md-1 control-label">Fecha</label>
					<div class="col-md-3">
						<input type="datetime-local" class="form-control input-sm" id="fecha" name="fecha" value="" readonly>
					</div>
					<label for="email" class="col-md-1 control-label">Pago</label>
					<div class="col-md-3">
						<!--select class='form-control input-sm' id="condiciones">
							<option value="1">Contado</option>
						</select-->
						<input type="text" class="form-control input-sm" id="condiciones" value="Contado" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label for="empresa" class="col-md-1 control-label">Destino</label>
					<div class="col-md-3">
						<select class="form-control" id="sucursal_llegada" name="id_sucu_llegada">
							<option value="">Seleccione</option>
							<?php
							while ($row = mysqli_fetch_array($fetch)) {
							?>
							<option value="<?php echo $row['id_sucursal']?>"><?php echo $row['nombre_sucursal'] ?></option>
							<?php
						}
							?>
						</select>
					</div>
					<label for="tel2" class="col-md-1 control-label">Bus</label>
					<div class="col-md-3">
						<select class="form-control" id="idbus" name="id_bus">
							<option value="">Seleccione</option>
							<?php
							while ($rowa = mysqli_fetch_array($fetcha)) {
							?>
							<option value="<?php echo $rowa['id_bus']?>"><?php echo $rowa['placa'] ?></option>
							<?php
						}
							?>
						</select>
					</div>
					<label for="fenvio" class="col-sm-1 control-label"> F. Salida</label>
					<div class="col-sm-3">
					  <input type="date" class="form-control delteimputs" id="fenvio" name="fenvio"  required>
					</div>
				</div>
				<div class="form-group row">
					<?php 
					$stl = ($documento == '03') ? "display:none;" : "display:block;" ;
					$stlcol = ($documento == '03') ? "col-md-12" : "col-md-8" ;
					?>
				<div id="divpasajero" style="<?php echo $stl; ?>"> 
				 <label for="dni_pasajero" class="col-md-1 control-label">DNI</label>
				 <div class="col-md-3">
				 	<input type="text" class="form-control " id="dni_pasajero" placeholder="Ingrese Numero de dni" required>
				 </div>

				 <label for="email" class="col-md-1 control-label">Pasajero</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="consignatario" name="consignatario" readonly>
						<input id="id_pasajero" name="id_pasajero" type='hidden'>
					</div>
				</div>
				<div class="<?php echo $stlcol; ?>">
					<div class="pull-right">

						<!--button id="asiento" type="button" class="btn btn-default" data-toggle="modal" data-target="#modalbus50">
						 <span class="glyphicon glyphicon-plus"></span> Asiento de 50
						</button>
						<button id="asiento" type="button" class="btn btn-default" data-toggle="modal" data-target="#modalbus53">
						 <span class="glyphicon glyphicon-plus"></span> Asiento de 53
						</button>
						<button id="asiento" type="button" class="btn btn-default" data-toggle="modal" data-target="#modalbus54">
						 <span class="glyphicon glyphicon-plus"></span> Asiento de 54
						</button-->
						<!--button id="asiento" type="button" class="btn btn-default">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo asiento
						id="agenciasa"
						</button-->
						<button data-toggle="modal" data-target="#exampleModal"	 type="button" class="btn btn-default">
						 <span class="glyphicon glyphicon-plus"></span> Acción
						</button>
						<button type="button" id="nuevocliente" class="btn btn-default" data-toggle="modal" data-target="#nuevoClientemodal">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<!--button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button-->
						<button type="button" id="save" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Guardar
						</button>
					</div>	
				</div>
				</div>
			</form>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px">
			<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reservación / Separación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
        	<div class="row">
        		<div class="col-md-4"><button id="agenciasa" type="button" class="form-control btn btn-danger"name=""><span class="glyphicon glyphicon-log-out"></span> Separar</button></div>
        		<div class="col-md-4"><button id="reserasiento" type="button" class="form-control btn btn-info"  name=""><span class="glyphicon glyphicon-new-window"></span> Reservar</button></div>
        		<div class="col-md-4"><button id="reserasiento" type="button" class="form-control btn btn-info"  name=""><span class="glyphicon glyphicon-road"></span> Liberar</button></div>

        	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>
 
		<!--table class="table">
			<tbody>
				<tr>
					<th class="text-center">CODIGO</th>
					<th class="text-center">CANT.</th>
					<th>DESCRIPCION</th>
					<th class="text-right">PRECIO UNIT.</th>
					<th class="text-right">PRECIO TOTAL</th>
					<th></th>
				</tr>
				<tr>
					<td class="text-center">2121</td>
					<td class="text-center">1</td>
					<td>2122</td>
					<td class="text-right">21.00</td>
					<td class="text-right">21.00</td>
					<td class="text-center"><a href="#" onclick="eliminar('2')"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>	
				<tr>
					<td class="text-right" colspan="4">SUBTOTAL $</td>
					<td class="text-right">147.00</td>
					<td></td>
				</tr>
				<tr>
					<td class="text-right" colspan="4">IVA (13)% $</td>
					<td class="text-right">19.11</td>
					<td></td>
				</tr>
				<tr>
					<td class="text-right" colspan="4">TOTAL $</td>
					<td class="text-right">166.11</td>
					<td></td>
				</tr>
			</tbody>
		</table-->






		</div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>
	</div>
	<div id="modals"></div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/clientes.js"></script>
	<script type="text/javascript" src="js/nueva_factura.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
			var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHJKMNPQRTUVWXYZ2346789";
       var contraseña = "";
       for (i=0; i<6; i++) contraseña +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));
       $("#codigo").val(contraseña); 
       console.log(contraseña);
		})
		function gencod(){
			var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHJKMNPQRTUVWXYZ2346789";
       var contraseña = "";
       for (i=0; i<6; i++) contraseña +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));
       $("#codigo").val(contraseña); 
       console.log(contraseña);
		};



    	function recargaBus(){
			idbus = $('#idbus').val();
		fecha = $('#fenvio').val(); //new Date().toDateInputValue();
		if (idbus.length > 0 && fecha.length > 0) {
			$.ajax({
	            url: './ajax/modal_bus_50.php',
	            type: 'POST',
	            data: 'idbus='+idbus+'&fecha='+fecha,
	            dataType: "json",
	            beforeSend: function() {
	                 $.ajaxblock();
	            },
	            success: function(response) {
	                
	            },
	            complete: function(datos) {
	               $.ajaxunblock(); 	               
	               $("#diseño_bus").html(datos.responseText);
	               // $('#diseño_bus').html()
	    //            if (idbus == 1 || idbus == 17) { $("#modalbus54").modal(); }
					// else if (idbus == 18 || idbus == 19){ $("#modalbus50").modal(); }
					// 	else if (idbus == 16) { $("#modalbus53").modal(); }
	            }
	        });
		}else{
			Swal('Mensaje','seleccionar un bus y/o fecha salida', 'warning');
		}
		}
		$(document).on('click','#agenciasa', function(e){
		//alert("hola");
		bus = $('#idbus').val();
		asiento = $('#asiento span').html();
		piso = $('#piso_cab span').html();
		temp='bus='+bus+'&asiento='+asiento+'&piso='+piso;
		$.ajax({
			url: 'ajax/separacion_agencias.php',
	        type: 'POST',
	        data:$('#datos_factura').serialize()+temp,
	        success:function(data){
	        	alert(data);
	        	recargaBus();
	        	//location.reload(true);

	        }
		})
	});

    $(document).on('click','#reserasiento', function(e){
      bus = $('#idbus').val();
	  asiento = $('#asiento span').html();
	  piso = $('#piso_cab span').html();
	  desti=$('#sucursal_llegada').val();
	  //alert(desti);
	  if (desti==""){
		  Swal('¡Alerta!','Debe de Ingresar el Destino Final', 'warning');
		  return;
		}
	  temp='&bus='+bus+'&asiento='+asiento+'&piso='+piso;
	  $.ajax({
			url: 'ajax/g_reserva.php',
	        type: 'POST',
	        data:$('#datos_factura').serialize()+temp,
	        success:function(data){
	        	//alert(data);
	        	console.log(data);
	        	if(data==0){
	        		Swal('Mensaje','Asiento Ocupado, Elija Otro', 'warning');
                  //alert("Asiento Ocupado, Elija Otro");
	        	}
	        	if(data==100){
	        		Swal('Mensaje','error Ocupado, Elija Otro', 'warning');
                  //alert("Asiento Ocupado, Elija Otro");
	        	}
	        	if (data==10) {
	        		Swal('Mensaje','Asiento Reservado con Exito', 'success');
	        	}
	        	if (data==11) {
	        		Swal('Mensaje','Detalle Reservado con Exito', 'success');
	        	}
	        	recargaBus();
	        	//location.reload(true);

	        }
		})
    });
    </script>
	<script>
		$(function() {
			var tipdoc = $('#tipdoc').val();
			$("#Didentidad").autocomplete({
				source: "./ajax/autocomplete/clientes.php?d="+tipdoc,
				minLength: 2,
				select: function(event, ui) {
					event.preventDefault();
					console.log(ui.item);
					$('#id_cliente').val(ui.item.id_cliente);
					$('#nombre_cliente').val(ui.item.nombre_cliente);
					$('#Didentidad').val(ui.item.documentoidentidad);
					$('#direcc').val(ui.item.direcc);
				 }
			});
			$("#sucursal_llegada").autocomplete({
				source: "./ajax/autocomplete/sucursales.php",
				appendTo: "#nuevoEncomienda",	
				minLength: 2,
				select: function(event, ui) {
					event.preventDefault();
					$('#sucursales').val(ui.item.id_sucursal);
					$('#sucursal_llegada').val(ui.item.nombre_sucursal);
				 }
			});
			$("#dni_pasajero").autocomplete({
				source: "./ajax/autocomplete/clientes.php?d=03",
				minLength: 2,
				select: function(event, ui) {
					event.preventDefault();
					console.log(ui.item);
					$('#id_pasajero').val(ui.item.id_cliente);
					$('#consignatario').val(ui.item.nombre_cliente);
					$('#dni_pasajero').val(ui.item.documentoidentidad);
				 }
			});
		});
		$(function() {
			$("#nombus").autocomplete({
				source: "./ajax/autocomplete/bus.php",
				minLength: 2,
				select: function(event, ui) {
					event.preventDefault();
					console.log(ui.item);
					$('#idbus').val(ui.item.idbus);
					$('#nombus').val(ui.item.placa);				
				 }
			});
		});
					
		/*$("#nombre_cliente" ).on( "keydown", function( event ) {
					if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
					{
						$("#id_cliente" ).val("");
						$("#tel1" ).val("");
						$("#mail" ).val("");
										
					}
					if (event.keyCode==$.ui.keyCode.DELETE){
						$("#nombre_cliente" ).val("");
						$("#id_cliente" ).val("");
						$("#tel1" ).val("");
						$("#mail" ).val("");
					}
		});	*/
	</script>

  </body>
</html>