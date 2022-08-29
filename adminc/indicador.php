<?php
require_once('../locklvl.php');
$MM_authorizedUsers =usuario(0);
require_once('../lock.php'); ?>
<?php require_once('../Connections/conexion.php'); ?>
<?php
# Ocultar warnings
error_reporting(E_ERROR | E_PARSE);

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    //$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
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
	$codindicador=generarCodigo(16);
//  $insertSQL = sprintf("INSERT INTO indicador (cod_indicador, cod_financiador_ind, descr_indicador, pond_2021, pond_2022, pond_2023, pond_2024, pond_2025, indicador_orden) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",

  $insertSQL = sprintf("INSERT INTO indicador (cod_indicador, cod_financiador_ind, descr_indicador, indicador_orden) VALUES (%s, %s, %s, %s)",
                      GetSQLValueString($codindicador, "text"),
                      GetSQLValueString($_POST['cod_financiador_ind'], "text"),
                      GetSQLValueString($_POST['descr_indicador'], "text"),
                      // str_replace(",", ".", GetSQLValueString($_POST['2021'], "text")),
                      // str_replace(",", ".", GetSQLValueString($_POST['2022'], "text")),
                      // str_replace(",", ".", GetSQLValueString($_POST['2023'], "text")),
                      // str_replace(",", ".", GetSQLValueString($_POST['2024'], "text")),
                      // str_replace(",", ".", GetSQLValueString($_POST['2025'], "text")),
                      GetSQLValueString($_POST['orden'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "indicador.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_listaindicadores = 10;
$pageNum_listaindicadores = 0;
if (isset($_GET['pageNum_listaindicadores'])) {
  $pageNum_listaindicadores = $_GET['pageNum_listaindicadores'];
}
$startRow_listaindicadores = $pageNum_listaindicadores * $maxRows_listaindicadores;

$colname_listaindicadores = "-1";
if (isset($_GET['finan'])) {
  $colname_listaindicadores = $_GET['finan'];
}
mysqli_select_db($conexion, $database_conexion);
$query_listaindicadores = sprintf("SELECT * FROM financiador INNER JOIN indicador ON financiador.cod_finnanciador=indicador.cod_financiador_ind WHERE indicador.cod_financiador_ind = %s ORDER BY indicador.indicador_orden, indicador.id_indicador ASC", GetSQLValueString($colname_listaindicadores, "text"));
$query_limit_listaindicadores = sprintf("%s LIMIT %d, %d", $query_listaindicadores, $startRow_listaindicadores, $maxRows_listaindicadores);
$listaindicadores = mysqli_query($conexion, $query_limit_listaindicadores) or die(mysqli_error($conexion));
$row_listaindicadores = mysqli_fetch_assoc($listaindicadores);

if (isset($_GET['totalRows_listaindicadores'])) {
  $totalRows_listaindicadores = $_GET['totalRows_listaindicadores'];
} else {
  $all_listaindicadores = mysqli_query($conexion, $query_listaindicadores);
  $totalRows_listaindicadores = mysqli_num_rows($all_listaindicadores);
}
$totalPages_listaindicadores = ceil($totalRows_listaindicadores/$maxRows_listaindicadores)-1;

$queryString_listaindicadores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listaindicadores") == false &&
        stristr($param, "totalRows_listaindicadores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listaindicadores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listaindicadores = sprintf("&totalRows_listaindicadores=%d%s", $totalRows_listaindicadores, $queryString_listaindicadores);


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
              <div class="navbar nav_title" style="border: 0; text-align: center;">
              <?php
			  echo $stitulo;
			  ?>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo $foto; ?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Hola,</span>
                <h2><?php echo $husuario; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
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
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <?php echo $hmeninf; ?>
            <!-- /menu footer buttons -->
          </div>
        </div>
<?php
echo $navtop;
?>

        <div class="right_col" role="main">

<?php
		echo $headerpag;
		?>
			<div class="page-title">
              <div class="title_left">
				<h1>
						<small>MENU / ADMINISTRADOR / </small>I. APS - METAS
				</h1>
				<h4>
							<div class="btn-group">
								<a href="financiadores.php" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-default"><i class="fa fa-reply"></i></a>
                                <a href="financiadores.php" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-primary">APS <?php echo $row_listaindicadores['nombre_financiador']; ?></a>
							</div>
				</h4>
              </div>
         </div>

          <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile">
                <div class="x_title">
                  <h2>INDICADORES POR COMPONENTE</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-block btn-default">Registrar Nuevo Indicador</a>
                    </li>
                  </ul>
                  <ul class="nav navbar-right panel_toolbox">
                    <li></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

<table id="datatable-responsive" class="table table-bordered table-hover" cellspacing="0" >
<thead>
        <tr>
          <th width="5%" align="center" valign="middle">&nbsp;</th>
          <th width="5%" align="center" valign="middle">&nbsp;</th>
          <th width="5%" height="39" align="center" valign="middle">Nº</th>
          <th width="75%" align="center" valign="middle">DESCRIPCION</th>
<!-- 
          <th align="center" valign="middle">2021</th>
          <th align="center" valign="middle">2022</th>
          <th align="center" valign="middle">2023</th>
          <th align="center" valign="middle">2024</th>
          <th align="center" valign="middle">2025</th>
           -->
          <th width="10%" align="center" valign="middle">INDICADORES</th>
          <!-- <th width="10%" align="center" valign="middle"></th>
          <th width="10%" align="center" valign="middle">IMAGEN</th> -->
          </tr>
          </thead>
          <tbody>
        <?php 
		do { 
		$sigord=$row_listaindicadores['indicador_orden'];
		?>
          <tr>
            <td>
<a href="delcoord.php?del=<?php echo $row_listaindicadores['cod_indicador']; ?>&finan=<?php echo $_GET['finan']; ?>&a=indicador&b=cod_indicador&c=indicador" data-toggle="tooltip" data-placement="top" title="Eliminar este registro de la LISTA DE INDICADORES" onclick="if(!confirm('<?php echo $alertborrar; ?>'))return false"><i class="fa fa-close fa-2x"></i></a>
            </td>
            <td><a class="btn btn-succes" data-toggle='modal' data-target='#option' onClick="ventana('editarind','<?php echo $row_listaindicadores['cod_indicador'].'&finan='.$_GET['finan']; ?>','pop')">
<i class="fa fa-pencil fa-2x"></i>
</a> </td>
            <td><?php echo $row_listaindicadores['indicador_orden']; ?></td>
            <td><?php echo $row_listaindicadores['descr_indicador']; ?></td>
            <!-- <td><?php echo $row_listaindicadores['pond_2021']; ?></td>
            <td><?php echo $row_listaindicadores['pond_2022']; ?></td>
            <td><?php echo $row_listaindicadores['pond_2023']; ?></td>
            <td><?php echo $row_listaindicadores['pond_2024']; ?></td>
            <td><?php echo $row_listaindicadores['pond_2025']; ?></td> -->
            <td><a href="metas.php?finan=<?php echo $_GET['finan']; ?>&indicador=<?php echo $row_listaindicadores['cod_indicador']; ?>" class="btn btn-block btn-default">
<span class="badge"><?php

		$contare = mysqli_query($conexion, contare('meta','cod_indicador_meta',$row_listaindicadores['cod_indicador'])) or die(mysqli_error($conexion));
		$row_contare = mysqli_fetch_assoc($contare);
		    if(isset($row_contare)){
      if($row_contare['disp'] > 0 ) {$valc=$row_contare['disp'];}else{$valc=0;}
      echo $valc;
    } else {
      echo '0';
    }

		?></span>
            </a></td>
            <!-- <td>
              <?php
                    if($row_listaindicadores['id_img_indicador'])
                    {
                      // echo '<img src="../imagenesayuda/'.$row_listaindicadores['id_img_indicador'].'" width="75">';
                    }
               ?>
            </td>
            <td>
<a href="#" data-toggle="modal" data-target="#optionimg" class="btn btn-block btn-default" onclick="ventana('asignarimgind','<?php echo $row_listaindicadores['cod_indicador']; ?>&finan=<?php echo $_GET['finan']; ?>','popimg')">
IMG</a>
            </td> -->
            </tr>
          <?php } while ($row_listaindicadores = mysqli_fetch_assoc($listaindicadores)); ?>
          </tbody>
        </table>
<table border="0">
        <tr>
          <td><?php if ($pageNum_listaindicadores > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listaindicadores=%d%s", $currentPage, 0, $queryString_listaindicadores); ?>">Primero</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listaindicadores > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listaindicadores=%d%s", $currentPage, max(0, $pageNum_listaindicadores - 1), $queryString_listaindicadores); ?>">Anterior</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listaindicadores < $totalPages_listaindicadores) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listaindicadores=%d%s", $currentPage, min($totalPages_listaindicadores, $pageNum_listaindicadores + 1), $queryString_listaindicadores); ?>">Siguiente</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_listaindicadores < $totalPages_listaindicadores) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listaindicadores=%d%s", $currentPage, $totalPages_listaindicadores, $queryString_listaindicadores); ?>">&Uacute;ltimo</a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table>


  </div>
              </div>
            </div>
          </div>
        </div>
        <?php //echo $footer; ?>
        <!-- /footer content -->
      </div>
    </div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">NUEVO REGISTRO INDICADOR</h4>
      </div>
      <div class="modal-body">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table class="table" style="background-color: #CCCCCC;">

          <tr valign="baseline">
            <td><input type="hidden" name="cod_financiador_ind" value="<?php echo $_GET['finan']; ?>"  class="form-control"></td>
            </tr>
          <tr valign="baseline">
            <td>INDICADOR Y COMPONENTE:</td>
          </tr>
          <tr valign="baseline">
            <td><textarea name="descr_indicador" class="form-control" rows="5" required></textarea></td>
            </tr>
<!--             
          <tr valign="baseline">
            <td>PONDERACION 2021:</td>
            <td>
            <input name="2021" type="text">
          </td>

          <tr valign="baseline">
            <td>PONDERACION 2022:</td>
            <td>
            <input name="2022" type="text">
          </td>
          
          <tr valign="baseline">
            <td>PONDERACION 2023:</td>
            <td>
            <input name="2023" type="text">
          </td>
          </tr>

           <tr valign="baseline">
            <td>PONDERACION 2024:</td>
            <td>
            <input name="2024" type="text">
            </td>
          </tr>

           <tr valign="baseline">
            <td>PONDERACION 2025:</td>
            <td>
            <input name="2025" type="text">
            </td>
          </tr> -->

          <tr valign="baseline">
            <td>ORDEN:</td>
          </tr>
          <tr valign="baseline">
            <td>
            <input type="text" name="orden" id="orden" class="form-control" value="<?php echo $sigord+1; ?>" required></td>
          </tr>
          <tr valign="baseline">
            <td><input type="submit" value="Insertar registro" class="btn btn-block btn-default"></td>
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
        <h4 class="modal-title" id="large"><?php echo $editar; ?></h4>
      </div>
      <div class="modal-body" id="pop">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $close; ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="optionimg" tabindex="-1" role="dialog" aria-labelledby="large" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="large">ASIGNAR IMAGEN</h4>
      </div>
      <div class="modal-body" id="popimg">

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
mysqli_free_result($contare);
mysqli_free_result($listaindicadores);
?>