<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombresucursal'])) {
           $errors[] = "Nombre de la Sucursal vacio";
        } else if (empty($_POST['direccion'])){
			$errors[] = "Direccion de la Sucursal vacio";
		} else if ($_POST['seriefactura']==""){
			$errors[] = "El Número de Factura Vacio";
		}else if (empty($_POST['serieboleta'])) {
			$errors[] = "El Número de Boleta Vacio";
		}else if (empty($_POST['fiscal'])){
			$errors[] = "Código Fiscal Vacio";
		} else if (
			!empty($_POST['nombresucursal']) &&
			!empty($_POST['direccion']) &&
			!empty($_POST['seriefactura']) &&
			!empty($_POST['serieboleta']) &&
			!empty($_POST['fiscal']) 
			//$_POST['estado']!=""
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombresucursal=mysqli_real_escape_string($con,(strip_tags($_POST["nombresucursal"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
		$direccion_real=mysqli_real_escape_string($con,(strip_tags($_POST["direccion_real"],ENT_QUOTES)));
		$seriefactura=mysqli_real_escape_string($con,(strip_tags($_POST["seriefactura"],ENT_QUOTES)));
		$serieboleta=mysqli_real_escape_string($con,(strip_tags($_POST["serieboleta"],ENT_QUOTES)));

		$seriefactura_viaje=mysqli_real_escape_string($con,(strip_tags($_POST["serieboleta_viaje"],ENT_QUOTES)));
		$serieboleta_viaje=mysqli_real_escape_string($con,(strip_tags($_POST["seriefactura_viaje"],ENT_QUOTES)));


		$fical=mysqli_real_escape_string($con,(strip_tags($_POST["fiscal"],ENT_QUOTES)));
		$horaviaje=date("Y-m-d H:i:s", strtotime(mysqli_real_escape_string($con,(strip_tags($_POST["horaviaje"],ENT_QUOTES)))));

		$porcentaje=mysqli_real_escape_string($con,(strip_tags($_POST["porcentaje"],ENT_QUOTES)));
		//$estado=intval($_POST['estado']);
		// $date_added=date("Y-m-d H:i:s");
		$usu = $_SESSION['user_id'];
		$fec = date('Y-m-d');


		$sql="INSERT INTO tb_sucursales(nombre_sucursal, serie_boleta,serie_factura,direccion,cod_direccion_fiscal,estado,id_usuario_creador,fecha_creado, fecha_modificado,hora_viaje,serie_boleta_viaje,serie_factura_viaje,porcentaje,direccion_real) VALUES ('$nombresucursal','$serieboleta','$seriefactura','$direccion','$fical','1',$usu,'$fec','$fec','$horaviaje','$serieboleta_viaje','$seriefactura_viaje',$porcentaje,'$direccion_real')";
		//print_r($sql);
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Sucursal ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
						foreach ($errors as $error) {
								echo $error;
							}
						
			}
			if (isset($messages)){
				
							foreach ($messages as $message) {
									echo $message;
								}
			}

?>