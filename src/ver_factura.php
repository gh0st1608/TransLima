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
	$title="Ver Factura | Expreso Lima E.I.R.L";
	
	
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	if (isset($_GET['id_factura']))
	{
		print_r('entroooooooooooooooooooooooooo222222222222222o');
		$id_factura=intval($_GET['id_factura']);
		$campos="tb_sucursales.nombre_sucursal, tb_cliente.id_cliente, tb_cliente.nombre_cliente, tb_cliente.telefono, tb_cliente.direccion,  tb_facturacion_cab.fecha_creado, tb_facturacion_cab.n_documento,tb_usuarios.nombre_usuario, tb_buses.placa, tb_facturacion_cab.precio_texto, tb_facturacion_cab.id_tipo_documento, tb_cliente.n_documento_identidad, tb_facturacion_cab.fecha_envio, tb_facturacion_cab.valor_total, tb_facturacion_cab.igv_total , tb_facturacion_cab.precio_total, tb_facturacion_cab.id_tipo, tb_facturacion_cab.consignatario";
		$sql_factura=mysqli_query($con,"select $campos from tb_facturacion_cab, tb_cliente, tb_usuarios, tb_buses, tb_sucursales where tb_sucursales.id_sucursal = tb_facturacion_cab.id_sucursal_llegada and tb_facturacion_cab.id_usuario_creador = tb_usuarios.id_usuario and tb_buses.id_bus = tb_facturacion_cab.id_bus and tb_facturacion_cab.id_cliente = tb_cliente.id_cliente and id_facturacion='".$id_factura."'");
		$count=mysqli_num_rows($sql_factura);

		$sqlempresa = mysqli_query($con,"select * from tb_empresa	 where id_empresa=1");
		$empr=mysqli_fetch_array($sqlempresa);
		$ruc = $empr['ruc'];

		if ($count == 1)
		{
				$rw_factura=mysqli_fetch_array($sql_factura);
				$id_cliente=$rw_factura['id_cliente'];
				$nombre_cliente=$rw_factura['nombre_cliente'];
				$n_documento=$rw_factura['n_documento_identidad'];
				$direccion_cliente=$rw_factura['direccion'];
				$id_vendedor_db= $rw_factura['nombre_usuario'];
				$fecha_salida= date("d/m/Y", strtotime($rw_factura['fecha_envio']));
				$fecha_factura=date("d/m/Y h:i:s a", strtotime($rw_factura['fecha_creado']));
				$condiciones= "";//$rw_factura['condiciones'];
				$estado_factura= "";//$rw_factura['estado_factura'];
				$numero_factura=$rw_factura['n_documento'];
				$placa=$rw_factura['placa'];
				$_SESSION['id_factura']=$id_factura;
				$_SESSION['numero_factura']=$numero_factura;
				$precio_texto = $rw_factura['precio_texto'];
				$documento = ($rw_factura['id_tipo_documento'] == "3") ? "Boleta Venta Electronica" : "Factura Electronica";
				$tipdoc = ($rw_factura['id_tipo_documento'] == "3") ? "03" : "01";
				$sucursal_llegada = $rw_factura['nombre_sucursal'];

				

				$subt = $rw_factura['valor_total'];
				$igvf = $rw_factura['igv_total'];
				$pre = $rw_factura['precio_total'];

				/*$rw_facturadet=mysqli_fetch_array($sql_fac_det);
				$precio = $rw_facturadet['precio_unitario'];
				$igv = $rw_facturadet['igv_total'];
				$preciototal = $rw_facturadet['precio_total'];
				$descripccion = $rw_facturadet['descripccion'];*/

				$docidentidad = ($rw_factura['id_tipo_documento'] == "3") ? "DNI" : "RUC";
				$id_tipo = $rw_factura['id_tipo'];

				if ($id_tipo == 3) {
					$consignatario = $rw_factura['consignatario'];
				}else{
					$consignatario = ($tipdoc == "03") ? $nombre_cliente : $rw_factura['consignatario'];
				}
				
 				
		}	
		else
		{
			header("location: facturas.php");
			exit;	
		}
	} 
	else 
	{
		header("location: facturas.php");
		exit;
	}
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
				<?php 
				$ruta = "C:\SFS_v1.3.4.2\sunat_archivos\sfs\FIRMA\\".$ruc."-".$tipdoc."-".$numero_factura.".xml";
				if(file_exists($ruta)){
				$idbtn = "imprimir_ticketera";
                $contenido = nl2br(file_get_contents($ruta));
                $hash = substr($contenido , 1209, 28);
            	}else { $idbtn = "errorxml"; }
				 ?>
            	<a  href="nueva_factura.php?d=03" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nueva Boleta Electronica</a>
            	<a  href="facturas.php" class="btn btn-info" style="margin-left: 11px;"><span class="glyphicon glyphicon-arrow-left" ></span> 
				Regresar</a>

            
			
			</div>
			<h4><i class='glyphicon glyphicon-edit'></i> <?php echo $documento; ?></h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_factura">
				<div class="form-group row">
				  <label for="n_documento" class="col-md-1 control-label">N° Doc.</label>
				  <div class="col-md-3">
					  <input type="text" readonly class="form-control input-sm" id="n_documento" required value="<?php echo $numero_factura;?>">	
					  <input type="hidden"  value="<?php echo $id_factura; ?>" id="id_factura">
				  </div>
				  <label for="tel2" class="col-md-1 control-label">Fecha</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-sm" id="fecha" value="<?php echo $fecha_factura;?>" readonly>
					</div>
				  <label for="empresa" class="col-md-1 control-label">F. Salida</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="id_vendedor" placeholder="Vendedor" value="<?php echo $fecha_salida;?>" readonly>					
					</div>
				 </div>
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				  <div class="col-md-3">
					  <input type="text" readonly class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required value="<?php echo $nombre_cliente;?>">
					  <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">	
				  </div>
				  <label for="tel1" class="col-md-1 control-label"><?php echo $docidentidad; ?> </label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" value="<?php echo $n_documento;?>" readonly>
							</div>
					<label for="mail" class="col-md-1 control-label">Direccion</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly  value="<?php echo $direccion_cliente;?>">
							</div>
				 </div>	
				 <div class="form-group row">
				  <label for="idbus" class="col-md-1 control-label">Bus</label>
				  <div class="col-md-3">
					  <input type="text" readonly class="form-control input-sm" id="idbus" value="<?php echo $placa;?>">	
				  </div>	
				  <label for="moneda" class="col-md-1 control-label">Destino</label>
				  <div class="col-md-2">
					  <input type="text" readonly class="form-control input-sm" id="moneda" value="<?php echo $sucursal_llegada; ?>">	
				  </div>
				  <?php if ($id_tipo == 3 && $tipdoc == "01") {?>
				  	 <label for="formapago" class="col-md-1 control-label">Pasajero</label>
				  <div class="col-md-3">
					  <input type="text" readonly class="form-control input-sm" id="Consignatario" value="<?php echo $consignatario; ?>">	
				  </div>	
				  <?php } ?>
				 			
				 </div>
				 				
			</form>	
			<div class="clearfix"></div>
				<div class="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px">
			
			<table class="table" id="tabledetalle">
			<tbody>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Cantidad</th>
					<th>Descripción</th>
					<th class="text-right">Precio Unitario</th>
					<th class="text-right">Precio Total</th>
					<th></th>
				</tr>
				<?php 	

			$sqltabledet=mysqli_query($con, "select * from tb_facturacion_det where tb_facturacion_det.id_facturacion ='".$id_factura."'");
				$hash = 0 ;
				while ($rows=mysqli_fetch_array($sqltabledet)){  $hash++; ?>
						<tr class="precios">
							<td class="text-center"><?php echo $hash; ?></td>
							<td class="text-center"><?php echo $rows['cantidad']; ?></td>
							<td class="desc"><?php echo $rows['descripccion']; ?></td>
							<td class="text-right valor"><?php echo $rows['precio_unitario']; ?></td>
							<td class="text-right preciototal"><?php echo $rows['precio_total']; ?></td>
							<td class="text-center"></td>
						</tr>
				<?php } 
				if ($id_tipo == 1 || $id_tipo == 3) {
					$texto = "OP EXONERADA";
				}else if ($id_tipo == 2) {
					$texto = ($tipdoc == "03") ? "OP INAFECTA" : "SUBTOTAL";
				}
				?>	
				<tr class="subtotal">
					<td class="text-right" colspan="4"><?php echo $texto; ?> S/.</td>
					<td class="text-right valor"><?php echo $subt; ?></td>
					<td></td>
				</tr>
				<tr class="igv">
					<td class="text-right" colspan="4">IGV (18)% S/.</td>
					<td class="text-right valor"><?php echo $igvf; ?></td>
					<td class="text-center"></td>
				</tr>
				<tr class="total">
					<td class="text-right" colspan="4">TOTAL S/.</td>
					<td class="text-right valor"><?php echo $pre; ?></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		</div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_factura.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
				
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#tel1').val(ui.item.telefono_cliente);
								$('#mail').val(ui.item.email_cliente);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_cliente" ).on( "keydown", function( event ) {
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
			});	
	</script>

  </body>
</html>