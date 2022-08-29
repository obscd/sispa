<?php
require_once('../locklvl.php');
$MM_authorizedUsers =usuario(0);
require_once('../lock.php'); ?>
<?php require_once('../Connections/conexion.php'); ?>
<?php
# Ocultar warnings
error_reporting(E_ERROR | E_PARSE);

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    // $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  global $conexion;
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conexion, $theValue) : mysqli_escape_string($conexion, $theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$codigoa=$_GET['actividad'];
  $insertSQL = sprintf("INSERT INTO coordinador (cod_quien_necesita, cod_meta_coord) VALUES (%s, %s)",
                       GetSQLValueString($codigoa, "text"),
                       GetSQLValueString($_POST['cod_meta_coord'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));
//**************************************************
$updateSQL = sprintf("UPDATE meta SET meta_estado=%s WHERE cod_meta=%s",
                       GetSQLValueString('1', "int"),
                       GetSQLValueString($_POST['cod_meta_coord'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));
//***************************************************
  $insertGoTo = "coordinador.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysqli_select_db($conexion, $database_conexion);
$query_listametas = "SELECT * FROM meta where meta_estado = 0 ORDER BY id_meta ASC";
$listametas = mysqli_query($conexion, $query_listametas) or die(mysqli_error($conexion));
$row_listametas = mysqli_fetch_assoc($listametas);
$totalRows_listametas = mysqli_num_rows($listametas);

$maxRows_verlistmetaactivi = 10;
$pageNum_verlistmetaactivi = 0;
if (isset($_GET['pageNum_verlistmetaactivi'])) {
  $pageNum_verlistmetaactivi = $_GET['pageNum_verlistmetaactivi'];
}
$startRow_verlistmetaactivi = $pageNum_verlistmetaactivi * $maxRows_verlistmetaactivi;

$colname_verlistmetaactivi = "-1";
if (isset($_GET['actividad'])) {
  $colname_verlistmetaactivi = $_GET['actividad'];
}
mysqli_select_db($conexion, $database_conexion);
$query_verlistmetaactivi = sprintf("SELECT *
FROM (((((pilar LEFT JOIN programa ON pilar.cod_pilar=programa.cod_pilar_pro)
LEFT JOIN accion ON programa.cod_programa=accion.cod_programa_ac)
LEFT JOIN actividad ON accion.cod_accion=actividad.cod_accion_act)
LEFT JOIN coordinador ON actividad.cod_actividad=coordinador.cod_quien_necesita)
LEFT JOIN meta ON coordinador.cod_meta_coord = meta.cod_meta ) WHERE coordinador.cod_quien_necesita = %s ORDER BY id_coordinador ASC", GetSQLValueString($colname_verlistmetaactivi, "text"));
$query_limit_verlistmetaactivi = sprintf("%s LIMIT %d, %d", $query_verlistmetaactivi, $startRow_verlistmetaactivi, $maxRows_verlistmetaactivi);
$verlistmetaactivi = mysqli_query($conexion, $query_limit_verlistmetaactivi) or die(mysqli_error($conexion));
$row_verlistmetaactivi = mysqli_fetch_assoc($verlistmetaactivi);

if (isset($_GET['totalRows_verlistmetaactivi'])) {
  $totalRows_verlistmetaactivi = $_GET['totalRows_verlistmetaactivi'];
} else {
  $all_verlistmetaactivi = mysqli_query($conexion, $query_verlistmetaactivi);
  $totalRows_verlistmetaactivi = mysqli_num_rows($all_verlistmetaactivi);
}
$totalPages_verlistmetaactivi = ceil($totalRows_verlistmetaactivi/$maxRows_verlistmetaactivi)-1;

$queryString_verlistmetaactivi = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_verlistmetaactivi") == false &&
        stristr($param, "totalRows_verlistmetaactivi") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_verlistmetaactivi = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_verlistmetaactivi = sprintf("&totalRows_verlistmetaactivi=%d%s", $totalRows_verlistmetaactivi, $queryString_verlistmetaactivi);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $titulo; ?> </title>

<?php require('../cssadmin.php'); ?>
  </head>

<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
              <div class="navbar nav_title" style="border: 0; text-align: center;">
              <?php
			  echo $stitulo;
			  ?>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo $foto; ?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Hola,</span>
                <h2><?php echo $husuario; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3><?php echo $titulomenu; ?></h3>
                <?php
				echo $menu;//**********************************************************menu
				?>
              </div>
              <?php
			  echo $configuracion;//***********************************************configuracion
			  ?>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <?php echo $hmeninf; ?>
            <!-- /menu footer buttons -->
          </div>
        </div>
<?php
echo $navtop;
?>

        <div class="right_col" role="main">
<?php
		echo $headerpag;
		?>
			<div class="page-title">
              <div class="title_left">
				<h1>
								<small>MENU / ADMINISTRADOR / </small> PLAN DE ACCION
				</h1>
				<h4>
							<div class="btn-group">
								<a href="actividades.php?pilar=<?php echo $_GET['pilar']; ?>&programa=<?php echo $_GET['programa']; ?>&accion=<?php echo $_GET['accion']; ?>" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-default"><i class="fa fa-reply"></i></a>
                                <a href="../adminc/" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-default">COMPONENTE <?php echo $row_verlistmetaactivi['orden_pilar']; ?></a>
                                <a href="programa.php?pilar=<?php echo $_GET['pilar']; ?>" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-default">PROGRAMA <?php echo $row_verlistmetaactivi['orden_programa']; ?></a>
                                <a href="accion.php?pilar=<?php echo $_GET['pilar']; ?>&programa=<?php echo $_GET['programa']; ?>" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-default">ACCION <?php echo $row_verlistmetaactivi['orden_accion']; ?></a>
								<a href="actividades.php?pilar=<?php echo $_GET['pilar']; ?>&programa=<?php echo $_GET['programa']; ?>&accion=<?php echo $_GET['accion']; ?>" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-primary">ACTIVIDAD <?php echo $row_verlistmetaactivi['orden_actividad']; ?></a>
							</div>
				</h4>
              </div>
         </div>
          <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile">
<div class="x_title">
                  <h2> METAS</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li>
                    <a class="btn btn-default" data-toggle="modal" data-target="#buscar" onclick="ventana('buscardetalle','','')" >(BUSCAR META)</a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
<table id="datatable-responsive" class="table table-bordered table-hover" cellspacing="0" >
<thead>
      <tr>
        <th align="center" valign="middle" bgcolor="#2A3F54">&nbsp;</th>
        <th align="center" valign="middle" bgcolor="#2A3F54">CODIGO Y METAS</th>
        <th height="44" align="center" valign="middle" bgcolor="#2A3F54">GESTION</th>
        <th align="center" valign="middle" bgcolor="#2A3F54">META</th>
        <th align="center" valign="middle" bgcolor="#2A3F54">PONDERACION</th>
        <th bgcolor="#2A3F54">META A CUMPLIR</th>
        </tr>
</thead>
<tbody>
      <?php
	  $cmeta=0;
	  do {
	  $cmeta++;
	  ?>
        <tr>
          <td align="center" valign="middle"><a href="delcoord.php?del=<?php echo $row_verlistmetaactivi['cod_meta_coord']; ?>&pilar=<?php echo $_GET['pilar']; ?>&programa=<?php echo $_GET['programa']; ?>&accion=<?php echo $_GET['accion']; ?>&actividad=<?php echo $_GET['actividad']; ?>&a=coordinador&b=cod_meta_coord&c=coordinador" data-toggle="tooltip" data-placement="top" title="Liberar Meta para que pueda ser usado por otra actividad"><i class="fa fa-close fa-2x"></i></a></td>
          <td align="center" valign="middle">

            META <?php echo $row_verlistmetaactivi['orden_pilar']; ?>.<?php echo $row_verlistmetaactivi['orden_programa']; ?>.<?php echo $row_verlistmetaactivi['orden_accion']; ?>.<?php echo $row_verlistmetaactivi['orden_actividad'].'-'.$cmeta; ?> :

</td>
          <td align="center" valign="middle"><?php echo $row_verlistmetaactivi['gestion']; ?></td>
          <td><?php echo $row_verlistmetaactivi['descr_meta']; ?></td>
          <td align="center" valign="middle"><?php echo $row_verlistmetaactivi['ponderacion']; ?></td>
          <td align="center" valign="middle"><?php echo $row_verlistmetaactivi['cumplimiento_meta']; ?></td>
          </tr>
        <?php } while ($row_verlistmetaactivi = mysqli_fetch_assoc($verlistmetaactivi)); ?>
</tbody>
    </table>
<table border="0">
        <tr>
          <td><?php if ($pageNum_verlistmetaactivi > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_verlistmetaactivi=%d%s", $currentPage, 0, $queryString_verlistmetaactivi); ?>">Primero</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_verlistmetaactivi > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_verlistmetaactivi=%d%s", $currentPage, max(0, $pageNum_verlistmetaactivi - 1), $queryString_verlistmetaactivi); ?>">Anterior</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_verlistmetaactivi < $totalPages_verlistmetaactivi) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_verlistmetaactivi=%d%s", $currentPage, min($totalPages_verlistmetaactivi, $pageNum_verlistmetaactivi + 1), $queryString_verlistmetaactivi); ?>">Siguiente</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_verlistmetaactivi < $totalPages_verlistmetaactivi) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_verlistmetaactivi=%d%s", $currentPage, $totalPages_verlistmetaactivi, $queryString_verlistmetaactivi); ?>">&Uacute;ltimo</a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table>

</div>
</div>
</div>
</div>
  </div>
        <?php echo $footer; ?>
        <!-- /footer content -->
      </div>
    </div>

<div class="modal fade bs-example-modal-lg" id="buscar" tabindex="-1" role="dialog" aria-labelledby="search" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="search">BUSCAR:</h4>
      </div>

	    <input type="text" name="de" id="de" onkeyup="ventana('listarmetas',this.value,'busqueda')" class="form-control" placeholder="BUSCAR EN LA DESCRIPCION DE LA META"/>

      <div class="modal-body" id="busqueda">
        <!-- Realizado por: athoted@hotmail.com -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $close; ?></button>
      </div>
    </div>
  </div>
</div>

 <?php require('../jsadmin.php'); ?>

</body>
</html>
<?php
mysqli_free_result($listametas);

mysqli_free_result($verlistmetaactivi);
?>