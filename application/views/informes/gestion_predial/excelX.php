<?php
//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("cf")
	->setLastModifiedBy("cf")
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
//Estilo de los titulos
$titulo_centrado_negrita = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

$titulo_centrado = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

$titulo_izquierdo = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
	)
);

$titulo_derecho = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
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

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(250);

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($titulo_centrado_negrita);

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Unidad funcional');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Predio');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Tramo');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Abscisa inicial');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Abscisa final');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Longitud efectiva');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Longitud efectiva requerida');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Margen');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Propietarios');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Nombres');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Documento');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Dirección');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Matrícula');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Cédula catastral');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Municipio');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Barrio / vereda');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Clasificación');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Actividad económica');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Topografía');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Área total terreno (m2)');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Área requerida (m2)');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'Área remanente (m2)');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'Área sobrante (m2)');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'Área total requerida (m2)');
$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'Lindero');

//Se declara fila
$fila = 2;
$numero = 1;

//Se recorren los predios
foreach ($this->InformesDAO->obtener_predios_agrupados() as $registro) {
	$cont = 1;
	$longitud_efectiva = 0;
	$area_total = 0;
	$area_requerida = 0;
	$area_remanente = 0;

	//Estilos
	$objPHPExcel->getActiveSheet()->getStyle("H{$fila}")->getNumberFormat()->setFormatCode("#,##0");
	$objPHPExcel->getActiveSheet()->getStyle("U{$fila}")->getNumberFormat()->setFormatCode("#,##0");
	$objPHPExcel->getActiveSheet()->getStyle("V{$fila}")->getNumberFormat()->setFormatCode("#,##0");
	$objPHPExcel->getActiveSheet()->getStyle("W{$fila}")->getNumberFormat()->setFormatCode("#,##0");
	$objPHPExcel->getActiveSheet()->getStyle("X{$fila}")->getNumberFormat()->setFormatCode("#,##0");
	$objPHPExcel->getActiveSheet()->getStyle("Y{$fila}")->getNumberFormat()->setFormatCode("#,##0");

	// Se recorren las fichas encontradas en ese predio
	foreach ($this->InformesDAO->obtener_predios_ficha(substr($registro->ficha_predial, 0, 6)) as $predio) {
		// Se carga la ficha
		$ficha = $this->InformesDAO->obtener_informe_gestion_predial_ani($predio->ficha_predial);

		// Cálculo de longitud y áreas
		$longitud_efectiva += $ficha->abscisa_final - $ficha->abscisa_inicial;
		// $area_total += $ficha->area_total_catastral;
		$area_requerida += $ficha->area_requerida;
		$area_remanente += $ficha->area_residual;

		// Si es la primera ficha
		if ($cont == 1) {
			// Se almacena la abscisa inicial
			$abscisa_inicial = $ficha->abscisa_inicial;

			// Se almacena la margen inicial
			$margen_inicial = $ficha->margen_inicial;
		} // if

		// Aumento de contador
		$cont++;
	} // foreach

	// Para el abscisado inicial
	$ms_inicial = substr($abscisa_inicial, -3);
	$kms_inicial = substr($abscisa_inicial, 0, strlen($abscisa_inicial) - 3);
	if($kms_inicial == "") {
		$kms_inicial = "0";
	}

	// Para el abscisado final
	$ms_final = substr($ficha->abscisa_final, -3);
	$kms_final = substr($ficha->abscisa_final, 0, strlen($ficha->abscisa_final) - 3);
	if($kms_final == "") {
		$kms_final = "0";
	}

	// Si son dos o más propietarios
	if ($ficha->numero_propietarios > 1) {
		// Si es mayor a dos
		if ($ficha->numero_propietarios > 2) {
			$propietarios_adicionales = " Y OTROS";
		}else{
			$propietarios_adicionales = " Y OTRO";
		}
	}else{
		$propietarios_adicionales = "";
	}

	// Datos
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", $numero);
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $ficha->unidad_funcional);
	$objPHPExcel->getActiveSheet()->setCellValue("C{$fila}", substr($ficha->ficha_predial, 0, 6));
	$objPHPExcel->getActiveSheet()->setCellValue("D{$fila}", $ficha->tramo);
	$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", $kms_inicial."+".$ms_inicial);
	$objPHPExcel->getActiveSheet()->setCellValue("F{$fila}", $kms_final."+".$ms_final);
	$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", $longitud_efectiva);
	$objPHPExcel->getActiveSheet()->setCellValue("H{$fila}", $ficha->requiere_longitud_efectiva);
	$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", "$margen_inicial-$ficha->margen_final");
	$objPHPExcel->getActiveSheet()->setCellValue("J{$fila}", $ficha->numero_propietarios);
	$objPHPExcel->getActiveSheet()->setCellValue("K{$fila}", $ficha->nombre_propietario.$propietarios_adicionales);
	$objPHPExcel->getActiveSheet()->setCellValue("L{$fila}", $ficha->documento_propietario);
	$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", $ficha->direccion);
	$objPHPExcel->getActiveSheet()->setCellValue("N{$fila}", $ficha->matricula);
	$objPHPExcel->getActiveSheet()->setCellValue("O{$fila}", $ficha->no_catastral);
	$objPHPExcel->getActiveSheet()->setCellValue("P{$fila}", $ficha->municipio);
	$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila}", $ficha->barrio);
	$objPHPExcel->getActiveSheet()->setCellValue("R{$fila}", $ficha->uso_terreno);
	$objPHPExcel->getActiveSheet()->setCellValue("S{$fila}", $ficha->uso_edificacion);
	$objPHPExcel->getActiveSheet()->setCellValue("T{$fila}", $ficha->topografia);
	$objPHPExcel->getActiveSheet()->setCellValue("U{$fila}", $ficha->area_total_catastral);
	// $objPHPExcel->getActiveSheet()->setCellValue("U{$fila}", $area_total);
	$objPHPExcel->getActiveSheet()->setCellValue("V{$fila}", $area_requerida);
	$objPHPExcel->getActiveSheet()->setCellValue("W{$fila}", $area_remanente);
	$objPHPExcel->getActiveSheet()->setCellValue("X{$fila}", "=U{$fila}-Y{$fila}");
	$objPHPExcel->getActiveSheet()->setCellValue("Y{$fila}", "=V{$fila}+W{$fila}");
	$objPHPExcel->getActiveSheet()->setCellValue("Z{$fila}", $ficha->lind_titulo);

	
	




	// //Se aumenta la fila y contador
	$fila++;
	$numero++;
} // foreach predios

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Gestión predial");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Gestión predial.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>