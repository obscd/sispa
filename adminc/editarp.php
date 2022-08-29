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
  $updateSQL = sprintf("UPDATE programa SET titulo_programa=%s, descr_programa=%s, orden_programa=%s WHERE cod_programa=%s",
                       GetSQLValueString($_POST['titulo_programa'], "text"),
                       GetSQLValueString($_POST['descr_programa'], "text"),
                       GetSQLValueString($_POST['orden_programa'], "int"),
                       GetSQLValueString($_POST['cod_programa'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "programa.php?pilar=".$_GET['pilar'];
  header("Location: ".$updateGoTo);
  exit();
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editarprogra = "-1";
if (isset($_GET['area'])) {
  $colname_editarprogra = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_editarprogra = sprintf("SELECT * FROM programa WHERE cod_programa = %s", GetSQLValueString($colname_editarprogra, "text"));
$editarprogra = mysqli_query($conexion, $query_editarprogra) or die(mysqli_error($conexion));
$row_editarprogra = mysqli_fetch_assoc($editarprogra);
$totalRows_editarprogra = mysqli_num_rows($editarprogra);
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
      <td height="35" valign="middle" bgcolor="#CCC"><strong>PROGRAMA</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC"><input type="text" name="titulo_programa" value="<?php echo htmlentities($row_editarprogra['titulo_programa'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr>
    <tr valign="baseline">
      <td height="35" valign="middle" bgcolor="#CCC"><strong>DESCRIPCION</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC"><textarea name="descr_programa" cols="50" rows="5" class="form-control"><?php echo htmlentities($row_editarprogra['descr_programa'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td height="35" valign="middle" bgcolor="#CCC"><strong>ORDEN</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC"><input type="text" name="orden_programa" value="<?php echo htmlentities($row_editarprogra['orden_programa'], ENT_COMPAT, 'utf-8'); ?>"  class="form-control"></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC"><input type="submit" value="Actualizar" class="btn btn-block btn-success"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_programa" value="<?php echo $row_editarprogra['cod_programa']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($editarprogra);
?>
