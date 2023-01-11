<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
$bus=$_POST['id_bus'];
$asiento=$_POST['asiento'];
$fenvio=$_POST['fenvio'];
$piso=$_POST['piso'];
//echo $fenvio; die();
$count_queryasiento   = mysqli_query($con, "SELECT id_buses_det FROM tb_buses_det where id_bus = $bus and piso = $piso and asiento =$asiento");
		$rowasiento= mysqli_fetch_array($count_queryasiento);
		$idbusdet = $rowasiento['id_buses_det'];
$sqlasiento = "INSERT INTO tb_control_asientos (id_bus, id_bus_det, estado, estado_general, fecha) VALUES ('$bus','$idbusdet','4','1', '$fenvio')";
		//print_r($sqlasiento);die();
		$insert_sqlasiento = mysqli_query($con, $sqlasiento);
if ($insert_sqlasiento) {
	echo "EXITO! Se separo el Asiento para una Agencia";
}else{
	echo "ERROR";
}
?>