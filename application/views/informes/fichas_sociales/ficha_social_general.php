<?php
//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
$hoja = $objPHPExcel->getActiveSheet();

$valores_f = array();

foreach ($valores_fichas as $valor_ficha) {
	array_push($valores_f, $valor_ficha->id_valor_social);
}
//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("Luis David Moreno - Concesión Vías del Nus - Vinus")
	->setLastModifiedBy("Luis David Moreno")
	->setTitle("Sistema de Gestión Predial Vinus - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Ficha social - Caracterización general del inmueble")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9); //Tamaño
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
// $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$hoja->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL); //Tamano oficio
$hoja->getPageSetup()->setScale(100);

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$hoja->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(3);

// Título de la hoja
$hoja->setTitle("Caracterización general");

// //Se establecen las margenes
// $hoja->getPageMargins()->setTop(1); //Arriba
// $hoja->getPageMargins()->setRight(0.55); //Derecha
// $hoja->getPageMargins()->setLeft(0.55); //Izquierda
// $hoja->getPageMargins()->setBottom(1); //Abajo

//Centrar página
$hoja->getPageSetup()->setHorizontalCentered();

/*******************************************************
 *********************** Estilos ***********************
 *******************************************************/
 $centrado = array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER ) ); // Alineación centrada
 $negrita = array( 'font' => array( 'bold' => true ) ); // negrita

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

$hoja->getStyle("A1:N55")->applyFromArray($centrado);
// Logos
// Logo Vinus
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo Devimed');
$objDrawing->setDescription('');
$objDrawing->setPath('./img/logo.png');
$objDrawing->setCoordinates('J1');
$objDrawing->setHeight(60);
$objDrawing->setWidth(55);
$objDrawing->setOffsetX(20);
$objDrawing->setOffsetY(5);
$objDrawing->getShadow()->setDirection(160);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


// logo ANI
$objDrawing2 = new PHPExcel_Worksheet_Drawing();
$objDrawing2->setName('Logo ANI');
$objDrawing2->setDescription('Logo de uso exclusivo de ANI');
$objDrawing2->setPath('./img/logo_ani.jpg');
$objDrawing2->setCoordinates('A1');
$objDrawing2->setHeight(50);
$objDrawing2->setWidth(90);
$objDrawing2->setOffsetX(35);
$objDrawing2->setOffsetY(5);
$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());

/*
 * Definicion de la anchura de las columnas
 */
$columna = "A";
// Asingnacion del tamaño de las columnas y filas
for ($i=1; $i <= 50; $i++) {
	$hoja->getColumnDimension($columna)->setWidth(7.2);
	$hoja->getRowDimension($i)->setRowHeight(20);
	// siguiente columna
	$columna++;
} // for

//Celdas a combinar
$hoja->mergeCells('A1:C3');
$hoja->mergeCells('D1:I1');
$hoja->mergeCells('D2:I3');

$hoja->mergeCells('J1:K3');

$hoja->mergeCells('M1:N1');
$hoja->mergeCells('M2:N2');
$hoja->mergeCells('M3:N3');

$hoja->mergeCells('A5:N5');

$hoja->mergeCells('A6:B6');
$hoja->mergeCells('C6:E6');
$hoja->mergeCells('F6:G6');
$hoja->mergeCells('H6:I6');
$hoja->mergeCells('K6:N6');

$hoja->mergeCells('A7:B7');
$hoja->mergeCells('C7:E7');
$hoja->mergeCells('F7:G7');
$hoja->mergeCells('H7:I7');
$hoja->mergeCells('K7:N7');

$hoja->mergeCells('A8:C8');
$hoja->mergeCells('D8:N8');

$hoja->mergeCells('A9:C9');
$hoja->mergeCells('D9:N9');

$hoja->mergeCells('A11:N11');

$hoja->mergeCells('A12:E12');
$hoja->mergeCells('F12:G12');
$hoja->mergeCells('H12:I12');
$hoja->mergeCells('J12:L12');

$hoja->mergeCells('A13:G13');
$hoja->mergeCells('J13:N13');

$hoja->mergeCells('A14:B14');
$hoja->mergeCells('C14:D14');
$hoja->mergeCells('E14:F14');
$hoja->mergeCells('G14:H14');
$hoja->mergeCells('I14:J14');
$hoja->mergeCells('K14:L14');
$hoja->mergeCells('M14:N14');

$hoja->mergeCells('A15:L15');

$hoja->mergeCells('A16:D16');
$hoja->mergeCells('G16:L16');

$hoja->mergeCells('A17:E17');
$hoja->mergeCells('H17:I17');
$hoja->mergeCells('J17:N17');

$hoja->mergeCells('A19:C20');
$hoja->mergeCells('D19:E20');
$hoja->mergeCells('F19:N19');

$hoja->mergeCells('F20:H20');
$hoja->mergeCells('I20:K20');
$hoja->mergeCells('L20:N20');

//Encabezados
$hoja->getStyle("A1:C3")->applyFromArray($bordes);
$hoja->getStyle("J1:K3")->applyFromArray($bordes);
$hoja->getStyle("D2:I3")->applyFromArray($bordes);
$hoja->getStyle("A1:N1")->applyFromArray($bordes);
$hoja->getStyle("A2:N2")->applyFromArray($bordes);
$hoja->getStyle("A3:N3")->applyFromArray($bordes);
$hoja->setCellValue('D1', 'CONCESIÓN VÍAS DEL NUS - VINUS');
$hoja->setCellValue('D2', 'FICHA SOCIAL - FORMATO DE CARACTERIZACIÓN GENERAL DE INMUEBLE');
$hoja->setCellValue('L1', 'Código:');
$hoja->setCellValue('L2', 'Versión:');
$hoja->setCellValue('L3', 'Fecha:');
$hoja->setCellValue('M1', 'F012');
$hoja->setCellValueExplicit('M2', '1.00', PHPExcel_Cell_DataType::TYPE_STRING);
$hoja->setCellValue('M3', '31/5/2016');



// Contenido
$hoja->mergeCells('A4:N4');
$hoja->getRowDimension(4)->setRowHeight(5.7);

$hoja->getStyle("A5:N5")->applyFromArray($bordes);
$hoja->getStyle("A4:N4")->applyFromArray($bordes);
$hoja->getStyle("A5:N5")->applyFromArray($relleno_gris);
$hoja->setCellValue('A5', '1. DATOS GENERALES');

$hoja->getStyle("A6:N6")->applyFromArray($bordes);
$hoja->setCellValue('A6', 'Proyecto:');
$hoja->setCellValue('C6', 'Vias del Nus');
$hoja->setCellValue('F6', 'Ficha predial:');

$unidad = explode('-', $ficha); // Se divide la ficha para sacar unidad y número

if (count($unidad) > 2) {
	// Se pone en vez de F o M, Área
	$nombre_ficha = "$unidad[0]-$unidad[1] Área $unidad[3]";
} else {
	// Ficha normal
	$nombre_ficha = $ficha;
} // if

$hoja->setCellValue('H6', $nombre_ficha);
$hoja->setCellValue('J6', 'Tramo:');
$hoja->setCellValue('K6', $predio->tramo);

$hoja->getStyle("A7:N7")->applyFromArray($bordes);
$hoja->setCellValue('A7', 'Municipio:');
$hoja->setCellValue('C7', $predio->municipio);
$hoja->setCellValue('F7', 'Vereda / Barrio:');
$hoja->setCellValue('H7', $predio->barrio);
$hoja->setCellValue('J7', 'Dirección:');
$hoja->setCellValue('K7', $predio->direccion);

$hoja->getStyle("A8:N8")->applyFromArray($bordes);
$hoja->setCellValue('A8', 'Propietario:');
$hoja->setCellValue('D8', $predio->nombre_propietario);

$hoja->getStyle("A9:N9")->applyFromArray($bordes);
$hoja->setCellValue('A9', 'Datos de contacto:');
$hoja->setCellValue('D9', $predio->direccion_propietario." / ".$predio->telefono_propietario." / ".$predio->email_propietario);

$hoja->getRowDimension(10)->setRowHeight(5.7);
$hoja->mergeCells('A10:N10');

$hoja->getStyle("A11:N11")->applyFromArray($bordes);
$hoja->getStyle("A11:N11")->applyFromArray($relleno_gris);
$hoja->setCellValue('A11', '2. CARACTERISTCAS DEL INMUEBLE');

$hoja->getStyle("A12:N12")->applyFromArray($bordes);
$hoja->setCellValue('A12', 'Requerimiento del terreno por el proyecto:');
$hoja->setCellValue('F12', 'TOTAL ___');
$hoja->setCellValue('H12', 'PARCIAL ___');

if ($ficha_social->requerimiento_terreno == "1") {
	$hoja->setCellValue('H12', 'PARCIAL _X_');
} else if ($ficha_social->requerimiento_terreno == "2") {
	$hoja->setCellValue('F12', 'TOTAL _X_');
}

$hoja->setCellValue('J12', '¿Se requieren edificaciones?');
$hoja->setCellValue('M12', 'SI ___');
$hoja->setCellValue('N12', 'NO ___');

if ($ficha_social->requerimiento_edificaciones == "1") {
	$hoja->setCellValue('M12', 'SI _X_');
} else if($ficha_social->requerimiento_edificaciones == "0") {
	$hoja->setCellValue('N12', 'NO _X_');
}

$hoja->getStyle("A13:N13")->applyFromArray($bordes);
$hoja->setCellValue('A13', '¿El valor del área a adquirir es inferior a 3 SLMMV?');
$hoja->setCellValue('H13', 'SI ___');
$hoja->setCellValue('I13', 'NO ___');

if ($ficha_social->area_adquirir == "1") {
	$hoja->setCellValue('H13', 'SI _X_');
} else if($ficha_social->area_adquirir == "0"){
	$hoja->setCellValue('I13', 'NO _X_');
}

$hoja->setCellValue('J13', 'Usos actuales del inmueble:');

$col = "A";
$hoja->getStyle("A14:N14")->applyFromArray($bordes);
foreach ($this->Gestion_socialDAO->cargar_valores_ficha(1) as $valor1) {
	if(in_array($valor1->id, $valores_f)) {$check = "X";} else {$check = "_";}
		$hoja->setCellValue("{$col}14", $valor1->nombre."_".$check."_");
		$col++;
		$col++;
}

// Si tiene otros usos
if ($ficha_social->otros_usos != "") {
	// Otros usos
	$hoja->setCellValue("{$col}14", "{$ficha_social->otros_usos} _X_");
} // if

$hoja->getStyle("A15:N15")->applyFromArray($bordes);
$hoja->setCellValue('A15', '¿En el área no requerida se puede restablecer el uso actual(en caso de requerimiento parcial)?:');
$hoja->setCellValue('M15', 'SI ___');
$hoja->setCellValue('N15', 'NO ___');
if ($ficha_social->restablecer_uso_area_no_requerida == "1") {
	$hoja->setCellValue('M15', 'SI _X_');
} else if($ficha_social->restablecer_uso_area_no_requerida == "0"){
	$hoja->setCellValue('N15', 'NO _X_');
}

$hoja->getStyle("A16:N16")->applyFromArray($bordes);
$hoja->setCellValue('A16', '¿Existe vivienda en el inmueble?');
$hoja->setCellValue('E16', 'SI ___');
$hoja->setCellValue('F16', 'NO ___');

if ($ficha_social->existe_vivienda == "1") {
	$hoja->setCellValue('E16', 'SI _X_');
} else if($ficha_social->existe_vivienda == "0"){
	$hoja->setCellValue('F16', 'NO _X_');
}

$hoja->setCellValue('G16', '¿La vivienda se encuentra habitada?');
$hoja->setCellValue('M16', 'SI ___');
$hoja->setCellValue('N16', 'NO ___');

if ($ficha_social->vivienda_habitada == "1") {
	$hoja->setCellValue('M16', 'SI _X_');
} else if($ficha_social->vivienda_habitada == "0") {
	$hoja->setCellValue('N16', 'NO _X_');
}


$hoja->getStyle("A17:N17")->applyFromArray($bordes);
$hoja->setCellValue('A17','¿La vivienda se requiere para el proyecto?');
$hoja->setCellValue('F17','SI ___');
$hoja->setCellValue('G17','NO ___');
$hoja->setCellValue('H17','PARCIAL ___');

switch ($ficha_social->requerida_proyecto) {
	case '0':
		$hoja->setCellValue('G17','NO _X_');
		break;

	case '1':
		$hoja->setCellValue('F17','SI _X_');
		break;

	case '2':
		$hoja->setCellValue('H17','PARCIAL _X_');
		break;
}

$hoja->setCellValue('J17', 'Condiciones actuales del inmueble:');

$hoja->getRowDimension(18)->setRowHeight(5.7);
$hoja->mergeCells("A18:N18");

$hoja->getStyle("A19:N19")->applyFromArray($bordes);
$hoja->setCellValue('A19', 'Servicios básicos');
$hoja->setCellValue("D19", 'Distribucion por numero de:');
$hoja->setCellValue("F19", 'Material predominante');

$hoja->getStyle("A20:N20")->applyFromArray($bordes);
$hoja->setCellValue("F20", 'Paredes');
$hoja->setCellValue("I20", 'Pisos');
$hoja->setCellValue("L20", 'Techo');

$fila = 21;
foreach ($this->Gestion_socialDAO->cargar_valores_ficha(2) as $valor2) {
	if(in_array($valor1->id, $valores_f)) {$check = "X";} else {$check = "";}
		$objPHPExcel->getActiveSheet()->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
		$hoja->setCellValue("A{$fila}", $valor2->nombre);
		$hoja->setCellValue("C{$fila}", $check);
		$hoja->mergeCells("A{$fila}:B{$fila}");
		$hoja->mergeCells("F{$fila}:G{$fila}");
		$hoja->mergeCells("I{$fila}:J{$fila}");
		$hoja->mergeCells("L{$fila}:M{$fila}");
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($fila + 1, 1);
		$fila++;
}

// Distribucion por numero de:
$fila = 21;
$hoja->setCellValue("D{$fila}", "Alcobas");
$hoja->setCellValue("E{$fila}", $ficha_social->distribucion_alcobas);
$fila++;

$hoja->setCellValue("D{$fila}", "Cocinas");
$hoja->setCellValue("E{$fila}", $ficha_social->distribucion_cocinas);
$fila++;

$hoja->setCellValue("D{$fila}", "Salas");
$hoja->setCellValue("E{$fila}", $ficha_social->distribucion_sala);
$fila++;

$hoja->setCellValue("D{$fila}", "Comedor");
$hoja->setCellValue("E{$fila}", $ficha_social->distribucion_comedor);
$fila++;

//Paredes
$fila = 21;
foreach ($this->Gestion_socialDAO->cargar_valores_ficha(4) as $valor4) {
	if(in_array($valor4->id, $valores_f)) {$check = "X";} else {$check = "";}
	$hoja->setCellValue("F{$fila}", $valor4->nombre);
	$hoja->setCellValue("H{$fila}", $check);
	$fila++;
}

//Pisos
$fila = 21;
foreach ($this->Gestion_socialDAO->cargar_valores_ficha(5) as $valor5) {
	if(in_array($valor5->id, $valores_f)) {$check = "X";} else {$check = "";}
	$hoja->setCellValue("I{$fila}", $valor5->nombre);
	$hoja->setCellValue("K{$fila}", $check);
	$fila++;
}

//Techo
$fila = 21;
foreach ($this->Gestion_socialDAO->cargar_valores_ficha(6) as $valor6) {
	if(in_array($valor6->id, $valores_f)) {$check = "X";} else {$check = "";}
	$hoja->setCellValue("L{$fila}", $valor6->nombre);
	$hoja->setCellValue("N{$fila}", $check);
	$fila++;
}

$hoja->getRowDimension($fila)->setRowHeight(5.7);
$hoja->mergeCells("A{$fila}:N{$fila}");
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->mergeCells("A{$fila}:L{$fila}");
$hoja->setCellValue("A{$fila}", "¿Existen edificaciones con infraesructura mínima para el desarrollo de actividades productivas?");
$hoja->setCellValue("M{$fila}", "SI ___");
$hoja->setCellValue("N{$fila}", "NO ___");
if ($ficha_social->edificaciones_unidades_productivas == "1") {
	$hoja->setCellValue("M{$fila}", "SI _X_");
} else if($ficha_social->edificaciones_unidades_productivas == "0"){
	$hoja->setCellValue("N{$fila}", "NO _X_");
}
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->mergeCells("A{$fila}:B{$fila}");
$hoja->mergeCells("C{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "¿Cuáles?");
$hoja->setCellValue("C{$fila}", $ficha_social->edificaciones_unidades_productivas_descripcion);
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->getRowDimension($fila)->setRowHeight(5.7);
$hoja->mergeCells("A{$fila}:N{$fila}");
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->mergeCells("A{$fila}:N{$fila}");
$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($relleno_gris);
$hoja->setCellValue("A{$fila}", "3. UNIDADES SOCIALES IDENTIFICADAS");
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->mergeCells("A{$fila}:E{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->mergeCells("k{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "¿Existen unidades sociales identificadas?");
$hoja->setCellValue("F{$fila}", "SI ___");
$hoja->setCellValue("G{$fila}", "NO ___");
$hoja->setCellValue("H{$fila}", "¿Cuantas?");
$fila++;
$fila++;

$unidades_identificadas = 0;
foreach ($unidades_productivas as $unidad_productiva) {
	$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
	$unidades_identificadas++;
	$hoja->mergeCells("B{$fila}:C{$fila}");
	$hoja->mergeCells("D{$fila}:E{$fila}");
	$hoja->mergeCells("F{$fila}:H{$fila}");
	$hoja->mergeCells("I{$fila}:J{$fila}");
	$hoja->mergeCells("K{$fila}:N{$fila}");
	$hoja->setCellValue("A{$fila}", $unidades_identificadas);
	$hoja->setCellValue("B{$fila}", "USP");
	$hoja->setCellValue("D{$fila}", $unidad_productiva->relacion_inmueble);
	$hoja->setCellValue("F{$fila}", $unidad_productiva->titular);
	$hoja->setCellValue("I{$fila}", $unidad_productiva->arrendatarios);
	$fila++;
}

foreach ($unidades_residentes as $unidad_residente) {
	$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
	$unidades_identificadas++;
	$hoja->mergeCells("B{$fila}:C{$fila}");
	$hoja->mergeCells("D{$fila}:E{$fila}");
	$hoja->mergeCells("F{$fila}:H{$fila}");
	$hoja->mergeCells("I{$fila}:J{$fila}");
	$hoja->mergeCells("K{$fila}:N{$fila}");
	$hoja->setCellValue("A{$fila}", $unidades_identificadas);
	$hoja->setCellValue("B{$fila}", "USR");
	$hoja->setCellValue("D{$fila}", $unidad_residente->relacion_inmueble);
	$hoja->setCellValue("F{$fila}", $unidad_residente->responsable);
	$hoja->setCellValue("I{$fila}", $unidad_residente->integrantes);
	$fila++;
}

$fila2 = $fila - $unidades_identificadas - 2;
$fila3 = $fila2 + 1;

if ($unidades_identificadas > 0) {
	$hoja->setCellValue("F{$fila2}", "SI _X_");
	$hoja->setCellValue("K{$fila2}", "Identificación:");
	$hoja->getStyle("A{$fila3}:N{$fila3}")->applyFromArray($bordes);
	$hoja->mergeCells("B{$fila3}:C{$fila3}");
	$hoja->mergeCells("D{$fila3}:E{$fila3}");
	$hoja->mergeCells("F{$fila3}:H{$fila3}");
	$hoja->mergeCells("I{$fila3}:J{$fila3}");
	$hoja->mergeCells("K{$fila3}:N{$fila3}");
	$hoja->setCellValue("A{$fila3}", "Nro");
	$hoja->setCellValue("B{$fila3}", "Categoría");
	$hoja->setCellValue("D{$fila3}", "Relacion con el inmueble");
	$hoja->setCellValue("F{$fila3}", "Responsable unidad social");
	$hoja->setCellValue("I{$fila3}", "Numero de integrantes");
	$hoja->setCellValue("K{$fila3}", "Firma del responsable de la unidad social");
} else {
	$hoja->setCellValue("G{$fila2}", "NO _X_");
	$hoja->getStyle("A{$fila3}:N{$fila3}")->applyFromArray($bordes);
	$hoja->getRowDimension($fila3)->setRowHeight(0);
}

// cuantas unidades sociales identificadas hay
$hoja->setCellValue("J{$fila2}", $unidades_identificadas);

$hoja->getRowDimension($fila)->setRowHeight(5.7);
$hoja->mergeCells("A{$fila}:N{$fila}");
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->mergeCells("A{$fila}:N{$fila}");
$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($relleno_gris);
$hoja->setCellValue("A{$fila}", "4. OBSERVACIONES");
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->mergeCells("A{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", $ficha_social->observaciones);
if (strlen($ficha_social->observaciones) > 0) {
	$hoja->setDinamicSizeRow($ficha_social->observaciones, $fila, "A:N");
}
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->getRowDimension($fila)->setRowHeight(5.7);
$hoja->mergeCells("A{$fila}:N{$fila}");
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->mergeCells("A{$fila}:D{$fila}");
$hoja->mergeCells("E{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Fecha de levantamiento de la información");
$hoja->setCellValue("E{$fila}", "El profesional social certifica que en la fecha se levantó la inforacion contenida en el presente documento");
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$fila2 = $fila + 1;
$hoja->mergeCells("A{$fila}:D{$fila2}");
$hoja->mergeCells("E{$fila}:I{$fila}");
$hoja->mergeCells("J{$fila}:N{$fila}");
$hoja->setCellValue("E{$fila}", "Nombre / Cargo");
$hoja->setCellValue("J{$fila}", "Firma / CC");
$fila++;

$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($bordes);
$hoja->mergeCells("E{$fila}:I{$fila}");
$hoja->mergeCells("J{$fila}:N{$fila}");

$objPHPExcel->getActiveSheet()->getStyle("A1:N{$fila}")->applyFromArray($borde_negrita_externo);

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$nombre_ficha.' - Caracterización general".xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>
