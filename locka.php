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
$g0='<li><a><i class="fa fa-home"></i> ADMIN <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../adminc/">Pilares</a></li>
                      <li><a href="../adminc/financiadores.php">Financiador</a></li>
                    </ul>
                  </li>';
$g1='<li><a><i class="fa fa-edit"></i> REVISOR <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../revisor/general.php">General</a></li>
					  <li><a href="../revisor/">* Financiador</a></li>
                    </ul>
                  </li>';
$g2='<li><a><i class="fa fa-desktop"></i> INFORMES <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../revisor/infgeneral.php">General</a></li>
					  <li><a href="../informes/">* Financiador</a></li>
                    </ul>
                  </li>';
$g3='<li><a><i class="fa fa-desktop"></i> RESPONSABLES <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../responsables/">Tareas</a></li>
                    </ul>
                  </li>';

//---------------------------------
$configuracion='';
switch($_SESSION['MM_UserGroup'])
	{
		case 0:
			$_SESSION['xx']='<ul class="nav side-menu">'.$g0.$g1.$g2.$g3.'</ul>';
			$configuracion='<div class="menu_section">
                <h3>CONFIGURACION</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> CUENTAS <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../usuario/">NUEVO USUARIO</a></li>
                     
                    </ul>
                  </li>
                </ul>
              </div>';
			break;
		case 1:
		$_SESSION['xx']='<ul class="nav side-menu">'.$g1.$g2.$g3.'</ul>';

			break;
		case 2:
		$_SESSION['xx']='<ul class="nav side-menu">'.$g2.$g3.'</ul>';
			break;
		case 3:
		$_SESSION['xx']='<ul class="nav side-menu">'.$g3.'</ul>';

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
$titulo='SISTEMA DE MONITOREO';//************************TITULO DE PAGINA
$stitulo='<a href="../escritorio/" class="site_title"><span>SISTEMA</span></a>';
$_SESSION['codusuario'];
$_SESSION['MM_UserGroup'];
$foto="../perfil/".$_SESSION['codusuario'].".jpg";
$husuario=$_SESSION['MM_Username'];




function inicipcounter($consulta, $conexion, $variable, $valor)
{
	
$tactividad = mysql_query($consulta, $conexion) or die(mysqli_error($conexion));
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
              <a href="../salir/" data-toggle="tooltip" data-placement="top" title="Salir">
                Salir
              </a>
              <a data-toggle="tooltip" data-placement="top" title="op2">
                link
              </a>
              <a data-toggle="tooltip" data-placement="top" title="op3">
                link
              </a>
              <a data-toggle="tooltip" data-placement="top" title="op4">
               link
              </a>
            </div>
';
$headerpag='<div class="page-title">
              <div class="title_left">
                <h3>Form Elements</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>';
$headerpagx='<div class="row">
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
          <br />';
$footer='<footer>
          <div class="pull-right">
           ** Sistema Realizado por:
          </div>
          <div class="clearfix">**>>></div>
        </footer>';
$color1='bgcolor="#E9E9E9"';
$color2='bgcolor="#DDEEFF"';


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