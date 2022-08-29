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
    // $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
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
  // $updateSQL = sprintf("UPDATE indicador SET descr_indicador=%s, pond_2021=%s, pond_2022=%s, pond_2023=%s, pond_2024=%s, pond_2025=%s, indicador_orden=%s WHERE cod_indicador=%s",

  $updateSQL = sprintf("UPDATE indicador SET descr_indicador=%s, indicador_orden=%s WHERE cod_indicador=%s",
                      GetSQLValueString($_POST['descr_indicador'], "text"),
                      // str_replace(",", ".", GetSQLValueString($_POST['2021'], "text")),
                      // str_replace(",", ".", GetSQLValueString($_POST['2022'], "text")),
                      // str_replace(",", ".", GetSQLValueString($_POST['2023'], "text")),
                      // str_replace(",", ".", GetSQLValueString($_POST['2024'], "text")),
                      // str_replace(",", ".", GetSQLValueString($_POST['2025'], "text")),
                      GetSQLValueString($_POST['orden'], "int"),
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

$colname_editind = "-1";
if (isset($_GET['area'])) {
  $colname_editind = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_editind = sprintf("SELECT * FROM indicador WHERE cod_indicador = %s", GetSQLValueString($colname_editind, "text"));
$editind = mysqli_query($conexion, $query_editind) or die(mysqli_error($conexion));
$row_editind = mysqli_fetch_assoc($editind);
$totalRows_editind = mysqli_num_rows($editind);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center" class="table" style="background-color: #CCCCCC;">
    <tr valign="baseline">
      <td height="30" valign="middle">DESCRIPCION</td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle"><textarea name="descr_indicador" cols="50" rows="5" class="form-control"><?php echo htmlentities($row_editind['descr_indicador'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
<!-- 
    <tr valign="baseline">
      <td height="30" valign="middle">PONDERACION 2021</td>
      <td height="30" valign="middle">
      <input name="2021" type="text" id="2021" value="<?php echo htmlentities($row_editind['pond_2021'], ENT_COMPAT, 'utf-8'); ?>"></td>
    </tr>

    <tr valign="baseline">
      <td height="30" valign="middle">PONDERACION 2022</td>
      <td height="30" valign="middle"><input name="2022" type="text" id="2022" value="<?php echo htmlentities($row_editind['pond_2022'], ENT_COMPAT, 'utf-8'); ?>"></td>
    </tr>

    <tr valign="baseline">
      <td height="30" valign="middle">PONDERACION 2023</td>
      <td height="30" valign="middle"><input name="2023" type="text" id="2023" value="<?php echo htmlentities($row_editind['pond_2023'], ENT_COMPAT, 'utf-8'); ?>"></td>
    </tr>

    <tr valign="baseline">
      <td height="30" valign="middle">PONDERACION 2024</td>
      <td height="30" valign="middle"><input name="2024" type="text" id="2024" value="<?php echo htmlentities($row_editind['pond_2024'], ENT_COMPAT, 'utf-8'); ?>"></td>
    </tr>

    <tr valign="baseline">
      <td height="30" valign="middle">PONDERACION 2025</td>
      <td height="30" valign="middle"><input name="2025" type="text" id="2025" value="<?php echo htmlentities($row_editind['pond_2025'], ENT_COMPAT, 'utf-8'); ?>"></td>
    </tr> -->

    <tr valign="baseline">
      <td height="30" valign="middle">ORDEN</td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle">
      <input name="orden" type="text" id="orden" value="<?php echo htmlentities($row_editind['indicador_orden'], ENT_COMPAT, 'utf-8'); ?>"></td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle"><input type="submit" value="Actualizar"  class="btn btn-block btn-success"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_indicador" value="<?php echo $row_editind['cod_indicador']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($editind);
?>
