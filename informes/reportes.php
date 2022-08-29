<?php 
require_once('../locklvl.php'); 
$MM_authorizedUsers =usuario(100);
require_once('../lock.php'); 

require_once('../Connections/conexion.php');
?>
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

$inicio = 2021;

for ($i=1; $i < 6; $i++) { 
    $gestiones[$i]=$inicio;
    $inicio++;
}

mysqli_select_db($conexion, $database_conexion);

# metas
$gestion = date("Y");
if (isset($_POST['ges'])) {
    $gestion = $_POST['ges'];
}

$query_metas = sprintf("SELECT *  FROM pilar
                        INNER JOIN programa ON pilar.cod_pilar = programa.cod_pilar_pro
                        INNER JOIN accion ON programa.cod_programa = accion.cod_programa_ac
                        INNER JOIN coordinador ON accion.cod_accion = coordinador.cod_quien_necesita
                        INNER JOIN meta ON coordinador.cod_meta_coord = meta.cod_meta
                        INNER JOIN meta_usaurios ON meta.cod_meta = meta_usaurios.cod_meta_mtus
                        INNER JOIN entidad ON meta_usaurios.meta_login = entidad.sigla 
                        WHERE meta.gestion = %s",
                        GetSQLValueString($gestion, "text"));
$query_metas_groupby = $query_metas." GROUP BY meta.cod_meta;";
$metas = mysqli_query($conexion, $query_metas_groupby) or die(mysqli_error($conexion));
$row_metas = mysqli_fetch_assoc($metas);
$totalRows_metas = mysqli_num_rows($metas);

# exportar a excel
if (isset($_POST['exportar'])) {

}

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

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3><?php echo $titulomenu; ?></h3>
                <?php
				echo $menu;
				?>
              </div>
              <?php
			  echo $configuracion;
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
                <h1><small>MENU / </small>REPORTES</h1>
              </div>
         </div>

         <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>REPORTES</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <table align="center" class="filtros">
                    <tr>
                        <td>
                            GESTION :
                        </td>
                            <td>
                                <form method="post">
                                <select name="ges" onchange="submit();" class="form-control">
                                    <?php foreach($gestiones as $id=>$row){?>
                                        <option value="<?php echo $row;?>" <?php if($gestion==$row){echo 'selected';}?> ><?php echo $row;?></option>
                                    <?php }?>
                                </select>
                                </form>
                            </td>
                            <td>
                                <form id="general" action="exportar.php" target="_blank" method="post">
                                    <input type="hidden" name="gestion" value="<?php echo $gestion;?>">
                                    <button type="submit" name="button" class="btn btn-success">Descargar <icon class="fa fa-file-excel-o"> </button>
                                </form>
                            </td>
                            <td>
                                <!-- <form action="generar_plan_estado.php" target="_blank" method="post">
                                    <input type="hidden" name="ges" value="<?php echo $gestion;?>">
                                    <input type="submit" name="button" value="REPORTE GENERAL ESTADO SITUACION" class="btn btn-success">
                                </form>
                            </td> -->
                            <!--td align="center">
                                <input type="submit" name="enviar" value="REPORTE GENERAL SEMAFORIZACION">
                            </td-->

                        <!--td align="center">
                            <form id="indicadores" action="generar_acciones.php" target="_blank" method="post">
                                <input type="hidden" name="ges" id="gestion_indicadores" value="<?php echo $gestiones['2016'];?>">
                                <input type="submit" name="button" value="REPORTE POR ACTIVIDADES">
                            </form>
                        </td-->
                    </tr>
                  </table>

                  <!-- Reporte -->
                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Componente</th>
                            <th>Programa</th>
                            <th>Acción</th>
                            <th>Indicador</th>
                            <th>Meta</th>
                            <th>Avance</th>
                            <th>% de avance</th>
                            <th>Entidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $j=1;
                        $porcentaje_conteo;
                        do {
                            $pilar_descripcion = $row_metas['titulo_pilar'];
                            $pilar_cod = $row_metas['cod_pilar'];
                            $pilar_id = $row_metas['orden_pilar'];
                            $programa_descripcion = $row_metas['titulo_programa'];
                            $programa_cod =  $row_metas['cod_programa'];
                            $programa_id = $row_metas['orden_programa'];
                            $accion_descripcion = $row_metas['descr_accion'];
                            $meta_descripcion = $row_metas['descr_meta'];
                            $meta_cumplimiento = $row_metas['cumplimiento_meta'];
                            $meta_respuesta = $row_metas['respuesta_real_decumpl'];

                        ?>
                        
                        <tr>
                            <!-- Componente/pilar -->
                            <?php if($row_metas['orden_programa']==1 && $row_metas['orden_accion']==1){
                                # metas por pilar/componente 
                                
                                $query_metas_por_pilar = sprintf("AND pilar.cod_pilar = %s GROUP BY meta.cod_meta",
                                    GetSQLValueString($pilar_cod, "text"));
                                $query_metas_por_pilar = $query_metas.$query_metas_por_pilar;
                                $metas_por_pilar = mysqli_query($conexion, $query_metas_por_pilar) or die(mysqli_error($conexion));
                                //$row_metas_pilar = mysqli_fetch_assoc($metas_por_pilar);
                                $totalRows_metas_pilar = mysqli_num_rows($metas_por_pilar);
                                
                            ?>
                                <td style="vertical-align: middle;" rowspan="<?php echo $totalRows_metas_pilar;?>">
                                <?php echo $pilar_id.'. '.$pilar_descripcion; ?></td>
                            <?php } ?>
                            <?php if($row_metas['orden_accion']==1) {
                                # metas por pilar/componente y por programa
                                $query_metas_pilar_programa = sprintf("AND pilar.cod_pilar = %s AND programa.cod_programa = %s GROUP BY meta.cod_meta",
                                    GetSQLValueString($pilar_cod, "text"),
                                    GetSQLValueString($programa_cod, "text"));
                                $query_metas_pilar_programa = $query_metas.$query_metas_pilar_programa;
                                $metas_pilar_programa = mysqli_query($conexion, $query_metas_pilar_programa) or die(mysqli_error($conexion));
                                //$row_metas_pilar = mysqli_fetch_assoc($metas_por_pilar);
                                $totalRows_metas_pilar_programa = mysqli_num_rows($metas_pilar_programa);
                                ?>
                                <td style="vertical-align: middle;" rowspan="<?php echo $totalRows_metas_pilar_programa;?>">
                                <?php echo $pilar_id.'.'.$programa_id.'. '.$programa_descripcion; ?></td>

                            <?php

                            }
                            ?>
                            
                            <td><?php echo $accion_descripcion; ?></td>
                            <td><?php echo $meta_descripcion; ?></td>
                            <td class="text-right"><?php echo $meta_cumplimiento; ?></td>
                            <td class="text-right"><?php echo $meta_respuesta; ?></td>
                            <?php if ($meta_cumplimiento>0){
                                    if ($meta_respuesta >0) {
                                        $porcentaje = 100*$meta_respuesta/$meta_cumplimiento;
                                    } else {$porcentaje=0;}
                                } else { $porcentaje=100;}
                                ?>
                            <td class="text-right <?php if ($porcentaje<34) {echo "btn-danger";} 
                                             if($porcentaje>33 && $porcentaje<67) {echo "btn-warning";}
                                             if($porcentaje>67 && $porcentaje<101) {echo "btn-success";} ?>">
                                             <?php echo $porcentaje; 
                                             $porcentaje_conteo[$j] = $porcentaje;
                                             $j++;?></td>
                            <?php
                            mysqli_select_db($conexion, $database_conexion);
                            $query_listarusuarios = sprintf("SELECT * FROM meta_usaurios WHERE cod_meta_mtus = %s ORDER BY id ASC", 
                                GetSQLValueString($row_metas['cod_meta'], "text"));
                            $listarusuarios = mysqli_query($conexion, $query_listarusuarios) or die(mysqli_error($conexion));
                            $row_listarusuarios = mysqli_fetch_assoc($listarusuarios);
                            $totalRows_listarusuarios = mysqli_num_rows($listarusuarios);
                            ?> <td>
                                <?php
                            do {

                                    echo $row_listarusuarios['meta_login'].'</br>';

                            } while ($row_listarusuarios = mysqli_fetch_assoc($listarusuarios));
                            ?>
                            </td>
                        </tr>

                        <?php
                        } while ($row_metas = mysqli_fetch_assoc($metas));
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">TOTAL</th>
                            <th class="text-right"><?php $total = array_sum($porcentaje_conteo)/count($porcentaje_conteo);
                             echo round($total, 2);?></th>

                        </tr>
                    </tfoot>
                    

                  </table>
                  

         <?php require_once('../jsadmin2.php'); ?>
</body>
</html>