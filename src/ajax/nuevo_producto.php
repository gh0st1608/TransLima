<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/ //print_r($_POST);die();
	if (empty($_POST['nombre_bus'])) {
           $errors[] = "Nombre vacío";
        } else if (empty($_POST['fila1'])){
			$errors[] = "Filas Vacio";
        //} else if (empty($_POST['asiento1'])){
			//$errors[] = "Pisos vacío";
		//} else if (empty($_POST['caracteristicas'])){
			//$errors[] = "Caracteristicas vacio";
		 } else if (empty($_POST['placa'])){
			$errors[] = "Placa vacio";	
		} else if (
			!empty($_POST['nombre_bus']) &&
			!empty($_POST['fila1']) &&
			//!empty($_POSTS['asiento1']) &&
			//!empty($_POST['caracteristicas']) &&
			!empty($_POST['placa'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be(html/javascript-) code
		//$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigobus"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre_bus"],ENT_QUOTES)));
		$filas1=mysqli_real_escape_string($con,(strip_tags($_POST["fila1"],ENT_QUOTES)));
		$filas2=(!empty($_POST['fila2'])) ? mysqli_real_escape_string($con,(strip_tags($_POST["fila2"],ENT_QUOTES))) : 0;

		//print_r($filas2);die();
		//$asiento=mysqli_real_escape_string($con,(strip_tags($_POST["asiento1"],ENT_QUOTES)));
		$caracteristicas=mysqli_real_escape_string($con,(strip_tags($_POST["caracteristicas"],ENT_QUOTES)));
		$placa=mysqli_real_escape_string($con,(strip_tags($_POST["placa"],ENT_QUOTES)));

		$usu = $_SESSION['user_id'];
		$fec = date('Y-m-d');


		$sql="INSERT INTO tb_buses(nombre_bus,filaspiso1,filaspiso2,caracteristicas,estado,placa,id_usuario_creador,fecha_creado) VALUES ('$nombre','$filas1','$filas2','$caracteristicas','1','$placa',$usu,'$fec')";
		//print_r($sql);die();
		$query_new_insert = mysqli_query($con,$sql);
		//print_r($sql);
		$id_query   = mysqli_query($con, "SELECT id_bus FROM tb_buses ORDER BY id_bus DESC LIMIT 1");
		$row= mysqli_fetch_array($id_query);
		$idbus = intval($row['id_bus']);
		$asientos1 = ($filas1==0 || $filas1 < 0) ? 0 : ($filas1*4)+1;
		$asientos2 = ($filas2==0 || $filas2 < 0) ? 0 : ($filas2*4)+1;
		$succes = 1 ;
		for ($i=0; $i < $asientos1 ; $i++) { 
			$sqldet="INSERT INTO tb_buses_det(id_bus,estado,piso) VALUES ($idbus,'1','1')";
			$query_insert = mysqli_query($con,$sqldet);
			if ($query_insert){}else{$succes=0;}
		}
		if($asientos2 !=0){
			for ($i=0; $i < $asientos2 ; $i++) { 
				$sqldet="INSERT INTO tb_buses_det(id_bus,estado,piso) VALUES ($idbus,'1','2')";
				$query_insert = mysqli_query($con,$sqldet);
				if ($query_insert){}else{$succes=0;}
			}
		}


			if ($query_new_insert && $succes == 1){
				$messages[] = "El bus ha sido ingresado satisfactoriamente.";
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