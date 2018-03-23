<?php
// Se obtiene el número de ficha desde la URL
$ficha = $this->uri->segment(3);

// Se hace la consulta
$predio = $this->InformesDAO->obtener_informe_gestion_predial_ani($ficha);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Concesión Vías del Nus - VINUS S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Predial Vinus - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Gestión predial - Formato ANI")
    ->setCategory("Reporte");

/*********************************************************************
**************************** Ficha predial ***************************
*********************************************************************/
//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Tahoma'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10); //Tamaño
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(77);

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
// $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.10); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.70); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.80); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,90); //Abajo

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered();
$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Ocultar la cuadrícula:
$objPHPExcel->getActiveSheet()->setShowGridlines(false);

/*******************************************************
 *********************** Estilos ***********************
 *******************************************************/
$centrado = array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER ) ); // Alineación centrada
$negrita = array( 'font' => array( 'bold' => true ) ); // Negrita
$tamanio8 = array ( 'font' => array( 'size' => 8 ) );// Tamaño de fuente 8
$tamanio9 = array ( 'font' => array( 'size' => 9 ) );// Tamaño de fuente 9
$tamanio11 = array ( 'font' => array( 'size' => 11 ) );// Tamaño de fuente 11
$tamanio13 = array ( 'font' => array( 'size' => 13 ) );// Tamaño de fuente 14
$tamanio14 = array ( 'font' => array( 'size' => 14 ) );// Tamaño de fuente 14
$rojo = array( 'font' => array ( 'color' => array( 'argb' => 'FF0F0F' ) ) );
$arial = array( 'font' => array( 'name' => 'Arial' ) ); // Arial

$relleno_gris = array(
	'fill' => array(
	    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	    'rotation' => 90,
	    'startcolor' => array(
  	  		'argb' => 'DBDBDB'
        ),
	    'endcolor' => array(
			'argb' => 'DBDBDB'
    	),
    ),
);

$borde_negrita_externo = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK,
			'color' => array('argb' => '000000'),
		),
	),
);

$borde_puntos_externo = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_HAIR,
			'color' => array('argb' => '000000'),
		),
	),
);

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(2);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(1);

//Tamaño de celdas
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(6);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(8);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(7);
$objPHPExcel->getActiveSheet()->getRowDimension(11)->setRowHeight(7);
$objPHPExcel->getActiveSheet()->getRowDimension(14)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(15)->setRowHeight(7);
$objPHPExcel->getActiveSheet()->getRowDimension(17)->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getRowDimension(19)->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getRowDimension(20)->setRowHeight(11);
$objPHPExcel->getActiveSheet()->getRowDimension(22)->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getRowDimension(23)->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getRowDimension(25)->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getRowDimension(27)->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getRowDimension(29)->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getRowDimension(31)->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getRowDimension(33)->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getRowDimension(34)->setRowHeight(3);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:I14');
$objPHPExcel->getActiveSheet()->mergeCells('J1:O7');
$objPHPExcel->getActiveSheet()->mergeCells('J8:O11');
$objPHPExcel->getActiveSheet()->mergeCells('J12:O14');
$objPHPExcel->getActiveSheet()->mergeCells('Q2:U2');
$objPHPExcel->getActiveSheet()->mergeCells('Q3:U3');
$objPHPExcel->getActiveSheet()->mergeCells('Q5:S5');
$objPHPExcel->getActiveSheet()->mergeCells('V2:AD2');
$objPHPExcel->getActiveSheet()->mergeCells('V3:AD3');
$objPHPExcel->getActiveSheet()->mergeCells('Q12:S12');
$objPHPExcel->getActiveSheet()->mergeCells('Q13:S13');
$objPHPExcel->getActiveSheet()->mergeCells('W12:Y12');
$objPHPExcel->getActiveSheet()->mergeCells('W5:Y10');
$objPHPExcel->getActiveSheet()->mergeCells('Z5:AD10');
$objPHPExcel->getActiveSheet()->mergeCells('S8:U9');
$objPHPExcel->getActiveSheet()->mergeCells('W13:Y13');
$objPHPExcel->getActiveSheet()->mergeCells('AB12:AB13');
$objPHPExcel->getActiveSheet()->mergeCells('AC12:AD13');
$objPHPExcel->getActiveSheet()->mergeCells('B16:N16');
$objPHPExcel->getActiveSheet()->mergeCells('B18:N20');
$objPHPExcel->getActiveSheet()->mergeCells('Q16:T16');
$objPHPExcel->getActiveSheet()->mergeCells('Q18:T18');
$objPHPExcel->getActiveSheet()->mergeCells('Q20:T20');
$objPHPExcel->getActiveSheet()->mergeCells('U16:Z16');
$objPHPExcel->getActiveSheet()->mergeCells('U18:Z18');
$objPHPExcel->getActiveSheet()->mergeCells('U20:Z20');
$objPHPExcel->getActiveSheet()->mergeCells('AB16:AD16');
$objPHPExcel->getActiveSheet()->mergeCells('AB17:AD18');
$objPHPExcel->getActiveSheet()->mergeCells('AB20:AD20');
$objPHPExcel->getActiveSheet()->mergeCells('AB21:AD21');
$objPHPExcel->getActiveSheet()->mergeCells('B24:E24');
$objPHPExcel->getActiveSheet()->mergeCells('B26:E26');
$objPHPExcel->getActiveSheet()->mergeCells('B28:E28');
$objPHPExcel->getActiveSheet()->mergeCells('B30:E30');
$objPHPExcel->getActiveSheet()->mergeCells('J24:N24');
$objPHPExcel->getActiveSheet()->mergeCells('J26:N26');
$objPHPExcel->getActiveSheet()->mergeCells('J28:N28');
$objPHPExcel->getActiveSheet()->mergeCells('O24:Q24');
$objPHPExcel->getActiveSheet()->mergeCells('O26:Q26');
$objPHPExcel->getActiveSheet()->mergeCells('O28:Q28');
$objPHPExcel->getActiveSheet()->mergeCells('O30:Q30');
$objPHPExcel->getActiveSheet()->mergeCells('R24:T24');
$objPHPExcel->getActiveSheet()->mergeCells('R26:T26');
$objPHPExcel->getActiveSheet()->mergeCells('R28:T28');
$objPHPExcel->getActiveSheet()->mergeCells('R30:T30');
$objPHPExcel->getActiveSheet()->mergeCells('R32:T32');
$objPHPExcel->getActiveSheet()->mergeCells('U24:V24');
$objPHPExcel->getActiveSheet()->mergeCells('U26:V26');
$objPHPExcel->getActiveSheet()->mergeCells('U28:V28');
$objPHPExcel->getActiveSheet()->mergeCells('U30:V30');
$objPHPExcel->getActiveSheet()->mergeCells('U32:V32');
$objPHPExcel->getActiveSheet()->mergeCells('W24:AD24');
$objPHPExcel->getActiveSheet()->mergeCells('W26:AD26');
$objPHPExcel->getActiveSheet()->mergeCells('W28:AD28');
$objPHPExcel->getActiveSheet()->mergeCells('W30:AD30');
$objPHPExcel->getActiveSheet()->mergeCells('W32:AD32');
$objPHPExcel->getActiveSheet()->mergeCells('A35:K35');
$objPHPExcel->getActiveSheet()->mergeCells('B36:F36');
$objPHPExcel->getActiveSheet()->mergeCells('I36:J36');
$objPHPExcel->getActiveSheet()->mergeCells('N35:Z36');
$objPHPExcel->getActiveSheet()->mergeCells('M35:M36');
$objPHPExcel->getActiveSheet()->mergeCells('AB35:AB36');
$objPHPExcel->getActiveSheet()->mergeCells('AD35:AD36');
$objPHPExcel->getActiveSheet()->mergeCells('T5:U5');
$objPHPExcel->getActiveSheet()->mergeCells('F24:I24');
$objPHPExcel->getActiveSheet()->mergeCells('F26:I26');
$objPHPExcel->getActiveSheet()->mergeCells('F28:I28');
$objPHPExcel->getActiveSheet()->mergeCells('F30:I30');

/**
 * Aplicacion de los estilos
 */
// Borde externo en negrita
$objPHPExcel->getActiveSheet()->getStyle('A1:I14')->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle('J1:O14')->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle('P1:AE14')->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle('A15:O22')->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle('P15:AE22')->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle('A23:AE33')->applyFromArray($borde_negrita_externo);


// Borde externo punteado
$objPHPExcel->getActiveSheet()->getStyle('T5:U5')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('V2:AD2')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('V3:AD3')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('Z5:AD10')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('T12')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U12')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('S8:U9')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('T13')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U13')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('Z12')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('Z13')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("AC12:AD13")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U16:Z16')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U18:Z18')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U20:Z20')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('AB16:AD16')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('AB17:AD18')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('AB20:AD20')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('AB21:AD21')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('B18:N20')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('F24:I24')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('F26:I26')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('F28:I28')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('F30:I30')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('O24:Q24')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('O26:Q26')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('O28:Q28')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U24:V24')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U26:V26')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U28:V28')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U30:V30')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('U32:V32')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('W24:AD24')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('W26:AD26')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('W28:AD28')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('W30:AD30')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('W32:AD32')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('Z12')->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle('Z13')->applyFromArray($borde_puntos_externo);



/*******************************************************
 ******************* Estilo de celdas ******************
 *******************************************************/
$objPHPExcel->getActiveSheet()->getStyle("J1:O14")->applyFromArray($tamanio11);
$objPHPExcel->getActiveSheet()->getStyle("J1:O14")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("J1:O14")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("J12")->applyFromArray($rojo);
$objPHPExcel->getActiveSheet()->getStyle("Q2:AD3")->applyFromArray($tamanio8);
$objPHPExcel->getActiveSheet()->getStyle("Q2:AD3")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("Q2:AD3")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("Q5")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("Q9:Q13")->applyFromArray($arial);
$objPHPExcel->getActiveSheet()->getStyle("Q9:Q13")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("Q9:Q13")->applyFromArray($tamanio8);
$objPHPExcel->getActiveSheet()->getStyle('W12')->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle('W13')->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("AB12")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("AB12")->applyFromArray($tamanio9);
$objPHPExcel->getActiveSheet()->getStyle("W5")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("W5")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("W5")->applyFromArray($tamanio8);
$objPHPExcel->getActiveSheet()->getStyle("B16")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("B16")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("B18")->applyFromArray($arial);
$objPHPExcel->getActiveSheet()->getStyle("B18")->applyFromArray($tamanio11);
$objPHPExcel->getActiveSheet()->getStyle("B18")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("Q16:S20")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("U16:Z20")->applyFromArray($tamanio9);
$objPHPExcel->getActiveSheet()->getStyle("U16:Z20")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("AB16")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("AB16:AD21")->applyFromArray($arial);
$objPHPExcel->getActiveSheet()->getStyle("AB16:AD21")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("AB16:AD21")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("AB16:AD21")->applyFromArray($tamanio9);
$objPHPExcel->getActiveSheet()->getStyle("AB20")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("B24:B30")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("J24:N30")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("O24:O30")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("U24:AD24")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("U24:AD32")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("R24:R32")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("A35:AD35")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("A35:AD35")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("A35:AD35")->applyFromArray($tamanio9);
$objPHPExcel->getActiveSheet()->getStyle("B36:J36")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("B36:J36")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("T5")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("S8")->applyFromArray($tamanio13);
$objPHPExcel->getActiveSheet()->getStyle("Z5")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("AC12")->getNumberFormat()->setFormatCode("#,##0");
$objPHPExcel->getActiveSheet()->getStyle("F24:I30")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("F24:I30")->applyFromArray($tamanio9);
$objPHPExcel->getActiveSheet()->getStyle("O24:O29")->applyFromArray($centrado);


//Logo Vinus
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo Vinus');
$objDrawing->setDescription('Logo de uso exclusivo de Vinus');
$objDrawing->setPath('./img/logo_vinus.jpg');
$objDrawing->setCoordinates('G3');
$objDrawing->setHeight(90);
$objDrawing->setOffsetX(32);
$objDrawing->setOffsetY(50);
$objDrawing->getShadow()->setDirection(160);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//Logo ANI
$objDrawing2 = new PHPExcel_Worksheet_Drawing();
$objDrawing2->setName('Logo ANI');
$objDrawing2->setDescription('Logo de uso exclusivo de ANI');
$objDrawing2->setPath('./img/logo_ani.jpg');
$objDrawing2->setCoordinates('B3');
$objDrawing2->setWidth(125);
// $objDrawing2->setOffsetX(30);
$objDrawing2->setOffsetY(50);
$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'MINISTERIO DE TRANSPORTE');
$objPHPExcel->getActiveSheet()->setCellValue('J8', 'AGENCIA NACIONAL DE INFRAESTRUCTURA');
$objPHPExcel->getActiveSheet()->setCellValue('J12', 'FICHA PREDIAL');
$objPHPExcel->getActiveSheet()->setCellValue('Q2', 'PROYECTO DE CONCESIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('Q3', 'Contrato No.');
$objPHPExcel->getActiveSheet()->setCellValue('V2', 'CONCESIÓN VÍAS DEL NUS');
$objPHPExcel->getActiveSheet()->setCellValue('V3', '01 de 2016');
$objPHPExcel->getActiveSheet()->setCellValue('Q5', 'UNIDAD FUNCIONAL');
$objPHPExcel->getActiveSheet()->setCellValue('Q9', 'PREDIO No.');
$objPHPExcel->getActiveSheet()->setCellValue('Q12', 'ABSCISA INICIAL');
$objPHPExcel->getActiveSheet()->setCellValue('Q13', 'ABSCISA FINAL');
$objPHPExcel->getActiveSheet()->setCellValue('T12', 'K');
$objPHPExcel->getActiveSheet()->setCellValue('T13', 'K');
$objPHPExcel->getActiveSheet()->setCellValue('W5', 'SECTOR O TRAMO');
$objPHPExcel->getActiveSheet()->setCellValue('W12', 'MARGEN');
$objPHPExcel->getActiveSheet()->setCellValue('W13', 'MARGEN');
$objPHPExcel->getActiveSheet()->setCellValue('AB12', 'LONGITUD EFECTIVA');
$objPHPExcel->getActiveSheet()->setCellValue('B16', 'NOMBRE DEL PROPIETARIO DEL PREDIO');
$objPHPExcel->getActiveSheet()->setCellValue('Q16', 'CÉDULA');
$objPHPExcel->getActiveSheet()->setCellValue('Q18', 'DIRECCIÓN / EMAIL');
$objPHPExcel->getActiveSheet()->setCellValue('Q20', 'DIRECCIÓN DEL PREDIO');
$objPHPExcel->getActiveSheet()->setCellValue('AB16', 'MATRÍCULA INMOBILIARIA');
$objPHPExcel->getActiveSheet()->setCellValue('AB20', 'CÉDULA CATASTRAL');
$objPHPExcel->getActiveSheet()->setCellValue('B24', 'VEREDA / BARRIO:');
$objPHPExcel->getActiveSheet()->setCellValue('B26', 'MUNICIPIO:');
$objPHPExcel->getActiveSheet()->setCellValue('B28', 'DEPARTAMENTO:');
$objPHPExcel->getActiveSheet()->setCellValue('B30', 'REQUERIDO PARA:');
$objPHPExcel->getActiveSheet()->setCellValue('J24', 'CLASIFICACIÓN DEL SUELO');
$objPHPExcel->getActiveSheet()->setCellValue('J26', 'ACTIVIDAD ECONÓMICA DEL PREDIO');
$objPHPExcel->getActiveSheet()->setCellValue('J28', 'TOPOGRAFÍA');
$objPHPExcel->getActiveSheet()->setCellValue('U24', 'LONGITUD');
$objPHPExcel->getActiveSheet()->setCellValue('R24', 'LINDEROS');
$objPHPExcel->getActiveSheet()->setCellValue('R26', 'NORTE');
$objPHPExcel->getActiveSheet()->setCellValue('R28', 'SUR');
$objPHPExcel->getActiveSheet()->setCellValue('R30', 'ORIENTE');
$objPHPExcel->getActiveSheet()->setCellValue('R32', 'OCCIDENTE');
$objPHPExcel->getActiveSheet()->setCellValue('W24', 'COLINDANTES');
$objPHPExcel->getActiveSheet()->setCellValue('A35', 'INVENTARIO DE CULTIVOS Y ESPECIES');
$objPHPExcel->getActiveSheet()->setCellValue('B36', 'DESCRIPCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('G36', 'CANT.');
$objPHPExcel->getActiveSheet()->setCellValue('H36', 'DENS.');
$objPHPExcel->getActiveSheet()->setCellValue('I36', 'UN.');
$objPHPExcel->getActiveSheet()->setCellValue('M35', 'ÍTEM');
$objPHPExcel->getActiveSheet()->setCellValue('N35', 'DESCRIPCIÓN DE LAS CONSTRUCCIONES');
$objPHPExcel->getActiveSheet()->setCellValue('AB35', 'CANTIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('AD35', 'UNIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('F28', 'ANTIOQUIA');
$objPHPExcel->getActiveSheet()->setCellValue('F30', 'USO DE VÍA');


// Datos
$unidad = explode('-', $ficha); // Se divide la ficha para sacar unidad y número

if (count($unidad) > 2) {
	// Se pone en vez de F o M, Área
	$nombre_ficha = "$unidad[0]-$unidad[1] Área $unidad[3]";
} else {
	// Ficha normal
	$nombre_ficha = $ficha;
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

// Si son dos propietarios
if ($predio->numero_propietarios > 1) {
	// Si es mayor a dos
	if ($predio->numero_propietarios > 2) {
		$propietarios_adicionales = " Y OTROS";
	}else{
		$propietarios_adicionales = " Y OTRO";
	}
}else{
	$propietarios_adicionales = "";
}


$objPHPExcel->getActiveSheet()->setCellValue('T5', $unidad['0']);
$objPHPExcel->getActiveSheet()->setCellValue('S8', $nombre_ficha);
// $objPHPExcel->getActiveSheet()->setCellValue('S8', $ficha);
$objPHPExcel->getActiveSheet()->setCellValue('Z5', $predio->tramo);
$objPHPExcel->getActiveSheet()->setCellValue('Z12', $predio->margen_inicial);
$objPHPExcel->getActiveSheet()->setCellValue('Z13', $predio->margen_final);
$objPHPExcel->getActiveSheet()->setCellValue('U12', "$kms_inicial + $ms_inicial");
$objPHPExcel->getActiveSheet()->setCellValue('U13', "$kms_final + $ms_final");
$objPHPExcel->getActiveSheet()->setCellValue('AC12', $predio->abscisa_final - $predio->abscisa_inicial);
$objPHPExcel->getActiveSheet()->setCellValue('B18', $predio->nombre_propietario.$propietarios_adicionales);
$objPHPExcel->getActiveSheet()->setCellValue('U16', $predio->documento_propietario);
// $objPHPExcel->getActiveSheet()->setCellValue('U18', $predio->direccion_propietario);
$objPHPExcel->getActiveSheet()->setDinamicSizeRow($predio->direccion_propietario, 18, "U:Z");
$objPHPExcel->getActiveSheet()->setCellValue('U20', $predio->direccion);
$objPHPExcel->getActiveSheet()->setCellValue('AB17', $predio->matricula);
$objPHPExcel->getActiveSheet()->setCellValue('AB21', " ".$predio->no_catastral);
$objPHPExcel->getActiveSheet()->setCellValue('F24', $predio->barrio);
$objPHPExcel->getActiveSheet()->setCellValue('F26', $predio->municipio);
$objPHPExcel->getActiveSheet()->setCellValue('O24', $predio->uso_terreno);
$objPHPExcel->getActiveSheet()->setCellValue('O26', $predio->uso_edificacion);
$objPHPExcel->getActiveSheet()->setCellValue('O28', $predio->topografia);
$objPHPExcel->getActiveSheet()->setCellValue('U26', $predio->norte_long);
$objPHPExcel->getActiveSheet()->setCellValue('U28', $predio->sur_long);
$objPHPExcel->getActiveSheet()->setCellValue('U30', $predio->oriente_long);
$objPHPExcel->getActiveSheet()->setCellValue('U32', $predio->occidente_long);
$objPHPExcel->getActiveSheet()->setDinamicSizeRow($predio->nom_norte, 26, "W:AD");
$objPHPExcel->getActiveSheet()->setDinamicSizeRow($predio->nom_sur, 28, "W:AD");
$objPHPExcel->getActiveSheet()->setDinamicSizeRow($predio->nom_oriente, 30, "W:AD");
$objPHPExcel->getActiveSheet()->setDinamicSizeRow($predio->nom_occ, 32, "W:AD");


/********************************************************************
************ Cultivos, especies y construcciones ********************
********************************************************************/

// Se consultan los cultivos, construcciones y construcciones anexas
$cultivos = $this->PrediosDAO->obtener_cultivos($ficha);
$construcciones = $this->PrediosDAO->obtener_construcciones($ficha, '1');
$construcciones_anexas = $this->PrediosDAO->obtener_construcciones($ficha, '2');

// Se cuentan los cultivos y las construcciones (mas 7 filas de encabezados y otros datos que tiene la ficha)
$total_cultivos = count($cultivos);
$total_construcciones = count($construcciones) + count($construcciones_anexas) + 11;

// Si hay más cultivos que construcciones, ese será el total de filas a crear, sino, será el total de contrucciones
($total_cultivos > $total_construcciones) ? $total_filas = $total_cultivos : $total_filas = $total_construcciones ;

// Fila inicial
$fila = 37;

// Recorrido del total de filas para formatear el espacio de los cultivos
for ($i=1; $i <= $total_filas; $i++) {
	// Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:F{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");

	// Estilos de celda
	$objPHPExcel->getActiveSheet()->getStyle("B{$fila}:F{$fila}")->applyFromArray($borde_puntos_externo);
	$objPHPExcel->getActiveSheet()->getStyle("G{$fila}")->applyFromArray($borde_puntos_externo);
	$objPHPExcel->getActiveSheet()->getStyle("H{$fila}")->applyFromArray($borde_puntos_externo);
	$objPHPExcel->getActiveSheet()->getStyle("I{$fila}:J{$fila}")->applyFromArray($borde_puntos_externo);

	// Aumento de fila
	$fila++;
} // for

// Fila inicial
$fila = 37;

// Recorrido para llenar el dato de los cultivos y especies
foreach ($cultivos as $cultivo) {
	// Datos
	$objPHPExcel->getActiveSheet()->setDinamicSizeRow($cultivo->descripcion, $fila, "B:F");
	$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", $cultivo->cantidad);
	$objPHPExcel->getActiveSheet()->setCellValue("H{$fila}", $cultivo->densidad);
	$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", $cultivo->unidad);

	// Aumento de fila
	$fila++;
} // foreach

// Fila inicial
$fila = 37;
$fila_construcciones = $fila;
$cont = 1;

// Recorrido para formatear y llenar las construcciones
foreach ($construcciones as $construccion) {
	// Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("N{$fila}:Z{$fila}");

	// Estilos de celda
	$objPHPExcel->getActiveSheet()->getStyle("M{$fila}")->applyFromArray($borde_puntos_externo);
	$objPHPExcel->getActiveSheet()->getStyle("N{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
	$objPHPExcel->getActiveSheet()->getStyle("AB{$fila}")->applyFromArray($borde_puntos_externo);
	$objPHPExcel->getActiveSheet()->getStyle("AD{$fila}")->applyFromArray($borde_puntos_externo);

	// Datos
	$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", $cont++);
	$objPHPExcel->getActiveSheet()->setDinamicSizeRow($construccion->descripcion, $fila, "N:Z");
	$objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", $construccion->cantidad);
	$objPHPExcel->getActiveSheet()->setCellValue("AD{$fila}", $construccion->unidad);

	// Aumento de fila
	$fila++;
} // foreach construcciones

$fila_construcciones_fin = $fila - 1;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("U{$fila}:Z{$fila}");

// Texto
$objPHPExcel->getActiveSheet()->setCellValue("U{$fila}", 'TOTAL ÁREA CONSTRUIDA');
$objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "=SUM(AB{$fila_construcciones}:AB{$fila_construcciones_fin})");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("U{$fila}:AB{$fila}")->applyFromArray($negrita);

// Aumento de fila
$fila = $fila + 2;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("N{$fila}:Z{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", 'ÍTEM');
$objPHPExcel->getActiveSheet()->setCellValue("N{$fila}", 'DESCRIPCIÓN DE LAS CONSTRUCCIONES ANEXAS');
$objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", 'CANTIDAD');
$objPHPExcel->getActiveSheet()->setCellValue("AD{$fila}", 'UNIDAD');

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}:AD{$fila}")->applyFromArray($tamanio9);
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}:AD{$fila}")->applyFromArray($negrita);

// Aumento de fila
$fila++;

$fila_construcciones_anexas = $fila;

$cont = 1;

// Recorrido para formatear y llenar las construcciones
foreach ($construcciones_anexas as $construccion_anexa) {
	// Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("N{$fila}:Z{$fila}");

	// Estilos de celda
	$objPHPExcel->getActiveSheet()->getStyle("M{$fila}")->applyFromArray($borde_puntos_externo);
	$objPHPExcel->getActiveSheet()->getStyle("N{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
	$objPHPExcel->getActiveSheet()->getStyle("AB{$fila}")->applyFromArray($borde_puntos_externo);
	$objPHPExcel->getActiveSheet()->getStyle("AD{$fila}")->applyFromArray($borde_puntos_externo);

	// Datos
	$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", $cont++);
	$objPHPExcel->getActiveSheet()->setDinamicSizeRow($construccion_anexa->descripcion, $fila, "N:Z");
	$objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", $construccion_anexa->cantidad);
	$objPHPExcel->getActiveSheet()->setCellValue("AD{$fila}", $construccion_anexa->unidad);

	// Aumento de fila
	$fila++;
} // construcciones anexas

$fila_construcciones_anexas_fin = $fila - 1;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("U{$fila}:Z{$fila}");

// Texto
$objPHPExcel->getActiveSheet()->setCellValue("U{$fila}", 'TOTAL ÁREA CONSTRUIDA');
$objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "=SUM(AB{$fila_construcciones_anexas}:AB{$fila_construcciones_anexas_fin})");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("U{$fila}:AB{$fila}")->applyFromArray($negrita);
// Estilos
$objPHPExcel->getActiveSheet()->getStyle("U{$fila}")->applyFromArray($negrita);

// Aumento de fila
$fila = $fila + 2;

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", 'SI/NO');

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("AB{$fila}")->applyFromArray($negrita);

// Aumento de fila
$fila++;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:Z{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", '¿Tiene el inmueble licencia urbanística, Urbanización, parcelación, subdivisión, construcción, Intervención, Espacio Público?');
if ($predio->c_licencia == "1") { $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "SI"); }else{ $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "NO");}


// Estilos
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("N{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("AB{$fila}")->applyFromArray($borde_puntos_externo);

// Aumento de fila
$fila++;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:Z{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", '¿Tiene el inmueble reglamento de Propiedad Horizontal LEY 675 DE 2001?');
if ($predio->c_reglamento == "1") { $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "SI"); }else{ $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "NO");}

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("N{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("AB{$fila}")->applyFromArray($borde_puntos_externo);

// Aumento de fila
$fila++;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:Z{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", '¿Tiene el inmueble aprobado plan parcial en el momento del levantamiento de la Ficha Predial?');
if ($predio->c_levantamiento == "1") { $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "SI"); }else{ $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "NO");}

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("N{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("AB{$fila}")->applyFromArray($borde_puntos_externo);

// Aumento de fila
$fila++;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:Z{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", '¿Aplica Informe de análisis de Área Remanente?');
if ($predio->c_informe == "1") { $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "SI"); }else{ $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "NO");}

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("N{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("AB{$fila}")->applyFromArray($borde_puntos_externo);

// Aumento de fila
$fila++;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:Z{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", '¿De acuerdo al estudio de títulos, la franja que estipula el decreto 2770 debe adquirirse?');
if ($predio->c_adquisicion == "1") { $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "SI"); }else{ $objPHPExcel->getActiveSheet()->setCellValue("AB{$fila}", "NO");}

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("N{$fila}:Z{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("AB{$fila}")->applyFromArray($borde_puntos_externo);

// La fila a asignarse es la suma de donde arranca hasta el total
$fila = 37 + $total_filas;

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(3);

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A34:K{$fila}")->applyFromArray($borde_negrita_externo);

// Aumento de fila
$fila++;

$fila_pie = $fila;

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(3);

// Aumento de fila
$fila++;

$fila_M2 = $fila;

$fila_area_total = $fila;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:O{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("T{$fila}:AD{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:J{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", 'ÁREA TOTAL TERRENO');
$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", 'FECHA DE ELABORACIÓN');
$objPHPExcel->getActiveSheet()->setCellValue("T{$fila}", 'OBSERVACIONES:');
$objPHPExcel->getActiveSheet()->setCellValue("R{$fila}", 'm2');

// Contenido
$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila_area_total}", $predio->area_total_catastral);

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila_area_total}")->getNumberFormat()->setFormatCode('#,##0.000');
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B{$fila}")->applyFromArray($negrita);

// Aumento de fila
$fila++;

$fila_observaciones = $fila;

// Datos
$objPHPExcel->getActiveSheet()->setDinamicSizeRow($predio->observacion, $fila, "T:AD");


//Tamaño de celdas y aumento de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(3); $fila++;

$fila_area_requerida = $fila;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:O{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:J{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $this->InformesDAO->formatear_fecha(date('Y-m-d')));
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", 'ÁREA REQUERIDA');
$objPHPExcel->getActiveSheet()->setCellValue("R{$fila}", 'm2');

// Contenido
$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila_area_requerida}", $predio->area_requerida);

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B{$fila_M2}:J{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila_area_requerida}")->getNumberFormat()->setFormatCode('#,##0.000');

// Aumento de fila
$fila++;

//Tamaño de celdas y aumento de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(3); $fila++;

$fila_area_remanente = $fila;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:O{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:E{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:J{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", 'Elaboró');
$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", 'Revisó y aprobó');
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", 'ÁREA REMANENTE');
$objPHPExcel->getActiveSheet()->setCellValue("R{$fila}", 'm2');

// Contenido
$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila_area_remanente}", number_format($predio->area_residual, 3));

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B{$fila}:G{$fila}")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila_area_remanente}")->getNumberFormat()->setFormatCode('#,##0.000');

// Aumento de fila
$fila++;

$fila_elaboro = $fila;

//Tamaño de celdas y aumento de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(3); $fila++;

$fila_area_sobrante = $fila;
$fila_area_total_requerida = $fila - 4;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:O{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", 'ÁREA SOBRANTE');
$objPHPExcel->getActiveSheet()->setCellValue("R{$fila}", 'm2');

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila_area_sobrante}", "=Q{$fila_area_total}-Q{$fila_area_total_requerida}");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila_area_sobrante}")->getNumberFormat()->setFormatCode('#,##0.000');

// Aumento de fila
$fila++;

//Tamaño de celdas y aumento de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(3); $fila++;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:O{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("T{$fila_observaciones}:AD{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila_elaboro}:E{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila_elaboro}:J{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", 'ÁREA TOTAL REQUERIDA');
$objPHPExcel->getActiveSheet()->setCellValue("R{$fila}", 'm2');

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila}")->applyFromArray($borde_puntos_externo);

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("R{$fila_M2}:R{$fila}")->applyFromArray($tamanio8);
$objPHPExcel->getActiveSheet()->getStyle("M{$fila_M2}:M{$fila}")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("T{$fila_observaciones}:AD{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B{$fila_elaboro}:E{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("G{$fila_elaboro}:J{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila}")->getNumberFormat()->setFormatCode('#,##0.000');

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila}", "=Q{$fila_area_requerida}+Q{$fila_area_remanente}");

// Aumento de fila
$fila++;

//Tamaño de celdas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(3);

$objPHPExcel->getActiveSheet()->getStyle("A34:AE{$fila}")->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_pie}:K{$fila}")->applyFromArray($borde_negrita_externo);





// Aumento de fila
$fila++;

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(3);








// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Ficha predial");

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$ficha.' Ficha predial".xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>
