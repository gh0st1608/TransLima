<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
include("../funciones.php");

$bus=$_POST['id_bus'];
$asiento=$_POST['asiento'];
$piso=$_POST['piso'];
$fechaenvio=$_POST['fenvio'];
$sucursal = $_SESSION['idsucursal'];
$codigo=(isset($_POST['codigo'])?$_POST['codigo']:'');
$fecha=date("Y/m/d H:i:s", strtotime($_POST['fecha']));
$id_sucu_llegada=$_POST['id_sucu_llegada'];
$usuario =$_SESSION['user_id'];

// $count_queryasiento   = mysqli_query($con, "SELECT id_buses_det FROM tb_buses_det where id_bus = $bus and piso = $piso and asiento =$asiento");
// 		$rowasiento= mysqli_fetch_array($count_queryasiento);
// 		$idbusdet = $rowasiento['id_buses_det'];


$query="SELECT id_buses_det FROM tb_buses_det WHERE id_bus='$bus' and piso='$piso' and asiento=$asiento";
 //print_r($query);die();
$result=mysqli_query($con, $query);
$dato=mysqli_fetch_array($result);
$valor=$dato['id_buses_det'];
//print_r($valor);die();
$veri="SELECT * FROM tb_control_asientos where id_bus='$bus' and id_bus_det='$valor' and fecha='$fechaenvio'";
//print_r($veri);die();
$rpta=mysqli_query($con, $veri);
$fila=mysqli_num_rows($rpta);
//print_r($fila);die();
//echo $fila;
if($fila==1){
	echo "0"; die();
 //$resver['id_control_asientos'];
}else{
 $insertar="INSERT INTO tb_control_asientos (id_bus,id_bus_det,estado,estado_general,fecha) VALUES ('$bus','$valor','3','1','$fechaenvio')";
 //echo $insertar;die();
 $exe=mysqli_query($con, $insertar);
}
if ($exe) {
$cab="INSERT INTO tb_reservas_cab (codigo,fecha_registro,id_cliente,id_usuario_creador,fecha_salida,est_eliminar,id_sucursal,id_sucursal_llegada) VALUES ('$codigo','$fecha','77','$usuario','$fechaenvio','0','$sucursal','$id_sucu_llegada')";
//echo $cab;die();
$exec=mysqli_query($con, $cab);
}
if ($exec) {
	$buscarcab="SELECT * FROM tb_reservas_cab ORDER by id_reservas DESC LIMIT 1";
	$c=mysqli_query($con, $buscarcab);
	$ver=mysqli_fetch_array($c);
	$idres=$ver['id_reservas'];
	$descri="Piso # ".$piso." asiento # ".$asiento."";
	//var_dump($ver);die();
$det="INSERT INTO tb_reservas_det (id_reservas,descripcion,total,id_bus,id_bus_det,codigo,fecha_envi,pasajero) VALUES('$idres','$descri','50','$bus','$valor','$codigo','$fechaenvio','FACTURA')";
//echo $det;die();
 $execute=mysqli_query($con, $det);
}
if($execute){
	echo "11";
}else{
	echo "100";
}
?>