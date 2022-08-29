<?php
require_once('../Connections/conexion.php');
include ("funciones/funcionesdb.php");
require_once 'libreria/excel/PHPExcel.php';

if (isset($_POST['gestion'])) {
    $gestion = $_POST['gestion'];
}
if (isset($_POST['financiador'])) {
    $idFinanciador = $_POST['financiador'];
}

$idFinanciador = 1;
if($idFinanciador<=0){
    echo "Debe Seleccionar un financiador";
    die();
}
$consulta = '
        SELECT
        *
        FROM
        financiador
        WHERE
        id_financiador = ' . $idFinanciador;
$financiador = fetchRow($consulta,$conexion);
if($financiador){
    $consulta = '
    SELECT
    *
    FROM
    indicador
    WHERE
    cod_financiador_ind = "'.$financiador['cod_finnanciador'].'"';
    $indicadores = fetchAll($consulta,$conexion);
    foreach($indicadores as $num=>$indicador){
        $consulta = '
        SELECT
        *
        FROM
        meta
        WHERE
        gestion = '.$gestion.' AND cod_indicador_meta = "'.$indicador['cod_indicador'].'"';
        $metas = fetchAll($consulta,$conexion);
        $indicadores[$num]['nrows'] = count($metas);        
        $indicadores[$num]['metas'] = $metas;
        if('pond_2016'=='pond_'.$gestion)
            $indicadores[$num]['porciento'] = $indicador['pond_2016'];
        elseif('pond_2017'=='pond_'.$gestion)
            $indicadores[$num]['porciento'] = $indicador['pond_2017'];
        elseif('pond_2018'=='pond_'.$gestion)
            $indicadores[$num]['porciento'] = $indicador['pond_2018'];       
    }
}

function semaforizacion($porcentaje){
    if($porcentaje>0 && $porcentaje<50)
        return "rojo";
    elseif($porcentaje>49 && $porcentaje<80)
        return "amarillo";
    elseif($porcentaje>79 && $porcentaje<=100)
        return "verde";
}

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
// Bordes
$styleThinBlackBorderOutline = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000'),
        ),
    ),
);

//fONDO CABECERA

$styleBackgroundHeader = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '4f81bd')
    )
);

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
$objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila, 'Gestión : ' . $gestion);
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
$cabecera = array('DEFINICION INDICADOR','% INDICADOR',' ','METAS (GENERALIZADAS)','% META/INDICADOR','% AVANCE META','% AVANCE 100');
$tamanio = array(32,9,9,45,14,12,12); //total 133

foreach ($columnas as $num=>$letra){
    $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila, $cabecera[$num]);
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
            $letra = 'A';
            $nCelda = $letra.$nfila.':'.$letra.($nfila+$indicador['nrows']-1);
            $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila,  ($num+1).'. '.$indicador['descr_indicador']);
            $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
            $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayIndicador);
            $letra = 'B';
            $nCelda = $letra.$nfila.':'.$letra.($nfila+$indicador['nrows']-1);
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
                    if($cumplimientoPorcentaje>=0 && $cumplimientoPorcentaje<50)
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeRojo);
                    elseif($cumplimientoPorcentaje>49 && $cumplimientoPorcentaje<80)
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeAmarillo);
                    elseif($cumplimientoPorcentaje>79 && $cumplimientoPorcentaje<=100)
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeVerde);
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
            $nCelda = $letra.$nfila.':'.$letra.($nfila+$indicador['nrows']-1);
            $objPHPExcel->getActiveSheet()->setCellValue($letra.$nfila,  ($num+1).'. '.$indicador['descr_indicador']);
            $objPHPExcel->getActiveSheet()->mergeCells($nCelda);
            $objPHPExcel->getActiveSheet()->getStyle($nCelda)->applyFromArray($styleArrayIndicadorP);
            $letra = 'B';
            $nCelda = $letra.$nfila.':'.$letra.($nfila+$indicador['nrows']-1);
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
                    if($cumplimientoPorcentaje>=0 && $cumplimientoPorcentaje<50)
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeRojo);
                    elseif($cumplimientoPorcentaje>49 && $cumplimientoPorcentaje<80)
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeAmarillo);
                    elseif($cumplimientoPorcentaje>79 && $cumplimientoPorcentaje<=100)
                        $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeVerde);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $letra='G';
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.($nfila+$numMeta),$cumplimientoPorcentaje);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.($nfila+$numMeta))->applyFromArray($styleArrayPorcentajeP);

                    $porcentajeTotalCumplido += round(($cumplimientoIndicador*$cumplimientoPorcentaje)/100,3);
                    $porcentajeCumplimientoIndicador[($num+1)]+= round(($cumplimientoIndicador*$cumplimientoPorcentaje)/100,3);
                }
            }
        }
        $nfila+=$indicador['nrows'];
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

$objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila,  '% Total de Cumplimiento del APS :   ');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':E'.$nfila);
$objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':E'.$nfila)->applyFromArray($styleArrayTotalCumplimiento);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$nfila,  $porcentajeTotalCumplido);
$objPHPExcel->getActiveSheet()->getStyle('F'.$nfila)->applyFromArray($styleArrayTotalCumplimiento1);
$objPHPExcel->getActiveSheet()->getStyle('F'.$nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':G'.$nfila)->applyFromArray($styleArrayTotalCumplimientoFondo);


$styleArrayGrafica = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 9,
        'name'  => 'Calibri'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ffda00')
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
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap' => true
    )
);

// Add new sheet
$objPHPExcel->createSheet(1); //Setting index when creating
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet(1)->setTitle('Resumen');

//Configuracion de la pagina
$objPHPExcel->getActiveSheet(1)
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet(1)
    ->getPageSetup()
    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

$objPHPExcel->getActiveSheet(1)->getPageMargins()->setTop(0);
$objPHPExcel->getActiveSheet(1)->getPageMargins()->setRight(0);
$objPHPExcel->getActiveSheet(1)->getPageMargins()->setLeft(0);
$objPHPExcel->getActiveSheet(1)->getPageMargins()->setBottom(0);
$objPHPExcel->getActiveSheet(1)->getPageMargins()->setHeader(0);
$objPHPExcel->getActiveSheet(1)->getPageMargins()->setFooter(0);

$objPHPExcel->getActiveSheet(1)->getPageSetup()->setHorizontalCentered(false);
$objPHPExcel->getActiveSheet(1)->getPageSetup()->setVerticalCentered(false);

$numero = 1;

// Tamaño de logos
$objPHPExcel->getActiveSheet(1)->getRowDimension('1')->setRowHeight(45);
$objPHPExcel->getActiveSheet(1)->mergeCells('A1:G1');

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo CONALTID');
$objDrawing->setDescription('CONALTID');
$objDrawing->setPath('img/conaltid.png');
$objDrawing->setCoordinates('A1');
$objDrawing->setHeight(45);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet(1));

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo Ministerio');
$objDrawing->setDescription('Ministerio de Gobierno');
$objDrawing->setPath('img/logo.png');
$objDrawing->setCoordinates('D1');
$objDrawing->setHeight(50);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet(1));

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo OBD');
$objDrawing->setDescription('OBD');
$objDrawing->setPath('img/obd.jpg');
$objDrawing->setCoordinates('E1');
$objDrawing->setHeight(40);
$objDrawing->setOffsetX(65);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet(1));

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo UE');
$objDrawing->setDescription('Union Europea');
$objDrawing->setPath('img/ue.jpg');
$objDrawing->setCoordinates('G1');
$objDrawing->setHeight(40);
$objDrawing->setOffsetX(70);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet(1));

$nfila=2;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila, 'Gestión : ' . $gestion);
$objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':B'.$nfila);
$objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':B'.$nfila)->applyFromArray($styleArraySubTitulo);
$nfila++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila, 'Financiador : '.$financiador['nombre_financiador']);
$objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':B'.$nfila);
$objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':B'.$nfila)->applyFromArray($styleArraySubTitulo);
$nfila++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$nfila, 'Fecha : '.date('d/m/Y'));
$objPHPExcel->getActiveSheet()->mergeCells('A'.$nfila.':B'.$nfila);
$objPHPExcel->getActiveSheet()->getStyle('A'.$nfila.':B'.$nfila)->applyFromArray($styleArraySubTitulo);
$nfila++;
$objPHPExcel->getActiveSheet(1)->setCellValue('A'.$nfila, 'SISTEMA MONITORE APS');
$objPHPExcel->getActiveSheet(1)->mergeCells('A'.$nfila.':C'.$nfila);
$objPHPExcel->getActiveSheet(1)->getStyle('A'.$nfila.':C'.$nfila)->applyFromArray($styleArrayTitulo);
$nfila++;

$columnas = array('A','B','C','D','E','F','G');
$cabecera = array('INDICADORES','% INDICADOR','% CUMPLIMIENTO','','','','');
$tamanio = array(15,15,15,22,22,22,22); //total 133

foreach ($columnas as $num=>$letra){
    if($cabecera[$num]){
        $objPHPExcel->getActiveSheet(1)->setCellValue($letra.$nfila, $cabecera[$num]);
        $objPHPExcel->getActiveSheet(1)->getStyle($letra.$nfila)->applyFromArray($styleArrayHeader);
    }else{
        $objPHPExcel->getActiveSheet(1)->setCellValue($letra.$nfila, '');
    }
    $objPHPExcel->getActiveSheet(1)->getColumnDimension($letra)->setWidth($tamanio[$num]);
}

$nfila++;
$nDatos = $nfila;
$numeroRomano = array('I','II','III','IV','V','VI','VII','VIII','IX','X');
foreach($porcentajeCumplimientoIndicador as $num=>$row){
    $letra = 'A';
    $objPHPExcel->getActiveSheet(1)->setCellValue($letra.$nfila, $numeroRomano[$num-1]);
    $objPHPExcel->getActiveSheet(1)->getStyle($letra.$nfila)->applyFromArray($styleArrayIndicador);
    $letra = 'B';
    $objPHPExcel->getActiveSheet(1)->setCellValue($letra.$nfila, round($indicadores[$num-1]['porciento'],2));
    $objPHPExcel->getActiveSheet(1)->getStyle($letra.$nfila)->applyFromArray($styleArrayPorcentaje);
    $objPHPExcel->getActiveSheet(1)->getStyle($letra.$nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $letra = 'C';
    $objPHPExcel->getActiveSheet(1)->setCellValue($letra.$nfila, round($row,2));
    $objPHPExcel->getActiveSheet(1)->getStyle($letra.$nfila)->applyFromArray($styleArrayPorcentaje);
    $objPHPExcel->getActiveSheet(1)->getStyle($letra.$nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $nfila++;
}

$objPHPExcel->getActiveSheet(1)->setCellValue('A'.$nfila,  'Porcentaje de Cumplimiento');
$objPHPExcel->getActiveSheet(1)->mergeCells('A'.$nfila.':B'.$nfila);
$objPHPExcel->getActiveSheet(1)->getStyle('A'.$nfila.':B'.$nfila)->applyFromArray($styleArrayTotalCumplimiento);
$objPHPExcel->getActiveSheet(1)->setCellValue('C'.$nfila,  $porcentajeTotalCumplido);
$objPHPExcel->getActiveSheet(1)->getStyle('C'.$nfila)->applyFromArray($styleArrayTotalCumplimiento1);
$objPHPExcel->getActiveSheet(1)->getStyle('C'.$nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$nfila++;
$objPHPExcel->getActiveSheet(1)->setCellValue('A'.$nfila,  'Porcentaje de No Cumplimiento');
$objPHPExcel->getActiveSheet(1)->mergeCells('A'.$nfila.':B'.$nfila);
$objPHPExcel->getActiveSheet(1)->getStyle('A'.$nfila.':B'.$nfila)->applyFromArray($styleArrayTotalCumplimiento);
$objPHPExcel->getActiveSheet(1)->setCellValue('C'.$nfila,  round(100-$porcentajeTotalCumplido,2));
$objPHPExcel->getActiveSheet(1)->getStyle('C'.$nfila)->applyFromArray($styleArrayTotalCumplimiento1);
$objPHPExcel->getActiveSheet(1)->getStyle('C'.$nfila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$nfila++;

$hoja = 'Resumen';
$nIndicadores = count($indicadores);
//	Set the Labels for each data series we want to plot
//		Datatype
//		Cell reference for data
//		Format Code
//		Number of datapoints in series
//		Data values
//		Data Marker
$dataseriesLabels = array(
    new PHPExcel_Chart_DataSeriesValues('String', $hoja.'!$B$'.($nDatos-1), NULL, 1),	//	% INDICADOR
    new PHPExcel_Chart_DataSeriesValues('String', $hoja.'!$C$'.($nDatos-1), NULL, 1)	//	% CUMPLIMIENTO
);
//	Set the X-Axis Labels
//		Datatype
//		Cell reference for data
//		Format Code
//		Number of datapoints in series
//		Data values
//		Data Marker
$xAxisTickValues = array(
    new PHPExcel_Chart_DataSeriesValues('String', $hoja.'!$A$'.$nDatos.':$A$'.($nDatos+$nIndicadores-1), NULL, $nIndicadores),	//	Q1 to Q4
);
//	Set the Data values for each data series we want to plot
//		Datatype
//		Cell reference for data
//		Format Code
//		Number of datapoints in series
//		Data values
//		Data Marker
$dataSeriesValues = array(
    new PHPExcel_Chart_DataSeriesValues('Number', $hoja.'!$B$'.$nDatos.':$B$'.($nDatos+$nIndicadores-1), NULL, $nIndicadores),
    new PHPExcel_Chart_DataSeriesValues('Number', $hoja.'!$C$'.$nDatos.':$C$'.($nDatos+$nIndicadores-1), NULL, $nIndicadores)
);

//	Build the dataseries
$series = new PHPExcel_Chart_DataSeries(
    PHPExcel_Chart_DataSeries::TYPE_BARCHART_3D,		// plotType
    PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
    range(0, count($dataSeriesValues)-1),			// plotOrder
    $dataseriesLabels,								// plotLabel
    $xAxisTickValues,								// plotCategory
    $dataSeriesValues								// plotValues
);
//	Set additional dataseries parameters
//		Make it a horizontal bar rather than a vertical column graph
$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

$layout1 = new PHPExcel_Chart_Layout();
$layout1->setShowVal(TRUE);      // Initializing the data labels with Values
//$layout1->setManual3dAlign(true);
//$layout1->setXRotation(20);
//$layout1->setYRotation(20);
//$layout1->setPerspective(15);
//$layout1->setRightAngleAxes(TRUE);

//	Set the series in the plot area
$plotarea = new PHPExcel_Chart_PlotArea($layout1, array($series));
//	Set the chart legend
$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title = new PHPExcel_Chart_Title('Cumplimiento Indicadores (Porcentaje)');
$yAxisLabel = new PHPExcel_Chart_Title('% 100');
$xAxisLabel = new PHPExcel_Chart_Title('Indicadores');

//	Create the chart
$chart = new PHPExcel_Chart(
    'indicadores',		// name
    $title,			// title
    $legend,		// legend
    $plotarea,		// plotArea
    true,			// plotVisibleOnly
    0,				// displayBlanksAs
    $xAxisLabel,			// xAxisLabel
    NULL		// yAxisLabel
);

//	Set the position where the chart should appear in the worksheet$nfila
$chart->setTopLeftPosition('A'.$nfila);
$chart->setBottomRightPosition('G'.($nfila+20));

//	Add the chart to the worksheet
$objPHPExcel->getActiveSheet(1)->addChart($chart);

//	Set the Labels for each data series we want to plot
//		Datatype
//		Cell reference for data
//		Format Code
//		Number of datapoints in series
//		Data values
//		Data Marker
$dataSeriesLabels1 = array(
    new PHPExcel_Chart_DataSeriesValues('String', $hoja.'!$C$6', NULL, 1),   // Cabecera % Indicador
);
//	Set the X-Axis Labels
//		Datatype
//		Cell reference for data
//		Format Code
//		Number of datapoints in series
//		Data values
//		Data Marker
$xAxisTickValues1 = array(
    new PHPExcel_Chart_DataSeriesValues('String', $hoja.'!$A$'.($nDatos+$nIndicadores).':$A$'.($nDatos+$nIndicadores+1), NULL, 2),	//	Indicador I II III
);
//	Set the Data values for each data series we want to plot
//		Datatype
//		Cell reference for data
//		Format Code
//		Number of datapoints in series
//		Data values
//		Data Marker
$dataSeriesValues1 = array(
    new PHPExcel_Chart_DataSeriesValues('Number', $hoja.'!$C$'.($nDatos+$nIndicadores).':$C$'.($nDatos+$nIndicadores+1), NULL, 2),  // Ponderacion del indicador
);
//	Build the dataseries
$series1 = new PHPExcel_Chart_DataSeries(
    PHPExcel_Chart_DataSeries::TYPE_PIECHART_3D,				// plotType
    NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
    range(0, count($dataSeriesValues1)-1),					// plotOrder
    $dataSeriesLabels1,										// plotLabel
    $xAxisTickValues1,										// plotCategory
    $dataSeriesValues1										// plotValues
);
//	Set up a layout object for the Pie chart
$layout1 = new PHPExcel_Chart_Layout();
$layout1->setShowVal(FALSE);
$layout1->setShowPercent(TRUE);
//	Set the series in the plot area
$plotArea1 = new PHPExcel_Chart_PlotArea($layout1, array($series1));
//	Set the chart legend
$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
$title1 = new PHPExcel_Chart_Title('% CUMPLIMIENTO INDICADORES APS ');
//	Create the chart
$chart1 = new PHPExcel_Chart(
    'torta',		// name
    $title1,		// title
    $legend1,		// legend
    $plotArea1,		// plotArea
    true,			// plotVisibleOnly
    0,				// displayBlanksAs
    NULL,			// xAxisLabel
    NULL			// yAxisLabel		- Pie charts don't have a Y-Axis
);
//	Set the position where the chart should appear in the worksheet
$chart1->setTopLeftPosition('D'.($nDatos-1));
$chart1->setBottomRightPosition('G'.($nDatos+$nIndicadores+1));

//	Add the chart to the worksheet
$objPHPExcel->getActiveSheet(1)->addChart($chart1);


// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(1);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
$archivo = 'aps'.date('Y-m-d').'.xls';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setIncludeCharts(TRUE);
$objWriter->save('php://output');
exit;