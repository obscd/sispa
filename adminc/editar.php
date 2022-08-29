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
  $updateSQL = sprintf("UPDATE pilar SET titulo_pilar=%s, descr_pilar=%s, orden_pilar=%s WHERE cod_pilar=%s",
                       GetSQLValueString($_POST['titulo_pilar'], "text"),
                       GetSQLValueString($_POST['descr_pilar'], "text"),
                       GetSQLValueString($_POST['orden_pilar'], "int"),
                       GetSQLValueString($_POST['cod_pilar'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editar = "-1";
if (isset($_GET['area'])) {
  $colname_editar = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_editar = sprintf("SELECT * FROM pilar WHERE cod_pilar = %s", GetSQLValueString($colname_editar, "text"));
$editar = mysqli_query($conexion, $query_editar) or die(mysqli_error($conexion));
$row_editar = mysqli_fetch_assoc($editar);
$totalRows_editar = mysqli_num_rows($editar);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table border="0" cellspacing="0" class="table">
    <tr valign="baseline">
      <td height="35" valign="middle" bgcolor="#CCCCCC"><strong>TITULO</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC">
        <input type="text" name="titulo_pilar" value="<?php echo htmlentities($row_editar['titulo_pilar'], ENT_COMPAT, 'utf-8'); ?>" class="form-control">
      </td>
    </tr>
    <tr valign="baseline">
      <td height="35" valign="middle" bgcolor="#CCCCCC"><strong>DESCRIPCION</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC">
        <textarea name="descr_pilar" cols="50" rows="5"  class="form-control"><?php echo htmlentities($row_editar['descr_pilar'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td height="35" valign="middle" bgcolor="#CCCCCC"><strong>ORDEN</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC">
        <input type="text" name="orden_pilar" value="<?php echo htmlentities($row_editar['orden_pilar'], ENT_COMPAT, 'utf-8'); ?>" class="form-control">
      </td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC"><strong>
        <input type="submit" value="Actualizar" class="btn btn-block btn-success">
      </strong></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_pilar" value="<?php echo $row_editar['cod_pilar']; ?>">
</form>

</body>
</html>
<?php
mysqli_free_result($editar);
?>
