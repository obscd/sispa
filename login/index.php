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
  #$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['userc'])) {
  $loginUsername=$_POST['userc'];
  $password=$_POST['passc'];
  $password=hash('sha256', $password);
  $MM_fldUserAuthorization = "nivel";
  $MM_redirectLoginSuccess = "../escritorio/";
  #$MM_redirectLoginFailed = "../error/";
  $MM_redirectLoginFailed = "../login/";
  $MM_redirecttoReferrer = false;
  mysqli_select_db($conexion, $database_conexion);

  $LoginRS__query=sprintf("SELECT cod_cliente_login, usuario_login, contrasenia, nivel, id_entidad FROM login WHERE usuario_login=%s AND contrasenia=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));

  $LoginRS = mysqli_query($conexion, $LoginRS__query) or die(mysqli_error($conexion));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  $row_login = mysqli_fetch_assoc($LoginRS);

  if ($loginFoundUser) {

    $loginStrGroup  = mysqli_result($LoginRS,0,'nivel');
    $_SESSION['codusuario'] = mysqli_result($LoginRS,0,'cod_cliente_login');
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['xx']='usuario no reconocido';

  $query_entidad = sprintf("SELECT * FROM entidad WHERE id = %s", 
    GetSQLValueString($row_login['id_entidad'], "text"));
  $entidad = mysqli_query($conexion, $query_entidad) or die(mysqli_error($conexion));
  $row_entidad = mysqli_fetch_assoc($entidad);
  $_SESSION['entidad'] = $row_entidad['sigla'];

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }
	if($_SESSION['MM_UserGroup']==3)
	{
		//$MM_redirectLoginSuccess = "../responsables/";
                  $MM_redirectLoginSuccess = "../escritorio/";
		}
	if($_SESSION['MM_UserGroup']==4)
	{
		//$MM_redirectLoginSuccess = "../presupuesto/";
                 $MM_redirectLoginSuccess = "../escritorio/";
		}
	if($_SESSION['MM_UserGroup']==5)
	{
		//$MM_redirectLoginSuccess = "../administracion/";
                $MM_redirectLoginSuccess = "../escritorio/";
		}
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>SISPA</title>

  <!-- Favicons -->
  <link href="../favicon.ico" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="../assets/fonts/OpenSans.css" rel="stylesheet">
  
  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body style="background-image: url('../images/subtle-prism.svg');">

<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="#" class="logo d-flex align-items-center w-auto">
                  <!-- <img src="../assets/img/logo.png" alt="">  -->
                  <span class="d-none d-lg-block text-center">Sistema de Seguimiento y Monitoreo al Plan de Acción</span>
                </a>
              </div><!-- End Logo -->
              
              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Inicio de sesión</h5>
                    <p class="text-center small">Ingrese su Usuario y Contraseña</p>
                  </div>

                  <form action="" method="POST" name="ingreso" id="ingreso" autocomplete="off" class="row g-3 needs-validation">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Usuario</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="userc" class="form-control" id="username" required>
                        <div class="invalid-feedback">Por favor, ingrese su usuario</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Contraseña</label>
                      <div class="input-group has-validation">

                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-key-fill"></i></span>
                        <input type="password" name="passc" class="form-control" id="password" required>
                        <div class="invalid-feedback">Por favor, ingrese su contraseña</div>
                      </div>
                    </div>

                    <!-- <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Recuérdame</label>
                      </div>
                    </div> -->
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Iniciar Sesión</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0"><a href="recuperar.php">¿Olvidaste tu contraseña?</a></p>
                    </div>
                  </form>

                </div>
              </div>


              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendor/chart.js/chart.min.js"></script>
<script src="../assets/vendor/echarts/echarts.min.js"></script>
<script src="../assets/vendor/quill/quill.min.js"></script>
<script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="../assets/vendor/tinymce/tinymce.min.js"></script>
<script src="../assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>

</body>
</html>