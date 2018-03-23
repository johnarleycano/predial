<?php

// Se crea el nuevo objeto
$PHPWord = new PHPWord();

// $identificacion = $this->PrediosDAO->obtener_identificacion('UF1-01');

$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$temp_file_uri = tempnam('', 'xyz');
$objWriter->save($temp_file_uri);

/**
 * Configuración por defecto
 */
$PHPWord->setDefaultFontName('Arial');
$PHPWord->setDefaultFontSize(11);
$properties = $PHPWord->getProperties();
$properties->setCreator('Luis David Moreno Lopera');
$properties->setCompany('VINUS S.A.S.');
$properties->setTitle('Estudio de titulos');
$properties->setDescription('Estudio de titulos');
$properties->setCategory('informe');
$properties->setLastModifiedBy('Luis David Moreno Lopera');

/**
 * Estilos de alineación
 */
$alineacion_centrada = array ('align' => 'center', 'valign' => 'center');
$alineacion_izquierda = array ('align' => 'left', 'valign' => 'center');
$alineacion_derecha = array ('align' => 'right', 'valign' => 'center');
$alineacion_justificada = array ('align' => 'both', 'valign' => 'center');

/**
 * Estilos de las fuentes
 */
$PHPWord->addFontStyle('titulo1', array( 'name'=>'Arial', 'size'=> 18, 'color'=>'000000', 'bold'=> true, 'italic' => true));
$PHPWord->addFontStyle('titulo2', array( 'name'=>'Arial', 'size'=> 12, 'color'=>'000000', 'bold'=> true));
$PHPWord->addFontStyle('titulo3', array( 'name'=>'Arial', 'size'=> 8, 'color'=>'000000', 'bold'=> true, 'italic' => true));

$PHPWord->addFontStyle('parrafo1', array( 'name'=>'Arial', 'size'=> 11, 'color'=>'000000', 'bold'=> true));
$PHPWord->addFontStyle('parrafo2', array( 'name'=>'Arial', 'size'=> 12, 'color'=>'000000', 'bold'=> false));

/**
 * Estilos de las tablas
 */
$tabla1 = array('borderColor'=>'000000', 'borderSize'=> 6);
$tabla2 = array('borderSize' => 8, 'borderColor' => '1E1E1E',  'cellMarginTop' => 100, 'rules' => 'cols');
$tabla3 = array('cellMarginTop' => 5, 'rules' => 'cols');
$tabla4 = array('borderRightSize' => 50, 'borderBottomColor' => '009900',    'borderBottomSize' => 50, 'borderRightColor' => '00CCFF',    'borderTopSize' => 50, 'borderTopColor' => '00CCFF',    'borderLeftSize' => 50, 'borderLeftColor' => '00CCFF');

/**
 * Estilos de celdas
 */
$styleCell = array('valign' => 'center');

/**
 * Sección 1
 */
$seccion1 = $PHPWord->createSection(array('pageSizeW'=>12240, 'pageSizeH'=>15840));

/**
 * Cabecera
 */
$PHPWord->addTableStyle('tabla1', $tabla3);
$cabecera = $seccion1->createHeader();
$table = $cabecera->addTable('tabla1');
$table->addRow(1000);
// $table->addCell(4000, $styleCell)->addText('COCAN 900.193.471-9', 'titulo1', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addImage('./img/logo_vinus.png',
array(
  'width' => 68,
  'height' => 80,
  'align' => 'left',
  'marginTop' => -1,
  'marginLeft' => -1,
  'wrappingStyle' => 'behind'
));

$table->addCell(10000, $styleCell)->addText(("ESTUDIO DE TÍTULOS PREDIO "). (($descripcion->uso_terreno)), 'titulo2', $alineacion_centrada);

$table->addCell(10000, $styleCell)->addImage('./img/logo_ani.jpg',
array(
  'width' => 80,
  'align' => 'right',
  'marginTop' => -1,
  'marginLeft' => -1,
  'wrappingStyle' => 'behind'
));
$cabecera->addTextBreak();

$seccion1->addText("ESTUDIO DE TÍTULOS PREDIO ".$descripcion->uso_terreno, 'titulo2', $alineacion_centrada);
$seccion1->addTextBreak();

$PHPWord->addTableStyle('tabla2', $tabla1);
$table = $seccion1->addTable('tabla2');
$table->addRow();
$table->addCell(10000, $styleCell)->addText("NOMBRE DEL PROYECTO", 'parrafo1', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText("TRAMO", 'parrafo1', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText("Nº PREDIO", 'parrafo1', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText("ABSCISA INICIAL", 'parrafo1', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText("ABSCISA FINAL", 'parrafo1', $alineacion_centrada);
$table->addRow();
$abscisa_inicial = explode(".", $descripcion->abscisa_inicial / 1000);
$abscisa_inicial = "K".$abscisa_inicial[0] ."+" .$descripcion->abscisa_inicial % 1000;
$abscisa_final = explode(".", $descripcion->abscisa_final / 1000);
$abscisa_final = "K".$abscisa_final[0]. "+". $descripcion->abscisa_final % 1000;
$table->addCell(10000, $styleCell)->addText("VÍAS DEL NUS", 'parrafo2', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText($descripcion->tramo, 'parrafo2', $alineacion_centrada);

$ficha = explode('-', $predio->ficha_predial);

$table->addCell(10000, $styleCell)->addText("$ficha[0]-$ficha[1]", 'parrafo2', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText($abscisa_inicial, 'parrafo2', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText($abscisa_final, 'parrafo2', $alineacion_centrada);
$seccion1->addTextBreak();

$seccion1->addText("1. IDENTIFICACIÓN DEL INMUEBLE", 'titulo2', $alineacion_izquierda);
$seccion1->addTextBreak();

$PHPWord->addTableStyle('tabla3', $tabla3);
$table = $seccion1->addTable('tabla3');
$table->addRow();
$table->addCell(10000, $styleCell)->addText("Dirección:", 'parrafo2', $alineacion_izquierda);
$table->addCell(10000, $styleCell)->addText($identificacion->direccion, 'parrafo2', $alineacion_izquierda);
$table->addRow();
$table->addCell(10000, $styleCell)->addText("Vereda:", 'parrafo2', $alineacion_izquierda);
$table->addCell(10000, $styleCell)->addText($identificacion->barrio, 'parrafo2', $alineacion_izquierda);
$table->addRow();
$table->addCell(10000, $styleCell)->addText("Municipio:", 'parrafo2', $alineacion_izquierda);
$table->addCell(10000, $styleCell)->addText($identificacion->municipio, 'parrafo2', $alineacion_izquierda);
$table->addRow();
$table->addCell(10000, $styleCell)->addText("Departamento:", 'parrafo2', $alineacion_izquierda);
$table->addCell(10000, $styleCell)->addText("Antioquia", 'parrafo2', $alineacion_izquierda);
$table->addRow();
$table->addCell(10000, $styleCell)->addText("Matricula Inmobiliaria:", 'parrafo2', $alineacion_izquierda);
$table->addCell(10000, $styleCell)->addText($identificacion->matricula_orig, 'parrafo2', $alineacion_izquierda);
$table->addRow();
$table->addCell(10000, $styleCell)->addText("Cedula catastral:", 'parrafo2', $alineacion_izquierda);
$table->addCell(10000, $styleCell)->addText($identificacion->no_catastral, 'parrafo2', $alineacion_izquierda);
$table->addRow();
$table->addCell(10000, $styleCell)->addText("Destinación:", 'parrafo2', $alineacion_izquierda);
$table->addCell(10000, $styleCell)->addText($descripcion->uso_edificacion, 'parrafo2', $alineacion_izquierda);
$table->addRow();
$table->addCell(10000, $styleCell)->addText("Coordenadas de amarre:", 'parrafo2', $alineacion_izquierda);
$table->addCell(10000, $styleCell)->addText("Sistema Magna Sirgas - Origen Bogotá", 'parrafo2', $alineacion_izquierda);
$table->addRow();
$table->addCell(10000, $styleCell)->addText("Área del predio:", 'parrafo2', $alineacion_izquierda);

$seccion1->addTextBreak();

$PHPWord->addTableStyle('tabla4', $tabla1);
$table = $seccion1->addTable('tabla4');
$table->addRow();
$table->addCell(10000, $styleCell)->addText("CATASTRAL", 'titulo2', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText("REGISTRAL", 'titulo2', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText("TITULOS (E.P)", 'titulo2', $alineacion_centrada);
$table->addRow();
$table->addCell(10000, $styleCell)->addText($descripcion->area_total_catastral . " m2", 'parrafo2', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText($descripcion->area_total_registral . " m2", 'parrafo2', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText($descripcion->area_total_titulos . " m2", 'parrafo2', $alineacion_centrada);
$seccion1->addTextBreak();

$seccion1->addText("Descripción, Cabida y Linderos: ", 'titulo2', $alineacion_izquierda);
$seccion1->addTextBreak();

bulleted_list($identificacion->lind_titulo, $seccion1);

// $seccion1->addText((($linderos->lind_titulo)), 'parrafo2', $alineacion_justificada);
$seccion1->addTextBreak();

$seccion1->addText("2. TITULARIDAD DEL INMUEBLE", 'titulo2', $alineacion_izquierda);
$seccion1->addTextBreak();

$PHPWord->addTableStyle('tabla5', $tabla1);
$table = $seccion1->addTable('tabla5');
$table->addRow();
$table->addCell(10000, $styleCell)->addText("PROPIETARIO", 'titulo2', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText("DOCUMENTO", 'titulo2', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText("(%)", 'titulo2', $alineacion_centrada);
foreach ($propietarios as $propietario) {
  $table->addRow();
  $table->addCell(10000, $styleCell)->addText($propietario->nombre, 'parrafo2', $alineacion_izquierda);
  $table->addCell(10000, $styleCell)->addText($propietario->documento, 'parrafo2', $alineacion_izquierda);
  $table->addCell(10000, $styleCell)->addText($propietario->participacion, 'parrafo2', $alineacion_izquierda);
}
$seccion1->addTextBreak();

$seccion1->addText("Título de adquisición: ". $identificacion->nombre_titulo_adquisicion, 'parrafo2', $alineacion_izquierda);
$seccion1->addTextBreak();

// para mostrar viñetas se usa TYPE_BULLET_FILLED con la funcion addListItem
$seccion1->addText("3. TRADICION DEL INMUEBLE", 'titulo2', $alineacion_izquierda);

bulleted_list($identificacion->titulos_adq, $seccion1);

$seccion1->addText("4. GRAVÁMENES Y LIMITACIONES", 'titulo2', $alineacion_izquierda);
$seccion1->addTextBreak();

bulleted_list($identificacion->gravamenes, $seccion1);

$seccion1->addText("5. SEGREGACIONES DEL INMUEBLE", 'titulo2', $alineacion_izquierda);
$seccion1->addTextBreak();

bulleted_list($identificacion->segreg_titu, $seccion1);

$seccion1->addText("6. OBSERVACIONES DEL INMUEBLE", 'titulo2', $alineacion_izquierda);
$seccion1->addTextBreak();

bulleted_list($identificacion->ob_titu, $seccion1);

$seccion1->addText("7. CONCEPTO", 'titulo2', $alineacion_izquierda);
$seccion1->addTextBreak();

bulleted_list($identificacion->conc_titu, $seccion1);

$seccion1->addText("8. DOCUMENTOS DE ESTUDIO", 'titulo2', $alineacion_izquierda);
$seccion1->addTextBreak();

bulleted_list($identificacion->doc_estud, $seccion1);

$seccion1->addText("9. FECHA DE ELABORACIÓN Y AJUSTE", 'titulo2', $alineacion_izquierda);
$seccion1->addTextBreak();

$seccion1->addText("El presente estudio de títulos se realizó el ". $this->InformesDAO->formatear_fecha(date('Y-m-d').'.'), 'parrafo2', $alineacion_izquierda);
$seccion1->addTextBreak(2);

$seccion1->addText("LUIS ALFREDO RESTREPO SEPÚLVEDA", 'titulo2', $alineacion_centrada);
$seccion1->addText("C.C Nº 15.505.215", 'parrafo2', $alineacion_centrada);
$seccion1->addText("T.P Nº 73.599 del C.S de la Judicatura", 'parrafo2', $alineacion_centrada);


$footer = $seccion1->createFooter();
$footer->addText("Concesión Vías del NUS S.A.S. | Calle 59 No.48 35 Copacabana, Antioquia (Kilómetro 4 + 500 Autopista Norte)", 'titulo3', $alineacion_centrada);
$footer->addText("PBX (574) 401 2277 FAX: (574) 401 2277", 'titulo3', $alineacion_centrada);
$footer->addPreserveText('www.vinus.com.co | Página {PAGE} de {NUMPAGES}', 'titulo3', $alineacion_centrada);

function bulleted_list($contenido, $seccion) {
    $alineacion_justificada = array ('align' => 'both', 'valign' => 'center');
    $contenido = str_replace('', '•', $contenido);
    // se verifica que exista contendio y que existan viñetas
    if (!empty($contenido) && strpos($contenido, '•') !== FALSE) {
        $contenido = explode('•', $contenido); // se particiona cada que encuentra una viñeta
        foreach ($contenido as $item) {
            if ($item != '') {
                $seccion->addListItem($item, 0, 'parrafo2', 'TYPE_BULLET_FILLED', $alineacion_justificada); //coloca una viñeta y el contenido
                $seccion->addTextBreak();
             }
        }
    } else {
        $seccion->addText($contenido, 'parrafo2', $alineacion_justificada);
        $seccion->addTextBreak();
    }
}

$temp_file_uri = tempnam('', 'xyz');
$objWriter->save($temp_file_uri);
//download code
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename=Acta_Recibo.docx');
header("Content-Disposition: attachment; filename={$predio->ficha_predial} - Estudio de Títulos.docx");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Content-Length: ' . filesize($temp_file_uri));
readfile($temp_file_uri);
unlink($temp_file_uri); // deletes the temporary file
exit;
