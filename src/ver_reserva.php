<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_reservas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Ver Reserva | Expreso Lima E.I.R.L";
	
	
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	if (isset($_GET['id_reserva']))
	{
		$id_reserva=intval($_GET['id_reserva']);

				
		$sql_enco=mysqli_query($con,"select * from tb_reservas_cab, tb_cliente, tb_sucursales where  tb_sucursales.id_sucursal = tb_reservas_cab.id_sucursal_llegada  and tb_reservas_cab.id_cliente = tb_cliente.id_cliente and tb_reservas_cab.id_reservas='".$id_reserva."'");
		$countenco=mysqli_num_rows($sql_enco);

		//print_r($countenco);

		if ($countenco == 1)
		{
				$rw_encomienda=mysqli_fetch_array($sql_enco);
				$nombre_cliente=$rw_encomienda['nombre_cliente'];
				$n_documento=$rw_encomienda['n_documento_identidad'];
				$destino=$rw_encomienda['nombre_sucursal'];
				$docidentidad= ($rw_encomienda['id_tipo_persona'] == "1") ? "DNI" : "RUC";
				$fecha=date("d/m/Y h:i:s a", strtotime($rw_encomienda['fecha_registro']));	
				$codigo = $rw_encomienda['codigo'];
				$fechasal = date("d/m/Y", strtotime($rw_encomienda['fecha_salida']));

		}	
		else
		{
			header("location: reservas.php");
			exit;
			
		}
	} 
	else 
	{
		header("location: reservas.php");
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
			<h4><i class='glyphicon glyphicon-edit'></i> Ver Encomienda</h4>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form" id="datos_factura">
				<div class="form-group row">
				  <label for="n_documento" class="col-md-1 control-label">Codigo</label>
				  <div class="col-md-3">
					  <input type="text" readonly class="form-control input-sm" id="n_documento" required value="<?php echo $codigo;?>">	
				  </div>
				  <label for="tel2" class="col-md-1 control-label">Fecha</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-sm" id="fecha" value="<?php echo $fecha;?>" readonly>
					</div>
				  <label for="empresa" class="col-md-1 control-label">F. Salida</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm"  value="<?php echo $fechasal;?>" readonly>					
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
					<label for="mail" class="col-md-1 control-label">Destino</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly  value="<?php echo $destino;?>">
							</div>
				 </div>	
			</form>	
			<div class="clearfix"></div>
				<div class="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px">
			
			<table class="table" id="tabledetalle">
			<tbody>
				<tr>
					<th class='text-center'>#</th>
					<th class='text-center'>Descripcion</th>
					<th class='text-right'>Precio</th>
				</tr>
				<?php
				$sql=mysqli_query($con, "select * from tb_reservas_det where tb_reservas_det.codigo='".$codigo."'");
				$hash = 0;
				while ($row=mysqli_fetch_array($sql))
				{
				$hash++; 
				$descripcion=$row["descripcion"];
				$id_reservas_det=$row["id_reservas_det"];	
				$total = $row['total'];
				$valordeprecio = ($total == 0) ? '<input id="'.$id_reservas_det.'" class="txtenvio" type="text" name="preciobus">' : number_format($total,2) ;
					?>
					<tr class="if">
						<td class='text-center else'><?php echo $hash;?></td>
						<td class='text-center'><?php echo $descripcion;?></td>
						<td class="text-right"><?php echo $valordeprecio;?></td>
					</tr>		
					<?php } ?>
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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  </body>
</html>