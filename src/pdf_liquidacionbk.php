<?php 

require_once 'dompdf/autoload.inc.php';
 // error_reporting(0);

  use Dompdf\Dompdf;
  session_start();

  require_once ('config/db.php');//Contiene las variables de configuracion para conectar a la base de datos
  require_once ('config/conexion.php');//Contiene funcion que conecta a la base de datos

  $id_liquidacion = $_GET['id'];
  $query   = mysqli_query($con, "SELECT * FROM tb_liquidacion WHERE id_liquidacion = $id_liquidacion");
  $data= mysqli_fetch_array($query);
  //var_dump($data);die();


  $oficina = $data['su_inicio']; 
  $detino = $data['sucu_fin']; 
  $bus = $data['nombre_bus']; 

  $totalliquidacion = $data['importe_total'] - $data['gastos'];


$html = '
<body style=" font-family: Arial;">
    <table style="width: 100%; background-color: white; text-align: left;border-collapse: collapse;border: 1px solid black;">

        <tr>
          <th rowspan="3" style="width: 15%;text-align: right;padding-right: 15px;"><img src="img/bus.png" style="width: 80px !important;"></th>
          <th colspan="5" style="width: 85%;font-size: 22px; letter-spacing: 1px;">Emp. de trasporte "HUARI TOURS" S.A.C</th>
        </tr>
        <tr>
          <td></td>
          <td style="text-align: left;" colspan="3" style="width: 50%;">Jr. Isidro Alcibar 735 Lima Telf: 482-3239</td>
          <td colspan="1" style="width: 5%;color: red;">N° '.str_pad($id_liquidacion,  6, "0", STR_PAD_LEFT).'</td>
        </tr>
        <tr>
          <th colspan="5" style="width: 85%;">LIQUIDACION DE PASAJES, ENCOMIENDAS Y EXCESOS</th>
        </tr>
       <tr>
          <th colspan="6"><hr style=""></th>
        </tr>
        
        <tr>
          <td colspan="2" style="width: 34%;padding-bottom: 10px !important">&nbsp;&nbsp;OFICINA: '.$oficina.'</td>
          <td colspan="2" style="width: 34%;padding-bottom: 10px !important">DESTINO: GERENCIA</td>
          <td colspan="2" style="width: 34%;padding-bottom: 10px !important">BUS: '.$bus.'</td>
        </tr>


        <tr>
          <th style="width: 17%;border: 1px solid black;border-collapse: collapse;">BOLETO Nro</th>
          <th style="width: 17%;border: 1px solid black;border-collapse: collapse;">IMPORTE</th>
          <th style="width: 17%;border: 1px solid black;border-collapse: collapse;">Nro. GUIA</th>
          <th style="width: 17%;border: 1px solid black;border-collapse: collapse;">IMPORTE</th>
          <th style="width: 17%;border: 1px solid black;border-collapse: collapse;">EXCESO</th>
          <th style="width: 17%;border: 1px solid black;border-collapse: collapse;">IMPORTE</th>
        </tr>';

       
      $sqltabledet=mysqli_query($con, "SELECT * FROM tb_facturacion_cab WHERE si_liquidacion = $id_liquidacion");
      $val = 0;
//var_dump($sqltabledet);die();
       while ($rows=mysqli_fetch_array($sqltabledet)){
       	//var_dump($rows); die();
          //$array_cab[] = $rows;

          if (substr($rows['n_documento'],0,2) == 'FV' || substr($rows['n_documento'],0,2) == 'BV'){
             $array_fac[] = $rows;
          }else{
             $array_enc[] = $rows;
          }
           $val++; 
       } 
       var_dump(count($array_enc));die();
       if (count($array_fac) > count($array_enc)) {
          $recorrigo = count($array_fac);
       }else{
          $recorrigo = count($array_enc);
       }
      $key = 0; $tbus = 0; $tguia = 0;
      for ($i = 1; $i <= $recorrigo; $i++) {
          $nbus = (isset($array_fac[$key]['n_documento'])) ? $array_fac[$key]['n_documento'] : "";
          $pbus = (isset($array_fac[$key]['precio_total'])) ? $array_fac[$key]['precio_total'] : "";
          $tbus += $pbus;
          $nguia = (isset($array_enc[$key]['n_documento'])) ? $array_enc[$key]['n_documento'] : "";
          $pguia = (isset($array_enc[$key]['precio_total'])) ? $array_enc[$key]['precio_total'] : "";
          $tguia += $pguia;
  
          $html.= '
              <tr>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$nbus.'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$pbus.'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$nguia.'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;">'.$pguia.'</td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;"></td>
                <td style="text-align:center; border: 1px solid black;border-collapse: collapse;"></td>
              </tr>';
          $key++;
      }

      $val_fin = 31 - $val;
      for ($i = 1; $i <= $val_fin; $i++) {
          $html.= '
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;">&nbsp;</td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
                <td style="border: 1px solid black;border-collapse: collapse;"></td>
              </tr>';
      }
    
    $html .= '<tr>
      <td style="border: 1px solid black;border-collapse: collapse;text-align: center;">IMP.TOTAL</td>
      <td style="text-align:center; border: 1px solid black;border-collapse: collapse;background-color: #E8E8E8">'.number_format($tbus, 2 , '.', '').'</td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align: center;">IMP.TOTAL</td>
      <td style="text-align:center; border: 1px solid black;border-collapse: collapse;background-color: #E8E8E8">'.number_format($tguia, 2 , '.', '').'</td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align: center;">IMP.TOTAL</td>
      <td style="border: 1px solid black;border-collapse: collapse;background-color: #E8E8E8"></td>

    </tr>
    <tr>
      <td style="padding-top: 10px !important;" colspan="2">&nbsp; &nbsp; FECHA: '. date("m-d-Y", strtotime($data['fecha_creado'])).'</td>
      <td style="padding-top: 10px !important;">TOTAL: '.$data['importe_total'].'</td>
      <td style="padding-top: 10px !important;text-align: right; padding-right: 35px;" colspan="3">TOTAL LIQUIDACION: '.number_format($totalliquidacion, 2 , '.', '').'</td>
     
    </tr>
    <tr>
      <td colspan="2"></td>
      <td colspan="2" style="padding-top: 5px !important;">COMISION: '.$data['porcentaje'].' % - ('. $data['n_porcentaje'].')</td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td colspan="2"></td>
      <td colspan="2" style="padding-top: 5px !important;">GASTOS: '.$data['gastos'].'</td>
      <td colspan="2"></td>
    </tr>
    <tr>
          <th colspan="6">&nbsp;</th>
    </tr>
    <tr>
      <td colspan="2" style="padding-left: 75px;">____________________</td>
      <td></td>
      <td colspan="2" style="padding-left: 75px;">____________________</td>
      <td></td>
    </tr>
    <tr>
      <td colspan="2" style="padding-left: 120px;">OFICINA</td>
      <td></td>
      <td colspan="2" style="padding-left: 120px;">CONTROL</td>
      <td></td>
    </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
  

    </table>
</body>';

// echo $html;die();

$domdpdf = new Dompdf();


$domdpdf->loadHtml($html);
$domdpdf->setPaper('A4', 'portrait');
$domdpdf->render();
$pdf = $domdpdf->output();
$domdpdf->stream($rowfac['n_documento'], array('Attachment' =>0));
