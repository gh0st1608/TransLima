<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	//echo "<pre>"; print_r($_POST); echo "</pre>";die();
	if (empty($_POST['razon_social'])) {
           $errors[] = "Razon Social esta vacío";
        }else if (empty($_POST['nombre_empresa'])) {
           $errors[] = "Nombre de la Empresa esta vacío";
        }else if (empty($_POST['ruc'])) {
           $errors[] = "RUC esta vacío";
        }else if (empty($_POST['email'])) {
           $errors[] = "Correo esta vacío";
        } else if (empty($_POST['telefono'])) {
           $errors[] = "Telefono esta vacío";
        } else if (empty($_POST['direccion'])) {
           $errors[] = "Direccion esta vacío";
        } else if (empty($_POST['impuesto'])) {
           $errors[] = "Impuesto esta vacío";
      	} else if (empty($_POST['moneda'])) {
           $errors[] = "Moneda esta vacío";
        }   else if (
			!empty($_POST['razon_social']) &&
			!empty($_POST['nombre_empresa']) &&
			!empty($_POST['ruc']) &&
			!empty($_POST['email']) &&
			!empty($_POST['telefono']) &&
			!empty($_POST['direccion']) &&
			!empty($_POST['impuesto']) &&
			!empty($_POST['moneda'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$razon_social=mysqli_real_escape_string($con,(strip_tags($_POST["razon_social"],ENT_QUOTES)));
		$nombre_empresa=mysqli_real_escape_string($con,(strip_tags($_POST["nombre_empresa"],ENT_QUOTES)));
		$ruc=mysqli_real_escape_string($con,(strip_tags($_POST["ruc"],ENT_QUOTES)));
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["email"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
		$impuesto=mysqli_real_escape_string($con,(strip_tags($_POST["impuesto"],ENT_QUOTES)));
		$moneda=mysqli_real_escape_string($con,(strip_tags($_POST["moneda"],ENT_QUOTES)));
		

		$count_query   = mysqli_query($con, "SELECT count(*) data FROM tb_empresa");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['data'];
		$usu = $_SESSION['user_id'];
		$fec = date("Y-m-d H:i:s");
		

		if($numrows==0){
	
			$sql="INSERT INTO tb_empresa 
			(razon_social,nombre_comercial,ruc,logotipo_empresa,correo_empresa,telefono_empresa,direccion,impuesto,moneda,id_usuario_creador,fecha_creado,id_usuario_modificador,fecha_modificado) VALUES
			('$razon_social','$nombre_empresa','$ruc','','$email','$telefono','$direccion','$impuesto','$moneda',$usu,'$fec',$usu,'$fec')";
		//print($sql);die();

		}else{
			$sql="UPDATE tb_empresa SET razon_social='".$razon_social."', nombre_comercial='".$nombre_empresa."', ruc='".$ruc."', correo_empresa='".$email."', telefono_empresa='".$telefono."', direccion='".$direccion."', impuesto='".$impuesto."', moneda='".$moneda."' ,id_usuario_modificador='".$_SESSION['user_id']."', fecha_modificado='".date("Y-m-d H:i:s")."'  WHERE id_empresa='1'";//die();
			//print($sql);die();
		}

		
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Datos han sido actualizados satisfactoriamente.";
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