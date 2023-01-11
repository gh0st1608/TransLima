		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_liquidacion.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 //$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

		$(function() {

			$("#sucursal_partida").autocomplete({
				source: "./ajax/autocomplete/sucursales.php",
				appendTo: "#nuevoEncomienda",	
				minLength: 2,
				select: function(event, ui) {
					event.preventDefault();
					$('#sucursal_par').val(ui.item.id_sucursal);
					$('#sucursal_partida').val(ui.item.nombre_sucursal);
				 }
			});

			$("#sucursal_llegada").autocomplete({
				source: "./ajax/autocomplete/sucursales.php",
				appendTo: "#nuevoEncomienda",	
				minLength: 2,
				select: function(event, ui) {
					event.preventDefault();
					$('#sucursal_lle').val(ui.item.id_sucursal); console.log("asd");console.log(ui.item.id_sucursal);
					$('#sucursal_llegada').val(ui.item.nombre_sucursal);
				 }
			});


			$("#nombus").autocomplete({
				source: "./ajax/autocomplete/bus.php",
				minLength: 2,
				select: function(event, ui) {
					event.preventDefault();
					console.log(ui.item);
					$('#idbus').val(ui.item.idbus);
					$('#nombus').val(ui.item.placa);				
				 }
			});

			

		});

	

$(document).on('click','#guardar_datos',function(){	
		idbus = $("#idbus").val();
		n_idbus = $("#nombus").val();
		gastos = $("#nomgastos").val();

		if(idbus=='')
		{
			alert('Elija el bus'); return;
		}
		else {
			if(n_idbus=='')
			{
				alert('Elija el bus'); return;
			}
		}

		if(gastos=='')
		{
			alert('Si no tiene gastos operativos, ingrese 0'); return;
		}

		$.ajax({
			type: "POST",
			url:'./ajax/agregar_liquidacion.php?action=save',
			data: 'idbus='+idbus+'&n_idbus='+n_idbus+'&gastos='+gastos,
				beforeSend: function(objeto){
			},
			success:function(data){
				data = data.trim();
				$("#nueva_liquidacion").modal("hide");	
				if (data == "error") {
					Swal('Mensaje','No se han encontrado datos','error'); return;
				}else {
				  var url = location.origin;
				  window.open(url + '/Expreso/pdf_liquidacion.php?id='+data, '_blank');
				  load(1);
				  //alert(url);
				  //alert(data);
				  //http://localhost/Sistema-Huari-Tours/pdf_liquidacion.php?id=7
				  //window.open('http://localhost/Sistema-Huari-Tours/pdf_liquidacion.php?id='+data, '_blank');
				}
				
			}
		})

	});