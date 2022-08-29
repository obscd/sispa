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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE meta SET descr_meta=%s, cumplimiento_meta=%s WHERE cod_meta=%s",
                       GetSQLValueString($_POST['descr_meta'], "text"),
                       GetSQLValueString($_POST['cumplimiento_meta'], "int"),
                       GetSQLValueString($_POST['cod_meta'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "metas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editarme = "-1";
if (isset($_GET['area'])) {
  $colname_editarme = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_editarme = sprintf("SELECT * FROM meta WHERE cod_meta = %s", GetSQLValueString($colname_editarme, "text"));
$editarme = mysqli_query($conexion, $query_editarme) or die(mysqli_error($conexion));
$row_editarme = mysqli_fetch_assoc($editarme);
$totalRows_editarme = mysqli_num_rows($editarme);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table border="0" align="center" cellspacing="0" class="table">
    <!-- <tr valign="baseline">
      <td height="30" valign="middle">GESTIONe</td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle"><input type="text" name="gestion" value="<?php echo htmlentities($row_editarme['gestion'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr> -->
    <tr valign="baseline">
      <td height="30" valign="middle">DESCRIPCION</td>
      <td height="30" valign="middle"><textarea name="descr_meta" cols="50" rows="5" class="form-control"><?php echo htmlentities($row_editarme['descr_meta'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <!--
    <tr valign="baseline">
      <td height="30" valign="middle">% PONDERACION</td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle"><input type="text" name="ponderacion" value="<?php echo htmlentities($row_editarme['ponderacion'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr>
     <tr valign="baseline">
      <td height="30" valign="middle">FECHA INICIO</td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle"><input type="text" name="fecha_ini" value="<?php echo htmlentities($row_editarme['fecha_ini'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle">FECHA FINAL</td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle"><input type="text" name="fecha_fin" value="<?php echo htmlentities($row_editarme['fecha_fin'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr> 
    <tr valign="baseline">
      <td height="30" valign="middle">META A CUMPLIR</td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle"><input type="text" name="cumplimiento_meta" value="<?php echo htmlentities($row_editarme['cumplimiento_meta'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr> -->
    <!-- <tr valign="baseline">
      <td height="30" valign="middle">RESPUESTA DE CUMPLIMIENTO</td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle"><input type="text" name="respuesta_real_decumpl" value="<?php echo htmlentities($row_editarme['respuesta_real_decumpl'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr> -->
    <tr valign="baseline">
          <td align="right" valign="middle" nowrap>META A CUMPLIR EN LA GESTIÓN:
		      </td>
          <td><input type="text" name="cumplimiento_meta" class="form-control" value="<?php echo htmlentities($row_editarme['cumplimiento_meta'], ENT_COMPAT, 'utf-8'); ?>" required></td>
        </tr>

    <tr valign="baseline">
      <td><input type="submit" value="Actualizar" class="btn btn-block btn-success"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_meta" value="<?php echo $row_editarme['cod_meta']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($editarme);
?>