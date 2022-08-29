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
$g0='<li><a><i class="fa fa-home"></i> ADMINISTRADOR <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../adminc/">PLAN DE ACCION</a></li>
                      <li><a href="../adminc/financiadores.php">METAS</a></li>
                    </ul>
                  </li>';
$g1='<!-- <li><a><i class="fa fa-edit"></i> REVISOR <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                                          <li><a href="../revisor/general.php">PLAN DE ACCION</a></li>
					  <li><a href="../revisor/financiador.php?financiador=20160923111919">METAS</a></li> -->
					  <!-- <li><a href="../graficas/">RESUMEN I. APS - PA</a></li> -->
            <!-- </ul>
                  </li> -->';
$g2='<li><a><i class="fa fa-check-circle"></i>REPORTES<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../informes/reportes.php">Descargar</a></li>
                    <!--   
                      <li><a href="../informes/infgeneral.php">PLAN DE ACCION</a></li>
	                    <li><a href="../informes/aps.php">METAS</a></li>
                      <li><a href="../informes/plan.php">GRAFICA PLAN ACCION</a></li>
					            <li><a href="../informes/">GRAFICA I. APS</a></li>
                    -->  
                    </ul>
                  </li>';
$g3='<li><a><i class="fa fa-desktop"></i> RESPONSABLES <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../responsables/">Tareas</a></li>
                    </ul>
                  </li>';
/*$g4='<li><a><i class="fa fa-usd"></i> PRESUPUESTO <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../presupuesto/">Programado</a></li>
		      <li><a href="../administracion/">Ejecutado</a></li>
                    </ul>
                  </li>';*/
$g4a='<li><a href="../images/manual-admin.pdf" target="_blank"><i class="fa fa-question-circle "></i> MANUAL DE USUARIO</a>                    
                  </li>';
$g4b='<li><a href="../images/manual-revisor.pdf" target="_blank"><i class="fa fa-question-circle "></i> MANUAL DE USUARIO</a>                    
                  </li>';
$g4c='<li><a href="../images/manual-responsable.pdf" target="_blank"><i class="fa fa-question-circle "></i> MANUAL DE USUARIO</a>                    
                  </li>';
$g5='';

//---------------------------------
$configuracion='';
switch($_SESSION['MM_UserGroup'])
	{
		case 0:
			$_SESSION['xx']='<ul class="nav side-menu">'.$g0.$g1.$g2.$g3.$g4a.'
                  <li><a><i class="fa fa-group"></i> USUARIOS <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../usuario/">USUARIOS</a></li>
					            <!-- <li><a href="../upload/">IMAGENES</a></li> -->

                    </ul>
                  </li>
                </ul>
              </div>';
			break;
		case 1:
		$_SESSION['xx']='<ul class="nav side-menu">'.$g1.$g2.$g4b.'</ul>';

			break;
		case 2:
		$_SESSION['xx']='<ul class="nav side-menu">'.$g2.$g4da.'</ul>';
			break;
		case 3:
		$_SESSION['xx']='<ul class="nav side-menu">'.$g3.$g4c.'</ul>';

			break;
		case 4:
		$_SESSION['xx']='<ul class="nav side-menu"><li><a><i class="fa fa-usd"></i> PRESUPUESTO <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../presupuesto/financiador.php?financiador=20160923111919">Programado</a></li>
                    </ul>
                  </li></ul>';

			break;
		case 5:
		$_SESSION['xx']='<ul class="nav side-menu"><li><a><i class="fa fa-usd"></i> PRESUPUESTO <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

					   <li><a href="../administracion/financiador.php?financiador=20160923111919">Ejecutado</a></li>
                    </ul>
                  </li></ul>';

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
$titulo='SISPA';
$stitulo='<a href="../escritorio/" class="site_title">SISPA</a>';


if($_SESSION['entidad']){
  $titulomenu=$_SESSION['entidad'];
} else {
  $titulomenu="ADMINISTRACIÓN";
}
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
                    <li><a href="../salir/"><i class="fa fa-sign-out pull-right"></i> Salir</a></li>
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
$hmeninf='
<div class="sidebar-footer hidden-small">
              <a href="../salir/" data-toggle="tooltip" data-placement="top" title="Salir" style="color:white;">
                Salir
              </a>
            </div>
';


$headerpag='<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-12">
                   <img src="../images/2.jpg" class="img-responsive">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          ';
$headerpag = '';
$footer='<footer>
          <div class="pull-right">

          </div>
          <div class="clearfix">

		  </div>
        </footer>';



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