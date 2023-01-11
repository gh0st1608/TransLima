<?php

include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../config/db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../config/conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include "../funciones.php";
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $id_sucursal = intval($_GET['id']);
    $query       = mysqli_query($con, "select * from tb_usuarios where id_sucursales='" . $id_sucursal . "'");
    $count       = mysqli_num_rows($query);
    if ($count == 0) {
        if ($delete1 = mysqli_query($con, "DELETE FROM tb_sucursales WHERE id_sucursal='" . $id_sucursal . "'")) {
            ?>Datos eliminados exitosamente.<?php
} else {
            ?>
			Lo siento algo ha salido mal intenta nuevamente.
			<?php

        }

    } else {
        ?>
			No se puede Eliminar la Sucursal que tienen Usuario Agregados.
			<?php
}

}
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('nombre_sucursal', 'direccion'); //Columnas de busqueda
    $sTable   = "tb_sucursales";
    $sWhere   = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by id_sucursal desc";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = './sucursales.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        // $simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
        ?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Nombre</th>
					<th>Celular</th>
					<th style="text-align: center;">Codigo Fiscal</th>
					<th style="text-align: center;">Hora Salida</th>
					<th><span class="pull-right">Acciones</span></th>

				</tr>
				<?php
//$key = 0;
        while ($row = mysqli_fetch_array($query)) {
            $id_sucursal      = $row['id_sucursal'];
            $nombre_sucursal  = $row['nombre_sucursal'];
            $serie_boleta     = $row['serie_boleta'];
            $serie_factura    = $row['serie_factura'];

            $serie_boleta_viaje     = $row['serie_boleta_viaje'];
            $serie_factura_viaje    = $row['serie_factura_viaje'];

            $direccion        = $row['direccion'];
            $direccion_real        = $row['direccion_real'];
            $direccion_fiscal = $row['cod_direccion_fiscal'];
            $horaviaje        = date('H:i:s', strtotime($row['hora_viaje']));
            $porcentaje = $row['porcentaje'];
            //if ($estatus==1){$estado="Activo";}
            //else {$estado="Inactivo";}
            $offset++;
            $date_added = date('d/m/Y', strtotime($row['fecha_creado']));
            ?>

					<input type="hidden" value="<?php echo $id_sucursal; ?>" id="codigo_sucursal<?php echo $id_sucursal; ?>">
					<input type="hidden" value="<?php echo $nombre_sucursal; ?>" id="nombre_sucursal<?php echo $id_sucursal; ?>">
					<input type="hidden" value="<?php echo $serie_boleta; ?>" id="serie_boleta<?php echo $id_sucursal; ?>">
					<input type="hidden" value="<?php echo $serie_factura; ?>" id="serie_factura<?php echo $id_sucursal; ?>">

                    <input type="hidden" value="<?php echo $serie_boleta_viaje; ?>" id="serie_boleta_viaje<?php echo $id_sucursal; ?>">
                    <input type="hidden" value="<?php echo $serie_factura_viaje; ?>" id="serie_factura_viaje<?php echo $id_sucursal; ?>">

					<input type="hidden" value="<?php echo $direccion; ?>" id="direccion<?php echo $id_sucursal; ?>">
					<input type="hidden" value="<?php echo $direccion_fiscal; ?>" id="direccion_fiscal<?php echo $id_sucursal; ?>">
                    <input type="hidden" value="<?php echo $horaviaje; ?>" id="horaviaje<?php echo $id_sucursal; ?>">
                    <input type="hidden" value="<?php echo $porcentaje; ?>" id="porcentaje<?php echo $id_sucursal; ?>">
					<input type="hidden" value="<?php echo $direccion_real; ?>" id="direccion_real<?php echo $id_sucursal; ?>">

					<!--input type="hidden" value="<?php echo $estatus; ?>" id="estado<?php echo $id_sucursal; ?>"-->
					<tr>
						<td><?php echo $offset; ?></td>
						<td><?php echo $nombre_sucursal; ?></td>
						<td><?php echo $direccion; ?></td>
						<td style="text-align: center;"><?php echo $direccion_fiscal; ?></td>
						<td style="text-align: center;"><?php echo date('h:i:s a', strtotime($row['hora_viaje'])); ?></td>

					</span></td>
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar producto' onclick="obtener_datos('<?php echo $id_sucursal; ?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
					<!--a href="#" class='btn btn-default' title='Borrar producto' onclick="eliminar('<?php echo $id_sucursal; ?>')"><i class="glyphicon glyphicon-trash"></i> </a--></span></td>

					</tr>
					<?php
}
        ?>
				<tr>
					<td colspan=7><span class="pull-right">
					<?php
echo paginate($reload, $page, $total_pages, $adjacents);
        ?></span></td>
				</tr>
			  </table>
			</div>
			<?php
}
}
?>