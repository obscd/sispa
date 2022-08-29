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

$maxRows_buscarmetas = 100;
$pageNum_buscarmetas = 0;
if (isset($_GET['pageNum_buscarmetas'])) {
  $pageNum_buscarmetas = $_GET['pageNum_buscarmetas'];
}
$startRow_buscarmetas = $pageNum_buscarmetas * $maxRows_buscarmetas;

$colname_buscarmetas = "";
if (isset($_GET['area'])) {
  $colname_buscarmetas = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_buscarmetas = sprintf("SELECT * FROM meta WHERE descr_meta LIKE %s ORDER BY id_meta ASC", GetSQLValueString("%" . $colname_buscarmetas . "%", "text"));
$query_limit_buscarmetas = sprintf("%s LIMIT %d, %d", $query_buscarmetas, $startRow_buscarmetas, $maxRows_buscarmetas);
$buscarmetas = mysqli_query($conexion, $query_limit_buscarmetas) or die(mysqli_error($conexion));
$row_buscarmetas = mysqli_fetch_assoc($buscarmetas);

if (isset($_GET['totalRows_buscarmetas'])) {
  $totalRows_buscarmetas = $_GET['totalRows_buscarmetas'];
} else {
  $all_buscarmetas = mysqli_query($conexion, $query_buscarmetas);
  $totalRows_buscarmetas = mysqli_num_rows($all_buscarmetas);
}
$totalPages_buscarmetas = ceil($totalRows_buscarmetas/$maxRows_buscarmetas)-1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<table class="table">
  <tr>
    <th height="42">GESTION</th>
    <th>DESCRIPCION</th>
    <th>META A CUMPLIR</th>
    <th>&nbsp;</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_buscarmetas['gestion']; ?></td>
      <td><?php echo $row_buscarmetas['descr_meta']; ?></td>
      <td><?php echo $row_buscarmetas['cumplimiento_meta']; ?></td>
      <td>
        <?php if($row_buscarmetas['meta_estado']==0){ ?>
  <form method="post" name="form1" action="">
    <table align="center">
      <tr valign="baseline">
        <td><input name="cod_meta_coord" type="hidden" value="<?php echo $row_buscarmetas['cod_meta']; ?>"></td>
        </tr>
      <tr valign="baseline">
        <td><input type="submit" value="Asignar" data-toggle="tooltip" data-placement="top" title="Asociar esta Meta con la Actividad"></td>
        </tr>
      </table>
    <input type="hidden" name="MM_insert" value="form1">
    </form>    
        <?php } ?>  
      </td>
    </tr>
    <?php } while ($row_buscarmetas = mysqli_fetch_assoc($buscarmetas)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($buscarmetas);
?>
