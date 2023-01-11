<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	
	if($action == 'ajax'){
		$sucursal = $_SESSION['idsucursal'];
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('codigo', 'tb_cliente.nombre_cliente');//Columnas de busqueda
		 $sTable = " tb_reservas_cab, tb_cliente";
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
			$sWhere .= " and tb_reservas_cab.id_cliente = tb_cliente.id_cliente";
		}else { $sWhere = " WHERE tb_reservas_cab.id_cliente = tb_cliente.id_cliente"; } 
		$sWhere.=" and tb_reservas_cab.id_sucursal = ".$sucursal." and tb_reservas_cab.est_eliminar = 0 order by tb_reservas_cab.id_reservas desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$query= "SELECT count(*) AS numrows FROM $sTable  $sWhere";
		//print_r($query);
		$count_query   = mysqli_query($con,$query);

		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './clientes.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		//print_r($sql);
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Codigo</th>
					<th>Cliente</th>
					<th>Fecha</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$offset++;
						$codigo =$row['codigo'];
						$cliente=$row['nombre_cliente'];
						$fecha=date("Y/m/d", strtotime($row['fecha_registro']));;
						$id_reservas=$row['id_reservas'];
					?>
					
				
					<tr>
						<td><?php echo $offset; ?></td>
						<td class="codigo"><?php echo $codigo; ?></td>
						<td><?php echo $cliente; ?></td>
						<td><?php echo $fecha; ?></td>

						
					<td ><span class="pull-right">
					<a href="ver_reserva.php?id_reserva=<?php echo $id_reservas;?>" class='btn btn-default' title='Ver Reserva' id="agregar_bus"><i class="glyphicon glyphicon-eye-open"></i></a> 
					<a href="#" class='btn btn-default agregar_bus' data-toggle="modal" data-target="#modal_reserva_fac" title='Factura' >Factura</a>
					<a href="#" class='btn btn-default agregar_bus' data-toggle="modal" data-target="#modal_reserva_fac" title='Boleta' >Boleta</a>
					<a onclick="eliminarreservas('<?php echo $id_reservas; ?>')" class='btn btn-default' title='EliminarReserva' id="eliminar_reserva"><i class="glyphicon glyphicon-trash"></i></a> 
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

	}else if ($action =='savefacbol'){	
		//print_r($_POST);die();

		$sucursal = $_SESSION['idsucursal'];
		$tipdoc = $_POST['tipodocumento'];
		$cliente = $_POST['id_cliente'];
		$codigo = $_POST['codigo'];
		$uprecio=$_POST['precio'];
		$facturadoa=(isset($_POST['facturado'])?$_POST['facturado']:'');
		//------------------------------------------------------
		$variable = ($tipdoc=='01') ? "serie_factura_viaje" : "serie_boleta_viaje";

		$count_query   = mysqli_query($con, "SELECT $variable, cod_direccion_fiscal FROM tb_sucursales where id_sucursal = '".$sucursal."'");
		$fetchsucursal= mysqli_fetch_array($count_query);

		$qq = "UPDATE tb_reservas_cab SET est_eliminar='1' WHERE codigo= '".$codigo."' "; //print_r($qq);die();
		$insert_tmp=mysqli_query($con, $qq);

		$modprecio = "UPDATE tb_reservas_det SET total='$uprecio', pasajero='$facturadoa' WHERE codigo= '".$codigo."' "; //print_r($qq);die();
		$updateprecio_tmp=mysqli_query($con, $modprecio);
		
		

		$zz = "SELECT * FROM tb_reservas_det, tb_reservas_cab WHERE tb_reservas_det.id_reservas = tb_reservas_cab.id_reservas and tb_reservas_det.codigo = '".$codigo."'"; //print_r($zz);die();
		$count_queryreserva   = mysqli_query($con, $zz);
		//$reserv= mysqli_fetch_array($count_queryreserva);

		//$fecha_envi = 
		$igv = "0.00";
		$usuario = $_SESSION['user_id'];
		$fecha = date("Y/m/d H:i:s", strtotime($_POST['fecha'])); 
		//--------------------------------------------------------

		
		while ($rowse=mysqli_fetch_array($count_queryreserva))
		{
			
			$count_query   = mysqli_query($con, "SELECT count(*) filas FROM tb_facturacion_cab WHERE id_tipo in (3,1) and id_sucursal = '".$_SESSION['idsucursal']."' and id_tipo_documento=".$tipdoc);
			$row= mysqli_fetch_array($count_query);

			$filas = ($row['filas'] == 0) ? 1 : $row['filas']+1;
			$ndocumento = $fetchsucursal[$variable]."-".str_pad($filas, 8, "0", STR_PAD_LEFT);


			$subtotal =$rowse['total'];
			$total =$rowse['total'];
			$preciotexto =$rowse['total'];
			$id_bus = $rowse['id_bus'];
			$idbusdet = $rowse['id_bus_det'];
			$desc = $rowse['descripcion'];
			$id_sucursal_llegada = $rowse['id_sucursal_llegada'];
			$fenvio = date("Y/m/d", strtotime($rowse['fecha_salida']));

			$pasajero = $rowse['pasajero'];
			$totaldet[] = $total;
			$descdet[] = $desc;

			$sql = "INSERT INTO tb_facturacion_cab (id_sucursal, id_tipo_documento, n_documento, id_cliente, valor_total, igv_total, precio_total, id_usuario_creador, fecha_creado , id_usuario_modificador, fecha_modificado, id_moneda, id_bus, precio_texto, fecha_envio, codigo, id_sucursal_llegada, id_tipo, consignatario) VALUES ('$sucursal','$tipdoc','$ndocumento','$cliente', $subtotal, $igv, $total, '$usuario', '$fecha', '0', '$fecha', '1','$id_bus', $preciotexto, '$fenvio','$codigo', $id_sucursal_llegada, 3, '$pasajero')";
			$insert_tmp=mysqli_query($con, $sql);

			$sqlasiento = "UPDATE tb_control_asientos SET estado='2' WHERE fecha = '".$fenvio."' and id_bus= '".$id_bus."' and id_bus_det = '".$idbusdet."' "; //print_r($qq);die();
			//$sqlasiento = "up INSERT INTO tb_control_asientos (id_bus, id_bus_det, estado, estado_general) VALUES ('$id_bus','$idbusdet','2','1')";
			//print_r($sqlasiento);die();
			$insert_sqlasiento = mysqli_query($con, $sqlasiento);


			$P = "|";

			$nombre_archivo= "20601621241-".$tipdoc."-".$ndocumento;
			$ruta_servidor = "C:\SFS_v1.3.4.2\sunat_archivos\sfs\DATA\\";

			$ruta_archivo['info'][1]['ruta'] =$ruta_servidor.$nombre_archivo.".det";
			$ruta_archivo['info'][1]['data'] =
	            "ZZ".$P. //Unidad de medida
	            "1".$P. // Cantidad
	            "cod01".$P. // Codigo Producto 
	            "-".$P. // Codigo Producto Sunat --
	            $desc.$P. // Descripcion
	            $preciotexto.$P. // Valor Unitario (Sin IGV) pero multiplicado por la cantidad
	            "0.00".$P. // Sumatorio Tributo  9+16+26
	            "9997".$P. //Codigo Tipo Triburo Catalogo N° 5
	            "0.00".$P. // Monto Total IGV por item 
	            $preciotexto.$P. // Tributo: Base Imponible IGV por Item
	            "EXO".$P. // Nombre Tributo Catalogo N° 5
	            "VAT".$P. // Codigo Tributo Catalogo N° 5
	            "20".$P. // Catalogo N° 7 
	            "18".$P. // 
	            "-".$P. // Codigo Tipo ISC Catalogo N° 5 (si no es afecto "-") y valores vacios
	            "".$P. // Monto de ISC por ítem
	            "".$P. // Monto de ISC por ítem
	            "".$P. // Nombre de tributo por item Catalogo N° 5
	            "".$P. // Código de tipo de tributo por Item Catalogo N° 5
	            "".$P. // Tipo de sistema ISC Catalogo N° 8
	            "".$P. // Porcentaje de ISC por Item (normalmente 15.00)
	            "-".$P. // Codigo Tipo Otros Catalogo N° 5 (si no es afecto "-") y valores vacios
	            "".$P. // Monto de tributo OTRO por iItem
	            "".$P. // Base Imponible de tributo OTRO por Item
	            "".$P. // Nombre de tributo OTRO por item Catalogo N° 5
	            "".$P. // Código de tipo de tributo OTRO por Item Catalogo N° 5
	            "".$P. // Porcentaje de tributo OTRO por Item (normalmente 15.00)

	            "-".$P. // ICBPER
                "".$P. // ICBPER
                "".$P. // ICBPER
                "".$P. // ICBPER
                "".$P. // ICBPER
                "".$P. // ICBPER
	            $preciotexto.$P. // Precio unitario (incluye IGV-ISC-OTROS)
	            $preciotexto.$P.//number_format($total,2,'.','').$P. // Precio unitario por item * Cantidad (sin igv)
	            "0.00".$P; //Valor REFERENCIAL unitario (gratuitos)

	        $querycliente   = mysqli_query($con, "SELECT * FROM tb_cliente where id_cliente = '".$cliente."'");
			$fetchcliente= mysqli_fetch_array($querycliente);

	        $ruta_archivo['info'][0]['ruta'] =$ruta_servidor.$nombre_archivo.".cab";
	        $ruta_archivo['info'][0]['data'] = 
	            "0101".$P. //tipo operacion Catalogo N° 51
	            date("Y-m-d").$P. //Fecha de emision
	            date("H:m:s").$P. //Hora de emision
	            "-".$P. //Fecha de vencimiento (no obligatorio "-")
	            $fetchsucursal['cod_direccion_fiscal'].$P. //codigo de domicilioFiscal
	            $fetchcliente['id_tipo_documento_identidad'].$P. //Tipo documento Identidad Catalogo N° 6
	            $fetchcliente['n_documento_identidad'].$P. // Numero de documento
	            $fetchcliente['nombre_cliente'].$P. // Nombre de usuario
	            "PEN".$P. // Tipo moneda Catalogo N° 2  
	            "0.00".$P. //Sumatoria de tributo
	            $preciotexto.$P. // Total Valor Venta (total sin igv)
	            $preciotexto.$P. //TOTAL (incluye IGV) 
	            "0.00".$P. // Total descuentos
	            "0".$P. // Sumatoria otros Cargos
	            "0".$P. // Total Anticipos
	            $preciotexto.$P. //TOTAL - descuento + Otros cargos - Anticipos
	            "2.1".$P. // Version UBL
	            "2.0".$P; // Customization*/


	        $ruta_archivo['info'][2]['ruta'] =$ruta_servidor.$nombre_archivo.".ley";
	        $ruta_archivo['info'][2]['data'] = 
	            "1000".$P. //Código de leyenda
	            numtoletras(number_format($preciotexto ,2,'.','')).$P; //Descripcion de leyenda
	            
	        $ruta_archivo['info'][3]['ruta'] =$ruta_servidor.$nombre_archivo.".tri";
	        $ruta_archivo['info'][3]['data'] =
	            "9997".$P. // Identificador de Tributo Catalogo N° 5
	            "EXO".$P. // Nombre de tributo Catalogo N° 5
	            "VAT".$P. // Codigo de Tributo Catalogo N°5
	            $preciotexto.$P. // Base Inponible
	            "0".$P;// Monto Tributo por Item;

	        foreach ($ruta_archivo['info'] as $key => $value) {
	            if($archivo = fopen($value['ruta'] , "w+")) //a
	            {   
	                fwrite($archivo,"");
	                if(fwrite($archivo, $value['data']))
	                {
	                    $respo = true;
	                }
	                else
	                {
	                    $respo =false;
	                    break;
	                }
	                fclose($archivo);
	            }  
	        }

		}
		
		$count_queryfas   = mysqli_query($con, "SELECT id_facturacion FROM tb_facturacion_cab where codigo = '".$codigo."'");
		/*$rowes= mysqli_fetch_array($count_queryfas);
		$idfactura = $rowes['id_facturacion'];*/
		//print_r($codigo);
		$tip = 0;
		while ($rowface=mysqli_fetch_array($count_queryfas))
		{
			
			$desc = $descdet[$tip];
			$total = $totaldet[$tip];

			$idfactura = $rowface['id_facturacion'];
			$sqldet = "INSERT INTO tb_facturacion_det (id_facturacion, cantidad, id_categoria, id_producto, precio_unitario, igv_total, precio_total, descripccion) VALUES ('$idfactura','1','1','1', $total, $igv, $total, '$desc')";
			$insert_sqldet = mysqli_query($con, $sqldet);
			$tip++;
			//print_r($sqldet);
		}
			

		
		echo "1";
		
	}else if($action == "eliminar"){
		$idres = $_GET['idres'];


		$zz = "SELECT * FROM tb_reservas_det, tb_reservas_cab WHERE tb_reservas_det.id_reservas = tb_reservas_cab.id_reservas and tb_reservas_cab.id_reservas = '".$idres."'"; //print_r($zz);die();

		$count_queryreserva   = mysqli_query($con, $zz);
		

		
		while ($rowse=mysqli_fetch_array($count_queryreserva)){

			$id_bus = $rowse['id_bus'] ;
			$id_bus_det = $rowse['id_bus_det'] ;
			$fecha = $rowse['fecha_salida'] ;

			$qq = "DELETE FROM tb_control_asientos WHERE id_bus = '".$id_bus."' and id_bus_det= '".$id_bus_det."' and fecha= '".$fecha."' "; 
			//print_r($qq);die();
			$insert_tmp=mysqli_query($con, $qq);


		}



		$qq = "UPDATE tb_reservas_cab SET est_eliminar='1' WHERE id_reservas= '".$idres."' "; //print_r($qq);die();
		$insert_tmp=mysqli_query($con, $qq);
	}




	function numtoletras($xcifra)
    {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
    //
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }
        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }
                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                                
                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                                
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                                
                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO
            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";
            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";
            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO CON $xdecimales/100 SOLES";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UNO CON $xdecimales/100 SOLES";
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= "CON $xdecimales/100 SOLES"; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

    function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }