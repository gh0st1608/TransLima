<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_nombresucursal'])) {
           $errors[] = "Ingrese nombre de la sucursal";
        }else if (empty($_POST['mod_direccion'])) {
           $errors[] = "Ingrese la dirección";
        }else if (empty($_POST['id_sucursal'])) {
           $errors[] = "ID_sucursal";
        }else if (empty($_POST['mod_fiscal'])){
			$errors[] = "Ingrese código fiscal";
        } else if (empty($_POST['mod_seriefactura'])){
			$errors[] = "Ingrese numero de factura";
		} else if (empty($_POST['mod_serieboleta'])){
			$errors[] = "Ingrese numero de boleta";
		//} else if ($_POST['mod_estado']==""){
			//$errors[] = "Selecciona el estado del producto";
		} else if (
			!empty($_POST['mod_nombresucursal']) &&
			!empty($_POST['mod_direccion']) &&
			!empty($_POST['mod_fiscal']) &&
			!empty($_POST['mod_seriefactura']) &&
			!empty($_POST['mod_serieboleta'])
			//$_POST['mod_estado']!=""){
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$id_sucursal=mysqli_real_escape_string($con,(strip_tags($_POST["id_sucursal"],ENT_QUOTES)));
		$nombre_sucursal=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombresucursal"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["mod_direccion"],ENT_QUOTES)));
		$direccion_real=mysqli_real_escape_string($con,(strip_tags($_POST["mod_direccion_real"],ENT_QUOTES)));
		$dirección_fiscal=mysqli_real_escape_string($con,(strip_tags($_POST["mod_fiscal"],ENT_QUOTES)));
		$serie_factura=mysqli_real_escape_string($con,(strip_tags($_POST["mod_seriefactura"],ENT_QUOTES)));
		$serie_boleta=mysqli_real_escape_string($con,(strip_tags($_POST["mod_serieboleta"],ENT_QUOTES)));

		$serie_factura_viaje=mysqli_real_escape_string($con,(strip_tags($_POST["mod_seriefactura_viaje"],ENT_QUOTES)));
		$serie_boleta_viaje=mysqli_real_escape_string($con,(strip_tags($_POST["mod_serieboleta_viaje"],ENT_QUOTES)));

		$porcentaje=mysqli_real_escape_string($con,(strip_tags($_POST["mod_porcentaje"],ENT_QUOTES)));

		$horaviaje=date("Y-m-d H:i:s", strtotime(mysqli_real_escape_string($con,(strip_tags($_POST["mod_horaviaje"],ENT_QUOTES)))));
		//$estado=intval($_POST['mod_estado']);
		$usu = $_SESSION['user_id'];
		$fec = date('Y-m-d');

		$sql="UPDATE tb_sucursales SET nombre_sucursal='".$nombre_sucursal."', serie_boleta='".$serie_boleta."',serie_factura='".$serie_factura."',direccion='".$direccion."',cod_direccion_fiscal='".$dirección_fiscal."',estado='1',id_usuario_modificador='".$usu."', fecha_modificado='".$fec."', hora_viaje = '".$horaviaje."' , serie_boleta_viaje = '".$serie_boleta_viaje."' , serie_factura_viaje = '".$serie_factura_viaje."' , direccion_real = '".$direccion_real."' , porcentaje = ".$porcentaje."  WHERE id_sucursal='".$id_sucursal."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "La sucursal ha sido actualizado satisfactoriamente.";
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