<?php
	 
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();


	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	//print_r("ex");
?>
<input type="hidden" name="" value="<?php echo $_POST['valrow']; ?>" id="idasiento">
<table class="table" id="tabledetalle">
			<tbody>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Cantidad</th>
					<th>Descripción</th>
					<th class="text-right">Precio Unitario</th>
					<th class="text-right">Precio Total</th>
					<th></th>
				</tr>
				<tr class="precios">
					<td class="text-center">1</td>
					<td class="text-center">1</td>
					<td class="desc">Piso # <?php echo $_POST['valpiso']; ?> Asiento # <?php echo $_POST['valrow']; ?></td>
					<td class="text-right valor"><input type="text" name="valorunitario" id="valorunitario"></td>
					<td class="text-right preciototal">00.00</td>
					<td class="text-center"><a href="#" onclick="eliminar('2')"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>	
				<tr class="subtotal">
					<td class="text-right" colspan="4">OP EXONERADA S/.</td>
					<td class="text-right valor">00.00</td>
					<td></td>
				</tr>
				<tr class="igv">
					<td class="text-right" colspan="4">IGV (18)% S/.</td>
					<td class="text-right valor">00.00</td>
					<td class="text-center"></td>
				</tr>
				<tr class="total">
					<td class="text-right" colspan="4">TOTAL S/.</td>
					<td class="text-right valor">00.00</td>
					<td></td>
				</tr>
			</tbody>
		</table>
