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
$respon='';
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$updateSQL = sprintf("UPDATE meta SET respuesta_real_decumpl=%s, meta_estd_sit=%s  WHERE cod_meta=%s",
                       GetSQLValueString($_POST['respuesta_real_decumpl'], "int"),
                       GetSQLValueString($_POST['situacion'], "text"),
                       GetSQLValueString($_POST['cod_meta'], "text"));	
    
  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header('Location: ../responsables');
}

$colname_actualizar = "-1";
if (isset($_GET['cod_meta'])) {
  $colname_actualizar = $_GET['cod_meta'];
}
mysqli_select_db($conexion, $database_conexion);
$query_actualizar = sprintf("SELECT * FROM meta WHERE cod_meta = %s", GetSQLValueString($colname_actualizar, "text"));
$actualizar = mysql_query($query_actualizar, $conexion) or die(mysqli_error($conexion));
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
</body>
</html>
<?php
mysqli_free_result($actualizar);
?>
