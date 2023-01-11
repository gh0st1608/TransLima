<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

$idfact=$_POST['idfact'];
$bus=$_POST['bus'];
$asiento=$_POST['asiento'];
$fecha=$_POST['fecha'];
$piso=$_POST['piso'];
$queryu="SELECT * FROM tb_buses_det where id_bus='$bus' and piso='$piso' and asiento='$asiento' ";
$exeu=mysqli_query($con,$queryu);
$asientoa=mysqli_fetch_array($exeu);
$idasiento=$asientoa['id_buses_det'];
$queryd="SELECT * FROM tb_control_asientos where fecha like'%$fecha%' and id_bus_det='$idasiento'";
$exed=mysqli_query($con,$queryd);
$dato=mysqli_num_rows($exed);
if ($dato==1) {
	echo "1";
}
if ($dato==0) {
	 $insertar="INSERT INTO tb_control_asientos (id_bus,id_bus_det,estado,estado_general,fecha) VALUES ('$bus','$idasiento','2','1','$fecha')";
     //echo $insertar;die();
     $exe=mysqli_query($con, $insertar);
 if ($exe) {
 	//echo "11";
 	$queryt="UPDATE tb_facturacion_cab SET id_bus='$bus',fecha_envio='$fecha' WHERE id_facturacion='$idfact'";
 	//echo $queryt; die();
 	$cab=mysqli_query($con,$queryt);
 	$queryc="UPDATE tb_facturacion_det SET descripccion='Piso # $piso Asiento # $asiento' where id_facturacion='$idfact'";
 	$det=mysqli_query($con,$queryc);
 }
 if ($det) {
 		echo "11";
 	}
}

?>