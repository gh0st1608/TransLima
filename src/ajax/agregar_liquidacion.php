<?php

include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();
//print_r($session_id);die();

if (isset($_POST['idbus']) && isset($_POST['gastos']) ){$idbus=$_POST['idbus']; $gastos=$_POST['gastos'];}


	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");

	//date_default_timezone_set('UTC');
	date_default_timezone_set("America/Lima");

	$fecha_enco   = date("Y-m-d"); 
	$mas = 0; //date("Y-m-d 00:00:00");
	$consul="SELECT * FROM tb_facturacion_cab where si_liquidacion='0' and cast(fecha_envio as date) = '$fecha_enco' and id_sucursal = '".$_SESSION['idsucursal']."'";
	$query_vali   = mysqli_query($con, "SELECT * FROM tb_facturacion_cab where si_liquidacion='0' and cast(fecha_envio as date) = '$fecha_enco' and id_sucursal = '".$_SESSION['idsucursal']."'");
	while ($rows=mysqli_fetch_array($query_vali)){
		$mas++;
	}
	//echo $fecha_enco;
	//echo $mas;
//var_dump($consul);die();
if (!empty($idbus) && $mas > 0)
{	
	$fecha_inicio   = date("Y-m-d 00:00:01");
	$fecha_fin   = date("Y-m-d 23:59:59");

	$fecha   = date("Y-m-d 00:00:00");

	$query_encomienda = "";
	$query_encomienda .= "select sum(precio) as precio ";
	$query_encomienda .= "from tb_encomienda_cab a ";
	$query_encomienda .= "inner join tb_encomienda_det b on a.id_encomienda = b.id_encomienda ";
	$query_encomienda .= "where a.id_sucursal_partida = '".$_SESSION['idsucursal']."' ";
	$query_encomienda .= "and b.si_liquidacion = '0' ";
	$query_encomienda .= "and cast(fecha_creado as date) = '$fecha_enco' ";

	$query_precio   = mysqli_query($con, $query_encomienda);
	$fetch_precio= mysqli_fetch_array($query_precio);
	$total_encomienda  = (!empty($fetch_precio['precio'])) ? $fetch_precio['precio'] : 0;

	$query_factura = "";
	$query_factura .= "SELECT SUM(precio_total) precio FROM tb_facturacion_cab ";
	$query_factura .= "where si_liquidacion = '0' ";
	$query_factura .= "and (substring(n_documento,1,2) = 'FV' or substring(n_documento,1,2) = 'BV' ) ";
	$query_factura .= "and id_sucursal = '".$_SESSION['idsucursal']."' ";
	$query_factura .= "and cast(fecha_envio as date) = '$fecha_enco' ";

	//$count_queryfactura   = mysqli_query($con, "SELECT SUM(precio_total) precio FROM tb_facturacion_cab where si_liquidacion = '0' and fecha_envio > '$fecha_enco' and id_sucursal = '".$_SESSION['idsucursal']."'");
	$count_queryfactura   = mysqli_query($con, $query_factura);
	//var_dump($query_factura);die();
	$fetchfactura= mysqli_fetch_array($count_queryfactura);
	$total_comprobante  = (!empty($fetchfactura['precio'])) ? $fetchfactura['precio'] : 0;


	$count_query   = mysqli_query($con, "SELECT porcentaje FROM tb_sucursales WHERE id_sucursal = '".$_SESSION['idsucursal']."'");
	$serie= mysqli_fetch_array($count_query);
	$porcentaje  = $serie['porcentaje'];

	$count_query   = mysqli_query($con, "SELECT count(id_liquidacion) cantidad FROM tb_liquidacion");
	$fetch_liquidacion= mysqli_fetch_array($count_query);
	$fetch_liquidacion['cantidad']++;
	$correlativo  = str_pad($fetch_liquidacion['cantidad'], 6, "0", STR_PAD_LEFT);

	$total = $total_comprobante + $total_encomienda;
	$n_porc = ($total * $porcentaje) / 100;
	//$tot_desc = $total - $n_porc;
	$importe_total = $total - $n_porc - $gastos;

	$n_sucursal_par = $_SESSION['sucursal'];
	$sucursal_par = $_SESSION['idsucursal'];
	//$n_sucursal_lle = $_POST['n_sucursal_lle'];
	$n_idbus = $_POST['n_idbus'];
	$user_id = $_SESSION['user_id'];
	$idsucursal = $_SESSION['idsucursal'];

	try {

		//$sql = "INSERT INTO tb_liquidacion (correlativo, id_sucursal_inicio, su_inicio, id_sucursal_fin, sucu_fin, id_bus, nombre_bus, total_comprobante, total_encomienda, total, porcentaje, n_porcentaje, importe_total, id_usuario_creador, fecha_creado, id_sucursal) VALUES ('$correlativo', '$sucursal_par', '$n_sucursal_par', 'HUARI', '50', '$idbus', '$n_idbus', '$total_comprobante', '$total_encomienda', '$total', '$porcentaje', '$n_porc', '$importe_total', '$user_id', '$fecha', '$idsucursal')";
		$sql = "";
		$sql .= "INSERT INTO tb_liquidacion (correlativo, id_sucursal_inicio, su_inicio, id_sucursal_fin, sucu_fin, id_bus, nombre_bus, total_comprobante, total_encomienda, total, porcentaje, n_porcentaje, importe_total, id_usuario_creador, fecha_creado, id_sucursal, gastos)";
		$sql .= "VALUES ('$correlativo', '$sucursal_par', '$n_sucursal_par', '50', 'HUARI', '$idbus', '$n_idbus', '$total_comprobante', '$total_encomienda', '$total', '$porcentaje', '$n_porc', '$importe_total', '$user_id', '$fecha', '$idsucursal', '$gastos')";

		$insert_tmp=mysqli_query($con, $sql);

		//var_dump($sql); die();

		$query_id = mysqli_query($con, "SELECT id_liquidacion FROM tb_liquidacion order by id_liquidacion DESC limit 1");
		$fetch_id = mysqli_fetch_array($query_id);
		$id_liquidacion  = $fetch_id['id_liquidacion'];

		if ($id_liquidacion>0)
		{
			$updateFactura=mysqli_query($con, "UPDATE tb_facturacion_cab SET si_liquidacion='$id_liquidacion' WHERE si_liquidacion='0' and cast(fecha_envio as date) = '$fecha_enco' and id_sucursal = $idsucursal ");
			//$updateEncomienda=mysqli_query($con, "UPDATE tb_encomienda_det SET si_liquidacion='$id_liquidacion' WHERE si_liquidacion='0' and cast(fecha_registro as date) = '$fecha_enco' and id_sucursal_partida = $idsucursal ");
			$updateEncomienda  = "";
			$updateEncomienda .= "UPDATE tb_encomienda_det a ";
			$updateEncomienda .= "inner join tb_encomienda_cab b on a.id_encomienda	= b.id_encomienda ";
			$updateEncomienda .= "SET a.si_liquidacion='$id_liquidacion' ";
			$updateEncomienda .= "WHERE a.si_liquidacion='0' "; 
			$updateEncomienda .= "and cast(fecha_registro as date) = '$fecha_enco' ";
			$updateEncomienda .= "and b.id_sucursal_partida = '$idsucursal'";
			$updateE = mysqli_query($con,$updateEncomienda);
			echo $id_liquidacion;
		}else {
			echo "error";
		}
	} catch (Exception $e) {
		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	}
	// $updates=mysqli_query($con, "UPDATE tb_encomienda_det SET si_liquidacion='$id_liquidacion'WHERE si_liquidacion='0' and fecha_registro > '$fecha' and fecha_registro < '$fecha'");	
}else{
	echo "error";
}


?>