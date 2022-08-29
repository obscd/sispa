<?php require_once('Connections/conexion.php'); ?>
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
$respon='';
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==0)
	{
	$updateSQL = sprintf("UPDATE meta SET cumplimiento_meta=%s, respuesta_real_decumpl=%s WHERE cod_meta=%s",
                       GetSQLValueString($_POST['cumplimiento_meta'], "int"),
                       GetSQLValueString($_POST['respuesta_real_decumpl'], "int"),
                       GetSQLValueString($_POST['cod_meta'], "text"));	
	}
    else
	{
		$respon='x';
		$updateSQL = sprintf("UPDATE meta SET respuesta_real_decumpl=%s WHERE cod_meta=%s",
                       GetSQLValueString($_POST['respuesta_real_decumpl'], "int"),
                       GetSQLValueString($_POST['cod_meta'], "text"));
	}

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));
 if($_POST['tp']!='rep')
 {
  $updateGoTo = $_POST['fl']."/".$_POST['ph'].".php?financiador=".$_POST['tp'];
 }
 else
 {
	 $updateGoTo = 'reporte general/';
 }
 if($respon=='x')
 {
	 $updateGoTo = $_POST['fl']."/".$_POST['ph'].".php";
 }
  
  header('Location: '.$updateGoTo);
exit();
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_actualizar = "-1";
if (isset($_GET['cod_meta'])) {
  $colname_actualizar = $_GET['cod_meta'];
}
mysqli_select_db($conexion, $database_conexion);
$query_actualizar = sprintf("SELECT * FROM meta WHERE cod_meta = %s", GetSQLValueString($colname_actualizar, "text"));
$actualizar = mysqli_query($conexion, $query_actualizar) or die(mysqli_error($conexion));
$row_actualizar = mysqli_fetch_assoc($actualizar);
$totalRows_actualizar = mysqli_num_rows($actualizar);
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
      <td nowrap align="right">Cumplimiento_meta:</td>
      <td><input type="text" name="cumplimiento_meta" value="<?php echo htmlentities($row_actualizar['cumplimiento_meta'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Respuesta_real_decumpl:</td>
      <td><input type="text" name="respuesta_real_decumpl" value="<?php echo htmlentities($row_actualizar['respuesta_real_decumpl'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_meta" value="<?php echo $row_actualizar['cod_meta']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($actualizar);
?>
