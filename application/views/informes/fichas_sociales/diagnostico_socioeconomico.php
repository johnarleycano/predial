<?php
$GLOBALS['ficha'] = $predio->ficha_predial;
class PDF extends FPDF{
	/*
	 * Cabecera del reporte
	 */
	function Header(){
		//Fuente
	    $this->SetFont('Arial','',10);
	    // Logo ANI
	    $this->setXY(15, 10);
	    $this->Cell( 37, 36, $this->Image('./img/logo_ani.jpg', $this->GetX()+2, $this->GetY()+4, 33.78), 1, 0, 'C', false );

	    $this->setX(52);
	    $this->MultiCell(85,9, utf8_decode('DEVIMED'),1,'C');
	    $this->setX(52);
	    $this->MultiCell(85,9, utf8_decode('FICHA SOCIAL DIAGNÓSTICO SOCIOECONÓMICO'),1,'C');
	    $this->setX(52);
	    $this->MultiCell(85,9, utf8_decode('PREDIO '.$GLOBALS['ficha']),1,'C');

	    // Logo Vinus
	    $this->setXY(137,10);
	    $this->Cell( 30, 36, $this->Image('./img/logo.png', $this->GetX()+2, $this->GetY()+2, 25), 1, 0, 'C', false );

	    // Versión
	    $this->setXY(167,10);
	    $this->Cell(39,12, utf8_decode('Código: F-016'),1,1,'C');
	    $this->setX(167);
	    $this->Cell(39,12, utf8_decode('Versión 1.00'),1,1,'C');
	    $this->setX(167);
	    $this->Cell(39,12, utf8_decode('Fecha: 9/08/2016'),1,0,'C');

	    // Salto de línea
	    $this->Ln(5);
	}//Fin header


    /*
	 * Pie de pagina
	 */
	function Footer(){
		//Color negro
		$this->SetTextColor(0,0,0);
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Se define la fuente del footer
	    $this->SetFont('Arial', '', 8);
	    // Número de página
	    $this->Cell(0,10, utf8_decode('Sistema de Gestión Predial - Página ').$this->PageNo().' de {nb}',0,0,'R');
	}
}//Fin PDF

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','Legal');

//Anadir pagina
$pdf->AliasNbPages();

//Anadir pagina
$pdf->AddPage();

//Se definen las margenes
$pdf->SetMargins(15, 15, 15);

$pdf->setXY(15, $pdf->GetY() + 15);

// Datos generales
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(191, 5, utf8_decode('1. DATOS GENERALES'), 1, 0, 'C');


$pdf->setXY(16, $pdf->GetY() + 10);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(45, 1, utf8_decode('Proyecto:  DEVIMED'), 0, 0, 'L');
$pdf->Cell(55, 1, utf8_decode('Ficha Predial:  '.$predio->ficha_predial), 0, 0, 'L');
$pdf->Cell(55, 1, utf8_decode('Trayecto:  '. $predio->tramo), 0, 0, 'L');

$pdf->setXY(16, $pdf->GetY() + 7);

$pdf->Cell(45, 1, utf8_decode('Municipio:  '.$predio->municipio), 0, 0, 'L');
$pdf->Cell(55, 1, utf8_decode('Vereda / Barrio:  '.$predio->barrio), 0, 0, 'L');
$pdf->Cell(55, 1, utf8_decode('Dirección:  '.$predio->direccion), 0, 0, 'L');

$pdf->setXY(16, $pdf->GetY() + 7);

$pdf->Cell(45, 1, utf8_decode('Unidad social No.  1'), 0, 0, 'L');

if ($tipo == 3 && isset($relacion_inmueble)) {
	$pdf->Cell(55, 1, utf8_decode('Relación con el inmueble:  '.$relacion_inmueble), 0, 0, 'L');
} else if($tipo == 4 && isset($relacion_inmueble)) {
	$pdf->Cell(55, 1, utf8_decode('Relación con el inmueble:  '.$relacion_inmueble->nombre), 0, 0, 'L');
}

if (empty($diagnostico)) {
	$diagnostico = (object) array(
						'observaciones' => '',
						'apoyo_restablecimiento' => '',
						'apoyo_restablecimiento_valor' => '',
						'apoyo_moradores' => '',
						'apoyo_moradores_valor' => '',
						'apoyo_tramites' => '',
						'apoyo_tramites_valor' => '',
						'apoyo_movilizacion' => '',
						'apoyo_movilizacion_valor' => '',
						'restablecimiento_servicios' => '',
						'restablecimiento_servicios_valor' =>  '',
						'restablecimiento_economico' => '',
						'restablecimiento_economico_valor' => '',
						'apoyo_arrendadores' => '',
						'apoyo_arrendadores_valor' => ''
					);
}


$pdf->setXY(15, $pdf->GetY() - 19);
$pdf->MultiCell(191, 25, utf8_decode(''), 1, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(191, 5, utf8_decode('2. IDENTIFICACIÓN DE IMPACTOS Y DIAGNÓSTICO SOCIOECONÓMICOS'), 1, 1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(191, 5, substr(utf8_decode($diagnostico->observaciones), 0, 2500), 0, 'L');

$pdf->setY(89);
$pdf->MultiCell(191, 110, utf8_decode(''), 1, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(191, 5, utf8_decode('3. APLICACIÓN DE FACTORES SOCIALES'), 1, 1, 'C');

$y = 215;
$pdf->setXY(17, $y);
$pdf->Cell(50, 5, utf8_decode('FACTOR SOCIAL'), 1, 0, 'C');
$pdf->Cell(135, 5, utf8_decode('APLICACIÓN DEL FACTOR Y OBSERVACIONES'), 1, 0, 'C');
$y += 5;

$pdf->SetFont('Arial', '', 8);
$pdf->setXY(17, $y);
$pdf->MultiCell(50, 5, utf8_decode('Factor de apoyo al restablecimiento de vivienda'), 1, 'L');
$pdf->setXY(67, $y);
$pdf->Cell(135, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->MultiCell(118, 5, utf8_decode($diagnostico->apoyo_restablecimiento), 0, 'L');
$pdf->setXY(185, $y + 5);
$pdf->Cell(195, 5, utf8_decode($diagnostico->apoyo_restablecimiento_valor), 0, 'L');
$y += 10;

$pdf->setXY(17, $y);
$pdf->MultiCell(50, 5, utf8_decode('Factor de apoyo a moradores'), 0, 'L');
$pdf->setXY(17, $y);
$pdf->Cell(50, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->Cell(135, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->MultiCell(118, 5, utf8_decode($diagnostico->apoyo_moradores), 0, 'L');
$pdf->setXY(185, $y + 5);
$pdf->Cell(195, 5, utf8_decode(($diagnostico->apoyo_moradores_valor)), 0, 'L');
$y += 10;

$pdf->setXY(17, $y);
$pdf->MultiCell(50, 5, utf8_decode('Factor de apoyo para trámites'), 0, 'L');
$pdf->setXY(17, $y);
$pdf->Cell(50, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->Cell(135, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->MultiCell(118, 5, utf8_decode($diagnostico->apoyo_tramites), 0, 'L');
$pdf->setXY(185, $y + 5);
$pdf->Cell(195, 5, utf8_decode(($diagnostico->apoyo_tramites_valor)), 0, 'L');
$y += 10;

$pdf->setXY(17, $y);
$pdf->MultiCell(50, 5, utf8_decode('Factor de apoyo por movilización'), 0, 'L');
$pdf->setXY(17, $y);
$pdf->Cell(50, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->Cell(135, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->MultiCell(118, 5, utf8_decode($diagnostico->apoyo_movilizacion), 0, 'L');
$pdf->setXY(185, $y + 5);
$pdf->Cell(195, 5, utf8_decode(($diagnostico->apoyo_movilizacion_valor)), 0, 'L');
$y += 10;

$pdf->setXY(17, $y);
$pdf->MultiCell(50, 5, utf8_decode('Restablecimiento de servicios'), 0, 'L');
$pdf->setXY(17, $y);
$pdf->Cell(50, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->Cell(135, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->MultiCell(118, 5, utf8_decode($diagnostico->restablecimiento_servicios), 0, 'L');
$pdf->setXY(185, $y + 5);
$pdf->Cell(195, 5, utf8_decode(($diagnostico->restablecimiento_servicios_valor)), 0, 'L');
$y += 10;

$pdf->setXY(17, $y);
$pdf->MultiCell(50, 5, utf8_decode('Restablecimiento de medios económicos'), 0, 'L');
$pdf->setXY(17, $y);
$pdf->Cell(50, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->Cell(135, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->MultiCell(118, 5, utf8_decode($diagnostico->restablecimiento_economico), 0, 'L');
$pdf->setXY(185, $y + 5);
$pdf->Cell(195, 5, utf8_decode(($diagnostico->restablecimiento_economico_valor)), 0, 'L');
$y += 10;

$pdf->setXY(17, $y);
$pdf->MultiCell(50, 5, utf8_decode('Apoyo a arrendadores'), 0, 'L');
$pdf->setXY(17, $y);
$pdf->Cell(50, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->Cell(135, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(67, $y);
$pdf->MultiCell(118, 5, utf8_decode($diagnostico->apoyo_arrendadores), 0, 'L');
$pdf->setXY(185, $y + 5);
$pdf->Cell(195, 5, utf8_decode(($diagnostico->apoyo_arrendadores_valor)), 0, 'L');
$y += 10;

$pdf->SetFont('Arial', 'B', 8);
$pdf->setXY(17, $y);
$pdf->MultiCell(150, 10, utf8_decode('VALOR TOTAL DE LA PROPUESTA DE APLICACIÓN DE FACTORES SOCIALES'), 0, 'L');
$pdf->setXY(17, $y);
$pdf->Cell(145, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(162, $y);
$pdf->Cell(40, 10, utf8_decode(''), 1, 0, 'L');
$pdf->setXY(165, $y + 3);
$pdf->SetFont('Arial', 'I', 8);
$total = (float)$diagnostico->apoyo_restablecimiento_valor +
		 (float)$diagnostico->apoyo_moradores_valor +
		 (float)$diagnostico->apoyo_tramites_valor +
		 (float)$diagnostico->apoyo_movilizacion_valor +
		 (float)$diagnostico->restablecimiento_servicios_valor +
		 (float)$diagnostico->restablecimiento_economico_valor +
		 (float)$diagnostico->apoyo_arrendadores_valor;

$pdf->MultiCell(30, 5, '$ '. number_format((float)$total), 0, 'L');

$pdf->setY(204);
$pdf->MultiCell(191, 98, utf8_decode(''), 1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->setY(305);
$pdf->MultiCell(50, 10, utf8_decode('Fecha de elaboración del diagnóstico'), 1, 'L');
$pdf->setXY(65, 305);
$pdf->Cell(70, 10, utf8_decode('Profesional que elabora el diagnóstico:'), 1, 0, 'L');
$pdf->Cell(71, 10, utf8_decode('Profesional social de interventoría:'), 1, 0, 'L');

$pdf->setXY(15, $pdf->GetY() + 10);
$pdf->Cell(50, 20, utf8_decode(''), 1, 0, 'L');
$pdf->Cell(70, 20, utf8_decode(''), 1, 0, 'L');
$pdf->Cell(71, 20, utf8_decode(''), 1, 0, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->setXY(15,  329);
$pdf->MultiCell(50, 5, utf8_decode('DIA / MES / AÑO'), 0, 'C');

$pdf->setXY(65, $pdf->GetY() - 20);
$pdf->MultiCell(15, 7, utf8_decode('Nombre: Firma: C.C'), 0, 'L');

$pdf->setXY(135, $pdf->GetY() - 21);
$pdf->MultiCell(15, 7, utf8_decode('Nombre: Firma: C.C'), 0, 'L');

$pdf->Output($predio->ficha_predial.'.pdf', 'D');
