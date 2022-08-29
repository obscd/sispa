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
  $updateSQL = sprintf("UPDATE indicador SET descrp_img_indicador=%s, id_img_indicador=%s WHERE cod_indicador=%s",
                       GetSQLValueString($_POST['descrp_img_indicador'], "text"),
                       GetSQLValueString($_POST['id_img_indicador'], "text"),
                       GetSQLValueString($_POST['cod_indicador'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "indicador.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysqli_select_db($conexion, $database_conexion);
$query_seleccionarimagen = "SELECT * FROM imagenesadicionales ORDER BY descripcion ASC";
$seleccionarimagen = mysqli_query($conexion, $query_seleccionarimagen) or die(mysqli_error($conexion));
$row_seleccionarimagen = mysqli_fetch_assoc($seleccionarimagen);
$totalRows_seleccionarimagen = mysqli_num_rows($seleccionarimagen);

$colname_verindicador = "-1";
if (isset($_GET['area'])) {
  $colname_verindicador = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_verindicador = sprintf("SELECT * FROM indicador WHERE cod_indicador = %s", GetSQLValueString($colname_verindicador, "text"));
$verindicador = mysqli_query($conexion, $query_verindicador) or die(mysqli_error($conexion));
$row_verindicador = mysqli_fetch_assoc($verindicador);
$totalRows_verindicador = mysqli_num_rows($verindicador);
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
      <td>IMAGEN</td>
    <tr valign="baseline">
      <td><select name="id_img_indicador" class="form-control">
	  <option value=''>sin imagen</option>
        <?php 
do {  
?>
        <option data-thumbnail="../imagenesayuda/<?php echo $row_seleccionarimagen['codigo_img_adicional']?>" value="<?php echo $row_seleccionarimagen['codigo_img_adicional']?>" <?php if (!(strcmp($row_seleccionarimagen['codigo_img_adicional'], htmlentities($row_verindicador['id_img_indicador'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_seleccionarimagen['descripcion']?></option>
        <?php
} while ($row_seleccionarimagen = mysqli_fetch_assoc($seleccionarimagen));
?>
      </select></td>
    <tr valign="baseline">
      <td><input type="submit" value="Actualizar" class="btn btn-default"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_indicador" value="<?php echo $row_verindicador['cod_indicador']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($seleccionarimagen);

mysqli_free_result($verindicador);
?>