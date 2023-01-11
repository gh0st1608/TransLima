<?php 

require_once 'dompdf/autoload.inc.php';


  use Dompdf\Dompdf;
  session_start();

  require_once ('config/db.php');//Contiene las variables de configuracion para conectar a la base de datos
  require_once ('config/conexion.php');//Contiene funcion que conecta a la base de datos

  // $id_liquidacion = $_GET['id'];
  $fecha = $_GET['fecha'];
  $idbus = $_GET['idbus'];
  $n_idbus = $_GET['n_idbus'];
  // $sucu = $_GET['sucu'];

  $unomas = $_GET['correlativo_'] + 1;
  $updates=mysqli_query($con, "UPDATE correlativos SET correlativo=$unomas WHERE id_correlativo=1 ");

  $oficina = $_SESSION['sucursal'];
  $detino = "HUARI";//$_GET['n_sucu'];
 
  // $queryquery = "SELECT * FROM tb_sucursales where id_sucursal =".$_SESSION['idsucursal'];
  // $query   = mysqli_query($con, $queryquery);
  // $row= mysqli_fetch_array($query);
  // $direccion = $row['direccion_real'];

  $queryquery1 = "SELECT count(*) total FROM tb_buses_det where id_bus =".$_GET['idbus'];
  $query1   = mysqli_query($con, $queryquery1);
  $row1= mysqli_fetch_array($query1);
  $total = $row1['total'];





  // print_r($queryquery);die();

$html = '
<style>
@page {
            margin-top: 0.3em;
            margin-left: 0.6em;
            margin-right: 0.6em;
            margin-bottom: 0.1em;
        }
</style>
<body style=" font-family: Arial;">
    

    <table style="width: 100%; text-align:center; border-collapse: collapse;border: 1px solid black; font-size:15px;">';
    //50 es Huari - 51 Infantas
    //por defecto saldra de infantas
    $serie = ($_SESSION['idsucursal'] == 50 ) ? '004' : '005';
    $direccion_ = ($_SESSION['idsucursal'] == 50 ) ? 'Jr. Ancash 848-Huari-Ancash' : 'Av. 25 de Enero lote 5 -Urb. Santa Luisa -Infantas';
     

      $html.='<tr style="border: 1px solid black;">
        <td width="13%" rowspan="4"><img style="margin-left:15px; width: 70px;" src="img/bus.png"></td>
        <td width="60%" >EMPRESA DE TRASNPORTE "HUARI TOURS"</td>
        <td width="28%" style="border-collapse: collapse; border: 1px solid black; border-top-left-radius: 400px;">  R.U.C 20601621241</td>
      </tr>
       <tr >
        <td style="font-size:12px;">Av. Independencia N° 1173 Dpto. 301 Magdalena del Mar - Lima - Lima </td>
        <td rowspan="2" style="    background: #cfc8d0; border-collapse: collapse;border: 1px solid black;">MANIFIESTO DE PASAJEROS</td>
      </tr>
       <tr >
        <td style="font-size:12px;">'.$direccion_.'</td>
      </tr>
       <tr >
        <td  style="font-size:12px;">Tlf.: 555-5555  Cel.: 999999999</td>
        <td style="border-collapse: collapse;border: 1px solid black;">'.$serie.' - <span style="color:red; ">N°'.str_pad($_GET["correlativo_"],8,"0", STR_PAD_LEFT).'<span></td>
      </tr>



     
     
        </table>
        <table style="width: 99.2%; background-color: white; font-size:9px; text-align: left;border-collapse: collapse;border: 1px solid black;">
                <tr>
                  <td style="">FECHA:</td>
                  <td>'.$_GET["fecha"].'</td>
                  <td style="width: 100px;">HORA DE SALIDA:</td>
                  <td>04:00 PM</td>
                  <td colspan="2">Tarjeta de Circulación N°:</td>
                  <td colspan="2">'.$_GET["tarjeta"].'</td>
                </tr>
                <tr>
                  <td>MARCA:</td>
                  <td>Mercedez Benz</td>
                  <td>PLACA:</td>
                  <td>'.$_GET["n_idbus"].'</td>
                  <td width="50px" style="">ORIGEN:</td>
                  <td>'.$_GET["origen"].'</td>
                  <td width="50px;">DESTINO:</td>
                  <td style="" width="90px;">'.$_GET["destino"].'</td>
                </tr> 
                <tr>
                  <td style="" width="90px;">CAP. DE ASIENTOS:</td>
                  <td>'.$total.'</td>
                  <td width="20px">ASIENTOS DE TIP:</td>
                  <td>3</td>
                  <td>PILOTO:</td>
                  <td style="" width="120px;">'.$_GET["piloto"].'</td>
                  <td>L.C.:</td>
                  <td>'.$_GET["lc_piloto"].'</td>
                </tr> 
                <tr>
                  <td>COPILOTO:</td>
                  <td style="" width="120px;">'.$_GET["copiloto"].'</td>
                  <td>L.C.:</td>
                  <td style="" width="50px">'.$_GET["lc_copiloto"].'</td>
                  <td>AUXILIAR:</td>
                  <td>'.$_GET["axiliar"].'</td>
                  <td>D.N.I.:</td>
                  <td>'.$_GET["dni_axiliar"].'</td>
                </tr> 
        </table>

        <table style="width: 100%; font-size:9px;  text-align: center;border-collapse: collapse;border: 1px solid black;">
       


     

     
        <tr style="">
          <th style="background-color:LemonChiffon; width: 5%; border: 1px solid black;border-collapse: collapse;" rowspan="2">N°</th>
          <th style="background-color:LemonChiffon; width: 30% border: 1px solid black;border-collapse: collapse;"rowspan="2">Nombres Y Apellidos</th>
          <th style="background-color:LemonChiffon; width: 5%; border: 1px solid black;border-collapse: collapse;"rowspan="2">Edad</th>
          <th style="background-color:LemonChiffon; width: 10%; border: 1px solid black;border-collapse: collapse;" rowspan="2">N° Doc.</th>
          <th style="background-color:LemonChiffon; width: 5%; border: 1px solid black;border-collapse: collapse;" rowspan="2">Tipo Doc.</th>
          <th style="background-color:LemonChiffon; width: 5%; border: 1px solid black;border-collapse: collapse;" rowspan="2">Asiento</th>
          <th style="background-color:LemonChiffon; width: 10%; border: 1px solid black;border-collapse: collapse;" rowspan="2">Destino</th>
          <th style="background-color:LemonChiffon; width: 5%; border: 1px solid black;border-collapse: collapse;"  colspan="2">N° Boleto</th>
          <th style="background-color:LemonChiffon; width: 5%; border: 1px solid black;border-collapse: collapse;" rowspan="2">Importe</th>
        </tr>

        <tr style="">
          <th style="background-color:LemonChiffon; width: 5%; border: 1px solid black;border-collapse: collapse;">Serie</th>
          <th style="background-color:LemonChiffon; width: 5%; border: 1px solid black;border-collapse: collapse;">Numero</th>
        </tr>

        ';

     
      $queryquery = "SELECT SUBSTRING(a.n_documento,1,4) serie,SUBSTRING(a.n_documento,6,13) numero,SUBSTRING(b.descripccion,8,1) piso, SUBSTRING(b.descripccion,19,3) asiento,su.nombre_sucursal, d.id_tipo_persona, case when d.id_tipo_persona = '2' then e.edad else d.edad end edad, b.descripccion, case when d.id_tipo_persona = '2' then e.nombre_cliente else d.nombre_cliente end nombre_cliente, case when d.id_tipo_persona = '2' then e.n_documento_identidad else d.n_documento_identidad end n_documento_identidad, a.n_documento, a.precio_total  FROM tb_facturacion_cab a
    left join tb_facturacion_det b on a.id_facturacion = b.id_facturacion
    left join tb_cliente d on a.id_cliente = d.id_cliente
    left join tb_cliente e on a.id_pasajero = e.id_cliente
    left join tb_sucursales su on su.id_sucursal = a.id_sucursal_llegada
    where  a.fecha_envio = '$fecha 00:00:00' and a.id_bus = $idbus and a.id_tipo != 2 ORDER BY piso,asiento";
    // print_r($queryquery);die();
      $query   = mysqli_query($con, $queryquery);


      $corr = 0;
      while ($rows=mysqli_fetch_array($query)){
        $data_print[] = $rows;
      } 
       


       foreach ($data_print as $key => $value) {
          $corr++;
          //$tipo = ($value['id_tipo_persona'] == '1' ) ? "DNI" : "RUC";
          $tipo = "DNI";
          $html.= '
              <tr>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$corr.'</td>
                <td style="text-align:left; border: 1px solid black;border-collapse: collapse;">'.strtolower($value["nombre_cliente"]).'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$value["edad"].'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$value["n_documento_identidad"].'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$tipo.'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$value['asiento'].'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$value['nombre_sucursal'].'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$value["serie"].'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$value["numero"].'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$value["precio_total"].'</td>
              </tr>';
       }


      $val_fin = 66 - $corr;
      for ($i = 1; $i <= $val_fin; $i++) {
        $corr++;
          $html.= '
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;">'.$corr.'</td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
              </tr>';
      }
    
    $html .= '
     
  

        <tr>
      <td colspan="10">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" style="">____________</td>
      <td colspan="4" style="">____________</td>
       <td colspan="3" style="">____________</td>
    </tr>

    <tr>
      <td colspan="3" style="">OFICINA</td>
      <td colspan="4" style="">CONTROL</td>
      <td colspan="3" style="">CONTROL</td>
    </tr>
    <tr>
      <td colspan="10">&nbsp;</td>
    </tr>

    </table>
</body>';

//echo $html;die();

$domdpdf = new Dompdf();


$domdpdf->loadHtml($html);
$domdpdf->setPaper('legal', 'portrait');
$domdpdf->render();
$pdf = $domdpdf->output();
$domdpdf->stream($rowfac['n_documento'], array('Attachment' =>0));
