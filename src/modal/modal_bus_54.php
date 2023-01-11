

	<!-- Modal -->
	<div class="modal fade" id="xx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Seleccionar Asiento</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			
			<?php
	$html = "<table style='float:right;    margin-right: 10px;' class='tablemodalbus' piso='3'>";
	$conta = 1;
	$fila = 4;
	$html.="<tr><td colspan='4' style='text-align:center; font-size:20px; padding-bottom: 10px;'>Piso 2</td></tr>";
	for ($i = 1; $i <= $fila; $i++){
		
		$num2 = ($i==2 || $i==4) ? ($conta++ + 1): $conta++ ;
		$html.= "

		<tr>
			<td class='idrow'>
				<div style='border:1px solid black; width:50px; height:50px; text-align:center; line-height:50px;'>".$num2."</div>
			</td>";
		//$h = ($i == 2) ? "string" : "";

		$num = ($i==2 || $i==4) ? ($conta - 1) : $conta++ ;
		//$num = ($i==2 || $i==4) ? $conta++ : "";
		$html .="<td class='idrow'>
				<div style='border:1px solid black; width:50px; height:50px; margin-right:50px; text-align:center; line-height:50px;'>".
				$num."</div> 
				<!-- -->
			</td>";
		if ($i == 2 || $i == 4) {$conta++;}
		$html .="<td class='idrow'>
				<div style='border:1px solid black; width:50px; height:50px; text-align:center; line-height:50px;'>".$conta++ ."</div>
			</td>
			
		</tr>";
	}
	$html.="</table>";
	echo $html;

	echo "<div style='float:right; border-left: 6px solid #3498db; margin-right:50px; height: 731px;' class='vl'></div>";
	$conta = 1;
	$fila = 14;
	$piso2 = "<table piso='1'>";
	$piso2.="<tr><td colspan='4' style='text-align:center; font-size:20px; padding-bottom: 10px;'>Piso 1</td></tr>";
	for ($i = 1; $i <= $fila; $i++){
		$piso2.= "
		<tr>
			<td class='idrow'>
				<div style='border:1px solid black; width:50px; height:50px; text-align:center; line-height:50px;'>".$conta++."</div>
			</td>
			<td class='idrow'>
				<div style='border:1px solid black; width:50px; height:50px; text-align:center; line-height:50px;'>".$conta++."</div> 
				<!-- -->
			</td>";	


			if ($fila==$i) {
				$piso2.=

				"<td class='idrow'>
				<div style='border:1px solid black; width:50px; height:50px; text-align:center; line-height:50px;'>".$conta++."</div> 
				<!-- margin-right:50px;-->
			</td>";

				
			}
			else{
				$piso2 .= "<td class='idrow'>
					<div style=' width:50px; height:50px; text-align:center; line-height:50px;'></div> 
					<!-- margin-right:50px; border:1px solid black;-->
				</td>
				";
			}


			if($i==3){		
			$piso2.="<td class='idrow' colspan='2'>
				<div style='border:1px solid black; width:100%; height:50px; text-align:center; line-height:50px;'>Escalera</div>
			</td>";}else{
				$sum = ($fila ==$i) ? 0 : 1;
				$piso2.="
				<td class='idrow'>
					<div style='border:1px solid black; width:50px; height:50px; text-align:center; line-height:50px;'>".($conta++  + $sum)."</div>
				</td>";
				if ($fila != $i) {
				$piso2.="<td class='idrow'>
					<div style='border:1px solid black; width:50px; height:50px; text-align:center; line-height:50px;'>".($conta++  - 1)."</div>
				</td>";}
				}
			
		$piso2.="</tr>";
	}
	$piso2.="</table>";
	echo $piso2;
?>


			 
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
