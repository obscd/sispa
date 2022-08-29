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
  $updateSQL = sprintf("UPDATE meta SET descrp_img_meta=%s, id_img_meta=%s WHERE cod_meta=%s",
                       GetSQLValueString('-', "text"),
                       GetSQLValueString($_POST['id_img_meta'], "text"),
                       GetSQLValueString($_POST['cod_meta'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "metas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysqli_select_db($conexion, $database_conexion);
$query_listarimagenes = "SELECT * FROM imagenesadicionales ORDER BY descripcion ASC";
$listarimagenes = mysqli_query($conexion, $query_listarimagenes) or die(mysqli_error($conexion));
$row_listarimagenes = mysqli_fetch_assoc($listarimagenes);
$totalRows_listarimagenes = mysqli_num_rows($listarimagenes);

$colname_editarmetaim = "-1";
if (isset($_GET['area'])) {
  $colname_editarmetaim = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_editarmetaim = sprintf("SELECT * FROM meta WHERE cod_meta = %s", GetSQLValueString($colname_editarmetaim, "text"));
$editarmetaim = mysqli_query($conexion, $query_editarmetaim) or die(mysqli_error($conexion));
$row_editarmetaim = mysqli_fetch_assoc($editarmetaim);
$totalRows_editarmetaim = mysqli_num_rows($editarmetaim);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    
   <tr valign="baseline">
      <td>IMAGEN</td>
    <tr valign="baseline">
      <td><select name="id_img_meta" class="form-control">
	  <option value=''>sin imagen</option>
        <?php 
do {  
?>
        <option value="<?php echo $row_listarimagenes['codigo_img_adicional']?>" <?php if (!(strcmp($row_listarimagenes['codigo_img_adicional'], htmlentities($row_editarmetaim['id_img_meta'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_listarimagenes['descripcion']?></option>
        <?php
} while ($row_listarimagenes = mysqli_fetch_assoc($listarimagenes));
?>
      </select></td>
    <tr valign="baseline">
      <td align="right"><input type="submit" value="Actualizar" class="btn btn-default"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_meta" value="<?php echo $row_editarmetaim['cod_meta']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($listarimagenes);

mysqli_free_result($editarmetaim);
?>