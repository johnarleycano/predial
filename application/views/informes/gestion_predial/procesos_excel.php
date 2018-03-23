<?php
// Se consultan las unidades funcionales
$unidades = $this->PrediosDAO->obtener_unidades_funcionales();

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("CF")
	->setLastModifiedBy("CF")
	->setTitle("Sistema de Gestión Predial - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Gestión de procesos")
	->setDescription("Gestión predial")
	->setKeywords("gestion predial DEVIMED")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9); //Tamanio
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
$tamanio8 = array ( 'font' => array( 'size' => 8 ) );
$negrita = array( 'font' => array( 'bold' => true ) );

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);

// Declaración de columna
$columna = "B";

// Recorrido de columnas de las mismas características
for ($i=1; $i <= 15; $i++) { 
	// Tamaño de columnas
	$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(4);

	// Combinación de celdas
	$objPHPExcel->getActiveSheet()->mergeCells("{$columna}5:{$columna}6");

	// Rotar el texto
	$objPHPExcel->getActiveSheet()->getStyle("{$columna}5")->getAlignment()->setTextRotation(90);

	// Aumento
	$columna++;
} // for

// Tamaño de las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);

//Tamaño de filas
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(8);
$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(120);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(33);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A1:A3");
$objPHPExcel->getActiveSheet()->mergeCells("A5:A6");
$objPHPExcel->getActiveSheet()->mergeCells("B1:N1");
$objPHPExcel->getActiveSheet()->mergeCells("B2:N2");
$objPHPExcel->getActiveSheet()->mergeCells("B3:N3");
$objPHPExcel->getActiveSheet()->mergeCells("O1:Q3");
$objPHPExcel->getActiveSheet()->mergeCells("Q5:S5");
$objPHPExcel->getActiveSheet()->mergeCells("R1:S1");
$objPHPExcel->getActiveSheet()->mergeCells("R2:S2");
$objPHPExcel->getActiveSheet()->mergeCells("R3:S3");
$objPHPExcel->getActiveSheet()->mergeCells("T5:T6");

//Logo ANI
$objDrawing2 = new PHPExcel_Worksheet_Drawing();
$objDrawing2->setName('Logo ANI');
$objDrawing2->setDescription('Logo de uso exclusivo de ANI');
$objDrawing2->setPath('./img/logo_ani.jpg');
$objDrawing2->setCoordinates('A1');
$objDrawing2->setWidth(80);
$objDrawing2->setOffsetX(52);
$objDrawing2->setOffsetY(4);
$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());

//Logo Vinus
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo DEVIMED');
$objDrawing->setDescription('Logo DEVIMED');
$objDrawing->setPath('./img/logo.png');
$objDrawing->setCoordinates('O1');
$objDrawing->setHeight(65);
$objDrawing->setOffsetX(32);
$objDrawing->setOffsetY(2);
$objDrawing->getShadow()->setDirection(160);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'UNIDAD FUNCIONAL');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'DEVIMED S.A');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'FORMATO DE GESTIÓN DE PROCESOS PREDIALES');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Fecha de generación: '.$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'));
$objPHPExcel->getActiveSheet()->setCellValue('B5', 'PREDIOS REQUERIDOS');
$objPHPExcel->getActiveSheet()->setCellValue('C5', 'ENVIADOS A INTERVENTORÍA');
$objPHPExcel->getActiveSheet()->setCellValue('D5', 'APROBADOS');
$objPHPExcel->getActiveSheet()->setCellValue('E5', 'EN ÚNICA REVISIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('F5', 'ESTUDIOS DE TÍTULOS APROBADOS');
$objPHPExcel->getActiveSheet()->setCellValue('G5', 'FICHAS SOCIALES APROBADAS');
$objPHPExcel->getActiveSheet()->setCellValue('H5', 'AVALÚOS EN PROCESO');
$objPHPExcel->getActiveSheet()->setCellValue('I5', 'AVALÚOS APROBADOS');
$objPHPExcel->getActiveSheet()->setCellValue('J5', 'OFERTAS DE COMPRA EN PROCESO');
$objPHPExcel->getActiveSheet()->setCellValue('K5', 'OFERTAS DE COMPRA NOTIFICADAS');
$objPHPExcel->getActiveSheet()->setCellValue('L5', 'ACEPTACIONES DE OFERTA');
$objPHPExcel->getActiveSheet()->setCellValue('M5', 'PERMISOS DE INTERVENCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('N5', 'PROMESAS FIRMADAS');
$objPHPExcel->getActiveSheet()->setCellValue('O5', 'PRIMER PAGO');
$objPHPExcel->getActiveSheet()->setCellValue('P5', '% AVANCE DE INSUMOS');
$objPHPExcel->getActiveSheet()->setCellValue('Q5', '% AVANCE PERMISOS DE INTERVENCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('Q6', '% PREDIOS');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Código:');
$objPHPExcel->getActiveSheet()->setCellValue('R2', 'Versión:');
$objPHPExcel->getActiveSheet()->setCellValue('R3', 'Creado:');
$objPHPExcel->getActiveSheet()->setCellValue('R6', '% LONGITUD');
$objPHPExcel->getActiveSheet()->setCellValue('S6', '% LONGITUD EFECTIVA');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'F018');
$objPHPExcel->getActiveSheet()->setCellValue('T2', 'V1.00');
$objPHPExcel->getActiveSheet()->setCellValue('T3', '01/06/2016');
$objPHPExcel->getActiveSheet()->setCellValue('T5', '% AVANCE ADQUISICIÓN');

// Fila inicial
$fila = 7;

// Se recorren las unidades funcionales
foreach ($unidades as $unidad) {
	// Contenido
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "{$unidad->Nombre} - {$unidad->Codigo}");
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $unidad->Requeridos);

	//Tamaño de filas
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(25);

	// Aumento de fila
	$fila++;
} // foreach unidades

//Tamaño de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(8);

// Reducción de fila
$fila--;

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A5:T{$fila}")->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle("A1:T3")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("B5:P5")->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("B5:P5")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
$objPHPExcel->getActiveSheet()->getStyle("A5:T6")->applyFromArray($tamanio8);
$objPHPExcel->getActiveSheet()->getStyle("A5:T6")->applyFromArray($centrado);

// Aumento de fila
$fila++;
$fila++;

$fila_inicial = $fila;

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:T{$fila}");

// Contenidos
$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", 'CONVENCIONES');

// Aumento de fila
$fila++;

// Declaración de columna
$columna = "A";

// Arreglo con las descripciones de las convenciones
$descripciones = array(
	'',
	'Código y nombre de la unidad funcional a la que pertenece el predio',
	'Total de los predios requeridos para el proyecto',
	'Del total de los predios requeridos, los que fueron enviados a interventoría',
	'De los predios enviados a interventoría, el total de los que fueron aprobados',
	'De los predios enviados a interventoría, el total de los que fueron devueltos para su única revisión',
	'Predios con estudio de títulos aprobados',
	'Fichas sociales aprobadas',
	'Avalúos en elaboración, corrección y ajuste por parte de la lonja',
	'Avalúos aprobados por parte de la interventoría',
	'Ofertas de compra radicadas, proyectadas y firmadas',
	'Ofertas de compra notificadas',
	'Ofertas aceptadas',
	'Permisos otorgados por propietarios que permiten el ingreso',
	'Promesas de compraventa firmadas por propietarios',
	'Predios que han tenido un primer pago',
	'Porcentaje de avance con relación al número de permiso sobre la totalidad de predios y de porcentadje sobre la totalidad de la longitud',
);

// Recorrido para las convenciones
for ($i=1; $i<=15; $i++) {
	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:T{$fila}");

	// Contenidos
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "={$columna}5");
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $descripciones[$i]);




	// Aumento de fila columna
	$fila++;
	$columna++;
} // for

// Disminución de fila
$fila--;

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:T{$fila}")->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:T{$fila}")->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:T{$fila}")->applyFromArray($tamanio8);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:A{$fila}")->applyFromArray($negrita);


// Aumento de fila
$fila++;
$fila++;






// Rotar el texto
$objPHPExcel->getActiveSheet()->getStyle("T5")->getAlignment()->setTextRotation(90);

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A1:T3")->applyFromArray($bordes);



//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Gestión de procesos.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>