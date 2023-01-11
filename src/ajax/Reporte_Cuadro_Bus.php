<?php
//session_start();
//include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
//require("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
//require("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
//$con=mysqli_connect("a2plcpnl0863.prod.iad2.secureserver.net","bd_sistema","%Sistemas0rb1n3t@","db_sis_integral");
require('./ajax/fpdf/fpdf.php');
$pdf = new FPDF('P','mm','A4'); 
//$pdf = new FPDF();
$pdf->AddPage();
//$pdf->Image('logito.png',30,4,20);
$pdf->SetFont('Arial','B',16);
$pdf->Ln(10);
$pdf->setX(1);
$pdf->Cell(70,10,'HUARI TOURS S.A.C.',0,1,'C');
?>