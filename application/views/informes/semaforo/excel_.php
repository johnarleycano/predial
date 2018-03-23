<?php
// Modificación del límite en memoria para que permita generar el reporte
ini_set('memory_limit', '-1');
//error_reporting(-1);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Se consultan las unidades funcionales
$unidades_funcionales = $this->PrediosDAO->obtener_unidades_funcionales();
// print_r($unidades_funcionales);

// Se consultan las funciones del predio en obra
$funciones = $this->PrediosDAO->obtener_funciones_predios_obra();

// Se consultan los estados de la via
$estados_via = $this->PrediosDAO->obtener_estados_via();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Concesión Vías del NUS S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Predial - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Anexo 4 - Formato Semáforo")
	->setDescription("Formato Semáforo")
	->setKeywords("formato semaforo vinus")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100);

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(4);

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
$titulo_izquierdo = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
	)
);

//Estilo de los bordes
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

$texto_derecha = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
	)
);

$titulo_centrado_negrita = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

//Se declara el numero de la hoja en la que se va a trabajar
$cont = 1;
$hoja = 1;

// Se hace el recorrido por unidades funcionales
foreach ($unidades_funcionales as $unidad) {
	//Si la hoja es la primera
	if($cont == 1){
		//Titulo de la hoja
		$hoja = $objPHPExcel->getActiveSheet()->setTitle($unidad->Nombre);
	} else {

		// Nueva hoja
		$hoja = $objPHPExcel->createSheet();
		
		// Titulo de la hoja
		$hoja->setTitle($unidad->Nombre);
	} // if

	//Se establece la configuracion de la pagina
	$hoja->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
	$hoja->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
	$hoja->getPageSetup()->setScale(100); //Escala

	//Se establecen las margenes
	$hoja->getPageMargins()->setTop(0,90); //Arriba
	$hoja->getPageMargins()->setRight(0,70); //Derecha
	$hoja->getPageMargins()->setLeft(0,70); //Izquierda
	$hoja->getPageMargins()->setBottom(0,90); //Abajo

	/*
	 * Definicion de la anchura de las columnas
	 */
	$hoja->getColumnDimension('A')->setWidth(0.70);
	$hoja->getColumnDimension('B')->setWidth(27);

	/**
	 * Definicion de la altura de las celdas
	 */
	$hoja->getRowDimension(1)->setRowHeight(5);
	$hoja->getRowDimension(2)->setRowHeight(40);
	$hoja->getRowDimension(3)->setRowHeight(40);

	// Combinar celdas
	$hoja->mergeCells('B2:B3');

	// Se declara la columna donde inicia
	$columna = "C";

	$cont_columna = 1;

	// Se consultan los predios del tramo específico
	$predios = $this->PrediosDAO->obtener_predio_semaforo();

	// Se hace el recorrido de predios del tramo
	foreach ($predios as $predio) {
		// Se declara la fila donde inicia
		$fila = 5;

		/*
		 * Definicion de la anchura de las columnas
		 */
		$hoja->getColumnDimension($columna)->setWidth(16);

		$ficha = explode('-', $predio->ficha_predial); // Se divide la ficha para sacar unidad y número

		if (count($ficha) > 2) {
			// Se pone en vez de F o M, Área
			$nombre_ficha = "$ficha[0]-$ficha[1] Área $ficha[3]";
		} else {
			// Ficha normal
			$nombre_ficha = $predio->ficha_predial;
		} // if

		// Número de predio
		$hoja->setCellValue($columna.$fila, $nombre_ficha);
		
		// Aumento de fila
		$fila++;

		// Si tiene un id en el estado del Semáforo
		if ($predio->id_funcion_predio) {
			// Se colorea la celda con el color que viene según el id
			$objPHPExcel->getActiveSheet()->getStyle($columna.$fila)->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => $predio->color_funcion )));
		} // if

		// Aumento de fila
		$fila++;

		$color_disponible = "4F7F2C";
		$color_no_disponible = "FF0000";


		// Si El predio está marcado como dispo
		if ($predio->estado_predio == 1) {
			// Color verde
			$color_disponibilidad = $color_disponible;
		} else {
			// Color rojo
			$color_disponibilidad = $color_no_disponible;
		} // if

		// Se colorea la celda con el color que viene según el id
		$hoja->getStyle($columna.$fila)->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => $color_disponibilidad )));

		// Aumento de fila
		$fila++;

		// Si tiene un id en el estado del Semáforo
		if ($predio->id_estado_via) {
			// Se colorea la celda con el color que viene según el id
			$objPHPExcel->getActiveSheet()->getStyle($columna.$fila)->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => $predio->color_estado )));
		} // if

		// Aumento de fila
		$fila++;

		/**
		 * Definicion de la altura de las celdas
		 */
		$hoja->getRowDimension($fila)->setRowHeight(5);
		
		// Aumento de fila
		$fila++;

		// Margen
		$hoja->setCellValue($columna.$fila, $predio->margen);

		// Aumento de fila
		$fila++;

		// Para el abscisado inicial
		$ms_inicial = substr($predio->abscisa_inicial, -3);
		$kms_inicial = substr($predio->abscisa_inicial, 0, strlen($predio->abscisa_inicial) - 3);
		if($kms_inicial == "") {
			$kms_inicial = "0";
		} // if

		// Para el abscisado final
		$ms_final = substr($predio->abscisa_final, -3);
		$kms_final = substr($predio->abscisa_final, 0, strlen($predio->abscisa_final) - 3);
		if($kms_final == "") {
			$kms_final = "0";
		} // if

		// Abscisa inicial
		$hoja->setCellValue($columna.$fila, "PR $kms_inicial + $ms_inicial");

		// Aumento de fila
		$fila++;

		// Abscisa final
		$hoja->setCellValue($columna.$fila, "PR $kms_final + $ms_final");

		// Aumento de fila
		$fila++;

		// Longitud efectiva
		$hoja->setCellValue($columna.$fila, $predio->abscisa_final - $predio->abscisa_inicial);
		$objPHPExcel->getActiveSheet()->getStyle($columna.$fila)->getNumberFormat()->setFormatCode("#,##0"); // estilo

		// Si es el antepenúltimo recorrido del predio
		if ($cont_columna == (count($predios) - 3)) {
			// Se guarda la columna
			$columna_cabecera = $columna;
		} // if

		// Si es el penúltimo recorrido del predio
		if ($cont_columna == (count($predios) - 2)) {
			// Se guarda la columna
			$columna_titulo = $columna;
		} // if

		// Si es el penúltimo recorrido del predio
		if ($cont_columna == (count($predios) - 1)) {
			// Se guarda la columna
			$columna_datos_inicio = $columna;
		} // if

		// Si es el penúltimo recorrido del predio
		if ($cont_columna == (count($predios))) {
			// Se guarda la columna
			$columna_datos_fin = $columna;
		} // if

		$columna++;
		$cont_columna++;
	} // foreach predios

	// Estilo de los bordes
	$hoja->getStyle("B2:{$columna_datos_fin}3")->applyFromArray($bordes);

	//Celdas a combinar
	$hoja->mergeCells("C2:{$columna_cabecera}3");
	$hoja->mergeCells("{$columna_datos_inicio}2:{$columna_datos_fin}2");
	$hoja->mergeCells("{$columna_datos_inicio}3:{$columna_datos_fin}3");

	/**
	 * Aplicacion de los estilos
	 */
	$hoja->getStyle("B2:B{$fila}")->applyFromArray($titulo_izquierdo);
	$hoja->getStyle("B5:{$columna}5")->applyFromArray($titulo_centrado_negrita);
	$hoja->getStyle("C2")->applyFromArray($titulo_centrado_negrita);
	$hoja->getStyle("{$columna_titulo}2:{$columna_titulo}3")->applyFromArray($titulo_izquierdo);
	$hoja->getStyle("C11:{$columna}12")->applyFromArray($texto_derecha);

	//Logo
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo Concesión Vías del NUS S.A.S.');
	$objDrawing->setDescription('Logo de uso exclusivo de Concesión Vías del NUS S.A.S.');
	$objDrawing->setPath('img/logo_vinus.jpg');
	$objDrawing->setCoordinates('B2');
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objDrawing->setHeight(90);
	$objDrawing->setOffsetX(45);
	$objDrawing->setOffsetY(10);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	$objDrawing->getShadow()->setDirection(40);

	/*
	 * Encabezado
	 */
	$hoja->setCellValue('C2', 'FORMATO 4 - SEMÁFORO PREDIAL');
	$hoja->setCellValue($columna_titulo.'2', 'Fecha de generación');
	$hoja->setCellValue($columna_titulo.'3', 'Unidad funcional');
	$hoja->setCellValue('B5', 'Ficha predial');
	$hoja->setCellValue('B6', 'Función del predio en obra');
	$hoja->setCellValue('B7', 'Estado del predio');
	$hoja->setCellValue('B8', 'Estado de la vía');
	$hoja->setCellValue('B10', 'Margen');
	$hoja->setCellValue('B11', 'Abscisa inicial');
	$hoja->setCellValue('B12', 'Abscisa final');
	$hoja->setCellValue('B13', 'Longitud efectiva');
	$hoja->setCellValue($columna_datos_inicio.'2', $this->InformesDAO->formatear_fecha(date('Y-m-d')));
	$hoja->setCellValue($columna_datos_inicio.'3', $unidad->Nombre);

	// Estilo de los bordes
	$hoja->getStyle("B5:{$columna_datos_fin}8")->applyFromArray($bordes);
	$hoja->getStyle("B10:{$columna_datos_fin}13")->applyFromArray($bordes);

	// Se declara la fila donde inicia
	$fila =	$fila + 4;
	$fila2 = $fila + 1;

	// Combinación de celdas
	$hoja->mergeCells("B{$fila}:B{$fila2}");

	// Título
	$hoja->setCellValue("B".$fila, "Función del predio en obra");

	// Columna inicial
	$columna_inicial = "C";
	
	// Se recorren las funciones del predio en obra
	foreach ($funciones as $funcion) {
		// Color
		$objPHPExcel->getActiveSheet()->getStyle($columna_inicial.$fila)->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => $funcion->color )));
		
		// Aumento de la fila
		$fila++;

		// Nombre		
		$hoja->setCellValue($columna_inicial.$fila, $funcion->nombre);
		
		// Aumento de columna y disminución de fila
		$columna_inicial++;
		$fila--;
	} // foreach funciones

	// Aumento de fila
	$fila = $fila + 3;
	$fila2 = $fila + 1;

	// Combinación de celdas
	$hoja->mergeCells("B{$fila}:B{$fila2}");

	// Título
	$hoja->setCellValue("B".$fila, "Estado de la vía");

	// Columna inicial
	$columna_inicial = "C";

	// Se recorren los estados de la vía
	foreach ($estados_via as $estado_via) {
		// Color
		$objPHPExcel->getActiveSheet()->getStyle($columna_inicial.$fila)->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => $estado_via->color )));
		
		// Aumento de la fila
		$fila++;

		// Nombre		
		$hoja->setCellValue($columna_inicial.$fila, $estado_via->nombre);
		
		// Aumento de columna y disminución de fila
		$columna_inicial++;
		$fila--;
	} // foreach estados_via

	// Aumento de fila
	$fila = $fila + 3;
	$fila2 = $fila + 1;

	// Combinación de celdas
	$hoja->mergeCells("B{$fila}:B{$fila2}");

	// Título
	$hoja->setCellValue("B".$fila, "Estado del predio");

	// Columna inicial
	$columna_inicial = "C";

	// Color
	$objPHPExcel->getActiveSheet()->getStyle($columna_inicial.$fila)->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => $color_disponible)));
	
	// Aumento de la fila
	$fila++;

	// Nombre		
	$hoja->setCellValue($columna_inicial.$fila, "Disponible");
	
	// Aumento de columna y disminución de fila
	$columna_inicial++;
	$fila--;

	// Color
	$objPHPExcel->getActiveSheet()->getStyle($columna_inicial.$fila)->getFill()->applyFromArray(array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array( 'rgb' => $color_no_disponible)));
	
	// Aumento de la fila
	$fila++;

	// Nombre		
	$hoja->setCellValue($columna_inicial.$fila, "No disponible");


	//Se aumenta el numero de la hoja y contador
	$hoja++;
	$cont++;
} // foreach unidades_funcionales

// Se disminuye el contador de hojas
$hoja--;

// Establece la primera hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

/*
 *
 * Pie de pagina
 *
 */
// $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&HPlease treatthis document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Formato_Semaforo.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>