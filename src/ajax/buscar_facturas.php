<?php

	include('is_logged.php');
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$numero_factura=intval($_GET['id']);
		$del1="delete from facturas where numero_factura='".$numero_factura."'";
		$del2="delete from detalle_factura where numero_factura='".$numero_factura."'";
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php
			
		}
	}
	//var_dump($_SESSION['id_rol']);
	//echo "<br>";
	//var_dump($_SESSION['idsucursal']);die();
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$sTable = "tb_facturacion_cab tb_facturacion_cab inner join tb_cliente tb_cliente on tb_facturacion_cab.id_cliente = tb_cliente.id_cliente inner join tb_sucursales tb_sucursales on tb_facturacion_cab.id_sucursal = tb_sucursales.id_sucursal";
		$sWhere_count = "";
		$sWhere_count = "";
		$sWhere =" WHERE tb_facturacion_cab.eliminado = 0 AND tb_facturacion_cab.id_cliente=tb_cliente.id_cliente ";
		if ( $_SESSION['id_rol'] != 1)
		{
			$sWhere.= "    and tb_facturacion_cab.id_sucursal = ".$_SESSION['idsucursal'];

			$sWhere_count = " where tb_facturacion_cab.id_sucursal = ".$_SESSION['idsucursal'];
			
		}else{
			$sWhere.= "    and tb_facturacion_cab.id_sucursal = tb_sucursales.id_sucursal";
		}
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (tb_cliente.nombre_cliente like '%$q%' or tb_facturacion_cab.n_documento='$q')";
			
		}
		
		if ( $_SESSION['id_rol'] == 1)
		{
			
		}
			$sWhere.= " group by tb_facturacion_cab.n_documento ";
		$sWhere.=" order by tb_facturacion_cab.id_facturacion desc";
		// print_r($sTable);
		// print_r($sWhere);
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$query = "SELECT COUNT(*) numrows FROM (SELECT 1 FROM tb_facturacion_cab $sWhere_count LIMIT 15) a"; //print_r($query);
		$count_query  = mysqli_query($con, $query);
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);

		$querya ="SELECT * FROM tb_buses";
	    $busesht = mysqli_query($con,$querya);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<?php if ($_SESSION['id_rol'] == 1) {
						echo "<th>Sucursal</th>";
					} ?>
					<th>Tipo Documento</th>
					<th>Documento</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th class='text-right'>Total</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					//echo "<pre>"; print_r($row);echo "</pre>"; 
						$id_factura=$row['id_facturacion'];
						$numero_factura=$row['id_facturacion'];
						$numero_documento=$row['n_documento'];
						$fecha=date("d/m/Y", strtotime($row[9]));
						//$fecha=date("d/m/Y h:i:s a", strtotime($row[9]));
						//$Object = new DateTime(); 
						//$fecha = $Object->format("d-m-Y h:i:s a");
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono'];
						$email_cliente=$row['correo'];
						$total_venta=$row['precio_total'];
						$b=$row['id_bus'];
						$tipo_documento  = ($row['id_tipo_documento'] == 1) ? "Factura" : "Boleta";
						$offset++;
					?>
					<tr>
						<td><?php echo $offset; ?></td>
						<?php if ($_SESSION['id_rol'] == 1) {
							echo "<td>".$row['nombre_sucursal']."</td>";
						} ?>
						<td><?php echo $tipo_documento; ?></td>
						<td><?php echo $numero_documento; ?></td>
						<td><?php echo $fecha; ?></td>
						<!-- <td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_cliente;?>" ><?php echo $nombre_cliente;?></a></td> -->

						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						
						
						<td class='text-right'><?php echo number_format ($total_venta,2); ?></td>					
					<td class="text-right">
						<a href="ver_factura.php?id_factura=<?php echo $id_factura;?>" class='btn btn-default' title='Ver factura' ><i class="glyphicon glyphicon-eye-open"></i></a> 
						<a href="#" class='btn btn-default' target="_blank" title='Descargar factura' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a>
						<a href="eliminar_factura.php?id_factura=<?php echo $id_factura;?>" class='btn btn-default' title='Eliminar_factura' ><i class="glyphicon glyphicon-trash"></i></a>  <?php
						if ($b=="99"){
							$stylo="background:#E96B6B";
						}else{
							$stylo="";
						}
						if($_SESSION['id_rol'] == 1){
							$esconder="display:inline";
						}else{
							$esconder="display:none";
						}
						?>
						<!-- <a style="<?php echo $stylo ?>;<?php echo $esconder?>" href="#" class='btn btn-default' title='Liberar asiento' onclick="bboleto('<?php echo $numero_factura; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
						<a style=";<?php echo $esconder?>" href="#" data-toggle="modal" data-target="#exampleModal" class='btn btn-default' title='Ocupar asiento' onclick="ocupar('<?php echo $numero_factura; ?>')"><i class="glyphicon glyphicon-send"></i> </a> -->
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			  <!-- Modal asignacion de asiento -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignación de Asiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<center>
        <select style="width: 350px" class="form-control" id="idbuss" name="idbuss">
        	<option>SELECCIONE BUS</option>
        	<?php
        	foreach ($busesht as $key => $value) {
        		echo "<option value='".$value['id_bus']."'>".$value['placa']."</option>";
        	}
        	?>
        </select>
        <br>
        <input style="width: 350px" hidden="true" class="form-control" type="hidden" name="idfact" id="idfact">
        <input style="width: 350px" class="form-control" type="text" name="pisov" id="pisov" placeholder="Ingrese el PISO"><br>
        <input style="width: 350px" class="form-control" type="text" name="asientov" id="asientov" placeholder="Ingrese el ASIENTO"><br>
        <input style="width: 350px" class="form-control" type="date" name="fechaviaje" id="fechaviaje"></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button onclick="asignar();" type="button" class="btn btn-primary">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
			</div>
			<?php
		}
	}
?>
<script type="text/javascript">

/*$(document).ready(function() {
		$(".Eliminar_factura").click(function(event) {
			id_factura=$(this).attr('data-id');
			bootbox.dialog({
            message: "¿Estas seguro de eliminar la factura",
            title: "Eliminar Factura",
            buttons: {
                main: {
                    label: "Eliminar",
                    className: "btn-primary",
                    callback: function() {
                        window.location.href = "facturas.php"
                    }
                },
                danger: {
                    label: "Cancelar",
                    className: "btn-danger",
                    callback: function() {
                        bootbox.hideAll();
                    }
                }
            }
        });
		});
	});
*/



	function bboleto(nboleto){
		//alert(nboleto);
		$.ajax({
			type:"POST",
			url:"ajax/liberar.php",
			data:"id="+nboleto,
			success:function(valor){
				//alert(valor);
				if (valor==1){
					alert("Asiento Liberado :)");
					location.reload();
				}else{
					alert("Algo ocurrio mal :(");
				}

			}
		})

	}

	function ocupar(id){
		// alert(id);
		$("#idfact").val(id);
	}
	function asignar(){
		var idfact  =document.getElementById("idfact").value;
		var bus     =document.getElementById("idbuss").value;
		var fecha   =document.getElementById("fechaviaje").value;
		var asiento =document.getElementById("asientov").value;
		var piso    =document.getElementById("pisov").value;
		// alert(bus);
		if (idfact==''){
			alert("Algo ocurrio mal :(");
			return;
		}
		if (bus==''){
			alert("Debe asignar una placa de Bus");
			return;
		}
		if (fecha==''){
			alert("Debe asignar una fecha de viaje");
			return;
		}
		if (asiento==''){
			alert("Debe de asignar un asiento en el bus");
			return;
		}
		$.ajax({
			type:"POST",
			url:"ajax/asig_asiento.php",
			data:"idfact="+idfact+"&bus="+bus+"&fecha="+fecha+"&asiento="+asiento+"&piso="+piso,
			success:function(data){
               //alert(data);
               if (data==1){
               	alert("El asiento ya esta Ocupado, Vuelva  a intentar en otro asiento :(");
               	return;
               }
               if (data==11){
               	alert("Se le Asigno un asiento al Pasajero :)");
               	location.reload();

               }
			}

		})
	}
</script>