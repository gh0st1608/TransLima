
<?php 
	
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");

	$idbus = $_POST['idbus'];
	$fecha = date("Y/m/d", strtotime($_POST['fecha']));
	$sqlest="SELECT * FROM tb_control_asientos conasi left join tb_buses_det busdet on conasi.id_bus_det = busdet.id_buses_det where conasi.estado_general = 1 and conasi.fecha = '".$fecha."' and conasi.id_bus = '".$idbus."'";
	$queryest = mysqli_query($con, $sqlest);
	$arrays = array();
	while ($row=mysqli_fetch_array($queryest)){
		$arrays[] = $row;
	}	


	    $query_cab   = mysqli_query($con, "SELECT COUNT(c.nombre_sucursal) as cantidad , c.nombre_sucursal FROM tb_facturacion_cab a
		left join tb_facturacion_det b on a.id_facturacion = b.id_facturacion
		left join tb_sucursales c on a.id_sucursal = c.id_sucursal
		left join tb_cliente d on a.id_cliente = d.id_cliente
		where  a.fecha_envio = '$fecha 00:00:00' and a.id_bus = $idbus and a.id_tipo != 2 GROUP BY c.nombre_sucursal");

	    $sucus = "";
		while ($rows_cab=mysqli_fetch_array($query_cab)){
		    $sucus .= $rows_cab['nombre_sucursal'].": ". $rows_cab['cantidad']."  &nbsp;&nbsp;"; 
		}

if ($idbus == 19 || $idbus == 18) {


	
 ?>
<?php }else if ($idbus == 55 || $idbus == 23 || $idbus ==24 || $idbus ==29 || $idbus ==33 || $idbus ==34 || $idbus ==35 || $idbus ==36 || $idbus ==37 || $idbus ==38 || $idbus ==42 || $idbus ==43 || $idbus ==47 || $idbus ==48 || $idbus ==51 || $idbus ==52 || $idbus ==53) { ?>
<div role="tabpanel" class="tab-pane active" id="home">
	                       
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
	        <ul class="listIcon">
	            <li>Asiento<br> Disponible</li>
	            <li>
	                 <div class="imgsbus img-asientod"></div>
	            </li>
	        </ul>
	    </div>
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
			<ul class="listIcon">
				<li>Asiento<br> Ocupado</li>
				<li>
					<div class="imgsbus img-asientos"></div>
				</li>
			</ul>
	    </div>
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
	        <ul class="listIcon">
	            <li>Asiento <br> Reservado</li>
	            <li>
	                <div class="imgsbus img-asienton"></div>
	            </li>
	        </ul>
	    </div>
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
	        <ul class="listIcon">
	            <li>Asiento <br>Separado</li>
	            <li>
	                <div class="imgsbus img-asientom"></div>
	            </li>
	        </ul>
	    </div>
	    <div class="col-md-4 col-sm-3 col-xs-3 form-group centrado leyenda-desktop" style="margin-top: -19px; padding-left: 48px;">
	       <table class="tblVerde" id="table_det" style="width: 300px">
                <tbody>
                	<tr class="title-fileds" style="background:#e1e1e1;">
                        <th>Piso</th>
                        <th>Asiento</th>
                        <th id="cab_preciop">Precio</th>
                    </tr>
                    <tr class="det_lista">
                        <td id="piso_cab">Piso <span></span></td>
                        <td id="asiento">Asiento #<span></span></td>
                        <td id="precio"><input type="number" style="    width: 50px;" id="cant_precio" name="precio"> Soles</td>
                    </tr>
                </tbody>
            </table>
	    </div>
	       <div class="cl"></div>
	  <table style="width: 100%; text-align: center;">
	  	<tr style="text-align: center;">
	  		<td style="text-align: center;"><b><?php echo  $sucus; ?><b></td>
	  	</tr>
	  </table>

	<div class="col-md-12 centrado plano-mobile">
	 <span id="ctl00_ContPWeb_lbltitlecroquisida"></span>
	<div id="ctl00_ContPWeb_croquisida" class="croquis">
	 <div id="ctl00_ContPWeb_DivPlanoBusIda" class="contenido-plano"><link rel="stylesheet" type="text/css" href=""> 
	<!-- Aqui empieza-->
		<div class="plano-ida">
	 <div class="frontis-a"><img src="" width="100%"></div>
		<div class="contenedor-niveles">

			<div class="primer-nivel">
				<ul><li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
				</ul>
				<ul>
					<li><div class="icon-escalera"></div></li>
					<!-- <li><div class="blockfree"></div></li> -->
					<li><button type="button" id="btn011" piso="1" numero="01" name="btn01" class="asiento <?php echo traerdatos("1","1",$arrays); ?>">01</button></li>
					<li><button type="button" id="btn021" piso="1" numero="02" name="btn02" class="asiento <?php echo traerdatos("2","1",$arrays); ?>">02</button></li>
					<li><button type="button" id="btn031" piso="1" numero="03" name="btn03" class="asiento <?php echo traerdatos("3","1",$arrays); ?>">03</button></li>
					<!-- <li><div class="blockfree"></div></li> -->
					<li><div class="icon-escalera"></div></li>
				</ul>
			</div>

		</div>
			<div class="frontis-b"></div>
		</div>

	</div>
	</div>
	   <div class="cl"></div>
	</div>
	     <div class="cl"></div>
	</div>
	<!-- *-------------------FIN--------------------* -->
<!-- AUTO INICIO -->
<?php }else if ($idbus == 999) { ?>
	<!-- FIN -->
<?php }else if ($idbus == 369) { ?>
<?php }else if ($idbus == 379) { ?>
<?php }else if ($idbus == 389) { ?>
<?php }else if ($idbus == 429) { ?>
<?php }else if ($idbus == 439) { ?>
<?php }else if ($idbus == 479) { ?>
<?php }else if ($idbus == 489) { ?>
<?php }else if ($idbus == 519) { ?>
<?php }else if ($idbus == 529) { ?>
<?php }else if ($idbus == 539) { ?>
<?php }else if ($idbus == 349) { ?>
<?php }else if ($idbus == 339) { ?>
<?php }else if ($idbus == 239) { ?>
<?php }else if ($idbus == 249) { ?>
<?php }else if ($idbus == 299) { ?>
<!-- AUTO FIN -->
<!-- CAMIONETA INICIO -->
<?php }else if ($idbus == 46 || $idbus == 25 || $idbus ==26 || $idbus ==27 || $idbus ==28 || $idbus ==30 || $idbus ==31 || $idbus ==32 || $idbus ==39 || $idbus ==40 || $idbus ==41 || $idbus ==44 || $idbus ==45 || $idbus ==46 || $idbus ==49 || $idbus ==50 || $idbus ==54) { ?>
<div role="tabpanel" class="tab-pane active" id="home">
	                       
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
	        <ul class="listIcon">
	            <li>Asiento<br> Disponible</li>
	            <li>
	                 <div class="imgsbus img-asientod"></div>
	            </li>
	        </ul>
	    </div>
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
			<ul class="listIcon">
				<li>Asiento<br> Ocupado</li>
				<li>
					<div class="imgsbus img-asientos"></div>
				</li>
			</ul>
	    </div>
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
	        <ul class="listIcon">
	            <li>Asiento <br> Reservado</li>
	            <li>
	                <div class="imgsbus img-asienton"></div>
	            </li>
	        </ul>
	    </div>
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
	        <ul class="listIcon">
	            <li>Asiento <br>Separado</li>
	            <li>
	                <div class="imgsbus img-asientom"></div>
	            </li>
	        </ul>
	    </div>
	    <div class="col-md-4 col-sm-3 col-xs-3 form-group centrado leyenda-desktop" style="margin-top: -19px; padding-left: 48px;">
	       <table class="tblVerde" id="table_det" style="width: 300px">
                <tbody>
                	<tr class="title-fileds" style="background:#e1e1e1;">
                        <th>Piso</th>
                        <th>Asiento</th>
                        <th id="cab_preciop">Precio</th>
                    </tr>
                    <tr class="det_lista">
                        <td id="piso_cab">Piso <span></span></td>
                        <td id="asiento">Asiento #<span></span></td>
                        <td id="precio"><input type="number" style="    width: 50px;" id="cant_precio" name="precio"> Soles</td>
                    </tr>
                </tbody>
            </table>
	    </div>
	       <div class="cl"></div>
	  <table style="width: 100%; text-align: center;">
	  	<tr style="text-align: center;">
	  		<td style="text-align: center;"><b><?php echo  $sucus; ?><b></td>
	  	</tr>
	  </table>

	<div class="col-md-12 centrado plano-mobile">
	 <span id="ctl00_ContPWeb_lbltitlecroquisida"></span>
	<div id="ctl00_ContPWeb_croquisida" class="croquis">
	 <div id="ctl00_ContPWeb_DivPlanoBusIda" class="contenido-plano"><link rel="stylesheet" type="text/css" href=""> 
	<!-- Aqui empieza-->
		<div class="plano-ida">
	 <div class="frontis-a"><img src="" width="100%"></div>
		<div class="contenedor-niveles">

			<div class="primer-nivel">
				<ul><li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
				</ul>
				<ul>
<!-- 					<li><div class="icon-escalera"></div></li> -->
					<!-- <li><div class="blockfree"></div></li> -->
					<li><button type="button" id="btn011" piso="1" numero="01" name="btn01" class="asiento <?php echo traerdatos("1","1",$arrays); ?>">01</button></li>
					<li><button type="button" id="btn021" piso="1" numero="02" name="btn02" class="asiento <?php echo traerdatos("2","1",$arrays); ?>">02</button></li>
					<li><button type="button" id="btn031" piso="1" numero="03" name="btn03" class="asiento <?php echo traerdatos("3","1",$arrays); ?>">03</button></li>
					<!-- <li><div class="blockfree"></div></li> -->
					<li><div class="icon-escalera"></div></li>
				</ul>
				<ul>
<!-- 					<li><div class="icon-escalera"></div></li> -->
					<!-- <li><div class="blockfree"></div></li> -->
					<li><button type="button" id="btn011" piso="1" numero="04" name="btn01" class="asiento <?php echo traerdatos("4","1",$arrays); ?>">04</button></li>
					<li><button type="button" id="btn021" piso="1" numero="05" name="btn02" class="asiento <?php echo traerdatos("5","1",$arrays); ?>">05</button></li>
					<li><button type="button" id="btn031" piso="1" numero="06" name="btn03" class="asiento <?php echo traerdatos("6","1",$arrays); ?>">06</button></li>
					<!-- <li><div class="blockfree"></div></li> -->
					<li><div class="icon-escalera"></div></li>
				</ul>
			</div>

		</div>
			<div class="frontis-b"></div>
		</div>

	</div>
	</div>
	   <div class="cl"></div>
	</div>
	     <div class="cl"></div>
	</div>

<?php }else if ($idbus == 269) { ?>
<?php }else if ($idbus == 259) { ?>
<?php }else if ($idbus == 499) { ?>
<?php }else if ($idbus == 279) { ?><!-- CAMIONETA FIN -->
<?php }else if ($idbus == 219){ ?>
	<!-- *-------------------FIN--------------------* -->
<?php }else if ($idbus == 22 || $idbus == 21){ ?>
<div role="tabpanel" class="tab-pane active" id="home">
	                       
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
	        <ul class="listIcon">
	            <li>Asiento<br> Disponible</li>
	            <li>
	                 <div class="imgsbus img-asientod"></div>
	            </li>
	        </ul>
	    </div>
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
			<ul class="listIcon">
				<li>Asiento<br> Ocupado</li>
				<li>
					<div class="imgsbus img-asientos"></div>
				</li>
			</ul>
	    </div>
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
	        <ul class="listIcon">
	            <li>Asiento <br> Reservado</li>
	            <li>
	                <div class="imgsbus img-asienton"></div>
	            </li>
	        </ul>
	    </div>
	    <div class="col-md-2 col-sm-3 col-xs-3 form-group centrado leyenda-desktop">
	        <ul class="listIcon">
	            <li>Asiento <br>Separado</li>
	            <li>
	                <div class="imgsbus img-asientom"></div>
	            </li>
	        </ul>
	    </div>
	    <div class="col-md-4 col-sm-3 col-xs-3 form-group centrado leyenda-desktop" style="margin-top: -19px; padding-left: 48px;">
	       <table class="tblVerde" id="table_det" style="width: 300px">
                <tbody>
                	<tr class="title-fileds" style="background:#e1e1e1;">
                        <th>Piso</th>
                        <th>Asiento</th>
                        <th id="cab_preciop">Precio</th>
                    </tr>
                    <tr class="det_lista">
                        <td id="piso_cab">Piso <span></span></td>
                        <td id="asiento">Asiento #<span></span></td>
                        <td id="precio"><input type="number" style="    width: 50px;" id="cant_precio" name="precio"> Soles</td>
                    </tr>
                </tbody>
            </table>
	    </div>
	       <div class="cl"></div>
	  <table style="width: 100%; text-align: center;">
	  	<tr style="text-align: center;">
	  		<td style="text-align: center;"><b><?php echo  $sucus; ?><b></td>
	  	</tr>
	  </table>

	<div class="col-md-12 centrado plano-mobile">
	 <span id="ctl00_ContPWeb_lbltitlecroquisida"></span>
	<div id="ctl00_ContPWeb_croquisida" class="croquis">
	 <div id="ctl00_ContPWeb_DivPlanoBusIda" class="contenido-plano"><link rel="stylesheet" type="text/css" href=""> 
	<!-- Aqui empieza-->
		<div class="plano-ida">
	 <div class="frontis-a"><img src="" width="100%"></div>
		<div class="contenedor-niveles">

			<div class="primer-nivel">
				<ul><li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
				</ul>
				<ul>
					<li><button type="button" id="btn011" piso="1" numero="01" name="btn01" class="asiento <?php echo traerdatos("1","1",$arrays); ?>">01</button></li>
					<li><button type="button" id="btn021" piso="1" numero="02" name="btn02" class="asiento <?php echo traerdatos("2","1",$arrays); ?>">02</button></li>
					<li><button type="button" id="btn031" piso="1" numero="03" name="btn03" class="asiento <?php echo traerdatos("3","1",$arrays); ?>">03</button></li>
					<li><div class="blockfree"></div></li>
					<li><div class="icon-escalera"></div></li>
				</ul>
				<ul>
					<li><button type="button" id="btn051" piso="1" numero="05" name="btn05" class="asiento <?php echo traerdatos("5","1",$arrays); ?>">05</button></li>
					<li><button type="button" id="btn041" piso="1" numero="04" name="btn04" class="asiento <?php echo traerdatos("4","1",$arrays); ?>">04</button></li>
					<li><button type="button" id="btn061" piso="1" numero="06" name="btn06" class="asiento <?php echo traerdatos("6","1",$arrays); ?>">06</button></li>
			        <li><div class="blockfree"></div></li>
					<li><div class="icon-escalera"></div></li>

				</ul>
				<ul>
					<li><button type="button" id="btn071" piso="1" numero="07" name="btn07" class="asiento <?php echo traerdatos("7","1",$arrays); ?>">07</button></li>
					<li><button type="button" id="btn081" piso="1" numero="08" name="btn08" class="asiento <?php echo traerdatos("8","1",$arrays); ?>">08</button></li>
					<li><button type="button" id="btn091" piso="1" numero="09" name="btn09" class="asiento <?php echo traerdatos("9","1",$arrays); ?>">09</button></li>
			 		<li><div class="blockfree"></div></li>
					<li><div class="icon-escalera"></div></li>
				</ul>
				<ul>
					<li><button type="button" id="btn111" piso="1" numero="11" name="btn11" class="asiento <?php echo traerdatos("11","1",$arrays); ?>">11</button></li>
					<li><button type="button" id="btn101" piso="1" numero="10" name="btn10" class="asiento <?php echo traerdatos("10","1",$arrays); ?>">10</button></li>
					<li><button type="button" id="btn121" piso="1" numero="12" name="btn12" class="asiento <?php echo traerdatos("12","1",$arrays); ?>">12</button></li>
					<li><button type="button" id="btn121" piso="1" numero="13" name="btn13" class="asiento <?php echo traerdatos("13","1",$arrays); ?>">13</button></li>
				</ul>
			</div>

		</div>
			<div class="frontis-b"></div>
		</div>

	</div>
	</div>
	   <div class="cl"></div>
	</div>
	     <div class="cl"></div>
	</div>
<!-- ****************** -->
<?php }else if ($idbus == 17){ ?>
<!-- ****************** -->
<?php }else if ($idbus == 20){ ?>
<?php }else{ echo "No se encontraron datos"; } 



		function traerdato($id, $array){
			$i = 0;
			$color = "asiento-disponible";
			foreach ($array as $key => $value) {
				if ($value['asiento'] == $id) {
					if ($value['estado'] ==  2) {
						$color = "asiento-seleccionado";
						break;	
					}else if($value['estado'] == 3){
						$color = "asiento-ocupado";
						break;
					}else if($value['estado'] == 4){
						$color = "asiento-separado";
						break;
					}else{
						$color = "asiento-disponible";
					}
				}
			}
			return $color;
		}

		function traerdatos($id, $piso, $array){
			$i = 0;
			$color = "asiento-disponible";
			foreach ($array as $key => $value) {
				if ($value['asiento'] == $id && $value['piso'] == $piso) {
					if ($value['estado'] ==  2) {
						$color = "asiento-seleccionado";
						break;	
					}else if($value['estado'] == 3){
						$color = "asiento-ocupado";
						break;
					}else if($value['estado'] == 4){
						$color = "asiento-separado";
						break;
					}else{
						$color = "asiento-disponible";
					}
				}
			}
			return $color;
		}


		?>



