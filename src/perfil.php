<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$active_perfil="active";	
	$title="Configuración | Expreso Lima E.I.R.L";
	
	$query_empresa=mysqli_query($con,"select * from tb_empresa where id_empresa=1");
	$row=mysqli_fetch_array($query_empresa);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
	<?php include("head.php");?>
  </head>
  <body>
 	<?php
	include("navbar.php");
	?> 
	<div class="container">
      <div class="row">
      <form method="post" id="perfil">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><i class='glyphicon glyphicon-cog'></i> Configuración</h3>
            </div>
            <div class="panel-body">
              <div class="row">
			  
                <div class="col-md-3 col-lg-3 " align="center"> 
				<div id="load_img">
					<img class="img-responsive" src="<?php echo $row['logotipo_empresa'];?>" alt="Logo">
					
				</div>
				<br>				
					<div class="row">
  						<div class="col-md-12">
							<div class="form-group">
								<input class='filestyle' data-buttonText="Logo" type="file" name="imagefile" id="imagefile" onchange="upload_image();">
							</div>
						</div>
						
					</div>
				</div>
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-condensed">
                    <tbody>
                      <tr>
                        <td class='col-md-3'>Razon Social:</td>
                    		<td><input type="text" class="form-control input-sm" name="razon_social" value="<?php echo $row['razon_social']?>" required title="Razon Social" placeholder="Razon Social"></td>
                      </tr>
                      <tr>
                      <td class='col-md-3'>Nombre Comercial:</td>
                    		<td><input type="text" class="form-control input-sm" name="nombre_empresa" value="<?php echo $row['nombre_comercial']?>" required title="Nombre Comercial" placeholder="Nombre Comercial"></td>
                      </tr>
                       <tr>
                        <td class='col-md-3'>RUC:</td>
                    		<td><input type="text" class="form-control input-sm" name="ruc" value="<?php echo $row['ruc']?>" title="RUC" placeholder="RUC"></td>
                      </tr>
                       <tr>
                        <td class='col-md-3'>Correo:</td>
                    		<td><input type="text" class="form-control input-sm" name="email" value="<?php echo $row['correo_empresa']?>" required title="Correo" placeholder="Correo"></td>
                      </tr>
                       <tr>
                        <td class='col-md-3'>Telefono:</td>
                    		<td><input type="text" class="form-control input-sm" name="telefono" value="<?php echo $row['telefono_empresa']?>" required title="Telefono" placeholder="Telefono"></td>
                      </tr>
                       <tr>
                        <td class='col-md-3'>Direccion:</td>
                    		<td><input type="text" class="form-control input-sm" name="direccion" value="<?php echo $row["direccion"];?>" required title="Direccion" placeholder="Direccion"></td>
                      </tr>
                      <tr>
                        <td>IGV (%):</td>
                        	<td><input disabled="" type="text" class="form-control input-sm" required name="impuesto" value="<?php echo $row['impuesto']?>" title="IGV (%)" placeholder="IGV (%)"></td>
                      </tr>
                      <tr>
                      	<td>Simbolo de moneda:</td>
                      	 <td>
                      	 	<select disabled="" class="form-control input-sm" id="moneda" name="moneda" title="Simbolo de moneda" placeholder="Simbolo de moneda">
									<?php
										$sql_vendedor=mysqli_query($con,"select * from tb_moneda where  estado = 1 order by id_moneda ");
										while ($rw=mysqli_fetch_array($sql_vendedor)){
											$id_moneda=$rw["id_moneda"];
											$nombre_vendedor=$rw["simbolo"];
											if ($rw['defecto'] == 1){
												$selected="selected";
											} else {
												$selected="";
											}
											?>
											<option value="<?php echo $rw['id_moneda'] ?>" <?php echo $selected;?>><?php echo $nombre_vendedor?></option>
											<?php
										}
									?>
								</select>
                      	 </td>
                      </tr>
                    </tbody>
                  </table>
                  
                  
                </div>
				<di	v class='col-md-12' id="resultados_ajax"></div><!-- Carga los datos ajax -->
              </div>
            </div>
                 <div class="panel-footer text-center">
                    
                     
                            <button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-refresh"></i> Actualizar datos</button>
                       
                       
                    </div>
            
          </div>
        </div>
		</form>
      </div>

	
	<?php
	include("footer.php");
	?>
  </body>
</html>
<script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
<script>
$( "#perfil" ).submit(function( event ) {
  $('.guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_perfil.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			//$("#resultados_ajax").html(datos);
			nom = (datos =="Datos han sido actualizados satisfactoriamente.") ? "success" : "error";
			Swal(
			  'Mensaje',
			  datos,
			  nom
			)
			$('.guardar_datos').attr("disabled", false);

		  }
	});
  event.preventDefault();
})





		
</script>

<script>
		function upload_image(){
				
				var inputFileImage = document.getElementById("imagefile");
				var file = inputFileImage.files[0];
				if( (typeof file === "object") && (file !== null) )
				{
					$("#load_img").text('Cargando...');	
					var data = new FormData();
					data.append('imagefile',file);
					
					
					$.ajax({
						url: "ajax/imagen_ajax.php",        // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						contentType: false,       // The content type used when sending data to the server.
						cache: false,             // To unable request pages to be cached
						processData:false,        // To send DOMDocument or non processed data file it is set to false
						success: function(data)   // A function to be called if request succeeds
						{
							$("#load_img").html(data);
							
						}
					});	
				}
				
				
			}
    </script>

