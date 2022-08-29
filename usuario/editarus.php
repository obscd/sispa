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
  $updateSQL = sprintf("UPDATE login SET usuario_login=%s, email=%s, id_entidad=%s, nivel=%s WHERE cod_cliente_login=%s",
                       GetSQLValueString($_POST['usuario_login'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['entidad'], "text"),
                       GetSQLValueString($_POST['nivel'], "int"),
                       GetSQLValueString($_POST['cod_cliente_login'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editarus = "-1";
if (isset($_GET['area'])) {
  $colname_editarus = $_GET['area'];
}
mysqli_select_db($conexion, $database_conexion);
$query_editarus = sprintf("SELECT * FROM login WHERE cod_cliente_login = %s", GetSQLValueString($colname_editarus, "text"));
$editarus = mysqli_query($conexion, $query_editarus) or die(mysqli_error($conexion));
$row_editarus = mysqli_fetch_assoc($editarus);
$totalRows_editarus = mysqli_num_rows($editarus);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center" class="table">
    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc"><strong>USUARIO</strong></td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc"><input type="text" name="usuario_login" value="<?php echo htmlentities($row_editarus['usuario_login'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" required></td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc"><strong>CORREO ELECTRÓNICO</strong></td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc"><input type="email" name="email" value="<?php echo htmlentities($row_editarus['email'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" required></td>
    </tr>
    <!-- <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc"><strong>CONTRASEÑA</strong></td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc"><input type="text" name="contrasenia" value="<?php // echo htmlentities($row_editarus['contrasenia'], ENT_COMPAT, 'utf-8'); ?>" class="form-control"></td>
    </tr> -->
    <?php
    mysqli_select_db($conexion, $database_conexion);
    $query_listaentidad = "SELECT * FROM entidad ORDER BY sigla ASC";
    $listaentidad = mysqli_query($conexion, $query_listaentidad) or die(mysqli_error($conexion));
    $row_listaentidad = mysqli_fetch_assoc($listaentidad);
    //$totalRows_listaentidad = mysqli_num_rows($listaentidad);
    ?>
    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc"><strong>ENTIDAD</strong></td>
    </tr>
    <tr valign="baseline">
      <td bgcolor="#CCC">
        <select name="entidad" id="entidad" class="form-control" required>
          <option value="">Seleccionar</option>
          <?php 
          do { 
          ?>
          <option value="<?php echo $row_listaentidad['id']; ?>" <?php if($row_listaentidad['id'] == $row_editarus['id_entidad']){ echo 'selected="selected"';} ?>>
            <?php echo $row_listaentidad['sigla']; ?>
          </option>
          <?php
          } while ($row_listaentidad = mysqli_fetch_assoc($listaentidad));
          ?>
        </select>
      </td>
    </tr>

    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc"><strong>NIVEL</strong></td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc">
        <?php $sel='selected="selected"'; ?>
          <select name="nivel" id="nivel" class="form-control">
            <option value="0" <?php if($row_editarus['nivel']== 0 ) echo $sel; ?>>ADMINISTRADOR</option>
            <option value="1" <?php if($row_editarus['nivel']== 1 ) echo $sel; ?>>REVISOR</option>
            <!-- <option value="2" <?php if($row_editarus['nivel']== 2 ) echo $sel; ?>>USUARIO APROBACION</option> -->
            <option value="3" <?php if($row_editarus['nivel']== 3 ) echo $sel; ?>>RESPONSABLE</option>
            <!-- <option value="4" <?php if($row_editarus['nivel']== 4 ) echo $sel; ?>>PRESUPUESTO PROGRAMADO</option>
            <option value="5" <?php if($row_editarus['nivel']== 5 ) echo $sel; ?>>PRESUPUESTO EJECUTADO</option> -->
          </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td height="30" valign="middle" bgcolor="#ccc"><input type="submit" value="Actualizar" class="btn btn-block btn-success"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_cliente_login" value="<?php echo $row_editarus['cod_cliente_login']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($editarus);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
