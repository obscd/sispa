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

$maxRows_financiadores = 10;
$pageNum_financiadores = 0;
if (isset($_GET['pageNum_financiadores'])) {
  $pageNum_financiadores = $_GET['pageNum_financiadores'];
}
$startRow_financiadores = $pageNum_financiadores * $maxRows_financiadores;

mysqli_select_db($conexion, $database_conexion);
$query_financiadores = "SELECT * FROM financiador ORDER BY nombre_financiador ASC";
$query_limit_financiadores = sprintf("%s LIMIT %d, %d", $query_financiadores, $startRow_financiadores, $maxRows_financiadores);
$financiadores = mysqli_query($conexion, $query_limit_financiadores) or die(mysqli_error($conexion));
$row_financiadores = mysqli_fetch_assoc($financiadores);

if (isset($_GET['totalRows_financiadores'])) {
  $totalRows_financiadores = $_GET['totalRows_financiadores'];
} else {
  $all_financiadores = mysqli_query($conexion, $query_financiadores);
  $totalRows_financiadores = mysqli_num_rows($all_financiadores);
}
$totalPages_financiadores = ceil($totalRows_financiadores/$maxRows_financiadores)-1;

$queryString_financiadores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_financiadores") == false &&
        stristr($param, "totalRows_financiadores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_financiadores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_financiadores = sprintf("&totalRows_financiadores=%d%s", $totalRows_financiadores, $queryString_financiadores);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$codfinanciador=generarCodigo(16);
  $insertSQL = sprintf("INSERT INTO financiador (cod_finnanciador, nombre_financiador, descripcion_financiador, fechreg_financiador) VALUES ( %s, %s, %s, %s)",
                       GetSQLValueString($codfinanciador, "text"),
                       GetSQLValueString($_POST['nombre_financiador'], "text"),
                       GetSQLValueString('-', "text"),
                       GetSQLValueString($fecha, "date"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "financiadores.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
						 <small>MENU / ADMINISTRADOR / </small>	I. APS - METAS
				</h1>
				<h4>
				</h4>
              </div>
         </div>

          <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile">
                <div class="x_title">
                  <h2>INDICADORES APS - PLAN ACCION (METAS)</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-block btn-default">Registrar Plan de Acción </a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
<table id="datatable-responsive" class="table table-bordered table-hover" >
<thead>
        <tr>
          <th width="5%">&nbsp;</th>
          <th width="5%">&nbsp;</th>
          <th width="5%" height="39">Nº</th>
          <th width="80%">NOMBRE</th>
          <th width="10%">INDICADORES</th>
          </tr>
</thead>
<tbody >
        <?php do { ?>
          <tr>
            <td>
            <a href="delcoord.php?del=<?php echo $row_financiadores['cod_finnanciador']; ?>&a=financiador&b=cod_finnanciador&c=financiadores" data-toggle="tooltip" data-placement="top" title="Eliminar este registro de la LISTA DE FINANCIADORES" onclick="if(!confirm('<?php echo $alertborrar; ?>'))return false"><i class="fa fa-close fa-2x"></i></a>
            </td>
            <td>
<a class="btn btn-succes" data-toggle='modal' data-target='#option' onClick="ventana('editarfi','<?php echo $row_financiadores['cod_finnanciador']; ?>','pop')">
<i class="fa fa-pencil fa-2x"></i>
</a>
            </td>
            <td><?php echo $row_financiadores['id_financiador']; ?></td>
            <td data-toggle="tooltip" data-placement="top" title="Para ver los indicadores de este financiador CLICK EN VER INDICADORES >>>>" ><?php echo $row_financiadores['nombre_financiador']; ?></td>
            <td><a href="indicador.php?finan=<?php echo $row_financiadores['cod_finnanciador']; ?>" class="btn btn-block btn-default">
<span class="badge"><?php

		$contare = mysqli_query($conexion, contare('indicador','cod_financiador_ind',$row_financiadores['cod_finnanciador'])) or die(mysqli_error($conexion));
		$row_contare = mysqli_fetch_assoc($contare);
		    if(isset($row_contare)){
      if($row_contare['disp'] > 0 ) {$valc=$row_contare['disp'];}else{$valc=0;}
      echo $valc;
    } else {
      echo '0';
    }

		?></span>
            </a></td>
            </tr>
          <?php } while ($row_financiadores = mysqli_fetch_assoc($financiadores)); ?>
          </tbody>
        </table>
<table border="0">
        <tr>
          <td><?php if ($pageNum_financiadores > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_financiadores=%d%s", $currentPage, 0, $queryString_financiadores); ?>">Primero</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_financiadores > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_financiadores=%d%s", $currentPage, max(0, $pageNum_financiadores - 1), $queryString_financiadores); ?>">Anterior</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_financiadores < $totalPages_financiadores) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_financiadores=%d%s", $currentPage, min($totalPages_financiadores, $pageNum_financiadores + 1), $queryString_financiadores); ?>">Siguiente</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_financiadores < $totalPages_financiadores) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_financiadores=%d%s", $currentPage, $totalPages_financiadores, $queryString_financiadores); ?>">&Uacute;ltimo</a>
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
        <h4 class="modal-title" id="myModalLabel">NUEVO PLAN DE ACCIÓN</h4>
      </div>
      <div class="modal-body">
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table class="table">
        <tr valign="baseline">
          <td align="center" valign="middle" nowrap bgcolor="#CCCCCC">NOMBRE:</td>
          <td bgcolor="#CCCCCC"><text type="text" name="nombre_financiador" value="" class="form-control"></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC"><input type="submit" value="Insertar registro" class="btn btn-block btn-default"></td>
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
mysqli_free_result($financiadores);
?>