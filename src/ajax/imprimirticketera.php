<?php
require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;


/*
Este ejemplo imprime un
ticket de venta desde una impresora térmica
 */
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../config/db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../config/conexion.php"; //Contiene funcion que conecta a la base de datos

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

$id_factura = intval($_GET['id_factura']);

$campos             = "tb_facturacion_cab.n_documento , tb_facturacion_cab.fecha_creado , tb_facturacion_cab.id_pasajero,tb_facturacion_cab.igv_total, tb_facturacion_cab.precio_total , tb_facturacion_cab.id_tipo_documento ,tb_cliente.n_documento_identidad, tb_facturacion_cab.fecha_envio, tb_cliente.nombre_cliente, tb_sucursales.nombre_sucursal,tb_facturacion_cab.id_sucursal_llegada, tb_facturacion_cab.codigo, tb_facturacion_cab.id_tipo, tb_facturacion_cab.consignatario";
$count_queryfactura = mysqli_query($con, "SELECT $campos FROM tb_facturacion_cab, tb_cliente, tb_sucursales WHERE tb_facturacion_cab.id_sucursal_llegada = tb_sucursales.id_sucursal and tb_cliente.id_cliente = tb_facturacion_cab.id_cliente and id_facturacion = $id_factura ");
$fetchfactura       = mysqli_fetch_array($count_queryfactura);
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
$pasajef =$respf['nombre_cliente'];
$dnipf =$respf['n_documento_identidad'];

if ($id_tipo == 2) {
    $nombre_cliente = ($tipdoc == "01") ? $fetchfactura['nombre_cliente'] : $fetchfactura['consignatario'];
} else if ($id_tipo == 3) {
    $nombre_cliente = $fetchfactura['consignatario'];
} else {
    $nombre_cliente = $fetchfactura['consignatario'];
}

$nombre_sucursal     = $fetchfactura['nombre_sucursal'];
$id_sucursal_llegada = $fetchfactura['id_sucursal_llegada'];
$codigo              = $fetchfactura['codigo'];
$id_tipo             = $fetchfactura['id_tipo'];

if (!empty($codigo)) {
    $count_queryasientoss = mysqli_query($con, "SELECT tb_encomienda_cab.id_consignatario FROM tb_encomienda_cab where tb_encomienda_cab.codigo='" . $codigo . "'");
    $rowasientoss         = mysqli_fetch_array($count_queryasientoss);
    $nombre_consignatario = $rowasientoss['id_consignatario'];
}

//$count_querysucursalllegada   = mysqli_query($con, "SELECT * FROM tb_sucursales WHERE id_sucursal = $id_sucursal_llegada ");
//$fetchsucursalllegada= mysqli_fetch_array($count_querysucursalllegada);
//$hora_viaje = date('h:i:s a', strtotime($fetchsucursalllegada['hora_viaje']));
//print_r($hora_viaje);die();
$count_queryfacturadet = mysqli_query($con, "SELECT * FROM tb_facturacion_det WHERE id_facturacion = $id_factura ");
$fetchfacturadet       = mysqli_fetch_array($count_queryfacturadet);

$ruta = "C:\SFS_v1.3.4.2\sunat_archivos\sfs\FIRMA\\" . $ruc . "-" . $tipdoc . "-" . $n_documento . ".xml";
if (file_exists($ruta)) {
    $idbtn     = "imprimir_ticketera";
    $contenido = nl2br(file_get_contents($ruta));
    $hash      = substr($contenido, 1209, 28);}

include "../phpqrcode/qrlib.php";
$resultado = str_replace("-", "|", $n_documento);
//$text=$ruc."|"."01|F001|00000001|IGV|TOTAL|FECHA|6|RUC_CLIENTE|hibl4oMU3ow8hKcL9a0xfC9uXUE=';
$text = $ruc . "|" . $tipdoc . "|" . $resultado . "|" . $igv . "|" . $total . "|" . $fecha . "|" . $tipdocidentidad . "|" . $docidencli . "|" . $hash;
//QRcode::png($text, "10447915125-F001-00000001.png", 'Q',15, 0);

QRcode::png($text, $sucursal . "qr.png", QR_ECLEVEL_L, 5, 4);

/*
Una pequeña clase para
trabajar mejor con
los productos
Nota: esta clase no es requerida, puedes
imprimir usando puro texto de la forma
que tú quieras
 */
class Producto
{

    public function __construct($nombre, $precio, $cantidad)
    {
        $this->nombre   = $nombre;
        $this->precio   = $precio;
        $this->cantidad = $cantidad;
    }
}

/*
Vamos a simular algunos productos. Estos
podemos recuperarlos desde $_POST o desde
cualquier entrada de datos. Yo los declararé
aquí mismo
 */

$count_queryfacturadet = mysqli_query($con, "SELECT * FROM tb_facturacion_det WHERE id_facturacion = $id_factura ");
//$count_queryfacturadetsucu   = mysqli_query($con, "SELECT * FROM tb_encomienda_det WHERE codigo = $codigo ");
//    $fetchfacturadet= mysqli_fetch_array($count_queryfacturadet);

//$productos = array();

while ($rowse = mysqli_fetch_array($count_queryfacturadet)) {
    $descri      = $rowse['descripccion'];
    $productos[] = new Producto($rowse['descripccion'], $rowse['precio_total'], 1);

}

//new Producto("Pringles", 22, 2),
/*
El nombre del siguiente producto es largo
para comprobar que la librería
bajará el texto por nosotros en caso de
que sea muy largo
 */
//new Producto("Galletas saladas con un sabor muy salado y un precio excelente", 10, 1.5),

/*
Aquí, en lugar de "POS-58" (que es el nombre de mi impresora)
escribe el nombre de la tuya. Recuerda que debes compartirla
desde el panel de control
 */

$nombre_impresora = "POS-80";
//TermicaImpresora

$connector = new WindowsPrintConnector($nombre_impresora);
$printer   = new Printer($connector);

/*
Vamos a imprimir un logotipo
opcional. Recuerda que esto
no funcionará en todas las
impresoras

Pequeña nota: Es recomendable que la imagen no sea
transparente (aunque sea png hay que quitar el canal alfa)
y que tenga una resolución baja. En mi caso
la imagen que uso es de 250 x 250
 */

# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);

if ($id_tipo == 2) {
    $documentoimprimir = ($tipdoc == "01") ? "Factura de venta electronica" : "Boleta de venta electronica";
    $imprimss          = "Consignatario";
} else {
    $documentoimprimir = ($tipdoc == "01") ? "Factura de viaje electronica" : "Boleta de viaje electronica";
    $imprimss          = "Pasajero";
}

/*
Ahora vamos a imprimir un encabezado
 */
$ndia      = date("w", strtotime($fechaenvio));
$nmes      = substr($fechaenvio, 5, 2);
$diadelmes = substr($fechaenvio, 8, 2);
$años     = substr($fechaenvio, 0, 4);
$dias      = array("domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
$meses     = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$fechaeniaprint = $dias[$ndia] . ", " . $diadelmes . " " . $meses[intval($nmes - 1)] . ", " . $años;
//print_r($fechaeniaprint);die();

$printer->text($empresa . " - " . $ruc . "\n");
$printer->text($direccion_empresa . "\n");
$printer->text("\n");
$printer->text("SEDE: " . $nombre_sucursalcab . "\n");
$printer->text("CELULAR: " . $direccion_sucursal . "\n");
$printer->text("PAGINA WEB: WWW.HUARITOURS.COM");

$printer->text("\n");
$printer->text($documento . "\n");
$printer->text($n_documento . "\n");
$printer->text("\n");

$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Documento : ");
$printer->text($documentoimprimir . "\n");
$printer->text($Docimpr . " : ");
$printer->text($docidencli . "\n");
if ($tipdoc == "01" and $id_tipo == 1) {
    $printer->text("Razon Social : ");
    $printer->text($emisor . "\n");
} else if ($id_tipo == 2) {
    if ($tipdoc == "01") {
        $printer->text("Razon Social : ");
    } else {
        $printer->text("Remitente : ");
    }

    $printer->text($emisor . "\n");
}
$printer->text("Fecha - hora : ");
$printer->text($fecha . "\n");
$printer->text("Destino : ");
$printer->text($nombre_sucursal . "\n");
$printer->text("Fecha de Viaje : ");
$printer->text($fechaeniaprint . "\n");
$printer->text("Hora de Viaje : ");
$printer->text($hora_viaje . "\n");
//$printer->text($Docimpr." : ");
//$printer->text($docidencli . "\n");
/*if ($id_tipo == 2 && $tipdoc != "01" ) {

$printer->text($Docimpr." : ");
$printer->text($docidencli . "\n");
}*/
if ($id_tipo == 1 || $id_tipo == 3) {
    if ($tipdoc == "01") {
        $printer->text("DNI".":");
        $printer->text($dnipf."\n");
        $printer->text($imprimss . " : ");
        $printer->text($pasajef . "\n");
        $printer->text($nombre_consignatario . "\n");
    } else {
        $printer->text($imprimss . " : ");
        $printer->text($emisor . "\n");
    }
} else if ($id_tipo == 2 && $tipdoc != "01") {

    $printer->text($imprimss . " : ");
    $printer->text($nombre_consignatario . "\n");
} else {
    $printer->text($imprimss . " : ");
    $printer->text($nombre_cliente . "\n");
    //$printer->text("Consignatario" . "\n");
    $printer->text($nombre_consignatario . "\n");
}

$printer->text("\n");
$printer->text("\n");

/*
Ahora vamos a imprimir los
productos
 */
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Descripcion                               ");

/*Y a la derecha para el importe*/
//$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("Precio" . "\n");
# Para mostrar el total
foreach ($productos as $producto) {

    /*Alinear a la izquierda para la cantidad y el nombre*/
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text($producto->cantidad . "x" . $producto->nombre . "\n");

    /*Y a la derecha para el importe*/
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text(' S/.' . $producto->precio . "\n");
}

/*
Terminamos de imprimir
los productos, ahora va el total
 */
$printer->text("\n");
if ($id_tipo == 2 && $tipdoc == "01") {
    $printer->text("IGV(18%): S/." . $igv . "\n");
} elseif ($id_tipo == 2 && $tipdoc != "01") {
    $printer->text("OP INAFECTA: S/." . $total . "\n");
} else {
    $printer->text("OP EXONERADA: S/." . $total . "\n");
}

$printer->text("TOTAL: S/." . $total . "\n");

/*
Intentaremos cargar e imprimir
el logo
 */
$printer->setJustification(Printer::JUSTIFY_CENTER);
try {
    $logo = EscposImage::load($sucursal . "qr.png", false);
    $printer->bitImage($logo);
} catch (Exception $e) { /*No hacemos nada si hay error*/}

/*
Podemos poner también un pie de página
 */
$printer->text("\n");
$printer->text("Muchas gracias por su compra");
$printer->text("\n");
$printer->text("\n");
$printer->text("Representación impresa de la factura electronica generada desde el sistema facturador SUNAT.    Puede verificarla utilizando su clave SOL");
$printer->text("\n");
$printer->text("----------------------------------------------");
$printer->text("\n");

$printer->setJustification(Printer::JUSTIFY_LEFT);

if ($id_tipo == 2) {
    $printer->text("1.- La Empresa no se responsabiliza por deterioro al mal embalaje ni por descomposicion de articulossucesptibles. 2.-Por encomienda o cartas no retiradas dentro de 30 dias 3.- La empresa no se responsabiliza de dinero y cosas de valor no declarado. 4.- El pago de perdida de un bulto se hara de acuerdo a ley. 5.- Una vez firmada la guia es improcedente de todo reclamo.");
} else {
    $printer->text("Solo se aceptan como equipajes los que contengan objetos de uso personal corriente no debiendo   contener dinero, joyas y objetos de valor, en   consecuencia la infracción de la cláusula exime a la empresa de todo pago por perdida. \n Mayores de 5 años pagan su pasaje. \n Obligatorio presentarse media hora antes de la  partida portando su DNI original. \n Menor de edad que no viaja con sus padres       presentar autorización notarial y DNI. \n Postergaciones con 4 horas de anticipación \n");
}
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("\n");
$printer->text("INTRASFERIBLE NO REMBOLSABLE");

/*Alimentamos el papel 3 veces*/
$printer->feed(3);
//print_r($printer);
/*
Cortamos el papel. Si nuestra impresora
no tiene soporte para ello, no generará
ningún error
 */
$printer->cut();

/*
Por medio de la impresora mandamos un pulso.
Esto es útil cuando la tenemos conectada
por ejemplo a un cajón
 */
$printer->pulse();

/*
Para imprimir realmente, tenemos que "cerrar"
la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
 */
$printer->close();

$printer = new Printer($connector);

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text($empresa . " - " . $ruc . "\n");
$printer->text($documento . "\n");
$printer->text($n_documento . "\n");
$printer->text("\n");

$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Fecha - hora : ");
$printer->text($fecha . "\n");
$printer->text("Total Venta : ");
$printer->text("S/. " . $total . "\n");
$printer->text("Destino : ");
$printer->text($nombre_sucursal . "\n");
$printer->text("Fecha de Viaje : ");
$printer->text($fechaeniaprint . "\n");
$printer->text("Hora de Viaje : ");
$printer->text($hora_viaje . "\n");
$printer->text("Descripcion : ");
$printer->text($descri . "\n");
if ($id_tipo == 1 || $id_tipo == 3) {
    if ($tipdoc == "01") {
        $printer->text("DNI".":");
        $printer->text($dnipf."\n");
        $printer->text($imprimss . " : ");
        $printer->text($pasajef . "\n");
        $printer->text($$nombre_consignatario . "\n");
    } else {
        $printer->text($imprimss . " : ");
        $printer->text($emisor . "\n");
    }
} else if ($id_tipo == 2 && $tipdoc != "01") {

    $printer->text($imprimss . " : ");
    $printer->text($nombre_consignatario . "\n");
} else {

    $printer->text("Razon Social : ");
    $printer->text($emisor . "\n");
    $printer->text($Docimpr . " : ");
    $printer->text($docidencli . "\n");
    $printer->text("Consignatario" . "\n");
    $printer->text($nombre_consignatario . "\n");
}

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("\n");
$printer->text("CONTROL");

$printer->feed(3);
$printer->cut();
$printer->close();

$printer = new Printer($connector);

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text($empresa . " - " . $ruc . "\n");
$printer->text($documento . "\n");
$printer->text($n_documento . "\n");
$printer->text("\n");

$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Fecha - hora : ");
$printer->text($fecha . "\n");
$printer->text("Total Venta : ");
$printer->text("S/. " . $total . "\n");
$printer->text("Destino : ");
$printer->text($nombre_sucursal . "\n");
$printer->text("Fecha de Viaje : ");
$printer->text($fechaeniaprint . "\n");
$printer->text("Hora de Viaje : ");
$printer->text($hora_viaje . "\n");
$printer->text("Descripcion : ");
$printer->text($descri . "\n");
if ($id_tipo == 1 || $id_tipo == 3) {
    if ($tipdoc == "01") {
        $printer->text("DNI".":");
        $printer->text($dnipf."\n");
        $printer->text($imprimss . " : ");
        $printer->text($pasajef . "\n");
        $printer->text($$nombre_consignatario . "\n");
    } else {
        $printer->text($imprimss . " : ");
        $printer->text($emisor . "\n");
    }
} else if ($id_tipo == 2 && $tipdoc != "01") {

    $printer->text($imprimss . " : ");
    $printer->text($nombre_consignatario . "\n");
} else {
    $printer->text("Razon Social : ");
    $printer->text($emisor . "\n");
    $printer->text($Docimpr . " : ");
    $printer->text($docidencli . "\n");
    $printer->text("Consignatario" . "\n");
    $printer->text($nombre_consignatario . "\n");
}

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("\n");
$printer->text("CONTROL");

$printer->feed(3);
$printer->cut();
$printer->close();

