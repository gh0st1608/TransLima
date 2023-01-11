
<?php 
	
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

	$idbus = $_POST['idbus'];
	$fecha = date("Y/m/d", strtotime($_POST['fecha']));
	//print_r($fecha);
	/*$sqldet="SELECT * FROM  tb_buses_det where id_bus = '".$idbus."'";
	$querydet = mysqli_query($con, $sqldet);*/

	$sqlest="SELECT * FROM tb_control_asientos conasi left join tb_buses_det busdet on conasi.id_bus_det = busdet.id_buses_det where conasi.estado_general = 1 and conasi.fecha = '".$fecha."' and conasi.id_bus = '".$idbus."'";
	$queryest = mysqli_query($con, $sqlest);
	$arrays = array();
	while ($row=mysqli_fetch_array($queryest)){
		$arrays[] = $row;
	}	


	// echo "<pre>";print_r($arrays);echo "</pre>";die();

	    $query_cab   = mysqli_query($con, "SELECT COUNT(c.nombre_sucursal) as cantidad , c.nombre_sucursal FROM tb_facturacion_cab a
		left join tb_facturacion_det b on a.id_facturacion = b.id_facturacion
		left join tb_sucursales c on a.id_sucursal = c.id_sucursal
		left join tb_cliente d on a.id_cliente = d.id_cliente
		where  a.fecha_envio = '$fecha 00:00:00' and a.id_bus = $idbus and a.id_tipo != 2 GROUP BY c.nombre_sucursal");

	    $sucus = "";
		while ($rows_cab=mysqli_fetch_array($query_cab)){
		    $sucus .= $rows_cab['nombre_sucursal'].": ". $rows_cab['cantidad']."  &nbsp;&nbsp;"; 
		}

	if ($idbus == 19 || $idbus == 18) {?>
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

			<div class="segundo-nivel">
				<ul></ul>
				<ul>
					<li><button onclick="reserasiento('1','1')" type="button" id="btn011" piso="1" numero = "01" name="btn01" class="asiento <?php echo traerdato("1",$arrays); ?>">01</button></li>
					<li><button onclick="reserasiento('2','1')" type="button" id="btn021" piso="1" numero = "02" name="btn02" class="asiento <?php echo traerdato("2",$arrays); ?>">02</button></li>
					<li><div class="icon-tv"></div></li>
					<li><button onclick="reserasiento('4','1')" type="button" id="btn041" piso="1" numero = "04" name="btn04" class="asiento <?php echo traerdato("4",$arrays); ?>">04</button></li>
					<li><button onclick="reserasiento('3','1')" type="button" id="btn031" piso="1" numero = "03" name="btn03" class="asiento <?php echo traerdato("3",$arrays); ?>">03</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('5','1')" type="button" id="btn051" piso="1" numero = "05" name="btn05" class="asiento <?php echo traerdato("5",$arrays); ?>">05</button></li>
					<li><button onclick="reserasiento('6','1')" type="button" id="btn061" piso="1" numero = "06" name="btn06" class="asiento <?php echo traerdato("6",$arrays); ?>">06</button></li>
					<li><div class="blockfree"></div></li>
					<li><button onclick="reserasiento('8','1')" type="button" id="btn081" piso="1" numero = "08" name="btn08" class="asiento <?php echo traerdato("8",$arrays); ?>">08</button></li>
					<li><button onclick="reserasiento('7','1')" type="button" id="btn071" piso="1" numero = "07" name="btn07" class="asiento <?php echo traerdato("7",$arrays); ?>">07</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('9','1')" type="button" id="btn091" piso="1" numero = "09" name="btn09" class="asiento <?php echo traerdato("9",$arrays); ?>">09</button></li>
					<li><button onclick="reserasiento('10','1')" type="button" id="btn101" piso="1" numero = "10" name="btn10" class="asiento <?php echo traerdato("10",$arrays); ?>">10</button></li>
					<li><div class="blockfree"></div></li>
					<li><button onclick="reserasiento('12','1')" type="button" id="btn121" piso="1" numero = "12" name="btn12" class="asiento <?php echo traerdato("12",$arrays); ?>">12</button></li>
					<li><button onclick="reserasiento('11','1')" type="button" id="btn111" piso="1" numero = "11" name="btn11" class="asiento <?php echo traerdato("11",$arrays); ?>">11</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('13','1')" type="button" id="btn131" piso="1" numero = "13" name="btn13" class="asiento <?php echo traerdato("13",$arrays); ?>">13</button></li>
					<li><button onclick="reserasiento('14','1')" type="button" id="btn141" piso="1" numero = "14" name="btn14" class="asiento <?php echo traerdato("14",$arrays); ?>">14</button></li>
					<li><div class="icon-tv"></div></li>
					<li><button onclick="reserasiento('16','1')" type="button" id="btn161" piso="1" numero = "16" name="btn16" class="asiento <?php echo traerdato("16",$arrays); ?>">16</button></li>
					<li><button onclick="reserasiento('15','1')" type="button" id="btn151" piso="1" numero = "15" name="btn15" class="asiento <?php echo traerdato("15",$arrays); ?>">15</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('17','1')" type="button" id="btn171" piso="1" numero = "17" name="btn17" class="asiento <?php echo traerdato("17",$arrays); ?>">17</button></li>
					<li><button onclick="reserasiento('18','1')" type="button" id="btn181" piso="1" numero = "18" name="btn18" class="asiento <?php echo traerdato("18",$arrays); ?>">18</button></li>
					<li><div class="blockfree"></div></li>
					<li><button onclick="reserasiento('20','1')" type="button" id="btn201" piso="1" numero = "20" name="btn20" class="asiento <?php echo traerdato("20",$arrays); ?>">20</button></li>
					<li><button onclick="reserasiento('19','1')" type="button" id="btn191" piso="1" numero = "19" name="btn19" class="asiento <?php echo traerdato("19",$arrays); ?>">19</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('21','1')" type="button" id="btn211" piso="1" numero = "21" name="btn21" class="asiento <?php echo traerdato("21",$arrays); ?>">21</button></li>
					<li><button onclick="reserasiento('22','1')" type="button" id="btn221" piso="1" numero = "22" name="btn22" class="asiento <?php echo traerdato("22",$arrays); ?>">22</button></li>
					<li><div class="blockfree"></div></li>
					<li><button onclick="reserasiento('24','1')" type="button" id="btn241" piso="1" numero = "24" name="btn24" class="asiento <?php echo traerdato("24",$arrays); ?>">24</button></li>
					<li><button onclick="reserasiento('23','1')" type="button" id="btn231" piso="1" numero = "23" name="btn23" class="asiento <?php echo traerdato("23",$arrays); ?>">23</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('25','1')" type="button" id="btn251" piso="1" numero = "25" name="btn25" class="asiento <?php echo traerdato("25",$arrays); ?>">25</button></li>
					<li><button onclick="reserasiento('26','1')" type="button" id="btn261" piso="1" numero = "26" name="btn26" class="asiento <?php echo traerdato("26",$arrays); ?>">26</button></li>
					<li><div class="icon-tv"></div></li>
					<li><button onclick="reserasiento('28','1')" type="button" id="btn281" piso="1" numero = "28" name="btn28" class="asiento <?php echo traerdato("28",$arrays); ?>">28</button></li>
					<li><button onclick="reserasiento('27','1')" type="button" id="btn271" piso="1" numero = "27" name="btn27" class="asiento <?php echo traerdato("27",$arrays); ?>">27</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('29','1')" type="button" id="btn291" piso="1" numero = "29" name="btn29" class="asiento <?php echo traerdato("29",$arrays); ?>">29</button></li>
					<li><button onclick="reserasiento('30','1')" type="button" id="btn301" piso="1" numero = "30" name="btn30" class="asiento <?php echo traerdato("30",$arrays); ?>">30</button></li>
					<li><div class="blockfree"></div></li>
					<li><button onclick="reserasiento('32','1')" type="button" id="btn321" piso="1" numero = "32" name="btn32" class="asiento <?php echo traerdato("32",$arrays); ?>">32</button></li>
					<li><button onclick="reserasiento('31','1')" type="button" id="btn311" piso="1" numero = "31" name="btn31" class="asiento <?php echo traerdato("31",$arrays); ?>">31</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('33','1')" type="button" id="btn331" piso="1" numero = "33" name="btn33" class="asiento <?php echo traerdato("33",$arrays); ?>">33</button></li>
					<li><button onclick="reserasiento('34','1')" type="button" id="btn341" piso="1" numero = "34" name="btn34" class="asiento <?php echo traerdato("34",$arrays); ?>">34</button></li>
					<li><div class="blockfree"></div></li>
					<li><button onclick="reserasiento('36','1')" type="button" id="btn361" piso="1" numero = "36" name="btn36" class="asiento <?php echo traerdato("36",$arrays); ?>">36</button></li>
					<li><button onclick="reserasiento('35','1')" type="button" id="btn351" piso="1" numero = "35" name="btn35" class="asiento <?php echo traerdato("35",$arrays); ?>">35</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('37','1')" type="button" id="btn371" piso="1" numero = "37" name="btn37" class="asiento <?php echo traerdato("37",$arrays); ?>">37</button></li>
					<li><button onclick="reserasiento('38','1')" type="button" id="btn381" piso="1" numero = "38" name="btn38" class="asiento <?php echo traerdato("38",$arrays); ?>">38</button></li>
					<li><div class="blockfree"></div></li>
					<li><button onclick="reserasiento('40','1')" type="button" id="btn401" piso="1" numero = "40" name="btn40" class="asiento <?php echo traerdato("40",$arrays); ?>">40</button></li>
					<li><button onclick="reserasiento('39','1')" type="button" id="btn391" piso="1" numero = "39" name="btn39" class="asiento <?php echo traerdato("39",$arrays); ?>">39</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('41','1')" type="button" id="btn411" piso="1" numero = "41" name="btn41" class="asiento <?php echo traerdato("41",$arrays); ?>">41</button></li>
					<li><button onclick="reserasiento('42','1')" type="button" id="btn421" piso="1" numero = "42" name="btn42" class="asiento <?php echo traerdato("42",$arrays); ?>">42</button></li>
					<li><div class="blockfree"></div></li>
					<li><button onclick="reserasiento('44','1')" type="button" id="btn441" piso="1" numero = "44" name="btn44" class="asiento <?php echo traerdato("44",$arrays); ?>">44</button></li>
					<li><button onclick="reserasiento('43','1')" type="button" id="btn431" piso="1" numero = "43" name="btn43" class="asiento <?php echo traerdato("43",$arrays); ?>">43</button></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('45','1')" type="button" id="btn451" piso="1" numero = "45" name="btn45" class="asiento <?php echo traerdato("45",$arrays); ?>">45</button></li>
					<li><button onclick="reserasiento('46','1')" type="button" id="btn461" piso="1" numero = "46" name="btn46" class="asiento <?php echo traerdato("46",$arrays); ?>">46</button></li>
					<li><div class="blockfree"></div></li>
					<li><button onclick="reserasiento('48','1')" type="button" id="btn481" piso="1" numero = "48" name="btn48" class="asiento <?php echo traerdato("48",$arrays); ?>">48</button></li>
					<li><button onclick="reserasiento('47','1')" type="button" id="btn471" piso="1" numero = "47" name="btn47" class="asiento <?php echo traerdato("47",$arrays); ?>">47</button></li>
				</ul>
				<ul>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><div class="blockfree"></div></li>
					<li><button type="button" id="btn491" piso="1" numero = "49" name="btn49" class="asiento <?php echo traerdato("49",$arrays); ?>">49</button></li>
					<li><button type="button" id="btn501" piso="1" numero = "50" name="btn50" class="asiento <?php echo traerdato("50",$arrays); ?>">50</button></li>
					
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
<?php }else if ($idbus == 169){?>
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
					<li><button onclick="reserasiento('1','1')"  type="button" id="btn011" piso="1" numero="01" name="btn01" class="asiento <?php echo traerdatos("1","1",$arrays); ?>">01</button></li>
					<li><button onclick="reserasiento('2','1')"  type="button" id="btn021" piso="1" numero="02" name="btn02" class="asiento <?php echo traerdatos("2","1",$arrays); ?>">02</button></li>
					<li><button onclick="reserasiento('3','1')"  type="button" id="btn031" piso="1" numero="03" name="btn03" class="asiento <?php echo traerdatos("3","1",$arrays); ?>">03</button></li>
					<li><div class="blockfree"></div></li>
					<li><div class="icon-escalera"></div></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('5','1')"  type="button" id="btn051" piso="1" numero="05" name="btn05" class="asiento <?php echo traerdatos("5","1",$arrays); ?>">05</button></li>
					<li><button onclick="reserasiento('4','1')"  type="button" id="btn041" piso="1" numero="04" name="btn04" class="asiento <?php echo traerdatos("4","1",$arrays); ?>">04</button></li>
					<li><button onclick="reserasiento('6','1')"  type="button" id="btn061" piso="1" numero="06" name="btn06" class="asiento <?php echo traerdatos("6","1",$arrays); ?>">06</button></li>
			        <li><div class="blockfree"></div></li>
					<li><div class="icon-escalera"></div></li>

				</ul>
				<ul>
					<li><button onclick="reserasiento('7','1')"  type="button" id="btn071" piso="1" numero="07" name="btn07" class="asiento <?php echo traerdatos("7","1",$arrays); ?>">07</button></li>
					<li><button onclick="reserasiento('8','1')"  type="button" id="btn081" piso="1" numero="08" name="btn08" class="asiento <?php echo traerdatos("8","1",$arrays); ?>">08</button></li>
					<li><button onclick="reserasiento('9','1')"  type="button" id="btn091" piso="1" numero="09" name="btn09" class="asiento <?php echo traerdatos("9","1",$arrays); ?>">09</button></li>
			 		<li><div class="blockfree"></div></li>
					<li><div class="icon-escalera"></div></li>
				</ul>
				<ul>
					<li><button onclick="reserasiento('11','1')" type="button" id="btn111" piso="1" numero="11" name="btn11" class="asiento <?php echo traerdatos("11","1",$arrays); ?>">11</button></li>
					<li><button onclick="reserasiento('10','1')" type="button" id="btn101" piso="1" numero="10" name="btn10" class="asiento <?php echo traerdatos("10","1",$arrays); ?>">10</button></li>
					<li><button onclick="reserasiento('12','1')" type="button" id="btn121" piso="1" numero="12" name="btn12" class="asiento <?php echo traerdatos("12","1",$arrays); ?>">12</button></li>
					<li><button onclick="reserasiento('13','1')" type="button" id="btn121" piso="1" numero="13" name="btn13" class="asiento <?php echo traerdatos("13","1",$arrays); ?>">13</button></li>
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
					<li><button onclick="reserasiento('1','1')" type="button" id="btn011" piso="1" numero="01" name="btn01" class="asiento <?php echo traerdatos("1","1",$arrays); ?>">01</button></li>
					<li><button onclick="reserasiento('2','1')" type="button" id="btn021" piso="1" numero="02" name="btn02" class="asiento <?php echo traerdatos("2","1",$arrays); ?>">02</button></li>
					<li><button onclick="reserasiento('3','1')" type="button" id="btn031" piso="1" numero="03" name="btn03" class="asiento <?php echo traerdatos("3","1",$arrays); ?>">03</button></li>
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
					<li><button onclick="reserasiento('1','1')" type="button" id="btn011" piso="1" numero="01" name="btn01" class="asiento <?php echo traerdatos("1","1",$arrays); ?>">01</button></li>
					<li><button onclick="reserasiento('2','1')" type="button" id="btn021" piso="1" numero="02" name="btn02" class="asiento <?php echo traerdatos("2","1",$arrays); ?>">02</button></li>
					<li><button onclick="reserasiento('3','1')" type="button" id="btn031" piso="1" numero="03" name="btn03" class="asiento <?php echo traerdatos("3","1",$arrays); ?>">03</button></li>
					<!-- <li><div class="blockfree"></div></li> -->
					<li><div class="icon-escalera"></div></li>
				</ul>
				<ul>
<!-- 					<li><div class="icon-escalera"></div></li> -->
					<!-- <li><div class="blockfree"></div></li> -->
					<li><button onclick="reserasiento('4','1')" type="button" id="btn011" piso="1" numero="04" name="btn01" class="asiento <?php echo traerdatos("4","1",$arrays); ?>">04</button></li>
					<li><button onclick="reserasiento('5','1')" type="button" id="btn021" piso="1" numero="05" name="btn02" class="asiento <?php echo traerdatos("5","1",$arrays); ?>">05</button></li>
					<li><button onclick="reserasiento('6','1')" type="button" id="btn031" piso="1" numero="06" name="btn03" class="asiento <?php echo traerdatos("6","1",$arrays); ?>">06</button></li>
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
<?php }else if ($idbus == 199){?>
	<!-- *-------------------FIN--------------------* -->
<?php }else if ($idbus == 219){?>
<!-- ****************** -->
<?php }else if ($idbus == 179){?>
<!-- ****************** -->
<?php }else if ($idbus == 209){?>

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
