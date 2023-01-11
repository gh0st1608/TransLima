<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
// $b=$_POST['bus'];
// $a=$_POST['asiento'];
// $p=$_POST['piso'];

	//session_start();
	if (!empty($_POST['id_cliente']) and !empty($_POST['id_bus']))
	{	
		$sucursal = $_SESSION['idsucursal'];
		//$fecha = date("Y-m-d H:i:s");
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST['codigo'],ENT_QUOTES)));
		$id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST['id_cliente'],ENT_QUOTES)));
		$id_sucu_llegada=mysqli_real_escape_string($con,(strip_tags($_POST['id_sucu_llegada'],ENT_QUOTES)));
		$fecha=date("Y/m/d H:i:s", strtotime(mysqli_real_escape_string($con,(strip_tags($_POST['fecha'],ENT_QUOTES)))));
		$usuario =$_SESSION['user_id'];
		$fecha_salida= date("Y/m/d", strtotime(mysqli_real_escape_string($con,(strip_tags($_POST['fenvio'],ENT_QUOTES)))));


		/*encomienda*/
		$sqlres = "INSERT INTO tb_reservas_cab (codigo, fecha_registro, id_cliente, id_usuario_creador, fecha_salida, id_sucursal, id_sucursal_llegada) VALUES ('$codigo', '$fecha', $id_cliente, $usuario, '$fecha_salida',$sucursal, $id_sucu_llegada)";

		$insert_sqlres=mysqli_query($con, $sqlres);


		//print_r($sqlencocab);die();

		$count_encocab   = mysqli_query($con, "SELECT id_reservas FROM tb_reservas_cab WHERE codigo = '".$codigo."'");
		$rowencocab= mysqli_fetch_array($count_encocab);
		$id_reservas = $rowencocab['id_reservas'];

		$sqlencodet = "UPDATE tb_reservas_det SET id_reservas = $id_reservas WHERE codigo = '".$codigo."'";
		$insert_encodet=mysqli_query($con, $sqlencodet);

		$count_resdet   = mysqli_query($con, "SELECT * FROM tb_reservas_det WHERE codigo = '".$codigo."'");
		//$rowresdev= mysqli_fetch_array($count_resdet);

		while ($rowresdev=mysqli_fetch_array($count_resdet)){

			$id_bus = $rowresdev['id_bus'];
			$id_bus_det = $rowresdev['id_bus_det'];

			$count_conasi   = mysqli_query($con, "SELECT id_control_asientos FROM tb_control_asientos WHERE fecha = '".$fecha_salida."' and id_bus = $id_bus and id_bus_det = $id_bus_det and estado_general = 1");
			$rowconasi= mysqli_fetch_array($count_conasi);
			$conasi = $rowconasi['id_control_asientos'];
			if (!empty($conbus)) {
				$cambiocontrol = "UPDATE tb_control_asientos SET estado = 3 WHERE id_control_asientos = '".$conasi."'";
				$savecontrol=mysqli_query($con, $cambiocontrol);
			}else{
				$cambiocontrol = "INSERT INTO tb_control_asientos (id_bus, id_bus_det, estado, estado_general, fecha) VALUES ($id_bus, $id_bus_det, 3, 1, '$fecha_salida')";
				$savecontrol=mysqli_query($con, $cambiocontrol);
			}
		}

		/*-------------------------------------*/
		$validacion = ($insert_sqlres && $savecontrol) ? true : false ;

	}
	/*if (isset($_POST['facobol'])) {
		

		$sqlfac = "INSERT INTO tb_facturacion_cab (id_sucursal, id_tipo_documento, n_documento, id_cliente, valor_total, igv_total, precio_total, id_usuario_creador, fecha_creado , id_usuario_modificador, fecha_modificado, id_moneda, id_bus, precio_texto, fecha_envio, codigo) VALUES ('$idsucupartida','$tipdoc','$ndocumento','$id_cliente', $subtotalcab, $igvcab, $totalcab, '$usuario', '$fecha', '', '', '1','$id_bus', $preciotexto, '$fecha', '$codigo')";
		$insert_tmp=mysqli_query($con, $sqlfac);

		$count_query   = mysqli_query($con, "SELECT id_facturacion FROM tb_facturacion_cab ORDER BY id_facturacion DESC limit 1");
		$row= mysqli_fetch_array($count_query);
		$idfactura = $row['id_facturacion'];

		$sqldetencomienda=mysqli_query($con, "select * from tb_encomienda_det where tb_encomienda_det.codigo='".$codigo."'");

		while ($row=mysqli_fetch_array($sqldetencomienda))
		{	
			$desc=$row['producto'];
			$cantidad=$row['cantidad'];

			if ($tipdoc == 1) {

				$subtotal = number_format($row['precio'],2,'.','') / $cantidad;
				$igv = (($subtotal * 18 ) / 100) * $cantidad;
				$total = number_format($row['precio'],2,'.','');

				$subtotalparafe=number_format($row['precio'],2,'.','');
			}else{
				
				$zz = ($row['precio'] * 18 ) / 100;
				$total = $row['precio'] - $zz;
				$subtotal = (number_format($row['precio'],2,'.','') - $zz) / $cantidad ;

				$subtotalparafe= number_format($row['precio'],2,'.','') - $zz;
                $valorigv = ($subtotalparafe * 18) / 100;
				$igv = number_format($valorigv,2,'.','') ;
			}
			
			

			$sqldet = "INSERT INTO tb_facturacion_det (id_facturacion, cantidad, id_categoria, id_producto, precio_unitario, igv_total, precio_total, descripccion) VALUES ('$idfactura','$cantidad','1','1', $subtotal, $igv, $total, '$desc')";

			$insert_sqldet = mysqli_query($con, $sqldet);

		}


	}*/

		if ($validacion){
			echo $id_reservas."-El documento fue creada correctamente";
		} else{
			echo "0-Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
		}



       




