<?php 

require_once 'dompdf/autoload.inc.php';


  use Dompdf\Dompdf;
  //session_start();

  require_once ('config/db.php');//Contiene las variables de configuracion para conectar a la base de datos
  require_once ('config/conexion.php');//Contiene funcion que conecta a la base de datos

 
  session_unset($_SESSION['array_repo']);
  $_SESSION['array_repo'] = array();
  $fecha = $_GET['fecha'];
  $idbus = $_GET['idbus'];
  $n_idbus = $_GET['n_idbus'];

  $query   = mysqli_query($con, "SELECT b.descripccion, d.nombre_cliente, d.n_documento_identidad, a.n_documento, c.nombre_sucursal  FROM tb_facturacion_cab a
left join tb_facturacion_det b on a.id_facturacion = b.id_facturacion
left join tb_sucursales c on a.id_sucursal = c.id_sucursal
left join tb_cliente d on a.id_cliente = d.id_cliente
where  a.fecha_envio = '$fecha 00:00:00' and a.id_bus = $idbus");

    $query_cab   = mysqli_query($con, "SELECT COUNT(c.nombre_sucursal) as cantidad , c.nombre_sucursal FROM tb_facturacion_cab a
left join tb_facturacion_det b on a.id_facturacion = b.id_facturacion
left join tb_sucursales c on a.id_sucursal = c.id_sucursal
left join tb_cliente d on a.id_cliente = d.id_cliente
where  a.fecha_envio = '$fecha 00:00:00' and a.id_bus = $idbus GROUP BY c.nombre_sucursal");

  $key = 0;
  while ($rows=mysqli_fetch_array($query)){
          $_SESSION['array_repo'][] = $rows; 
          $_SESSION['array_repo'][$key]['asiento'] = substr($rows['descripccion'], -2, 2);
          $_SESSION['array_repo'][$key]['piso'] = substr($rows['descripccion'], -14, 1);
          $key++;
  } 
  $sucus = "";
  while ($rows_cab=mysqli_fetch_array($query_cab)){
         $sucus .= $rows_cab['nombre_sucursal'].": ". $rows_cab['cantidad']."  &nbsp;&nbsp;"; 
  } 
  //print_r($_SESSION['array_repo']);die();


$nombre = "demetria robles baz";

if ($idbus == 17 || $idbus == 1) {

$html = '

<style>
.todo_total{
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  font-size:7px;
}
table, td {
  border-left: 1px solid black;
  border-right: 1px solid black;
  border-collapse: collapse;
}
td .sin_borde{
  border-right: 1px solid red !important;
}
.rueda{
background-color: white !important;
border-radius: 7px !important;
display: inline-block !important;
line-height: 12px !important;
margin-right: 2px !important;
text-align: center !important;
width: 12px;
border:1px solid black;
font-size: 7px !important;
}
.th_der{
  border-top: 1px solid black;
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.th_ab_der{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.th_ab_der_x{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.td_bottom{
  border-bottom: 1px solid black; 
}
.th_med_der{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.th_izq{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.th_med_izq{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.sepa{
  border: 1px solid black;
  text-align: center !important;
}

</style>
<body style="max-height: 200px;">
  <div class="todo_total">
    <table style="width:100%;border-top: 1px solid black;">
     <tr>
        <td rowspan="3"><img style="width: 60px; margin-left:30%;" src="img/bus.png"></td>
        <td style="font-size: 11px !important; text-align: center;padding-right: 0px;" colspan="2">"Emp. de trasporte turismo HUARI S.A.C."</td>
        <td rowspan="3"><img style="width: 60px; margin-left:30%;" src="img/bus.png"></td>
        <td rowspan="3"><img style="width: 60px; margin-left:30%;" src="img/logito.png"></td>
      </tr>
      <tr>
        <td style="text-align: center;padding-right: 0px;font-size: 11px !important;" colspan="2">Av. 25 de enero Lt. 5 Urb. Infantas - Comas</td>
      </tr>
      <tr>
        <td style="text-align: center;font-size: 11px !important;" colspan="2"><b>Bus: '.$n_idbus.' - Fecha: '.$fecha.'</b></td>
      </tr>
       
        <tr>
        <td class="sepa" colspan="5">'.$sucus.'</td>
      </tr>  
      <tr>
        <td class="sepa" colspan="5">PRIMER PISO</td>
      </tr>
      

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >1</a> <b>NOM:</b>'.get_value("1","01","nombre").' </td>
        <td class="th_med_der"><a style="font-size:19px;font-weight:bold" >2</a> <b>NOM:</b>'.get_value("1","02","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq"><a style="font-size:19px;font-weight:bold" >3</a> <b>NOM:</b>'.get_value("1","03","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","01","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","02","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","03","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","01","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","02","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","03","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","01","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","02","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","03","sucursal").'</td>
      </tr>


      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >4</a> <b>NOM:</b>'.get_value("1","04","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >5</a> <b>NOM:</b>'.get_value("1","05","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >6</a> <b>NOM:</b>'.get_value("1","06","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","04","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","05","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","06","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","04","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","05","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","06","boleto").'</td>
      </tr>

      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","04","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","05","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","06","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >7</a> <b>NOM:</b>'.get_value("1","07","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >8</a> <b>NOM:</b>'.get_value("1","08","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >9</a> <b>NOM:</b>'.get_value("1","09","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","07","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","08","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","09","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","07","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","08","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","09","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","07","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","08","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","09","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >10</a> <b>NOM:</b>'.get_value("1","10","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >11</a> <b>NOM:</b>'.get_value("1","11","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >12</a> <b>NOM:</b>'.get_value("1","12","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","10","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","11","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","12","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","10","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","11","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","12","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","10","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","11","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","12","sucursal").'</td>
      </tr>
      <tr>
        <td class="sepa" colspan="5">SEGUNDO PISO</td>
      </tr>


      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >1</a> <b>NOM:</b>'.get_value("2","01","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >2</a> <b>NOM:</b>'.get_value("2","02","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >4</a> <b>NOM:</b>'.get_value("2","04","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >3</a> <b>NOM:</b>'.get_value("2","03","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","01","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","02","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","04","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","03","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","01","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","02","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","04","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","03","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","01","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","02","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","04","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","03","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >5</a> <b>NOM:</b>'.get_value("2","05","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >6</a> <b>NOM:</b>'.get_value("2","06","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >8</a> <b>NOM:</b>'.get_value("2","08","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >7</a> <b>NOM:</b>'.get_value("2","07","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","05","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","06","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","08","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","07","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","05","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","06","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","08","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","07","boleto").'</td>
      </tr>
       <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","05","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","06","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","08","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","07","sucursal").'</td>
      </tr>


      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >9</a> <b>NOM:</b>'.get_value("2","9","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >10</a> <b>NOM:</b>'.get_value("2","10","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","9","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","10","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","9","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","10","boleto").'</td>
        <th>&nbsp;</th>
        <th class="th_ab_der_x">&nbsp;</th>
        <th class="th_ab_der_x">&nbsp;</th>
      </tr>

      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","9","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","10","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >11</a> <b>NOM:</b>'.get_value("2","11","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >12</a> <b>NOM:</b>'.get_value("2","12","nombre").' </td>
        <td>&nbsp;</td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >14</a> <b>NOM:</b>'.get_value("2","14","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >13</a> <b>NOM:</b>'.get_value("2","13","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","11","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","12","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","14","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","13","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL:'.get_value("2","11","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","12","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","14","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","13","boleto").'</td>
      </tr>

      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","11","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","12","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","14","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","13","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >15</a> <b>NOM:</b>'.get_value("2","15","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >16</a> <b>NOM:</b>'.get_value("2","16","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >18</a> <b>NOM:</b>'.get_value("2","18","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >17</a> <b>NOM:</b>'.get_value("2","17","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","15","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","16","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","18","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","17","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","15","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","16","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","18","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","17","boleto").'</td>
      </tr>

      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","15","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","16","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","18","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","17","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >19</a> <b>NOM:</b>'.get_value("2","19","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >20</a> <b>NOM:</b>'.get_value("2","20","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >22</a> <b>NOM:</b>'.get_value("2","22","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >21</a> <b>NOM:</b>'.get_value("2","21","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","19","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","20","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","22","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","21","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","19","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","20","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","22","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","21","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","19","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","20","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","22","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","21","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >23</a> <b>NOM:</b>'.get_value("2","23","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >24</a> <b>NOM:</b>'.get_value("2","24","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >26</a> <b>NOM:</b>'.get_value("2","26","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >25</a> <b>NOM:</b>'.get_value("2","25","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","23","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","24","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","26","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","25","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","23","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","24","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","26","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","25","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","23","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","24","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","26","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","25","sucursal").'</td>
      </tr>

     
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >27</a> <b>NOM:</b>'.get_value("2","27","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >28</a> <b>NOM:</b>'.get_value("2","28","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >30</a> <b>NOM:</b>'.get_value("2","30","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >29</a> <b>NOM:</b>'.get_value("2","29","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","27","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","28","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","30","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","29","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","27","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","28","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","30","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","29","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","27","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","28","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","30","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","29","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >31</a> <b>NOM:</b>'.get_value("2","31","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >32</a> <b>NOM:</b>'.get_value("2","32","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >34</a> <b>NOM:</b>'.get_value("2","34","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >33</a> <b>NOM:</b>'.get_value("2","33","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","31","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","32","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","34","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","33","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","31","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","32","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","34","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","33","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","31","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","32","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","34","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","33","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >35</a> <b>NOM:</b>'.get_value("2","35","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >36</a> <b>NOM:</b>'.get_value("2","36","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >38</a> <b>NOM:</b>'.get_value("2","38","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >37</a> <b>NOM:</b>'.get_value("2","37","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","35","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","36","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","38","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","37","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","35","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","36","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","38","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","37","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","35","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","36","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","38","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","37","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >39</a> <b>NOM:</b>'.get_value("2","39","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >40</a> <b>NOM:</b>'.get_value("2","40","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >42</a> <b>NOM:</b>'.get_value("2","42","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >41</a> <b>NOM:</b>'.get_value("2","41","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","39","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","40","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","42","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","41","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","39","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","40","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","42","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","41","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","39","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","40","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","42","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","41","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >43</a> <b>NOM:</b>'.get_value("2","43","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >44</a> <b>NOM:</b>'.get_value("2","44","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >46</a> <b>NOM:</b>'.get_value("2","46","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >45</a> <b>NOM:</b>'.get_value("2","45","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","43","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","44","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","46","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","45","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","43","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","44","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","46","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","45","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","43","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","44","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","46","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","45","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >47</a> <b>NOM:</b>'.get_value("2","47","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >48</a> <b>NOM:</b>'.get_value("2","48","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >50</a> <b>NOM:</b>'.get_value("2","50","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >49</a> <b>NOM:</b>'.get_value("2","49","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","47","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","48","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","50","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","49","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","47","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","48","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","50","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","49","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","47","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","48","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","50","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","49","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >51</a> <b>NOM:</b>'.get_value("2","51","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >52</a> <b>NOM:</b>'.get_value("2","52","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >54</a> <b>NOM:</b>'.get_value("2","54","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >53</a> <b>NOM:</b>'.get_value("2","53","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","51","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","52","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","54","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","53","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">BOL: '.get_value("2","51","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","52","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","54","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","53","boleto").'</td>
      </tr>
       <tr>
        <td class="td_bottom">Salida: '.get_value("2","51","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","52","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","54","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","53","sucursal").'</td>
      </tr>
    </table>
  </div>
</body>';
}elseif ($idbus == 18 || $idbus == 19) {
  $html = '

<style>
.todo_total{
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  font-size: 10px;
}
table, td {
  border-left: 1px solid black;
  border-right: 1px solid black;
  border-collapse: collapse;
}
.rueda{
background-color: white !important;
border-radius: 7px !important;
display: inline-block !important;
line-height: 12px !important;
margin-right: 2px !important;
text-align: center !important;
width: 12px;
border:1px solid black;
font-size: 10px !important;
}
.th_der{
  border-top: 1px solid black;
  width: 22% !important;
  text-align: left !important;
  font-size: 10px !important;
}
.th_ab_der{
  width: 22% !important;
  text-align: left !important;
  font-size: 10px !important;
}
.th_ab_der_x{
  width: 22% !important;
  text-align: left !important;
  font-size: 10px !important;
}
.td_bottom{
  border-bottom: 1px solid black; 
}
.th_med_der{
  width: 22% !important;
  text-align: left !important;
  font-size: 10px !important;
}
.th_izq{
  width: 22% !important;
  text-align: left !important;
  font-size: 10px !important;
}
.th_med_izq{
  width: 22% !important;
  text-align: left !important;
  font-size: 10px !important;
}
.sepa{
  border: 1px solid black;
  text-align: center !important;
}

</style>
<body style="max-height: 200px;">
  <div class="todo_total">
    <table style="width:100%;border-top: 1px solid black;">
      <tr>
        <td rowspan="3"><img style="width: 60px; margin-left:30%;" src="img/bus.png"></td>
        <td style="font-size: 11px !important; text-align: center;padding-right: 0px;" colspan="2">"Emp. de trasporte turismo HUARI S.A.C."</td>
        <td rowspan="3"><img style="width: 60px; margin-left:30%;" src="img/bus.png"></td>
        <td rowspan="3"><img style="width: 60px; margin-left:30%;" src="img/logito.png"></td>
      </tr>
      <tr>
        <td style="text-align: center;padding-right: 0px;font-size: 11px !important;" colspan="2">Av. 25 de enero Lt. 5 Urb. Infantas - Comas</td>
      </tr>
      <tr>
        <td style="margin-left:30%; text-align: center;font-size: 11px !important;" colspan="2"><b>Bus: '.$n_idbus.' - Fecha: '.$fecha.'</b></td>
      </tr>
       
        <tr>
        <td class="sepa" colspan="5">'.$sucus.'</td>
      </tr>  
      <tr>
        <td class="sepa" colspan="5">PRIMER PISO</td>
      </tr>


      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >1</a> <b>NOM:</b>'.get_value("1","01","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >2</a> <b>NOM:</b>'.get_value("1","02","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >4</a> <b>NOM:</b>'.get_value("1","04","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >3</a> <b>NOM:</b>'.get_value("1","03","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","01","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","02","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","04","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","03","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","01","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","02","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","04","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","03","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","01","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","02","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","04","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","03","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >5</a> <b>NOM:</b>'.get_value("1","05","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >6</a> <b>NOM:</b>'.get_value("1","06","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >8</a> <b>NOM:</b>'.get_value("1","08","nombre").' </td> <td class="th_der"><a style="font-size:19px;font-weight:bold" >7</a> <b>NOM:</b>'.get_value("1","07","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","05","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","06","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","08","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","07","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","05","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","06","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","08","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","07","boleto").'</td>
      </tr>
       <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","05","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","06","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","08","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","07","sucursal").'</td>
      </tr>


      

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >09</a> <b>NOM:</b>'.get_value("1","09","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >10</a> <b>NOM:</b>'.get_value("1","10","nombre").' </td>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >12</a> <b>NOM:</b>'.get_value("1","12","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >11</a> <b>NOM:</b>'.get_value("1","11","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","09","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","10","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","12","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","11","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL:'.get_value("1","09","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("1","10","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL:'.get_value("1","12","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("1","11","boleto").'</td>
      </tr>

      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","09","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","10","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","12","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","11","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >13</a> <b>NOM:</b>'.get_value("1","13","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >14</a> <b>NOM:</b>'.get_value("1","14","nombre").' </td>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >16</a> <b>NOM:</b>'.get_value("1","16","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >15</a> <b>NOM:</b>'.get_value("1","15","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","13","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","14","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","16","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","15","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","13","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","14","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","16","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","15","boleto").'</td>
      </tr>

      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","13","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","14","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","16","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","15","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >17</a> <b>NOM:</b>'.get_value("1","17","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >18</a> <b>NOM:</b>'.get_value("1","18","nombre").' </td>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >20</a> <b>NOM:</b>'.get_value("1","20","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >19</a> <b>NOM:</b>'.get_value("1","19","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","17","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","18","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","20","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","19","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","17","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","18","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","20","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","19","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","17","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","18","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","20","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","19","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >21</a> <b>NOM:</b>'.get_value("1","21","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >22</a> <b>NOM:</b>'.get_value("1","22","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >24</a> <b>NOM:</b>'.get_value("1","24","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >23</a> <b>NOM:</b>'.get_value("1","23","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","21","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","22","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","24","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","23","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","21","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","22","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","24","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","23","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","21","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","22","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","24","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","23","sucursal").'</td>
      </tr>

     
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >25</a> <b>NOM:</b>'.get_value("1","25","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >26</a> <b>NOM:</b>'.get_value("1","26","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >28</a> <b>NOM:</b>'.get_value("1","28","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >27</a> <b>NOM:</b>'.get_value("1","27","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","25","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","26","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","28","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","27","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","25","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","26","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","28","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","27","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","25","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","26","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","28","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","27","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >29</a> <b>NOM:</b>'.get_value("1","29","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >30</a> <b>NOM:</b>'.get_value("1","30","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >32</a> <b>NOM:</b>'.get_value("1","32","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >31</a> <b>NOM:</b>'.get_value("1","31","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","29","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","30","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","32","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","31","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","29","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","30","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","32","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","31","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","29","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","30","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","32","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","31","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >33</a> <b>NOM:</b>'.get_value("1","33","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >34</a> <b>NOM:</b>'.get_value("1","34","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >36</a> <b>NOM:</b>'.get_value("1","36","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >35</a> <b>NOM:</b>'.get_value("1","35","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","33","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","34","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","36","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","35","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","33","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","34","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","36","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","35","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","33","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","34","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","36","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","35","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >37</a> <b>NOM:</b>'.get_value("1","37","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >38</a> <b>NOM:</b>'.get_value("1","38","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >40</a> <b>NOM:</b>'.get_value("1","40","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >39</a> <b>NOM:</b>'.get_value("1","39","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","37","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","38","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","40","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","39","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","37","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","38","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","40","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","39","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","37","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","38","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","40","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","39","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >41</a> <b>NOM:</b>'.get_value("1","41","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >42</a> <b>NOM:</b>'.get_value("1","42","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >44</a> <b>NOM:</b>'.get_value("1","44","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >43</a> <b>NOM:</b>'.get_value("1","43","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","41","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","42","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","44","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","43","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","41","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","42","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","44","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","43","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("1","41","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","42","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","44","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","43","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >45</a> <b>NOM:</b>'.get_value("1","45","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >46</a> <b>NOM:</b>'.get_value("1","46","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >48</a> <b>NOM:</b>'.get_value("1","48","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >47</a> <b>NOM:</b>'.get_value("1","47","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","45","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","46","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","48","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","47","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","45","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","46","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","48","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","47","boleto").'</td>
      </tr>
      <tr>
        <td class="td_bottom">Salida: '.get_value("1","45","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","46","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","48","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","47","sucursal").'</td>
      </tr>
      <tr>
        <th colspan="2" style="border:1px solid white;">&nbsp;</th>
        <td>&nbsp;</td>
        <td><a style="font-size:19px;font-weight:bold" >50</a> <b>NOM:</b>'.get_value("1","50","nombre").' </td>
        <td><a style="font-size:19px;font-weight:bold" >49</a> <b>NOM:</b>'.get_value("1","49","nombre").' </td>
      </tr>
      <tr>
        <th colspan="2" style="border:1px solid white;">&nbsp;</th>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("1","50","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("1","49","dni").'</td>
      </tr>
      <tr>
        <th colspan="2" style="border:1px solid white;">&nbsp;</th>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","50","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","49","boleto").'</td>
      </tr>
      <tr>
        <th colspan="2" style="border:1px solid white;">&nbsp;</th>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("1","50","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("1","49","sucursal").'</td>
      </tr>

    
    </table>
  </div>
</body>';
}elseif ($idbus == 16) {
  $html = '

<style>
.todo_total{
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  font-size:7px;
}
table, td {
  border-left: 1px solid black;
  border-right: 1px solid black;
  border-collapse: collapse;
}
.rueda{
background-color: white !important;
border-radius: 7px !important;
display: inline-block !important;
line-height: 12px !important;
margin-right: 2px !important;
text-align: center !important;
width: 12px;
border:1px solid black;
font-size: 7px !important;
}
.th_der{
  border-top: 1px solid black;
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.th_ab_der{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.th_ab_der_x{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.td_bottom{
  border-bottom: 1px solid black; 
}
.th_med_der{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.th_izq{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.th_med_izq{
  width: 22% !important;
  text-align: left !important;
  font-size: 7px !important;
}
.sepa{
  border: 1px solid black;
  text-align: center !important;
}

</style>
<body style="max-height: 200px;">
  <div class="todo_total">
    <table style="width:100%;border-top: 1px solid black;">
       <tr>
        <td rowspan="3"><img style="width: 60px; margin-left:30%;" src="img/bus.png"></td>
        <td style="font-size: 11px !important; text-align: center;padding-right: 0px;" colspan="2">"Emp. de trasporte turismo HUARI S.A.C."</td>
        <td rowspan="3"><img style="width: 60px; margin-left:30%;" src="img/bus.png"></td>
        <td rowspan="3"><img style="width: 60px; margin-left:30%;" src="img/logito.png"></td>
      </tr>
      <tr>
        <td style="text-align: center;padding-right: 0px;font-size: 11px !important;" colspan="2">Av. 25 de enero Lt. 5 Urb. Infantas - Comas</td>
      </tr>
      <tr>
        <td style="text-align: center;font-size: 11px !important;" colspan="2"><b>Bus: '.$n_idbus.' - Fecha: '.$fecha.'</b></td>
      </tr>
       
        <tr>
        <td class="sepa" colspan="5">'.$sucus.'</td>
      </tr>  
      <tr>
        <td class="sepa" colspan="5">PRIMER PISO</td>
      </tr>
      

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >1</a> <b>NOM:</b>'.get_value("1","01","nombre").' </td>
        <td class="th_med_der"><a style="font-size:19px;font-weight:bold" >2</a> <b>NOM:</b>'.get_value("1","02","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq"><a style="font-size:19px;font-weight:bold" >3</a> <b>NOM:</b>'.get_value("1","03","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","01","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","02","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","03","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","01","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","02","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","03","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","01","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","02","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","03","sucursal").'</td>
      </tr>


      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >4</a> <b>NOM:</b>'.get_value("1","04","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >5</a> <b>NOM:</b>'.get_value("1","05","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >6</a> <b>NOM:</b>'.get_value("1","06","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","04","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","05","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","06","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","04","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","05","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","06","boleto").'</td>
      </tr>

      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","04","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","05","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","06","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >7</a> <b>NOM:</b>'.get_value("1","07","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >8</a> <b>NOM:</b>'.get_value("1","08","nombre").' </td>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >10</a> <b>NOM:</b>'.get_value("1","10","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >9</a> <b>NOM:</b>'.get_value("1","09","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","07","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","08","dni").'</td>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","10","dni").'</td>
        <td class="th_izq">DNI: '.get_value("1","09","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","07","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","08","boleto").'</td>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","10","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","09","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","07","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","08","sucursal").'</td>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","10","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","09","sucursal").'</td>
      </tr>

    
      <tr>
        <td class="sepa" colspan="5">SEGUNDO PISO</td>
      </tr>


      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >1</a> <b>NOM:</b>'.get_value("2","01","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >2</a> <b>NOM:</b>'.get_value("2","02","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","01","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","02","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","01","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","02","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","01","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","02","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >5</a> <b>NOM:</b>'.get_value("2","05","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >6</a> <b>NOM:</b>'.get_value("2","06","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >4</a> <b>NOM:</b>'.get_value("2","04","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >3</a> <b>NOM:</b>'.get_value("2","03","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","05","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","06","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","04","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","03","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","05","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","06","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","04","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","03","boleto").'</td>
      </tr>
       <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","05","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","06","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","04","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","03","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >9</a> <b>NOM:</b>'.get_value("2","09","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >10</a> <b>NOM:</b>'.get_value("2","10","nombre").' </td>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >8</a> <b>NOM:</b>'.get_value("2","08","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >7</a> <b>NOM:</b>'.get_value("2","07","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","09","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","10","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","08","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","07","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL:'.get_value("2","09","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","10","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","08","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","07","boleto").'</td>
      </tr>

      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","09","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","10","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","08","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","07","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >11</a> <b>NOM:</b>'.get_value("2","11","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >12</a> <b>NOM:</b>'.get_value("2","12","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","11","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","12","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","11","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","12","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","11","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","12","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >15</a> <b>NOM:</b>'.get_value("2","15","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >16</a> <b>NOM:</b>'.get_value("2","16","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >14</a> <b>NOM:</b>'.get_value("2","14","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >13</a> <b>NOM:</b>'.get_value("2","13","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","15","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","16","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","14","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","13","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","15","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","16","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","14","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","13","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","15","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","16","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","14","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","13","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >19</a> <b>NOM:</b>'.get_value("2","19","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >20</a> <b>NOM:</b>'.get_value("2","20","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >18</a> <b>NOM:</b>'.get_value("2","18","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >17</a> <b>NOM:</b>'.get_value("2","17","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","19","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","20","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","18","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","17","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","19","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","20","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","18","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","17","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","19","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","20","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","18","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","17","sucursal").'</td>
      </tr>

     
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >23</a> <b>NOM:</b>'.get_value("2","23","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >24</a> <b>NOM:</b>'.get_value("2","24","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >22</a> <b>NOM:</b>'.get_value("2","22","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >21</a> <b>NOM:</b>'.get_value("2","21","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","23","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","24","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","22","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","21","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","23","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","24","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","22","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","21","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","23","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","24","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","22","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","21","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >27</a> <b>NOM:</b>'.get_value("2","27","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >28</a> <b>NOM:</b>'.get_value("2","28","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >26</a> <b>NOM:</b>'.get_value("2","26","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >25</a> <b>NOM:</b>'.get_value("2","25","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","27","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","28","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","26","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","25","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","27","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","28","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","26","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","25","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","27","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","28","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","26","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","25","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >31</a> <b>NOM:</b>'.get_value("2","31","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >32</a> <b>NOM:</b>'.get_value("2","32","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >30</a> <b>NOM:</b>'.get_value("2","30","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >29</a> <b>NOM:</b>'.get_value("2","29","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","31","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","32","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","30","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","29","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","31","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","32","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","30","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","29","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","31","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","32","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","30","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","29","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >35</a> <b>NOM:</b>'.get_value("2","35","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >36</a> <b>NOM:</b>'.get_value("2","36","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >34</a> <b>NOM:</b>'.get_value("2","34","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >33</a> <b>NOM:</b>'.get_value("2","33","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","35","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","36","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","34","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","33","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","35","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","36","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","34","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","33","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","35","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","36","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","34","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","33","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >39</a> <b>NOM:</b>'.get_value("2","39","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >40</a> <b>NOM:</b>'.get_value("2","40","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >38</a> <b>NOM:</b>'.get_value("2","38","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >37</a> <b>NOM:</b>'.get_value("2","37","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","39","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","40","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","38","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","37","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","39","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","40","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","38","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","37","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","39","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","40","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","38","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","37","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >43</a> <b>NOM:</b>'.get_value("2","43","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >44</a> <b>NOM:</b>'.get_value("2","44","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >42</a> <b>NOM:</b>'.get_value("2","42","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >41</a> <b>NOM:</b>'.get_value("2","41","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","43","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","44","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","42","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","41","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","43","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","44","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","42","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","41","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","43","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","44","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","42","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","41","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >47</a> <b>NOM:</b>'.get_value("2","47","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >48</a> <b>NOM:</b>'.get_value("2","48","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >46</a> <b>NOM:</b>'.get_value("2","46","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >45</a> <b>NOM:</b>'.get_value("2","45","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","47","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","48","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","46","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","45","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","47","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","48","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","46","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","45","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","47","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","48","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","46","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","45","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >49</a> <b>NOM:</b>'.get_value("2","49","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >50</a> <b>NOM:</b>'.get_value("2","50","nombre").' </td>
        <th class="th_der"><a style="font-size:19px;font-weight:bold" >51</a> <b>NOM:</b>'.get_value("2","51","nombre").'</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >52</a> <b>NOM:</b>'.get_value("2","52","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >53</a> <b>NOM:</b>'.get_value("2","53","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","49","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","51","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","50","dni").'</td>
        <td class="th_izq">DNI: '.get_value("2","52","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","53","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der_x">BOL: '.get_value("2","49","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","50","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","51","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","52","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","53","boleto").'</td>
      </tr>
       <tr>
        <td class="td_bottom">Salida: '.get_value("2","49","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","50","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","51","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","52","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","53","sucursal").'</td>
      </tr>
    </table>
  </div>
</body>';
}elseif ($idbus == 20){
 $html = '

<style>

@page {
 margin-top: 1em;
 margin-left: 1em;
 margin-right: 1em;
 margin-bottom: 1em;
}

.todo_total{
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  font-size:9px;
}
table, td {
  border-left: 1px solid black;
  border-right: 1px solid black;
  border-collapse: collapse;
}
td .sin_borde{
  border-right: 1px solid red !important;
}
.rueda{
 background-color: white !important;
 border-radius: 7px !important;
 display: inline-block !important;
 line-height: 12px !important;
 margin-right: 2px !important;
 text-align: center !important;
 width: 12px;
 border:1px solid black;
 font-size: 7px !important;
}
.th_der{
  border-top: 1px solid black;
  width: 22% !important;
  text-align: left !important;
}
.th_ab_der{
  width: 22% !important;
  text-align: left !important;
  font-size: 9px !important;
  line-height: .5px;
}
.th_ab_der_x{
  width: 22% !important;
  text-align: left !important;
  font-size: 9px !important;
  line-height: .5px;
}
.td_bottom{
  border-bottom: 1px solid black; 
}
.th_med_der{
  width: 22% !important;
  text-align: left !important;
}
.th_izq{
  width: 22% !important;
  text-align: left !important;
}
.th_med_izq{
  width: 22% !important;
  text-align: left !important;
  
}
.sepa{
  border: 1px solid black;
  text-align: center !important;
}

.sep td,th {
 height:10px;
 font-size:9px;
 line-height:.5px;
}

.titulo {
 text-align: center;
}

.tituloempresa {
 font-family: "Oswald", sans-serif;
 font-size: 1.3em;
}



</style>
<body style="max-height: 200px;">
  <div class="todo_total">
    <table style="width:100%;border: 1px solid black;">
      <tr class="tituloempresa">
        <td style="font-size:13px" colspan="4">'.$sucus.'</td>
        <td rowspan="3"><img style="width: 30px; margin-left:35%;" src="img/logito.png"></td>
      </tr>
      <tr>
        <td class="titulo" colspan="4"><b>Bus: '.$n_idbus.' - Fecha: '.$fecha.'</b></td>
      </tr>
 
      <tr>
        <td class="sepa" colspan="5">PRIMER PISO</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >1</a> <b>NOM:</b>'.get_value("1","01","nombre").'</td>
        <td class="th_med_der"><a style="font-size:19px;font-weight:bold" >2</a> <b>NOM:</b>'.get_value("1","02","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq"><a style="font-size:19px;font-weight:bold" >3</a> <b>NOM:</b>'.get_value("1","03","nombre").' </td>
      </tr>
      <tr class="sep">
        <td >DNI: '.get_value("1","01","dni").'</td>
        <td >DNI: '.get_value("1","02","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td >DNI: '.get_value("1","03","dni").'</td>
      </tr>
      <tr class="sep">
        <td >BOL: '.get_value("1","01","boleto").'</td>
        <td >BOL: '.get_value("1","02","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td >BOL: '.get_value("1","03","boleto").'</td>
      </tr>
      <tr class="sep">
        <td >Salida: '.get_value("1","01","sucursal").'</td>
        <td >Salida: '.get_value("1","02","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td >Salida: '.get_value("1","03","sucursal").'</td>
      </tr>


      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >4</a> <b>NOM:</b>'.get_value("1","04","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >5</a> <b>NOM:</b>'.get_value("1","05","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >6</a> <b>NOM:</b>'.get_value("1","06","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","04","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","05","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","06","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","04","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","05","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","06","boleto").'</td>
      </tr>

      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","04","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","05","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","06","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >7</a> <b>NOM:</b>'.get_value("1","07","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >8</a> <b>NOM:</b>'.get_value("1","08","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >9</a> <b>NOM:</b>'.get_value("1","09","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","07","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","08","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","09","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","07","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","08","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","09","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","07","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","08","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","09","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >10</a> <b>NOM:</b>'.get_value("1","10","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >11</a> <b>NOM:</b>'.get_value("1","11","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >12</a> <b>NOM:</b>'.get_value("1","12","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","10","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","11","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","12","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","10","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","11","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","12","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","10","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","11","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","12","sucursal").'</td>
      </tr>
      <tr>
        <td class="sepa" colspan="5">SEGUNDO PISO</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >1</a> <b>NOM:</b>'.get_value("2","01","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >2</a> <b>NOM:</b>'.get_value("2","02","nombre").' </td>
        <td>&nbsp;</td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >4</a> <b>NOM:</b>'.get_value("2","04","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >3</a> <b>NOM:</b>'.get_value("2","03","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","01","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","02","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","04","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","03","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","01","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","02","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","04","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","03","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","01","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","02","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","04","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","03","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >5</a> <b>NOM:</b>'.get_value("2","05","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >6</a> <b>NOM:</b>'.get_value("2","06","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","05","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","06","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
       <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","05","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","06","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","05","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","06","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >7</a> <b>NOM:</b>'.get_value("2","07","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >8</a> <b>NOM:</b>'.get_value("2","08","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>

      </tr>
      <tr class="sep">
        <td class="th_izq">DNI: '.get_value("2","07","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","08","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">BOL: '.get_value("2","07","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","08","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
       <tr class="sep">
        <td class="th_ab_der_x td_bottom">Salida: '.get_value("2","07","sucursal").'</td>
        <td class="th_ab_der_x td_bottom">Salida: '.get_value("2","08","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >9</a> <b>NOM:</b>'.get_value("2","9","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >10</a> <b>NOM:</b>'.get_value("2","10","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","9","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","10","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","9","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","10","boleto").'</td>
        <th>&nbsp;</th>
        <th class="th_ab_der_x">&nbsp;</th>
        <th class="th_ab_der_x">&nbsp;</th>
      </tr>

      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","9","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","10","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >13</a> <b>NOM:</b>'.get_value("2","13","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >14</a> <b>NOM:</b>'.get_value("2","14","nombre").' </td>
        <td>&nbsp;</td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >12</a> <b>NOM:</b>'.get_value("2","12","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >11</a> <b>NOM:</b>'.get_value("2","11","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","13","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","14","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","12","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","11","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL:'.get_value("2","13","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","14","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","12","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","11","boleto").'</td>
      </tr>

      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","13","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","14","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","12","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","11","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >17</a> <b>NOM:</b>'.get_value("2","17","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >18</a> <b>NOM:</b>'.get_value("2","18","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >16</a> <b>NOM:</b>'.get_value("2","16","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >15</a> <b>NOM:</b>'.get_value("2","15","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","17","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","18","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","16","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","15","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","17","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","18","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","16","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","15","boleto").'</td>
      </tr>

      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","17","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","18","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","16","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","15","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >21</a> <b>NOM:</b>'.get_value("2","21","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >22</a> <b>NOM:</b>'.get_value("2","22","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >20</a> <b>NOM:</b>'.get_value("2","20","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >19</a> <b>NOM:</b>'.get_value("2","19","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","21","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","22","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","20","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","19","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","21","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","22","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","20","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","19","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","21","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","22","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","20","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","19","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >25</a> <b>NOM:</b>'.get_value("2","25","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >26</a> <b>NOM:</b>'.get_value("2","26","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >24</a> <b>NOM:</b>'.get_value("2","24","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >23</a> <b>NOM:</b>'.get_value("2","23","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","25","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","26","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","24","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","23","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","25","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","26","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","24","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","23","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","25","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","26","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","24","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","23","sucursal").'</td>
      </tr>

     
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >29</a> <b>NOM:</b>'.get_value("2","29","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >30</a> <b>NOM:</b>'.get_value("2","30","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >28</a> <b>NOM:</b>'.get_value("2","28","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >27</a> <b>NOM:</b>'.get_value("2","27","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","29","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","30","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","28","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","27","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","29","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","30","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","28","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","27","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","29","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","30","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","28","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","27","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >33</a> <b>NOM:</b>'.get_value("2","33","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >34</a> <b>NOM:</b>'.get_value("2","34","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >32</a> <b>NOM:</b>'.get_value("2","32","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >31</a> <b>NOM:</b>'.get_value("2","31","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","33","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","34","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","32","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","31","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","33","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","34","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","32","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","31","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","33","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","34","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","32","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","31","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >37</a> <b>NOM:</b>'.get_value("2","37","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >38</a> <b>NOM:</b>'.get_value("2","38","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >36</a> <b>NOM:</b>'.get_value("2","36","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >35</a> <b>NOM:</b>'.get_value("2","35","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","37","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","38","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","36","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","35","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","37","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","38","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","36","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","35","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","37","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","38","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","36","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","35","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >41</a> <b>NOM:</b>'.get_value("2","41","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >42</a> <b>NOM:</b>'.get_value("2","42","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >40</a> <b>NOM:</b>'.get_value("2","40","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >39</a> <b>NOM:</b>'.get_value("2","39","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","41","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","42","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","40","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","39","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","41","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","42","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","40","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","39","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","41","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","42","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","40","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","39","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >45</a> <b>NOM:</b>'.get_value("2","45","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >46</a> <b>NOM:</b>'.get_value("2","46","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >44</a> <b>NOM:</b>'.get_value("2","44","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >43</a> <b>NOM:</b>'.get_value("2","43","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","45","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","46","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","44","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","43","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","45","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","46","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","44","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","43","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","45","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","46","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","44","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","43","sucursal").'</td>
      </tr>      
    </table>
  </div>
</body>';
}elseif ($idbus == 21){
 $html = '

<style>

@page {
 margin-top: 1em;
 margin-left: 1em;
 margin-right: 1em;
 margin-bottom: 1em;
}

.todo_total{
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  font-size:9px;
}
table, td {
  border-left: 1px solid black;
  border-right: 1px solid black;
  border-collapse: collapse;
}
td .sin_borde{
  border-right: 1px solid red !important;
}
.rueda{
 background-color: white !important;
 border-radius: 7px !important;
 display: inline-block !important;
 line-height: 12px !important;
 margin-right: 2px !important;
 text-align: center !important;
 width: 12px;
 border:1px solid black;
 font-size: 7px !important;
}
.th_der{
  border-top: 1px solid black;
  width: 22% !important;
  text-align: left !important;
  font-size: 9px !important;
}
.th_ab_der{
  width: 22% !important;
  text-align: left !important;
  font-size: 9px !important;
  line-height: .5px;
}
.th_ab_der_x{
  width: 22% !important;
  text-align: left !important;
  font-size: 9px !important;
  line-height: .5px;
}
.td_bottom{
  border-bottom: 1px solid black; 
}
.th_med_der{
  width: 22% !important;
  text-align: left !important;
  font-size: 9px !important;
}
.th_izq{
  width: 22% !important;
  text-align: left !important;
  font-size: 9px !important;
}
.th_med_izq{
  width: 22% !important;
  text-align: left !important;
  font-size: 9px !important;
}
.sepa{
  border: 1px solid black;
  text-align: center !important;
}

.sep td,th {
 height:11px;
 font-size:9px;
 line-height:.5px;
}

.titulo {
 text-align: center;
}

.tituloempresa {
 font-family: "Oswald", sans-serif;
 font-size: 1.3em;
}



</style>
<body style="max-height: 200px;">
  <div class="todo_total">
    <table style="width:100%;border: 1px solid black;">
      <tr class="tituloempresa">
        <td class="titulo" colspan="4" style="font-size:15px"><b>"EMPRESA DE TRANSPORTES HUARI TOURS S.A.C."</b></td>
        <td rowspan="3"><img style="width: 60px; margin-left:35%;" src="img/logito.png"></td>
      </tr>
      <tr>
        <td class="titulo" colspan="4" style="font-size:15px"><b>BUS: '.$n_idbus.' - FECHA: '.$fecha.'</b></td>
      </tr>
      <tr> <td class="titulo" colspan="4">Av. 25 de enero Lt. 5 Urb. Infantas - Comas</td>
      </tr> 
      <tr>
        <td class="sepa" colspan="5">'.$sucus.'</td>
      </tr>  
      <tr>
        <td class="sepa" colspan="5" style="font-size:15px">PRIMER PISO</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >1</a> <b>NOM:</b>'.get_value("1","01","nombre").' </td>
        <td class="th_med_der"><a style="font-size:19px;font-weight:bold" >2</a> <b>NOM:</b>'.get_value("1","02","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq"><a style="font-size:19px;font-weight:bold" >3</a> <b>NOM:</b>'.get_value("1","03","nombre").' </td>
      </tr>
      <tr class="sep">
        <td >DNI: '.get_value("1","01","dni").'</td>
        <td >DNI: '.get_value("1","02","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td >DNI: '.get_value("1","03","dni").'</td>
      </tr>
      <tr class="sep">
        <td >BOL: '.get_value("1","01","boleto").'</td>
        <td >BOL: '.get_value("1","02","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td >BOL: '.get_value("1","03","boleto").'</td>
      </tr>
      <tr class="sep">
        <td >Salida: '.get_value("1","01","sucursal").'</td>
        <td >Salida: '.get_value("1","02","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td >Salida: '.get_value("1","03","sucursal").'</td>
      </tr>


      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >4</a> <b>NOM:</b>'.get_value("1","04","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >5</a> <b>NOM:</b>'.get_value("1","05","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >6</a> <b>NOM:</b>'.get_value("1","06","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","04","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","05","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","06","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","04","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","05","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","06","boleto").'</td>
      </tr>

      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","04","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","05","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","06","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >7</a> <b>NOM:</b>'.get_value("1","07","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >8</a> <b>NOM:</b>'.get_value("1","08","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >9</a> <b>NOM:</b>'.get_value("1","09","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","07","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","08","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","09","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","07","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","08","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","09","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","07","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","08","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","09","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >10</a> <b>NOM:</b>'.get_value("1","10","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >11</a> <b>NOM:</b>'.get_value("1","11","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >12</a> <b>NOM:</b>'.get_value("1","12","nombre").' </td>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("1","10","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("1","11","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_izq">DNI: '.get_value("1","12","dni").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("1","10","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("1","11","boleto").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("1","12","boleto").'</td>
      </tr>
      <tr>
        <td class="th_ab_der">Salida: '.get_value("1","10","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("1","11","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">Salida: '.get_value("1","12","sucursal").'</td>
      </tr>
      <tr>
        <td class="sepa" colspan="5" style="font-size:15px">SEGUNDO PISO</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >1</a> <b>NOM:</b>'.get_value("2","01","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >2</a> <b>NOM:</b>'.get_value("2","02","nombre").' </td>
        <td>&nbsp;</td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >4</a> <b>NOM:</b>'.get_value("2","04","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >3</a> <b>NOM:</b>'.get_value("2","03","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","01","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","02","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","04","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","03","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","01","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","02","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","04","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","03","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","01","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","02","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="td_bottom">Salida: '.get_value("2","04","sucursal").'</td>
        <td class="td_bottom">Salida: '.get_value("2","03","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >5</a> <b>NOM:</b>'.get_value("2","05","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >6</a> <b>NOM:</b>'.get_value("2","06","nombre").' </td>
        <th>&nbsp;</th>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >8</a> <b>NOM:</b>'.get_value("2","08","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >7</a> <b>NOM:</b>'.get_value("2","07","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","05","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","06","dni").'</td>
        <th>&nbsp;</th>
        <td class="th_med_izq">DNI: '.get_value("2","08","dni").'</td>
        <td class="th_izq">DNI: '.get_value("2","07","dni").'</td>
      </tr>
       <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","05","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","06","boleto").'</td>
        <th>&nbsp;</th>
        <td class="th_ab_der_x">BOL: '.get_value("2","08","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","07","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","05","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","06","sucursal").'</td>
        <th>&nbsp;</th>
        <td class="th_ab_der_x td_bottom">Salida: '.get_value("2","08","sucursal").'</td>
        <td class="th_ab_der_x td_bottom">Salida: '.get_value("2","07","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >9</a> <b>NOM:</b>'.get_value("2","9","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >10</a> <b>NOM:</b>'.get_value("2","10","nombre").' </td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">DNI: '.get_value("2","9","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","10","dni").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_ab_der">BOL: '.get_value("2","9","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","10","boleto").'</td>
        <th>&nbsp;</th>
        <th class="th_ab_der_x">&nbsp;</th>
        <th class="th_ab_der_x">&nbsp;</th>
      </tr>

      <tr>
        <td class="th_ab_der_x">Salida: '.get_value("2","9","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","10","sucursal").'</td>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
      <td class="th_der"><a style="font-size:19px;font-weight:bold" >11</a> <b>NOM:</b>'.get_value("2","11","nombre").' </td>
      <td class="th_der"><a style="font-size:19px;font-weight:bold" >12</a> <b>NOM:</b>'.get_value("2","12","nombre").' </td>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      </tr>
      <tr class="sep">
      <td class="th_ab_der">DNI: '.get_value("2","11","dni").' </td>
      <td class="th_med_der">DNI: '.get_value("2","12","dni").' </td>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      </tr>
      <tr class="sep">
      <td class="th_ab_der">BOL:'.get_value("2","11","boleto").' </td>
      <td class="th_ab_der_x">BOL:'.get_value("2","12","boleto").' </td>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      </tr>
      <tr class="sep">
      <td class="th_ab_der_x">SALIDA:'.get_value("2","11","sucursal").' </td>
      <td class="th_ab_der_x">SALIDA:'.get_value("2","12","sucursal").' </td>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >15</a> <b>NOM:</b>'.get_value("2","15","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >16</a> <b>NOM:</b>'.get_value("2","16","nombre").' </td>
        <td>&nbsp;</td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >14</a> <b>NOM:</b>'.get_value("2","14","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >13</a> <b>NOM:</b>'.get_value("2","13","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","15","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","16","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","14","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","13","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL:'.get_value("2","15","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","16","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","14","boleto").'</td>
        <td class="th_ab_der_x">BOL:'.get_value("2","13","boleto").'</td>
      </tr>

      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","15","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","16","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","14","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","13","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >19</a> <b>NOM:</b>'.get_value("2","19","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >20</a> <b>NOM:</b>'.get_value("2","20","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >18</a> <b>NOM:</b>'.get_value("2","18","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >17</a> <b>NOM:</b>'.get_value("2","17","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","19","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","20","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","18","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","17","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","19","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","20","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","18","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","17","boleto").'</td>
      </tr>

      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","19","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","20","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","18","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","17","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >23</a> <b>NOM:</b>'.get_value("2","23","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >24</a> <b>NOM:</b>'.get_value("2","24","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >22</a> <b>NOM:</b>'.get_value("2","22","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >21</a> <b>NOM:</b>'.get_value("2","21","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","23","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","24","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","22","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","21","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","23","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","24","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","22","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","21","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","23","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","24","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","22","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","21","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >27</a> <b>NOM:</b>'.get_value("2","27","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >28</a> <b>NOM:</b>'.get_value("2","28","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >26</a> <b>NOM:</b>'.get_value("2","26","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >25</a> <b>NOM:</b>'.get_value("2","25","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","27","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","28","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","26","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","25","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","27","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","28","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","26","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","25","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","27","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","28","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","26","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","25","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >31</a> <b>NOM:</b>'.get_value("2","31","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >32</a> <b>NOM:</b>'.get_value("2","32","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >30</a> <b>NOM:</b>'.get_value("2","30","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >29</a> <b>NOM:</b>'.get_value("2","29","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","31","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","32","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","30","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","29","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","31","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","32","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der">BOL: '.get_value("2","30","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","29","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","31","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","32","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","30","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","29","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >35</a> <b>NOM:</b>'.get_value("2","35","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >36</a> <b>NOM:</b>'.get_value("2","36","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >34</a> <b>NOM:</b>'.get_value("2","34","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >33</a> <b>NOM:</b>'.get_value("2","33","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","35","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","36","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","34","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","33","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","35","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","36","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","34","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","33","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","35","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","36","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","34","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","33","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >39</a> <b>NOM:</b>'.get_value("2","39","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >40</a> <b>NOM:</b>'.get_value("2","40","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >38</a> <b>NOM:</b>'.get_value("2","38","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >37</a> <b>NOM:</b>'.get_value("2","37","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","39","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","40","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","38","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","37","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","39","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","40","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","38","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","37","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","39","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","40","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","38","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","37","sucursal").'</td>
      </tr>

      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >43</a> <b>NOM:</b>'.get_value("2","43","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >44</a> <b>NOM:</b>'.get_value("2","44","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >42</a> <b>NOM:</b>'.get_value("2","42","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >41</a> <b>NOM:</b>'.get_value("2","41","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","43","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","44","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","42","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","41","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","43","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","44","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","42","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","41","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","43","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","44","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","42","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","41","sucursal").'</td>
      </tr>
      <tr>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >47</a> <b>NOM:</b>'.get_value("2","47","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >48</a> <b>NOM:</b>'.get_value("2","48","nombre").' </td>
        <th>&nbsp;</t2>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >46</a> <b>NOM:</b>'.get_value("2","46","nombre").' </td>
        <td class="th_der"><a style="font-size:19px;font-weight:bold" >45</a> <b>NOM:</b>'.get_value("2","45","nombre").' </td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">DNI: '.get_value("2","47","dni").'</td>
        <td class="th_med_der">DNI: '.get_value("2","48","dni").'</td>
        <td>&nbsp;</td>
        <td class="th_izq">DNI: '.get_value("2","46","dni").'</td>
        <td class="th_med_izq">DNI: '.get_value("2","45","dni").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der">BOL: '.get_value("2","47","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","48","boleto").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","46","boleto").'</td>
        <td class="th_ab_der_x">BOL: '.get_value("2","45","boleto").'</td>
      </tr>
      <tr class="sep">
        <td class="th_ab_der_x">Salida: '.get_value("2","47","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","48","sucursal").'</td>
        <td>&nbsp;</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","46","sucursal").'</td>
        <td class="th_ab_der_x">Salida: '.get_value("2","45","sucursal").'</td>
      </tr>       
    </table>
  </div>
</body>';
}


//echo $html;
$domdpdf = new Dompdf();
$domdpdf->loadHtml($html);
//$domdpdf->setPaper('A4', 'portrait');
$domdpdf->setPaper('legal','portrait');
$domdpdf->render();
$pdf = $domdpdf->output();
$domdpdf->stream($rowfac['n_documento'], array('Attachment' =>0));




 function get_value($piso, $asiento, $return){
  $var_return = "";
  foreach ($_SESSION['array_repo'] as $key => $value) {
    if ($value['asiento'] == $asiento && $value['piso'] == $piso) {
      if ($return == "nombre") {
        $var_return = strtoupper($value['nombre_cliente']);
      }elseif ($return == "dni") {
        $var_return = $value['n_documento_identidad'];
      }elseif ($return == "boleto") {
        $var_return = $value['n_documento'];
      }elseif ($return == "sucursal") {
        $var_return = $value['nombre_sucursal'];
      }
      break;
    }else{
      $var_return = "";
    }
  }
  return $var_return;
}