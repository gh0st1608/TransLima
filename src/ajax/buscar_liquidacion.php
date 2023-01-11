<?php

include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../config/db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../config/conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include "../funciones.php";
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $idsucu = $_SESSION['idsucursal'];
    $q        = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('correlativo', 'fecha_creado'); //Columnas de busqueda
    $sTable   = "tb_liquidacion";
    $sWhere   = "";
    $sWhere .= " WHERE id_sucursal = '$idsucu' " ;
    if ($_GET['q'] != "") {
        $sWhere = "AND (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ') ';
    }    
    $sWhere .= " order by id_liquidacion desc";
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
    //var_dump($sql); die();
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        // $simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
        ?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>N°</th>
					<th>Sucursal Partida</th>
					<th style="text-align: center;">Sucursal Llegada</th>
					<th style="text-align: center;">Bus</th>
					<th style="text-align: center;">Fecha creado</th>
					<th><span class="pull-right">Acciones</span></th>

				</tr>
				<?php
//$key = 0;
        while ($row = mysqli_fetch_array($query)) {
            $offset++;
            $url = "http://" . $_SERVER['HTTP_HOST'] . '/Expreso/' . 'pdf_liquidacion.php?id=' . $row['id_liquidacion'] ;
            ?>
            		<tr>
						<td><?php echo $offset; ?></td>
						<td><?php echo $row['correlativo']; ?></td>
						<td><?php echo $row['su_inicio']; ?></td>
						<td><?php echo $row['sucu_fin']; ?></td>
						<td style="text-align: center;"><?php echo $row['nombre_bus']; ?></td>
						<td style="text-align: center;"><?php echo date('Y-m-d', strtotime($row['fecha_creado'])); ?></td>
					<td ><span class="pull-right">
					<a target="_blank" href="<?php echo $url ?>" class='btn btn-default' title='Reporte'><i class="glyphicon glyphicon-edit"></i></a>
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