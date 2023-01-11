<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_bus=intval($_GET['id']);
		$query=mysqli_query($con, "select * from tb_facturacion_det where id_producto='".$id_bus."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			$deletedet=mysqli_query($con,"DELETE FROM tb_buses_det WHERE id_bus='".$id_bus."'");
			if ($delete1=mysqli_query($con,"DELETE FROM tb_buses WHERE id_bus='".$id_bus."'") && $deletedet){
			?>Datos eliminados exitosamente.<?php 
		}else {
			?>Lo siento algo ha salido mal intenta nuevamente.<?php
			
		}
			
		} else {
			?>No se pudo eliminar éste  producto. Existen cotizaciones vinculadas a éste producto.<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre_bus', 'placa');//Columnas de busqueda
		 $sTable = "tb_buses";
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
		$sWhere.=" order by id_bus desc";
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
		$reload = './buses.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			// $simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Bus</th>
					<th>Placa</th>
					<th>Asientos Piso 1</th>
					<th>Asientos Piso 2</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_bus=$row['id_bus'];
						$nombre_bus=$row['nombre_bus'];
						$filas1= (!empty($row['filaspiso1'])) ? $row['filaspiso1'] : 0;
						$filas2= (!empty($row['filaspiso2'])) ? $row['filaspiso2'] : 0;
						//$asientos1 = ($filas1==0 || $filas1 < 0) ? 0 : ($filas1*4)+1;
						//$asientos2 = ($filas2==0 || $filas2 < 0) ? 0 : ($filas2*4)+1;
						//print_r($asientos1."---".$asientos2);die();

						//$pisos=$row['pisos'];
						//$idbus = $row['id_bus']; 
						$caracteristicas=$row['caracteristicas'];
						$placa=$row['placa'];
						$date_added= date('d/m/Y', strtotime($row['fecha_creado']));
						$offset++;
					?>
					
					<input type="hidden" value="<?php echo $id_bus;?>" id="codigobus<?php echo $id_bus;?>">
					<input type="hidden" value="<?php echo $nombre_bus;?>" id="nombre<?php echo $id_bus;?>">
					<input type="hidden" value="<?php echo $filas1;?>" id="filas1<?php echo $id_bus;?>">
					<input type="hidden" value="<?php echo $filas2;?>" id="filas2<?php echo $id_bus;?>">
					<!--input type="hidden" value="<?php echo $asientos1;?>" id="asientos1<?php echo $id_bus;?>">
					<input type="hidden" value="<?php echo $asientos2;?>" id="asientos2<?php echo $id_bus;?>"-->
					<!--input type="hidden" value="<?php echo $pisos;?>" id="piso<?php echo $id_bus;?>"-->
					<input type="hidden" value="<?php echo $caracteristicas;?>" id="caracteristica<?php echo $id_bus;?>">
					<input type="hidden" value="<?php echo $placa;?>" id="placa<?php echo $id_bus;?>">
					<!--input type="hidden" value="<?php echo $date_added;?>" id="date<?php echo $id_bus;?>"-->
					
					<tr>
						<td><?php echo $offset;?></td>
						<td ><?php echo $nombre_bus;?></td>						
						<!--td><?php echo $pisos;?></td-->
						<td><?php echo $placa; ?></td>
						<td><?php echo $filas1; ?></td>
						<td><?php echo $filas2; ?></td>
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar producto' onclick="obtener_datos('<?php echo $id_bus;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<!--a href="#" class='btn btn-default' title='reset' onclick="resetbus('<?php echo $id_bus;?>');"> <i class="glyphicon glyphicon-level-up"></i> </a--></span></td>
						
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