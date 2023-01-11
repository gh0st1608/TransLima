<?php

	 
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from facturas where id_proveedor='".$id_proveedor."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM proveedores WHERE id_proveedor='".$id_proveedor."'")){
			?>Datos eliminados exitosamente.<?php 
		}else {
			?>Lo siento algo ha salido mal intenta nuevamente.<?php
			
		}
			
		} else {
			?>No se pudo eliminar éste  cliente. Existen facturas vinculadas a éste producto.<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre_proveedor');//Columnas de busqueda
		 $sTable = "proveedores";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by nombre_proveedor";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './proveedores.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Nombre</th>
					<th>Teléfono</th>
					<th>Email</th>
					<th>Dirección</th>
					<th>Estado</th>
					<th>Agregado</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_proveedor=$row['id_proveedor'];
						$nombre_proveedor=$row['nombre_proveedor'];
						$telefono_proveedor=$row['telefono'];
						$email_proveedor=$row['correo'];
						$direccion_proveedor=$row['direccion'];
						$status_proveedor=$row['estado'];
						if ($status_proveedor==1){$estado="Activo";}
						else {$estado="Inactivo";}
						$date_added= date('d/m/Y', strtotime($row['fecha_creado']));
						$offset++;
						
					?>



					
					<input type="hidden" value="<?php echo $nombre_proveedor;?>" id="nombre_proveedor<?php echo $id_proveedor;?>">
					<input type="hidden" value="<?php echo $telefono_proveedor;?>" id="telefono_proveedor<?php echo $id_proveedor;?>">
					<input type="hidden" value="<?php echo $email_proveedor;?>" id="email_proveedor<?php echo $id_proveedor;?>">
					<input type="hidden" value="<?php echo $direccion_proveedor;?>" id="direccion_proveedor<?php echo $id_proveedor;?>">
					<input type="hidden" value="<?php echo $status_proveedor;?>" id="status_proveedor<?php echo $id_proveedor;?>">
					
					<tr>
						<td><?php echo $offset; ?></td>
						<td><?php echo $nombre_proveedor; ?></td>
						<td ><?php echo $telefono_proveedor; ?></td>
						<td><?php echo $email_proveedor;?></td>
						<td><?php echo $direccion_proveedor;?></td>
						<td><?php echo $status_proveedor;?></td>
						<td><?php echo $date_added;?></td>
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar proveedor' onclick="obtener_datos('<?php echo $id_proveedor;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_proveedor; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>