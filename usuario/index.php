<?php
//Import PHPMailer classes into the global namespace
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;

// require '../PHPMailer/src/Exception.php';
// require '../PHPMailer/src/PHPMailer.php';
// require '../PHPMailer/src/SMTP.php';

require_once('../locklvl.php');
$MM_authorizedUsers =usuario(0);
require_once('../lock.php'); 
require_once ('../mail/mail.php');
?>
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  #creamos password
  $bytes = openssl_random_pseudo_bytes(4);
  $password = bin2hex($bytes);
  #echo $pass;
  #$password =  $_POST['contrasenia'];
  $email = $_POST['email'];
  $usuariologin=$_POST['usuario_login'];

  // almacenamos nuevo registro
  $insertSQL = sprintf("INSERT INTO login (cod_cliente_login, usuario_login, contrasenia, id_entidad, nivel, estado, fecha_reg_log, email) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(generarCodigo(16), "text"),
                       GetSQLValueString($usuariologin, "text"),
                       GetSQLValueString(hash('sha256', $password), "text"),
                       GetSQLValueString($_POST['entidad'], "text"),
                       GetSQLValueString($_POST['nivel'], "int"),
                       GetSQLValueString('A', "text"),
                       GetSQLValueString($fecha, "text"),
                       GetSQLValueString($email, "text"));
  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  //Enviamos correo
  $asunto = 'SISPA - Nuevo registro';
  $body = "Bienvenido ".$usuariologin.".</br>
          Su password es: <b>".$password."</b></br>
          No comparta su password con nadie.";

  enviarCorreo($email, $asunto, $body);

  $insertGoTo = "../usuario/";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_usuariosregistrados = 1000;
$pageNum_usuariosregistrados = 0;
if (isset($_GET['pageNum_usuariosregistrados'])) {
  $pageNum_usuariosregistrados = $_GET['pageNum_usuariosregistrados'];
}
$startRow_usuariosregistrados = $pageNum_usuariosregistrados * $maxRows_usuariosregistrados;

mysqli_select_db($conexion, $database_conexion);
$query_usuariosregistrados = "SELECT * FROM login ORDER BY id_login ASC";
$query_limit_usuariosregistrados = sprintf("%s LIMIT %d, %d", $query_usuariosregistrados, $startRow_usuariosregistrados, $maxRows_usuariosregistrados);
$usuariosregistrados = mysqli_query($conexion, $query_limit_usuariosregistrados) or die(mysqli_error($conexion));
$row_usuariosregistrados = mysqli_fetch_assoc($usuariosregistrados);

if (isset($_GET['totalRows_usuariosregistrados'])) {
  $totalRows_usuariosregistrados = $_GET['totalRows_usuariosregistrados'];
} else {
  $all_usuariosregistrados = mysqli_query($conexion, $query_usuariosregistrados);
  $totalRows_usuariosregistrados = mysqli_num_rows($all_usuariosregistrados);
}
$totalPages_usuariosregistrados = ceil($totalRows_usuariosregistrados/$maxRows_usuariosregistrados)-1;

$queryString_usuariosregistrados = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_usuariosregistrados") == false &&
        stristr($param, "totalRows_usuariosregistrados") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_usuariosregistrados = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_usuariosregistrados = sprintf("&totalRows_usuariosregistrados=%d%s", $totalRows_usuariosregistrados, $queryString_usuariosregistrados);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $titulo; ?> </title>
    <link href="../favicon.ico" rel="icon">
<?php require('../cssadmin.php'); ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <?php
			  echo $stitulo;
			  ?>
            </div>

            <div class="clearfix"></div>

            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo $foto; ?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Hola,</span>
                <h2><?php echo $husuario; ?></h2>
              </div>
            </div>

            <br />

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3><?php echo $titulomenu; ?></h3>
                <?php
				echo $menu;//**********************************************************menu
				?>
              </div>
              <?php
			  echo $configuracion;//***********************************************configuracion
			  ?>

            </div>

            <?php echo $hmeninf; ?>
          </div>
        </div>
<?php
echo $navtop;
?>

        <div class="right_col" role="main">
<?php
		echo $headerpag;
		?>
          <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile">
                <div class="x_title">
                  <h2>USUARIOS</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-block btn-default">Registrar Nuevo Usuario</a>
                    </li>
                  </ul>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <table class="table table-hover">
                      <tr>
                        <th width="18" bgcolor="#2A3F54">&nbsp;</th>
                        <th width="18" bgcolor="#2A3F54">&nbsp;</th>
                        <th height="45" bgcolor="#2A3F54">Nº</th>
                        <th bgcolor="#2A3F54">USUARIO</th>
                        <th bgcolor="#2A3F54">CORREO ELECTRÓNICO</th>
                        <th bgcolor="#2A3F54">NIVEL</th>
                        <th bgcolor="#2A3F54">FECHA REGISTRO</th>
                      </tr>
                      <?php do { ?>
                        <tr>
                          <td valign="middle">
<a href="delcoord.php?del=<?php echo $row_usuariosregistrados['cod_cliente_login']; ?>&a=login&b=cod_cliente_login&c=pilar" data-toggle="tooltip" data-placement="top" title="Eliminar este registro de la LISTA DE USUARIOS" onclick="if(!confirm('<?php echo $alertborrar; ?>'))return false"><i class="fa fa-close fa-2x"></i></a>
                          </td>
                          <td valign="middle">
<a class="btn btn-succes" data-toggle='modal' data-target='#option' onClick="ventana('editarus','<?php echo $row_usuariosregistrados['cod_cliente_login']; ?>','pop')">
<i class="fa fa-pencil fa-2x"></i>
</a>
                          </td>
                          <td><?php echo $row_usuariosregistrados['id_login']; ?></td>
                          <td><?php echo $row_usuariosregistrados['usuario_login']; ?></td>
                          <td><?php echo $row_usuariosregistrados['email']; ?></td>
                          <td><?php echo $row_usuariosregistrados['nivel']; ?></td>
                          <td><?php echo $row_usuariosregistrados['fecha_reg_log']; ?></td>
                        </tr>
                        <?php } while ($row_usuariosregistrados = mysqli_fetch_assoc($usuariosregistrados)); ?>
                    </table>
                    <table border="0">
                      <tr>
                        <td><?php if ($pageNum_usuariosregistrados > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_usuariosregistrados=%d%s", $currentPage, 0, $queryString_usuariosregistrados); ?>">Primero</a>
                            <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_usuariosregistrados > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_usuariosregistrados=%d%s", $currentPage, max(0, $pageNum_usuariosregistrados - 1), $queryString_usuariosregistrados); ?>">Anterior</a>
                            <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_usuariosregistrados < $totalPages_usuariosregistrados) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_usuariosregistrados=%d%s", $currentPage, min($totalPages_usuariosregistrados, $pageNum_usuariosregistrados + 1), $queryString_usuariosregistrados); ?>">Siguiente</a>
                            <?php } // Show if not last page ?></td>
                        <td><?php if ($pageNum_usuariosregistrados < $totalPages_usuariosregistrados) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_usuariosregistrados=%d%s", $currentPage, $totalPages_usuariosregistrados, $queryString_usuariosregistrados); ?>">&Uacute;ltimo</a>
                            <?php } // Show if not last page ?></td>
                      </tr>
                    </table>

</div>
           </div>
         </div>
       </div>
     </div>
     <?php echo $footer; ?>
     <!-- /footer content -->
   </div>
 </div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">NUEVO REGISTRO DE USUARIO</h4>
      </div>
      <div class="modal-body">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          <table align="center" class="table">
            <tr valign="baseline">
              <td bgcolor="#CCC">USUARIO:</td>
            </tr>
            <tr valign="baseline">
              <td bgcolor="#CCC"><input type="text" name="usuario_login" value="" class="form-control" required></td>
            </tr>
            <!-- <tr valign="baseline">
              <td bgcolor="#CCC">CONTRASEÑA:</td>
            </tr>
            <tr valign="baseline">
              <td bgcolor="#CCC"><input type="password" name="contrasenia" value="" class="form-control"></td>
            </tr> -->
            <tr valign="baseline">
              <td bgcolor="#CCC">CORREO ELECTRÓNICO:</td>
            </tr>
            <tr valign="baseline">
              <td bgcolor="#CCC"><input type="email" name="email" value="" class="form-control" required></td>
            </tr>

            <?php
            mysqli_select_db($conexion, $database_conexion);
            $query_listaentidad = "SELECT * FROM entidad ORDER BY sigla ASC";
            $listaentidad = mysqli_query($conexion, $query_listaentidad) or die(mysqli_error($conexion));
            $row_listaentidad = mysqli_fetch_assoc($listaentidad);
            //$totalRows_listaentidad = mysqli_num_rows($listaentidad);
            ?>

            <tr valign="baseline">
              <td bgcolor="#CCC">ENTIDAD:</td>
            </tr>
            <tr valign="baseline">
              <td bgcolor="#CCC">
                <select name="entidad" id="entidad" class="form-control" required>
                  <option value="">Seleccionar</option>
                  <?php 
                  do { 
                  ?>
                  <option value="<?php echo $row_listaentidad['id']; ?>"><?php echo $row_listaentidad['sigla']; ?></option>
                  <?php
                  } while ($row_listaentidad = mysqli_fetch_assoc($listaentidad));
                  ?>
                </select>
              </td>
            </tr>

            <tr valign="baseline">
              <td bgcolor="#CCC">NIVEL DE ACCESO</td>
            </tr>
            <tr valign="baseline">
              <td bgcolor="#CCC">
              <select name="nivel" id="nivel" class="form-control">
                <option value="0">ADMINISTRADOR</option>
                <option value="1">REVISOR</option>
                <!-- <option value="2">USUARIO APROBACION</option> -->
                <option value="3">RESPONSABLE</option>
                <!-- <option value="4">PRESUPUESTO PROGRAMADO</option>
                <option value="5">PRESUPUESTO EJECUTADO</option> -->
              </select>
              </td>
            </tr>
            <tr valign="baseline">
              <td bgcolor="#CCC"><input type="submit" value="Registrar" class="btn btn-success btn-block"></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $close; ?></button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="option" tabindex="-1" role="dialog" aria-labelledby="large" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="large">EDITAR</h4>
      </div>
      <div class="modal-body" id="pop">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $close; ?></button>
      </div>
    </div>
  </div>
</div>

<?php require('../jsadmin.php'); ?>
</body>
</html>
<?php
mysqli_free_result($usuariosregistrados);
?>
