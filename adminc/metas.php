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

# crear meta
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $meta[1] = GetSQLValueString($_POST['meta1'], "int");
  $meta[2] = GetSQLValueString($_POST['meta2'], "int");
  $meta[3] = GetSQLValueString($_POST['meta3'], "int");
  $meta[4] = GetSQLValueString($_POST['meta4'], "int");
  $meta[5] = GetSQLValueString($_POST['meta5'], "int");
  $gestion=2021;

  $codmeta=generarCodigo(16);

  for($i=1;$i<6;$i++){
    
    //$insertSQL = sprintf("INSERT INTO meta (cod_meta, cod_indicador_meta, gestion, descr_meta, ponderacion, fecha_ini, fecha_fin, cumplimiento_meta, respuesta_real_decumpl) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
    $insertSQL = sprintf("INSERT INTO meta (cod_meta, cod_indicador_meta, gestion, descr_meta, ponderacion, fecha_ini, fecha_fin, cumplimiento_meta, respuesta_real_decumpl) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                        GetSQLValueString($codmeta, "text"),
                        GetSQLValueString($_POST['cod_indicador_meta'], "text"),
                        $gestion,
                        GetSQLValueString($_POST['descr_meta'], "text"),
                        GetSQLValueString(100, "int"),
                        GetSQLValueString('-', "date"),
                        GetSQLValueString('-', "date"),
                        $meta[$i],
                        GetSQLValueString('0', "int"));

    //echo $insertSQL;
    mysqli_select_db($conexion, $database_conexion);
    $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

    # asignar responsable, si existe
    if (!empty($_POST['usuario'])) {
      echo
      $insertSQL = sprintf("INSERT INTO meta_usaurios (meta_login, cod_meta_mtus) VALUES (%s, %s)",
                          GetSQLValueString($_POST['usuario'], "text"),
                          GetSQLValueString($codmeta, "text"));
      //echo $insertSQL;

      mysqli_select_db($conexion, $database_conexion);
      $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));
    }

    #asignar meta, si existe
    if(!empty($_POST['accionesPilar'])){
      # almacenar relacion meta-accion en tabla 'coordinador'
      $insertSQL = sprintf("INSERT INTO coordinador (cod_quien_necesita, cod_meta_coord) VALUES (%s, %s)",
                       GetSQLValueString($_POST['accionesPilar'], "text"),
                       GetSQLValueString($codmeta, "text"));
      mysqli_select_db($conexion, $database_conexion);
      $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

      # actualizar registro de meta con asignacion de accion
      $updateSQL = sprintf("UPDATE meta SET meta_estado=%s WHERE cod_meta=%s",
                       GetSQLValueString('1', "int"),
                       GetSQLValueString($codmeta, "text"));
      mysqli_select_db($conexion, $database_conexion);
      $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));
    }

    $gestion=$gestion+1;
    $codmeta=$codmeta+1;

  }


  $insertGoTo = "metas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}



$maxRows_listarmetas = 500;
$pageNum_listarmetas = 0;
if (isset($_GET['pageNum_listarmetas'])) {
  $pageNum_listarmetas = $_GET['pageNum_listarmetas'];
}
$startRow_listarmetas = $pageNum_listarmetas * $maxRows_listarmetas;

$colname_listarmetas = "-1";
if (isset($_GET['indicador'])) {
  $colname_listarmetas = $_GET['indicador'];
}
mysqli_select_db($conexion, $database_conexion);
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formb")) {
  $insertSQL = sprintf("INSERT INTO meta_usaurios (meta_login, cod_meta_mtus) VALUES (%s, %s)",
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['cc'], "text"));

  mysqli_select_db($conexion, $database_conexion);
  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));
}
$colname_financiado = "-1";
if (isset($_GET['indicador'])) {
  $colname_financiado = $_GET['indicador'];
}
//ver financiador y indicador
$query_financiado = sprintf("SELECT * FROM financiador INNER JOIN indicador ON financiador.cod_finnanciador=indicador.cod_financiador_ind WHERE indicador.cod_indicador=%s ", GetSQLValueString($colname_financiado, "text"));
$financiado = mysqli_query($conexion, $query_financiado) or die(mysqli_error($conexion));
$row_financiado = mysqli_fetch_assoc($financiado);
$totalRows_financiado = mysqli_num_rows($financiado);

//$query_listarmetas = sprintf("SELECT * FROM meta LEFT JOIN meta_usaurios ON meta.cod_meta=meta_usaurios.cod_meta_mtus WHERE meta.cod_indicador_meta = %s GROUP BY meta_usaurios.cod_meta_mtus ", GetSQLValueString($colname_listarmetas, "text"));
$query_listarmetas = sprintf("SELECT * FROM meta LEFT JOIN meta_usaurios ON meta.cod_meta=meta_usaurios.cod_meta_mtus WHERE meta.cod_indicador_meta = %s ORDER BY meta_usaurios.id DESC", GetSQLValueString($colname_listarmetas, "text"));

$query_limit_listarmetas = sprintf("%s LIMIT %d, %d", $query_listarmetas, $startRow_listarmetas, $maxRows_listarmetas);
$listarmetas = mysqli_query($conexion, $query_limit_listarmetas) or die(mysqli_error($conexion));
$row_listarmetas = mysqli_fetch_assoc($listarmetas);

$query_listarunameta = sprintf("SELECT * FROM meta LEFT JOIN meta_usaurios ON meta.cod_meta=meta_usaurios.cod_meta_mtus WHERE meta.cod_indicador_meta = %s GROUP BY meta.id_meta ", GetSQLValueString($colname_listarmetas, "text"));
$query_limit_listarunameta = sprintf("%s LIMIT %d, %d", $query_listarunameta, $startRow_listarmetas, $maxRows_listarmetas);
$listarunameta = mysqli_query($conexion, $query_limit_listarunameta) or die(mysqli_error($conexion));
$row_listarunameta = mysqli_fetch_assoc($listarunameta);


$query_listausuario = "SELECT * FROM login ORDER BY usuario_login ASC";
$listausuario = mysqli_query($conexion, $query_listausuario) or die(mysqli_error($conexion));
$row_listausuario = mysqli_fetch_assoc($listausuario);
$totalRows_listausuario = mysqli_num_rows($listausuario);

if (isset($_GET['totalRows_listarmetas'])) {
  $totalRows_listarmetas = $_GET['totalRows_listarmetas'];
} else {
  $all_listarmetas = mysqli_query($conexion, $query_listarmetas);
  $totalRows_listarmetas = mysqli_num_rows($all_listarmetas);
}
$totalPages_listarmetas = ceil($totalRows_listarmetas/$maxRows_listarmetas)-1;

$queryString_listarmetas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listarmetas") == false &&
        stristr($param, "totalRows_listarmetas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listarmetas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listarmetas = sprintf("&totalRows_listarmetas=%d%s", $totalRows_listarmetas, $queryString_listarmetas);


$query_listaentidad = "SELECT * FROM entidad ORDER BY sigla ASC";
$listaentidad = mysqli_query($conexion, $query_listaentidad) or die(mysqli_error($conexion));
$row_listaentidad = mysqli_fetch_assoc($listaentidad);
$totalRows_listaentidad = mysqli_num_rows($listaentidad);


$selus='<select name="usuario" class="form-control input-sm" required>';

$selus .= '<option value="" >Seleccionar entidad</option>';
do {
 $selus .= '<option value="'.$row_listaentidad['sigla'].'" >'.$row_listaentidad['sigla'].'</option>';
} while ($row_listaentidad = mysqli_fetch_assoc($listaentidad));

$selus .='</select>';




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
								<a href="indicador.php?finan=<?php echo $_GET['finan']; ?>" data-toggle="tooltip" data-placement="top" title="ir a:" class="btn btn-sm btn-default"><i class="fa fa-reply"></i></a>
                                <a href="financiadores.php" data-toggle="tooltip" data-placement="bottom" title="<?php echo 'ir a: '.$row_financiado['nombre_financiador']; ?>" class="btn btn-sm btn-default">APS <?php echo substr($row_financiado['nombre_financiador'], 0, 30).'...'; ?></a>
								<a href="indicador.php?finan=<?php echo $_GET['finan']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row_financiado['descr_indicador']; ?>" class="btn btn-sm btn-primary">INDICADOR. <?php echo $row_financiado['indicador_orden']; ?></a>
							</div>
				</h4>
              </div>
         </div>

          <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile">
                <div class="x_title">
                  <h2>METAS</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-block btn-default">Registrar Nueva META</a>
                    </li>
                  </ul>
                  <ul class="nav navbar-right panel_toolbox">
                    <li></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

<p>
<?php //echo $row_financiado['descr_indicador']; ?></p>

<table id="datatable-responsive" class="table table-bordered table-hover" cellspacing="0" >
  <thead>
    <tr>
      <th bgcolor="#2A3F54"></th>
      <th bgcolor="#2A3F54"></th>
      <th bgcolor="#2A3F54">Nº</th>
      <th bgcolor="#2A3F54">GESTION</th>
      <th bgcolor="#2A3F54">DESCRIPCION</th>
      <!-- <th bgcolor="#2A3F54">PONDERACION</th> -->
      <th bgcolor="#2A3F54">META</th>
      <th bgcolor="#2A3F54">ENTIDAD ASIGNADA</th>
      <th bgcolor="#2A3F54">ASIGNAR ENTIDAD</th>
      <!-- <th bgcolor="#2A3F54"></th>
      <th bgcolor="#2A3F54">IMAGEN</th> -->
    </tr>
  </thead>
  <tbody>
    <?php
    $cc=0;
    do {
    $cc++;
    ?>
    <tr>
      <td><a href="delcoord.php?del=<?php echo $row_listarunameta['cod_meta']; ?>&finan=<?php echo $_GET['finan']; ?>&indicador=<?php echo $_GET['indicador']; ?>&a=meta&b=cod_meta&c=metas" data-toggle="tooltip" data-placement="top" title="Eliminar este registro de la LISTA DE METAS" onclick="if(!confirm('<?php echo $alertborrar; ?>'))return false"><i class="fa fa-close fa-2x"></i></a></td>
      <td><a class="btn btn-succes" data-toggle='modal' data-target='#option' onClick="ventana('editarme','<?php echo $row_listarunameta['cod_meta'].'&finan='.$_GET['finan'].'&indicador='.$_GET['indicador']; ?>','pop')"> <i class="fa fa-pencil fa-2x"></i> </a></td>
      <td><?php echo $cc; ?></td>
      <td><?php echo $row_listarunameta['gestion']; ?></td> 
      <td><?php echo $row_listarunameta['descr_meta']; ?></td>
      <!-- <td><?php echo $row_listarunameta['ponderacion']; ?></td> -->
      <td><?php echo $row_listarunameta['cumplimiento_meta']; ?></td>
      <td>
	  <?php
//********** ASIGNAR USUARIO ************************************************************
mysqli_select_db($conexion, $database_conexion);
$query_listarusuarios = sprintf("SELECT * FROM meta_usaurios WHERE cod_meta_mtus = %s ORDER BY id ASC", GetSQLValueString($row_listarunameta['cod_meta_mtus'], "text"));
$listarusuarios = mysqli_query($conexion, $query_listarusuarios) or die(mysqli_error($conexion));
$row_listarusuarios = mysqli_fetch_assoc($listarusuarios);
$totalRows_listarusuarios = mysqli_num_rows($listarusuarios);
do {
echo $row_listarusuarios['meta_login'].'
<a href="delcoord.php?del='.$row_listarusuarios['id'].'&finan='.$_GET['finan'].'&indicador='.$_GET['indicador'].'&a=meta_usaurios&b=id&c=metas" data-toggle="tooltip" data-placement="top" title="" onclick="if(!confirm(\''.$alertborrar.'\'))return false"><i class="fa fa-times fa-1" title="Eliminar asignación"></i></a><br>';
} while ($row_listarusuarios = mysqli_fetch_assoc($listarusuarios));
//********************************************************************************************
 ?></td>
      <td align="center"><form method="post" name="formb" action="<?php echo $editFormAction; ?>">
        <?php echo $selus; ?>
        <input type="hidden" name="cc" value="<?php echo $row_listarunameta['cod_meta']; ?>" > 
        <input type="submit" value="+" class="btn btn-sm btn-primary" title="Asignar usuario">
        <input type="hidden" name="MM_insert" value="formb">
        </form>
      </td>
      <!-- <td>
        <?php
        if($row_listarmetas['id_img_meta'])
        {
          echo '<img src="../imagenesayuda/'.$row_listarmetas['id_img_meta'].'" width="75">';
        }
         ?>


      </td>
      <td>
<a href="#" data-toggle="modal" data-target="#optionimg" class="btn btn-block btn-default" onclick="ventana('asignarimgmeta','<?php echo $row_listarmetas['cod_meta']; ?>&finan=<?php echo $_GET['finan']; ?>&indicador=<?php echo $_GET['indicador']; ?>','popimg')">
IMG</a>
      </td> -->
    </tr>
    <?php } while ($row_listarunameta = mysqli_fetch_assoc($listarunameta)); ?>
  </tbody>
</table>

<table border="0">
                    <tr>
          <td><?php if ($pageNum_listarmetas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listarmetas=%d%s", $currentPage, 0, $queryString_listarmetas); ?>">Primero</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listarmetas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_listarmetas=%d%s", $currentPage, max(0, $pageNum_listarmetas - 1), $queryString_listarmetas); ?>">Anterior</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_listarmetas < $totalPages_listarmetas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listarmetas=%d%s", $currentPage, min($totalPages_listarmetas, $pageNum_listarmetas + 1), $queryString_listarmetas); ?>">Siguiente</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_listarmetas < $totalPages_listarmetas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_listarmetas=%d%s", $currentPage, $totalPages_listarmetas, $queryString_listarmetas); ?>">&Uacute;ltimo</a>
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
        <h4 class="modal-title" id="myModalLabel">NUEVO REGISTRO META</h4>
      </div>
      <div class="modal-body">
<form method="post" name="form1" action="<?php echo $editFormAction; ?>" accept-charset="UTF-8">
      <table class="table" style="background-color: #CCCCCC;">

        <tr valign="baseline">
          <td align="right" nowrap></td>
          <td><input type="hidden" name="cod_indicador_meta" value="<?php echo $_GET['indicador']; ?>" ></td>
          </tr>
        <!-- <tr valign="baseline">
          <td align="right" valign="middle" nowrap>GESTION:</td>
          <td><input type="number" name="gestion" value="<?php echo date('Y'); ?>" class="form-control" required></td>
          </tr> -->
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap>DESCRIPCION:</td>
          <td>
            <textarea name="descr_meta" id="descr_meta"  class="form-control" required></textarea></td>
          </tr>
        <!-- <tr valign="baseline">
          <td align="right" valign="middle" nowrap>% PONDERACION:</td>
          <td><input type="text" name="ponderacion" class="form-control" value='100'></td>
        </tr> 
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap>META A CUMPLIR:
		      </td>
          <td><input type="text" name="cumplimiento_meta" class="form-control" required></td>
        </tr> -->
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap>META 2021:
		      </td>
          <td><input type="text" name="meta1" class="form-control" required></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap>META 2022:
		      </td>
          <td><input type="text" name="meta2" class="form-control" required></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap>META 2023:
		      </td>
          <td><input type="text" name="meta3" class="form-control" required></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap>META 2024:
		      </td>
          <td><input type="text" name="meta4" class="form-control" required></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap>META 2025:
		      </td>
          <td><input type="text" name="meta5" class="form-control" required></td>
        </tr>

        <tr valign="baseline">
          <td align="right" valign="middle" nowrap>ASIGNAR A ENTIDAD </td>
          <td><?php echo $selus; ?></td>
        </tr>
        <?php
        $query_acciones_pilar = "SELECT * FROM accion INNER JOIN programa ON accion.cod_programa_ac = programa.cod_programa
        INNER JOIN pilar ON pilar.cod_pilar = programa.cod_pilar_pro;";
        $acciones_pilar = mysqli_query($conexion, $query_acciones_pilar) or die(mysqli_error($conexion));
        $row_acciones_pilar = mysqli_fetch_assoc($acciones_pilar);
        $totalRows_acciones_pilar = mysqli_num_rows($acciones_pilar);

        ?>
        <tr>
          <td align="right" valign="middle" nowrap>ASIGNAR ACCION</td>
          <td>
            <select name="accionesPilar" class="form-control input-sm" required>
              <option>Seleccionar Programa-Acción</option>
              <?php do {
                
                if ($row_acciones_pilar['orden_accion']=='1') {
                  ?>
                  <optgroup label="<?php echo mb_strtoupper(substr($row_acciones_pilar['titulo_pilar'], 0, 60)); ?>"></optgroup>
                  <?php
                }
                ?>
                <option value="<?php echo $row_acciones_pilar['cod_accion']; ?>" title="<?php echo $row_acciones_pilar['descr_accion'];?>"><?php echo mb_substr($row_acciones_pilar['descr_accion'], 0, 50).'...' ?></option>
              <?php } while ($row_acciones_pilar = mysqli_fetch_assoc($acciones_pilar));?>
            </select>

          </td>
        </tr>

        <tr valign="baseline">
          <td align="right" nowrap>&nbsp;</td>
          <td><input type="submit" value="Guardar Registro" class="btn btn-block btn-default"></td>
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
mysqli_free_result($listarusuarios);
mysqli_free_result($listausuario);
mysqli_free_result($listarmetas);
?>