<?php
$GLOBALS['ficha'] = $predio->ficha_predial;
class PDF extends FPDF{
	/*
	 * Cabecera del reporte
	 */
	function Header(){
		//Fuente
	    $this->SetFont('Arial','',11);
	    // Logo ANI
	    $this->setXY(15, 10);
	    $this->Cell( 37, 36, $this->Image('./img/logo_ani.jpg', $this->GetX()+2, $this->GetY()+4, 33.78), 1, 0, 'C', false );

	    $this->setX(52);
	    $this->MultiCell(85,9, utf8_decode('DEVIMED'),1,'C');
	    $this->setX(52);
	    $this->MultiCell(85,9, utf8_decode('FICHA SOCIAL REGISTRO FOTOGRÁFICO'),1,'C');

	    $ficha = explode('-', $GLOBALS['ficha']);

	    if (count($ficha) > 2) {
			// Se pone en vez de F o M, Área
			$nombre_ficha = "$ficha[0]-$ficha[1] Área $ficha[3]";
		} else {
			// Ficha normal
			$nombre_ficha = $GLOBALS['ficha'];
		} // if


	    $this->setX(52);
	    $this->MultiCell(85,9, utf8_decode('PREDIO '.$nombre_ficha),1,'C');

	    // Logo Vinus
	    $this->setXY(137,10);
	    $this->Cell( 30, 36, $this->Image('./img/logo.png', $this->GetX()+2, $this->GetY()+2, 25), 1, 0, 'C', false );

	    // Versión
	    $this->SetFont('Arial','',10);
	    $this->setXY(167,10);
	    $this->Cell(39,12, utf8_decode('Código: F-015'),1,1,'C');
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
$pdf->Cell(45, 1, utf8_decode('Proyecto:  DEVIMED S.A'), 0, 0, 'L');
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

$pdf->setXY(15, $pdf->GetY() + 10);

$cont = 1;
// carga de fotos
foreach ($fotos as $foto) {

	// Se consulta los datos de la foto
	$fecha = (isset($foto->fecha)) ?  $foto->fecha : $fecha = "";
	$descripcion =(isset($foto->descripcion)) ? utf8_decode($foto->descripcion) : $descripcion = "";

	if ($cont % 2 != 0) {
		$pdf->setY($pdf->GetY() + 15);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Ln();
	} else {
		$pdf->setXY(115, $nextY);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
	}

	if ($cont == 1) { $pdf->setY($pdf->GetY() - 15); }

	$pdf->SetFont('Arial','',9);
	$pdf->SetX($x);
	$nextY = $pdf->GetY();
	$pdf->Cell(95, 1, utf8_decode("Registro No. $cont"), 0, 1, 'C');
	$pdf->SetX($x);
	$pdf->Cell(95, 55, $pdf->Image(base_url().$directorio.'/'.$foto->archivo, $pdf->GetX()+3, $pdf->GetY()+3, null, 50),0,1,'C');

	$pdf->setXY(15, $pdf->GetY() + 4);
	$pdf->SetX($x + 3);
	$pdf->MultiCell(80, 4, utf8_decode("Descripción: $descripcion"), 0, 'L');
	$pdf->SetX($x);

	$pdf->setXY(15, $pdf->GetY() + 4);
	$pdf->SetX($x + 3);
	$pdf->Cell(80, 3, utf8_decode("Fecha: $fecha"), 0, 0, 'L');
	$pdf->SetX($x);

	$pdf->setXY(15, $pdf->GetY() - 4);


	if($cont % 2 == 0){
		$pdf->Ln();
	}

	if($cont % 4 == 0 && $cont < count($fotos)){
		$pdf->AddPage();
	}

	$cont++;
}
$pdf->setXY(15, 290);
$pdf->Multicell(50, 5, utf8_decode("Fecha de levantamiento de la información:"), 1, 'L');
$pdf->setXY(65, $pdf->GetY() - 10);
$pdf->Multicell(135, 5, utf8_decode("El profesional Social certifica que en la fecha levantó la información contenida en el presente documento:"), 1, 'L');
$pdf->Multicell(50, 20, '', 1, 'L');
$pdf->setXY(15, $pdf->GetY() - 12);
$pdf->Multicell(50, 20, utf8_decode('Dia / Mes / Año'), 0, 'C');
$pdf->setXY(65, $pdf->GetY() - 28);
$pdf->Multicell(68, 5, 'Nombre / Cargo', 1, 'C');
$pdf->setXY($pdf->GetX() + 118, $pdf->GetY() - 5);
$pdf->Multicell(67, 5, 'Firma / C.C.', 1, 'C');
$pdf->setXY(65, $pdf->GetY() - 5);
$pdf->Multicell(68, 20, '', 1, 'C');
$pdf->setXY($pdf->GetX() + 118, $pdf->GetY() - 20);
$pdf->Multicell(67, 20, '', 1, 'C');

$pdf->Output($predio->ficha_predial.'.pdf', 'D');
