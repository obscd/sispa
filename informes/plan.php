<?php
require_once('../locklvl.php');
$MM_authorizedUsers =usuario(2);
require_once('../lock.php');
require_once('../Connections/conexion.php');
include ("funciones/funcionesdb.php");

# Ocultar warnings
error_reporting(E_ERROR | E_PARSE);

$gestiones['2016'] = 2016;
$gestiones['2017'] = 2017;
$gestiones['2018'] = 2018;
$idFinanciador = 2;
$gestion = 2016;
#$ges = $_POST['ges'];

if (isset($_POST['ges'])) {
    $gestion = $_POST['ges'];
}
// if ($_POST['ges']) {
//     $gestion = $_POST['ges'];
// }
$sumPilares = array();
$arrayActividades = array();
$actividadesCompletadas = array();
$actividadesProceso = array();
$actividadesSinIniciar = array();
$consulta = '
SELECT
cod_pilar
FROM
pilar
ORDER BY
orden_pilar ASC';
$pilares = fetchAll($consulta, $conexion);
if ($pilares) {
    $porcentajePilar = round(1/count($pilares),3)*100;
    foreach ($pilares as $idp => $pilar) {
        $aux = 0;
        $consulta = '
        SELECT
        cod_programa
        FROM
        programa
        WHERE
        cod_pilar_pro = ' . $pilar['cod_pilar'] . '
        ORDER BY
        orden_programa ASC';
        $programas = fetchAll($consulta, $conexion);
        if ($programas) {
            $porcentajePrograma = (1/count($programas))*100;
            $porcentajeProgramaPilar = ($porcentajePrograma/100)*$porcentajePilar;
            foreach ($programas as $idpr => $programa) {
                $consulta = '
                SELECT
                cod_accion
                FROM
                accion
                WHERE
                cod_programa_ac	= ' . $programa['cod_programa'] . '
                ORDER BY
                orden_accion ASC';
                $acciones = fetchAll($consulta, $conexion);
                if ($acciones) {
                    $porcentajeAccion = (1/count($acciones))*100;
                    $porcentajeAccionPrograma = ($porcentajeAccion/100)*$porcentajeProgramaPilar;
                    foreach ($acciones as $idac => $accion) {
                        $consulta = '
                        SELECT
                        cod_actividad
                        FROM
                        actividad
                        WHERE
                        cod_accion_act	= ' . $accion['cod_accion'] . '
                        ORDER BY
                        orden_actividad ASC';
                        $actividades = fetchAll($consulta, $conexion);
                        if($actividades){
                            $porcentajeActividad = (1/count($actividades))*100;
                            $porcentajeActividadAccion = ($porcentajeActividad/100)*$porcentajeAccionPrograma;
                            foreach($actividades as $numActividad => $actividad){
                                $actividades[$numActividad]['porcentaje'] = round($porcentajeActividadAccion,2);
                                $consulta = '
                                SELECT
                                cumplimiento_meta,
                                respuesta_real_decumpl
                                FROM
                                coordinador LEFT JOIN meta ON(coordinador.cod_meta_coord=meta.cod_meta)
                                WHERE
                                cod_quien_necesita	= ' . $actividad['cod_actividad'] .'
                                AND gestion = '.$gestion;
                                $metas = fetchAll($consulta, $conexion);
                                if($metas){
                                    $porcentajeMetas = round(1/count($metas),3)*100;
                                    $porcentajeMetasActividad = round(($porcentajeMetas/100)*$porcentajeActividadAccion,3);
                                    $cumplimientoMetas = 0;
                                    foreach ($metas as $idm => $meta) {
                                        $porcentajeCumplimientoMeta = round($meta['respuesta_real_decumpl']/$meta['cumplimiento_meta'],3)*100;
                                        $porcentajeCumplimientoActividad = round(($porcentajeCumplimientoMeta/100)*$porcentajeMetasActividad,2);
                                        $cumplimientoMetas += ($porcentajeCumplimientoMeta/100)*$porcentajeMetasActividad;
                                    }
                                    $sumPilares[$idp] += $cumplimientoMetas;
                                    $actividades[$numActividad]['cumplimiento'] = round($cumplimientoMetas,2);
                                    $cumplimientoActividad = round(($cumplimientoMetas/$porcentajeActividadAccion)*100);
                                    $arrayActividades[$idp][$aux] = array(
                                        'label' => ($idp+1).'.'.($idpr+1).'.'.($idac+1).'.'.($numActividad+1),
                                        'value' => $cumplimientoActividad
                                    );
                                    if ($cumplimientoActividad == 0) {
                                        $actividadesSinIniciar[$idp]++;
                                    } elseif ($cumplimientoActividad == 100) {
                                        $actividadesCompletadas[$idp]++;
                                    } else {
                                        $actividadesProceso[$idp]++;
                                    }

                                    $aux++;
                                }
                            }
                        }
                        $acciones[$idac]['actividades'] = $actividades;
                    }
                }
                $programas[$idpr]['acciones'] = $acciones;
            }
            $pilares[$idp]['programas'] = $programas;
        }
    }
}

$romano = array('I','II','III','IV','V','VI','VII','VIII','IX','X');
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title><?php echo $titulo; ?> </title>

    <?php require('../cssadmin.php'); ?>

    <style type="text/css">
        table.filtros {
            border-collapse: collapse;
        }

        table.filtros td, table.filtros th {
            padding: 5px;
            text-align: center;
        }
        table.filtros th{
            color: black;
        }

        table.filtros1 {
            border-collapse: collapse;
            font-size: 13px;
            color: #73879c;
        }

        table.filtros1 td, table.filtros1 th {
            padding: 5px;
            text-align: center;
        }

    </style>


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

                        <h3>General</h3>

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



            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>REPORTE PLAN DE ACCION OPERATIVO</h2>
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
                                            <select name="ges" onchange="submit();">
                                                <?php foreach($gestiones as $id=>$row){?>
                                                    <option value="<?php echo $id;?>" <?php if($gestion==$id){echo 'selected';}?> ><?php echo $row;?></option>
                                                <?php }?>
                                            </select>
                                            </form>
                                        </td>
                                        <td align="center">
                                            <form id="general" action="generar_plan.php" target="_blank" method="post">
                                                <input type="hidden" name="gestion" value="<?php echo $gestion;?>">
                                                <input type="submit" name="button" value="REPORTE GENERAL">
                                            </form>
                                        </td>
                                        <td align="center">
                                            <form action="generar_plan_estado.php" target="_blank" method="post">
                                                <input type="hidden" name="ges" value="<?php echo $gestion;?>">
                                                <input type="submit" name="button" value="REPORTE GENERAL ESTADO SITUACION">
                                            </form>
                                        </td>
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
                            <br>
                            <div align="right">
                                <button onclick="window.open('imprimir_plan.php?gestion='+'<?php echo $gestion;?>', '_blank', 'location=yes,height=570,width=920,scrollbars=yes,status=yes,top=10,left=10');">Imprimir</button>
                            </div>
                            <div align="center">
                                <div id="chart-container">Cargando Grafica</div>
                                <br>
                                <div align="center"><strong>% TOTAL DE AVANCE DEL PLAN DE ACCION OPERATIVO : <?php echo round(array_sum($sumPilares),2);?>%</strong></div>
                                <?php if($pilares){?>
                                    <?php foreach($pilares as $idp=>$pilar){?>
                                        <br>
                                        <div id="<?php echo 'chart-container'.($idp);?>">Cargando Grafica</div>
                                        <table align="center" class="filtros1">
                                            <tr>
                                                <td><strong><i class="fa fa-user"></i> TOTAL ACTIVIDADES = <?php echo count($arrayActividades[$idp]);?></strong></td>
                                                <td><strong><i class="fa fa-clock-o"></i> ACTIVIDADES COMPLETADAS = <?php if($actividadesCompletadas[$idp]){echo $actividadesCompletadas[$idp];}else{echo 0;}?></strong></td>
                                                <td><strong><i class="fa fa-spinner"></i> ACTIVIDADES EN PROCESO = <?php if($actividadesProceso[$idp]){echo $actividadesProceso[$idp];}else{echo 0;}?></strong></td>
                                                <td><strong><i class="fa fa-close"></i> ACTIVIDADES SIN INICIAR = <?php if($actividadesSinIniciar[$idp]){echo $actividadesSinIniciar[$idp];}else{echo 0;}?></strong></td>
                                            </tr>
                                            <tr>
                                                <td><img src="../images/tmetas.jpg" alt=""></td>
                                                <td><img src="../images/cumplida.jpg" alt=""></td>
                                                <td><img src="../images/total.jpg" alt=""></td>
                                                <td><img src="../images/metasi.jpg" alt=""></td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="green">100% </i> ACTIVIDADES</strong></td>
                                                <td><strong><i class="green"><i class="fa fa-sort-asc"></i><?php echo round($actividadesCompletadas[$idp]/count($arrayActividades[$idp]),3) * 100;?> % </i> DE LAS ACTIVIDADES</strong></td>
                                                <td><strong><i class="green"><i class="fa fa-sort-asc"></i><?php echo round($actividadesProceso[$idp]/count($arrayActividades[$idp]),3) * 100;?> % </i> DE LAS ACTIVIDADES</strong></td>
                                                <td><strong><i class="red"><i class="fa fa-sort-desc"></i><?php echo round($actividadesSinIniciar[$idp]/count($arrayActividades[$idp]),3) * 100;?> % </i> DE LAS ACTIVIDADES</strong></td>
                                            </tr>
                                        </table>
                                    <?php }?>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php echo $footer; ?>

        <!-- /footer content -->

    </div>

    <?php require('../jsadmin2.php'); ?>
    <script type="text/javascript" src="libreria/column/fusioncharts.js"></script>
    <script type="text/javascript">
        FusionCharts.ready(function(){
            var fusioncharts = new FusionCharts({
                    type: 'mscolumn3d',                    
                    renderAt: 'chart-container',
                    width: '900',
                    height: '450',
                    dataFormat: 'json',
                    dataSource: {
                        "chart": {
                            "caption": "PLAN DE ACCION OPERATIVO",
                            "xAxisname": "Pilares",
                            "yAxisName": "% Pilar",
                            "theme": "fint",
                            "yAxisMaxValue": "20"
                        },
                        "categories": [{
                            "category": [
                                <?php
                                foreach($pilares as $num=>$pilar){
                                    if(($num+1)==count($pilares)){
                                        echo '{ "label": "'.$romano[$num].'" }';
                                    }else{
                                        echo '{ "label": "'.$romano[$num].'" },';
                                    }
                                }
                                ?>
                            ]
                        }],
                        "dataset": [{
                            "color":"#49759c",
                            "seriesname": "% Pilar",
                            "data": [
                                <?php
                                foreach($pilares as $num=>$pilar){
                                    if(($num+1)==count($pilares)){
                                        echo '{ "value": "'.$porcentajePilar.'" }';
                                    }else{
                                        echo '{ "value": "'.$porcentajePilar.'" },';
                                    }
                                }
                                ?>
                            ]
                        }, {
                            "color":"#a4bfda",
                            "seriesname": "% Cumplimiento",
                            "data": [
                                <?php
                                foreach($sumPilares as $num=>$sumPilar){
                                    if(($num+1)==count($sumPilares)){
                                        echo '{ "value": "'.round($sumPilar,2).'" }';
                                    }else{
                                        echo '{ "value": "'.round($sumPilar,2).'" },';
                                    }
                                }
                                ?>
                            ]
                        }]
                    }
                }
            );
            fusioncharts.render();
            <?php if($pilares){?>
                <?php foreach($pilares as $idp=>$pilar){?>
            var fusioncharts1 = new FusionCharts({
                    type: 'mscolumn3d',
                    renderAt: '<?php echo 'chart-container'.($idp);?>',
                    width: '900',
                    height: '450',
                    dataFormat: 'json',
                    dataSource: {
                        "chart": {
                            "caption": "<?php echo 'PORCENTAJE DE AVANCE DE LAS ACTIVIDADES DEL PILAR '.$romano[$idp];?>",
                            "xAxisname": "Actividades",
                            "yAxisName": " ",
                            "theme": "fint",
                            "yAxisMaxValue": "100"
                        },
                        "categories": [{
                            "category": [
                                <?php
                                foreach($arrayActividades[$idp] as $num=>$actividad){
                                    if(($num+1)==count($arrayActividades[$idp])){
                                        echo '{ "label": "'.$actividad['label'].'" }';
                                    }else{
                                        echo '{ "label": "'.$actividad['label'].'" },';
                                    }
                                }
                                ?>
                            ]
                        }],
                        "dataset": [{
                            "color":"#49759c",
                            "seriesname": "% Actividad",
                            "data": [
                                <?php
                                foreach($arrayActividades[$idp] as $num=>$actividad){
                                    if(($num+1)==count($arrayActividades[$idp])){
                                        echo '{ "value": "'.$actividad['value'].'" }';
                                    }else{
                                        echo '{ "value": "'.$actividad['value'].'" },';
                                    }
                                }
                                ?>
                            ]
                        }]
                    }
                }
            );
            fusioncharts1.render();
                <?php }?>
            <?php }?>
        });
        function cambioGestion(sel){
            document.getElementById("gestion_indicadores").value = sel.value;
        }
    </script>

</div>
<?php require('../jsadmin2.php'); ?>

</body>

</html>