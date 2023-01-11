<?php
$id=$_REQUEST['id'];
$con=mysqli_connect("localhost","root","","transportes");
$liquis="SELECT * FROM tb_facturacion_cab where si_liquidacion='$id'";
$liqui=mysqli_query($con,$liquis);

$liq="SELECT * FROM tb_liquidacion where id_liquidacion='$id'";
$li=mysqli_query($con,$liq);
$l=mysqli_fetch_array($li);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <table>
      <td>
      <h1>Liquidación N°<?php echo $id?></h1> 
      </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>
      <h1>Sucursal:<?php echo $l['su_inicio'] ?></h1>    
      </td>
    </table>
<table class="table">
	<thead>
		<th>Boletos</th>
    <th>Fecha</th>
		<th>Monto</th>
	</thead>
	<tbody>
		<?php 
		foreach ($liqui as $value) {
		?>
    <tr>
		<td><?php echo $value['n_documento'] ?></td>
    <td><?php echo $value['fecha_creado'] ?></td>
    <td><?php echo $value['precio_total'] ?></td>
    </tr>
		<?php
	}
		?>
	</tbody>

</table>
<b>
  
<label>Monto total Liquidado: </label>    <?php echo $l['total'] ?>
</b>
  </div>

</body>
</html>