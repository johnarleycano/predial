<?php
//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Predial - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Áreas remanentes")
	->setDescription("Áreas remanentes")
	->setKeywords("Áreas remanentes Devimed")
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
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0,90); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0,70); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0,70); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,90); //Abajo

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered();

/**
 * Estilos
 */
$titulo_centrado_negrita = array( 'font' => array( 'bold' => true ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER ) );
$titulo_centrado = array( 'font' => array( 'bold' => false ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER ) );
$titulo_izquierdo = array( 'font' => array( 'bold' => false ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP ) );
$titulo_derecho = array( 'font' => array( 'bold' => true ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT ) );
$bordes = array( 'borders' => array( 'allborders' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array( 'argb' => '000000' ) ), ), );

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($titulo_centrado_negrita);

//Encabezados
$objPHPExcel->getActiveSheet()
	->setCellValue('A1', '#')
	->setCellValue('B1', 'Proyecto')
	->setCellValue('C1', 'Unidad Funcional')
	->setCellValue('D1', 'Fecha culminación etapa construcción')
	->setCellValue('E1', 'Ficha predial')
	->setCellValue('F1', 'Propietario')
	->setCellValue('G1', 'Área total terreno (m2)')
	->setCellValue('H1', 'Área requerida (m2)')
	->setCellValue('I1', 'Área remanente (m2)')
	->setCellValue('J1', 'Área sobrante (m2)')
	->setCellValue('K1', 'Área total requerida (m2)')
	->setCellValue('L1', 'Valor total del predio')
	->setCellValue('M1', 'Valor total área remanente')
	->setCellValue('N1', 'Motivo de adquisición')
;

// Estilos de columnas
$objPHPExcel->getActiveSheet()->getStyle("G:H")->getNumberFormat()->setFormatCode("#,##0.#0");
$objPHPExcel->getActiveSheet()->getStyle("L")->getNumberFormat()->setFormatCode("#,##0.#0");

$numero = 1;
$fila = 2;

//Se recorren los predios
foreach ($this->InformesDAO->obtener_areas_remanentes() as $predio) {
	$propietarios_adicionales = "";
	
	// Si son dos o más propietarios
	if ($predio->numero_propietarios > 1) $propietarios_adicionales = ($predio->numero_propietarios == 2) ? "Y OTRO" : "Y OTROS" ;

	// Consulta de los datos del propietario
	if($predio->id_propietario) $propietario = $this->PropietariosDAO->obtener_propietario($predio->id_propietario);

	// Datos
	$objPHPExcel->getActiveSheet()
		->setCellValue("A{$fila}", $numero++)
		->setCellValue("B{$fila}", $predio->proyecto)
		->setCellValue("C{$fila}", $predio->unidad_funcional)
		->setCellValue("D{$fila}", $predio->fecha_culminacion_construccion)
		->setCellValue("E{$fila}", $predio->ficha_predial)
		->setCellValue("F{$fila}", "$propietario->nombre $propietarios_adicionales")
		->setCellValue("G{$fila}", $predio->area_total)
		->setCellValue("H{$fila}", $predio->area_requerida)
		->setCellValue("I{$fila}", $predio->area_remanente)
		->setCellValue("J{$fila}", "=G{$fila}-H{$fila}")
		->setCellValue("K{$fila}", "=H{$fila}+I{$fila}")
		->setCellValue("L{$fila}", $predio->total_avaluo)
	;

	// Se aumenta la fila
	$fila++;
} // foreach predios

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Áreas remanentes");

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Áreas remanentes.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>