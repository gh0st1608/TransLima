<?php
include('is_logged.php');

	require_once ("../config/db.php");
	require_once ("../config/conexion.php");

	$fecha = date('Y-m-d');

	$sqlSelectReserva = "SELECT id_reservas FROM tb_reservas_cab WHERE fecha_salida = '$fecha 00:00:00' ";

	while ($rows=mysqli_fetch_array($sqlSelectReserva)){
        $id_reserva = $rows['id_reservas'];
		$sqlDeleteReservaDetalle = "DELETE FROM tb_reservas_det WHERE id_reservas = ".$rows['id_reservas'];
        $deleteDetalle = mysqli_query($con, $sqlDeleteReservaDetalle);		
  	}

  	$sqlDeleteReserva = "DELETE FROM tb_reservas_cab WHERE fecha_salida = '$fecha 00:00:00'";
    $delete = mysqli_query($con, $sqlDeleteReserva);


    $upadateAsientos = "DELETE FROM tb_control_asientos WHERE estado_general = 1 AND estado = 3 AND fecha = '$fecha 00:00:00' ";
	
	$insert_tmp=mysqli_query($con, $upadateAsientos);

	if ($insert_tmp) {
			echo "1";
	}else{ echo "0"; }


