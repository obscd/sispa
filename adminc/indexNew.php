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
	$codpilar=generarCodigo(16);
  $insertSQL = sprintf("INSERT INTO pilar (cod_pilar, titulo_pilar, descr_pilar, orden_pilar) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($codpilar, "text"),
                       GetSQLValueString($_POST['titulo_pilar'], "text"),
                       GetSQLValueString($_POST['descr_pilar'], "text"),
					   GetSQLValueString($_POST['orden'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_listapilares = 500;
$pageNum_listapilares = 0;
if (isset($_GET['pageNum_listapilares'])) {
  $pageNum_listapilares = $_GET['pageNum_listapilares'];
}
$startRow_listapilares = $pageNum_listapilares * $maxRows_listapilares;

mysqli_select_db($conexion, $database_conexion);
//$query_listapilares = "SELECT *, COUNT(programa.cod_programa) AS disp FROM (pilar LEFT JOIN programa ON pilar.cod_pilar=programa.cod_pilar_pro) GROUP BY programa.cod_pilar_pro ORDER BY pilar.orden_pilar, pilar.id_pilar ASC";
$query_listapilares = "SELECT *FROM (pilar) ORDER BY pilar.orden_pilar, pilar.id_pilar ASC";
$query_limit_listapilares = sprintf("%s LIMIT %d, %d", $query_listapilares, $startRow_listapilares, $maxRows_listapilares);
$listapilares = mysqli_query($conexion, $query_limit_listapilares) or die(mysqli_error($conexion));
$row_listapilares = mysqli_fetch_assoc($listapilares);


if (isset($_GET['totalRows_listapilares'])) {
  $totalRows_listapilares = $_GET['totalRows_listapilares'];
} else {
  $all_listapilares = mysqli_query($conexion, $query_listapilares);
  $totalRows_listapilares = mysqli_num_rows($all_listapilares);
}
$totalPages_listapilares = ceil($totalRows_listapilares/$maxRows_listapilares)-1;

$queryString_listapilares = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listapilares") == false &&
        stristr($param, "totalRows_listapilares") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listapilares = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listapilares = sprintf("&totalRows_listapilares=%d%s", $totalRows_listapilares, $queryString_listapilares);
?>

<?php 
require_once('../header.php');
?>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Escritorio</span>
        </a>
      </li><!-- End Dashboard Nav -->

          <h3><?php echo $titulomenu; ?></h3>

          <?php echo $menu; ?>

        </div>

        <?php echo $configuracion; ?>
    </ul>
  </aside>
  <!-- ======= end Sidebar ======= -->

            <!-- /menu footer buttons -->
            <?php echo $hmeninf; ?>
            <!-- /menu footer buttons -->
          </div>
        </div>
<?php
echo $navtop;
?>
<main id="main" class="main">
        <div class="right_col" role="main">
		<?php
		echo $headerpag;
		?>
			<div class="pagetitle">
        <h1>PILARES</h1>
      </div>

      <section class="section">
        <div class="row">
          <div class="col-lg-12">

                <div class="x_panel">
                  <div class="x_title">
                    
                     <ul class="nav navbar-right panel_toolbox">
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary rounded-pill">Registrar Nuevo Pilar</a>
                        </li>
                      </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">

                    </p>
                    <table id="datatable-responsive" class="table datatable table-striped" cellspacing="0" >
                      <thead>
                        <tr>
                          <th width="18">&nbsp;</th>
                          <th>&nbsp;</th>
                          <th>CODIGO</th>
                          <th>TITULO</th>
                          <th>DESCRIPCION</th>
                          <th>PROGRAMAS</th>

                        </tr>
                      </thead>


                      <tbody>
 <?php
$orden=0;
 do { 
if($row_listapilares['orden_pilar'] >= $orden)
{
$orden=$row_listapilares['orden_pilar'];
}

?>
      <tr>
        <td align="center">
        <a href="delcoord.php?del=<?php echo $row_listapilares['cod_pilar']; ?>&a=pilar&b=cod_pilar&c=pilar" data-toggle="tooltip" data-placement="top" title="Eliminar este registro de la LISTA DE PILARES" onclick="if(!confirm('<?php echo $alertborrar; ?>'))return false"><i class="fa fa-close fa-2x"></i></a>

        </td>
        <td align="center">
          <a class="btn btn-succes" data-bs-toggle='modal' data-bs-target='#option' onClick="ventana('editar','<?php echo $row_listapilares['cod_pilar']; ?>','pop')">
          <i class="fa fa-pencil fa-2x"></i>
          </a>
        </td>
        <td align="center">
<?php echo $row_listapilares['orden_pilar']; ?>


        </td>
        <td><?php echo $row_listapilares['titulo_pilar']; ?></td>
        <td data-toggle="tooltip" data-placement="top" title="Para ver los PROGRAMAS de este Pilar CLICK EN EL BOTON DE LA DERECHA >>>>"><?php echo $row_listapilares['descr_pilar']; ?></td>
        <td align="center"><a href="programa.php?pilar=<?php echo $row_listapilares['cod_pilar']; ?>" class="btn btn-block btn-default"><span class="badge"><?php

		$contare = mysqli_query($conexion, contare('programa','cod_pilar_pro',$row_listapilares['cod_pilar'])) or die(mysqli_error($conexion));
		$row_contare = mysqli_fetch_assoc($contare);
    if(isset($row_contare)){
      if($row_contare['disp'] > 0 ) {$valc=$row_contare['disp'];}else{$valc=0;}
      echo $valc;
    } else {
      echo '0';
    }

		?></span></a></td>
        </tr>
      <?php } while ($row_listapilares = mysqli_fetch_assoc($listapilares)); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

          </div>
        </div>
</main>
        <?php echo $footer; ?>
        <!-- /footer content -->
      </div>
    </div>


<!-- modal registrar nuevo -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">NUEVO REGISTRO PILAR</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table class="table">
          <tr valign="baseline">
            <td>TITULO</td>
          </tr>
          <tr valign="baseline">
            <td><input type="text" name="titulo_pilar" class="form-control" required></td>
          </tr>
          <tr valign="baseline">
            <td>DESCRIPCION</td>
          </tr>
          <tr valign="baseline">
            <td><textarea name="descr_pilar" rows="3" class="form-control" required></textarea></td>
          </tr>
		      <tr valign="baseline">
            <td>ORDEN</td>
          </tr>
          <tr valign="baseline">
            <td><input type="text" name="orden" value="<?php echo $orden + 1; ?>" class="form-control" required></td>
          </tr>
          <tr valign="baseline">
            <td><input type="submit" value="Insertar registro" class="btn btn-success btn-block"></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo $close; ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="option" tabindex="-1" role="dialog" aria-labelledby="large" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="large"><?php echo $editar; ?></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
      </div>
      <div class="modal-body" id="pop">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          <table class="table">
            <tr valign="baseline">
              <td>TITULO</td>
            </tr>
            <tr valign="baseline">
              <td><input type="text" name="titulo_pilar" class="form-control" required></td>
            </tr>
            <tr valign="baseline">
              <td>DESCRIPCION</td>
            </tr>
            <tr valign="baseline">
              <td><textarea name="descr_pilar" rows="3" class="form-control" required></textarea></td>
            </tr>
            <tr valign="baseline">
              <td>ORDEN</td>
            </tr>
            <tr valign="baseline">
              <td><input type="text" name="orden" value="<?php echo $orden + 1; ?>" class="form-control" required></td>
            </tr>
            <tr valign="baseline">
              <td><input type="submit" value="Actualizar registro" class="btn btn-success btn-block"></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo $close; ?></button>
      </div>
    </div>
  </div>
</div>

<?php //require('../jsadmin.php'); ?>

<?php
require_once('../footer.php');
?>
<?php
mysqli_free_result($contare);
mysqli_free_result($listapilares);
?>