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
$colname_verificaritem = "-1";
if (isset($_GET['item'])) {
  $colname_verificaritem = $_GET['item'];
}
mysqli_select_db($conexion, $database_conexion);
$query_verificaritem = sprintf("SELECT * FROM documentos WHERE id_documentos = %s AND usuario_doc=%s", GetSQLValueString($colname_verificaritem, "int"), GetSQLValueString($_SESSION["MM_Username"], "text"));
$verificaritem = mysql_query($query_verificaritem, $conexion) or die(mysqli_error($conexion));
$row_verificaritem = mysqli_fetch_assoc($verificaritem);
$totalRows_verificaritem = mysqli_num_rows($verificaritem);

if($row_verificaritem['id_documentos'] > 0 && $row_verificaritem['cod_meta_doc'] !='')
{
	
if ((isset($_GET['item'])) && ($_GET['item'] != "")) {
  $deleteSQL = sprintf("DELETE FROM documentos WHERE id_documentos=%s",
                       GetSQLValueString($_GET['item'], "int"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $deleteSQL) or die(mysqli_error($conexion));

  echo $deleteGoTo = "documentos.php?item=".$row_verificaritem['cod_meta_doc'];
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  //header(sprintf("Location: %s", $deleteGoTo));
  header("Location: ".$deleteGoTo);
}

	
}





mysqli_free_result($verificaritem);
?>
