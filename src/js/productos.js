	 $(document).on('click','#nuevoproducto', function(e){
	 	$ ("#igv").attr("disabled", "disabled");
	 	$('#igv').val('18%');
	 	$('#total').attr("disabled", "disabled");

	 });		

		$("#precio" ).keyup(function() {
		  var valor = $('#precio').val();
		  var igv  = 0.18;
		  var total = parseFloat(((valor * igv).toFixed(2))) + parseFloat((valor));

		  $('#total').val(total.toFixed(2));
		  if ($('#precio').val() === '') {
		  		$('#total').val('');
		  }

		});


		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_productos.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
	
		function eliminar (id)
		{

			var q= $("#q").val();
			Swal({
			  title: 'Estas Seguro?',
			  text: "deseas eliminar el bus !",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Eliminar'
			}).then((result) => {
			  	if (result.value) {
				  	$.ajax({
			        type: "GET",
			        url: "./ajax/buscar_productos.php",
			        data: "id="+id,"q":q,
					 	beforeSend: function(objeto){
							
					  },
				        success: function(datos){
						//$("#resultados").html(datos);
						tipo = (datos == "Datos eliminados exitosamente.") ? "success" : "error";
						Swal(
					      'Eliminado!',
					      datos,
					      tipo
					    )
						load(1);
						}
					});
			  	} 
			})

}

 	function resetbus(id){
	 	
 		Swal.fire({
		  title: '¿Estas seguro?',
		  text: "Volveran a resetear los asientos de este bus",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si, resetear',
		  cancelButtonText: 'Cancelar'
		}).then((result) => {
		  if (result.value) {

		  	
		    	$.ajax({
			        type: "GET",
			        url: "./ajax/reset_bus.php",
			        data: "idbus="+id,
					 	beforeSend: function(objeto){
							
					  },
				        success: function(datos){
						//$("#resultados").html(datos);
						tipo = (datos == "Datos reseteados exitosamente.") ? "success" : "error";
						Swal('Eliminado!',datos, tipo)
						load(1);
						}
					});
		  }
		})

	 }
		
		
		
		

