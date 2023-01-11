<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['idbus'])){

		$id_bus=intval($_GET['idbus']);

		$query=mysqli_query($con, "SELECT * FROM tb_control_asientos WHERE id_bus='".$id_bus."'");
		$count=mysqli_num_rows($query);
		if ($count>=1){
			$deletedet=mysqli_query($con,"UPDATE tb_control_asientos SET estado_general='0' WHERE id_bus='".$id_bus."'");
			if ($deletedet){
			?>Datos reseteados exitosamente.<?php 
		}else {
			?>Lo siento algo ha salido mal intenta nuevamente.<?php
			
		}
			
		} else {
			?>No se pudo resetear este bus.<?php
		}
		
		
		
	}