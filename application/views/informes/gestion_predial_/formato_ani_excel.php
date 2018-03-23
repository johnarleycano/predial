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
	->setTitle("Concesión Vías del Nus - Sistema de Gestión Predial Vinus (generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A').")")
	->setSubject("Ficha predial - Formato ANI")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Tahoma'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8); //Tamaño
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(70);

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
// $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 25);
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(19);

//Se establecen las margenes
// $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.10); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.50); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.50); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,90); //Abajo

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered();
$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Ocultar la cuadrícula:
$objPHPExcel->getActiveSheet()->setShowGridlines(false);

/*******************************************************
 *********************** Estilos ***********************
 *******************************************************/
$centrado = array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER ) );
$negrita = array( 'font' => array( 'bold' => true ) );
$tamanio9 = array ( 'font' => array( 'size' => 9 ) );
$tamanio10 = array ( 'font' => array( 'size' => 10 ) );
$tamanio11 = array ( 'font' => array( 'size' => 11 ) );
$tamanio12 = array ( 'font' => array( 'size' => 12 ) );
$tamanio13 = array ( 'font' => array( 'size' => 13 ) );
$tamanio14 = array ( 'font' => array( 'size' => 14 ) );
$rojo = array( 'font' => array ( 'color' => array( 'argb' => 'FF0F0F' ) ) );
$arial = array( 'font' => array( 'name' => 'Arial' ) );
$tahoma = array( 'font' => array( 'name' => 'Tahoma' ) );

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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('c')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(1);

//Tamaño de celdas
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(11)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(19)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(20)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(24)->setRowHeight(70);
$objPHPExcel->getActiveSheet()->getRowDimension(25)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(26)->setRowHeight(5);
if (trim($predio->observacion) == "") {
	$objPHPExcel->getActiveSheet()->getRowDimension(64)->setRowHeight(40);
} // if
$objPHPExcel->getActiveSheet()->getRowDimension(65)->setRowHeight(5);



//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("B2:B10");
$objPHPExcel->getActiveSheet()->mergeCells("B13:F13");
$objPHPExcel->getActiveSheet()->mergeCells("B14:B15");
$objPHPExcel->getActiveSheet()->mergeCells("B17:B18");
$objPHPExcel->getActiveSheet()->mergeCells("B21:V21");
$objPHPExcel->getActiveSheet()->mergeCells("B22:E22");
$objPHPExcel->getActiveSheet()->mergeCells("B23:E23");
$objPHPExcel->getActiveSheet()->mergeCells("B24:E24");
$objPHPExcel->getActiveSheet()->mergeCells("C2:E10");
$objPHPExcel->getActiveSheet()->mergeCells("C14:F15");
$objPHPExcel->getActiveSheet()->mergeCells("C16:F16");
$objPHPExcel->getActiveSheet()->mergeCells("C17:F18");
$objPHPExcel->getActiveSheet()->mergeCells("F2:J4");
$objPHPExcel->getActiveSheet()->mergeCells("F5:J8");
$objPHPExcel->getActiveSheet()->mergeCells("F9:J10");
$objPHPExcel->getActiveSheet()->mergeCells("F22:L22");
$objPHPExcel->getActiveSheet()->mergeCells("F23:L23");
$objPHPExcel->getActiveSheet()->mergeCells("F24:L24");
$objPHPExcel->getActiveSheet()->mergeCells("I13:V13");
$objPHPExcel->getActiveSheet()->mergeCells("I14:L14");
$objPHPExcel->getActiveSheet()->mergeCells("I15:L15");
$objPHPExcel->getActiveSheet()->mergeCells("I16:L16");
$objPHPExcel->getActiveSheet()->mergeCells("I17:L17");
$objPHPExcel->getActiveSheet()->mergeCells("I18:L18");
$objPHPExcel->getActiveSheet()->mergeCells("I19:L19");
$objPHPExcel->getActiveSheet()->mergeCells("M2:P2");
$objPHPExcel->getActiveSheet()->mergeCells("M14:O14");
$objPHPExcel->getActiveSheet()->mergeCells("M15:O15");
$objPHPExcel->getActiveSheet()->mergeCells("M16:O16");
$objPHPExcel->getActiveSheet()->mergeCells("M17:O17");
$objPHPExcel->getActiveSheet()->mergeCells("M18:O18");
$objPHPExcel->getActiveSheet()->mergeCells("M19:O19");
$objPHPExcel->getActiveSheet()->mergeCells("M22:Q22");
$objPHPExcel->getActiveSheet()->mergeCells("M23:Q23");
$objPHPExcel->getActiveSheet()->mergeCells("M24:Q24");
$objPHPExcel->getActiveSheet()->mergeCells("M3:P3");
$objPHPExcel->getActiveSheet()->mergeCells("N5:O5");
$objPHPExcel->getActiveSheet()->mergeCells("N7:O7");
$objPHPExcel->getActiveSheet()->mergeCells("Q2:V2");
$objPHPExcel->getActiveSheet()->mergeCells("Q3:V3");
$objPHPExcel->getActiveSheet()->mergeCells("Q5:S7");
$objPHPExcel->getActiveSheet()->mergeCells("Q14:S14");
$objPHPExcel->getActiveSheet()->mergeCells("Q15:S15");
$objPHPExcel->getActiveSheet()->mergeCells("Q16:S16");
$objPHPExcel->getActiveSheet()->mergeCells("Q17:S17");
$objPHPExcel->getActiveSheet()->mergeCells("Q18:S18");
$objPHPExcel->getActiveSheet()->mergeCells("Q19:S19");
$objPHPExcel->getActiveSheet()->mergeCells("R22:V22");
$objPHPExcel->getActiveSheet()->mergeCells("R23:V23");
$objPHPExcel->getActiveSheet()->mergeCells("R24:V24");
$objPHPExcel->getActiveSheet()->mergeCells("T5:V7");
$objPHPExcel->getActiveSheet()->mergeCells("T9:U9");
$objPHPExcel->getActiveSheet()->mergeCells("T10:U10");
$objPHPExcel->getActiveSheet()->mergeCells("T14:V14");
$objPHPExcel->getActiveSheet()->mergeCells("T15:V15");
$objPHPExcel->getActiveSheet()->mergeCells("T16:V16");
$objPHPExcel->getActiveSheet()->mergeCells("T17:V17");
$objPHPExcel->getActiveSheet()->mergeCells("T18:V18");
$objPHPExcel->getActiveSheet()->mergeCells("T19:V19");

//Logo ANI
$objDrawing2 = new PHPExcel_Worksheet_Drawing();
$objDrawing2->setName('Logo ANI');
$objDrawing2->setDescription('Logo de uso exclusivo de ANI');
$objDrawing2->setPath('./img/logo_ani.jpg');
$objDrawing2->setCoordinates('B2');
$objDrawing2->setWidth(135);
$objDrawing2->setOffsetX(31);
$objDrawing2->setOffsetY(6);
$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());

//Logo Vinus
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo Vinus');
$objDrawing->setDescription('Logo de uso exclusivo de Vinus');
$objDrawing->setPath('./img/logo_vinus.jpg');
$objDrawing->setCoordinates('D2');
$objDrawing->setHeight(95);
$objDrawing->setOffsetX(47);
$objDrawing->setOffsetY(6);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//Encabezados
($predio->abreviatura == "M") ? $nombre = "MEJORATARIO" : $nombre = "PROPIETARIO" ;
$objPHPExcel->getActiveSheet()->setCellValue('B13', 'INFORMACIÓN DEL '.$nombre);
$objPHPExcel->getActiveSheet()->setCellValue('B14', 'NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('B16', 'CÉDULA');
$objPHPExcel->getActiveSheet()->setCellValue('B17', 'DIRECCIÓN / EMAIL');
$objPHPExcel->getActiveSheet()->setCellValue('B21', 'COLINDANTES');
$objPHPExcel->getActiveSheet()->setCellValue('B22', 'NORTE');
$objPHPExcel->getActiveSheet()->setCellValue('F22', 'SUR');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'MINISTERIO DE TRANSPORTE');
$objPHPExcel->getActiveSheet()->setCellValue('F5', 'AGENCIA NACIONAL DE INFRAESTRUCTURA');
$objPHPExcel->getActiveSheet()->setCellValue('F9', 'FICHA PREDIAL');
$objPHPExcel->getActiveSheet()->setCellValue('I13', 'IDENTIFICACIÓN DEL PREDIO');
$objPHPExcel->getActiveSheet()->setCellValue('I14', 'DEPARTAMENTO');
$objPHPExcel->getActiveSheet()->setCellValue('I15', 'MUNICIPIO');
$objPHPExcel->getActiveSheet()->setCellValue('I16', 'VEREDA / BARRIO');
$objPHPExcel->getActiveSheet()->setCellValue('I17', 'DIRECCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('I18', 'CLASIFICACIÓN SUELO');
$objPHPExcel->getActiveSheet()->setCellValue('M14', 'ANTIOQUIA');
$objPHPExcel->getActiveSheet()->setCellValue('M22', 'ORIENTE');
$objPHPExcel->getActiveSheet()->setCellValue('N9', 'K');
$objPHPExcel->getActiveSheet()->setCellValue('N10', 'K');
$objPHPExcel->getActiveSheet()->setCellValue('R22', 'OCCIDENTE');
$objPHPExcel->getActiveSheet()->setCellValue('M2', 'PROYECTO DE CONCESIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('M3', 'NÚMERO DE CONTRATO');
$objPHPExcel->getActiveSheet()->setCellValue('M5', 'UNIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('M7', 'PREDIO');
$objPHPExcel->getActiveSheet()->setCellValue('M9', 'ABSCISA INICIAL');
$objPHPExcel->getActiveSheet()->setCellValue('M10', 'ABSCISA FINAL');
$objPHPExcel->getActiveSheet()->setCellValue('Q2', 'CONCESIÓN VÍAS DEL NUS');
$objPHPExcel->getActiveSheet()->setCellValue('Q3', '01 DE 2016');
$objPHPExcel->getActiveSheet()->setCellValue('Q5', 'SECTOR O TRAMO');
$objPHPExcel->getActiveSheet()->setCellValue('Q9', 'MARGEN');
$objPHPExcel->getActiveSheet()->setCellValue('Q10', 'MARGEN');
$objPHPExcel->getActiveSheet()->setCellValue('Q14', 'REQUIERIDO PARA');
$objPHPExcel->getActiveSheet()->setCellValue('Q15', 'ACTIVIDAD ECONÓMICA');
$objPHPExcel->getActiveSheet()->setCellValue('Q16', 'TOPOGRAFÍA');
$objPHPExcel->getActiveSheet()->setCellValue('Q17', 'MATRÍCULA');
$objPHPExcel->getActiveSheet()->setCellValue('Q18', 'CÉDULA CATASTRAL');
$objPHPExcel->getActiveSheet()->setCellValue('T9', 'LONGITUD EFECTIVA');
$objPHPExcel->getActiveSheet()->setCellValue('T10', 'L.E. REQUERIDA');
$objPHPExcel->getActiveSheet()->setCellValue('V10', $predio->requiere_longitud_efectiva);
$objPHPExcel->getActiveSheet()->setCellValue('T14', 'USO DE VÍA');

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
} // IF

// Datos
$objPHPExcel->getActiveSheet()->setCellValue('N5', $predio->unidad_funcional);
$objPHPExcel->getActiveSheet()->setCellValue('N7', "$predio->unidad_funcional-$predio->predio $predio->tipo_ficha $predio->numero_faja");
$objPHPExcel->getActiveSheet()->setCellValue('C14', $predio->nombre_propietario.$propietarios_adicionales);
$objPHPExcel->getActiveSheet()->setCellValue('C16', $predio->documento_propietario);
$objPHPExcel->getActiveSheet()->setDinamicSizeRow($predio->direccion_propietario, 17, "C:H");
$objPHPExcel->getActiveSheet()->setCellValue('N5', $predio->unidad_funcional);
$objPHPExcel->getActiveSheet()->setCellValue('O9', "$kms_inicial + $ms_inicial");
$objPHPExcel->getActiveSheet()->setCellValue('O10', "$kms_final + $ms_final");
$objPHPExcel->getActiveSheet()->setCellValue('R9', $predio->margen_inicial);
$objPHPExcel->getActiveSheet()->setCellValue('R10', $predio->margen_final);
$objPHPExcel->getActiveSheet()->setCellValue('T5', $predio->tramo);
$objPHPExcel->getActiveSheet()->setCellValue('V9', $predio->abscisa_final - $predio->abscisa_inicial);
$objPHPExcel->getActiveSheet()->setCellValue('M15', $predio->municipio);
$objPHPExcel->getActiveSheet()->setCellValue('M16', $predio->barrio);
$objPHPExcel->getActiveSheet()->setCellValue('M17', $predio->direccion);
$objPHPExcel->getActiveSheet()->setCellValue('M18', $predio->uso_terreno);
$objPHPExcel->getActiveSheet()->setCellValue('T15', $predio->uso_edificacion);
$objPHPExcel->getActiveSheet()->setCellValue('T16', $predio->topografia);
$objPHPExcel->getActiveSheet()->setCellValue('T17', $predio->matricula);
$objPHPExcel->getActiveSheet()->setCellValue('T18', " ".$predio->no_catastral);
$objPHPExcel->getActiveSheet()->setCellValue('B23', $predio->norte_long);
$objPHPExcel->getActiveSheet()->setCellValue('F23', $predio->sur_long);
$objPHPExcel->getActiveSheet()->setCellValue('M23', $predio->oriente_long);
$objPHPExcel->getActiveSheet()->setCellValue('R23', $predio->occidente_long);
$objPHPExcel->getActiveSheet()->setDinamicSizeRow(trim($predio->nom_norte), 24, "B:E");
$objPHPExcel->getActiveSheet()->setDinamicSizeRow(trim($predio->nom_sur), 24, "F:L");
$objPHPExcel->getActiveSheet()->setDinamicSizeRow(trim($predio->nom_oriente), 24, "M:Q");
$objPHPExcel->getActiveSheet()->setDinamicSizeRow(trim($predio->nom_occ), 24, "R:V");

// Bordes externos en negrita
$objPHPExcel->getActiveSheet()->getStyle("A1:E11")->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle("A12:G19")->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle("A20:W25")->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle("F1:K11")->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle("H12:W19")->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle("L1:W11")->applyFromArray($borde_negrita_externo);

// Bordes externos punteados
$objPHPExcel->getActiveSheet()->getStyle("B13:F18")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B21:V24")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B22:E24")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("F22:L24")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("M22:Q24")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("R22:V24")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("I13:V18")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("M2:V2")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("M3:V3")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("M5:O5")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("M7:O7")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("M9:O9")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("M10:O10")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("Q5:V7")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("Q9:R9")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("Q10:R10")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("T9:V9")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("T10:V10")->applyFromArray($borde_puntos_externo);


// Negrita
$objPHPExcel->getActiveSheet()->getStyle("B13:V13")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("B14:B19")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("B21:V23")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("B27:F28")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("F2:J10")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("I14:I19")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("I27:V28")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("M2:V3")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("M5:M10")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("Q5:Q10")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("Q14:Q19")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("T9:T10")->applyFromArray($negrita);

// Relleno gris
$objPHPExcel->getActiveSheet()->getStyle("B13")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("B21")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("I13")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("M2:P3")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("M5")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("M7")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("M9:M10")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("Q5")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("Q9:Q10")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("T9:T10")->applyFromArray($relleno_gris);

// Texto en colores
$objPHPExcel->getActiveSheet()->getStyle("F9")->applyFromArray($rojo);

// Tamaños de texto diferentes al original

// Se borran las filas donde va a ir información de cultivos, construcciones y construcciones anexas
// $objPHPExcel->getActiveSheet()->removeRow(30,24);

/********************************************************************
************ Cultivos, especies y construcciones ********************
********************************************************************/
// Se consultan los cultivos, construcciones y construcciones anexas
$cultivos = $this->PrediosDAO->obtener_cultivos($ficha);
$construcciones = $this->PrediosDAO->obtener_construcciones($ficha, '1');
$construcciones_anexas = $this->PrediosDAO->obtener_construcciones($ficha, '2');

// Se cuentan los cultivos y las construcciones
$total_cultivos = count($cultivos);
$total_construcciones = count($construcciones) + count($construcciones_anexas);

// Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("B27:F27");
$objPHPExcel->getActiveSheet()->mergeCells("C28:D28");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("B27:F27")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B28")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("C28:D28")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("E28")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("F28")->applyFromArray($borde_puntos_externo);


// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('B27', 'INVENTARIO DE CULTIVOS Y ESPECIES');
$objPHPExcel->getActiveSheet()->setCellValue('B28', 'DESCRIPCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('F28', 'UNIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('C28', 'CANTIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('E28', 'DENSIDAD');

// // Se almacena el tamaño del espacio para cultivos y construcciones
// $tamanio_valores = 250;

// Fila inicial
$fila_cultivo = 29;

// Contador de cultivos
$cont_cultivos = 0;

// Si hay cultivos
if (count($cultivos) > 0) {
	// Recorrido para llenar el dato de los cultivos y especies
	foreach ($cultivos as $cultivo) {
		// Aumento contador de cultivos
		$cont_cultivos++;

		// Se crea la fila
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($fila_cultivo + 1, 1);

		// Celdas a combinar
		$objPHPExcel->getActiveSheet()->mergeCells("C{$fila_cultivo}:D{$fila_cultivo}");

		// Estilos
		$objPHPExcel->getActiveSheet()->getStyle("C{$fila_cultivo}:E{$fila_cultivo}")->getNumberFormat()->setFormatCode('#,##0');

		// Estilos
		$objPHPExcel->getActiveSheet()->getStyle("B{$fila_cultivo}")->applyFromArray($borde_puntos_externo);
		$objPHPExcel->getActiveSheet()->getStyle("C{$fila_cultivo}:D{$fila_cultivo}")->applyFromArray($borde_puntos_externo);
		$objPHPExcel->getActiveSheet()->getStyle("E{$fila_cultivo}")->applyFromArray($borde_puntos_externo);
		$objPHPExcel->getActiveSheet()->getStyle("E{$fila_cultivo}")->applyFromArray($borde_puntos_externo);
		$objPHPExcel->getActiveSheet()->getStyle("F{$fila_cultivo}")->applyFromArray($borde_puntos_externo);

		// Datos
		$objPHPExcel->getActiveSheet()->setDinamicSizeRow(trim($cultivo->descripcion), $fila_cultivo, "B:C");
		$objPHPExcel->getActiveSheet()->setCellValue("C{$fila_cultivo}", $cultivo->cantidad);
		$objPHPExcel->getActiveSheet()->setCellValue("E{$fila_cultivo}", $cultivo->densidad);
		$objPHPExcel->getActiveSheet()->setCellValue("F{$fila_cultivo}", $cultivo->unidad);
		// // $objPHPExcel->getActiveSheet()->setCellValue("E{$fila_cultivo}", $tamanio_valores);
		// $tamanio = $objPHPExcel->getActiveSheet()->getSizeDinamicRow(trim($cultivo->descripcion), "B:C");
		
		
		 
// 	// 		// $objPHPExcel->getActiveSheet()->setCellValue("E{$fila_cultivo}", $tamanio);
// 	// 		$objPHPExcel->getActiveSheet()->setCellValue("F{$fila_cultivo}", $cultivo->unidad);

// 	// 		// se obtiene la altura con que quedó la celda
// 	// 		$tamanio = $objPHPExcel->getActiveSheet()->getRowDimension($fila)->getRowHeight();

// 	// 	// $tamanio = $objPHPExcel->getActiveSheet()->getSizeDinamicRow($cultivo->descripcion, "B:C");
// 	// 	// $objPHPExcel->getActiveSheet()->setDinamicSizeRow($tamanio, $fila, "C:D");

		// Aumento de fila
		$fila_cultivo++;
	} // foreach cultivos
}else{
	// No hay cultivos
	
} // if

// // Se almacena el tamaño del espacio para cultivos y construcciones
// $tamanio_valores = 250;

// Fila inicial
$fila_construccion = 29;

// Contador de construcicones
$cont_construcciones = 0;

// Acumulador de áreas construidas
$area_construcciones = 0;

// Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("I27:T28");
$objPHPExcel->getActiveSheet()->mergeCells("U27:U28");
$objPHPExcel->getActiveSheet()->mergeCells("V27:V28");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('I27', 'DESCRIPCIÓN DE LAS CONSTRUCCIONES');
$objPHPExcel->getActiveSheet()->setCellValue('U27', 'CANTIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('V27', 'UNIDAD');

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("I27:T28")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("U27:U28")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("V27:V28")->applyFromArray($borde_puntos_externo);

// Si hay construcciones
if (count($construcciones) > 0) {
	// Recorrido para formatear y llenar las construcciones
	foreach ($construcciones as $construccion) {
		// Aumento de contador de construcciones
		$cont_construcciones++;

		// Si la construcción es de área
		if ($construccion->unidad == "M2") {
			// Se suma el área al área total de las construcciones
			$area_construcciones += $construccion->cantidad;
		} // if

		// Si el contador de construcciones supera el contador de cultivos
		if ($cont_cultivos+1 < $cont_construcciones) {
			// Se crea la fila
			$objPHPExcel->getActiveSheet()->insertNewRowBefore($fila_construccion + 1, 1);
		} // if

		// Celdas a combinar
		$objPHPExcel->getActiveSheet()->mergeCells("I{$fila_construccion}:T{$fila_construccion}");

		// Estilos
		$objPHPExcel->getActiveSheet()->getStyle("U{$fila_construccion}")->getNumberFormat()->setFormatCode('#,##0');

		// Estilos
		$objPHPExcel->getActiveSheet()->getStyle("I{$fila_construccion}:T{$fila_construccion}")->applyFromArray($borde_puntos_externo);
		$objPHPExcel->getActiveSheet()->getStyle("U{$fila_construccion}")->applyFromArray($borde_puntos_externo);
		$objPHPExcel->getActiveSheet()->getStyle("V{$fila_construccion}")->applyFromArray($borde_puntos_externo);

		// Datos
		$objPHPExcel->getActiveSheet()->setDinamicSizeRow(trim($construccion->descripcion), $fila_construccion, "I:T");
		$objPHPExcel->getActiveSheet()->setCellValue("U{$fila_construccion}", $construccion->cantidad);
		$objPHPExcel->getActiveSheet()->setCellValue("V{$fila_construccion}", $construccion->unidad);

		// Aumento de fila
		$fila_construccion++;
	} // foreach construcciones
} // if

// Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("R{$fila_construccion}:T{$fila_construccion}");

// Datos del total de las áreas
$objPHPExcel->getActiveSheet()->setCellValue("R{$fila_construccion}", "TOTAL ÁREA CONSTRUIDA");
$objPHPExcel->getActiveSheet()->setCellValue("U{$fila_construccion}", $area_construcciones);
$objPHPExcel->getActiveSheet()->setCellValue("V{$fila_construccion}", "M2");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("R{$fila_construccion}:V{$fila_construccion}")->applyFromArray($negrita);

// Si el contador de construcciones supera el contador de cultivos
if ($cont_cultivos+1 < $cont_construcciones) {
	// Se crea la fila
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($fila_construccion + 1, 1);
} // if

// Aumento de contador de construcciones
$cont_construcciones++;

// Aumento de fila
$fila_construccion++;
$fila_construccion++;

// Aumento de contador de construcciones
$cont_construcciones = $cont_construcciones + 2;

// Si el contador de construcciones supera el contador de cultivos
if ($cont_construcciones > $cont_cultivos) {
	// Se crea la fila
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($fila_construccion, 1);
} // if

// Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila_construccion}:T{$fila_construccion}");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("I{$fila_construccion}:V{$fila_construccion}")->applyFromArray($negrita);

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("I{$fila_construccion}", 'DESCRIPCIÓN DE LAS CONSTRUCCIONES ANEXAS');
$objPHPExcel->getActiveSheet()->setCellValue("U{$fila_construccion}", 'CANTIDAD');
$objPHPExcel->getActiveSheet()->setCellValue("V{$fila_construccion}", 'UNIDAD');

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("I{$fila_construccion}:T{$fila_construccion}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("U{$fila_construccion}:U{$fila_construccion}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("V{$fila_construccion}:V{$fila_construccion}")->applyFromArray($borde_puntos_externo);

// Aumento de fila
$fila_construccion++;

// Acumulador de área de construcciones anexas
$area_construcciones_anexas = 0;

// Si hay construcciones anexas
if (count($construcciones_anexas) > 0) {
	// Recorrido para formatear y llenar las construcciones anexas
	foreach ($construcciones_anexas as $construccion_anexa) {
		// Aumento de contador de construcciones
		$cont_construcciones++;

		// Si la construcción anexa es de área
		if ($construccion_anexa->unidad == "M2") {
			// Se suma el área al área total de las construcciones anexas
			$area_construcciones_anexas += $construccion_anexa->cantidad;
		} // if

		// Si el contador de construcciones supera el contador de cultivos
		if ($cont_cultivos+1 < $cont_construcciones) {
			// Se crea la fila
			$objPHPExcel->getActiveSheet()->insertNewRowBefore($fila_construccion + 1, 1);
		} // if

		// Celdas a combinar
		$objPHPExcel->getActiveSheet()->mergeCells("I{$fila_construccion}:T{$fila_construccion}");

		// Estilos
		$objPHPExcel->getActiveSheet()->getStyle("U{$fila_construccion}")->getNumberFormat()->setFormatCode('#,##0');

		// Estilos
		$objPHPExcel->getActiveSheet()->getStyle("I{$fila_construccion}:T{$fila_construccion}")->applyFromArray($borde_puntos_externo);
		$objPHPExcel->getActiveSheet()->getStyle("U{$fila_construccion}:U{$fila_construccion}")->applyFromArray($borde_puntos_externo);
		$objPHPExcel->getActiveSheet()->getStyle("V{$fila_construccion}:V{$fila_construccion}")->applyFromArray($borde_puntos_externo);

		// Datos
		$objPHPExcel->getActiveSheet()->setDinamicSizeRow(trim($construccion_anexa->descripcion), $fila_construccion, "I:T");
		$objPHPExcel->getActiveSheet()->setCellValue("U{$fila_construccion}", $construccion_anexa->cantidad);
		$objPHPExcel->getActiveSheet()->setCellValue("V{$fila_construccion}", $construccion_anexa->unidad);

		// Aumento de fila
		$fila_construccion++;
	} // foreach construcciones anexas
} // if

// Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("R{$fila_construccion}:T{$fila_construccion}");

// Datos del total de las áreas
$objPHPExcel->getActiveSheet()->setCellValue("R{$fila_construccion}", "TOTAL ÁREA CONSTRUIDA");
$objPHPExcel->getActiveSheet()->setCellValue("U{$fila_construccion}", $area_construcciones_anexas);
$objPHPExcel->getActiveSheet()->setCellValue("V{$fila_construccion}", "M2");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("R{$fila_construccion}:V{$fila_construccion}")->applyFromArray($negrita);

// Aumento de fila
$fila_construccion++;

// Si hay más filas de cultivos que de construcciones, ahí se sigue escribiendo
($fila_cultivo > $fila_construccion) ? $fila = $fila_cultivo : $fila = $fila_construccion ;

// Nueva fila
$objPHPExcel->getActiveSheet()->insertNewRowBefore($fila, 1);

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension($fila + 1)->setRowHeight(5);

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A26:G{$fila}")->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle("H26:W{$fila}")->applyFromArray($borde_negrita_externo);

// Aumento de fila
$fila = $fila + 2;

$fila_temporal2 = $fila - 1;

// Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:F{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", 'FECHA DE ELABORACIÓN');

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("B{$fila}:F{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B{$fila}")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("B{$fila}")->applyFromArray($relleno_gris);

// Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:L{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("Q{$fila}:T{$fila}");

// Fila del área total
$fila_area_total = $fila;

// Fila del área requerida
$fila_area_requerida = $fila + 2;

// Fila del área remanente
$fila_area_remanente = $fila + 4;

// Fila del área sobrante
$fila_area_sobrante = $fila;

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", 'ÁREA TOTAL TERRENO');
$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila}", 'ÁREA SOBRANTE');
$objPHPExcel->getActiveSheet()->setCellValue("N{$fila}", 'm2');
$objPHPExcel->getActiveSheet()->setCellValue("V{$fila}", 'm2');

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", $predio->area_total_catastral);
$objPHPExcel->getActiveSheet()->setCellValue("U{$fila}", "=M{$fila_area_total}-M{$fila_area_requerida}");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("U{$fila}")->applyFromArray($borde_puntos_externo);

// Aumento de fila
$fila++;

// Fila fecha de elaboración
$fila_fecha_elaboracion = $fila;

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(5);

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $this->InformesDAO->formatear_fecha(date('Y-m-d')));

// Aumento de fila
$fila++;

// Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:L{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("Q{$fila}:T{$fila}");

// Encabezadpos
$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", 'ÁREA REQUERIDA');
$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila}", 'ÁREA TOTAL REQUERIDA');
$objPHPExcel->getActiveSheet()->setCellValue("N{$fila}", 'm2');
$objPHPExcel->getActiveSheet()->setCellValue("V{$fila}", 'm2');

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", $predio->area_requerida);
$objPHPExcel->getActiveSheet()->setCellValue("U{$fila}", "=M{$fila_area_requerida}+M{$fila_area_remanente}");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("U{$fila}")->applyFromArray($borde_puntos_externo);

// Aumento de fila
$fila++;

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(5);

// Aumento de fila
$fila++;

// Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:L{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("Q{$fila}:T{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila_fecha_elaboracion}:F{$fila}");

// Encabezados
$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", 'ÁREA REMANENTE');
$objPHPExcel->getActiveSheet()->setCellValue("N{$fila}", 'm2');

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", number_format($predio->area_residual, 3));

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("M{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B{$fila_fecha_elaboracion}:F{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("I{$fila_area_total}:L{$fila}")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("Q{$fila_area_total}:T{$fila}")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("M{$fila_area_total}:M{$fila}")->getNumberFormat()->setFormatCode('#,##0.000');
$objPHPExcel->getActiveSheet()->getStyle("U{$fila_area_total}:U{$fila}")->getNumberFormat()->setFormatCode('#,##0.000');

// Aumento de fila
$fila++;

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(5);

// Aumento de fila
$fila++;

// Fila temporal
$fila_temporal = $fila;

// Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("D{$fila}:F{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:V{$fila}");

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", 'ELABORÓ');
$objPHPExcel->getActiveSheet()->setCellValue("D{$fila}", 'REVISÓ Y APROBÓ');
$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", 'OBSERVACIONES');

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("I{$fila}:V{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("B{$fila}:V{$fila}")->applyFromArray($negrita);
$objPHPExcel->getActiveSheet()->getStyle("B{$fila}")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("D{$fila}:F{$fila}")->applyFromArray($relleno_gris);
$objPHPExcel->getActiveSheet()->getStyle("I{$fila}:V{$fila}")->applyFromArray($relleno_gris);

// Aumento de fila
$fila++;

// Combinar celdas
$objPHPExcel->getActiveSheet()->getStyle("B{$fila_temporal}:B{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->mergeCells("D{$fila}:F{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:V{$fila}");

// Datos
$objPHPExcel->getActiveSheet()->setDinamicSizeRow(trim($predio->observacion), $fila, "I:V");


// Estilos
$objPHPExcel->getActiveSheet()->getStyle("D{$fila_temporal}:F{$fila}")->applyFromArray($borde_puntos_externo);
$objPHPExcel->getActiveSheet()->getStyle("I{$fila_temporal}:V{$fila}")->applyFromArray($borde_puntos_externo);

// Aumento de fila
$fila++;

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(5);

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_temporal2}:G{$fila}")->applyFromArray($borde_negrita_externo);
$objPHPExcel->getActiveSheet()->getStyle("H{$fila_temporal2}:W{$fila}")->applyFromArray($borde_negrita_externo);

// Aumento de fila
$fila++;

// Tamaño de fila
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(5);

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Ficha predial");

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() /*. '&RPágina &P de &N'*/);

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$ficha.' Ficha predial".xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>