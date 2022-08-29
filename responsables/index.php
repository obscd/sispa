<?php
require_once('../locklvl.php');
$MM_authorizedUsers =usuario(3);
require_once('../lock.php');
?>
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

$colname_tareas = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_tareas = $_SESSION['MM_Username'];
}
$gestione = date('Y');
if (isset($_GET['gestion'])) {
  $gestione = $_GET['gestion'];
}
$query_entidad = sprintf("SELECT * FROM entidad, login WHERE entidad.id = login.id_entidad AND usuario_login = %s",
                          GetSQLValueString($colname_tareas, "text"));
$entidad = mysqli_query($conexion, $query_entidad) or die(mysqli_error($conexion));
$row_entidad = mysqli_fetch_assoc($entidad);
$totalRows_entidad = mysqli_num_rows($entidad);

$usuario_entidad = $row_entidad['sigla'];

mysqli_select_db($conexion, $database_conexion);
//$query_tareas = sprintf("SELECT * FROM  meta_usaurios INNER JOIN meta ON meta_usaurios.cod_meta_mtus=meta.cod_meta WHERE meta_usaurios.meta_login = %s AND meta.gestion =%s GROUP BY meta_usaurios.cod_meta_mtus ORDER BY meta_usaurios.id DESC", GetSQLValueString($colname_tareas, "text"), GetSQLValueString($_GET['gestione'], "text"));
$query_tareas = sprintf("SELECT * FROM ((indicador INNER JOIN meta ON indicador.cod_indicador=meta.cod_indicador_meta) INNER JOIN meta_usaurios ON meta.cod_meta=meta_usaurios.cod_meta_mtus) 
                        WHERE meta_usaurios.meta_login = %s AND meta.gestion =%s GROUP BY meta_usaurios.cod_meta_mtus 
                        ORDER BY meta_usaurios.id DESC", 
                        GetSQLValueString($usuario_entidad, "text"), 
                        GetSQLValueString($gestione, "text"));
$tareas = mysqli_query($conexion, $query_tareas) or die(mysqli_error($conexion));
$row_tareas = mysqli_fetch_assoc($tareas);
$totalRows_tareas = mysqli_num_rows($tareas);

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
                <h1><small>MENU / </small>TAREAS</h1>
              </div>
         </div>


          <div class="row">

<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>METAS</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
<form method="get" class="form-horizontal form-label-left input_mask">
  <table class="table">
    <tr>
      <td class="text-right"><select name="gestion" id="gestion" class="form-control">
            <option value="2021" <?php if($gestione==2021) echo 'selected="selected"'; ?>>2021</option>
            <option value="2022" <?php if($gestione==2022) echo 'selected="selected"'; ?>>2022</option>
            <option value="2023"<?php if($gestione==2023) echo 'selected="selected"'; ?>>2023</option>
            <option value="2024"<?php if($gestione==2024) echo 'selected="selected"'; ?>>2024</option>
            <option value="2025"<?php if($gestione==2025) echo 'selected="selected"'; ?>>2025</option>
          </select>
        </td>
      <td><input type="submit" name="button" id="button" value="BUSCAR" class="btn btn-primary"></td>
    </tr>
  </table>


</form>
</p>
<table  class="table table-bordered" cellspacing="0" id="tablar" >

  <tr>
    <th width="5%" height="35" valign="middle">Nº</th>
    <th valign="middle">INDICADOR</th>
    <th valign="middle">DESCRIPCION META</th>
    <th width="5%" valign="middle">META A CUMPLIR</th>
    <th width="10%" valign="middle">CUMPLIMIENTO</th>
    <th width="40%" valign="middle"></th>
    <th width="5%" valign="middle">DOCUMENTOS RESPALDOS 
    <a class="btn btn-succes" data-toggle="modal" data-target="#buscard" onclick="ventana('search','','busquedad')">
      <i class="fa fa-search fa-2x" style="color: white;"></i>
    </a>
    </th>
  </tr>

  <?php
  $cfilas=$totalRows_tareas+1;
  do {
  $cfilas --;
  if ($totalRows_tareas){
    if(($row_tareas['respuesta_real_decumpl'] == 0) && $row_tareas['cumplimiento_meta']==0) {
      $resultado2=0;
    } else {
      $resultado2=($row_tareas['respuesta_real_decumpl']*100)/$row_tareas['cumplimiento_meta'];// %avance de la meta al 100%
    }
  }
  ?>
    <tr>
      <td><?php echo $cfilas; ?></td>
      <td><?php echo $row_tareas['descr_indicador']; ?></td>
      <td><?php echo $row_tareas['descr_meta']; ?></td>
      <td>
	  
	  <?php echo $row_tareas['cumplimiento_meta']; ?></td>
      <td <?php echo semaforo($resultado2);?>>
        <?php echo $row_tareas['respuesta_real_decumpl']; ?></td>
      <td>
  <form method="post" name="form1" action="CALCULO.php">
    <table class="table">
      <tr>
        <td width="70%" bgcolor="#DFDFDF">ESTADO DE SITUACION</td>
        <td bgcolor="#DFDFDF">ESTADO DE CUMPLIMIENTO</td>
        </tr>
      <tr>
        <td rowspan="2" bgcolor="#DFDFDF"><textarea name="situacion" rows="3" class="form-control" placeholder="Describa aqu&iacute; el estado de situaci&oacute;n?"><?php echo htmlentities($row_tareas['meta_estd_sit'], ENT_COMPAT, 'utf-8'); ?></textarea>
        </td>
        <td bgcolor="#DFDFDF"><input type="text" name="respuesta_real_decumpl" value="<?php echo htmlentities($row_tareas['respuesta_real_decumpl'], ENT_COMPAT, 'utf-8'); ?>"  class="form-control" autocomplete="off"></td>
        </tr>
      <tr>
        <td bgcolor="#DFDFDF"><input type="submit" value="Guardar Cambios" class="btn btn-block btn-default"></td>
        </tr>
      </table>
  <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="cod_meta" value="<?php echo $row_tareas['cod_meta']; ?>">
    <input type="hidden" name="fl" value="responsables">
    <input type="hidden" name="ph" value="index">
  </form>
      </td>
      <td>

<br>

 
<a class="btn btn-succes" data-toggle="modal" data-target="#buscar" onclick="ventana('carpetas','<?php echo $row_tareas['cod_meta']; ?>','busqueda')">
<img src="../images/respaldo.png" width="52" height="45px">
</a>

      </td>
    </tr>
    <?php } while ($row_tareas = mysqli_fetch_assoc($tareas)); ?>
    
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


<div class="modal fade bs-example-modal-lg" id="buscar" tabindex="-1" role="dialog" aria-labelledby="search" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="search">DOCUMENTACION DE RESPALDO</h4>
      </div>
      <div class="modal-body" id="busqueda">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $close; ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" id="buscard" tabindex="-1" role="dialog" aria-labelledby="search" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="search">BUSCAR DOCUMENTOS POR TITULO EN TODAS LAS METAS:</h4>
      </div>

	    <input type="text" name="de" id="de" onkeyup="ventana('search',this.value,'busquedad')" class="form-control" placeholder="BUSCAR DOCUMENTO"/>
        
      <div class="modal-body" id="busquedad">
        <!-- Realizado por: athoted@hotmail.com -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $close; ?></button>
      </div>
    </div>
  </div>
</div>


<?php require_once('../jsadmin2.php'); ?>

  </body>
</html>
<?php
mysqli_free_result($tareas);
?>