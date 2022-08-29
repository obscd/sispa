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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_verimagenes = 1000;
$pageNum_verimagenes = 0;
if (isset($_GET['pageNum_verimagenes'])) {
  $pageNum_verimagenes = $_GET['pageNum_verimagenes'];
}
$startRow_verimagenes = $pageNum_verimagenes * $maxRows_verimagenes;

mysqli_select_db($conexion, $database_conexion);
$query_verimagenes = "SELECT * FROM imagenesadicionales ORDER BY id_image_adi ASC";
$query_limit_verimagenes = sprintf("%s LIMIT %d, %d", $query_verimagenes, $startRow_verimagenes, $maxRows_verimagenes);
$verimagenes = mysqli_query($conexion, $query_limit_verimagenes) or die(mysqli_error($conexion));
$row_verimagenes = mysqli_fetch_assoc($verimagenes);

if (isset($_GET['totalRows_verimagenes'])) {
  $totalRows_verimagenes = $_GET['totalRows_verimagenes'];
} else {
  $all_verimagenes = mysqli_query($conexion, $query_verimagenes);
  $totalRows_verimagenes = mysqli_num_rows($all_verimagenes);
}
$totalPages_verimagenes = ceil($totalRows_verimagenes/$maxRows_verimagenes)-1;

$queryString_verimagenes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_verimagenes") == false && 
        stristr($param, "totalRows_verimagenes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_verimagenes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_verimagenes = sprintf("&totalRows_verimagenes=%d%s", $totalRows_verimagenes, $queryString_verimagenes);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<style>
.pagination {
    display: inline-block;
    padding-left: 0;
    margin: 0px 0;
    border-radius: 4px;
}
</style>
</head>

<body>
<div class="row">
  <?php do { ?>
  
<div class="col-sm-2 col-md-2">
    <div class="thumbnail">
<nav aria-label="Page navigation">
  <ul class="pagination pagination-sm">
    <li><a href data-toggle='modal' data-target='#option' onclick="ventana('edittext','<?php echo $row_verimagenes['id_image_adi']; ?>','pop')">
<img src="../images/edit.png" width="10" height="10"> 
</a></li>
    <li><a href="delcoord.php?del=<?php echo $row_verimagenes['id_image_adi']; ?>&a=imagenesadicionales&b=id_image_adi&c=pilar" data-toggle="tooltip" data-placement="top" title="" onclick="if(!confirm('Esta seguro de eliminar este registro?'))return false" data-original-title="Eliminar IMAGEN"><img src="../images/eliminar.png" width="10" height="10"></a></li>
   
  </ul>
</nav>     
    
<?php echo $row_verimagenes['descripcion']; ?>

      <img src="../imagenesayuda/<?php echo $row_verimagenes['codigo_img_adicional']; ?>" class="img-responsive" width="100px">
      <div class="caption">
       
        <p>
        
        </p>
      </div>
    </div>
  </div>
  
    <tr>
      <td></td>
      <td></td>
    </tr>
    <?php } while ($row_verimagenes = mysqli_fetch_assoc($verimagenes)); ?>
</div>
</body>
</html>
<?php
mysqli_free_result($verimagenes);
?>

