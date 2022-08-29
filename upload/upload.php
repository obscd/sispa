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

if(!empty($_FILES)) {
  if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {




  $extension = end(explode('.', $_FILES['userImage']['name']));
  $file_name = substr(md5(uniqid(rand())),0,10).".".$extension;

  $sourcePath = $_FILES['userImage']['tmp_name'];
  //$targetPath = "../imagenesayuda/".$_FILES['userImage']['name'];
  $targetPath = "../imagenesayuda/".$file_name;
  if(move_uploaded_file($sourcePath,$targetPath)) {
    //*********************************************************************
  $insertSQL = sprintf("INSERT INTO imagenesadicionales (codigo_img_adicional, descripcion) VALUES (%s, %s)",
                        GetSQLValueString($file_name, "text"),
                        GetSQLValueString($_POST['nombre'], "text"));

    mysqli_select_db($conexion, $database_conexion);
    $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));
  //*********************************************************************	
    header('Location: listar.php');
  ?>
  <img src="<?php echo $targetPath; ?>" width="100px" height="100px" />
  <?php
  }
  }
} else {
  header('Location: index.php');
}
?>