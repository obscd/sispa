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

$maxRows_listaareasinst = 10;
$pageNum_listaareasinst = 0;
if (isset($_GET['pageNum_listaareasinst'])) {
  $pageNum_listaareasinst = $_GET['pageNum_listaareasinst'];
}
$startRow_listaareasinst = $pageNum_listaareasinst * $maxRows_listaareasinst;

$colname_listaareasinst = "-1";
if (isset($_GET['institucion'])) {
  $colname_listaareasinst = $_GET['institucion'];
}
mysqli_select_db($conexion, $database_conexion);
$query_listaareasinst = sprintf("SELECT * FROM areas_instituciones WHERE cod_institucion_area = %s ORDER BY sigla_areas_inst ASC", GetSQLValueString($colname_listaareasinst, "text"));
$query_limit_listaareasinst = sprintf("%s LIMIT %d, %d", $query_listaareasinst, $startRow_listaareasinst, $maxRows_listaareasinst);
$listaareasinst = mysql_query($query_limit_listaareasinst, $conexion) or die(mysqli_error($conexion));
$row_listaareasinst = mysqli_fetch_assoc($listaareasinst);

if (isset($_GET['totalRows_listaareasinst'])) {
  $totalRows_listaareasinst = $_GET['totalRows_listaareasinst'];
} else {
  $all_listaareasinst = mysql_query($query_listaareasinst);
  $totalRows_listaareasinst = mysqli_num_rows($all_listaareasinst);
}
$totalPages_listaareasinst = ceil($totalRows_listaareasinst/$maxRows_listaareasinst)-1;

$queryString_listaareasinst = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listaareasinst") == false && 
        stristr($param, "totalRows_listaareasinst") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listaareasinst = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listaareasinst = sprintf("&totalRows_listaareasinst=%d%s", $totalRows_listaareasinst, $queryString_listaareasinst);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$codigoareainst=generarCodigo(16); 
  $insertSQL = sprintf("INSERT INTO areas_instituciones (codigo_area_inst, cod_institucion_area, sigla_areas_inst, nombre_areas_inst, descrp_areas_inst) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($codigoareainst, "text"),
                       GetSQLValueString($_POST['cod_institucion_area'], "text"),
                       GetSQLValueString($_POST['sigla_areas_inst'], "text"),
                       GetSQLValueString($_POST['nombre_areas_inst'], "text"),
                       GetSQLValueString($_POST['descrp_areas_inst'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "instituciones_areas.php";
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

<table width="100%" border="1">
  <tr>
    <th width="29%" scope="col"><a href="instituciones.php">inicio</a></th>
    <th width="71%" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap>REGISTRAR AREAS DE LA INSTITUCION</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"></td>
      <td><input type="hidden" name="cod_institucion_area" value="<?php echo $_GET['institucion']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Sigla_areas_inst:</td>
      <td><input type="text" name="sigla_areas_inst" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nombre_areas_inst:</td>
      <td><input type="text" name="nombre_areas_inst" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Descrp_areas_inst:</td>
      <td><textarea name="descrp_areas_inst" cols="50" rows="5"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form></td>
    <td><table border="1" align="center">
        <tr>
          <td height="36" bgcolor="#CCCCCC">id_responsables</td>
          <td bgcolor="#CCCCCC">sigla_areas_inst</td>
          <td bgcolor="#CCCCCC">nombre_areas_inst</td>
          <td bgcolor="#CCCCCC">descrp_areas_inst</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_listaareasinst['id_responsables']; ?></td>
            <td><?php echo $row_listaareasinst['sigla_areas_inst']; ?></td>
            <td><?php echo $row_listaareasinst['nombre_areas_inst']; ?></td>
            <td><?php echo $row_listaareasinst['descrp_areas_inst']; ?></td>
          </tr>
          <?php } while ($row_listaareasinst = mysqli_fetch_assoc($listaareasinst)); ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table border="0">
        <tr>
          <td><?php if ($pageNum_listaareasinst > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listaareasinst=%d%s", $currentPage, 0, $queryString_listaareasinst); ?>">Primero</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listaareasinst > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listaareasinst=%d%s", $currentPage, max(0, $pageNum_listaareasinst - 1), $queryString_listaareasinst); ?>">Anterior</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listaareasinst < $totalPages_listaareasinst) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listaareasinst=%d%s", $currentPage, min($totalPages_listaareasinst, $pageNum_listaareasinst + 1), $queryString_listaareasinst); ?>">Siguiente</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_listaareasinst < $totalPages_listaareasinst) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listaareasinst=%d%s", $currentPage, $totalPages_listaareasinst, $queryString_listaareasinst); ?>">&Uacute;ltimo</a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($listaareasinst);
?>
