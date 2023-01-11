<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
$id=$_POST['id'];
$query="SELECT * FROM tb_facturacion_cab WHERE id_facturacion='$id'";
$execute=mysqli_query($con,$query);
$dato=mysqli_fetch_array($execute);
$idbus=$dato['id_bus'];
$fechaviaje=$dato['fecha_envio'];

$act="UPDATE tb_facturacion_cab SET id_bus='99' WHERE id_facturacion='$id'";
//var_dump($act);die();
$exe=mysqli_query($con,$act);

//echo "bus: ".$idbus;
$querys="SELECT * FROM tb_facturacion_det WHERE id_facturacion='$id'";
$executes=mysqli_query($con,$querys);
$datos=mysqli_fetch_array($executes);
$piso=$datos['descripccion'];
$pisos=$piso[7];
$asiento=$datos['descripccion'];
$asientos=substr($asiento,19);
$as=intval($asientos);

$editardet="UPDATE tb_facturacion_det SET descripccion='' WHERE id_facturacion='$id'";
$editar=mysqli_query($con,$editardet);
//var_dump($as);die();
$verb="SELECT * FROM tb_buses_det where id_bus='$idbus' and piso='$pisos' and asiento='$as'";
//var_dump($verb);die();
$exever=mysqli_query($con,$verb);
$d=mysqli_fetch_array($exever);
$idasiento=$d['id_buses_det'];

$control="UPDATE tb_control_asientos SET id_bus='99' where id_bus_det='$idasiento' and fecha='$fechaviaje'";
//var_dump($control);
$exec=mysqli_query($con,$control);
//$vali=mysqli_affected_rows();
if ($exec) {
echo "1";
}else{
echo "0";
}
?>