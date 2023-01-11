<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_reservas = "active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Nueva Reserva | Expreso Lima E.I.R.L";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	$query ="SELECT * FROM tb_sucursales";
	$fetch = mysqli_query($con,$query);

	$querya ="SELECT * FROM tb_buses";
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
			<h4><i class='glyphicon glyphicon-edit'></i> Nueva Reserva</h4>
		</div>
		<div class="panel-body">
		<?php 
			//include("modal/buscar_reservas.php");
			include("modal/registro_clientes.php");
		?>
			<form class="form-horizontal" role="form" id="datos_reserva">
				<div id="modals"></div>
				<div class="form-group row">
				  <label for="codigo" class="col-md-1 control-label">Codigo</label>
				  <div class="col-md-3">
				  	<div id="recar">
				  		<input type="text" class="form-control input-sm" id="codigo" name="codigo"   value="" required>
				  	</div>
					  
					  
				  </div>
				  <label for="tel1" class="col-md-1 control-label">N. Doc</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="Didentidad" value="" name="Didentidad" placeholder="Ingresar Numero de documento" >
					</div>
				  	<label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				  	<div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" readonly  >
					  <input id="id_cliente" name="id_cliente" type='hidden'>	
				  	</div>
				 </div>
				 <div class="form-group row">
					<label for="empresa" class="col-md-1 control-label">Bus</label>
					<div class="col-md-3">
						<select class="form-control" id="idbus" name="id_bus">
							<option>Seleccione</option>
							<?php
							while ($rowa = mysqli_fetch_array($fetcha)) {
							?>
							<option value="<?php echo $rowa['id_bus']?>"><?php echo $rowa['placa'] ?></option>
							<?php
						}
							?>
						</select>
						<!-- <input type="text" placeholder="Ingresar placa" class="form-control input-sm" id="nombus" value="">
						<input type="hidden" class="form-control input-sm" id="idbus" name="id_bus" value="" readonly> -->
					</div>
					
					<label for="tel2" class="col-md-1 control-label">Fecha</label>
					<div class="col-md-3">
						<input type="datetime-local" class="form-control" name="fecha" id="fecha" value="" readonly="">
					</div>
					<label for="fenvio" class="col-sm-1 control-label"> F. Salida</label>
					<div class="col-sm-3">
					  <input type="date" class="form-control delteimputs" id="fenvio" name="fenvio"  required>
					</div>

				</div>
				<div class="form-group row">
				<label for="email" class="col-md-1 control-label">Destino</label>
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
						<!-- <input type="text" class="form-control " id="sucursal_llegada" placeholder="Ingrese Sucursal Destino" required>
						<input id="sucursales" name="id_sucu_llegada" type='hidden' class=""> -->
					</div>

				

				
			
				
				
				<div class="col-md-8">
					
					<div class="pull-right">						
						<button type="button" class="btn btn-default" id="nuevocliente" data-toggle="modal" data-target="#nuevoClientemodal">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<!--button type="button" id="asiento" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo Asiento
						</button-->
						<button type="button" id="guardar_datosgenerales" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Guardar
						</button>
					</div>	
				</div>
				</div>
			</form>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>
	</div>
	<hr>
	<?php
	include("footer.php");

	 // function generarCodigo($longitud) {
	 // 	    $key = '';
	 // 	    $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
	 // 	    $max = strlen($pattern)-1;
	 // 	    for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
	 // 	    return strtoupper($key);
	 // 	} 

	?>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="js/clientes.js"></script>
	<script>
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
			fecha = $('#fenvio').val();
			if (idbus.length > 0 && fecha.length > 0) {
				$.ajax({
		            url: './ajax/bus_ht.php',
		            type: 'POST',
		            data: 'idbus='+idbus+'&fecha='+fecha,
		            dataType: "json",
		            beforeSend: function() {
		                 $.ajaxblock();
		            },
		            success: function(response) {
		                
		            },
		            complete: function(datos) {
		               //$('#buscarclientes').modal('show');
		               $.ajaxunblock(); 	               
		               $("#modals").html(datos.responseText);
		               $("#cab_preciop").hide();
		               $("#precio").hide();
		               $("#table_det tbody tr.title-fileds").append("<th id='idrow' rowspan='2'><i class='glyphicon glyphicon-plus'></i></th>");

		    //            if (idbus == 1 || idbus == 17) { $("#modalbus54").modal(); }
						// else if (idbus == 18 || idbus == 19){ $("#modalbus50").modal(); }
						// 	else if (idbus == 16) { $("#modalbus53").modal(); }
							
							$('.else').parents("tr.if").find("td.descp").each(function() {
					         valpisoasiento = $(this).html();
					         piso = valpisoasiento.substr(7,1);
					         asiento = valpisoasiento.substr(19,2);
					         id = piso+asiento;
					         $('#'+id).removeClass('idrow');
					         $('#'+id).addClass('yaesta');

					        });
		            }
		        });
			}else{
				Swal('Mensaje','seleccionar un bus y/o fecha salida', 'warning');
			}
		}
		
		$(document).on('change', '#fenvio', function(e) {
			
			idbus = $('#idbus').val();
			fecha = $('#fenvio').val();
			if (idbus.length > 0 && fecha.length > 0) {
				$.ajax({
		            url: './ajax/bus_ht.php',
		            type: 'POST',
		            data: 'idbus='+idbus+'&fecha='+fecha,
		            dataType: "json",
		            beforeSend: function() {
		                 $.ajaxblock();
		            },
		            success: function(response) {
		                
		            },
		            complete: function(datos) {
		               //$('#buscarclientes').modal('show');
		               $.ajaxunblock(); 	               
		               $("#modals").html(datos.responseText);
		               $("#cab_preciop").hide();
		               $("#precio").hide();
		               $("#table_det tbody tr.title-fileds").append("<th id='idrow' rowspan='2'><i class='glyphicon glyphicon-plus'></i></th>");

		    //            if (idbus == 1 || idbus == 17) { $("#modalbus54").modal(); }
						// else if (idbus == 18 || idbus == 19){ $("#modalbus50").modal(); }
						// 	else if (idbus == 16) { $("#modalbus53").modal(); }
							
							$('.else').parents("tr.if").find("td.descp").each(function() {
					         valpisoasiento = $(this).html();
					         piso = valpisoasiento.substr(7,1);
					         asiento = valpisoasiento.substr(19,2);
					         id = piso+asiento;
					         $('#'+id).removeClass('idrow');
					         $('#'+id).addClass('yaesta');

					        });
		            }
		        });
			}else{
				Swal('Mensaje','seleccionar un bus y/o fecha salida', 'warning');
			}
		});

		function reserasiento(asiento,piso){
			desti=$('#sucursal_llegada').val();
			if (desti==""){
				Swal('¡Alerta!','Debe de Ingresar el Destino Final', 'warning');
				return;
			}
		//bus = $('#idbus').val();
		bus ='';
		//asiento = $('#asiento span').html();
		//piso = $('#piso_cab span').html();
		temp='&bus='+bus+'&asiento='+asiento+'&piso='+piso;
		$.ajax({
			url: 'ajax/g_reserva.php',
	        type: 'POST',
	        data:$('#datos_reserva').serialize()+temp,
	        dataType:'json',
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

	        	// Método 1
	        	// let $btn;
	        	// $btn = $('#btn'+asiento+piso);
	        	// // console.log($btn);
	        	// $btn.removeClass('asiento asiento-disponible');
	        	// $btn.addClass('asiento asiento-ocupado');

	        	// Método 2
	        	gencod();
	        	recargaBus();
	        	// generarCodigo($longitud);
	        }
		})
		}

		$(function() {

			$("#Didentidad").autocomplete({
					source: "./ajax/autocomplete/clientes.php?d=0",
					minLength: 2,
					select: function(event, ui) {
						event.preventDefault();
						console.log(ui.item);
						$('#id_cliente').val(ui.item.id_cliente);
						$('#nombre_cliente').val(ui.item.nombre_cliente);
						$('#Didentidad').val(ui.item.documentoidentidad);
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

			$('#fecha').val(new Date().toDateInputValue());
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


		$(document).on('click', '#idrow', function(e) {
		
			valrow = $("#asiento span").html();  
			valpiso = $("#piso_cab span").html();
			idbus = $('#idbus').val();
			codigo = $('#codigo').val();

			
			if (valrow.length) {

				$.ajax({
			        type: "POST",
			        url: "./ajax/agregar_reserva.php",
			        data: 'valrow='+valrow+'&valpiso='+valpiso+'&idbus='+idbus+'&codigo='+codigo,
					beforeSend: function(objeto){
					},
			        success: function(datos){
			        //$("#myModal").modal("hide");
			        //$('.delteimputs').val("");
						$("#resultados").html(datos);
						// $("#btn"+valrow+valpiso).removeClass("asiento asiento-disponible");
						// $("#btn"+valrow+valpiso).addClass("asiento asiento-ocupado");
						$("#asiento span").html('');  
						$("#piso_cab span").html('');
					},
					complete: function(datos) {
		               $.ajaxunblock(); 
		               if (idbus == 1 || idbus == 17) { $("#modalbus54").modal("hide"); }
						else if (idbus == 18 || idbus == 19){ $("#modalbus50").modal("hide"); }
							else if (idbus == 16) { $("#modalbus53").modal("hide"); }
	               //$("#resultados").html(datos.responseText);
	            }
				});
			}else{
				Swal('Mensaje','Seleccionar Asiento','warning');
			}
		});

		$(document).on('click', '#guardar_datosgenerales', function(e) {

			sihayregistros = $('table#tablareserva').find('tr.if td.else').html();
			ndoc = $('#Didentidad').val();
			idbus = $('#idbus').val();
			fenvio = $('#fenvio').val();
			valorinput = $('.txtenvio').val();
			sucursales = $('#sucursales').val();


			if (sihayregistros == 1 && ndoc.trim().length && sucursales.trim().length && idbus.trim().length && fenvio.trim().length && valorinput === undefined) {
			
			fecha = new Date().toDateInputValue();
					
			$.ajax({
		        type: "POST",
		        url: "./ajax/save_reserva.php",
		        data: $('#datos_reserva').serialize()+'&fecha='+fecha,
				 beforeSend: function(objeto){
									  },
		        success: function(datos){
					var idres = datos.split("-");
					status = (idres[1] == "El documento fue creada correctamente") ? 'success' : 'error' ;            	
	            	Swal('Mensaje',idres[1],status);   

	            	var url = location.origin; console.log(url);
	               	
	               	if (url == "http://localhost" || url == "http://localhost:8080") {
	               			window.location.href  = url + "/Expreso/ver_reserva.php?id_reserva="+idres[0];
	               	}else{
	               			window.location.href  = url + "/ver_reserva.php?id_reserva="+idres[0];
	               	}
				}
			});
		}else{Swal('Mensaje','Completar todos los datos requeridos','warning');   }
		});

		Date.prototype.toDateInputValue = (function() {
		    var local = new Date(this);
		    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
		    return local.toJSON().slice(0,19);
		});

		function eliminar (id)
		{	
			codigo = $('#codigo').val();
			//tipdoc =$('#tipdoc').val();
			//+"&codigo="+codigo+"&tipdoc="+tipdoc
			$.ajax({
		        type: "GET",
		        url: "./ajax/agregar_reserva.php",
		        data: "id="+id+"&codigo="+codigo,
				 beforeSend: function(objeto){
					
				  },
		        success: function(datos){
				$("#resultados").html(datos);
				
				}
			});
		}
		
		$(document).on('click', '#asiento', function(e) {
			
		});

		(function($){
		$.ajaxblock 	= function(){
			$("body").prepend("<div id='ajax-overlay'><div id='ajax-overlay-body' class='center'><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><span class='sr-only'>Loading...</span></div></div>");
			$("#ajax-overlay").css({
				position: 'absolute',
				color: '#FFFFFF',
				top: '0',
				left: '0',
				width: '100%',
				height: '100%',
				position: 'fixed',
				background: 'rgba(39, 38, 46, 0.67)',
				'text-align': 'center',
				'z-index': '9999'
			});
			$("#ajax-overlay-body").css({
				position: 'absolute',
				top: '40%',
				left: '50%',
				width: '120px',
				height: '48px',
				'margin-top': '-12px',
				'margin-left': '-60px',
				//background: 'rgba(39, 38, 46, 0.1)',
				'-webkit-border-radius':	'10px',
				'-moz-border-radius':	 	'10px',
				'border-radius': 		 	'10px'
			});
			$("#ajax-overlay").fadeIn(50);
		};
		$.ajaxunblock 	= function(){
			$("#ajax-overlay").fadeOut(100, function()
			{
				$("#ajax-overlay").remove();
			});
		};
	})(jQuery);

	
	$(document).on('blur', '.txtenvio', function(e) {
	//$( ".txtenvio" ).blur(function() {

		id = $(this).attr('id');
		txtenv = $(this).val();
		codigo = $('#codigo').val();

		$.ajax({
		        type: "POST",
		        url: "./ajax/agregar_reserva.php",
		        data: "id="+id+"&txtenv="+txtenv+"&codigo="+codigo,
				 beforeSend: function(objeto){
					
				  },
		        success: function(datos){
				$("#resultados").html(datos);
				
				}
			});

	});

	$(document).on('blur', '.txtpasajero', function(e) {
	//$( ".txtenvio" ).blur(function() {

		id = $(this).attr('idpas');
		txtenv = $(this).val();
		codigo = $('#codigo').val();

		$.ajax({
		        type: "POST",
		        url: "./ajax/agregar_reserva.php",
		        data: "id="+id+"&txtpasajero="+txtenv+"&codigo="+codigo,
				 beforeSend: function(objeto){
					
				  },
		        success: function(datos){
				$("#resultados").html(datos);
				
				}
			});

	});

	
	$(document).on('click', '.yaesta', function(e) {
		Swal('Mensaje','Asiento ya esta registrado', 'warning');
	});

	$(document).on('click', '.asiento-disponible', function(e) {
		asiento = $(this).attr('numero');
		piso = $(this).attr('piso');
		$("#piso_cab span").html(piso);
		$("#asiento span").html(asiento);
	});

	$(document).on('click', '.asiento-seleccionado', function(e) {
		Swal('Mensaje','Asiento esta ocupado', 'warning');
	});
	$(document).on('click', '.asiento-ocupado', function(e) {
		Swal('Mensaje','Asiento esta ocupado', 'warning');
	});
	</script>

  </body>
</html>