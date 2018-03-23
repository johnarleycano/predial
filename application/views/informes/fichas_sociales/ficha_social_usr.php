<?php
$predio = $this->InformesDAO->obtener_informe_gestion_predial_ani($unidad_residente->ficha_predial);
//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
$hoja = $objPHPExcel->getActiveSheet();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("Devimed")
	->setLastModifiedBy("Devimed")
	->setTitle("Sistema de Gestión Predial Devimed - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Ficha social - Caracterización general del inmueble")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10); //Tamaño
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
// $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$hoja->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL); //Tamano oficio
$hoja->getPageSetup()->setScale(100);

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$hoja->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(3);

// Título de la hoja
$hoja->setTitle("Unidad social residente");

//Se establecen las margenes
$hoja->getPageMargins()->setTop(0.10); //Arriba
$hoja->getPageMargins()->setRight(0.70); //Derecha
$hoja->getPageMargins()->setLeft(0.80); //Izquierda
$hoja->getPageMargins()->setBottom(0,90); //Abajo

//Centrar página
$hoja->getPageSetup()->setHorizontalCentered();

/*******************************************************
 *********************** Estilos ***********************
 *******************************************************/
 $centrado = array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER ) ); // Alineación centrada
 $izquierda_align = array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT ) ); // Alineación centrada
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

 // variable para guardar valor tamaño de una fila estrecha y el numero de la fila
$filas_estrechas = array();

$hoja->getStyle("A1:N50")->applyFromArray($centrado);

// Logos
// Logo Vinus
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo Devimed');
$objDrawing->setDescription('');
$objDrawing->setPath('./img/logo.png');
$objDrawing->setCoordinates('J1');
$objDrawing->setHeight(60);
$objDrawing->setWidth(60);
$objDrawing->setOffsetX(30);
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
$objDrawing2->setWidth(100);
$objDrawing2->setOffsetX(35);
$objDrawing2->setOffsetY(0);
$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());

//encabezado
$fila = 1;

$hoja->mergeCells("A{$fila}:C3");
$hoja->mergeCells("J{$fila}:K3");
$hoja->mergeCells("D{$fila}:I{$fila}");
$hoja->mergeCells("M{$fila}:N{$fila}");
$hoja->setCellValue("D{$fila}", "CONCESIÓN VÍAS DEL NUS - VINUS");
$hoja->setCellValue("L{$fila}", "Código:");
$hoja->setCellValue("M{$fila}", "F013");
$fila++;

$hoja->mergeCells("D{$fila}:I3");
$hoja->mergeCells("M{$fila}:N{$fila}");
$hoja->setCellValue("D{$fila}", "FICHA SOCIAL - FORMATO DE CARACTERIZACIÓN GENERAL DE INMUEBLE");
$hoja->setCellValue("L{$fila}", "Versión:");
$hoja->setCellValueExplicit("M{$fila}", "1.00", PHPExcel_Cell_DataType::TYPE_STRING);
$fila++;

$hoja->mergeCells("M{$fila}:N{$fila}");
$hoja->setCellValue("L{$fila}", "Fecha:");
$hoja->setCellValue("M{$fila}", "31/5/2016");
$fila++;

// Contenido
$hoja->mergeCells("A{$fila}:N{$fila}");
array_push($filas_estrechas, $fila);
$fila++;

$hoja->mergeCells("A{$fila}:N{$fila}");
$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($relleno_gris);
$hoja->setCellValue("A{$fila}", "1. DATOS GENERALES");
$fila++;

$hoja->mergeCells("A{$fila}:B{$fila}");
$hoja->mergeCells("C{$fila}:E{$fila}");
$hoja->mergeCells("F{$fila}:G{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->mergeCells("K{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Proyecto:");
$hoja->setCellValue("C{$fila}", "Vias del Nus");
$hoja->setCellValue("F{$fila}", "Ficha predial:");

$unidad = explode('-', $unidad_residente->ficha_predial); // Se divide la ficha para sacar unidad y número

if (count($unidad) > 2) {
	// Se pone en vez de F o M, Área
	$nombre_ficha = "$unidad[0]-$unidad[1] Área $unidad[3]";
} else {
	// Ficha normal
	$nombre_ficha = $unidad_residente->ficha_predial;
} // if


$hoja->setCellValue("H{$fila}", $nombre_ficha);
$hoja->setCellValue("J{$fila}", "Tramo:");
$hoja->setCellValue("K{$fila}", $predio->tramo);
$fila++;

$hoja->mergeCells("A{$fila}:B{$fila}");
$hoja->mergeCells("C{$fila}:E{$fila}");
$hoja->mergeCells("F{$fila}:G{$fila}");
$hoja->mergeCells("H{$fila}:I{$fila}");
$hoja->mergeCells("K{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Municipio:");
$hoja->setCellValue("C{$fila}", $predio->municipio);
$hoja->setCellValue("F{$fila}", "Vereda / Barrio:");
$hoja->setCellValue("H{$fila}", $predio->barrio);
$hoja->setCellValue("J{$fila}", "Dirección:");
$hoja->setCellValue("K{$fila}", $predio->direccion);
$fila++;

$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("D{$fila}:E{$fila}");
$hoja->mergeCells("F{$fila}:I{$fila}");
$hoja->mergeCells("J{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Unidad social nro:");
$hoja->setCellValue("D{$fila}", "1");
$hoja->setCellValue("F{$fila}", "Relacion con el inmueble");
$hoja->setCellValue("J{$fila}", $unidad_residente->relacion_inmueble);
$fila++;

array_push($filas_estrechas, $fila);
$hoja->mergeCells("A{$fila}:N{$fila}");
$fila++;

$hoja->mergeCells("A{$fila}:N{$fila}");
$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($relleno_gris);
$hoja->setCellValue("A{$fila}", "2. IDENTIFICACION DE LOS INTEGRANTES DE LA UNIDAD SOCIAL RESIDENTE");
$fila++;

$hoja->mergeCells("A{$fila}:D{$fila}");
$hoja->mergeCells("E{$fila}:H{$fila}");
$hoja->mergeCells("I{$fila}:J{$fila}");
$hoja->mergeCells("K{$fila}:L{$fila}");
$hoja->setCellValue("A{$fila}", "Responsable de la unidad social");
$hoja->setCellValue("E{$fila}", $unidad_residente->responsable);
$hoja->setCellValue("I{$fila}", "Identificación");
$hoja->setCellValue("K{$fila}", "$unidad_residente->identificacion");
$hoja->setCellValue("M{$fila}", "Edad");
$hoja->setCellValue("N{$fila}", $unidad_residente->edad);
$fila++;

$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("D{$fila}:F{$fila}");
$hoja->mergeCells("G{$fila}:J{$fila}");
$hoja->mergeCells("K{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Ocupación");
$hoja->setCellValue("D{$fila}", "$unidad_residente->ocupacion");
$hoja->setCellValue("G{$fila}", "Otras actividades");
$hoja->setCellValue("K{$fila}", $unidad_residente->otras_actividades);
$fila++;

$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("D{$fila}:E{$fila}");
$hoja->mergeCells("F{$fila}:H{$fila}");
$hoja->mergeCells("I{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Ingresos mensuales");
$hoja->setCellValue("D{$fila}", $unidad_residente->ingresos_mensuales);
$hoja->setCellValue("F{$fila}", "Datos de verificacion");
$hoja->setCellValue("I{$fila}", $unidad_residente->datos_verificacion);
$fila++;

array_push($filas_estrechas, $fila);
$hoja->mergeCells("A{$fila}:N{$fila}");
$fila++;

$hoja->mergeCells("A{$fila}:C{$fila}");
$hoja->mergeCells("D{$fila}:E{$fila}");
$hoja->mergeCells("G{$fila}:H{$fila}");
$hoja->mergeCells("I{$fila}:J{$fila}");
$hoja->mergeCells("K{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Nombre e Identificación");
$hoja->setCellValue("D{$fila}", "Relación");
$hoja->setCellValue("F{$fila}", "Edad");
$hoja->setCellValue("G{$fila}", "Ocupación");
$hoja->setCellValue("I{$fila}", "Ingresos mensuales");
$hoja->setCellValue("K{$fila}", "Datos de verificación");
$fila++;

$i = 1;
$nombre_integrante = "nombre_integrante".$i;
while ($unidad_residente->$nombre_integrante != null) {
	$i = (string)$i;
	$nombre_integrante = "nombre_integrante".$i;
	$relacion_integrante = "relacion_integrante".$i;
	$edad_integrante = "edad_integrante".$i;
	$ocupacion_integrante = "ocupacion_integrante".$i;
	$ingresos_integrante = "ingresos_integrante".$i;
	$verificacion_integrante = "verificacion_integrante".$i;
	$hoja->mergeCells("A{$fila}:C{$fila}");
	$hoja->mergeCells("D{$fila}:E{$fila}");
	$hoja->mergeCells("G{$fila}:H{$fila}");
	$hoja->mergeCells("I{$fila}:J{$fila}");
	$hoja->mergeCells("K{$fila}:N{$fila}");
	$hoja->setCellValue("A{$fila}", $unidad_residente->$nombre_integrante);
	$hoja->setCellValue("D{$fila}", $unidad_residente->$relacion_integrante);
	$hoja->setCellValue("F{$fila}", $unidad_residente->$edad_integrante);
	$hoja->setCellValue("G{$fila}", $unidad_residente->$ocupacion_integrante);
	$hoja->setCellValue("I{$fila}", $unidad_residente->$ingresos_integrante);
	$hoja->setCellValue("K{$fila}", $unidad_residente->$verificacion_integrante);
	$i++;
	$nombre_integrante = "nombre_integrante".$i;
	$fila++;
}

// si no hay ningún integrante se deja una fila en blanco
if ($i == 1) {
	$hoja->mergeCells("A{$fila}:C{$fila}");
	$hoja->mergeCells("D{$fila}:E{$fila}");
	$hoja->mergeCells("G{$fila}:H{$fila}");
	$hoja->mergeCells("I{$fila}:J{$fila}");
	$hoja->mergeCells("K{$fila}:N{$fila}");
	$fila++;
}

array_push($filas_estrechas, $fila);
$hoja->mergeCells("A{$fila}:N{$fila}");
$fila++;

$hoja->mergeCells("A{$fila}:K{$fila}");
$hoja->mergeCells("L{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "¿Cual es la suma aproximada de ingresos de la totalidad de integrantes de la unidad social?");
$hoja->setCellValue("L{$fila}", $unidad_residente->total_ingresos);
$fila++;

$hoja->mergeCells("A{$fila}:E{$fila}");
$hoja->mergeCells("F{$fila}:G{$fila}");
$hoja->mergeCells("H{$fila}:L{$fila}");
$hoja->mergeCells("M{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "¿Hace cuanto vive en esta vivienda?");
$hoja->setCellValue("F{$fila}", $unidad_residente->antiguedad);
$hoja->setCellValue("H{$fila}", "Si es arrendamiento ¿cual es el canon?");
$hoja->setCellValue("M{$fila}", $unidad_residente->canon);
$fila++;

$hoja->mergeCells("A{$fila}:G{$fila}");
$hoja->mergeCells("K{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "¿Algún mienbro de la unidad social cuenta con otro inmueble?");
$hoja->setCellValue("H{$fila}", "SI ___");
$hoja->setCellValue("I{$fila}", "NO ___");

if ($unidad_residente->integrante_posee_inmuebe) {
	$hoja->setCellValue("H{$fila}", "SI _X_");
} else {
	$hoja->setCellValue("I{$fila}", "NO _X_");
}

$hoja->setCellValue("J{$fila}", "¿Cuál?");
$hoja->setCellValue("K{$fila}", $unidad_residente->integrante_inmueble);
$fila++;

$hoja->mergeCells("A{$fila}:G{$fila}");
$hoja->mergeCells("J{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "En caso de traslado, ¿Puede hacerse a dicho inmueble?");
$hoja->setCellValue("H{$fila}", "SI ___");
$hoja->setCellValue("I{$fila}", "NO ___");

if ($unidad_residente->traslado_inmueble) {
	$hoja->setCellValue("H{$fila}", "SI _X_");
} else {
	$hoja->setCellValue("I{$fila}", "NO _X_");
}

$hoja->setCellValue("J{$fila}", "¿Por qué?");
$fila++;

$hoja->mergeCells("A{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", $unidad_residente->traslado_razon);
$fila++;

$hoja->mergeCells("A{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "¿Cuántos integrantes de la unidad social gozan de cualquiera de los siguientes servicios contratados con una entidad legalmente reconocida como para certificarlo?");
$fila++;

//servicios
$hoja->mergeCells("A{$fila}:B{$fila}");
$hoja->mergeCells("C{$fila}:D{$fila}");
$hoja->mergeCells("E{$fila}:F{$fila}");
$hoja->mergeCells("G{$fila}:H{$fila}");
$hoja->mergeCells("I{$fila}:J{$fila}");
$hoja->mergeCells("K{$fila}:L{$fila}");
$hoja->mergeCells("M{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Guardería infantil");
$hoja->setCellValue("C{$fila}", "Restaurante escolar");
$hoja->setCellValue("E{$fila}", "Transporte escolar");
$hoja->setCellValue("G{$fila}", "Educacion básica");
$hoja->setCellValue("I{$fila}", "Rehabilitacíon");
$hoja->setCellValue("K{$fila}", "Apoyo geriátrico");
$hoja->setCellValue("M{$fila}", "Ninguno");
$fila++;

$hoja->mergeCells("A{$fila}:B{$fila}");
$hoja->mergeCells("C{$fila}:D{$fila}");
$hoja->mergeCells("E{$fila}:F{$fila}");
$hoja->mergeCells("G{$fila}:H{$fila}");
$hoja->mergeCells("I{$fila}:J{$fila}");
$hoja->mergeCells("K{$fila}:L{$fila}");
$hoja->mergeCells("M{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", $unidad_residente->servicio_guarderia);
$hoja->setCellValue("C{$fila}", $unidad_residente->servicio_restaurante);
$hoja->setCellValue("E{$fila}", $unidad_residente->servicio_transporte);
$hoja->setCellValue("G{$fila}", $unidad_residente->servicio_educacion);
$hoja->setCellValue("I{$fila}", $unidad_residente->servicio_rehabilitacion);
$hoja->setCellValue("K{$fila}", $unidad_residente->servicio_geriatria);
$hoja->setCellValue("M{$fila}", $unidad_residente->servicio_ninguno);


$fila++;
//
$hoja->mergeCells("A{$fila}:G{$fila}");
$hoja->mergeCells("K{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Ademas de residir, ¿la unidad social desarrolla actividades productivas en el inmueble?");
$hoja->setCellValue("H{$fila}", "SI ___");
$hoja->setCellValue("I{$fila}", "NO ___");

if ($unidad_residente->desarrollo_actividades_productivas) {
	$hoja->setCellValue("H{$fila}", "SI _X_");
} else {
	$hoja->setCellValue("I{$fila}", "NO _X_");
}

$hoja->setCellValue("J{$fila}", "¿Cuáles?");
$hoja->setCellValue("K{$fila}", $unidad_residente->actividades_productivas);
$fila++;

array_push($filas_estrechas, $fila);
$hoja->mergeCells("A{$fila}:N{$fila}");
$fila++;

$hoja->mergeCells("A{$fila}:N{$fila}");
$hoja->getStyle("A{$fila}:N{$fila}")->applyFromArray($relleno_gris);
$hoja->setCellValue("A{$fila}", "3. APORTE DE DOCUMENTOS");
$fila++;
$fila_aporte = $fila;

$izquierda = array();
foreach ($archivos as $archivo) {
	$hoja->mergeCells("A{$fila}:N{$fila}");
	$hoja->setCellValue("A{$fila}", $archivo->descripcion);
	array_push($izquierda, $fila);
	$fila++;
}

array_push($filas_estrechas, $fila);
$hoja->mergeCells("A{$fila}:N{$fila}");
$fila++;

$hoja->mergeCells("A{$fila}:D{$fila}");
$hoja->mergeCells("E{$fila}:N{$fila}");
$hoja->setCellValue("A{$fila}", "Fecha de levantamiento de la información");
$hoja->setCellValue("E{$fila}", "El profesional social certifica que en la fecha se levantó la información contenida en el presente documento");
$fila++;

$fila2 = $fila + 1;
$hoja->mergeCells("A{$fila}:D{$fila2}");
$hoja->mergeCells("E{$fila}:I{$fila}");
$hoja->mergeCells("J{$fila}:N{$fila}");
$hoja->setCellValue("E{$fila}", "Nombre / Cargo");
$hoja->setCellValue("J{$fila}", "Firma / CC");
$fila++;

$hoja->mergeCells("E{$fila}:I{$fila}");
$hoja->mergeCells("J{$fila}:N{$fila}");
// Asignación del tamaño de las columnas
for ($columna="A"; $columna < "N"; $columna++) {
	$hoja->getColumnDimension($columna)->setWidth(8.7);
}

// Asignación del tamaño de las filas y aplicacion de bordes
for ($i=1; $i <= $fila; $i++) {
	$hoja->getRowDimension($i)->setRowHeight(20);
	$hoja->getStyle("A{$i}:N{$i}")->applyFromArray($bordes);
	// siguiente columna
	$columna++;
}

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
}

// cambia los signos de interrogacion por ñ siempre y cuando solo exista el signo de cierre solamente
foreach ($hoja->getMergeCells() as $cells) {
	preg_match_all('!\d+!', $cells, $rows);
	preg_match_all('![a-zA-Z]+!', $cells, $cols);
	$value = $hoja->getCell($cols[0][0].$rows[0][0])->getValue();
	if (strpos($value, "?") !== false && strpos($value, "¿") === false) {
		$newValue = str_replace("?", "ñ", $value);
		$hoja->setCellValue($cols[0][0].$rows[0][0], $newValue);
	}
}

header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$unidad_residente->ficha_predial.' - Unidad Social Residente".xlsx"');

// Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
