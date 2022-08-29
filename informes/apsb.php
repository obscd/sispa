<?php
require_once('../locklvl.php');
$MM_authorizedUsers =usuario(100);
require_once('../lock.php'); ?>

<?php
require_once('../Connections/conexion.php');
include ("../funcionesdb.php");
require_once 'libreria/excel/PHPExcel.php';

$gestiones['2016'] = 2016;
$gestiones['2017'] = 2017;
$gestiones['2018'] = 2018;
$selectIndicador[0] = 'Todos los Indicadores';
$selectMeta[0] = 'Todos las Metas';

$idFinanciador = 1;
$consulta = '
SELECT
cod_finnanciador,
nombre_financiador
FROM
financiador
WHERE
id_financiador = ' . $idFinanciador;
$financiador = fetchRow($consulta,$conexion);

$colname_reportea = $fa;
if (isset($_POST['gestion'])) {
    $colname_reportea = $_POST['gestion'];
}
$ind = '';
$whereIndicador = '';
if ($_POST['ind']!=0) {
    $ind = $_POST['ind'];
    $whereIndicador = ' AND cod_indicador = "'.$ind.'"';
}
$met = '';
$whereMeta = '';
if ($_POST['met']!=0) {
    $met = $_POST['met'];
    $whereMeta = ' AND cod_meta = "'.$met.'" ';
}

$consulta = '
SELECT
cod_indicador,
descr_indicador
FROM
indicador
WHERE
cod_financiador_ind = "'.$financiador['cod_finnanciador'].'"';
$indicadores = fetchAll($consulta, $conexion);
if($indicadores){
    foreach($indicadores as $num=>$row){
        $selectIndicador[$row['cod_indicador']]=cortarCadena(($num+1).'. '.$row['descr_indicador'],50);
        if($row['cod_indicador'] == $ind)
            $numeroIndicadorSeleccionado = $num;
    }
    $porcentajeIndicador = round(1/count($indicadores),3)*100;

}
if($ind){
    $consulta = '
    SELECT
    cod_meta,
    descr_meta
    FROM
    meta
    WHERE
    gestion = '.$colname_reportea.' AND cod_indicador_meta = "'.$ind.'"';
    $metas = fetchAll($consulta, $conexion);
    foreach($metas as $num=>$row){
        $selectMeta[$row['cod_meta']]=cortarCadena(($num+1).'. '.$row['descr_meta'],50);
        if($row['cod_meta'] == $met)
            $numeroMetaSeleccionado = $num;
    }

}

function cortarCadena($texto,$num){
    if(strlen($texto)<=$num)
        return $texto;
    else
        return substr($texto,0,$num).'...';
}


$cabeceras = array('INDICADOR',' ', 'META', 'PONDERACION', 'META A CUMPLIR', 'CUMPLIMIENTO', '% CUMPLIMIENTO', 'ESTADO SITUACION');
$campos = array('descr_indicador', 'id_img_meta', 'descr_meta', 'ponderacion', 'cumplimiento_meta', 'respuesta_real_decumpl','cum','meta_estd_sit');


if($financiador){
    $consulta = '
    SELECT
    *
    FROM
    indicador
    WHERE
    cod_financiador_ind = "'.$financiador['cod_finnanciador'].'" ' .$whereIndicador;
    $indicadores = fetchAll($consulta,$conexion);
    foreach($indicadores as $num=>$indicador){
        $consulta = '
        SELECT
        *
        FROM
        meta
        WHERE
        gestion = '.$colname_reportea.' AND cod_indicador_meta = "'.$indicador['cod_indicador'].'" '. $whereMeta;
        $metas = fetchAll($consulta,$conexion);        
        $indicadores[$num]['nRows'] = count($metas);
        $indicadores[$num]['metas'] = $metas;
        $indicadores[$num]['porciento'] = $porcentajeIndicador;
    }
}

function semaforizacion($porcentaje){
    if($porcentaje>=0 && $porcentaje<31)
        return "rojo";
    elseif($porcentaje>30 && $porcentaje<85)
        return "amarillo";
    elseif($porcentaje>84 && $porcentaje<=100)
        return "verde";
}

/* Exportar Excel */
if($_POST['button']== 'Exportar EXCEL'){
    // Crea un nuevo objeto PHPExcel
    $objPHPExcel = new PHPExcel();

    // Establecer propiedades
    $objPHPExcel->getProperties()
        ->setCreator("OBD")
        ->setLastModifiedBy("OBD")
        ->setTitle("INIDICADORES")
        ->setSubject("REPORTE DE INDICADORES")
        ->setDescription("REPORTE POR FINANCIADOR, GESTION, INDICADORES Y METAS")
        ->setKeywords("REPORTE INDICADOR")
        ->setCategory("REPORTE");

    $objPHPExcel->getActiveSheet()->setTitle('Indicadores');
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
            'size'  => 9,
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

// Estilo del Cuerpo Inpar

    $styleArrayIndicador = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 9,
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
    $styleArrayIndicadorPor = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 9,
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
    $styleArrayPorcentaje = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 9,
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
    $styleArrayPorcentajeF = array(
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
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    $styleArrayMeta = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 9,
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

// Estilo del Cuerpo Par

    $styleArrayIndicadorP = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 9,
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
    $styleArrayIndicadorPorP = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 9,
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
    $styleArrayPorcentajeP = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 9,
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
    $styleArrayPorcentajePF = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
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

    $styleArrayMetaP = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 9,
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

// Estilo de Cumplimiento

    $styleArrayCumplimiento = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ffff00')
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
            'size'  => 11,
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
            'size'  => 11,
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
            'size'  => 11,
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
    $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');

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
    $objDrawing->setCoordinates('C1');
    $objDrawing->setHeight(50);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo OBD');
    $objDrawing->setDescription('OBD');
    $objDrawing->setPath('img/obd.jpg');
    $objDrawing->setCoordinates('D1');
    $objDrawing->setHeight(40);
    $objDrawing->setOffsetX(190);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo UE');
    $objDrawing->setDescription('Union Europea');
    $objDrawing->setPath('img/ue.jpg');
    $objDrawing->setCoordinates('G1');
    $objDrawing->setHeight(40);
    $objDrawing->setOffsetX(10);
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
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila, 'INDICADORES APS');
    $objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':G'.$nfila);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':G'.$nfila)->applyFromArray($styleArrayTitulo);
    $nfila++;
    $columnas = array('A','B','C','D','E','F','G');
    $cabeceraExcel = array('DEFINICION INDICADOR','% INDICADOR',' ','METAS (GENERALIZADAS)','% META/INDICADOR','% AVANCE META','% AVANCE 100');
    $tamanio = array(32,9,9,45,14,12,12); //total 133
    foreach ($columnas as $num=>$letra){
        $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila, $cabeceraExcel[$num]);
        $objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth($tamanio[$num]);
        $objPHPExcel->getActiveSheet()->getStyle($letra.$nfila)->applyFromArray($styleArrayHeader);
    }
    $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);
    $nfila++;
    $porcentajeTotalCumplido = 0;
    $porcentajeCumplimientoIndicador = array();
    if($indicadores){
        foreach($indicadores as $num=>$indicador){
            if($num%2==0){
                if($numeroIndicadorSeleccionado)
                    $num=$numeroIndicadorSeleccionado;
                $letra = 'A';
                $nCelda = $letra.$nfila.':'.$letra.($nfila+$indicador['nRows']-1);
                $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila,  ($num+1).'. '.$indicador['descr_indicador']);
                $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayIndicador);
                $letra = 'B';
                $nCelda = $letra.$nfila.':'.$letra.($nfila+$indicador['nRows']-1);
                $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila, round($indicador['porciento'],2));
                $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayIndicadorPor);
                $objPHPExcel->getActiveSheet()->getStyle($letra.$nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                if($indicador['metas']){
                    foreach($indicador['metas'] as $numMeta=>$meta){
                        $cumplimientoIndicador = round($indicador['porciento']*($meta['ponderacion']/100),2);
                        $cumplimientoPorcentaje = round(($meta['respuesta_real_decumpl']*100)/$meta['cumplimiento_meta'],2);
                        if(strlen($meta['descr_meta'])<=200)
                            $objPHPExcel->getActiveSheet()->getRowDimension(($nfila+$numMeta))->setRowHeight(53);
                        $letra='C';
                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        $objDrawing->setName('Imagen Meta');
                        $objDrawing->setDescription('img meta');
                        if($meta['id_img_meta'])
                            $objDrawing->setPath('../imagenesayuda/'.$meta['id_img_meta']);
                        else
                            $objDrawing->setPath('img/img.jpg');
                        $objDrawing->setHeight(60);
                        $objDrawing->setOffsetX(3);
                        $objDrawing->setOffsetY(5);
                        $objDrawing->setCoordinates($letra.($nfila+$numMeta));
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayMeta);
                        $letra='D';
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.($nfila+$numMeta),  ($num+1).'.'.($numMeta+1).'. '.$meta['descr_meta']);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayMeta);
                        $letra='E';
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.($nfila+$numMeta), $cumplimientoIndicador);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentaje);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        $letra='F';
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.($nfila+$numMeta),  round(($cumplimientoIndicador*$cumplimientoPorcentaje)/100,2));
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentaje);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        $letra='G';
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.($nfila+$numMeta),$cumplimientoPorcentaje);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentaje);

                        $porcentajeTotalCumplido += round(($cumplimientoIndicador*$cumplimientoPorcentaje)/100,3);
                        $porcentajeCumplimientoIndicador[($num+1)]+= round(($cumplimientoIndicador*$cumplimientoPorcentaje)/100,3);
                    }
                }
            }else{
                $letra = 'A';
                $nCelda = $letra.$nfila.':'.$letra.($nfila+$indicador['nRows']-1);
                $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila,  ($num+1).'. '.$indicador['descr_indicador']);
                $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayIndicadorP);
                $letra = 'B';
                $nCelda = $letra.$nfila.':'.$letra.($nfila+$indicador['nRows']-1);
                $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila, round($indicador['porciento'],2));
                $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
                $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayIndicadorPorP);
                $objPHPExcel->getActiveSheet()->getStyle($letra.$nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                if($indicador['metas']){
                    foreach($indicador['metas'] as $numMeta=>$meta){
                        $cumplimientoIndicador = round($indicador['porciento']*($meta['ponderacion']/100),2);
                        $cumplimientoPorcentaje = round(($meta['respuesta_real_decumpl']*100)/$meta['cumplimiento_meta'],2);
                        if(strlen($meta['descr_meta'])<=200)
                            $objPHPExcel->getActiveSheet()->getRowDimension(($nfila+$numMeta))->setRowHeight(53);
                        $letra='C';
                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        $objDrawing->setName('Imagen Meta');
                        $objDrawing->setDescription('img meta');
                        if($meta['id_img_meta'])
                            $objDrawing->setPath('../imagenesayuda/'.$meta['id_img_meta']);
                        else
                            $objDrawing->setPath('img/img.jpg');
                        $objDrawing->setHeight(60);
                        $objDrawing->setOffsetX(3);
                        $objDrawing->setOffsetY(5);
                        $objDrawing->setCoordinates($letra.($nfila+$numMeta));
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayMetaP);

                        $letra='D';
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.($nfila+$numMeta),  ($num+1).'.'.($numMeta+1).'. '.$meta['descr_meta']);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayMetaP);
                        $letra='E';
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.($nfila+$numMeta), $cumplimientoIndicador);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeP);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        $letra='F';
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.($nfila+$numMeta),  round(($cumplimientoIndicador*$cumplimientoPorcentaje)/100,2));
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeP);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        $letra='G';
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.($nfila+$numMeta),$cumplimientoPorcentaje);
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeP);

                        $porcentajeTotalCumplido += round(($cumplimientoIndicador*$cumplimientoPorcentaje)/100,3);
                        $porcentajeCumplimientoIndicador[($num+1)]+= round(($cumplimientoIndicador*$cumplimientoPorcentaje)/100,3);
                    }
                }
            }
            $nfila+=$indicador['nRows'];
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila,  '% Total de Cumplimiento por Indicador :    ');
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':E'.$nfila);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':E'.$nfila)->applyFromArray($styleArrayTotalCumplimiento);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$nfila,  $porcentajeCumplimientoIndicador[($num+1)]);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$nfila)->applyFromArray($styleArrayTotalCumplimiento1);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':G'.$nfila)->applyFromArray($styleArrayTotalCumplimientoFondo1);
            $nfila++;
        }
    }
    if(count($indicadores)>1) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $nfila, '% Total de Cumplimiento del APS :   ');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $nfila . ':E' . $nfila);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $nfila . ':E' . $nfila)->applyFromArray($styleArrayTotalCumplimiento);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $nfila, $porcentajeTotalCumplido);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $nfila)->applyFromArray($styleArrayTotalCumplimiento1);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $nfila . ':G' . $nfila)->applyFromArray($styleArrayTotalCumplimientoFondo);
    }

    // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
    $objPHPExcel->setActiveSheetIndex(0);

    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
    $archivo = 'aps'.date('Y-m-d').'.xls';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$archivo.'"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
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
<?php require('../cssadmin.php'); ?>
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
							US. APROBACION <small>INDICADORES APS</small>
				</h1>

              </div>
         </div>
          <div class="row">


<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
                <div class="x_content">
				
    <table width="100%" border="0" cellspacing="4">
        <tr>
            <td width="25%" align="center" valign="middle"><img src="../images/logo.jpg" height="70"></td>
            <td width="25%" align="center" valign="middle"><img src="../images/escudo.jpg" height="80"></td>
            <td width="25%" align="center" valign="middle"><img src="../images/obd.jpg" height="70"></td>
            <td width="25%" align="center" valign="middle"><img src="../images/ue.jpg" height="70"></td>
        </tr>
        <tr>
            <td colspan="4" align="center" valign="middle">
                <h1>INDICADORES APS<h1>
            </td>
        </tr>
    </table>
   
    <form method="post">

    <table align="center" class="filtros">
        <tr>
            <td>
                <b>GESTIÓN</b>
            </td>
            <td>
                <b>INDICADOR</b>
            </td>
            <td>
                <b>META</b>
            </td>
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
                <select name="ind" onchange="submit();">
                    <?php foreach($selectIndicador as $id=>$row){?>
                        <option value="<?php echo $id;?>" <?php if($id==$ind){echo "selected";}?>><?php echo $row;?></option>
                    <?php }?>
                </select>
            </td>
            <td>
                <select name="met" onchange="submit();">
                    <?php foreach($selectMeta as $id=>$row){?>
                        <option value="<?php echo $id;?>" <?php if($id==$met){echo "selected";}?>><?php echo $row;?></option>
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
        <?php if ($indicadores) { $sumAPS=0; ?>
            <?php foreach ($indicadores as $numIndicador => $indicador) { ?>
                <?php
                $sumIndicador = 0;
                if($numeroIndicadorSeleccionado)
                    $numIndicador = $numeroIndicadorSeleccionado;
                if ($numIndicador % 2 == 0) {
                    $style = 'impar';
                } else {
                    $style = 'par';
                }
                ?>
                <tr><td class="<?php echo $style; ?> textoAps" rowspan="<?php echo $indicador['nRows']; ?>" valign="middle"><?php echo '<strong>'.($numIndicador+1).'.</strong> '.$indicador[$campos[0]]; ?></td>
                <?php if ($indicador['metas']) { ?>
                    <?php
                    foreach ($indicador['metas'] as $numMeta => $meta) {
                        $semaforo = round(($meta['respuesta_real_decumpl']*100)/$meta['cumplimiento_meta'],2);
                        $semaforoPonderado = round(($semaforo/100)*$meta['ponderacion'],2);
                        $sumIndicador += $semaforoPonderado;                        
                    ?>
                        <?php
                        if ($numMeta == 0) {
                            if($numeroMetaSeleccionado)
                                $numMeta = $numeroMetaSeleccionado;
                        ?>                    
                            <?php if($meta[$campos[1]]){?>
                            <td class="<?php echo $style; ?>" valign="middle"><img width="60" height="60" src="../imagenesayuda/<?php echo $meta[$campos[1]]; ?>"></td>
                            <?php }else{?>
                            <td class="<?php echo $style; ?>" valign="middle"> </td>
                            <?php }?>
                            <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo '<strong>'.($numIndicador+1).'.'.($numMeta+1).'.</strong> '.$meta[$campos[2]]; ?></td>
                            <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta[$campos[3]]; ?></td>
                            <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta[$campos[4]]; ?></td>
                            <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta[$campos[5]]; ?></td>
                            <td class="<?php echo $style.' '.semaforizacion($semaforo); ?>" valign="middle"><?php echo $semaforoPonderado; ?></td>
                            <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta[$campos[7]]; ?></td>
                            <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('documento','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                            </tr>
                        <?php
                        } else {
                            if($numeroMetaSeleccionado)
                                $numMeta = $numeroMetaSeleccionado;
                        ?>
                            <tr>
                                <?php if($meta[$campos[1]]){?>
                                <td class="<?php echo $style; ?>" valign="middle"><img width="60" height="60" src="../imagenesayuda/<?php echo $meta[$campos[1]]; ?>"></td>
                                <?php }else{?>
                                <td class="<?php echo $style; ?>" valign="middle"> </td>
                                <?php }?>
                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo '<strong>'.($numIndicador+1).'.'.($numMeta+1).'.</strong> '.$meta[$campos[2]]; ?></td>
                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta[$campos[3]]; ?></td>
                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta[$campos[4]]; ?></td>
                                <td class="<?php echo $style; ?>" valign="middle"><?php echo $meta[$campos[5]]; ?></td>
                                <td class="<?php echo $style.' '.semaforizacion($semaforo); ?>" valign="middle"><?php echo $semaforoPonderado; ?></td>
                                <td class="<?php echo $style; ?> textoAps" valign="middle"><?php echo $meta[$campos[7]]; ?></td>
                                <td class="<?php echo $style; ?>" valign="middle"><a class="btn btn-succes" data-toggle='modal' data-target='#buscar' onClick="documentos('documento','<?php echo $meta['cod_meta']; ?>','busqueda')"><img src="../images/respaldo.png" width="25px" height="20px"></a></td>
                            </tr>
                        <?php } ?>
                    <?php                   
                    }
                    $sumAPS += ($sumIndicador/100)*$porcentajeIndicador;                    
                    ?>
                <?php } ?>
                            <tr>
                                <td colspan="6" class="total <?php echo $style; ?>" valign="middle" align="right"><strong>% Total de Cumplimiento por Indicador : </strong></td>
                                <td class="total <?php echo $style; ?>" valign="middle"><strong><?php echo $sumIndicador;?></strong></td>
                                <td colspan="2" class="total <?php echo $style; ?>" valign="middle"> </td>
                            </tr>
            <?php } ?>
                            <?php if(!$_POST['ind']){?>
                            <tr>
                                <td colspan="6" class="total" valign="middle" align="right"><strong>% Total de Cumplimiento del APS : </strong></td>
                                <td class="total" valign="middle"><strong><?php echo round($sumAPS,2);?></strong></td>
                                <td colspan="2" class="total" valign="middle"> </td>
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
   
</div>
            </div>

</div>
</div>


</div>
</div>
</div>


<?php require_once('../jsadmin.php'); ?>
<script>
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
</body>
</html>