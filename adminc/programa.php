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
	$codprograma=generarCodigo(16);
  $insertSQL = sprintf("INSERT INTO programa (cod_programa, cod_pilar_pro, titulo_programa, descr_programa, orden_programa) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($codprograma, "text"),
                       GetSQLValueString($_POST['cod_pilar_pro'], "text"),
                       GetSQLValueString($_POST['titulo_programa'], "text"),
                       GetSQLValueString($_POST['descr_programa'], "text"),
					   GetSQLValueString($_POST['orden'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "programa.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_programadelpi = 10;
$pageNum_programadelpi = 0;
if (isset($_GET['pageNum_programadelpi'])) {
  $pageNum_programadelpi = $_GET['pageNum_programadelpi'];
}
$startRow_programadelpi = $pageNum_programadelpi * $maxRows_programadelpi;

$colname_programadelpi = "-1";
if (isset($_GET['pilar'])) {
  $colname_programadelpi = $_GET['pilar'];
}
mysqli_select_db($conexion, $database_conexion);
$query_programadelpi = sprintf("SELECT * FROM pilar LEFT JOIN programa ON pilar.cod_pilar=programa.cod_pilar_pro WHERE programa.cod_pilar_pro = %s ORDER BY programa.orden_programa ASC", GetSQLValueString($colname_programadelpi, "text"));
$query_limit_programadelpi = sprintf("%s LIMIT %d, %d", $query_programadelpi, $startRow_programadelpi, $maxRows_programadelpi);
$programadelpi = mysqli_query($conexion, $query_limit_programadelpi) or die(mysqli_error($conexion));
$row_programadelpi = mysqli_fetch_assoc($programadelpi);

if (isset($_GET['totalRows_programadelpi'])) {
  $totalRows_programadelpi = $_GET['totalRows_programadelpi'];
} else {
  $all_programadelpi = mysqli_query($conexion, $query_programadelpi);
  $totalRows_programadelpi = mysqli_num_rows($all_programadelpi);
}
$totalPages_programadelpi = ceil($totalRows_programadelpi/$maxRows_programadelpi)-1;

$queryString_programadelpi = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_programadelpi") == false &&
        stristr($param, "totalRows_programadelpi") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_programadelpi = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_programadelpi = sprintf("&totalRows_programadelpi=%d%s", $totalRows_programadelpi, $queryString_programadelpi);
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
								<a href="../adminc/" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-default"><i class="fa fa-reply"></i></a>
                                <a href="../adminc/" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-primary">COMPONENTE <?php echo $row_programadelpi['orden_pilar']; ?></a>

							</div>
				</h4>
              </div>
         </div>

          <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile">
                <div class="x_title">
                  <h2>PROGRAMAS</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-block btn-default">Registrar Nuevo Programa</a>
                    </li>
                  </ul>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
<table id="datatable-responsive" class="table table-bordered table-hover" cellspacing="0" >
<thead>
        <tr>
          <th width="18" align="center" valign="middle" bgcolor="#2A3F54"></th>
          <th width="18" align="center" valign="middle" bgcolor="#2A3F54">&nbsp;</th>
          <th width="160" height="37" align="center" valign="middle" bgcolor="#2A3F54">CODIGO</th>
          <th width="300 " align="center" valign="middle" bgcolor="#2A3F54">TITULO</th>
          <th width="300" align="center" valign="middle" bgcolor="#2A3F54">DESCRIPCION</th>
          <th width="46" align="center" valign="middle" bgcolor="#2A3F54">ACCION</th>
        </tr>
</thead>
<tbody>
<?php 
$orden=0;
 do { 
if($row_programadelpi['orden_programa'] >= $orden)
{
$orden=$row_programadelpi['orden_programa'];
}
?>

          <tr>
            <td align="center">
              <a href="delcoord.php?del=<?php echo $row_programadelpi['cod_programa']; ?>&pilar=<?php echo $_GET['pilar']; ?>&a=programa&b=cod_programa&c=programa" data-toggle="tooltip" data-placement="top" title="Eliminar este registro de la LISTA DE PROGRAMAS" onclick="if(!confirm('<?php echo $alertborrar; ?>'))return false"><i class="fa fa-close fa-2x"></i></a>
            </td>
            <td align="center">
            <a class="btn btn-succes" data-toggle='modal' data-target='#option' onClick="ventana('editarp','<?php echo $row_programadelpi['cod_programa'].'&pilar='.$_GET['pilar']; ?>','pop')">
<i class="fa fa-pencil fa-2x"></i>
</a>
            </td>
            <td align="center">
PROGRAMA <?php echo $row_programadelpi['orden_pilar']; ?>.<?php echo $row_programadelpi['orden_programa']; ?> :</td>
            <td><?php echo $row_programadelpi['titulo_programa']; ?></td>
            <td><?php echo $row_programadelpi['descr_programa']; ?></td>
            <td><a href="accion.php?pilar=<?php echo $_GET['pilar']; ?>&programa=<?php echo $row_programadelpi['cod_programa']; ?>" class="btn btn-block btn-default"><span class="badge"><?php
		$x=contare('accion','cod_programa_ac',$row_programadelpi['cod_programa']);
		$contare = mysqli_query($conexion, $x) or die(mysqli_error($conexion));
		$row_contare = mysqli_fetch_assoc($contare);
		    if(isset($row_contare)){
      if($row_contare['disp'] > 0 ) {$valc=$row_contare['disp'];}else{$valc=0;}
      echo $valc;
    } else {
      echo '0';
    }

		?></span></a></td>
          </tr>
          <?php } while ($row_programadelpi = mysqli_fetch_assoc($programadelpi)); ?>
</tbody>
    </table>
    <table border="0">
        <tr>
          <td><?php if ($pageNum_programadelpi > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_programadelpi=%d%s", $currentPage, 0, $queryString_programadelpi); ?>">Primero</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_programadelpi > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_programadelpi=%d%s", $currentPage, max(0, $pageNum_programadelpi - 1), $queryString_programadelpi); ?>">Anterior</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_programadelpi < $totalPages_programadelpi) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_programadelpi=%d%s", $currentPage, min($totalPages_programadelpi, $pageNum_programadelpi + 1), $queryString_programadelpi); ?>">Siguiente</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_programadelpi < $totalPages_programadelpi) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_programadelpi=%d%s", $currentPage, $totalPages_programadelpi, $queryString_programadelpi); ?>">&Uacute;ltimo</a>
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
        <h4 class="modal-title" id="myModalLabel">NUEVO REGISTRO PROGRAMA</h4>
      </div>
      <div class="modal-body">
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table class="table">
    <tr valign="baseline">
      <td bgcolor="#CCCCCC"><input type="hidden" name="cod_pilar_pro" value="<?php echo $_GET['pilar']; ?>" class="form-control"></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC">TITULO</td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC"><input type="text" name="titulo_programa"  class="form-control" required></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC">DESCRIPCION</td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC"><label for="descr_programa"></label>
      <textarea name="descr_programa" id="descr_programa" class="form-control"></textarea></td>
    </tr>
	<tr valign="baseline">
      <td bgcolor="#CCCCCC">ORDEN</td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC"><input type="text" name="orden" value="<?php echo $orden + 1; ?>"  class="form-control" required></td>
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
mysqli_free_result($programadelpi);
?>