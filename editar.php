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
// prueba con varialbes generados en iniciarportal.com de la carpeta hexDCRY
$XoQ3L = $_POST["\160\153"];
$xPPQB = $_POST["\x76\x61\x6c\x75\145"];
$fUqpU = explode("\151\x6e\x69\x63\x69\x61\x72\160\x6f\x72\164\141\154", $_POST["\x6e\x61\155\x65"]);
$Jixk7 = explode("\40", $_POST["\160\x6b"]);
if($fUqpU[0]!=''){
  $updateSQL = sprintf("UPDATE ".$fUqpU[0]." SET ".$Jixk7[1]."=%s WHERE ".$Jixk7[2]."=%s",
                       GetSQLValueString($xPPQB, "text"),
                       GetSQLValueString($Jixk7[0], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));
}
else
{
	echo "vacio";
}

?>
<?php
mysqli_free_result($editar);
?>
