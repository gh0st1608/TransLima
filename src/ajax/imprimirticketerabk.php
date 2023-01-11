<?php
//echo"holaas";die();
//session_start();
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
//require("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
//require("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
$con=mysqli_connect("localhost","root","","transportes");
require('fpdf/fpdf.php');
$id_factura = intval($_REQUEST['id_factura']);
//var_dump($id_factura);die();
 $count_queryempresa = mysqli_query($con, "SELECT * FROM tb_empresa WHERE id_empresa = 1 ");
 $fetchempresa       = mysqli_fetch_array($count_queryempresa);
 $empresa            = $fetchempresa['razon_social'];
 $ruc                = $fetchempresa['ruc'];
 $direccion_empresa  = $fetchempresa['direccion'];
 $sucursal            = $_SESSION['idsucursal'];
 $count_querysucursal = mysqli_query($con, "SELECT * FROM tb_sucursales WHERE id_sucursal = $sucursal ");
 $fetchsucursal       = mysqli_fetch_array($count_querysucursal);
 $nombre_sucursalcab  = $fetchsucursal['nombre_sucursal'];
 $direccion_sucursal  = $fetchsucursal['direccion'];
 $hora_viaje          = date('h:i:s a', strtotime($fetchsucursal['hora_viaje']));
 $campos             = "tb_facturacion_cab.n_documento , tb_facturacion_cab.fecha_creado , tb_facturacion_cab.id_pasajero,tb_facturacion_cab.igv_total, tb_facturacion_cab.precio_total , tb_facturacion_cab.id_tipo_documento ,tb_cliente.n_documento_identidad, tb_facturacion_cab.fecha_envio, tb_cliente.nombre_cliente, tb_sucursales.nombre_sucursal,tb_facturacion_cab.id_sucursal_llegada, tb_facturacion_cab.codigo, tb_facturacion_cab.id_tipo, tb_facturacion_cab.consignatario";
 
 $count_queryfactura = mysqli_query($con, "SELECT $campos FROM tb_facturacion_cab, tb_cliente, tb_sucursales WHERE tb_facturacion_cab.id_sucursal_llegada = tb_sucursales.id_sucursal and tb_cliente.id_cliente = tb_facturacion_cab.id_cliente and id_facturacion = $id_factura ");
 $fetchfactura       = mysqli_fetch_array($count_queryfactura);
 //var_dump($fetchfactura);die();
 $n_documento        = $fetchfactura['n_documento'];
 $fecha              = date("Y-m-d h:i:s a", strtotime($fetchfactura['fecha_creado']));
 $igv                = $fetchfactura['igv_total'];
 $total              = $fetchfactura['precio_total'];
 $documento          = ($fetchfactura['id_tipo_documento'] == '1') ? "FACTURA ELECTRONICA" : "BOLETA VENTA ELECTRONICA";
 $Docimpr            = ($fetchfactura['id_tipo_documento'] == '1') ? "RUC" : "DNI";
 $tipdoc             = ($fetchfactura['id_tipo_documento'] == '1') ? "01" : "03";
 $tipdocidentidad    = ($fetchfactura['id_tipo_documento'] == '1') ? "6" : "1";
 $docidencli         = $fetchfactura['n_documento_identidad'];
 $fechaenvio         = $fetchfactura['fecha_envio'];
 $emisor             = $fetchfactura['nombre_cliente'];
 $pasajeroF          = $fetchfactura['id_pasajero'];
 $querypf ="SELECT * FROM tb_cliente where id_cliente='$pasajeroF'";
 $exequerypf =mysqli_query($con,$querypf);
 $respf= mysqli_fetch_array($exequerypf);
 $pasajef =isset($respf['nombre_cliente']) ? $respf['nombre_cliente'] : '';
 $dnipf =isset($respf['n_documento_identidad'])?$respf['n_documento_identidad']:'';
// class Producto
// {

//     public function __construct($nombre, $precio, $cantidad)
//     {
//         $this->nombre   = $nombre;
//         $this->precio   = $precio;
//         $this->cantidad = $cantidad;
//     }
// }
//-----------------------------------------------------------------------------------------------------------------------------
$pdf = new FPDF('P','mm',array(80,190)); 
//$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('logito.png',12,4,50);
$pdf->SetFont('Arial','B',16);
$pdf->Ln(10);
$pdf->setX(1);
$pdf->Cell(70,10,'EXPRESO LIMA S.A.C.',0,1,'C');


 $nombre_sucursal     = $fetchfactura['nombre_sucursal'];
 $id_sucursal_llegada = $fetchfactura['id_sucursal_llegada'];
 $codigo              = $fetchfactura['codigo'];
 $id_tipo             = $fetchfactura['id_tipo'];
 if ($id_tipo == 2) {
     $nombre_cliente = ($tipdoc == "01") ? $fetchfactura['nombre_cliente'] : $fetchfactura['consignatario'];
 } else if ($id_tipo == 3) {
     $nombre_cliente = $fetchfactura['consignatario'];
 } else {
     $nombre_cliente = $fetchfactura['consignatario'];
 }
 if (!empty($codigo)) {
     $count_queryasientoss = mysqli_query($con, "SELECT tb_encomienda_cab.id_consignatario FROM tb_encomienda_cab where tb_encomienda_cab.codigo='" . $codigo . "'");
     $rowasientoss         = mysqli_fetch_array($count_queryasientoss);
     if ($rowasientoss==NULL) {
         $nombre_consignatario="";
     }else{
     $nombre_consignatario = $rowasientoss['id_consignatario'];   
     }
//var_dump($rowasientoss);die();
 }else{
 $nombre_consignatario="";

 }

 $count_queryfacturadet = mysqli_query($con, "SELECT * FROM tb_facturacion_det WHERE id_facturacion = $id_factura ");
 $fetchfacturadet       = mysqli_fetch_array($count_queryfacturadet);

 $ruta = "C:\SFS_v1.3.4.2\sunat_archivos\sfs\FIRMA\\" . $ruc . "-" . $tipdoc . "-" . $n_documento . ".xml";
 //var_dump($ruta);die();
 if (file_exists($ruta)) {
     $idbtn     = "imprimir_ticketera";
     $contenido = nl2br(file_get_contents($ruta));
     $hash      = substr($contenido, 1209, 28);
 }else{
    echo "<script>alert('Debe de generar el XML Primero, Gracias');</script>";
 }

 $resultado = str_replace("-", "|", $n_documento);
 $text = $ruc . "|" . $tipdoc . "|" . $resultado . "|" . $igv . "|" . $total . "|" . $fecha . "|" . $tipdocidentidad . "|" . $docidencli . "|" . $hash;


 $count_queryfacturadet = mysqli_query($con, "SELECT * FROM tb_facturacion_det WHERE id_facturacion = $id_factura ");


// // while ($rowse = mysqli_fetch_array($count_queryfacturadet)) {
// //     $descri      = $rowse['descripccion'];
// //     $productos[] = new Producto($rowse['descripccion'], $rowse['precio_total'], 1);
// // }

 if ($id_tipo == 2) {
     $documentoimprimir = ($tipdoc == "01") ? "Factura de venta electronica" : "Boleta de venta electronica";
     $imprimss          = "Consignatario";
 } else {
     $documentoimprimir = ($tipdoc == "01") ? "Factura de viaje electronica" : "Boleta de viaje electronica";
     $imprimss          = "Pasajero";
 }

// /*
// Ahora vamos a imprimir un encabezado
//  */
 $ndia      = date("w", strtotime($fechaenvio));
 $nmes      = substr($fechaenvio, 5, 2);
 $diadelmes = substr($fechaenvio, 8, 2);
 $años     = substr($fechaenvio, 0, 4);
 $dias      = array("domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
 $meses     = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

 $fechaeniaprint = $dias[$ndia] . ", " . $diadelmes . " " . $meses[intval($nmes - 1)] . ", " . $años;
 $pdf->SetFont('Arial','B',8);
 $pdf->setX(1);
 $pdf->Cell(70,3,$empresa . " - " . $ruc,0,1,'C');
 $pdf->setX(1);
 $pdf->MultiCell(79,3,$direccion_empresa,0,0);
 $pdf->setX(1);
 $pdf->Cell(70,3,"SEDE: " . $nombre_sucursalcab,0,1,'C');
 $pdf->setX(1);
 $pdf->Cell(70,3,"CELULAR: " . $direccion_sucursal,0,1,'C');
 $pdf->setX(1);
 $pdf->Cell(70,3,"PAGINA WEB: WWW.EXPRESOLIMA.COM",0,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,1,"------------------------------------------------------------------------------------",0,1,'C');
$pdf->setX(1);
 $pdf->Cell(70,4,$documento,0,1,'C');
 $pdf->setX(1);
 $pdf->Cell(70,3,$n_documento,0,1,'C');
 $pdf->Cell(60,1,"------------------------------------------------------------------------------------",0,1,'C');
  $pdf->SetFont('Arial','B',9);
  $pdf->setX(5);
 $pdf->Cell(70,3,"Documento : ".$documentoimprimir,0,1,'L');
 //$pdf->Cell(40,5,$documentoimprimir,0,1);
$pdf->setX(5);
$pdf->Cell(70,3,$Docimpr.": ".$docidencli,0,1,'L');
 //$pdf->Cell(40,5,$docidencli ,0,1);
 if ($tipdoc == "01" and $id_tipo == 1) {
      $pdf->setX(5);
     $pdf->Cell(70,5,"Razon Social : ".$emisor ,0,1,'L');
    // $pdf->Cell(40,10,$emisor );
 } else if ($id_tipo == 2) {
     if ($tipdoc == "01") {
          $pdf->setX(5);
         $pdf->Cell(70,5,"Razon Social : ".$emisor,0,1);
     } else {
          $pdf->setX(5);
         $pdf->Cell(70,5,"Remitente : ".$emisor,0,1);
     }
       //$pdf->setX(5);
 //$pdf->Cell(70,10,$emisor);
 }
   $pdf->setX(5);
 $pdf->Cell(70,3,"Fecha - hora : ".$fecha,0,1,'L');
   $pdf->setX(5);
 $pdf->Cell(70,3,"Destino : ".$nombre_sucursal,0,1,'L');
   $pdf->setX(5);
 $pdf->Cell(70,3,"Fecha de Viaje : ".$fechaeniaprint,0,1,'L');
   $pdf->setX(5);
 $pdf->Cell(70,3,"Hora de Viaje : ".$hora_viaje,0,1,'L');

 if ($id_tipo == 1 || $id_tipo == 3) {
     if ($tipdoc == "01") {
        if ($nombre_cliente!="") {
            // code...
        }else{
$pdf->setX(5);
         $pdf->Cell(70,3,"DNI".":".$dnipf,0,1,'L');
        }
        
         //$pdf->Cell(40,10,$dnipf);
           $pdf->setX(5);
         $pdf->MultiCell(50,3,$imprimss . " : ".$pasajef.$nombre_consignatario.$nombre_cliente,0,'L');
         //$pdf->Cell(40,10,$pasajef);
         //$pdf->Cell(40,10,$nombre_consignatario);
     } else {
          $pdf->setX(5);
         $pdf->MultiCell(50,3,$imprimss . " : ".$emisor,0,'L');
         //$pdf->Cell(40,10,$emisor);
     }
 } else if ($id_tipo == 2 && $tipdoc != "01") {
  $pdf->setX(5);
     $pdf->MultiCell(50,3,$imprimss . " : ".$nombre_consignatario.$nombre_cliente,0,'L');
    // $pdf->Cell(40,10,$nombre_consignatario);
 } else {
      $pdf->setX(5);
     $pdf->MultiCell(50,3,$imprimss . " : ".$nombre_cliente.$nombre_consignatario,0,'L');
     //$pdf->Cell(40,10,$nombre_cliente);
     //$pdf->Cell(40,10,$nombre_consignatario);
 }

// /*
// Ahora vamos a imprimir los
// productos
//  */
   $pdf->setX(0);
 $pdf->Cell(70,1,"------------------------------------------------------------------------------------------------",0,1,'L');
   $pdf->setX(5);
 $pdf->Cell(70,3,"Descripcion                                      Precio ",0,1);
   $pdf->setX(0);
  $pdf->Cell(70,1,"-----------------------------------------------------------------------------------------------",0,1,'L');
  $pdf->Ln(2);
  $pdf->setX(5);
  $pdf->MultiCell(40,2,$fetchfacturadet[8]);
  $pdf->Ln(-3);
  $pdf->setX(58);
  $pdf->Cell(60,4,$fetchfacturadet[5],0,1);

// /*Y a la derecha para el importe*/
// //$printer->setJustification(Printer::JUSTIFY_RIGHT);
 //$pdf->Cell(40,10,"Precio");
// # Para mostrar el total
// // foreach ($productos as $producto) {

// //     $pdf->Cell(40,10,$producto->cantidad . "x" . $producto->nombre . "\n");
// //     $pdf->Cell(40,10,' S/.' . $producto->precio . "\n");
// // }

// /*
// Terminamos de imprimir
// los productos, ahora va el total
//  */
   $pdf->setX(0);
$pdf->Cell(70,1,"-----------------------------------------------------------------------------------",0,1,'L');
 if ($id_tipo == 2 && $tipdoc == "01") {
     $pdf->setX(7);
     $pdf->Cell(60,3,"IGV(18%): S/." . $igv,0,1,'R');
 } elseif ($id_tipo == 2 && $tipdoc != "01") {
     $pdf->setX(7);
     $pdf->Cell(60,3,"OP INAFECTA: S/." . $total,0,1,'R');
 } else {
    $pdf->setX(7);
     $pdf->Cell(60,3,"OP EXONERADA: S/." . $total,0,1,'R');
 }
$pdf->setX(7);
 $pdf->Cell(60,3,"TOTAL: S/." . $total,0,1,'R');


// /*
// Podemos poner también un pie de página
//  */
  $pdf->SetFont('Arial','',8);
  $pdf->setX(2);
 $pdf->Cell(70,5,utf8_decode("Muchas gracias por su compra"),0,1,'C');
 $pdf->setX(2);
 $pdf->MultiCell(70,2,utf8_decode("Representación impresa de la factura electronica generada desde el sistema facturador SUNAT.    Puede verificarla utilizando su clave SOL"),0,'J');
 $pdf->Cell(70,2,"-----------------------------------------------------------------------------",0,1,'C');



 if ($id_tipo == 2) {
    $pdf->setX(2);
     $pdf->MultiCell(70,2,utf8_decode("1.- La Empresa no se responsabiliza por deterioro al mal embalaje ni por descomposicion de articulossucesptibles. 2.-Por encomienda o cartas no retiradas dentro de 30 dias 3.- La empresa no se responsabiliza de dinero y cosas de valor no declarado. 4.- El pago de perdida de un bulto se hara de acuerdo a ley. 5.- Una vez firmada la guia es improcedente de todo reclamo."));
 } else {
    $pdf->setX(2);
     $pdf->MultiCell(70,2,utf8_decode("Solo se aceptan como equipajes los que contengan objetos de uso personal corriente no debiendo   contener dinero, joyas y objetos de valor, en   consecuencia la infracción de la cláusula exime a la empresa de todo pago por perdida.  Mayores de 5 años pagan su pasaje.  Obligatorio presentarse media hora antes de la  partida portando su DNI original.  Menor de edad que no viaja con sus padres       presentar autorización notarial y DNI.  Postergaciones con 4 horas de anticipación"));
 }
   $pdf->SetFont('Arial','B',8);
 $pdf->Cell(60,5,"INTRASFERIBLE NO REMBOLSABLE",0,1,'C');

// /*Alimentamos el papel 3 veces*/
// //$printer->feed(3);
// //print_r($printer);
// /*
// Cortamos el papel. Si nuestra impresora
// no tiene soporte para ello, no generará
// ningún error
//  */
// //$printer->cut();

// /*
// Por medio de la impresora mandamos un pulso.
// Esto es útil cuando la tenemos conectada
// por ejemplo a un cajón
//  */
// //$printer->pulse();

// /*
// Para imprimir realmente, tenemos que "cerrar"
// la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
//  */
// //$printer->close();

// //$printer = new Printer($connector);
$pdf->AddPage();
 $pdf->SetFont('Arial','B',9);
$pdf->setX(5);
 $pdf->Cell(70,3,$empresa . " - " . $ruc,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,$documento,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,$n_documento,0,1,'L');
$pdf->setX(5);
 $pdf->Cell(70,3,"Fecha - hora : ".$fecha,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Total Venta :    S/. " . $total,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Destino : ".$nombre_sucursal,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Fecha de Viaje : ".$fechaeniaprint,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Hora de Viaje : ".$hora_viaje,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Descripcion : ".$fetchfacturadet[8],0,1);
 //$pdf->Cell(40,10,$descri);
 if ($id_tipo == 1 || $id_tipo == 3) {
     if ($tipdoc == "01") {
        $pdf->setX(5);
         $pdf->Cell(70,5,"DNI".":".$dnipf,0,1,'L');
         $pdf->setX(5);
         $pdf->MultiCell(50,5,$imprimss . " : ".$pasajef.$nombre_consignatario,0);
         //$pdf->Cell(70,10,$pasajef);
         //$pdf->Cell(70,10,$$nombre_consignatario);
     } else {
          $pdf->setX(5);
          $pdf->MultiCell(50,4,$imprimss . " : ".$emisor,0,'L');
         //$pdf->Cell(70,10,$emisor);
     }
 } else if ($id_tipo == 2 && $tipdoc != "01") {
$pdf->setX(5);
     $pdf->Cell(70,10,$imprimss . " : ".$nombre_consignatario.$nombre_cliente,0,1,'L');
    // $pdf->Cell(70,10,$nombre_consignatario);
 } else {
$pdf->setX(5);
     $pdf->Cell(70,10,"Razon Social : ".$emisor,0,1,'L');
     //$pdf->Cell(70,10,$emisor);
     $pdf->setX(5);
     $pdf->Cell(70,10,$Docimpr . " : ".$docidencli,0,1,'L');
     //$pdf->Cell(70,10,$docidencli);
     $pdf->setX(5);
     $pdf->Cell(70,10,"Consignatario".$nombre_consignatario.$nombre_cliente,0,1,'L');
     //$pdf->Cell(70,10,$nombre_consignatario);
 }

$pdf->setX(0);
 $pdf->Cell(70,10,"CONTROL",0,1,'C');

// // $printer->feed(3);
// // $printer->cut();
// // $printer->close();

$pdf->AddPage();
 $pdf->SetFont('Arial','B',9);
$pdf->setX(5);
 $pdf->Cell(70,3,$empresa . " - " . $ruc,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,$documento,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,$n_documento,0,1,'L');
$pdf->setX(5);
 $pdf->Cell(70,3,"Fecha - hora : ".$fecha,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Total Venta :    S/. " . $total,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Destino : ".$nombre_sucursal,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Fecha de Viaje : ".$fechaeniaprint,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Hora de Viaje : ".$hora_viaje,0,1,'L');
 $pdf->setX(5);
 $pdf->Cell(70,3,"Descripcion : ".$fetchfacturadet[8],0,1);
 //$pdf->Cell(40,10,$descri);
 if ($id_tipo == 1 || $id_tipo == 3) {
     if ($tipdoc == "01") {
        $pdf->setX(5);
         $pdf->Cell(70,5,"DNI".":".$dnipf,0,1,'L');
         $pdf->setX(5);
         $pdf->MultiCell(40,5,$imprimss . " : ".$pasajef.$nombre_consignatario.$nombre_cliente,0);
         //$pdf->Cell(70,10,$pasajef);
         //$pdf->Cell(70,10,$$nombre_consignatario);
     } else {
          $pdf->setX(5);
         $pdf->MultiCell(50,4,$imprimss . " : ".$emisor,0,'L');
         //$pdf->Cell(70,10,$emisor);
     }
 } else if ($id_tipo == 2 && $tipdoc != "01") {
$pdf->setX(5);
     $pdf->Cell(70,10,$imprimss . " : ".$nombre_consignatario.$nombre_cliente,0,1,'L');
    // $pdf->Cell(70,10,$nombre_consignatario);
 } else {
$pdf->setX(5);
     $pdf->Cell(70,10,"Razon Social : ".$emisor,0,1,'L');
     //$pdf->Cell(70,10,$emisor);
     $pdf->setX(5);
     $pdf->Cell(70,10,$Docimpr . " : ".$docidencli,0,1,'L');
     //$pdf->Cell(70,10,$docidencli);
     $pdf->setX(5);
     $pdf->Cell(70,10,"Consignatario".$nombre_consignatario.$nombre_cliente,0,1,'L');
     //$pdf->Cell(70,10,$nombre_consignatario);
 }

$pdf->setX(0);
 $pdf->Cell(70,10,"CONTROL",0,1,'C');
$pdf->Output();
?>