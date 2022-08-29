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
  $updateSQL = sprintf("UPDATE actividad SET descr_actividad=%s, orden_actividad=%s WHERE cod_actividad=%s",
                       GetSQLValueString($_POST['descr_actividad'], "text"),
                       GetSQLValueString($_POST['orden_actividad'], "int"),
                       GetSQLValueString($_POST['cod_actividad'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "actividades.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editaract = "-1";
if (isset($_GET['area'])) {
  $colname_editaract = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_editaract = sprintf("SELECT * FROM actividad WHERE cod_actividad = %s ORDER BY cod_actividad ASC", GetSQLValueString($colname_editaract, "text"));
$editaract = mysqli_query($conexion, $query_editaract) or die(mysqli_error($conexion));
$row_editaract = mysqli_fetch_assoc($editaract);
$totalRows_editaract = mysqli_num_rows($editaract);
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
      <td height="35" valign="middle" bgcolor="#CCC"><strong>DESCRIPCION</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC"><textarea name="descr_actividad" cols="50" rows="5" class="form-control"><?php echo htmlentities($row_editaract['descr_actividad'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td height="35" valign="middle" bgcolor="#CCC"><strong>ACTIVIDAD</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC"><input type="text" name="orden_actividad" value="<?php echo htmlentities($row_editaract['orden_actividad'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC"><input type="submit" value="Actualizar" class="btn btn-block btn-success"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_actividad" value="<?php echo $row_editaract['cod_actividad']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($editaract);
?>
