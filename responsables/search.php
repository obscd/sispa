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

$currentPage = $_SERVER["PHP_SELF"];
$colname_tema = "-1";
if (isset($_GET['item'])) {
  $colname_tema = $_GET['item'];
}
mysqli_select_db($conexion, $database_conexion);
$maxRows_verfiles = 5000;
$pageNum_verfiles = 0;
if (isset($_GET['pageNum_verfiles'])) {
  $pageNum_verfiles = $_GET['pageNum_verfiles'];
}
$startRow_verfiles = $pageNum_verfiles * $maxRows_verfiles;

$colname_verfiles = "";
if (isset($_GET['item'])) {
  $colname_verfiles = $_GET['item'];
}
mysqli_select_db($conexion, $database_conexion);
//$query_verfiles = sprintf("SELECT * FROM documentos WHERE documentos_tipo LIKE %s AND usuario_doc=%s ORDER BY documentos_tipo DESC", GetSQLValueString("%".$colname_verfiles, "text"), GetSQLValueString($_SESSION["MM_Username"], "text"));
$query_verfiles = sprintf("SELECT * FROM ((indicador INNER JOIN meta ON indicador.cod_indicador=meta.cod_indicador_meta) INNER JOIN documentos ON meta.cod_meta=documentos.cod_meta_doc) WHERE documentos.documentos_tipo LIKE %s AND documentos.usuario_doc=%s ORDER BY documentos.documentos_tipo DESC", GetSQLValueString("%".$colname_verfiles, "text"), GetSQLValueString($_SESSION["MM_Username"], "text"));
$query_limit_verfiles = sprintf("%s LIMIT %d, %d", $query_verfiles, $startRow_verfiles, $maxRows_verfiles);
$verfiles = mysql_query($query_limit_verfiles, $conexion) or die(mysqli_error($conexion));
$row_verfiles = mysqli_fetch_assoc($verfiles);

if (isset($_GET['totalRows_verfiles'])) {
  $totalRows_verfiles = $_GET['totalRows_verfiles'];
} else {
  $all_verfiles = mysql_query($query_verfiles);
  $totalRows_verfiles = mysqli_num_rows($all_verfiles);
}
$totalPages_verfiles = ceil($totalRows_verfiles/$maxRows_verfiles)-1;

$queryString_verfiles = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_verfiles") == false && 
        stristr($param, "totalRows_verfiles") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_verfiles = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_verfiles = sprintf("&totalRows_verfiles=%d%s", $totalRows_verfiles, $queryString_verfiles);
//**************************************************
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<table class="table table-bordered table-hover">
  <tr>
    <th bgcolor="#2A3F54">INDICADOR</th>
    <th bgcolor="#2A3F54">META</th>
    <th width="5%" height="45" bgcolor="#2A3F54">Nº</th>
    <th width="5%" bgcolor="#2A3F54">FECHA</th>
    <th bgcolor="#2A3F54">TITULO</th>
    <th bgcolor="#2A3F54">DESCRIPCION</th>
    <th width="5%" bgcolor="#2A3F54">VER </th>
    <th width="5%" bgcolor="#2A3F54">&nbsp;</th>
  </tr>
  <?php 
  $countdocs=$totalRows_verfiles;
  if($row_verfiles['documentos_tipo'] =='')
          {
	  echo '<td height="45"><h3>No se adjuntaron Documentos</h3></td>';
	  exit();
	  }
  do { 
  $countdocs--;
  ?>
  <tr>
    <td>
    <?php echo $row_verfiles['descr_indicador']; ?>
    </td>
    <td> 
    <?php echo $row_verfiles['descr_meta']; ?>
    </td>
    <td><?php echo $countdocs; ?></td>
    <td><?php echo $row_verfiles['fecha_doc']; ?></td>
    <td><?php echo $row_verfiles['documentos_tipo']; ?></td>
    <td><?php echo $row_verfiles['documentos_descripcion']; ?> <br></td>
    <td><?php
	  $doccc=tipo($row_verfiles['cod_documento_fis']);
	  if($doccc=='jpg' || $doccc=='jpeg' || $doccc=='gif' || $doccc=='png')
	  {
		  echo '<a href="../vendors/iniciarportal.com.php?getimg='.base64_encode('res_'.$row_verfiles['cod_documento_fis']).'" target="new">
		  				<img src="../vendors/iniciarportal.com.php?getimg='.base64_encode('min_'.$row_verfiles['cod_documento_fis']).'" width="50">
		  </a>';
		  ?>
      <img src=""
          <?php
	  }
		else
		{
		  echo '<img src="../images/'.$doccc.'.jpg" width="50">';
		}
	  
	  ?>
	  
	  </td>
    <td><?php 
	  echo '<a href="../down.php?item='. $row_verfiles['cod_documento_fis'].'" ><img src="../images/descarga.png" width="25" height="35"></a>';
	  ?></td>
  </tr>
  <?php } while ($row_verfiles = mysqli_fetch_assoc($verfiles)); ?>
  <tr>
    <td colspan="8"><table border="0">
      <tr>
        <td><?php if ($pageNum_verfiles > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_verfiles=%d%s", $currentPage, 0, $queryString_verfiles); ?>">Primero</a>
          <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_verfiles > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_verfiles=%d%s", $currentPage, max(0, $pageNum_verfiles - 1), $queryString_verfiles); ?>">Anterior</a>
          <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_verfiles < $totalPages_verfiles) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_verfiles=%d%s", $currentPage, min($totalPages_verfiles, $pageNum_verfiles + 1), $queryString_verfiles); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_verfiles < $totalPages_verfiles) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_verfiles=%d%s", $currentPage, $totalPages_verfiles, $queryString_verfiles); ?>">&Uacute;ltimo</a>
          <?php } // Show if not last page ?></td>
      </tr>
    </table></td>
  </tr>
</table>



</body>
</html>
<?php
mysqli_free_result($verfiles);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<script type="text/javascript">
    parent.processForm('&ftpAction=openFolder');
</script>
</body>
</html>
