		
	$(document).ready(function(){
			load(1);
			
		});

	
	$(document).on('click','#save_resfacbol',function(){
		fecha = new Date().toDateInputValue();
		$.ajax({
				type: "POST",
				url:'./ajax/nueva_reserva.php?action=savefacbol',
				data: $('#save_reservafacbol').serialize()+'&fecha='+fecha,
				 beforeSend: function(objeto){
			  },
				success:function(data){
					//$(".reserva").html(data).fadeIn('slow');
					Swal('Mensaje',"El documento fue creada correctamente",'success');
					// if (data == 1) {Swal('Mensaje',"El documento fue creada correctamente",'success');}
					// else {Swal('Mensaje',"Ocurrio un error al crear el documento",'error');}
					load(1);
					$("#modal_reserva_fac").modal("hide");
					
					
				}
			})
	});
	$(document).on('click','.agregar_bus',function(){

			id =$(this).parents('tr').find('td.codigo').html();
			tip = $(this).html();
			console.log(tip);
			tip = (tip == 'Factura') ? '01' : '03';
			val = (tip == 1) ? 'FACTURACION ELECTRONICA' : 'BOLETA VENTA ELECTRONICA';
			$('#codigo').val(id);
			$('#tipodocumento').val(tip);
			$('#tituloreserca').html(val);
			buscarcliente();
	});
		
	Date.prototype.toDateInputValue = (function() {
	    var local = new Date(this);
	    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
	    return local.toJSON().slice(0,19);
	});


	function load(page){
			var q= $("#q").val();
			console.log("asas");
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/nueva_reserva.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 //$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true});
					
				}
			})
		}

	function eliminarreservas(idreserva){


		Swal.fire({
		  title: 'Mensaje',
		  text: "¿Estas seguro que deseas eliminarlo?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Ok',
		  cancelButtonText: 'Cancelar',
		}).then((result) => {
		 if (result.value) {
		  	$.ajax({
			url:'./ajax/nueva_reserva.php?action=eliminar&idres='+idreserva,
			 beforeSend: function(objeto){
			  },
				success:function(data){
					Swal.fire(
				      'Mensaje',
				      'Eliminado correctamente',
				      'success'
				    );
				    load(1);
				}
			})
		    
		  }
		})


		
		
	}
