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
  $updateSQL = sprintf("UPDATE imagenesadicionales SET descripcion=%s WHERE id_image_adi=%s",
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['id_image_adi'], "int"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "../upload/";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editartext = "-1";
if (isset($_GET['area'])) {
  $colname_editartext = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_editartext = sprintf("SELECT * FROM imagenesadicionales WHERE id_image_adi = %s", GetSQLValueString($colname_editartext, "int"));
$editartext = mysqli_query($conexion, $query_editartext) or die(mysqli_error($conexion));
$row_editartext = mysqli_fetch_assoc($editartext);
$totalRows_editartext = mysqli_num_rows($editartext);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table class="table">
    <tr valign="baseline">
      <td bgcolor="#ccc">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#ccc"><strong>DESCRIPCION</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#ccc"><label for="descripcion"></label>
        <textarea name="descripcion" id="descripcion" class="form-control"><?php echo htmlentities($row_editartext['descripcion'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#ccc">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#ccc"><input type="submit" value="Actualizar" class="btn btn-block btn-success"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_image_adi" value="<?php echo $row_editartext['id_image_adi']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($editartext);
?>
