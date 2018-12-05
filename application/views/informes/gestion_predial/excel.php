<?php
//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Predial - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Gestión predial")
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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(28);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
// $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(250);

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($titulo_centrado_negrita);

//Encabezados
$objPHPExcel->getActiveSheet()
	->setCellValue('A1', '#')
	->setCellValue('B1', 'Municipio')
	->setCellValue('C1', 'Unidad funcional')
	->setCellValue('D1', 'Predio')
	->setCellValue('E1', 'Tramo')
	->setCellValue('F1', 'Abscisa inicial')
	->setCellValue('G1', 'Abscisa final')
	->setCellValue('H1', 'Longitud efectiva')
	->setCellValue('I1', 'Longitud efectiva requerida')
	->setCellValue('J1', 'Margen')
	->setCellValue('K1', 'Propietarios')
	->setCellValue('L1', 'Nombres')
	->setCellValue('M1', 'Documento')
	->setCellValue('N1', 'Dirección')
	->setCellValue('O1', 'Matrícula')
	->setCellValue('P1', 'Cédula catastral')
	->setCellValue('Q1', 'Municipio')
	->setCellValue('R1', 'Barrio / vereda')
	->setCellValue('S1', 'Clasificación')
	->setCellValue('T1', 'Actividad económica')
	->setCellValue('U1', 'Topografía')
	->setCellValue('V1', 'Área total terreno (m2)')
	->setCellValue('W1', 'Área requerida (m2)')
	->setCellValue('X1', 'Área remanente (m2)')
	->setCellValue('Y1', 'Área sobrante (m2)')
	->setCellValue('Z1', 'Área total requerida (m2)')
	// ->setCellValue('AA1', 'Lindero')
;

// Estilos de columntas
$objPHPExcel->getActiveSheet()->getStyle("F:G")->getNumberFormat()->setFormatCode("#");
$objPHPExcel->getActiveSheet()->getStyle("P")->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
$objPHPExcel->getActiveSheet()->getStyle("V:Z")->getNumberFormat()->setFormatCode("#,##0.#0");

//Se declara fila
$fila = 2;
$numero = 1;

//Se recorren los predios
foreach ($this->InformesDAO->obtener_gestion_predial() as $predio) {
	$propietarios_adicionales = "";

	// Si son dos o más propietarios
	if ($predio->numero_propietarios > 1) $propietarios_adicionales = ($predio->numero_propietarios == 2) ? "Y OTRO" : "Y OTROS" ;

	// Para el abscisado inicial
	$ms_inicial = substr($predio->abscisa_inicial, -3);
	$kms_inicial = substr($predio->abscisa_inicial, 0, strlen($predio->abscisa_inicial) - 3);
	if($kms_inicial == "") $kms_inicial = "0";

	// Para el abscisado final
	$ms_final = substr($predio->abscisa_final, -3);
	$kms_final = substr($predio->abscisa_final, 0, strlen($predio->abscisa_final) - 3);
	if($kms_final == "") $kms_final = "0";

	$longitud_efectiva = $predio->abscisa_final - $predio->abscisa_inicial;

	// Consulta de los datos del propietario
	if($predio->id_propietario) $propietario = $this->PropietariosDAO->obtener_propietario($predio->id_propietario);

	// Datos
	$objPHPExcel->getActiveSheet()
		->setCellValue("A{$fila}", $numero++)
		->setCellValue("B{$fila}", $predio->municipio_ficha)
		->setCellValue("C{$fila}", $predio->unidad_funcional)
		->setCellValue("D{$fila}", $predio->ficha_predial)
		->setCellValue("E{$fila}", $predio->tramo)
		->setCellValue("F{$fila}", "$kms_inicial + $ms_inicial")
		->setCellValue("G{$fila}", "$kms_final + $ms_final")
		->setCellValue("H{$fila}", $longitud_efectiva)
		->setCellValue("I{$fila}", $predio->requiere_longitud_efectiva)
		->setCellValue("J{$fila}", "$predio->margen_inicial - $predio->margen_final")
		->setCellValue("K{$fila}", $predio->numero_propietarios)
		->setCellValue("L{$fila}", "$propietario->nombre $propietarios_adicionales")
		->setCellValue("M{$fila}", $propietario->documento)
		->setCellValue("N{$fila}", $propietario->direccion)
		->setCellValue("O{$fila}", $predio->matricula)
		->setCellValue("P{$fila}", " $predio->no_catastral")
		->setCellValue("Q{$fila}", $predio->municipio)
		->setCellValue("R{$fila}", $predio->barrio)
		->setCellValue("S{$fila}", $predio->uso_terreno)
		->setCellValue("T{$fila}", $predio->uso_edificacion)
		->setCellValue("U{$fila}", $predio->topografia)
		->setCellValue("V{$fila}", $predio->area_total)
		->setCellValue("W{$fila}", $predio->area_requerida)
		->setCellValue("X{$fila}", $predio->area_remanente)
		->setCellValue("Y{$fila}", "=V{$fila}-W{$fila}")
		->setCellValue("Z{$fila}", "=W{$fila}+X{$fila}")
	;

	//Se aumenta la fila
	$fila++;
} // foreach predios

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Gestión predial");

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Gestión predial.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>