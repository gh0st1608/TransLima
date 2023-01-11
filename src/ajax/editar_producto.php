<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['codigobus'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['nombre_bus'])) {
           $errors[] = "Nombre vacío";
       // } else if (empty($_POST['fila1'])){
			//$errors[] = "Filas Vacios";
        //} else if (empty($_POST['pisos'])){
		//	$errors[] = "Pisos vacío";
		} else if (empty($_POST['caracteristicas'])){
			$errors[] = "Caracteristicas vacio";
		 } else if (empty($_POST['placa'])){
			$errors[] = "Placa vacio";	
		} else if (
			!empty($_POST['codigobus']) &&
			!empty($_POST['nombre_bus']) &&
			//!empty($_POST['fila1']) &&
			//!empty($_POST['pisos']) &&
			!empty($_POST['caracteristicas']) &&
			!empty($_POST['placa'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigobus"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre_bus"],ENT_QUOTES)));
		//$filas1=mysqli_real_escape_string($con,(strip_tags($_POST["fila1"],ENT_QUOTES)));
		//$filas2=(!empty($_POST['fila2'])) ? mysqli_real_escape_string($con,(strip_tags($_POST["fila2"],ENT_QUOTES))) : 0;
		//$pisos=mysqli_real_escape_string($con,(strip_tags($_POST["pisos"],ENT_QUOTES)));
		$caracteristicas=mysqli_real_escape_string($con,(strip_tags($_POST["caracteristicas"],ENT_QUOTES)));
		$placa=mysqli_real_escape_string($con,(strip_tags($_POST["placa"],ENT_QUOTES)));
		
		$usu = $_SESSION['user_id'];
		$fec = date('Y-m-d');

		$sql="UPDATE tb_buses SET nombre_bus='".$nombre."', caracteristicas='".$caracteristicas."',estado='1',placa='".$placa."', id_usuario_modificador='".$usu."', fecha_modificado='".$fec."' WHERE id_bus='".$codigo."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "El bus ha sido actualizado satisfactoriamente.";
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