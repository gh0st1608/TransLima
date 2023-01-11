<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	//session_start();
	$idbus = $_POST['idbus'];
    $fecha = date("Y-m-d", strtotime($_POST['fecha']));
    $piso = $_POST['piso'];
    $asiento = $_POST['asiento'];
    // print_r($fecha); die();

    // verificar la existencia de los asientos
    $sql_existe = "";
    $sql_existe.= "SELECT EXISTS (select * from tb_buses_det where id_bus = '$idbus' and piso = $piso and asiento = $asiento) AS valor";
    $queryexiste = mysqli_query($con, $sql_existe);
    $valor_existe = mysqli_fetch_array($queryexiste,MYSQLI_ASSOC);
    $row = $valor_existe['valor'];
    if ($row==1) {// asiento si existe
        // verificar si asiento esta ocupado
        $sqlest="";
        $sqlest.="SELECT count(*) num FROM tb_control_asientos conasi ";
        $sqlest.="left join tb_buses_det busdet on conasi.id_bus_det = busdet.id_buses_det ";
        $sqlest.="where conasi.estado_general = 1 ";
        $sqlest.="and conasi.fecha = '$fecha' ";
        $sqlest.="and conasi.id_bus = '$idbus' ";
        $sqlest.="and busdet.piso = '$piso' ";
        $sqlest.="and busdet.asiento = '$asiento' ";
        $sqlest.="and conasi.estado !=1 ";

        $queryest = mysqli_query($con, $sqlest);
        $cantidad_asientos = mysqli_fetch_array($queryest,MYSQLI_ASSOC);
        $true = $cantidad_asientos['num'];

        if ($true > 0) {
            echo 1; //true
        }else {
            echo 0; //false
        }        
    }else echo 1; //true