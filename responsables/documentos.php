<?php 
require_once('../locklvl.php'); 
$MM_authorizedUsers =usuario(3);
require_once('../lock.php'); ?>
<?php require_once('../Connections/conexion.php'); ?>
<?php
# Ocultar warnings
error_reporting(E_ERROR | E_PARSE);

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

$currentPage = $_SERVER["PHP_SELF"];
$colname_tema = "-1";
if (isset($_GET['item'])) {
  $colname_tema = $_GET['item'];
}
mysqli_select_db($conexion, $database_conexion);
$query_tema = sprintf("SELECT *  FROM ((( meta))) WHERE meta.cod_meta = %s ORDER BY id_meta ASC", GetSQLValueString($colname_tema, "text"));
$tema = mysqli_query($conexion, $query_tema) or die(mysqli_error($conexion));
$row_tema = mysqli_fetch_assoc($tema);
$totalRows_tema = mysqli_num_rows($tema);


if(isset($_POST['file']))
{
	$carpeta=$_POST['file'];
}
else
{
$carpeta=$_GET['file'];	
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		//*********************************** subir imagen
		
if($_FILES['archivo']['name'] != ""){ 
		$errors= array();
		$file_name = $_FILES['archivo']['name'];
		$file_size =$_FILES['archivo']['size'];
		$file_tmp =$_FILES['archivo']['tmp_name'];
		$file_type=$_FILES['archivo']['type'];   
		$file_ext=strtolower(end(explode('.',$_FILES['archivo']['name'])));
		
		$expensions= array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG",'csv','xls','xlsx','pdf','PDF','doc','docx','mp4','rar'); 		
		if(in_array($file_ext,$expensions)=== false){
			$errors[]="El archivo no es valido";
		}
		if($file_size > 200971520){
		$errors[]='Archivo maximo 20 MB';
		}				
		if(empty($errors)==true){
			$extension = strtolower(end(explode('.', $_FILES['archivo']['name'])));
      
			$file_name = substr(md5(uniqid(rand())),0,10).".".$extension;
			$minFoto = 'min_'.$file_name;
            $resFoto = 'res_'.$file_name;
			move_uploaded_file($file_tmp,"../files/".$file_name);

			if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $extension == 'png'){
			      resizeImagen('../files/', $file_name, 65, 65,$minFoto,$extension);
            resizeImagen('../files/', $file_name, 1005, 1290,$resFoto,$extension);
            unlink('../files/'.$foto);
			}
			echo "Success";
		}else{
			print_r($errors);
			exit();
		}        
        
        
    } else { // El campo foto NO contiene una imagen
        header("Location: cargarImagen.php?error=noImagen");
        exit;
    }
//***************************************************************

  $insertSQL = sprintf("INSERT INTO documentos (cod_carpeta_doc, cod_meta_doc, documentos_tipo, documentos_descripcion, cod_documento_fis, usuario_doc, fecha_doc) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['file'], "text"),
					   GetSQLValueString($_POST['dc'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($file_name, "text"),
					   GetSQLValueString($_SESSION['MM_Username'], "text"),
					   GetSQLValueString($fecha, "text"));
  
  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));
  $ir="documentos.php?item=".$_POST['dc'].'&file='.$_POST['file'];
  header("Location: ".$ir);
  exit();

  
}
//*********************************** LISTAR DOCUMENTOS
$maxRows_verfiles = 1000;
$pageNum_verfiles = 0;
if (isset($_GET['pageNum_verfiles'])) {
  $pageNum_verfiles = $_GET['pageNum_verfiles'];
}
$startRow_verfiles = $pageNum_verfiles * $maxRows_verfiles;

$colname_verfiles = "-1";
if (isset($_GET['item'])) {
  $colname_verfiles = $_GET['item'];
}
mysqli_select_db($conexion, $database_conexion);
//********************************************************************
$query_verfiless = sprintf("SELECT * FROM carpeta WHERE codigo_carpeta = %s ", GetSQLValueString($carpeta, "text"));
$query_limit_verfiless = sprintf("%s LIMIT %d, %d", $query_verfiless, $startRow_verfiles, $maxRows_verfiles);
$verfiless = mysqli_query($conexion, $query_limit_verfiless) or die(mysqli_error($conexion));
$row_verfiless = mysqli_fetch_assoc($verfiless);
//********************************************************************
$query_verfiles = sprintf("SELECT * FROM documentos WHERE cod_carpeta_doc = %s AND usuario_doc=%s ORDER BY id_documentos DESC", GetSQLValueString($carpeta, "text"), GetSQLValueString($_SESSION["MM_Username"], "text"));
$query_limit_verfiles = sprintf("%s LIMIT %d, %d", $query_verfiles, $startRow_verfiles, $maxRows_verfiles);
$verfiles = mysqli_query($conexion, $query_limit_verfiles) or die(mysqli_error($conexion));
$row_verfiles = mysqli_fetch_assoc($verfiles);

if (isset($_GET['totalRows_verfiles'])) {
  $totalRows_verfiles = $_GET['totalRows_verfiles'];
} else {
  $all_verfiles = mysqli_query($conexion, $query_verfiles);
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
<title>Documento sin t??tulo</title>
</head>

<body>
<h3><?php echo $row_verfiless['nombre']; ?></h3>
<table width="100%" class="table">
  <tr>
    <td width="24%" valign="top">
<form class="edite" name="edite" id="edite" role="form" enctype="multipart/form-data">
    
  <table width="100%" border="0" cellspacing="0" >
  <tr valign="baseline">
      <td height="37" align="center" valign="middle">
	  <a onclick="ventana('carpetas','<?php echo $colname_tema; ?>','busqueda')" class="btn btn-default">VOLVER ATRAS</a></td>
    </tr>
    <tr valign="baseline">
      <td height="37" align="center" valign="middle" bgcolor="#D7EBFF"><strong>DETALLE DE LA META</strong></td>
    </tr>
    <tr valign="baseline">
      <td height="32" bgcolor="#CCCCCC"><strong>GESTION</strong>: <?php echo $row_tema['gestion']; ?></td>
    </tr>
    <tr valign="baseline">
      <td height="32" bgcolor="#CCCCCC"><strong>META</strong>: <?php echo $row_tema['descr_meta']; ?></td>
    </tr>
    <tr valign="baseline">
      <td height="37" align="center" valign="middle" bgcolor="#D7EBFF"><strong>FORMULARIO DE RESPALDOS</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC"><input type="text" name="tipo" class="form-control" placeholder="TITULO DOCUMENTO" autocomplete="off"></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC"><label for="descripcion"></label>
      <textarea name="descripcion" rows="4" id="descripcion" placeholder="DESCRIPCION DEL DOCUMENTO" class="form-control"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC"><label for="archivo"></label>
      <input type="file" name="archivo" id="archivo" class="form-control"></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC">
	  <input type="hidden" name="file" value="<?php echo $_GET['file']; ?>">
      <input type="hidden" name="dc" id="dc" value="<?php echo $row_tema['cod_meta']; ?>">
      <div id="progress-wrp"><div class="progress-bar"></div ><div class="status" id="status"></div></div>
    <div id="output"><!-- error or success results --></div>
      </td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCCCCC">
 <?php 
	  if($row_tema['cod_meta']==$_GET['item'])
	  {
?>
<a onclick="nre('documentos','edite','busqueda')" class="btn btn-success" id="registrar">Registrar </a>
<?php
		  }
		  else
		  {
			  echo "ERROR";
			  }
	  
	  
	  ?>      

      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form></td>
    <td width="76%" valign="top">
<table class="table table-hover">
  <tr>
    <th colspan="2" bgcolor="#2A3F54">ACCIONES</th>
    <!-- <th width="5%" height="45" bgcolor="#2A3F54">N??</th> -->
    <th width="5%" bgcolor="#2A3F54">FECHA</th>
    <th width="20%" bgcolor="#2A3F54">TITULO</th>
    <th width="50%" bgcolor="#2A3F54">DESCRIPCION</th>
    <!-- <th width="5%" bgcolor="#2A3F54">VER </th> -->
    <th width="5%" bgcolor="#2A3F54">DESCARGAR</th>
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
      <td align="center">
        

        <a class="btn btn-danger btn-xs" title="Eliminar documento" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar documento" onclick="if (confirm('??Estas seguro de eliminar este documento?')){ventana('deldoc','<?php echo $row_verfiles['id_documentos'].'&file='.$row_verfiles['cod_carpeta_doc']; ?>','busqueda')}	">
        <i class="fa fa-close fa-2x"></i></a>        

      </td>
      <td align="center">
      
      <a  class="btn btn-success btn-xs" title="Editar documento" data-toggle="tooltip" data-placement="top" data-original-title="Editar documento" onclick="ventana('editdoc','<?php echo $row_verfiles['id_documentos']; ?>','busqueda')">
      <i class="fa fa-pencil fa-2x"></i></a>      
      </td>
      <!-- <td><?php echo $countdocs; ?></td> -->
      <td><?php echo $row_verfiles['fecha_doc']; ?></td>
      <td><?php echo $row_verfiles['documentos_tipo']; ?></td>
      <td><?php echo $row_verfiles['documentos_descripcion']; ?> <br>
      </td>
      <!-- <td>
        <?php
	  $doccc=tipo($row_verfiles['cod_documento_fis']);

	  if($doccc=='jpg' || $doccc=='jpeg' || $doccc=='gif' || $doccc=='png')
	  {
		  echo '<a href="../vendors/iniciarportal.com.php?getimg='.base64_encode('res_'.$row_verfiles['cod_documento_fis']).'" target="new">
		  				<img src="../vendors/iniciarportal.com.php?getimg='.base64_encode('min_'.$row_verfiles['cod_documento_fis']).'" width="50">
		  </a>';
		  ?>
          <?php
	  }
		else
		{
		  echo '<img src="../images/'.$doccc.'.jpg" width="50">';
      
		}
	  
	  ?>

	  </td> -->
      <td align="center"><?php 
	  echo '<a href="../down.php?item='. $row_verfiles['cod_documento_fis'].'" ><i class="fa fa-cloud-download fa-2x"></i></a>';
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
    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($tema);

mysqli_free_result($verfiles);
?>