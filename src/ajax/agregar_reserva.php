<?php

include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();
//print_r($session_id);die();
if (isset($_POST['valrow'])){$valrow=$_POST['valrow'];}
if (isset($_POST['valpiso'])){$valpiso=$_POST['valpiso'];}
if (isset($_POST['idbus'])){$idbus=$_POST['idbus'];}
if (isset($_POST['codigo'])){$codigo=$_POST['codigo'];}


	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
if (!empty($valrow) and !empty($valpiso) and !empty($idbus) and !empty($codigo))
{
	$descripcion =  "Piso # ".$valpiso." asiento # ".$valrow;
	$count_queryasiento   = mysqli_query($con, "SELECT id_buses_det FROM tb_buses_det where id_bus = $idbus and piso = $valpiso and asiento =$valrow");
	$rowasiento= mysqli_fetch_array($count_queryasiento);
	$idbusdet = $rowasiento['id_buses_det'];
	
	$sqlque = "INSERT INTO tb_reservas_det (id_reservas, descripcion, total, id_bus, id_bus_det, codigo) VALUES ('0', '$descripcion', 0, $idbus, $idbusdet, '$codigo')";
	//print_r($sqlque);die();
	$insert_tmp=mysqli_query($con, $sqlque);

}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tb_reservas_det WHERE id_reservas_det='".$id_tmp."'");

$codigo = $_GET['codigo'];
//$tipdoc = $_GET['tipdoc'];
}

if (isset($_POST['txtenv']) && isset($_POST['id']))//codigo elimina un elemento del array
{
	$iddet=$_POST['id'];
	$txtenv=$_POST['txtenv'];	
	$codigo=$_POST['codigo'];	

	$updates=mysqli_query($con, "UPDATE tb_reservas_det SET total='50' WHERE id_reservas_det=$iddet ");
	
}
if (isset($_POST['txtpasajero']) && isset($_POST['id']))//codigo elimina un elemento del array
{
	$iddet=$_POST['id'];
	$txtenv=$_POST['txtpasajero'];	
	$codigo=$_POST['codigo'];	

	$sssql = "UPDATE tb_reservas_det SET pasajero='sucursal' WHERE id_reservas_det=$iddet ";
	//print_r($sssql);
	$updates=mysqli_query($con, $sssql);
	
}


?>
<table class="table" id="tablareserva">

<tr>
	<th class='text-center'>#</th>
	<th class='text-center'>Descripcion</th>
	<th class='text-right'>Pasajero</th>
	<th class='text-right'>Precio</th>
	<th class='text-right'>Acciones</th>
</tr>
<?php
	
	$sql=mysqli_query($con, "SELECT * FROM tb_reservas_det WHERE tb_reservas_det.codigo='".$codigo."'");
	$hash = 0;
	while ($row=mysqli_fetch_array($sql))
	{

	$hash++; 
	$descripcion=$row["descripcion"];
	$id_reservas_det=$row["id_reservas_det"];	
	$total = $row['total'];
	$pasajero = $row['pasajero']; //print_r($pasajero );
	$valordeprecio = ($total == 0) ? '<input id="'.$id_reservas_det.'"  type="text" name="preciobus" value="50">' : number_format($total,2) ;

	$pasajeros = (empty($pasajero)) ? '<input idpas="'.$id_reservas_det.'" type="text" name="pasjero" value="sucursal">' : $pasajero ;
	//<?php echo number_format($total,2);

		?>
		<tr class="if">
			<td class='text-center else'><?php echo $hash;?></td>
			<td class='text-center descp'><?php echo $descripcion;?></td>
			<td class="text-right"><?php echo $pasajeros;?></td>
			<td class="text-right"><?php echo $valordeprecio;?></td>
			<td class='text-right'><a href="#" onclick="eliminar('<?php echo $id_reservas_det ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	
?>


</table> 
