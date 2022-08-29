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
    //$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
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
	$codaccion=generarCodigo(16);
  $insertSQL = sprintf("INSERT INTO accion (cod_accion, cod_programa_ac, descr_accion, orden_accion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($codaccion, "text"),
                       GetSQLValueString($_POST['cod_programa_ac'], "text"),
                       GetSQLValueString($_POST['descr_accion'], "text"),
					   GetSQLValueString($_POST['orden'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "accion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_acciones = 10;
$pageNum_acciones = 0;
if (isset($_GET['pageNum_acciones'])) {
  $pageNum_acciones = $_GET['pageNum_acciones'];
}
$startRow_acciones = $pageNum_acciones * $maxRows_acciones;

$colname_acciones = "-1";
if (isset($_GET['programa'])) {
  $colname_acciones = $_GET['programa'];
}
mysqli_select_db($conexion, $database_conexion);
$query_acciones = sprintf("SELECT * FROM ((pilar LEFT JOIN programa ON pilar.cod_pilar=programa.cod_pilar_pro)LEFT JOIN accion ON programa.cod_programa=accion.cod_programa_ac) WHERE accion.cod_programa_ac = %s ORDER BY accion.orden_accion ASC", GetSQLValueString($colname_acciones, "text"));
$query_limit_acciones = sprintf("%s LIMIT %d, %d", $query_acciones, $startRow_acciones, $maxRows_acciones);
$acciones = mysqli_query($conexion, $query_limit_acciones) or die(mysqli_error($conexion));
$row_acciones = mysqli_fetch_assoc($acciones);

if (isset($_GET['totalRows_acciones'])) {
  $totalRows_acciones = $_GET['totalRows_acciones'];
} else {
  $all_acciones = mysqli_query($conexion, $query_acciones);
  $totalRows_acciones = mysqli_num_rows($all_acciones);
}
$totalPages_acciones = ceil($totalRows_acciones/$maxRows_acciones)-1;

$queryString_acciones = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_acciones") == false &&
        stristr($param, "totalRows_acciones") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_acciones = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_acciones = sprintf("&totalRows_acciones=%d%s", $totalRows_acciones, $queryString_acciones);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $titulo; ?> </title>
    <link href="../favicon.ico" rel="icon">
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
								<a href="programa.php?pilar=<?php echo $_GET['pilar']; ?>" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-default"><i class="fa fa-reply"></i></a>
                                <a href="../adminc/" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-default">COMPONENTE <?php echo $row_acciones['orden_pilar']; ?></a>
                                <a href="programa.php?pilar=<?php echo $_GET['pilar']; ?>" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-primary">PROGRAMA <?php echo $row_acciones['orden_programa']; ?></a>
							</div>
				</h4>
              </div>
         </div>

          <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile">
                <div class="x_title">
                  <h2>ACCIONES</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-block btn-default">Registrar Nueva Acción</a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
<table id="datatable-responsive" class="table table-bordered table-hover" cellspacing="0" >
<thead>
        <tr>
          <th width="18" align="center" valign="middle" bgcolor="#2A3F54">

          </th>
          <th width="18" align="center" valign="middle" bgcolor="#2A3F54">&nbsp;</th>
          <th width="136" height="42" align="center" valign="middle" bgcolor="#2A3F54">CODIGO</th>
          <th width="1183" align="center" valign="middle" bgcolor="#2A3F54">DESCRIPCION</th>
          <th width="46" align="center" valign="middle" bgcolor="#2A3F54">METAS</th>
        </tr>
</thead>
<tbody>
<?php 
$orden=0;
 do { 
if($row_acciones['orden_accion'] >= $orden)
{
$orden=$row_acciones['orden_accion'];
}

?>
          <tr>
            <td align="center" valign="middle">
              <a href="delcoord.php?del=<?php echo $row_acciones['cod_accion']; ?>&pilar=<?php echo $_GET['pilar']; ?>&programa=<?php echo $_GET['programa']; ?>&a=accion&b=cod_accion&c=accion" data-toggle="tooltip" data-placement="top" title="Eliminar este registro de la LISTA DE ACCIONES" onclick="if(!confirm('<?php echo $alertborrar; ?>'))return false"><i class="fa fa-close fa-2x"></i></a>
            </td>
            <td align="center" valign="middle">
<a class="btn btn-succes" data-toggle='modal' data-target='#option' onClick="ventana('editarpac','<?php echo $row_acciones['cod_accion'].'&pilar='.$_GET['pilar'].'&programa='.$_GET['programa']; ?>','pop')">
<i class="fa fa-pencil fa-2x"></i>
</a>
            </td>
            <td align="center" valign="middle">
ACP <?php echo $row_acciones['orden_pilar']; ?>.<?php echo $row_acciones['orden_programa']; ?>.<?php echo $row_acciones['orden_accion']; ?> :</td>
            <td><?php echo $row_acciones['descr_accion']; ?></td>

            <td>
              <a href="coordinador.php?pilar=<?php echo $_GET['pilar']; ?>&programa=<?php echo $_GET['programa']; ?>&accion=<?php echo $row_acciones['cod_accion']; ?>" class="btn btn-block btn-default">
                <span class="badge"><?php
                  $x=contare('coordinador','cod_quien_necesita',$row_acciones['cod_accion']);
                  $contare = mysqli_query($conexion, $x) or die(mysqli_error($conexion));
                  $row_contare = mysqli_fetch_assoc($contare);
                      if(isset($row_contare)){
                    if($row_contare['disp'] > 0 ) {$valc=$row_contare['disp'];}else{$valc=0;}
                    echo $valc;
                  } else {
                    echo '0';
                  }

                  ?></span>
                </a>
            </td>

          </tr>
          <?php } while ($row_acciones = mysqli_fetch_assoc($acciones)); ?>
          </tbody>
    </table>
    <table border="0">
        <tr>
          <td><?php if ($pageNum_acciones > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_acciones=%d%s", $currentPage, 0, $queryString_acciones); ?>">Primero</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_acciones > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_acciones=%d%s", $currentPage, max(0, $pageNum_acciones - 1), $queryString_acciones); ?>">Anterior</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_acciones < $totalPages_acciones) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_acciones=%d%s", $currentPage, min($totalPages_acciones, $pageNum_acciones + 1), $queryString_acciones); ?>">Siguiente</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_acciones < $totalPages_acciones) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_acciones=%d%s", $currentPage, $totalPages_acciones, $queryString_acciones); ?>">&Uacute;ltimo</a>
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



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">NUEVO REGISTRO ACCION</h4>
      </div>
      <div class="modal-body">
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center" class="table">
          <tr valign="baseline">
            <td bgcolor="#CCCCCC"><input type="hidden" name="cod_programa_ac" value="<?php echo $_GET['programa'];  ?>"></td>
    </tr>
          <tr valign="baseline">
            <td bgcolor="#CCCCCC">DESCRIPCION:</td>
          </tr>
          <tr valign="baseline">
            <td bgcolor="#CCCCCC"><label for="descr_accion"></label>
            <textarea name="descr_accion" id="descr_accion" class="form-control" rows=7 required></textarea></td>
    </tr>
	<tr valign="baseline">
      <td bgcolor="#CCCCCC">ORDEN</td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC"><input type="text" name="orden" value='<?php echo $orden + 1; ?>' class="form-control" required></td>
    </tr>
          <tr valign="baseline">
            <td bgcolor="#CCCCCC"><input type="submit" value="Insertar registro" class="btn btn-success btn-block"></td>
    </tr>
  </table>
        <input type="hidden" name="MM_insert" value="form1">
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $close; ?></button>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="option" tabindex="-1" role="dialog" aria-labelledby="large" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="large"><?php echo $editar; ?></h4>
      </div>
      <div class="modal-body" id="pop">

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
mysqli_free_result($contare);
mysqli_free_result($acciones);
?>