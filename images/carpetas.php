<?php
require_once('../locklvl.php');
$MM_authorizedUsers =usuario(3);
require_once('../lock.php');
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO carpeta (codigo_carpeta, cod_meta_carp, nombre) VALUES (%s, %s, %s)",
                       GetSQLValueString(generarCodigo(16), "text"),
                       GetSQLValueString($_POST['c_meta'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "carpetas.php?item=".$_POST['c_meta'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_listarcarpetas = "-1";
if (isset($_GET['item'])) {
  $colname_listarcarpetas = $_GET['item'];
}
mysqli_select_db($conexion, $database_conexion);
//$query_tareas = sprintf("SELECT * FROM ((indicador INNER JOIN meta ON indicador.cod_indicador=meta.cod_indicador_meta) INNER JOIN meta_usaurios ON meta.cod_meta=meta_usaurios.cod_meta_mtus) WHERE meta_usaurios.meta_login = %s GROUP BY meta_usaurios.cod_meta_mtus ORDER BY meta_usaurios.id DESC", GetSQLValueString($colname_tareas, "text"));
//$query_listarcarpetas = sprintf("SELECT * FROM carpeta WHERE cod_meta_carp = %s ORDER BY id ASC", GetSQLValueString($colname_listarcarpetas, "text"));
$query_listarcarpetas = sprintf("SELECT * FROM ((indicador INNER JOIN meta ON indicador.cod_indicador=meta.cod_indicador_meta) INNER JOIN carpeta ON meta.cod_meta=carpeta.cod_meta_carp) WHERE carpeta.cod_meta_carp = %s ORDER BY id_carpeta ASC", GetSQLValueString($colname_listarcarpetas, "text"));

$listarcarpetas = mysql_query($query_listarcarpetas, $conexion) or die(mysqli_error($conexion));
$row_listarcarpetas = mysqli_fetch_assoc($listarcarpetas);
$totalRows_listarcarpetas = mysqli_num_rows($listarcarpetas);
?>
<div class="row">
<div class="col-sm-6 col-md-6">

<b>GESTION:</b> <?php echo $row_listarcarpetas['gestion']; ?><br>
<b>INDICADOR:</b><br> <?php echo $row_listarcarpetas['descr_indicador']; ?><br>
<b>META:</b><br> <?php echo $row_listarcarpetas['descr_meta']; ?><br>
<form class="edite" name="edite" id="edite" role="form" enctype="multipart/form-data">



<div class="input-group input-group-sm">
  <span class="input-group-addon" id="sizing-addon6">
  <input type="text" name="nombre" value=""  placeholder="NOMBRE CARPETA" autocomplete="off" class="form-control" required>
  </span>
  <span class="input-group-addon" id="sizing-addon6">
<a onclick="nre('carpetas','edite','busqueda')" class="btn btn-success" id="registrar">CREAR CARPETA</a>
</span>
</div>
  <input type="hidden" name="MM_insert" value="form1">
  <input name="c_meta" type="hidden" id="c_meta" value="<?php echo $_GET['item']; ?>">
  
  
</form>
</div>
<div class="col-sm-6 col-md-6 text-right">
                     
</div>
</div>
<hr>
<div class="row">
  <?php 
	if($row_listarcarpetas['nombre']!='')
	{
  do { ?>
<div class="col-sm-2 col-md-2">
    <div class="thumbnail"> 
	<a class="btn btn-succes" onclick="ventana('documentos','<?php echo $row_listarcarpetas['cod_meta']; ?>&file=<?php echo $row_listarcarpetas['codigo_carpeta']; ?>','busqueda')">

      <img src="../images/file.png" class="img-responsive">
      <div class="caption text-center">
      <p>
       <?php echo $row_listarcarpetas['nombre']; ?>
        </p>
      </div>
    </a>
    </div>
  </div>                

 
    <?php } while ($row_listarcarpetas = mysqli_fetch_assoc($listarcarpetas)); 
    }
	else
	{
		echo "NO SE ENCONTRARON CARPEAS EN ESTA META";
		}
	?>
</div>	
<?php
mysqli_free_result($listarcarpetas);
?>
