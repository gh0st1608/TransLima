<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) 
	{
        header("location: login.php");
		exit;
    }

	
	
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	if (isset($_REQUEST['id_encomienda']))
	{
		$id_encomienda=intval($_REQUEST['id_encomienda']);
		$sqleliminar = mysqli_query($con,"update tb_encomienda_cab SET situacion = 2 WHERE id_encomienda='".$id_encomienda."'");
		header('Location: encomienda.php');
	}
?>