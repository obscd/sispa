<?php 
require_once('../locklvl.php'); 
$MM_authorizedUsers =usuario(0);
require_once('../lock.php'); ?>
<?php require_once('../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
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

$maxRows_listainstituciones = 10;
$pageNum_listainstituciones = 0;
if (isset($_GET['pageNum_listainstituciones'])) {
  $pageNum_listainstituciones = $_GET['pageNum_listainstituciones'];
}
$startRow_listainstituciones = $pageNum_listainstituciones * $maxRows_listainstituciones;

mysqli_select_db($conexion, $database_conexion);
$query_listainstituciones = "SELECT * FROM instituciones ORDER BY sigla_institucion ASC";
$query_limit_listainstituciones = sprintf("%s LIMIT %d, %d", $query_listainstituciones, $startRow_listainstituciones, $maxRows_listainstituciones);
$listainstituciones = mysql_query($query_limit_listainstituciones, $conexion) or die(mysqli_error($conexion));
$row_listainstituciones = mysqli_fetch_assoc($listainstituciones);

if (isset($_GET['totalRows_listainstituciones'])) {
  $totalRows_listainstituciones = $_GET['totalRows_listainstituciones'];
} else {
  $all_listainstituciones = mysql_query($query_listainstituciones);
  $totalRows_listainstituciones = mysqli_num_rows($all_listainstituciones);
}
$totalPages_listainstituciones = ceil($totalRows_listainstituciones/$maxRows_listainstituciones)-1;

$queryString_listainstituciones = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listainstituciones") == false && 
        stristr($param, "totalRows_listainstituciones") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listainstituciones = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listainstituciones = sprintf("&totalRows_listainstituciones=%d%s", $totalRows_listainstituciones, $queryString_listainstituciones);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$codinst=generarCodigo(16);
  $insertSQL = sprintf("INSERT INTO instituciones (cod_institucion, sigla_institucion, nombre_institucion, descr_institucion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($codinst, "text"),
                       GetSQLValueString($_POST['sigla_institucion'], "text"),
                       GetSQLValueString($_POST['nombre_institucion'], "text"),
                       GetSQLValueString($_POST['descr_institucion'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "instituciones.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <th width="21%" scope="col"><a href="index.php">pilares</a> | <a href="instituciones.php">instituciones</a> | <a href="financiadores.php">financiadores</a></th>
    <th width="79%" scope="col">LISTA DE INSTITUCIONES</th>
  </tr>
  <tr>
    <td><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap>REGISTRAR INSTITUCION</td>
      </tr>
    <tr valign="baseline">
      <td nowrap align="right">Sigla_institucion:</td>
      <td><input type="text" name="sigla_institucion" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nombre_institucion:</td>
      <td><input type="text" name="nombre_institucion" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Descr_institucion:</td>
      <td><label for="descr_institucion"></label>
        <textarea name="descr_institucion" id="descr_institucion"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form></td>
    <td><table width="951" border="1" align="center">
        <tr>
          <td width="192">id_institucion</td>
          <td width="207">sigla_institucion</td>
          <td width="227">nombre_institucion</td>
          <td width="259">descr_institucion</td>
          <td width="32">&nbsp;</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_listainstituciones['id_institucion']; ?></td>
            <td><?php echo $row_listainstituciones['sigla_institucion']; ?></td>
            <td><?php echo $row_listainstituciones['nombre_institucion']; ?></td>
            <td><?php echo $row_listainstituciones['descr_institucion']; ?></td>
            <td><a href="instituciones_areas.php?institucion=<?php echo $row_listainstituciones['cod_institucion']; ?>">ver areas</a></td>
          </tr>
          <?php } while ($row_listainstituciones = mysqli_fetch_assoc($listainstituciones)); ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;
      <table border="0">
        <tr>
          <td><?php if ($pageNum_listainstituciones > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listainstituciones=%d%s", $currentPage, 0, $queryString_listainstituciones); ?>">Primero</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listainstituciones > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listainstituciones=%d%s", $currentPage, max(0, $pageNum_listainstituciones - 1), $queryString_listainstituciones); ?>">Anterior</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listainstituciones < $totalPages_listainstituciones) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listainstituciones=%d%s", $currentPage, min($totalPages_listainstituciones, $pageNum_listainstituciones + 1), $queryString_listainstituciones); ?>">Siguiente</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_listainstituciones < $totalPages_listainstituciones) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listainstituciones=%d%s", $currentPage, $totalPages_listainstituciones, $queryString_listainstituciones); ?>">&Uacute;ltimo</a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($listainstituciones);
?>
