		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_sucursales.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 //$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
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
			  text: "deseas eliminar la sucursal !",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Eliminar'
			}).then((result) => {
			  	if (result.value) {
				  	$.ajax({
			        type: "GET",
			        url: "./ajax/buscar_sucursales.php",
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
			
			/*var q= $("#q").val();
			if (confirm("Realmente deseas eliminar el producto")){	
			$.ajax({
	        type: "GET",
	        url: "./ajax/buscar_sucursales.php",
	        data: "id="+id,"q":q,
			 beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			  },
	        success: function(datos){
			$("#resultados").html(datos);
			load(1);
			}
				});
			}*/
		}
		