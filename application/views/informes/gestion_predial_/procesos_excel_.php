<?php
// Se consultan las unidades funcionales
$unidades = $this->PrediosDAO->obtener_unidades_funcionales();

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Concesión Vías del Nus - Vinus S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Predial - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Gestión de procesos")
	->setDescription("Gestión predial")
	->setKeywords("gestion predial vinus")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); 

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(3);

//Se establecen las margenes
// $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0,90); //Arriba
// $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0,70); //Derecha
// $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0,70); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,90); //Abajo

// Ocultar la cuadrícula: 
$objPHPExcel->getActiveSheet()->setShowGridlines(true);

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered();


/*******************************************************
 *********************** Estilos ***********************
 *******************************************************/
$centrado = array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER ) ); // Alineación centrada

// Estilo de los bordes
$bordes = array( 'borders' => array( 'allborders' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array( 'argb' => '000000' ) ), ), );
$borde_negrita_externo = array( 'borders' => array( 'outline' => array( 'style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => array('argb' => '000000'), ), ), );
$negrita = array( 'font' => array( 'bold' => true ) );

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);

// Declaración de columna
$columna = "B";

// Recorrido de columnas de las mismas características
for ($i=1; $i <= 26; $i++) { 
	// Tamaño de columnas
	$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(4.6);

	// Rotar el texto
	$objPHPExcel->getActiveSheet()->getStyle("{$columna}6")->getAlignment()->setTextRotation(90);

	// Aumento
	$columna++;
} // for

// Rotar el texto
$objPHPExcel->getActiveSheet()->getStyle("X5")->getAlignment()->setTextRotation(90);

//Tamaño de filas
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(8);
$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(135);

// //Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A1:A3");
$objPHPExcel->getActiveSheet()->mergeCells("A4:AA4");
$objPHPExcel->getActiveSheet()->mergeCells("A5:A6");
$objPHPExcel->getActiveSheet()->mergeCells("B1:R1");
$objPHPExcel->getActiveSheet()->mergeCells("B2:R2");
$objPHPExcel->getActiveSheet()->mergeCells("B5:D5");
$objPHPExcel->getActiveSheet()->mergeCells("B3:R3");
$objPHPExcel->getActiveSheet()->mergeCells("E5:G5");
$objPHPExcel->getActiveSheet()->mergeCells("H5:J5");
$objPHPExcel->getActiveSheet()->mergeCells("K5:M5");
$objPHPExcel->getActiveSheet()->mergeCells("N5:Q5");
$objPHPExcel->getActiveSheet()->mergeCells("R5:T5");
$objPHPExcel->getActiveSheet()->mergeCells("S1:U3");
$objPHPExcel->getActiveSheet()->mergeCells("U5:W5");
$objPHPExcel->getActiveSheet()->mergeCells("V1:X1");
$objPHPExcel->getActiveSheet()->mergeCells("V2:X2");
$objPHPExcel->getActiveSheet()->mergeCells("V3:X3");
$objPHPExcel->getActiveSheet()->mergeCells("X5:X6");
$objPHPExcel->getActiveSheet()->mergeCells("Y1:AA1");
$objPHPExcel->getActiveSheet()->mergeCells("Y2:AA2");
$objPHPExcel->getActiveSheet()->mergeCells("Y3:AA3");
$objPHPExcel->getActiveSheet()->mergeCells("Y5:AA5");

//Logo ANI
$objDrawing2 = new PHPExcel_Worksheet_Drawing();
$objDrawing2->setName('Logo ANI');
$objDrawing2->setDescription('Logo de uso exclusivo de ANI');
$objDrawing2->setPath('./img/logo_ani.jpg');
$objDrawing2->setCoordinates('A1');
$objDrawing2->setWidth(80);
$objDrawing2->setOffsetX(47);
$objDrawing2->setOffsetY(4);
$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());

//Logo Vinus
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo Vinus');
$objDrawing->setDescription('Logo de uso exclusivo de Vinus');
$objDrawing->setPath('./img/logo_vinus.jpg');
$objDrawing->setCoordinates('S1');
$objDrawing->setHeight(65);
$objDrawing->setOffsetX(20);
$objDrawing->setOffsetY(3);
$objDrawing->getShadow()->setDirection(160);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// //Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'UNIDAD FUNCIONAL');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CONCESIÓN VÍAS DEL NUS - VINUS');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'FORMATO DE GESTIÓN DE PROCESOS PREDIALES');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Fecha de generación: '.$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'));
$objPHPExcel->getActiveSheet()->setCellValue('B6', 'PREDIOS ESTUDIADOS');
$objPHPExcel->getActiveSheet()->setCellValue('C6', 'PREDIOS REQUERIDOS');
$objPHPExcel->getActiveSheet()->setCellValue('D6', 'PREDIOS NO REQUERIDOS');
$objPHPExcel->getActiveSheet()->setCellValue('E5', 'FICHAS PREDIALES');
$objPHPExcel->getActiveSheet()->setCellValue('E6', 'ENVIADOS A INTERVENTORÍA');
$objPHPExcel->getActiveSheet()->setCellValue('F6', 'EN CORRECCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('G6', 'APROBADOS');
$objPHPExcel->getActiveSheet()->setCellValue('H5', 'FICHAS SOCIALES');
$objPHPExcel->getActiveSheet()->setCellValue('H6', 'ENVIADOS A INTERVENTORÍA');
$objPHPExcel->getActiveSheet()->setCellValue('I6', 'EN CORRECCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('J6', 'APROBADOS');
$objPHPExcel->getActiveSheet()->setCellValue('K5', 'AVALÚOS');
$objPHPExcel->getActiveSheet()->setCellValue('K6', 'ENVIADOS A INTERVENTORÍA');
$objPHPExcel->getActiveSheet()->setCellValue('L6', 'EN CORRECCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('M6', 'APROBADOS');
$objPHPExcel->getActiveSheet()->setCellValue('N5', 'OFERTAS DE COMPRAVENTA');
$objPHPExcel->getActiveSheet()->setCellValue('N6', 'ENVIADOS A INTERVENTORÍA');
$objPHPExcel->getActiveSheet()->setCellValue('O6', 'EN CORRECCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('P6', 'APROBADOS');
$objPHPExcel->getActiveSheet()->setCellValue('Q6', 'NOTIFICACIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('R5', 'ACEPTADAS');
$objPHPExcel->getActiveSheet()->setCellValue('R6', 'ENTREGA PREDIOS E.V.');
$objPHPExcel->getActiveSheet()->setCellValue('S6', 'ESCRITURA');
$objPHPExcel->getActiveSheet()->setCellValue('T6', 'REGISTRO');
$objPHPExcel->getActiveSheet()->setCellValue('U5', 'EXPROPIACIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('U6', 'ENTREGA EXPROPIADO');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Código:');
$objPHPExcel->getActiveSheet()->setCellValue('V2', 'Versión:');
$objPHPExcel->getActiveSheet()->setCellValue('V3', 'Creado:');
$objPHPExcel->getActiveSheet()->setCellValue('V6', 'PROCESO EXPROPIACIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('W6', 'REGISTRO SENTENCIA');
$objPHPExcel->getActiveSheet()->setCellValue('X5', 'PREDIOS DISPONIBLES PARA OBRA');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'F018');
$objPHPExcel->getActiveSheet()->setCellValue('Y2', 'V1.01');
$objPHPExcel->getActiveSheet()->setCellValue('Y3', '01/06/2016');
$objPHPExcel->getActiveSheet()->setCellValue('Y5', 'PORCENTAJES');
$objPHPExcel->getActiveSheet()->setCellValue('Y6', 'ENVIADOS A INTERVENTORÍA');
$objPHPExcel->getActiveSheet()->setCellValue('Z6', 'APROBADOS');
$objPHPExcel->getActiveSheet()->setCellValue('AA6', 'EN CORRECCIÓN');

// Fila inicial
$fila = 7;

// Se recorren las unidades funcionales
foreach ($unidades as $unidad) {
	// Contenido
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "{$unidad->Nombre} - {$unidad->Codigo}");
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", "=C{$fila}+D{$fila}");
	$objPHPExcel->getActiveSheet()->setCellValue("C{$fila}", $unidad->Requeridos);
	$objPHPExcel->getActiveSheet()->setCellValue("D{$fila}", $unidad->No_Requeridos);
	$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", $unidad->Ficha_Enviada);
	
	//Tamaño de filas
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(15);

	// Aumento de fila
	$fila++;
} // foreach unidades

// Reducción de fila
$fila--;

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A1:AA3")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("A1:AA3")->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle("B5:AA5")->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A5:AA6")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("B6:AA6")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
$objPHPExcel->getActiveSheet()->getStyle("X5")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);

// Aumento de fila
$fila++;
$fila_inicial = $fila;


// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:AA{$fila}");

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(5);

$fila--;

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A5:AA{$fila}")->applyFromArray($bordes);

// Aumento de fila
$fila++;
$fila++;

// Contenidos
$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", 'CONVENCIONES');

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A{$fila}")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila}")->applyFromArray($negrita);

// Almacenar fila
$fila_convenciones = $fila;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:AA{$fila}");

// Aumento de fila
$fila++;
$fila_convenciones2 = $fila;

// Arreglo con las descripciones de las convenciones
$descripciones1 = array(
	'',
	'Es la suma de los predios requeridos y no requeridos',
	'Total de predios que van a ser requeridos por el proyecto',
	'Predios que fueron objeto de estudio, pero no van a ser requeridos para el proyecto',
	'Fichas prediales, sociales, avalúos u ofertas que han sido enviados a interventoría',
	'Fichas prediales, sociales, avalúos u ofertas que fueron devueltos para su única revisión',
	'Fichas prediales, sociales, avalúos u ofertas aprobados por la interventoría',
);


// Arreglo con las descripciones de las convenciones
$descripciones2 = array(
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
);

// Declaración de columna
$columna = "B";

// Recorrido para las convenciones
for ($i=1; $i<=6; $i++) {
	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:I{$fila}");

	// Contenidos
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "={$columna}6");
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $descripciones1[$i]);

	// Tamaño de fila
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(25);

	// Estilos
	$objPHPExcel->getActiveSheet()->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes);
	$objPHPExcel->getActiveSheet()->getStyle("A{$fila}")->applyFromArray($negrita);

	// Aumento de fila columna
	$fila++;
	$columna++;
} // for


// Declaración de columna
$columna = "R";

// Recorrido para las convenciones
for ($i=1; $i<=6; $i++) {
	// //Celdas a combinar
	// $objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:I{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("K{$fila_convenciones2}:S{$fila_convenciones2}");
	$objPHPExcel->getActiveSheet()->mergeCells("T{$fila_convenciones2}:AA{$fila_convenciones2}");

	// Contenidos
	$objPHPExcel->getActiveSheet()->setCellValue("K{$fila_convenciones2}", "={$columna}6");
	$objPHPExcel->getActiveSheet()->setCellValue("T{$fila_convenciones2}", $descripciones2[$i]);

	// // Tamaño de fila
	// $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(25);

	// Estilos
	$objPHPExcel->getActiveSheet()->getStyle("K{$fila_convenciones2}")->applyFromArray($negrita);
	$objPHPExcel->getActiveSheet()->getStyle("K{$fila_convenciones2}:AA{$fila_convenciones2}")->applyFromArray($bordes);

	// Aumento de fila columna
	$fila_convenciones2++;
	$columna++;
} // for

// Disminución de fila
$fila--;

// Estilos
// $objPHPExcel->getActiveSheet()->getStyle("A{$fila_convenciones}:{$columna}{$fila}")->applyFromArray($bordes);
// $objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:T{$fila}")->applyFromArray($borde_negrita_externo);
// $objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:T{$fila}")->applyFromArray($tamanio8);
// $objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}")->applyFromArray($centrado);
// $objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}")->applyFromArray($negrita);
// $objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:A{$fila}")->applyFromArray($negrita);


// // Aumento de fila
// $fila++;
// $fila++;






// // Rotar el texto
// $objPHPExcel->getActiveSheet()->getStyle("T5")->getAlignment()->setTextRotation(90);

// // Estilos
// $objPHPExcel->getActiveSheet()->getStyle("A1:T3")->applyFromArray($bordes);


// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Procesos prediales");

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');


//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Gestión de procesos.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>