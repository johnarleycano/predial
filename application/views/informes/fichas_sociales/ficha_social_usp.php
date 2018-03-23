<?php

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
$hoja = $objPHPExcel->getActiveSheet();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("Luis David Moreno - Concesión Vías del Nus - Vinus")
	->setLastModifiedBy("Luis David Moreno")
	->setTitle("Sistema de Gestión Predial Vinus - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Ficha social - Unidad social productiva")
    ->setCategory("Reporte");


//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10); //Tamaño
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
// $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$hoja->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$hoja->getPageSetup()->setScale(90);

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$hoja->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(3);

// Título de la hoja
$hoja->setTitle("Unidad social productiva");

//Se establecen las margenes
$hoja->getPageMargins()->setTop(0.10); //Arriba
$hoja->getPageMargins()->setRight(0); //Derecha
$hoja->getPageMargins()->setLeft(0.7); //Izquierda
$hoja->getPageMargins()->setBottom(0.3); //Abajo

//Centrar página
$hoja->getPageSetup()->setHorizontalCentered();

/*******************************************************
*********************** Estilos ***********************
*******************************************************/
$izquierda_align = array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT ) ); // Alineación centrada
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

$bordes_externos = array(
  'borders' => array(
    'outline' => array(
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

$texto_izquierda = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    )
);

 // variable para guardar valor tamaño de una fila estrecha y el numero de la fila
$filas_estrechas = array();

$hoja->getStyle("A1:N50")->applyFromArray($centrado);

// Asignación del tamaño de las columnas
for ($columna="A"; $columna < "J"; $columna++) {
	$hoja->getColumnDimension($columna)->setWidth(11.5);
}

// asignacion del tamaño de las filas
for ($i=6; $i <= 50; $i++) {
	$hoja->getRowDimension($i)->setRowHeight(20);
}

// Asignación del tamaño de las filas y aplicacion de bordes
for ($i=1; $i <= 3; $i++) {
	$hoja->getRowDimension($i)->setRowHeight(26);
	$hoja->getStyle("A{$i}:I{$i}")->applyFromArray($bordes);
}

// Logos
// Logo Vinus
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo Devimed');
$objDrawing->setDescription('');
$objDrawing->setPath('./img/log.png');
$objDrawing->setCoordinates('G1');
$objDrawing->setHeight(60);
$objDrawing->setWidth(60);
$objDrawing->setOffsetX(10);
$objDrawing->setOffsetY(15);
$objDrawing->getShadow()->setDirection(160);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// logo ANI
$objDrawing2 = new PHPExcel_Worksheet_Drawing();
$objDrawing2->setName('Logo ANI');
$objDrawing2->setDescription('Logo de uso exclusivo de ANI');
$objDrawing2->setPath('./img/logo_ani.jpg');
$objDrawing2->setCoordinates('A1');
$objDrawing2->setHeight(50);
$objDrawing2->setWidth(120);
$objDrawing2->setOffsetX(20);
$objDrawing2->setOffsetY(10);
$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());

//encabezado
$fila = 1;

$hoja->mergeCells("A{$fila}:B3");
$hoja->mergeCells("C{$fila}:F{$fila}");
$hoja->mergeCells("G{$fila}:G3");
$hoja->getStyle("H{$fila}")->applyFromArray($negrita);
$hoja->setCellValue("C{$fila}", 'CONCESIÓN VÍAS DEL NUS - VINUS');
$hoja->setCellValue("H{$fila}", 'Código:');
$hoja->setCellValue("I{$fila}", 'F014');
$fila++;

$hoja->mergeCells("C{$fila}:F3");
$hoja->setCellValue("C{$fila}", 'FICHA SOCIAL - FORMATO DE CARACTERIZACIÓN DE UNIDAD SOCIAL PRODUCTIVA');
$hoja->getStyle("H{$fila}")->applyFromArray($negrita);
$hoja->setCellValue("H{$fila}", 'Versión:');
$hoja->setCellValueExplicit("I{$fila}", 'V1.00', PHPExcel_Cell_DataType::TYPE_STRING);
$fila++;

$hoja->getStyle("H{$fila}")->applyFromArray($negrita);
$hoja->setCellValue("H{$fila}", 'Fecha');
$hoja->setCellValue("I{$fila}", '9/08/2016');
$fila++;


// Contenido
$hoja->mergeCells("A{$fila}:I{$fila}");
array_push($filas_estrechas, $fila);
$fila++;

$hoja->mergeCells("A{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($relleno_gris);
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($negrita);
$hoja->setCellValue("A{$fila}", '1. DATOS GENERALES');
$fila++;

$hoja->mergeCells("B{$fila}:C{$fila}");
$hoja->mergeCells("E{$fila}:F{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:C{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("D{$fila}:F{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("G{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Proyecto');
$hoja->setCellValue("B{$fila}", 'Vías del Nus');
$hoja->setCellValue("D{$fila}", 'Ficha predial');

$unidad = explode('-', $unidad_productiva->ficha_predial); // Se divide la ficha para sacar unidad y número

if (count($unidad) > 2) {
	// Se pone en vez de F o M, Área
	$nombre_ficha = "$unidad[0]-$unidad[1] Área $unidad[3]";
} else {
	// Ficha normal
	$nombre_ficha = $unidad_productiva->ficha_predial;
} // if

$hoja->setCellValue("E{$fila}", $nombre_ficha);
$hoja->setCellValue("G{$fila}", 'Tramo');
$hoja->setDinamicSizeRow($predio->tramo, $fila, 'H:I');
$fila++;

$hoja->mergeCells("B{$fila}:C{$fila}");
$hoja->mergeCells("E{$fila}:F{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:C{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("D{$fila}:F{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("G{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Municipio');
$hoja->setCellValue("B{$fila}", $predio->municipio);
$hoja->setDinamicSizeRow('Vereda / Barrio', $fila, 'D:E');
$hoja->setCellValue("E{$fila}", $predio->barrio);
$hoja->setCellValue("G{$fila}", 'Dirección');
$hoja->setDinamicSizeRow($predio->direccion, $fila, "H:I");
$fila++;

$hoja->mergeCells("A{$fila}:B{$fila}");
$hoja->mergeCells("D{$fila}:F{$fila}");
$hoja->mergeCells("G{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:C{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("D{$fila}:F{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("G{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Unidad Social Nro.');
$hoja->setCellValue("C{$fila}", '1');
$hoja->setCellValue("D{$fila}", 'Relación con el inmueble');
$hoja->setCellValue("G{$fila}", $relacion_inmueble->nombre);
$fila_aux = $fila - 3;
$hoja->getStyle("A{$fila_aux}:I{$fila}")->applyFromArray($borde_negrita_externo);
$fila++;

$hoja->mergeCells("A{$fila}:I{$fila}");
array_push($filas_estrechas, $fila);
$fila++;

$fila_aux = $fila;
$hoja->mergeCells("A{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($relleno_gris);
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($negrita);
$hoja->setCellValue("A{$fila}", '2. IDENTIFICACIÓN DE LA UNIDAD SOCIAL PRODUCTIVA');
$fila++;

$hoja->mergeCells("B{$fila}:F{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:F{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("G{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Titular');
$hoja->setCellValue("B{$fila}", $unidad_productiva->titular);
$hoja->setCellValue("G{$fila}", 'Identificación');
$hoja->setCellValue("H{$fila}", $unidad_productiva->identificacion);
$fila++;

$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("D{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Datos de verificación');
$hoja->setDinamicSizeRow($unidad_productiva->datos_verificacion, $fila, 'D:I');
$fila++;

$hoja->mergeCells("A{$fila}:B{$fila}");
$hoja->mergeCells("C{$fila}:F{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:F{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("G{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Nombre y/o razón social');
$hoja->setCellValue("C{$fila}", $unidad_productiva->razon_social);
$hoja->setCellValue("G{$fila}", 'NIT');
$hoja->setCellValue("H{$fila}", $unidad_productiva->nit);
$fila++;

$hoja->mergeCells("A{$fila}:D{$fila}");
$hoja->mergeCells("E{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Descripción de la actividad desarrollada');
$hoja->setCellValue("E{$fila}", $unidad_productiva->descripcion_actividad);
$fila++;

$hoja->mergeCells("A{$fila}:F{$fila}");
$hoja->mergeCells("G{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", '¿Cuánto tiempo hace que desarrolla la actividad en el inmueble?');
$hoja->setCellValue("G{$fila}", $unidad_productiva->antiguedad);
$fila++;

$hoja->mergeCells("A{$fila}:D{$fila}");
$hoja->mergeCells("F{$fila}:G{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:E{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("F{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Valor del Canon de arrendamiento (si existe)');
$hoja->setCellValue("E{$fila}", $unidad_productiva->canon);
$hoja->setCellValue("F{$fila}", 'Próximo vencimiento');
$hoja->setCellValue("H{$fila}", $unidad_productiva->fecha_vencimiento_contrato);
$fila++;

$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("G{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:E{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("F{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", '¿Lleva algún tipo de contabilidad?');
$hoja->setCellValue("D{$fila}", ($unidad_productiva->lleva_contabilidad) ? "SI _X_" : "SI ___");
$hoja->setCellValue("E{$fila}", (!$unidad_productiva->lleva_contabilidad) ? "NO _X_" : "NO ___");
$hoja->setCellValue("F{$fila}", '¿Cuál?');
$hoja->setCellValue("G{$fila}", $unidad_productiva->contabilidad);
$fila++;

$hoja->mergeCells("A{$fila}:I{$fila}");
$hoja->setCellValue("A{$fila}", '¿Cuenta con los siguientes documentos para el desarrollo de la actividad?');
$fila++;

$valores_f = array();

foreach ($valores_fichas as $valor_ficha) {
	array_push($valores_f, $valor_ficha->id_valor_social);
}

$col1 = 'A';
$col2 = 'C';
$contador = 1;

foreach ($this->Gestion_socialDAO->cargar_valores_ficha(10) as $valor10) {
	$hoja->mergeCells("{$col1}{$fila}:{$col2}{$fila}");
    $hoja->getStyle("{$col1}{$fila}:{$col2}{$fila}")->applyFromArray($texto_izquierda);
	$hoja->setCellValue("{$col1}{$fila}", (in_array($valor10->id, $valores_f)) ? 	'_X_ '.$valor10->nombre : '___ '.$valor10->nombre );

    if ($contador % 3 == 0) {
        for ($i=0; $i < 3; $i++) {
            $col1++;
            $col2++;
        }
        $fila -= 3;
    }
    $contador++;
    $fila++;
}

$fila += 3;

$hoja->mergeCells("A{$fila}:G{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", '¿Cuánto considera que recibe por utilidades netas mensuales aproximadamente?');
$hoja->setCellValue("H{$fila}", $unidad_productiva->utilidades_netas);
$fila++;

$hoja->mergeCells("A{$fila}:D{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:F{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("G{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setDinamicSizeRow('En caso de poder continuar la actividad, estaría interesado', $fila, 'A:D');
$hoja->setCellValue("E{$fila}", ($unidad_productiva->continua_actividad) ? "SI _X_" : "SI ___");
$hoja->setCellValue("F{$fila}", (!$unidad_productiva->continua_actividad) ? "NO _X_" : "NO ___");
$hoja->setCellValue("G{$fila}", '¿Por qué?');
$hoja->setDinamicSizeRow($unidad_productiva->continua_actividad_razon, $fila, 'H:I');
$hoja->getStyle("A{$fila_aux}:I{$fila}")->applyFromArray($borde_negrita_externo);
$fila++;

$hoja->mergeCells("A{$fila}:I{$fila}");
array_push($filas_estrechas, $fila);
$fila++;

$fila_aux = $fila;
$hoja->mergeCells("A{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($relleno_gris);
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($negrita);
$hoja->setCellValue("A{$fila}", '3. ARRENDADORES');
$fila++;

$hoja->mergeCells("B{$fila}:F{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:F{$fila}")->applyFromArray($bordes_externos);
$hoja->getStyle("G{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Nombre');
$hoja->setCellValue("B{$fila}", $unidad_productiva->nombre_arrendador);
$hoja->setCellValue("G{$fila}", 'Identificación');
$hoja->setCellValue("H{$fila}", $unidad_productiva->identificacion_arrendador);
$fila++;

$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("D{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Datos de verificación');
$hoja->setDinamicSizeRow($unidad_productiva->datos_contacto, $fila, 'D:I');
$fila++;

$hoja->mergeCells("A{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes_externos);
$hoja->setCellValue("A{$fila}", 'Contratos de arrendamiento en ejecución');
$fila++;

$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("D{$fila}:E{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes);
$hoja->setCellValue("A{$fila}", 'Nombre e identificación del arrendatario');
$hoja->setCellValue("D{$fila}", 'Objeto del contrato');
$hoja->setCellValue("F{$fila}", 'Fecha suscripción');
$hoja->setCellValue("G{$fila}", 'Fecha terminación');
$hoja->setCellValue("H{$fila}", 'Valor canon mensual');
$hoja->setDinamicSizeRow('Valor terminación anticipada', $fila, 'I:J');
$fila++;


$arrendatarios = array(	'nombre_arrendatario1' => $unidad_productiva->nombre_arrendatario1,
						'nombre_arrendatario2' => $unidad_productiva->nombre_arrendatario2,
						'nombre_arrendatario3' => $unidad_productiva->nombre_arrendatario3,
						'nombre_arrendatario4' => $unidad_productiva->nombre_arrendatario4,
						'nombre_arrendatario5' => $unidad_productiva->nombre_arrendatario5,
						'objeto_contrato1' => $unidad_productiva->objeto_contrato1,
						'objeto_contrato2' => $unidad_productiva->objeto_contrato2,
						'objeto_contrato3' => $unidad_productiva->objeto_contrato3,
						'objeto_contrato4' => $unidad_productiva->objeto_contrato4,
						'objeto_contrato5' => $unidad_productiva->objeto_contrato5,
						'fecha_suscripcion1' => $unidad_productiva->fecha_suscripcion1,
						'fecha_suscripcion2' => $unidad_productiva->fecha_suscripcion2,
						'fecha_suscripcion3' => $unidad_productiva->fecha_suscripcion3,
						'fecha_suscripcion4' => $unidad_productiva->fecha_suscripcion4,
						'fecha_suscripcion5' => $unidad_productiva->fecha_suscripcion5,
						'fecha_terminacion1' => $unidad_productiva->fecha_terminacion1,
						'fecha_terminacion2' => $unidad_productiva->fecha_terminacion2,
						'fecha_terminacion3' => $unidad_productiva->fecha_terminacion3,
						'fecha_terminacion4' => $unidad_productiva->fecha_terminacion4,
						'fecha_terminacion5' => $unidad_productiva->fecha_terminacion5,
						'valor_canon_mensual1' => $unidad_productiva->valor_canon_mensual1,
						'valor_canon_mensual2' => $unidad_productiva->valor_canon_mensual2,
						'valor_canon_mensual3' => $unidad_productiva->valor_canon_mensual3,
						'valor_canon_mensual4' => $unidad_productiva->valor_canon_mensual4,
						'valor_canon_mensual5' => $unidad_productiva->valor_canon_mensual5,
						'valor_terminacion_anticipada1' => $unidad_productiva->valor_terminacion_anticipada1,
						'valor_terminacion_anticipada2' => $unidad_productiva->valor_terminacion_anticipada2,
						'valor_terminacion_anticipada3' => $unidad_productiva->valor_terminacion_anticipada3,
						'valor_terminacion_anticipada4' => $unidad_productiva->valor_terminacion_anticipada4,
						'valor_terminacion_anticipada5' => $unidad_productiva->valor_terminacion_anticipada5);



for ($i=1; $i <= 5 ; $i++) {
	if (!$arrendatarios['nombre_arrendatario'.$i]) {break;}
	$hoja->mergeCells("A{$fila}:C{$fila}");
	$hoja->mergeCells("D{$fila}:E{$fila}");
	$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes);
	$hoja->setCellValue("A{$fila}", $arrendatarios['nombre_arrendatario'.$i]);
	$hoja->setCellValue("D{$fila}", $arrendatarios['objeto_contrato'.$i]);
	$hoja->setCellValue("F{$fila}", $arrendatarios['fecha_suscripcion'.$i]);
	$hoja->setCellValue("G{$fila}", $arrendatarios['fecha_terminacion'.$i]);
	$hoja->setCellValue("H{$fila}", $arrendatarios['valor_canon_mensual'.$i]);
	$hoja->setCellValue("I{$fila}", $arrendatarios['valor_terminacion_anticipada'.$i]);
	$fila++;
}

$fila--;
$hoja->getStyle("A{$fila_aux}:I{$fila}")->applyFromArray($borde_negrita_externo);
$fila++;

$hoja->mergeCells("A{$fila}:I{$fila}");
array_push($filas_estrechas, $fila);
$fila++;


$fila_aux = $fila;
$hoja->mergeCells("A{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($relleno_gris);
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($negrita);
$hoja->getStyle("A{$fila_aux}:I{$fila}")->applyFromArray($bordes);
$hoja->setCellValue("A{$fila}", '4. APORTE DE DOCUMENTOS');
$fila++;
$fila_aporte = $fila;

$izquierda = array();
foreach ($archivos as $archivo) {
	$hoja->mergeCells("A{$fila}:I{$fila}");
	$hoja->setCellValue("A{$fila}", "");
	$hoja->setCellValue("A{$fila}", $archivo->descripcion);
	array_push($izquierda, $fila);
	$fila++;
}

if (count($archivos) > 0) { $fila--; }

$hoja->getStyle("A{$fila_aux}:I{$fila}")->applyFromArray($borde_negrita_externo);
$fila++;

$hoja->mergeCells("A{$fila}:I{$fila}");
array_push($filas_estrechas, $fila);
$fila++;

$fila_aux = $fila;
$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("D{$fila}:F{$fila}");
$hoja->mergeCells("G{$fila}:I{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($relleno_gris);
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes);
$hoja->setCellValue("A{$fila}", 'Fecha de levantamiento de la información');
$hoja->setCellValue("D{$fila}", 'El profesional social certifica que en la fecha se levantó la información contenida en el presente documento');
$hoja->setDinamicSizeRow('El titular de la actividad certifica que en la fecha atendió personalmente la entrevista, y verificó la contenida en el presente documento', $fila, 'G:I');
$fila++;

$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("D{$fila}:F{$fila}");
$hoja->mergeCells("G{$fila}:H{$fila}");
$hoja->getStyle("A{$fila}:I{$fila}")->applyFromArray($bordes);
$hoja->getRowDimension($fila)->setRowHeight(60);
$hoja->getStyle("A{$fila_aux}:I{$fila}")->applyFromArray($borde_negrita_externo);

// Asignación de las filas estrechas
foreach ($filas_estrechas as $f) {
	$hoja->getRowDimension($f)->setRowHeight(5.7);
}

// alineacion a la izquierda
foreach ($izquierda as $f) {
	$hoja->getStyle("A{$f}:N{$f}")->applyFromArray($izquierda_align);
}

if (count($archivos) == 0) {
	$hoja->getRowDimension($fila_aporte)->setRowHeight(40);
	$hoja->getStyle("A{$fila_aporte}:I{$fila_aporte}")->applyFromArray($negrita);
}

header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$unidad_productiva->ficha_predial.' - Unidad Social Productiva".xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
