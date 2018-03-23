<?php
// Modificación del límite en memoria para que permita generar el reporte
ini_set('memory_limit', '-1');
// error_reporting(-1);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Modelo que trae la gestión predial
$predios = $this->InformesDAO->obtener_informe_gestion_predial_ani(null);

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("CF")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Predial - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Anexo 5 - Sábana predial")
	->setDescription("Formato Sábana Predial")
	->setKeywords("formato sabana DEVIMED")		
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); 

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
// $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0,90); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0,70); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0,70); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,90); //Abajo

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered();

// Colores
$color_verde = array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '4F7F2C'));
$color_rojo = array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'FF0000'));
$color_naranja = array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'F7BF07'));
$color_gris = array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'D8D8D8'));

// Definición de variables para tamaños de columnas, para hacerlo más administrable
$col_numeral = 4;
$col_valor = 17;

// Estilos
$titulo_centrado_negrita = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

$bordes = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'argb' => '000000'
            )
        ),
    ),
);

/*
 * Definicion de la anchura de las columnas
 */
$columna = "A";
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(14); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(10); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(20); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(25); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(15); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(25); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(12); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(25); $columna++; // H
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(12); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++; // M
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(10); $columna++; // R
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(3); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(3); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(6); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(1); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(6); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(3); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(11); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(15); $columna++; // AA
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(12); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(12); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(12); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(12); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(12); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(12); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++; // AH
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++; // AN
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++; // AT
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++; // BI
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++; // BM
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++; // BS
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++; // BX
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++; // CC
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++; //CJ
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_numeral); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($col_valor); $columna++;
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(45); $columna++;

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A4:S4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:A8');
$objPHPExcel->getActiveSheet()->mergeCells('B5:B8');
$objPHPExcel->getActiveSheet()->mergeCells('C5:C8');
$objPHPExcel->getActiveSheet()->mergeCells('D5:D8');
$objPHPExcel->getActiveSheet()->mergeCells('E5:E8');
$objPHPExcel->getActiveSheet()->mergeCells('F5:F8');
$objPHPExcel->getActiveSheet()->mergeCells('G5:G8');
$objPHPExcel->getActiveSheet()->mergeCells('H5:H8');
$objPHPExcel->getActiveSheet()->mergeCells('I5:J6');
$objPHPExcel->getActiveSheet()->mergeCells('K5:K8');
$objPHPExcel->getActiveSheet()->mergeCells('L5:L8');
$objPHPExcel->getActiveSheet()->mergeCells('M5:M8');
$objPHPExcel->getActiveSheet()->mergeCells('N5:Q6');
$objPHPExcel->getActiveSheet()->mergeCells('N7:N8');
$objPHPExcel->getActiveSheet()->mergeCells('O7:O8');
$objPHPExcel->getActiveSheet()->mergeCells('P7:P8');
$objPHPExcel->getActiveSheet()->mergeCells('Q7:Q8');
$objPHPExcel->getActiveSheet()->mergeCells('R5:R8');
$objPHPExcel->getActiveSheet()->mergeCells('S5:S8');
$objPHPExcel->getActiveSheet()->mergeCells('T4:Y4');
$objPHPExcel->getActiveSheet()->mergeCells('U6:Y6');
$objPHPExcel->getActiveSheet()->mergeCells('U7:Y7');
$objPHPExcel->getActiveSheet()->mergeCells('U8:Y8');
$objPHPExcel->getActiveSheet()->mergeCells('Z4:Z8');
$objPHPExcel->getActiveSheet()->mergeCells('AA4:AA8');
$objPHPExcel->getActiveSheet()->mergeCells('AB4:AG5');
$objPHPExcel->getActiveSheet()->mergeCells('AB6:AB8');
$objPHPExcel->getActiveSheet()->mergeCells('AC6:AC8');
$objPHPExcel->getActiveSheet()->mergeCells('AD6:AD8');
$objPHPExcel->getActiveSheet()->mergeCells('AE6:AE8');
$objPHPExcel->getActiveSheet()->mergeCells('AF6:AF8');
$objPHPExcel->getActiveSheet()->mergeCells('AG6:AG8');
$objPHPExcel->getActiveSheet()->mergeCells('AH4:AM4');
$objPHPExcel->getActiveSheet()->mergeCells('AH5:AH8');
$objPHPExcel->getActiveSheet()->mergeCells('AI5:AI8');
$objPHPExcel->getActiveSheet()->mergeCells('AJ5:AM5');
$objPHPExcel->getActiveSheet()->mergeCells('AJ6:AJ8');
$objPHPExcel->getActiveSheet()->mergeCells('AK6:AK8');
$objPHPExcel->getActiveSheet()->mergeCells('AL6:AL8');
$objPHPExcel->getActiveSheet()->mergeCells('AM6:AM8');
$objPHPExcel->getActiveSheet()->mergeCells('AN4:AO4');
$objPHPExcel->getActiveSheet()->mergeCells('AN5:AN8');
$objPHPExcel->getActiveSheet()->mergeCells('AO5:AO8');
$objPHPExcel->getActiveSheet()->mergeCells('AP4:AS4');
$objPHPExcel->getActiveSheet()->mergeCells('AP5:AP8');
$objPHPExcel->getActiveSheet()->mergeCells('AQ5:AQ8');
$objPHPExcel->getActiveSheet()->mergeCells('AR5:AS5');
$objPHPExcel->getActiveSheet()->mergeCells('AR6:AR8');
$objPHPExcel->getActiveSheet()->mergeCells('AS6:AS8');
$objPHPExcel->getActiveSheet()->mergeCells('AT4:BH4');
$objPHPExcel->getActiveSheet()->mergeCells('AT5:AT8');
$objPHPExcel->getActiveSheet()->mergeCells('AU5:AU8');
$objPHPExcel->getActiveSheet()->mergeCells('AV5:AV8');
$objPHPExcel->getActiveSheet()->mergeCells('AW5:AW8');
$objPHPExcel->getActiveSheet()->mergeCells('AX5:AX8');
$objPHPExcel->getActiveSheet()->mergeCells('AY5:AY8');
$objPHPExcel->getActiveSheet()->mergeCells('AZ5:AZ8');
$objPHPExcel->getActiveSheet()->mergeCells('BA5:BA8');
$objPHPExcel->getActiveSheet()->mergeCells('BB5:BB8');
$objPHPExcel->getActiveSheet()->mergeCells('BC5:BC8');
$objPHPExcel->getActiveSheet()->mergeCells('BD5:BD8');
$objPHPExcel->getActiveSheet()->mergeCells('BE5:BE8');
$objPHPExcel->getActiveSheet()->mergeCells('BF5:BF8');
$objPHPExcel->getActiveSheet()->mergeCells('BG5:BH6');
$objPHPExcel->getActiveSheet()->mergeCells('BG7:BG8');
$objPHPExcel->getActiveSheet()->mergeCells('BH7:BH8');
$objPHPExcel->getActiveSheet()->mergeCells('BI4:BL4');
$objPHPExcel->getActiveSheet()->mergeCells('BI5:BI8');
$objPHPExcel->getActiveSheet()->mergeCells('BI5:BI8');
$objPHPExcel->getActiveSheet()->mergeCells('BJ5:BL6');
$objPHPExcel->getActiveSheet()->mergeCells('BJ7:BJ8');
$objPHPExcel->getActiveSheet()->mergeCells('BK7:BK8');
$objPHPExcel->getActiveSheet()->mergeCells('BL7:BL8');
$objPHPExcel->getActiveSheet()->mergeCells('BM4:BN4');
$objPHPExcel->getActiveSheet()->mergeCells('BO4:BR4');
$objPHPExcel->getActiveSheet()->mergeCells('BI5:BI8');
$objPHPExcel->getActiveSheet()->mergeCells('BJ5:BL6');
$objPHPExcel->getActiveSheet()->mergeCells('BJ7:BJ8');
$objPHPExcel->getActiveSheet()->mergeCells('BK7:BK8');
$objPHPExcel->getActiveSheet()->mergeCells('BL7:BL8');
$objPHPExcel->getActiveSheet()->mergeCells('BM5:BM8');
$objPHPExcel->getActiveSheet()->mergeCells('BN5:BN8');
$objPHPExcel->getActiveSheet()->mergeCells('BO5:BO8');
$objPHPExcel->getActiveSheet()->mergeCells('BP5:BP8');
$objPHPExcel->getActiveSheet()->mergeCells('BQ5:BQ8');
$objPHPExcel->getActiveSheet()->mergeCells('BR5:BR8');
$objPHPExcel->getActiveSheet()->mergeCells('BS4:BW4');
$objPHPExcel->getActiveSheet()->mergeCells('BS5:BS8');
$objPHPExcel->getActiveSheet()->mergeCells('BQ5:BQ8');
$objPHPExcel->getActiveSheet()->mergeCells('BT5:BT8');
$objPHPExcel->getActiveSheet()->mergeCells('BU5:BU8');
$objPHPExcel->getActiveSheet()->mergeCells('BV5:BV8');
$objPHPExcel->getActiveSheet()->mergeCells('BW5:BW8');
$objPHPExcel->getActiveSheet()->mergeCells('BX4:BZ4');
$objPHPExcel->getActiveSheet()->mergeCells('BX5:BX8');
$objPHPExcel->getActiveSheet()->mergeCells('BY5:BY8');
$objPHPExcel->getActiveSheet()->mergeCells('BZ5:BZ8');
$objPHPExcel->getActiveSheet()->mergeCells('CA4:CB4');
$objPHPExcel->getActiveSheet()->mergeCells('CA5:CA8');
$objPHPExcel->getActiveSheet()->mergeCells('CB5:CB8');
$objPHPExcel->getActiveSheet()->mergeCells('CC4:CI4');
$objPHPExcel->getActiveSheet()->mergeCells('CC5:CC8');
$objPHPExcel->getActiveSheet()->mergeCells('CD5:CD8');
$objPHPExcel->getActiveSheet()->mergeCells('CE5:CE8');
$objPHPExcel->getActiveSheet()->mergeCells('CF5:CF8');
$objPHPExcel->getActiveSheet()->mergeCells('CG5:CG8');
$objPHPExcel->getActiveSheet()->mergeCells('CH5:CH8');
$objPHPExcel->getActiveSheet()->mergeCells('CI5:CI8');
$objPHPExcel->getActiveSheet()->mergeCells('CJ4:CL4');
$objPHPExcel->getActiveSheet()->mergeCells('CJ5:CJ8');
$objPHPExcel->getActiveSheet()->mergeCells('CK5:CK8');
$objPHPExcel->getActiveSheet()->mergeCells('CL5:CL8');
$objPHPExcel->getActiveSheet()->mergeCells('CM4:CO4');
$objPHPExcel->getActiveSheet()->mergeCells('CM5:CM8');
$objPHPExcel->getActiveSheet()->mergeCells('CN5:CN8');
$objPHPExcel->getActiveSheet()->mergeCells('CO5:CO8');
$objPHPExcel->getActiveSheet()->mergeCells('CP4:CR4');
$objPHPExcel->getActiveSheet()->mergeCells('CP5:CP8');
$objPHPExcel->getActiveSheet()->mergeCells('CQ5:CQ8');
$objPHPExcel->getActiveSheet()->mergeCells('CR5:CR8');
$objPHPExcel->getActiveSheet()->mergeCells('CS4:CT4');
$objPHPExcel->getActiveSheet()->mergeCells('CS5:CS8');
$objPHPExcel->getActiveSheet()->mergeCells('CT5:CT8');
$objPHPExcel->getActiveSheet()->mergeCells('CU4:CV4');
$objPHPExcel->getActiveSheet()->mergeCells('CU5:CU8');
$objPHPExcel->getActiveSheet()->mergeCells('CV5:CV8');
$objPHPExcel->getActiveSheet()->mergeCells('CW4:CX4');
$objPHPExcel->getActiveSheet()->mergeCells('CW5:CW8');
$objPHPExcel->getActiveSheet()->mergeCells('CX5:CX8');
$objPHPExcel->getActiveSheet()->mergeCells('CY4:CY8');

//Estilo numérico
$objPHPExcel->getActiveSheet()->getStyle("E")->getNumberFormat()->setFormatCode("#,##0");
$objPHPExcel->getActiveSheet()->getStyle("R")->getNumberFormat()->setFormatCode("#,##0");
$objPHPExcel->getActiveSheet()->getStyle("S")->getNumberFormat()->setFormatCode("#,##0");
$objPHPExcel->getActiveSheet()->getStyle("AB:AG")->getNumberFormat()->setFormatCode("#,##0");
$objPHPExcel->getActiveSheet()->getStyle("AX:BF")->getNumberFormat()->setFormatCode("#,##0");
$objPHPExcel->getActiveSheet()->getStyle("CL")->getNumberFormat()->setFormatCode("#,##0");
$objPHPExcel->getActiveSheet()->getStyle("CO")->getNumberFormat()->setFormatCode("#,##0");
$objPHPExcel->getActiveSheet()->getStyle("CR")->getNumberFormat()->setFormatCode("#,##0");


/**
 * Definicion de la altura de las celdas
 */
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(50);

//Encabezados
$objPHPExcel->getActiveSheet()->getStyle('A4:CY8')->getFill()->applyFromArray($color_gris);
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Relación predios');
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '99CCFF')));
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Ficha');
$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Número');
$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Tramo');
$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Propietario');
$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Cédula o NIT.');
$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Dirección');
$objPHPExcel->getActiveSheet()->setCellValue('G5', 'Teléfono');
$objPHPExcel->getActiveSheet()->setCellValue('H5', 'Correo electrónico');
$objPHPExcel->getActiveSheet()->setCellValue('I5', 'Estado ambiental');
$objPHPExcel->getActiveSheet()->getStyle('I7')->getFill()->applyFromArray($color_rojo);
$objPHPExcel->getActiveSheet()->getStyle('I8')->getFill()->applyFromArray($color_verde);
$objPHPExcel->getActiveSheet()->setCellValue('J7', 'Sin licencia');
$objPHPExcel->getActiveSheet()->setCellValue('J8', 'Con licencia');
$objPHPExcel->getActiveSheet()->setCellValue('K5', 'Función del predio en el proyecto');
$objPHPExcel->getActiveSheet()->setCellValue('L5', 'Estado del predio en la obra');
$objPHPExcel->getActiveSheet()->setCellValue('M5', 'Estado de la vía');
$objPHPExcel->getActiveSheet()->setCellValue('N5', 'Abscisado');
$objPHPExcel->getActiveSheet()->setCellValue('N7', 'Inicial');
$objPHPExcel->getActiveSheet()->setCellValue('O7', 'Margen');
$objPHPExcel->getActiveSheet()->setCellValue('P7', 'Final');
$objPHPExcel->getActiveSheet()->setCellValue('Q7', 'Margen');
$objPHPExcel->getActiveSheet()->setCellValue('R5', 'Longitud efectiva');
$objPHPExcel->getActiveSheet()->setCellValue('S5', 'Longitud complementaria (obra)');
$objPHPExcel->getActiveSheet()->setCellValue('T4', 'Semáforo de disponibilidad predial');
$objPHPExcel->getActiveSheet()->getStyle('T4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'FFFFFF')));
$objPHPExcel->getActiveSheet()->getStyle('T6')->getFill()->applyFromArray($color_naranja);
$objPHPExcel->getActiveSheet()->getStyle('T7')->getFill()->applyFromArray($color_rojo);
$objPHPExcel->getActiveSheet()->getStyle('T8')->getFill()->applyFromArray($color_verde);
$objPHPExcel->getActiveSheet()->setCellValue('U5', 'EX');
$objPHPExcel->getActiveSheet()->setCellValue('V5', 'IZ');
$objPHPExcel->getActiveSheet()->setCellValue('U6', 'No disp. - Negocio');
$objPHPExcel->getActiveSheet()->setCellValue('U7', 'No disp. - Exprop.');
$objPHPExcel->getActiveSheet()->setCellValue('U8', 'Disponible');
$objPHPExcel->getActiveSheet()->setCellValue('X5', 'DER');
$objPHPExcel->getActiveSheet()->setCellValue('Y5', 'EX');
$objPHPExcel->getActiveSheet()->setCellValue('Z4', 'Meta contractual');
$objPHPExcel->getActiveSheet()->setCellValue('AA4', 'Disponibilidad según cruce ambiental y predial');
$objPHPExcel->getActiveSheet()->getStyle('AB4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'FFCC00')));
$objPHPExcel->getActiveSheet()->setCellValue('AB4', 'Áreas prediales');
$objPHPExcel->getActiveSheet()->setCellValue('AB6', 'Total');
$objPHPExcel->getActiveSheet()->setCellValue('AC6', 'Requerida');
$objPHPExcel->getActiveSheet()->setCellValue('AD6', 'Remanente');
$objPHPExcel->getActiveSheet()->setCellValue('AE6', 'Sobrante');
$objPHPExcel->getActiveSheet()->setCellValue('AF6', 'Construida principal');
$objPHPExcel->getActiveSheet()->setCellValue('AG6', 'Construida requerida');
$objPHPExcel->getActiveSheet()->setCellValue('AH4', 'Datos jurídicos');
$objPHPExcel->getActiveSheet()->getStyle('AH4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'CC99CC')));
$objPHPExcel->getActiveSheet()->setCellValue('AH5', 'Matrícula inmobiliaria');
$objPHPExcel->getActiveSheet()->setCellValue('AI5', 'Número catastral');
$objPHPExcel->getActiveSheet()->setCellValue('AJ5', 'Escritura pública');
$objPHPExcel->getActiveSheet()->setCellValue('AJ6', 'Número');
$objPHPExcel->getActiveSheet()->setCellValue('AK6', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('AL6', 'Notaría');
$objPHPExcel->getActiveSheet()->setCellValue('AM6', 'Ciudad');
$objPHPExcel->getActiveSheet()->setCellValue('AN4', 'Estudio de títulos');
$objPHPExcel->getActiveSheet()->getStyle('AN4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'FFCC99')));
$objPHPExcel->getActiveSheet()->setCellValue('AN5', '1');
$objPHPExcel->getActiveSheet()->setCellValue('AO5', 'Fecha de estudio');
$objPHPExcel->getActiveSheet()->setCellValue('AP4', 'Ficha predial');
$objPHPExcel->getActiveSheet()->getStyle('AP4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'FFFF85')));
$objPHPExcel->getActiveSheet()->setCellValue('AP5', '2');
$objPHPExcel->getActiveSheet()->setCellValue('AQ5', 'Fecha de elaboración');
$objPHPExcel->getActiveSheet()->setCellValue('AR5', 'Aprobación de interventoría');
$objPHPExcel->getActiveSheet()->setCellValue('AR6', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('AS6', 'Nro. de oficio');
$objPHPExcel->getActiveSheet()->setCellValue('AT4', 'Avalúo comercial corporativo');
$objPHPExcel->getActiveSheet()->getStyle('AT4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '66FF99')));
$objPHPExcel->getActiveSheet()->setCellValue('AT5', '3');
$objPHPExcel->getActiveSheet()->setCellValue('AU5', 'Fecha de remisión de insumos');
$objPHPExcel->getActiveSheet()->setCellValue('AV5', '4');
$objPHPExcel->getActiveSheet()->setCellValue('AW5', 'Fecha de avalúo');
$objPHPExcel->getActiveSheet()->setCellValue('AX5', 'Valor unitario m2 terreno');
$objPHPExcel->getActiveSheet()->setCellValue('AY5', 'Valor terreno requerido');
$objPHPExcel->getActiveSheet()->setCellValue('AZ5', 'Valor terreno área remanente');
$objPHPExcel->getActiveSheet()->setCellValue('BA5', 'Valor construcción');
$objPHPExcel->getActiveSheet()->setCellValue('BB5', 'Valor cultivos y especies');
$objPHPExcel->getActiveSheet()->setCellValue('BC5', 'Valor construcciones anexas');
$objPHPExcel->getActiveSheet()->setCellValue('BD5', 'Valor total avalúo (sin plan de compensaciones socioeconómicas)');
$objPHPExcel->getActiveSheet()->setCellValue('BE5', 'Valor plan de conmprensaciones económicas');
$objPHPExcel->getActiveSheet()->setCellValue('BF5', 'Valor total');
$objPHPExcel->getActiveSheet()->setCellValue('BG5', 'Aprobación interventoría');
$objPHPExcel->getActiveSheet()->setCellValue('BG7', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('BH7', 'Nro. de oficio');
$objPHPExcel->getActiveSheet()->setCellValue('BI4', 'Oferta de compra');
$objPHPExcel->getActiveSheet()->getStyle('BI4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'CCFFFF')));
$objPHPExcel->getActiveSheet()->setCellValue('BI5', '5');
$objPHPExcel->getActiveSheet()->setCellValue('BJ5', 'Oferta de compra');
$objPHPExcel->getActiveSheet()->setCellValue('BJ7', 'Fecha de oficio de oferta');
$objPHPExcel->getActiveSheet()->setCellValue('BK7', 'Nro. de oficio');
$objPHPExcel->getActiveSheet()->setCellValue('BL7', 'Valor oferta');
$objPHPExcel->getActiveSheet()->setCellValue('BM4', 'Notificación oferta');
$objPHPExcel->getActiveSheet()->getStyle('BM4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'CC99FF')));
$objPHPExcel->getActiveSheet()->setCellValue('BM5', '6');
$objPHPExcel->getActiveSheet()->setCellValue('BN5', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('BO4', 'Registro oferta');
$objPHPExcel->getActiveSheet()->getStyle('BO4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'FF99CC')));
$objPHPExcel->getActiveSheet()->setCellValue('BO5', '7');
$objPHPExcel->getActiveSheet()->setCellValue('BN5', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('BO5', '7');
$objPHPExcel->getActiveSheet()->setCellValue('BP5', 'Nro. oficio');
$objPHPExcel->getActiveSheet()->setCellValue('BQ5', 'Fecha oficio');
$objPHPExcel->getActiveSheet()->setCellValue('BR5', 'Fecha registro');
$objPHPExcel->getActiveSheet()->setCellValue('BS4', 'Alcance de la oferta');
$objPHPExcel->getActiveSheet()->getStyle('BS4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'FFCC00')));
$objPHPExcel->getActiveSheet()->setCellValue('BS5', '8');
$objPHPExcel->getActiveSheet()->setCellValue('BT5', 'Valor');
$objPHPExcel->getActiveSheet()->setCellValue('BU5', 'Nro. oficio');
$objPHPExcel->getActiveSheet()->setCellValue('BV5', 'Fecha oficio');
$objPHPExcel->getActiveSheet()->setCellValue('BW5', 'Fecha notificación');
$objPHPExcel->getActiveSheet()->setCellValue('BX4', 'Promesa de compraventa');
$objPHPExcel->getActiveSheet()->getStyle('BX4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '99CC00')));
$objPHPExcel->getActiveSheet()->setCellValue('BX5', '9');
$objPHPExcel->getActiveSheet()->setCellValue('BY5', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('BZ5', 'Valor');
$objPHPExcel->getActiveSheet()->setCellValue('CA4', 'Acta de entrega del predio');
$objPHPExcel->getActiveSheet()->getStyle('CA4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '33CCCC')));
$objPHPExcel->getActiveSheet()->setCellValue('CA5', '9');
$objPHPExcel->getActiveSheet()->setCellValue('CB5', 'Fecha de entrega');
$objPHPExcel->getActiveSheet()->setCellValue('CC4', 'Escritura');
$objPHPExcel->getActiveSheet()->getStyle('CC4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '00CCFF')));
$objPHPExcel->getActiveSheet()->setCellValue('CC5', '11');
$objPHPExcel->getActiveSheet()->setCellValue('CD5', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('CE5', 'Valor');
$objPHPExcel->getActiveSheet()->setCellValue('CF5', 'Número');
$objPHPExcel->getActiveSheet()->setCellValue('CG5', 'Notaría');
$objPHPExcel->getActiveSheet()->setCellValue('CH5', 'Ciudad');
$objPHPExcel->getActiveSheet()->setCellValue('CI5', 'Folio matrícula');
$objPHPExcel->getActiveSheet()->setCellValue('CJ4', 'Primer pago a propietarios');
$objPHPExcel->getActiveSheet()->getStyle('CJ4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '00CCFF')));
$objPHPExcel->getActiveSheet()->setCellValue('CJ5', '12');
$objPHPExcel->getActiveSheet()->setCellValue('CK5', 'Fecha de pago');
$objPHPExcel->getActiveSheet()->setCellValue('CL5', 'Valor');
$objPHPExcel->getActiveSheet()->setCellValue('CM4', 'Segundo pago a propietarios');
$objPHPExcel->getActiveSheet()->getStyle('CM4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '00CCFF')));
$objPHPExcel->getActiveSheet()->setCellValue('CM5', '12');
$objPHPExcel->getActiveSheet()->setCellValue('CN5', 'Fecha de pago');
$objPHPExcel->getActiveSheet()->setCellValue('CO5', 'Valor');;
$objPHPExcel->getActiveSheet()->setCellValue('CP4', 'Tercer pago a propietarios (cuando aplique)');
$objPHPExcel->getActiveSheet()->getStyle('CP4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '00CCFF')));
$objPHPExcel->getActiveSheet()->setCellValue('CP5', '12');
$objPHPExcel->getActiveSheet()->setCellValue('CQ5', 'Fecha de pago');
$objPHPExcel->getActiveSheet()->setCellValue('CR5', 'Valor');;
$objPHPExcel->getActiveSheet()->setCellValue('CS4', 'Expediente entregado para archivo en la ANI');
$objPHPExcel->getActiveSheet()->getStyle('CS4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => '99CCFF')));
$objPHPExcel->getActiveSheet()->setCellValue('CS5', '12');
$objPHPExcel->getActiveSheet()->setCellValue('CT5', 'Fecha de entrega');
$objPHPExcel->getActiveSheet()->setCellValue('CU4', 'Predio en expropiación');
$objPHPExcel->getActiveSheet()->getStyle('CU4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'FFFF00')));
$objPHPExcel->getActiveSheet()->setCellValue('CU5', '13');
$objPHPExcel->getActiveSheet()->setCellValue('CV5', 'Fecha de entrega');
$objPHPExcel->getActiveSheet()->setCellValue('CW4', 'Disponibilidad del predio para obra');
$objPHPExcel->getActiveSheet()->getStyle('CW4')->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => 'FFFF00')));
$objPHPExcel->getActiveSheet()->setCellValue('CW5', '17');
$objPHPExcel->getActiveSheet()->setCellValue('CX5', 'Fecha de entrega');
$objPHPExcel->getActiveSheet()->setCellValue('CY4', 'Observaciones');

// Aplicación de estilos a la cabecera
$objPHPExcel->getActiveSheet()->getStyle("A1:CY8")->applyFromArray($titulo_centrado_negrita);

// Fila inicial
$fila = 9;

// Recorrido de los predios
foreach ($predios as $predio) {
	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("I$fila:J$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("T$fila:V$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("X$fila:Y$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("AP$fila:AQ$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("AT$fila:AU$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("AV$fila:AW$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("BI$fila:BJ$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("BM$fila:BN$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("BO$fila:BP$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("BS$fila:BT$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("BX$fila:BY$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("CC$fila:CD$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("CJ$fila:CK$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("CM$fila:CN$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("CP$fila:CQ$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("CS$fila:CT$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("CU$fila:CV$fila");
	$objPHPExcel->getActiveSheet()->mergeCells("CW$fila:CX$fila");


	// Si el estado del predio es 1
	if ($predio->estado_predio == 1) {
		$estado_predio = "Disponible";
	} else {
		$estado_predio = "No disponible";
	} // if

	// Para el abscisado inicial
	$ms_inicial = substr($predio->abscisa_inicial, -3);
	$kms_inicial = substr($predio->abscisa_inicial, 0, strlen($predio->abscisa_inicial) - 3);
	if($kms_inicial == "") {
		$kms_inicial = "0";
	}

	// Para el abscisado final
	$ms_final = substr($predio->abscisa_final, -3);
	$kms_final = substr($predio->abscisa_final, 0, strlen($predio->abscisa_final) - 3);
	if($kms_final == "") {
		$kms_final = "0";
	}

	// Longitud efectiva
	$longitud_efectiva = $predio->abscisa_final - $predio->abscisa_inicial;

	// Si el estado ambiental es 1
	if ($predio->estado_ambiental == 1) {
		// Color verde
		$estado_ambiental = $color_verde;
	} else {
		// Color rojo
		$estado_ambiental = $color_rojo;
	} // if

	// Si la disponibilidad izquierda es 1
	if ($predio->disponibilidad_izquierda == 1) {
		// Color verde
		$disponibilidad_izquierda = $color_verde;
	} else if($predio->disponibilidad_izquierda == 0) {
		// Color rojo
		$disponibilidad_izquierda = $color_rojo;
	} else {
		// Color naranja
		$disponibilidad_izquierda = $color_naranja;
	} // if

	// Si la disponibilidad derecha es 1
	if ($predio->disponibilidad_derecha == 1) {
		// Color verde
		$disponibilidad_derecha = $color_verde;
	} else if($predio->disponibilidad_derecha == 0) {
		// Color rojo
		$disponibilidad_derecha = $color_rojo;
	} else {
		// Color naranja
		$disponibilidad_derecha = $color_naranja;
	} // if

	$ficha = explode('-', $predio->ficha_predial); // Se divide la ficha para sacar unidad y número

	if (count($ficha) > 2) {
		// Se pone en vez de F o M, Área
		$nombre_ficha = "$ficha[0]-$ficha[1] Área $ficha[3]";
	} else {
		// Ficha normal
		$nombre_ficha = $predio->ficha_predial;
	} // if

	// Contenido
	$objPHPExcel->getActiveSheet()->setCellValue("A$fila", $nombre_ficha);
	$objPHPExcel->getActiveSheet()->setCellValue("B$fila", $predio->numero);
	$objPHPExcel->getActiveSheet()->setCellValue("C$fila", $predio->tramo);
	$objPHPExcel->getActiveSheet()->setCellValue("D$fila", $predio->nombre_propietario);
	$objPHPExcel->getActiveSheet()->setCellValue("E$fila", $predio->documento_propietario);
	$objPHPExcel->getActiveSheet()->setCellValue("F$fila", $predio->direccion_propietario);
	$objPHPExcel->getActiveSheet()->setCellValue("G$fila", $predio->telefono_propietario);
	$objPHPExcel->getActiveSheet()->setCellValue("H$fila", $predio->email_propietario);
	$objPHPExcel->getActiveSheet()->getStyle("I$fila")->getFill()->applyFromArray($estado_ambiental);
	$objPHPExcel->getActiveSheet()->setCellValue("K$fila", $predio->funcion_predio);
	$objPHPExcel->getActiveSheet()->setCellValue("L$fila", $estado_predio);
	$objPHPExcel->getActiveSheet()->setCellValue("M$fila", $predio->estado_via);
	$objPHPExcel->getActiveSheet()->setCellValue("N$fila", "PR $kms_inicial + $ms_inicial");
	$objPHPExcel->getActiveSheet()->setCellValue("O$fila", $predio->margen_inicial);
	$objPHPExcel->getActiveSheet()->setCellValue("P$fila", "PR $kms_final + $ms_final");
	$objPHPExcel->getActiveSheet()->setCellValue("Q$fila", $predio->margen_final);
	$objPHPExcel->getActiveSheet()->setCellValue("R$fila", $longitud_efectiva);
	$objPHPExcel->getActiveSheet()->setCellValue("S$fila", "");
	$objPHPExcel->getActiveSheet()->getStyle("T$fila")->getFill()->applyFromArray($disponibilidad_izquierda);
	$objPHPExcel->getActiveSheet()->getStyle("X$fila")->getFill()->applyFromArray($disponibilidad_derecha);
	$objPHPExcel->getActiveSheet()->setCellValue("Z$fila", $predio->meta_contractual);
	$objPHPExcel->getActiveSheet()->setCellValue("AA$fila", "");
	$objPHPExcel->getActiveSheet()->setCellValue("AB$fila", $predio->area_total_catastral);
	$objPHPExcel->getActiveSheet()->setCellValue("AC$fila", $predio->area_requerida);
	$objPHPExcel->getActiveSheet()->setCellValue("AD$fila", $predio->area_residual);
	$objPHPExcel->getActiveSheet()->setCellValue("AE$fila", "");
	$objPHPExcel->getActiveSheet()->setCellValue("AF$fila", $predio->area_construida);
	$objPHPExcel->getActiveSheet()->setCellValue("AG$fila", $predio->area_cons_requerida);
	$objPHPExcel->getActiveSheet()->setCellValue("AH$fila", $predio->matricula);
	$objPHPExcel->getActiveSheet()->setCellValue("AI$fila", $predio->no_catastral);
	$objPHPExcel->getActiveSheet()->setCellValue("AJ$fila", $predio->escritura_orig);
	$objPHPExcel->getActiveSheet()->setCellValue("AK$fila", $predio->fecha_escritura);
	$objPHPExcel->getActiveSheet()->setCellValue("AL$fila", $predio->no_notaria);
	$objPHPExcel->getActiveSheet()->setCellValue("AM$fila", $predio->ciudad);
	$objPHPExcel->getActiveSheet()->setCellValue("AO$fila", $predio->fecha_estudio);
	$objPHPExcel->getActiveSheet()->setCellValue("AT$fila", $predio->fecha_remision_insumos);
	$objPHPExcel->getActiveSheet()->setCellValue("AV$fila", $predio->f_recibo_av);
	$objPHPExcel->getActiveSheet()->setCellValue("AX$fila", $predio->valor_mtr);
	$objPHPExcel->getActiveSheet()->setCellValue("AY$fila", $predio->valor_total_terr);
	$objPHPExcel->getActiveSheet()->setCellValue("CF$fila", $predio->escritura_orig);
	$objPHPExcel->getActiveSheet()->setCellValue("CG$fila", $predio->no_notaria);
	$objPHPExcel->getActiveSheet()->setCellValue("CH$fila", $predio->ciudad);

	// Se consulta el primer pago
	$pago = $this->PagosDAO->obtener_pago_numero($predio->ficha_predial, 1);

	// Si existe
	if ($pago) {
		// Datos del primer pago
		$objPHPExcel->getActiveSheet()->setCellValue("CJ$fila", $pago->fecha_pago);	
		$objPHPExcel->getActiveSheet()->setCellValue("CL$fila", $pago->valor);	
	}

	// Se consulta el segundo pago
	$pago = $this->PagosDAO->obtener_pago_numero($predio->ficha_predial, 2);

	// Si existe
	if ($pago) {
		// Datos del segundo pago
		$objPHPExcel->getActiveSheet()->setCellValue("CM$fila", $pago->fecha_pago);	
		$objPHPExcel->getActiveSheet()->setCellValue("CO$fila", $pago->valor);	
	}

	// Se consulta el primer pago
	$pago = $this->PagosDAO->obtener_pago_numero($predio->ficha_predial, 3);

	// Si existe
	if ($pago) {
		// Datos del primer pago
		$objPHPExcel->getActiveSheet()->setCellValue("CP$fila", $pago->fecha_pago);	
		$objPHPExcel->getActiveSheet()->setCellValue("CR$fila", $pago->valor);	
	}

	$objPHPExcel->getActiveSheet()->setCellValue("CY$fila", $predio->observacion);
	



	// Aumento de fila
	$fila++;
} // foreach

// Reducción de fila
$fila--;

// Bordes
$objPHPExcel->getActiveSheet()->getStyle("A4:CY$fila")->applyFromArray($bordes);


//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Sábana predial");


//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Sábana predial.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>