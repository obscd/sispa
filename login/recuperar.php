<?php 
require_once('../Connections/conexion.php');
require_once ('../mail/mail.php'); 
?>
<?php
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

if (!isset($_SESSION)) {
    session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
if (isset($_POST['user'])) {
    $usuario=$_POST['user'];
    $email=$_POST['email'];

    //$MM_fldUserAuthorization = "nivel";
    $MM_redirectLoginSuccess = "recuperar.php?msg=1";
    $MM_redirectLoginFailed = "recuperar.php?msg=2";
    //$MM_redirectLoginFailed = "../login/";
    //$MM_redirecttoReferrer = false;
    mysqli_select_db($conexion, $database_conexion);
  
    $LoginRS__query=sprintf("SELECT * FROM login WHERE  usuario_login=%s AND email=%s",
        GetSQLValueString($usuario, "text"), GetSQLValueString($email, "text"));
    
    $LoginRS = mysqli_query($conexion, $LoginRS__query) or die(mysqli_error($conexion));

    $loginFoundUser = mysqli_num_rows($LoginRS);
    
    if ($loginFoundUser) {
         #creamos nuevo password
        $bytes = openssl_random_pseudo_bytes(4);
        $password = bin2hex($bytes);

        $updateSQL = sprintf("UPDATE login SET contrasenia=%s WHERE usuario_login=%s AND email=%s",
                    GetSQLValueString(hash('sha256', $password), "text"),
                    GetSQLValueString($usuario, "text"), 
                    GetSQLValueString($email, "text"));
        
        mysqli_select_db($conexion, $database_conexion);
        $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

        //Enviamos correo
        $asunto = 'SISPA - Nuevos datos';
        $body = "Sra./Sr. ".$usuario.".</br>
                Su nuevo password es: <b>".$password."</b></br>
                No comparta su password con nadie.";

        enviarCorreo($email, $asunto, $body);

        header("Location: ". $MM_redirectLoginSuccess );
    }
    else {
      header("Location: ". $MM_redirectLoginFailed );
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

<?php // require('../cssadmin.php'); ?>
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
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                      <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Recuperar contraseña</h5>
                        <p class="text-center small">Ingrese sus datos para enviarle una nueva contraseña</p>
                      </div>
                      <?php 
                      if (isset($_GET['msg'])){
                        $msg=$_GET['msg'];
                        if($msg==1){
                          ?>
                          <div class="alert alert-info alert-dismissible fade show" role="alert">
                            La contraseña ha sido enviada a su correo. Revise su bandeja de Spam.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                          <?php
                        }
                        if($msg==2){
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          Usuario no encontrado.
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                        }
                      }
                      ?>

                      <form action="" method="POST" name="recuperar" id="recuperar" autocomplete="off" class="row g-3 needs-validation">
                        <div class="col-12">
                          <label for="yourUsername" class="form-label">Usuario</label>
                          <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="user" class="form-control" id="user" required>
                            <div class="invalid-feedback">Por favor, ingrese su usuario</div>
                          </div>
                        </div>

                        <div class="col-12">
                          <label for="yourEmail" class="form-label">Correo Electrónico</label>
                          <div class="input-group has-validation">

                            <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="email" class="form-control" id="email" required>
                            <div class="invalid-feedback">Por favor, ingrese su correo electrónico</div>
                          </div>
                        </div>
                        <div class="col-12">
                          <button class="btn btn-primary w-100" type="submit">Enviar contraseña</button>
                        </div>
                        <div>
                          <a href="index.php">
                            <button class="btn btn-secondary w-100" type="button">Volver a inicio</button>
                          </a>
                        </div>
                      </form>

                    </div>
                  </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>

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




        <!-- <div class="titulo_centro">  
          <div id="nuevo_titulo">    RECUPERAR CONTRASEÑA<br>    "SISPA"  </div>
        </div>
          <section class="stark-login">
              <form action="" method="POST" name="recuperar" id="recuperar" autocomplete="off" style="height: 250px;">
                  <div id="fade-box">
                      <label style="animation: 0s">Ingrese sus datos para enviarle une nueva contraseña.</label>
                      <input type="text" name="user" id="user" placeholder="USUARIO" required >
                      <input type="mail" name="email" id="email" placeholder="CORREO ELECTRÓNICO" required>
                      <button style="animation: 0s"><b>ENVIAR CORREO</b></button>
                      <a href="index.php">INICIAR SESIÓN</a>
                  </div>
              </form>
              <div class="hexagons">
                  <img src="fondo.jpg" height="100%" width="100%"/>
              </div>
          </section>

          </div>
        </div>
      </div>
    </main>
  </body> -->
</html>




