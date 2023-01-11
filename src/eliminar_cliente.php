<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) 
	{
        header("location: login.php");
		exit;
    }

	
	
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	if (isset($_REQUEST['id_cliente']))
	{
		$id_cliente=intval($_REQUEST['id_cliente']);
		print_r('entrooooooooooooooooooooooooooogaaaaaaaaaaaaaaaaaaaaa');
		print_r($id_cliente);
		$sqleliminar = mysqli_query($con,"update tb_cliente SET estado = 2 WHERE id_cliente='".$id_cliente."'");

		header('Location: clientes.php');
	}
?>