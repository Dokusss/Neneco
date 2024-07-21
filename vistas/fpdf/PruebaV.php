<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      
      $this->Image('../images/logosNeneco/logoN.png', 5, 5, 35); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode('BARRACA NENECO'), 0, 1, 'C');
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      //TELEFONO
      $this->Cell(5);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10, utf8_decode("Teléfono : 9232024"), 0, 0, '', 0);
      $this->Ln(5);

      //COREEO
      $this->Cell(5);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Correo : barracaneneco@gmail.com"), 0, 0, '', 0);
      $this->Ln(10);

      //TITULO DE LA TABLA
      //color
      $this->SetTextColor(0, 0, 0);
      $this->Cell(50); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE ASISTENCIAS "), 0, 2, 'C', 0);
      $this->Ln(7);

      //CABEZA DE LA TABLA
      // Configuración del encabezado de la tabla
      $this->SetFillColor(197, 226, 246); // Color de fondo
      $this->SetTextColor(0, 0, 0); // Color del texto
      $this->SetDrawColor(163, 163, 163); // Color del borde
      $this->SetFont('Arial', 'B', 11);

      // Ancho de la página y márgenes
      $anchoPagina = $this->GetPageWidth();
      $margenIzquierdo = $this->lMargin;
      $margenDerecho = $this->w - $anchoPagina + $this->rMargin;

      // Ancho del encabezado de la tabla
      $anchoEncabezado = $anchoPagina - ($margenIzquierdo + $margenDerecho);

      // Texto del encabezado de la tabla
      $textoEmpleado = 'Empleado: ';
      $textoTurnoManana = 'Mañana';
      $textoTurnoTarde = 'Tarde';

      // Dibujar el encabezado de la tabla
      $this->Cell($anchoEncabezado * 0.4, 10, utf8_decode($textoEmpleado), 1, 0, 'L', 1);
      $this->Cell($anchoEncabezado * 0.3, 10, utf8_decode($textoTurnoManana), 1, 0, 'C', 1);
      $this->Cell($anchoEncabezado * 0.3, 10, utf8_decode($textoTurnoTarde), 1, 0, 'C', 1);
      $this->Ln(); // Salto de línea

      // Segunda fila del encabezado de la tabla
      $this->Cell($anchoEncabezado * 0.4, 10, utf8_decode('Fecha'), 1, 0, 'C', 1);
      $this->Cell($anchoEncabezado * 0.15, 10, utf8_decode('Entrada'), 1, 0, 'C', 1);
      $this->Cell($anchoEncabezado * 0.15, 10, utf8_decode('Salida'), 1, 0, 'C', 1);
      $this->Cell($anchoEncabezado * 0.15, 10, utf8_decode('Entrada'), 1, 0, 'C', 1);
      $this->Cell($anchoEncabezado * 0.15, 10, utf8_decode('Salida'), 1, 0, 'C', 1);
      $this->Ln(); // Salto de línea
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/
$i = $i + 1;
/* TABLA */
// $pdf->Cell(18, 10, utf8_decode("N°"), 1, 0, 'C', 0);
// $pdf->Cell(20, 10, utf8_decode("numero"), 1, 0, 'C', 0);
// $pdf->Cell(30, 10, utf8_decode("nombre"), 1, 0, 'C', 0);
// $pdf->Cell(25, 10, utf8_decode("precio"), 1, 0, 'C', 0);
// $pdf->Cell(70, 10, utf8_decode("info"), 1, 0, 'C', 0);
// $pdf->Cell(25, 10, utf8_decode("total"), 1, 1, 'C', 0);


$pdf->Output('Prueba.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
