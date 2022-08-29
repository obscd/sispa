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

mysqli_select_db($conexion, $database_conexion);
$query_listadeareasinstituciones = "SELECT * FROM areas_instituciones ORDER BY id_responsables ASC";
$listadeareasinstituciones = mysql_query($query_listadeareasinstituciones, $conexion) or die(mysqli_error($conexion));
$row_listadeareasinstituciones = mysqli_fetch_assoc($listadeareasinstituciones);
$totalRows_listadeareasinstituciones = mysqli_num_rows($listadeareasinstituciones);

$maxRows_listaderesponsables = 10;
$pageNum_listaderesponsables = 0;
if (isset($_GET['pageNum_listaderesponsables'])) {
  $pageNum_listaderesponsables = $_GET['pageNum_listaderesponsables'];
}
$startRow_listaderesponsables = $pageNum_listaderesponsables * $maxRows_listaderesponsables;

$colname_listaderesponsables = "-1";
if (isset($_GET['actividad'])) {
  $colname_listaderesponsables = $_GET['actividad'];
}
mysqli_select_db($conexion, $database_conexion);
$query_listaderesponsables = sprintf("SELECT * FROM (responsable LEFT JOIN areas_instituciones ON responsable.codigo_ente_responsable=areas_instituciones.codigo_area_inst) WHERE responsable.cod_responsable_de = %s ORDER BY id_responsable ASC", GetSQLValueString($colname_listaderesponsables, "text"));
$query_limit_listaderesponsables = sprintf("%s LIMIT %d, %d", $query_listaderesponsables, $startRow_listaderesponsables, $maxRows_listaderesponsables);
$listaderesponsables = mysql_query($query_limit_listaderesponsables, $conexion) or die(mysqli_error($conexion));
$row_listaderesponsables = mysqli_fetch_assoc($listaderesponsables);

if (isset($_GET['totalRows_listaderesponsables'])) {
  $totalRows_listaderesponsables = $_GET['totalRows_listaderesponsables'];
} else {
  $all_listaderesponsables = mysql_query($query_listaderesponsables);
  $totalRows_listaderesponsables = mysqli_num_rows($all_listaderesponsables);
}
$totalPages_listaderesponsables = ceil($totalRows_listaderesponsables/$maxRows_listaderesponsables)-1;

$queryString_listaderesponsables = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listaderesponsables") == false && 
        stristr($param, "totalRows_listaderesponsables") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listaderesponsables = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listaderesponsables = sprintf("&totalRows_listaderesponsables=%d%s", $totalRows_listaderesponsables, $queryString_listaderesponsables);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
  $insertSQL = sprintf("INSERT INTO responsable (cod_responsable_de, codigo_ente_responsable) VALUES (%s, %s)",
                       GetSQLValueString($_GET['actividad'], "text"),
                       GetSQLValueString($_POST['codigo_ente_responsable'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "responsables.php";
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
    <th width="18%" scope="col"><a href="../adminc">inicio</a></th>
    <th width="82%" scope="col">LISTA RESPONSABLES DE ACTIVIDAD</th>
  </tr>
  <tr>
    <td><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td height="37" colspan="2" align="right" nowrap>ASIGNAR RESPONSABLES DE ACTIVIDAD</td>
      </tr>
    <tr valign="baseline">
      <td nowrap align="right">Codigo_ente_responsable:</td>
      <td><label for="codigo_ente_responsable"></label>
        <select name="codigo_ente_responsable" id="codigo_ente_responsable">
          <?php
do {  
?>
          <option value="<?php echo $row_listadeareasinstituciones['codigo_area_inst']?>"><?php echo $row_listadeareasinstituciones['nombre_areas_inst']?></option>
          <?php
} while ($row_listadeareasinstituciones = mysqli_fetch_assoc($listadeareasinstituciones));
  $rows = mysqli_num_rows($listadeareasinstituciones);
  if($rows > 0) {
      mysqli_data_seek($listadeareasinstituciones, 0);
	  $row_listadeareasinstituciones = mysqli_fetch_assoc($listadeareasinstituciones);
  }
?>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form></td>
    <td>&nbsp;
      <table border="1" align="center">
        <tr>
          <td height="39" bgcolor="#CCCCCC">id_responsable</td>
          <td bgcolor="#CCCCCC">sigla_areas_inst</td>
          <td bgcolor="#CCCCCC">nombre_areas_inst</td>
          <td bgcolor="#CCCCCC">descrp_areas_inst</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_listaderesponsables['id_responsable']; ?></td>
            <td><?php echo $row_listaderesponsables['sigla_areas_inst']; ?></td>
            <td><?php echo $row_listaderesponsables['nombre_areas_inst']; ?></td>
            <td><?php echo $row_listaderesponsables['descrp_areas_inst']; ?></td>
          </tr>
          <?php } while ($row_listaderesponsables = mysqli_fetch_assoc($listaderesponsables)); ?>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;
      <table border="0">
        <tr>
          <td><?php if ($pageNum_listaderesponsables > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listaderesponsables=%d%s", $currentPage, 0, $queryString_listaderesponsables); ?>">Primero</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listaderesponsables > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listaderesponsables=%d%s", $currentPage, max(0, $pageNum_listaderesponsables - 1), $queryString_listaderesponsables); ?>">Anterior</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listaderesponsables < $totalPages_listaderesponsables) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listaderesponsables=%d%s", $currentPage, min($totalPages_listaderesponsables, $pageNum_listaderesponsables + 1), $queryString_listaderesponsables); ?>">Siguiente</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_listaderesponsables < $totalPages_listaderesponsables) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listaderesponsables=%d%s", $currentPage, $totalPages_listaderesponsables, $queryString_listaderesponsables); ?>">&Uacute;ltimo</a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($listadeareasinstituciones);

mysqli_free_result($listaderesponsables);
?>
