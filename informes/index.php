<?php

require_once('../locklvl.php');
$MM_authorizedUsers = usuario(2);
require_once('../lock.php');
require_once('../Connections/conexion.php');
include("funciones/funcionesdb.php");

# Ocultar warnings
error_reporting(E_ERROR | E_PARSE);

$gestiones['2016'] = 2016;
$gestiones['2017'] = 2017;
$gestiones['2018'] = 2018;

$idFinanciador = 1;
$gestion = 2016;

if ($_POST['ge']) {
    $gestion = $_POST['ge'];
}

$aux = 0;
$sumTotalAPS = 0;
$metasCompletadas = 0;
$metasProceso = 0;
$metasSinIniciar = 0;
$arrayMetas = array();
$consulta = '
SELECT
cod_finnanciador
FROM
financiador
WHERE
id_financiador = ' . $idFinanciador;

$financiador = fetchRow($consulta, $conexion);

if ($financiador) {

    $consulta = '
    SELECT
    cod_indicador,
    pond_2016,
    pond_2017,
    pond_2018
    FROM
    indicador
    WHERE
    cod_financiador_ind = "' . $financiador['cod_finnanciador'] . '"';

    $indicadores = fetchAll($consulta, $conexion);

    foreach ($indicadores as $num => $indicador) {

        if ('pond_2016' == 'pond_' . $gestion)

            $porcentaje = $indicador['pond_2016'];

        elseif ('pond_2017' == 'pond_' . $gestion)

            $porcentaje = $indicador['pond_2017'];

        elseif ('pond_2018' == 'pond_' . $gestion)

            $porcentaje = $indicador['pond_2018'];

        $consulta = '
        SELECT
        *
        FROM
        meta
        WHERE
        gestion = ' . $gestion . ' AND cod_indicador_meta = "' . $indicador['cod_indicador'] . '"';

        $metas = fetchAll($consulta, $conexion);

        if ($metas) {

            foreach ($metas as $numMeta => $meta) {
                $cumplimientoIndicador = round($porcentaje * ($meta['ponderacion'] / 100), 3);
                $cumplimientoPorcentaje = round(($meta['respuesta_real_decumpl'] * 100) / $meta['cumplimiento_meta'], 2);
                $indicadores[$num]['porcentajeCumplimiento'] += round(($cumplimientoIndicador * $cumplimientoPorcentaje) / 100, 2);
                $sumTotalAPS += round(($cumplimientoIndicador * $cumplimientoPorcentaje) / 100, 2);
                $arrayMetas[$aux] = array(

                    'label' => ($num + 1) . '.' . ($numMeta + 1),

                    'value' => round(($meta['respuesta_real_decumpl'] * 100) / $meta['cumplimiento_meta'])

                );

                if ($cumplimientoPorcentaje == 0) {

                    $metasSinIniciar++;
                } elseif ($cumplimientoPorcentaje == 100) {

                    $metasCompletadas++;
                } else {

                    $metasProceso++;
                }

                $aux++;
            }
        }

        $indicadores[$num]['porcentaje'] = $porcentaje;
    }
}

$romano = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X');

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



        table.filtros td,
        table.filtros th {

            padding: 5px;

            text-align: center;

        }

        table.filtros th {

            color: black;

        }

        table.filtros1 {

            border-collapse: collapse;

            font-size: 13px;

            color: #73879c;

        }



        table.filtros1 td,
        table.filtros1 th {

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
                            echo $menu; //**********************************************************menu
                            ?>
                        </div>
                        <?php
                        echo $configuracion; //***********************************************configuracion
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
                                <h2>REPORTE INDICADORES APS</h2>

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

                                                <select name="ge" onchange="submit();">

                                                    <?php foreach ($gestiones as $id => $row) { ?>

                                                        <option value="<?php echo $id; ?>" <?php if ($gestion == $id) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php echo $row; ?></option>

                                                    <?php } ?>

                                                </select>

                                            </form>

                                        </td>

                                        <td align="center">

                                            <form id="general" action="generar.php" target="_blank" method="post">

                                                <input type="hidden" name="gestion" value="<?php echo $gestion; ?>">

                                                <input type="submit" name="button" value="REPORTE GENERAL">

                                            </form>

                                        </td>

                                        <td align="center">

                                            <form id="indicadores" action="generar_indicadores.php" target="_blank" method="post">

                                                <input type="hidden" name="ges" value="<?php echo $gestion; ?>">

                                                <input type="submit" name="button" value="REPORTE POR INDICADOR">

                                            </form>

                                        </td>

                                        <td align="center">

                                            <form id="indicadores1" action="generar1.php" target="_blank" method="post">

                                                <input type="hidden" name="ges1" value="<?php echo $gestion; ?>">

                                                <input type="submit" name="button" value="NUEVO REPORTE POR INDICADOR">

                                            </form>

                                        </td>

                                    </tr>

                                </table>

                                <br>

                                <div align="right">

                                    <button onclick="window.open('imprimir_aps.php?gestion='+'<?php echo $gestion; ?>', '_blank', 'location=yes,height=570,width=920,scrollbars=yes,status=yes,top=10,left=10');">Imprimir</button>

                                </div>

                                <div align="center">

                                    <div id="chart-container">Cargando Grafica</div>

                                    <br>

                                    <div align="center"><strong>% TOTAL AVANCE DEL APS : <?php echo $sumTotalAPS; ?>%</strong></div>

                                    <br>

                                    <div id="chart-container1">Cargando Grafica</div>

                                </div>

                                <table align="center" class="filtros1">

                                    <tr>

                                        <td><strong><i class="fa fa-user"></i> TOTAL METAS = <?php echo count($arrayMetas); ?></strong></td>

                                        <td><strong><i class="fa fa-clock-o"></i> METAS COMPLETADAS = <?php echo $metasCompletadas; ?></strong></td>

                                        <td><strong><i class="fa fa-spinner"></i> METAS EN PROCESO = <?php echo $metasProceso; ?></strong></td>

                                        <td><strong><i class="fa fa-close"></i> METAS SIN INICIAR = <?php echo $metasSinIniciar; ?></strong></td>

                                    </tr>

                                    <tr>

                                        <td><img src="../images/tmetas.jpg" alt=""></td>

                                        <td><img src="../images/cumplida.jpg" alt=""></td>

                                        <td><img src="../images/total.jpg" alt=""></td>

                                        <td><img src="../images/metasi.jpg" alt=""></td>

                                    </tr>

                                    <tr>

                                        <td><strong><i class="green">100% </i> METAS</strong></td>

                                        <td><strong><i class="green"><i class="fa fa-sort-asc"></i><?php echo round($metasCompletadas / count($arrayMetas), 3) * 100; ?> % </i> DE LAS METAS</strong></td>

                                        <td><strong><i class="green"><i class="fa fa-sort-asc"></i><?php echo round($metasProceso / count($arrayMetas), 3) * 100; ?> % </i> DE LAS METAS</strong></td>

                                        <td><strong><i class="red"><i class="fa fa-sort-desc"></i><?php echo round($metasSinIniciar / count($arrayMetas), 3) * 100; ?> % </i> DE LAS METAS</strong></td>

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



        <?php require('../jsadmin2.php'); ?>

        <script type="text/javascript" src="libreria/column/fusioncharts.js"></script>

        <script type="text/javascript">
            FusionCharts.ready(function() {

                var fusioncharts = new FusionCharts({

                        type: 'mscolumn3d',

                        renderAt: 'chart-container',

                        width: '900',

                        height: '450',

                        dataFormat: 'json',

                        dataSource: {

                            "chart": {

                                "caption": "INDICADORES APS",

                                "xAxisname": "Indicadores",

                                "yAxisName": "% Indicador",

                                "theme": "fint"

                            },

                            "categories": [{

                                "category": [

                                    <?php

                                    foreach ($indicadores as $num => $indicador) {

                                        if (($num + 1) == count($indicadores)) {

                                            echo '{ "label": "' . $romano[$num] . '" }';
                                        } else {

                                            echo '{ "label": "' . $romano[$num] . '" },';
                                        }
                                    }

                                    ?>

                                ]

                            }],

                            "dataset": [{

                                "color": "#49759c",

                                "seriesname": "% Indicador",

                                "data": [

                                    <?php

                                    foreach ($indicadores as $num => $indicador) {

                                        if (($num + 1) == count($indicadores)) {

                                            echo '{ "value": "' . $indicador['porcentaje'] . '" }';
                                        } else {

                                            echo '{ "value": "' . $indicador['porcentaje'] . '" },';
                                        }
                                    }

                                    ?>

                                ]

                            }, {

                                "color": "#a4bfda",

                                "seriesname": "% Cumplimiento",

                                "data": [

                                    <?php

                                    foreach ($indicadores as $num => $indicador) {

                                        if (($num + 1) == count($indicadores)) {

                                            echo '{ "value": "' . $indicador['porcentajeCumplimiento'] . '" }';
                                        } else {

                                            echo '{ "value": "' . $indicador['porcentajeCumplimiento'] . '" },';
                                        }
                                    }

                                    ?>

                                ]

                            }]

                        }

                    }

                );

                fusioncharts.render();

                var fusioncharts1 = new FusionCharts({

                        type: 'mscolumn3d',

                        renderAt: 'chart-container1',

                        width: '900',

                        height: '450',

                        dataFormat: 'json',

                        dataSource: {

                            "chart": {

                                "caption": "PORCENTAJE DE AVANCE METAS",

                                "xAxisname": "Metas",

                                "yAxisName": " ",

                                "theme": "fint",

                                "yAxisMaxValue": "100"

                            },

                            "categories": [{

                                "category": [

                                    <?php

                                    foreach ($arrayMetas as $num => $meta) {

                                        if (($num + 1) == count($arrayMetas)) {

                                            echo '{ "label": "' . $meta['label'] . '" }';
                                        } else {

                                            echo '{ "label": "' . $meta['label'] . '" },';
                                        }
                                    }

                                    ?>

                                ]

                            }],

                            "dataset": [{

                                "color": "#49759c",

                                "seriesname": "% Meta",

                                "data": [

                                    <?php

                                    foreach ($arrayMetas as $num => $meta) {

                                        if (($num + 1) == count($arrayMetas)) {

                                            echo '{ "value": "' . $meta['value'] . '" }';
                                        } else {

                                            echo '{ "value": "' . $meta['value'] . '" },';
                                        }
                                    }

                                    ?>

                                ]

                            }]

                        }

                    }

                );

                fusioncharts1.render();

            });

            function cambioGestion(sel) {

                document.getElementById("gestion_indicadores").value = sel.value;

            }
        </script>



    </div>



</body>



</html>