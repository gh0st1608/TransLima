<?php 
$fecha=$_POST['fechaini'];
$fechaf=$_POST['fechafin'];
//ECHO $fecha;
$con=mysqli_connect("localhost","root","","transportes");
$queryquery = "SELECT distinct b.nombre_sucursal,SUM(precio_total) as montos,COUNT(case when a.id_tipo_documento='3' and a.id_sucursal=a.id_sucursal then 1 else null end) as MONTBOLETOS ,COUNT(case when a.id_tipo_documento='1' then 1 else null end) as MONTFACTURAS FROM tb_facturacion_cab a LEFT JOIN tb_sucursales b on b.id_sucursal=a.id_sucursal WHERE CAST(a.fecha_creado AS date) BETWEEN '$fecha' and '$fechaf' GROUP BY a.id_sucursal";

$query   = mysqli_query($con, $queryquery);
 //var_dump($query);die();
 ///echo json_encode($query);
 foreach ($query as $value) {
 	echo"['".$value['nombre_sucursal']."',     ".$value['montos']."],";
 }
//var_dump($query);die();
?>