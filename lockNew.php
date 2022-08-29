<?php
if (!isset($_SESSION)) {
  session_start();
}
//$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
  $isValid = False;
  if (!empty($UserName)) {
    $arrUsers = Explode(",", $strUsers);
    $arrGroups = Explode(",", $strGroups);
    if (in_array($UserName, $arrUsers)) {
      $isValid = true;
    }
    if (in_array($UserGroup, $arrGroups)) {
      $isValid = true;
    }
    if (($strUsers == "") && false) {
      $isValid = true;
    }
  }
  return $isValid;
}

$MM_restrictGoTo = "../error/";

///*********************************************************
$g0='<li class="nav-item"> 
      <a class="nav-link collapsed" data-bs-target="#administrador-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>ADMINISTRADOR</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="administrador-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li><a href="../adminc/"><i class="bi bi-circle"></i>PLAN DE ACCION</a></li>
        <li><a href="../adminc/financiadores.php"><i class="bi bi-circle"></i>I. APS - METAS</a></li>
      </ul>
    </li>';

$g1='<li class="nav-item"> 
        <a class="nav-link collapsed" data-bs-target="#revisor-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-pencil-square"></i><span>REVISOR</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="revisor-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li><a href="../revisor/general.php"><i class="bi bi-circle"></i>PLAN DE ACCION</a></li>
          <li><a href="../revisor/financiador.php?financiador=20160923111919"><i class="bi bi-circle"></i>INDICADORES APS</a></li>
        </ul>
      </li>';

$g2= '<li class="nav-item"> 
        <a class="nav-link collapsed" data-bs-target="#aprobacion-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-check-square"></i><span>US. APROBACION</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="aprobacion-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li><a href="../informes/infgeneral.php"><i class="bi bi-circle"></i>PLAN DE ACCION</a></li>
          <li><a href="../informes/aps.php"><i class="bi bi-circle"></i>INDICADORES APS</a></li>
          <li><a href="../informes/plan.php"><i class="bi bi-circle"></i>GRAFICA PLAN ACCION</a></li>
          <li><a href="../informes/"><i class="bi bi-circle"></i>GRAFICA I. APS</a></li>
        </ul>
      </li>';

$g3= '<li class="nav-item"> 
        <a class="nav-link collapsed" data-bs-target="#responsable-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-building"></i><span>RESPONSABLES</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="responsable-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li><a href="../responsables/"><i class="bi bi-circle"></i>Tareas</a></li>
        </ul>
      </li>';

/*$g4='<li><a><i class="fa fa-desktop"></i> PRESUPUESTO <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../presupuesto/">Programado</a></li>
		      <li><a href="../administracion/">Ejecutado</a></li>
                    </ul>
                  </li>';*/
$g4da= '<li class="nav-item"> 
          <a class="nav-link collapsed" data-bs-target="#manual-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-book"></i><span>MANUAL DE USUARIO</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="manual-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li><a href="/monitoreo/documents/manual.pdf" target="_blank"><i class="bi bi-circle"></i>Descargar</a>                    
          </li>
          </ul>
        </li>';
$g5='';

//---------------------------------
$configuracion='';
switch($_SESSION['MM_UserGroup'])
	{
		case 0:
			$_SESSION['xx']=$g0.$g1.$g2.$g3.$g4da;
			$configuracion= '<li class="nav-item"> 
                          <a class="nav-link collapsed" data-bs-target="#usuarios-nav" data-bs-toggle="collapse" href="#">
                            <i class="bi bi-people"></i><span>USUARIOS</span><i class="bi bi-chevron-down ms-auto"></i>
                          </a>
                          <ul id="usuarios-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li><a href="../usuario/"><i class="bi bi-circle"></i>USUARIOS</a></li>
                            <li><a href="../upload/"><i class="bi bi-circle"></i>IMAGENES</a></li>
                          </ul>
                        </li>';

			break;
		case 1:
		$_SESSION['xx']=$g1.$g2.$g4da;

			break;
		case 2:
		$_SESSION['xx']=$g2.$g4da;
			break;
		case 3:
		$_SESSION['xx']=$g3;

			break;
		case 4:
		$_SESSION['xx']='<li class="nav-item"> 
                        <a class="nav-link collapsed" data-bs-target="#presupuesto-nav" data-bs-toggle="collapse" href="#">
                          <i class="bi bi-building"></i><span>PRESUPUESTO</span><i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="presupuesto-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                          <li><a href="../presupuesto/financiador.php?financiador=20160923111919"><i class="bi bi-circle"></i>Programado</a></li>
                        </ul>
                      </li>';
			break;
		case 5:
		$_SESSION['xx']='<li class="nav-item"> 
                        <a class="nav-link collapsed" data-bs-target="#presupuesto-nav" data-bs-toggle="collapse" href="#">
                          <i class="bi bi-building"></i><span>PRESUPUESTO</span><i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="presupuesto-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                          <li><a href="../administracion/financiador.php?financiador=20160923111919"><i class="bi bi-circle"></i>Ejecutado</a></li>
                        </ul>
                      </li>';

			break;
	}
//-------------------------------------
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {



//---------------------------------
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo);
  exit;
}
?>


<?php
$titulo='SISPA';//************************TITULO DE PAGINA
//$stitulo='<a href="../escritorio/" class="site_title"><span style="font-size: 24px;">SISPA</span></a>';
$stitulo='<a href="../escritorio/" class="site_title"><img src="../images/logo.png" class="img-responsive"></a>';



$titulomenu='';
$alertborrar='Esta seguro de eliminar este registro?';
$_SESSION['codusuario'];
$_SESSION['MM_UserGroup'];
//$foto="../perfil/".$_SESSION['codusuario'].".jpg";
//$foto="../perfil/admin.jpg";
$foto="../images/usuario.png";
$husuario=$_SESSION['MM_Username'];




function inicipcounter($consulta, $conexion, $variable, $valor)
{

$tactividad = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
$row_tactividad = mysqli_fetch_assoc($tactividad);

$vector=array();
		do {

           $x = $variable;
		   $x = $row_tactividad[$x];
		   if($row_tactividad[$valor] <= 0)
		   {
			   $row_tactividad[$valor]=1;
			   }

			$vector[$x]=$row_tactividad[$valor];
			//$accion[$row_tactividad[$variable]]=$row_tactividad[$valor];
		  } while ($row_tactividad = mysqli_fetch_assoc($tactividad));
		  //print_r ($vector);
return $vector;
}
$menu=$_SESSION['xx'];//$_SESSION["menus"];



//************************************* nav top
$navtop='';
$navtopx='<div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Perfil</a></li>
                    <li><a href="../salir/"><i class="fa fa-sign-out pull-right"></i> Salirrr</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>';
$navtop2='<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="../escritorio/">IR AL MENU</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">BUSCAR</button>
      </form>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>';
//**************************************** menu links de la parte inferior
$hmeninf='';


$headerpag='';
$footer='';



$get=$_SERVER['SERVER_NAME']."/".$_SERVER['PHP_SELF'].'<hr>';
$post=$_SERVER['SERVER_NAME']."/".$_SERVER['PHP_SELF'].'<hr>';
foreach($_GET as $key=>$value)
{
	$get.= $key."=>".$value."<br>";

}
foreach($_POST as $key=>$value)
{
	$post.= $key."=>".$value."<br>";

}
$postget="*********************".$get."****************".$post;
$log_handle = @fopen("../logs/".$_SESSION['MM_Username']."_".date("M-Y").".txt", 'ab');
	@fwrite($log_handle, date("M-d H:i:s")." \t ".$postget." \t ".$ip."\r\n");
	@fclose($log_handle);
?>