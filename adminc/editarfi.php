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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE financiador SET nombre_financiador=%s WHERE cod_finnanciador=%s",
                       GetSQLValueString($_POST['nombre_financiador'], "text"),
                       GetSQLValueString($_POST['cod_finnanciador'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "financiadores.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_area = "-1";
if (isset($_GET['area'])) {
  $colname_area = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_area = sprintf("SELECT * FROM financiador WHERE cod_finnanciador = %s ORDER BY id_financiador ASC", GetSQLValueString($colname_area, "text"));
$area = mysqli_query($conexion, $query_area,) or die(mysqli_error($conexion));
$row_area = mysqli_fetch_assoc($area);
$totalRows_area = mysqli_num_rows($area);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table border="0" align="center" cellspacing="0" class="table">
    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#CCC"><strong>NOMBRE:</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC"><input type="text" name="nombre_financiador" value="<?php echo htmlentities($row_area['nombre_financiador'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC"><input type="submit" value="Actualizar" class="btn btn-block btn-success"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_finnanciador" value="<?php echo $row_area['cod_finnanciador']; ?>">
</form>

</body>
</html>
<?php
mysqli_free_result($area);
?>