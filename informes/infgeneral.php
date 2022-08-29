<?php
require_once('../Connections/conexion.php');
include ("../funcionesdb.php");
require_once 'libreria/excel/PHPExcel.php';

# Ocultar warnings
error_reporting(E_ERROR | E_PARSE);

$gestiones['2016'] = 2016;
$gestiones['2017'] = 2017;
$gestiones['2018'] = 2018;
$selectPilar[0] = 'Todos los Pilares';
$selectPrograma[0] = 'Todos los Programas';
$selectAccion[0] = 'Todas las Acciones';
$selectActividad[0] = 'Todas las Actividades';

$colname_reportea = 2016;
if (isset($_POST['gestion'])) {
    $colname_reportea = $_POST['gestion'];
}
$pil = '';
$wherePilar = '';
if (isset($_POST['pil'])) {
if ($_POST['pil']!=0) {
    $pil = $_POST['pil'];
    $wherePilar = ' WHERE cod_pilar = "'.$pil.'"';
    $pro = '';
    $wherePrograma = '';
    if ($_POST['pro']!=0) {
        $pro = $_POST['pro'];
        $wherePrograma = ' AND cod_programa = "'.$pro.'" ';
        $acc = '';
        $whereAccion = '';
        if ($_POST['acc']!=0) {
            $acc = $_POST['acc'];
            $whereAccion = ' AND cod_accion = "'.$acc.'" ';
            $act = '';
            $whereActividad='';
            if ($_POST['act']!=0) {
                $act = $_POST['act'];
                $whereActividad = ' AND cod_actividad = "'.$act.'" ';
            }
        }
    }
}
}


$consulta = '
SELECT
cod_pilar,
titulo_pilar
FROM
pilar
ORDER BY
orden_pilar ASC';
$pilares = fetchAll($consulta, $conexion);

if($pilares){
    foreach($pilares as $num=>$row){
        $selectPilar[$row['cod_pilar']]=cortarCadena(($num+1).'. '.$row['titulo_pilar'],30);
        if($row['cod_pilar']==$pil)
            $numeroPilar = $num;
    }
    $porcentajePilar = round(1/count($pilares),3)*100;

}
if($pil){
    $consulta = '
    SELECT
    cod_programa,
    titulo_programa
    FROM
    programa
    WHERE
    cod_pilar_pro = ' . $pil . '
    ORDER BY
    orden_programa ASC';
    $programas = fetchAll($consulta, $conexion);
    $porcentajeProgramaSubmit = round(1/count($programas),3)*100;
    foreach($programas as $num=>$row){
        $selectPrograma[$row['cod_programa']]=cortarCadena(($num+1).'. '.$row['titulo_programa'],30);
        if($row['cod_programa']==$pro)
            $numeroPrograma = $num;
    }

    if($pro){
        $consulta = '
        SELECT
        cod_accion,
        descr_accion
        FROM
        accion
        WHERE
        cod_programa_ac	= ' . $pro . '
        ORDER BY
        orden_accion ASC';
        $acciones = fetchAll($consulta, $conexion);
        $porcentajeAccionSubmit = round(1/count($acciones),3)*100;
        foreach($acciones as $num=>$row){
            $selectAccion[$row['cod_accion']]=cortarCadena(($num+1).'. '.$row['descr_accion'],30);
            if($row['cod_accion']==$acc)
                $numeroAccion = $num;
        }

        if($acc){
            $consulta = '
            SELECT
            cod_actividad,
            descr_actividad
            FROM
            actividad
            WHERE
            cod_accion_act	= ' . $acc . '
            ORDER BY
            orden_actividad ASC';
            $actividades = fetchAll($consulta, $conexion);
            $porcentajeActividadSubmit = round(1/count($actividades),3)*100;
            foreach($actividades as $num=>$row){
                $selectActividad[$row['cod_actividad']]=cortarCadena(($num+1).'. '.$row['descr_actividad'],50);
                if($row['cod_actividad'] == $act)
                    $numeroActividad = $num;
            }
        }
    }
}

function cortarCadena($texto,$num){
    if(strlen($texto)<=$num)
        return $texto;
    else
        return substr($texto,0,$num).'...';
}


function semaforizacion($porcentaje=0){
    if($porcentaje>=0 && $porcentaje<50)
        return "rojo";
    elseif($porcentaje>49 && $porcentaje<80)
        return "amarillo";
    elseif($porcentaje>79 && $porcentaje<=100)
        return "verde";
    else
        return "rojo";
}
$sumPilares = array();
$cabeceras = array('PILAR', 'PROGRAMA', 'ACCION', 'ACTIVIDAD', '% PLAN ACCION', '% CUMPLIMIENTO PLAN ACCION', 'META', 'META A CUMPLIR', '% CUMPLIMIENTO META','% CUMPLIMIENTO ACTIVIDAD','ESTADO SITUACION','RESPONSABLE');
$campos = array('titulo_pilar', 'titulo_programa', 'descr_accion', 'descr_actividad', 'porcentaje', 'cumplimiento', 'descr_meta', 'cumplimiento_meta', 'porcentajeCumplimiento', 'porcentajeCumplimientoMeta','meta_estd_sit','meta_login');
$consulta = '
SELECT
cod_pilar,
titulo_pilar
FROM
pilar
'.$wherePilar.'
ORDER BY
orden_pilar ASC';
$pilares = fetchAll($consulta, $conexion);
if ($pilares) {
    #print_r ($pilares);
    foreach ($pilares as $idp => $pilar) {
        $numPilar = 0;
        $consulta = '
        SELECT
        cod_programa,
        titulo_programa
        FROM
        programa
        WHERE
        cod_pilar_pro = ' . $pilar['cod_pilar'] . $wherePrograma . '
        ORDER BY
        orden_programa ASC';
        $programas = fetchAll($consulta, $conexion);        
        if ($programas) {
            if($porcentajeProgramaSubmit)
                $porcentajePrograma = $porcentajeProgramaSubmit;
            else
                $porcentajePrograma = (1/count($programas))*100;
            $porcentajeProgramaPilar = ($porcentajePrograma/100)*$porcentajePilar;
            foreach ($programas as $idpr => $programa) {
                $numPrograma = 0;
                $consulta = '
                SELECT
                cod_accion,
                descr_accion
                FROM
                accion
                WHERE
                cod_programa_ac	= ' . $programa['cod_programa'] . $whereAccion . '
                ORDER BY
                orden_accion ASC';
                $acciones = fetchAll($consulta, $conexion);                
                if ($acciones) {
                    if($porcentajeAccionSubmit)
                        $porcentajeAccion = $porcentajeAccionSubmit;
                    else
                        $porcentajeAccion = (1/count($acciones))*100;
                    $porcentajeAccionPrograma = ($porcentajeAccion/100)*$porcentajeProgramaPilar;
                    foreach ($acciones as $idac => $accion) {
                        $numAccion = 0;
                        $consulta = '
                        SELECT
                        cod_actividad,
                        descr_actividad
                        FROM
                        actividad
                        WHERE
                        cod_accion_act	= ' . $accion['cod_accion'] . $whereActividad . '
                        ORDER BY
                        orden_actividad ASC';
                        $actividades = fetchAll($consulta, $conexion);                        
                        if($actividades){
                            if($porcentajeActividadSubmit)
                                $porcentajeActividad = $porcentajeActividadSubmit;
                            else
                                $porcentajeActividad = (1/count($actividades))*100;
                            $porcentajeActividadAccion = ($porcentajeActividad/100)*$porcentajeAccionPrograma;
                            foreach($actividades as $numActividad => $actividad){
                                $actividades[$numActividad]['porcentaje'] = round($porcentajeActividadAccion,2);
                                $consulta = '
                                SELECT
                                cod_meta,
                                descr_meta,
                                meta_estd_sit,
                                cumplimiento_meta,
                                respuesta_real_decumpl,
                                meta_login
                                FROM
                                coordinador LEFT JOIN meta ON(coordinador.cod_meta_coord=meta.cod_meta)
                                LEFT JOIN meta_usaurios ON (meta.cod_meta=meta_usaurios.cod_meta_mtus)
                                WHERE
                                cod_quien_necesita	= ' . $actividad['cod_actividad'] .'
                                AND gestion = '.$colname_reportea;
                                $metas = fetchAll($consulta, $conexion);
                                if($metas){
                                    $porcentajeMetas = round(1/count($metas),3)*100;
                                    $porcentajeMetasActividad = round(($porcentajeMetas/100)*$porcentajeActividadAccion,3);
                                    $cumplimientoMetas = 0;
                                    foreach ($metas as $idm => $meta) {
                                        $porcentajeCumplimientoMeta = round($meta['respuesta_real_decumpl']/$meta['cumplimiento_meta'],3)*100;
                                        $porcentajeCumplimientoActividad = round(($porcentajeCumplimientoMeta/100)*$porcentajeMetasActividad,2);
                                        $cumplimientoMetas += ($porcentajeCumplimientoMeta/100)*$porcentajeMetasActividad;
                                        $metas[$idm]['porcentajeCumplimiento'] = $porcentajeCumplimientoMeta;
                                        $metas[$idm]['porcentajeCumplimientoMeta'] = $porcentajeCumplimientoActividad;
                                        $metas[$idm]['semaforizacion'] = semaforizacion($porcentajeCumplimientoMeta);
                                    }
                                    $numPilar += count($metas);
                                    $numPrograma += count($metas);
                                    $numAccion += count($metas);
                                    $sumPilares[$idp] += $cumplimientoMetas;
                                    $actividades[$numActividad]['nRows'] = count($metas);
                                    $actividades[$numActividad]['cumplimiento'] = round($cumplimientoMetas,2);
                                    $actividades[$numActividad]['semaforizacion'] = semaforizacion(($cumplimientoMetas*100)/$porcentajeActividadAccion);
                                    $actividades[$numActividad]['metas'] = $metas;
                                }else{
                                    $numPilar += 1;
                                    $numPrograma += 1;
                                    $numAccion += 1;
                                    $actividades[$numActividad]['nRows'] = 1;
                                    $actividades[$numActividad]['cumplimiento'] = 0;
                                    $actividades[$numActividad]['semaforizacion'] = '';
                                    $actividades[$numActividad]['metas'] = '';
                                }
                            }
                        }
                        $acciones[$idac]['porcentaje'] = $porcentajeAccionPrograma;
                        $acciones[$idac]['nRows'] = $numAccion;
                        $acciones[$idac]['actividades'] = $actividades;                                                         
                    }
                }
                $programas[$idpr]['porcentaje'] = $porcentajeProgramaPilar;
                $programas[$idpr]['nRows'] = $numPrograma;
                $programas[$idpr]['acciones'] = $acciones;                                
            }
            $pilares[$idp]['porcentaje'] = $porcentajePilar;
            $pilares[$idp]['nRows'] = $numPilar;
            $pilares[$idp]['programas'] = $programas;                        
        }
    }
}



/* Exportar Excel */
if (isset($_POST['button'])){
if($_POST['button']== 'Exportar EXCEL'){
    // Crea un nuevo objeto PHPExcel
    $objPHPExcel = new PHPExcel();

    // Establecer propiedades
    $objPHPExcel->getProperties()
        ->setCreator("OBD")
        ->setLastModifiedBy("OBD")
        ->setTitle("INIDICADORES")
        ->setSubject("REPORTE PLAN DE ACCION")
        ->setDescription("REPORTE POR PILAR PROGRAMA ACCION ACTIVIDAD META")
        ->setKeywords("REPORTE PLAN DE ACCION")
        ->setCategory("REPORTE");

    $objPHPExcel->getActiveSheet()->setTitle('PLAN ACCION');
    $objPHPExcel->getActiveSheet()
        ->getPageSetup()
        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $objPHPExcel->getActiveSheet()
        ->getPageSetup()
        ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

    $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(0);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(0);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(false);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    // Estilos de la pagina
    $styleArrayTitulo = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 16,
            'name'  => 'Calibri'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'dce6f1')
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    );

    $styleArraySubTitulo = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 10,
            'name'  => 'Calibri'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'wrap' => true
        )
    );

    $styleArrayHeader = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size'  => 6,
            'name'  => 'Calibri'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4f81bd')
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    );
    $styleArrayTextoN = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 6,
            'name'  => 'Calibri'
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    );
    $styleArrayTexto = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 6,
            'name'  => 'Calibri'
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    );
    $styleArrayPorcentaje = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 6,
            'name'  => 'Calibri'
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );
    $styleArrayTextoNP = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 6,
            'name'  => 'Calibri'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'dbe5f1')
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    );
    $styleArrayTextoP = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 6,
            'name'  => 'Calibri'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'dbe5f1')
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    );
    $styleArrayPorcentajeP = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 6,
            'name'  => 'Calibri'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'dbe5f1')
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );
    $styleArrayTotalCumplimiento = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'wrap' => true
        )
    );
    $styleArrayTotalCumplimientoFondo = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '92d050')
        )
    );
    $styleArrayTotalCumplimientoFondo1 = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'fabf8f')
        )
    );
    $styleArrayTotalCumplimiento1 = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'wrap' => true
        )
    );
    $styleArrayPorcentajeRojo = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 8,
            'name'  => 'Calibri'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'd52b1c')
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    $styleArrayPorcentajeAmarillo = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 8,
            'name'  => 'Calibri'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ffe001')
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    $styleArrayPorcentajeVerde = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 8,
            'name'  => 'Calibri'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '007932')
        ),
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000'),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    // Agregar Informacion

    $numero = 1;
    // Tamaño de logos
    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(45);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo CONALTID');
    $objDrawing->setDescription('CONALTID');
    $objDrawing->setPath('img/conaltid.png');
    $objDrawing->setCoordinates('A1');
    $objDrawing->setHeight(45);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo Ministerio');
    $objDrawing->setDescription('Ministerio de Gobierno');
    $objDrawing->setPath('img/logo.png');
    $objDrawing->setCoordinates('D1');
    $objDrawing->setHeight(50);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo OBD');
    $objDrawing->setDescription('OBD');
    $objDrawing->setPath('img/obd.jpg');
    $objDrawing->setCoordinates('F1');
    $objDrawing->setHeight(40);
    $objDrawing->setOffsetX(5);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo UE');
    $objDrawing->setDescription('Union Europea');
    $objDrawing->setPath('img/ue.jpg');
    $objDrawing->setCoordinates('H1');
    $objDrawing->setHeight(40);
    $objDrawing->setOffsetX(25);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    $nfila=2;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila, 'Gestión : ' . $colname_reportea);
    $objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':B'.$nfila);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':B'.$nfila)->applyFromArray($styleArraySubTitulo);
    $nfila++;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila, 'Fecha : '.date('d/m/Y'));
    $objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':B'.$nfila);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':B'.$nfila)->applyFromArray($styleArraySubTitulo);
    $nfila++;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila, 'PLAN DE ACCION OPERATIVO');
    $objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':H'.$nfila);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':H'.$nfila)->applyFromArray($styleArrayTitulo);
    $nfila++;
    $columnas = array('A','B','C','D','E','F','G','H');
    $cabeceraExcel = array('PILAR','PROGRAMA','ACCION','ACTIVIDAD','% PLAN ACCION','% CUMPLIMIENTO PLAN ACCION','META','RESPONSABLE');
    $tamanio = array(11,15,15,25,12,15,25,15); //total 133

    foreach ($columnas as $num=>$letra){
        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila, $cabeceraExcel[$num]);
        $objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth($tamanio[$num]);
        $objPHPExcel->getActiveSheet()->getStyle($letra.$nfila)->applyFromArray($styleArrayHeader);
    }
    $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);

    $nfila++;
    if($pilares){
        $cumplimientoTotal = 0;
        foreach($pilares as $num=>$pilar){
            if($num%2==0){
                if($numeroPilar)
                    $num = $numeroPilar;
                $letra = 'A';
                $nCelda = $letra.$nfila.':'.$letra.($nfila+$pilar['nRows']-1);
                $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila,  ($num+1).'. '.$pilar['titulo_pilar']);
                $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayTextoN);
                if($pilar['programas']){
                    $nPrograma = $nfila;
                    foreach($pilar['programas'] as $numPrograma=>$programa){
                        if($numeroPrograma)
                            $numPrograma = $numeroPrograma;
                        $letra='B';
                        $nCelda = $letra.$nPrograma.':'.$letra.($nPrograma+$programa['nRows']-1);
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nPrograma,  ($num+1).'.'.($numPrograma+1).'. '.$programa['titulo_programa']);
                        $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                        $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayTexto);
                        if($programa['acciones']) {
                            $nAccion = $nPrograma;
                            foreach ($programa['acciones'] as $numAccion => $accion) {
                                if($numeroAccion)
                                    $numAccion = $numeroAccion;
                                $letra='C';
                                $nCelda = $letra.$nAccion.':'.$letra.($nAccion+$accion['nRows']-1);
                                $objPHPExcel->getActiveSheet()->setCellValue($letra.$nAccion,  ($num+1).'.'.($numPrograma+1).'.'.($numAccion+1).'. '.$accion['descr_accion']);
                                $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                                $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayTexto);
                                if($accion['actividades']) {
                                    $nActividad = $nAccion;
                                    foreach ($accion['actividades'] as $numActividad => $actividad) {
                                        if($numeroActividad)
                                            $numActividad = $numeroActividad;
                                        $letra='D';
                                        $nCelda = $letra.$nActividad.':'.$letra.($nActividad+$actividad['nRows']-1);
                                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nActividad,  ($num+1).'.'.($numPrograma+1).'.'.($numAccion+1).'.'.($numActividad+1).'. '.$actividad['descr_actividad']);
                                        $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                                        $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayTexto);
                                        $letra='E';
                                        $nCelda = $letra.$nActividad.':'.$letra.($nActividad+$actividad['nRows']-1);
                                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nActividad,  $actividad['porcentaje']);
                                        $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                                        $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayPorcentaje);
                                        $objPHPExcel->getActiveSheet()->getStyle($letra.$nActividad)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                                        $letra='F';
                                        $nCelda = $letra.$nActividad.':'.$letra.($nActividad+$actividad['nRows']-1);
                                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nActividad,  $actividad['cumplimiento']);
                                        $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                                        $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayPorcentaje);
                                        $objPHPExcel->getActiveSheet()->getStyle($letra.$nActividad)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                                        $cumplimientoTotal += $actividad['cumplimiento'];
                                        if($actividad['metas']) {
                                            foreach ($actividad['metas'] as $numMeta => $meta) {
                                                $letra = 'G';
                                                $objPHPExcel->getActiveSheet()->setCellValue($letra.($nActividad+$numMeta),  $meta['descr_meta']);
                                                $objPHPExcel->getActiveSheet()->getStyle($letra.($nActividad+$numMeta))->applyFromArray($styleArrayTexto);
                                                $letra = 'H';
                                                $objPHPExcel->getActiveSheet()->setCellValue($letra.($nActividad+$numMeta), $meta['meta_login']);
                                                $objPHPExcel->getActiveSheet()->getStyle($letra.($nActividad+$numMeta))->applyFromArray($styleArrayPorcentaje);
                                                $objPHPExcel->getActiveSheet()->getStyle($letra.($nActividad+$numMeta))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                                            }
                                        }
                                        $nActividad += $actividad['nRows'];
                                    }
                                }
                                $nAccion += $accion['nRows'];
                            }
                        }
                        $nPrograma+=$programa['nRows'];
                    }
                }
            }else{
                if($numeroPilar)
                    $num = $numeroPilar;
                $letra = 'A';
                $nCelda = $letra.$nfila.':'.$letra.($nfila+$pilar['nRows']-1);
                $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila,  ($num+1).'. '.$pilar['titulo_pilar']);
                $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayTextoNP);
                if($pilar['programas']){
                    $nPrograma = $nfila;
                    foreach($pilar['programas'] as $numPrograma=>$programa){
                        if($numeroPrograma)
                            $numPrograma = $numeroPrograma;
                        $letra='B';
                        $nCelda = $letra.$nPrograma.':'.$letra.($nPrograma+$programa['nRows']-1);
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nPrograma,  ($num+1).'.'.($numPrograma+1).'. '.$programa['titulo_programa']);
                        $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                        $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayTextoP);
                        if($programa['acciones']) {
                            $nAccion = $nPrograma;
                            foreach ($programa['acciones'] as $numAccion => $accion) {
                                if($numeroAccion)
                                    $numAccion = $numeroAccion;
                                $letra='C';
                                $nCelda = $letra.$nAccion.':'.$letra.($nAccion+$accion['nRows']-1);
                                $objPHPExcel->getActiveSheet()->setCellValue($letra.$nAccion,  ($num+1).'.'.($numPrograma+1).'.'.($numAccion+1).'. '.$accion['descr_accion']);
                                $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                                $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayTextoP);
                                if($accion['actividades']) {
                                    $nActividad = $nAccion;
                                    foreach ($accion['actividades'] as $numActividad => $actividad) {
                                        if($numeroActividad)
                                            $numActividad = $numeroActividad;
                                        $letra='D';
                                        $nCelda = $letra.$nActividad.':'.$letra.($nActividad+$actividad['nRows']-1);
                                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nActividad,  ($num+1).'.'.($numPrograma+1).'.'.($numAccion+1).'.'.($numActividad+1).'. '.$actividad['descr_actividad']);
                                        $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                                        $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayTextoP);
                                        $letra='E';
                                        $nCelda = $letra.$nActividad.':'.$letra.($nActividad+$actividad['nRows']-1);
                                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nActividad,  $actividad['porcentaje']);
                                        $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                                        $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayPorcentajeP);
                                        $objPHPExcel->getActiveSheet()->getStyle($letra.$nActividad)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                                        $letra='F';
                                        $nCelda = $letra.$nActividad.':'.$letra.($nActividad+$actividad['nRows']-1);
                                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nActividad,  $actividad['cumplimiento']);
                                        $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                                        $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayPorcentajeP);
                                        $objPHPExcel->getActiveSheet()->getStyle($letra.$nActividad)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                                        $cumplimientoTotal += $actividad['cumplimiento'];
                                        if($actividad['metas']) {
                                            foreach ($actividad['metas'] as $numMeta => $meta) {
                                                $letra = 'G';
                                                $objPHPExcel->getActiveSheet()->setCellValue($letra.($nActividad+$numMeta),  $meta['descr_meta']);
                                                $objPHPExcel->getActiveSheet()->getStyle($letra.($nActividad+$numMeta))->applyFromArray($styleArrayTextoP);
                                                $letra = 'H';
                                                $objPHPExcel->getActiveSheet()->setCellValue($letra.($nActividad+$numMeta), $meta['meta_login']);
                                                $objPHPExcel->getActiveSheet()->getStyle($letra.($nActividad+$numMeta))->applyFromArray($styleArrayPorcentajeP);
                                                $objPHPExcel->getActiveSheet()->getStyle($letra.($nActividad+$numMeta))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                                            }
                                        }
                                        $nActividad += $actividad['nRows'];
                                    }
                                }
                                $nAccion += $accion['nRows'];
                            }
                        }
                        $nPrograma+=$programa['nRows'];
                    }
                }
            }
            $nfila+=$pilar['nRows'];
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila,  '% Total de Cumplimiento por Pilar :    ');
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':E'.$nfila);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':E'.$nfila)->applyFromArray($styleArrayTotalCumplimiento);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$nfila,  $sumPilares[$num]);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$nfila)->applyFromArray($styleArrayTotalCumplimiento1);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':H'.$nfila)->applyFromArray($styleArrayTotalCumplimientoFondo1);
            $nfila++;
        }
    }
    if(count($pilares)>1) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $nfila, '% Total de Cumplimiento del Plan de Acción Operativo :   ');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $nfila . ':E' . $nfila);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $nfila . ':E' . $nfila)->applyFromArray($styleArrayTotalCumplimiento);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $nfila, $cumplimientoTotal);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $nfila)->applyFromArray($styleArrayTotalCumplimiento1);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $nfila . ':H' . $nfila)->applyFromArray($styleArrayTotalCumplimientoFondo);
    }


    // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
    $objPHPExcel->setActiveSheetIndex(0);

    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
    $archivo = 'plan'.date('Y-m-d').'.xls';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$archivo.'"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA DE MONITOREO </title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">    
    <style type="text/css">
        body, td, th {
            font-size: 11px;
        }
        th {
            color: white;
            text-align: center;
            vertical-align: middle !important;
        }
        td.par {
            text-align: center;
            vertical-align: middle !important;
            background-color: #f9f9f9;
        }
        td.impar {
            text-align: center;
            vertical-align: middle !important;
            background-color: #fff;
        }
        td.total {
            text-align: center;
            vertical-align: middle !important;
            background-color: #638ab1;
            font-size: 13px;
        }
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
        td.textoAps{
            text-align: justify !important;
        }
        td.rojo{
            padding: 5px;
            text-align: center;
            vertical-align: middle !important;
            font-weight: bold;
            background-color: white; /* For browsers that do not support gradients */
            background: -webkit-linear-gradient(90deg,white, #d52b1c); /* For Safari 5.1 to 6.0 */
            background: -o-linear-gradient(90deg,white, #d52b1c); /* For Opera 11.1 to 12.0 */
            background: -moz-linear-gradient(90deg,white, #d52b1c); /* For Firefox 3.6 to 15 */
            background: linear-gradient(90deg,white, #d52b1c); /* Standard syntax */
        }
        td.amarillo{
            padding: 5px;
            text-align: center;
            vertical-align: middle !important;
            font-weight: bold;
            background-color: white; /* For browsers that do not support gradients */
            background: -webkit-linear-gradient(90deg,white, #ffe001); /* For Safari 5.1 to 6.0 */
            background: -o-linear-gradient(90deg,white, #ffe001); /* For Opera 11.1 to 12.0 */
            background: -moz-linear-gradient(90deg,white, #ffe001); /* For Firefox 3.6 to 15 */
            background: linear-gradient(90deg,white, #ffe001); /* Standard syntax */
        }
        td.verde{
            padding: 5px;
            text-align: center;
            vertical-align: middle !important;
            font-weight: bold;
            background-color: white; /* For browsers that do not support gradients */
            background: -webkit-linear-gradient(90deg,white, #007932); /* For Safari 5.1 to 6.0 */
            background: -o-linear-gradient(90deg,white, #007932); /* For Opera 11.1 to 12.0 */
            background: -moz-linear-gradient(90deg,white, #007932); /* For Firefox 3.6 to 15 */
            background: linear-gradient(90deg,white, #007932); /* Standard syntax */
        }
        .results tr[visible='false'],
        .no-result{
          display:none;
        }

        .results tr[visible='true']{
          display:table-row;
        }

        .counter{
          padding:8px; 
          color:#ccc;
        }
    </style>
</head>
<body>
    <table width="100%" border="0" cellspacing="4">
        <tr>
            <td width="25%" align="center" valign="middle"><img src="../images/logo.jpg" height="70"></td>
            <td width="25%" align="center" valign="middle"><img src="../images/escudo.jpg" height="80"></td>
            <td width="25%" align="center" valign="middle"><img src="../images/obd.jpg" height="70"></td>
            <td width="25%" align="center" valign="middle"><img src="../images/ue.jpg" height="70"></td>
        </tr>
        <tr>
            <td colspan="4" align="center" valign="middle">
                <h1>PLAN DE ACCION<h1>
            </td>
        </tr>
    </table>
    <a href="../escritorio"><img src="../images/back.jpg" width="35">Atrás</a>
    <form method="post">

    <table align="center" class="filtros">
        <tr>
            <th>
                GESTIÓN
            </th>
            <th>
                PILAR
            </th>
            <th>
                PROGRAMA
            </th>
            <th>
                ACCIÓN
            </th>
            <th>
                ACTIVIDAD
            </th>
        </tr>
        <tr>
            <td>
                <select name="gestion" onchange="submit();">
                    <?php foreach($gestiones as $id=>$gestion){?>
                        <option value="<?php echo $id;?>" <?php if($id==$colname_reportea){echo "selected";}?>><?php echo $gestion;?></option>
                    <?php }?>
                </select>
            </td>
            <td>
                <select name="pil" onchange="submit();">
                    <?php foreach($selectPilar as $id=>$row){?>
                        <option value="<?php echo $id;?>" <?php if($id==$pil){echo "selected";}?>><?php echo $row;?></option>
                    <?php }?>
                </select>
            </td>
            <td>
                <select name="pro" onchange="submit();">
                    <?php foreach($selectPrograma as $id=>$row){?>
                        <option value="<?php echo $id;?>" <?php if($id==$pro){echo "selected";}?>><?php echo $row;?></option>
                    <?php }?>
                </select>
            </td>
            <td>
                <select name="acc" onchange="submit();">
                    <?php foreach($selectAccion as $id=>$row){?>
                        <option value="<?php echo $id;?>" <?php if($id==$acc){echo "selected";}?>><?php echo $row;?></option>
                    <?php }?>
                </select>
            </td>
            <td>
                <select name="act" onchange="submit();">
                    <?php foreach($selectActividad as $id=>$row){?>
                        <option value="<?php echo $id;?>" <?php if($id==$act){echo "selected";}?>><?php echo $row;?></option>
                    <?php }?>
                </select>
            </td>
            <td rowspan="2">
                <input type="submit" name="button" id="button" value="Exportar EXCEL">
            </td>
        </tr>
    </table>
    </form>

    <table id="datatable-responsive" class="table table-striped table-bordered" cellspacing="0">
        <thead>
        <tr>
            <?php foreach ($cabeceras as $cabecera) { ?>
                <th bgcolor="#2A3F54">
                    <div class="text-center"><?php echo $cabecera; ?></div>
                </th>
            <?php } ?>
            <th bgcolor="#2A3F54">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($pilares) { ?>
            <?php
            $sumTotal = 0;
            foreach ($pilares as $numPilar => $pilar) {
                $sumPilar = 0;
            ?>
                <?php
                if ($numPilar % 2 == 0) {
                    $style = 'impar';
                } else {
                    $style = 'par';
                }
                if($numeroPilar)
                    $numPilar = $numeroPilar
                ?>
                <tr>
                <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $pilar['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.</strong> '.$pilar[$campos[0]]; ?></td>
                <?php if ($pilar['programas']) { ?>
                    <?php foreach ($pilar['programas'] as $numPro => $programa) {?>
                        <?php                        
                        if ($numPro == 0) {
                            if($numeroPrograma)
                                $numPro = $numeroPrograma;
                        ?>
                            <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $programa['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.</strong> '.$programa[$campos[1]]; ?></td>
                            <?php if ($programa['acciones']) { ?>
                                <?php foreach ($programa['acciones'] as $numAc => $accion) { ?>
                                    <?php                                    
                                    if ($numAc == 0) {
                                        if($numeroAccion)
                                            $numAc = $numeroAccion;
                                    ?>
                                        <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $accion['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.</strong> '.$accion[$campos[2]]; ?></td>
                                        <?php if ($accion['actividades']) { ?>
                                            <?php
                                            foreach ($accion['actividades'] as $numAct => $actividad) {
                                                $sumPilar += $actividad['cumplimiento'];
                                                $sumTotal += $actividad['cumplimiento'];
                                            ?>
                                                <?php
                                                if ($numAct == 0) {
                                                    if($numeroActividad)
                                                        $numAct = $numeroActividad;
                                                ?>
                                                    <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.'.($numAct+1).'.</strong> '.$actividad['descr_actividad']; ?></td>
                                                    <td class="<?php echo $style; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['porcentaje']; ?></td>
                                                    <td class="<?php echo $style.' '.$actividad['semaforizacion']; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['cumplimiento']; ?></td>
                                                    <?php if ($actividad['metas']) {?>
                                                        <?php foreach ($actividad['metas'] as $numMe => $meta) {?>
                                                            <?php if ($numMe == 0) {?>
                                                            <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                            <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                            <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                            <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                            <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                            <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>                                                           
                                                            <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                            </tr>
                                                            <?php } else {  ?>
                                                            <tr>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                            </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>                                                                                                                                                                                                                                                                                                                        
                                                <?php } else {   ?>
                                                    <tr>
                                                    <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.'.($numAct+1).'.</strong> '.$actividad['descr_actividad']; ?></td>
                                                    <td class="<?php echo $style; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['porcentaje']; ?></td>
                                                    <td class="<?php echo $style.' '.$actividad['semaforizacion']; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['cumplimiento']; ?></td>
                                                    <?php if ($actividad['metas']) { ?>
                                                            <?php foreach ($actividad['metas'] as $numMe => $meta) {?>
                                                                <?php if ($numMe == 0) {?>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                                <?php } else { ?>
                                                                <tr>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                    <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                                <?php } ?>                                                                                                 
                                                            <?php } ?>
                                                        <?php } ?>                                                                                                                                                                                                                                
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                        <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $accion['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.</strong> '.$accion[$campos[2]]; ?></td>
                                        <?php if ($accion['actividades']) { ?>
                                            <?php
                                            foreach ($accion['actividades'] as $numAct => $actividad) {
                                                $sumPilar += $actividad['cumplimiento'];
                                                $sumTotal += $actividad['cumplimiento'];
                                                ?>
                                                <?php
                                                if ($numAct == 0) {
                                                    if($numeroActividad)
                                                        $numAct = $numeroActividad;
                                                    ?>
                                                    <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.'.($numAct+1).'.</strong> '.$actividad['descr_actividad']; ?></td>
                                                    <td class="<?php echo $style; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['porcentaje']; ?></td>
                                                    <td class="<?php echo $style.' '.$actividad['semaforizacion']; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['cumplimiento']; ?></td>
                                                    <?php if ($actividad['metas']) {?>
                                                        <?php foreach ($actividad['metas'] as $numMe => $meta) {?>
                                                            <?php if ($numMe == 0) {?>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } else {  ?>
                                                                <tr>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                    <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } else {   ?>
                                                    <tr>
                                                    <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.'.($numAct+1).'.</strong> '.$actividad['descr_actividad']; ?></td>
                                                    <td class="<?php echo $style; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['porcentaje']; ?></td>
                                                    <td class="<?php echo $style.' '.$actividad['semaforizacion']; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['cumplimiento']; ?></td>
                                                    <?php if ($actividad['metas']) { ?>
                                                        <?php foreach ($actividad['metas'] as $numMe => $meta) {?>
                                                            <?php if ($numMe == 0) {?>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                    <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                            <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $programa['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.</strong> '.$programa[$campos[1]]; ?></td>
                            <?php if ($programa['acciones']) { ?>
                                <?php foreach ($programa['acciones'] as $numAc => $accion) { ?>
                                    <?php if ($numAc == 0) { ?>
                                        <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $accion['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.</strong> '.$accion[$campos[2]]; ?></td>
                                        <?php if ($accion['actividades']) { ?>
                                            <?php
                                            foreach ($accion['actividades'] as $numAct => $actividad) {
                                                $sumPilar += $actividad['cumplimiento'];
                                                $sumTotal += $actividad['cumplimiento'];
                                                ?>
                                                <?php
                                                if ($numAct == 0) {
                                                    if($numeroActividad)
                                                        $numAct = $numeroActividad;
                                                    ?>
                                                    <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.'.($numAct+1).'.</strong> '.$actividad['descr_actividad']; ?></td>
                                                    <td class="<?php echo $style; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['porcentaje']; ?></td>
                                                    <td class="<?php echo $style.' '.$actividad['semaforizacion']; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['cumplimiento']; ?></td>
                                                    <?php if ($actividad['metas']) {?>
                                                        <?php foreach ($actividad['metas'] as $numMe => $meta) {?>
                                                            <?php if ($numMe == 0) {?>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } else {  ?>
                                                                <tr>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                    <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } else {   ?>
                                                    <tr>
                                                    <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.'.($numAct+1).'.</strong> '.$actividad['descr_actividad']; ?></td>
                                                    <td class="<?php echo $style; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['porcentaje']; ?></td>
                                                    <td class="<?php echo $style.' '.$actividad['semaforizacion']; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['cumplimiento']; ?></td>
                                                    <?php if ($actividad['metas']) { ?>
                                                        <?php foreach ($actividad['metas'] as $numMe => $meta) {?>
                                                            <?php if ($numMe == 0) {?>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                    <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                        <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $accion['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.</strong> '.$accion[$campos[2]]; ?></td>
                                        <?php if ($accion['actividades']) { ?>
                                            <?php
                                            foreach ($accion['actividades'] as $numAct => $actividad) {
                                                $sumPilar += $actividad['cumplimiento'];
                                                $sumTotal += $actividad['cumplimiento'];
                                                ?>
                                                <?php
                                                if ($numAct == 0) {
                                                    if($numeroActividad)
                                                        $numAct = $numeroActividad;
                                                    ?>
                                                    <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.'.($numAct+1).'.</strong> '.$actividad['descr_actividad']; ?></td>
                                                    <td class="<?php echo $style; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['porcentaje']; ?></td>
                                                    <td class="<?php echo $style.' '.$actividad['semaforizacion']; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['cumplimiento']; ?></td>
                                                    <?php if ($actividad['metas']) {?>
                                                        <?php foreach ($actividad['metas'] as $numMe => $meta) {?>
                                                            <?php if ($numMe == 0) {?>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } else {  ?>
                                                                <tr>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                    <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } else {   ?>
                                                    <tr>
                                                    <td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numPilar+1).'.'.($numPro+1).'.'.($numAc+1).'.'.($numAct+1).'.</strong> '.$actividad['descr_actividad']; ?></td>
                                                    <td class="<?php echo $style; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['porcentaje']; ?></td>
                                                    <td class="<?php echo $style.' '.$actividad['semaforizacion']; ?>" rowspan="<?php echo $actividad['nRows']; ?>" valign="middle"><?php echo $actividad['cumplimiento']; ?></td>
                                                    <?php if ($actividad['metas']) { ?>
                                                        <?php foreach ($actividad['metas'] as $numMe => $meta) {?>
                                                            <?php if ($numMe == 0) {?>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['descr_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['cumplimiento_meta']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['porcentajeCumplimiento']; ?></td>
                                                                    <td class="<?php echo $style .' '.$meta['semaforizacion']; ?>" valign="middle"><?php echo $meta['porcentajeCumplimientoMeta']; ?></td>
                                                                    <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta['meta_estd_sit']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta['meta_login']; ?></td>
                                                                    <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <tr>
                    <td colspan="5" class="total" valign="middle" align="right"><strong>% Total de Cumplimiento por Pilar : </strong></td>
                    <td class="total" valign="middle"><strong><?php echo $sumPilar;?></strong></td>
                    <td colspan="6" class="total" valign="middle"> </td>
                </tr>
            <?php } ?>
            <?php if(!$_POST['pil']){?>
                <tr>
                    <td colspan="5" class="total" valign="middle" align="right"><strong>% Total de Cumplimiento Plan Acción : </strong></td>
                    <td class="total" valign="middle"><strong><?php echo $sumTotal;?></strong></td>
                    <td colspan="6" class="total" valign="middle"> </td>
                </tr>
            <?php }?>
        <?php } ?>
        </tbody>
    </table>
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

                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                </div>

            </div>

        </div>

    </div>

    <script>

        function numeral(num)

        {

            <?php

            $pen="num";

            echo "document.getElementById('la_suma_de').value=".$pen.";";?>



        }

        //pagina,form,idsalida

        function nre(str,strb,sal)

        {

            menerror="failure";

            urr=str+".php";

            urfr="form."+strb;

            dest="#"+sal;

            var formData = new FormData($(urfr)[0]);

            $.ajax({

                type: "POST",

                url: urr,

                data: formData,

                contentType: false,

                processData: false,

                success: function(msg){

                    $(dest).html(msg)

                    $("#form-content").modal('hide');

                },

                error: function(){

                    alert(menerror);

                }

            })





        }

        function ventana(ht,str,sal)
        {
            if(str=='delete')
            {
                str=document.getElementById('focus').value;
            }

            //document.getElementById("buss").value=str;

            if (window.XMLHttpRequest) {

                // code for IE7+, Firefox, Chrome, Opera, Safari

                xmlhttp = new XMLHttpRequest();

            } else {

                // code for IE6, IE5

                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

            }

            xmlhttp.onreadystatechange = function() {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    document.getElementById(sal).innerHTML = xmlhttp.responseText;

                }

            }

            str=ht+".php?item="+str;

            xmlhttp.open("GET",str,true);

            xmlhttp.send();

        }

        function caja(ht,str,sal)

        {

            if(str=='delete')

            {

                str=document.getElementById('focus').value;

            }

            //	alert(str);

            //document.getElementById("buss").value=str;

            if (window.XMLHttpRequest) {

                // code for IE7+, Firefox, Chrome, Opera, Safari

                xmlhttp = new XMLHttpRequest();

            } else {

                // code for IE6, IE5

                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

            }

            xmlhttp.onreadystatechange = function() {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    document.getElementById(sal).value = xmlhttp.responseText;

                }

            }

            str=ht+".php?item="+str;

            xmlhttp.open("GET",str,true);

            xmlhttp.send();

        }



        function myFunction()

        {

            window.print();

        }
        
        function documentos(url,id,sal)
        {                       
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                    document.getElementById(sal).innerHTML = xmlhttp.responseText;
                
            }
            str=url+".php?cod="+id;            
            xmlhttp.open("GET",str,true);
            xmlhttp.send();
        }
        function mySearch() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");        

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[1];
          if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      }

    </script>
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../build/js/custom.min.js"></script>
    <script src="../js/index.js"></script>   
</body>
</html>