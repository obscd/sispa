<?php 
require_once('../locklvl.php'); 
$MM_authorizedUsers =usuario(3);
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
$colname_editardoc = "-1";
if (isset($_GET['item'])) {
  $colname_editardoc = $_GET['item'];
}
mysqli_select_db($conexion, $database_conexion);
$query_editardoc = sprintf("SELECT * FROM documentos WHERE id_documentos = %s AND usuario_doc=%s", GetSQLValueString($colname_editardoc, "int"), GetSQLValueString($_SESSION["MM_Username"], "text"));
$editardoc = mysql_query($query_editardoc, $conexion) or die(mysqli_error($conexion));
$row_editardoc = mysqli_fetch_assoc($editardoc);
$totalRows_editardoc = mysqli_num_rows($editardoc);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE documentos SET documentos_tipo=%s, documentos_descripcion=%s WHERE id_documentos=%s",
                       GetSQLValueString($_POST['documentos_tipo'], "text"),
                       GetSQLValueString($_POST['documentos_descripcion'], "text"),
                       GetSQLValueString($_POST['id_documentos'], "int"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "documentos.php?item=".$_POST['item'];
  header("Location: ".$updateGoTo);
 
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<form class="edite" name="edite" id="edite" role="form">
  <table class="table">
    <tr valign="baseline">
      <th align="center" nowrap>EDITOR</th>
    </tr>
    <tr valign="baseline">
      <td><strong>TITULO DOCUMENTO:</strong></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="documentos_tipo" value="<?php echo htmlentities($row_editardoc['documentos_tipo'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr>
    <tr valign="baseline">
      <td><strong>DESCRIPCIOIN:</strong></td>
    </tr>
    <tr valign="baseline">
      <td><textarea name="documentos_descripcion" rows="5"  class="form-control" id="documentos_descripcion"><?php echo htmlentities($row_editardoc['documentos_descripcion'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td>
        <a onclick="nre('editdoc','edite','busquedad')" class="btn btn-success">Guardar Cambios</a>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_documentos" value="<?php echo $row_editardoc['id_documentos']; ?>">
  <input type="hidden" name="item" value="<?php echo $row_editardoc['cod_meta_doc']; ?>">
</form>

</body>
</html>
<?php
mysqli_free_result($editardoc);
?>
