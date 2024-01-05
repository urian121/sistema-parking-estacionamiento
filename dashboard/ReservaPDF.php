<?php
require_once('../tcpdf/tcpdf.php');
require_once('../config/config.php');

date_default_timezone_set("Europe/Madrid");
$horaEnEspana = date("Y-m-d");

ob_end_clean(); //limpiar la memoria

//Informacion de la Reserva
if (isset($_GET["idReserva"])) {
    $idReserva = $_GET["idReserva"];
    $sqlReserva     = ("SELECT
                    c.idUser,
                    c.nombre_completo,
                    c.din,
                    c.direccion_completa,
                    c.tlf,
                    r.fecha_entrega,
                    r.hora_entrega,
                    r.fecha_recogida,
                    r.hora_recogida,
                    r.tipo_plaza,
                    r.terminal_entrega,
                    r.terminal_recogida,
                    r.matricula,
                    r.color,
                    r.marca_modelo,
                    r.numero_vuelo_de_vuelta,
                    r.servicio_adicional,
                    r.total_pago_reserva,
                    r.servicios_extras,
                    r.total_gasto_extras,
                    ABS(DATEDIFF(r.fecha_entrega, r.fecha_recogida)) AS diferencia_dias
                FROM tbl_clientes AS c 
                INNER JOIN tbl_reservas AS r
                ON c.idUser=r.id_cliente
                WHERE r.id='$idReserva' LIMIT 1");
    $resulReserva = mysqli_query($con, $sqlReserva);
    if (!$resulReserva) {
        header("Location: https://alcvaletparking.com/");
        exit;
    }
    $rowReserva = mysqli_fetch_assoc($resulReserva);
} else {
    header("Location: https://alcvaletparking.com/");
    exit;
}



class MYPDF extends TCPDF
{
    private function traducirDia($nombreDiaEnIngles)
    {
        $traducciones = array(
            'Monday'    => 'Lunes',
            'Tuesday'   => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday'  => 'Jueves',
            'Friday'    => 'Viernes',
            'Saturday'  => 'Sábado',
            'Sunday'    => 'Domingo',
        );

        return $traducciones[$nombreDiaEnIngles] ?? $nombreDiaEnIngles;
    }

    private function traducirMes($nombreMesEnIngles)
    {
        $traducciones = array(
            'January'   => 'Enero',
            'February'  => 'Febrero',
            'March'     => 'Marzo',
            'April'     => 'Abril',
            'May'       => 'Mayo',
            'June'      => 'Junio',
            'July'      => 'Julio',
            'August'    => 'Agosto',
            'September' => 'Septiembre',
            'October'   => 'Octubre',
            'November'  => 'Noviembre',
            'December'  => 'Diciembre',
        );

        return $traducciones[$nombreMesEnIngles] ?? $nombreMesEnIngles;
    }
    public function Header()
    {
        // $watermarkImg = dirname(__FILE__) . '/../assets/custom/imgs/logon_alcvaletparking.png'; // Ruta de la imagen de la marca de agua
        //$this->Image($watermarkImg, 90, 110, 30, 0, 'PNG', '', '', false, 300, '', false, false, 0);
        //$this->Image($watermarkImg, 90, 110, 30, 0, 'PNG', '', '', false, 300, '', false, false, 0, 100);


        $fechaActual = new DateTime();
        $nombreDia = $this->traducirDia($fechaActual->format('l'));
        $nombreMes = $this->traducirMes($fechaActual->format('F'));
        $fechaFormateada = $nombreDia . ', ' . $fechaActual->format('j') . ' de ' . $nombreMes . ' del ' . $fechaActual->format('Y');



        $path = dirname(__FILE__);
        $logo = $path . '/../assets/custom/imgs/logo_parking.png'; // Asegúrate de que el separador de directorios esté correcto

        /** Logo Derecha */
        $bMargin = $this->getBreakMargin();
        $auto_page_break = $this->AutoPageBreak;
        $this->SetAutoPageBreak(false, 0);
        $img_file = dirname(__FILE__) . '/../assets/custom/imgs/logon_alcvaletparking.png';
        $this->Image($img_file, 140, 23, 30, 30, '', '', '', false, 30, '', false, false, 0);
        $this->Image($logo, 175, 22, 25);
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        $this->setPageMark();

        $this->SetFont('Times', '', 12);
        $this->SetXY(18, 12);
        $this->Cell(180, 0, $fechaFormateada, 0, 0, 'R');

        $recibo = "4328";
        $this->SetFont('helvetica', 'B', 15);
        $this->SetXY(30, 20);
        $this->Cell(150, 80, 'Factura Nº: ' . $recibo, 0, 0, 'R');


        $this->SetFont('helvetica', 'B', 23);
        $this->SetXY(10, 8);
        $this->Cell(0, 0, 'Recibo de Aparcamiento', 0, 0, 'L');

        $this->SetFont('Times', '', 12);
        $this->SetXY(10, 20);
        $this->Cell(0, 0, 'ALC VALET PARKING', 0, 1, 'L'); // Cambié el último parámetro a 1

        $this->SetX(10);
        $this->Cell(0, 0, 'E72706781', 0, 1, 'L');

        $this->SetX(10);
        $this->Cell(0, 0, 'Ctra. Aeropuerto-Torellano s/n CV-852', 0, 1, 'L');

        $this->SetX(10);
        $this->Cell(0, 0, '03320 Torrellano(Alicante)', 0, 1, 'L');

        $this->SetX(10);
        $this->Cell(0, 0, 'Oficina +34 966 109 228', 0, 1, 'L');

        $this->SetX(10);
        $this->Cell(0, 0, 'Movil +34 601 356 356', 0, 1, 'L');

        $this->SetX(10);
        $this->Cell(0, 0, 'info@alcvaletparking.com', 0, 1, 'L');

        $this->SetX(10);
        $this->Cell(0, 0, 'www.alcvaletparking.com', 0, 1, 'L');

        //Linea Horizontal
        $this->Line(10, 70, 200, 70); // Cambia los valores según tu diseño
    }
}




//CREANDO NUEVO DOCUMNETO PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//establecer margenes
$pdf->SetMargins(25, 35, 25);
$pdf->SetHeaderMargin(20);
$pdf->setPrintFooter(false); //Defino el estado del footer
$pdf->setPrintHeader(true); //Defino el estado del Header
$pdf->SetAutoPageBreak(false);

// set default header data
$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);


// add a page
$pdf->AddPage();

$idUser = $rowReserva["idUser"];
if ($idUser < 10) {
    $idUser = 'C-00' . $idUser;
} elseif ($idUser < 100) {
    $idUser = 'C-0' . $idUser;
} else {
    $idUser = 'C-' . $idUser;
}

$pdf->Ln(28);
$cliente = array(
    'Código Cliente' => $idUser,
    'Cliente' => $rowReserva["nombre_completo"],
    'DNI / Passport' => $rowReserva["din"],
    'Dirección' => $rowReserva["direccion_completa"],
    'Teléfono' => $rowReserva["tlf"],
    'Terminal de entrega' => $rowReserva['terminal_entrega'],
    'Terminal de recogida' => $rowReserva['terminal_recogida'],
);

// Configuración de la fuente
$pdf->SetFont('Helvetica', 'B', 9);
// Configuración de la tabla
$anchoColumna1 = 60;
$anchoColumna2 = 80;
$altoCelda = 8;

// Establecer posición inicial de la tabla
$posicionX = 10;
$posicionY = $pdf->GetY() + 10;

// Crear tabla
foreach ($cliente as $campo => $valor) {
    $pdf->SetXY($posicionX, $posicionY);
    // Configurar fuente y agregar clave sin bordes
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell($anchoColumna1, $altoCelda, $campo, 0);

    // Cambiar la fuente para el valor (no negrita) y agregar valor sin bordes
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell($anchoColumna2, $altoCelda, $valor, 0);
    $posicionY += $altoCelda; // Ajustar la posición Y para la siguiente fila
}
$pdf->SetXY($posicionX, $posicionY + 5);
//Linea Horizontal
$pdf->Line(10, 133, 200, 133);


#Informacion del Vehiculo
$reservaDatos = array(
    'Marca y Modelo' => $rowReserva["marca_modelo"],
    'Color' => $rowReserva["color"],
    'Matrícula' => $rowReserva["matricula"],
    'Fecha Entrada' => date("d/m/Y", strtotime($rowReserva["fecha_entrega"])),
    'Hora Entrada' => $rowReserva["hora_entrega"],
    'Fecha Salida' => date("d/m/Y", strtotime($rowReserva["fecha_recogida"])),
    'Hora Salida' => $rowReserva["hora_recogida"],
    'Número Días' => $rowReserva["diferencia_dias"],
);


$anchoColumna1 = 60;
$anchoColumna2 = 80;
$altoCelda = 8;
$posicionX = 10;
$posicionY = $pdf->GetY() + 10;
foreach ($reservaDatos as $campo => $valor) {
    $pdf->SetXY($posicionX, $posicionY);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell($anchoColumna1, $altoCelda, $campo, 0, 0, 'L'); // Sin borde
    // Cambiar la fuente para el valor (no negrita)
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell($anchoColumna2, $altoCelda, $valor, 0, 1, 'L'); // Sin borde y salto de línea
    $posicionY += $altoCelda; // Ajustar la posición Y para la siguiente fila
}
$pdf->SetXY($posicionX, $posicionY + 10);


/**
 *  Observaciones
 */
$pdf->SetFont('Helvetica', 'B', 15);
$pdf->Cell(0, 0, 'OBSERVACIONES', 0, 0, 'C');
$pdf->Line(10, 225, 200, 225);

// Calcular el precio real sin IVA
$precioConIva = ($rowReserva['total_pago_reserva']); // Precio del producto con IVA
$sumaTotal = ($precioConIva + $rowReserva['total_gasto_extras']);

//Base Impuesto
$porcentajeIva = 21; // Porcentaje de IVA
$precioSinIva = $sumaTotal / (1 + ($porcentajeIva / 100));
$iva = $precioSinIva * ($porcentajeIva / 100);


// Información para la primera tabla
$tablaDatos1 = array(
    'Precio Estancia'   => number_format($precioConIva, 2) . ' €',
    'Servicio Adicional' => number_format($rowReserva['total_gasto_extras'], 2) . ' €',
    'SUMA TOTAL'        => $sumaTotal . ' €'
);

// Información para la segunda tabla
$tablaDatos2 = array(
    'Base Imp'          => number_format($precioSinIva, 2) . ' €',
    'IVA 21 %'          => number_format($iva, 2) . ' €',
    'TOTAL'             => $sumaTotal . ' €',
);

// Configuración de la tabla
$anchoColumna1 = 60;
$anchoColumna2 = 40;
$altoCelda = 7;

// Establecer posición inicial de la primera tabla
$posicionX1 = 10;
$posicionY1 = $pdf->GetY() + 10;

// Crear primera tabla
foreach ($tablaDatos1 as $concepto => $valor) {
    $pdf->SetXY($posicionX1, $posicionY1);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell($anchoColumna1, $altoCelda, $concepto); // Sin bordes
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell($anchoColumna2, $altoCelda, $valor); // Sin bordes
    $posicionY1 += $altoCelda; // Ajustar la posición Y para la siguiente fila
}

// Establecer posición inicial de la segunda tabla
$posicionX2 = $posicionX1 - 110; // Desplazamiento horizontal
$posicionY2 = $pdf->GetY() - 14;

// Crear segunda tabla
foreach ($tablaDatos2 as $concepto => $valor) {
    $pdf->SetXY($posicionX2, $posicionY2);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell($anchoColumna1, $altoCelda, $concepto); // Sin bordes
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell($anchoColumna2, $altoCelda, $valor); // Sin bordes
    $posicionY2 += $altoCelda; // Ajustar la posición Y para la siguiente fila
}
// Ajustar según sea necesario
$pdf->SetXY($posicionX1, max($posicionY1, $posicionY2) + 10);

//Validando si hay Servicios Extras
if ($rowReserva['servicios_extras'] != "") {
    $pdf->SetFont('helvetica', 'B', 14); //La B es para letras en Negritas
    $pdf->SetXY(127, 138);
    $pdf->Cell(200, 0, 'Detalles Servicio Adicional', 0, 0, '');

    // Configurar la fuente y tamaño para el párrafo
    $pdf->SetXY(120, 146);
    $pdf->SetFont('Helvetica', '', 12);
    $anchoCelda = 80;
    $pdf->MultiCell($anchoCelda, 10, $rowReserva['servicios_extras'], 0, 'J');
}





// Texto en la parte inferior izquierda
$pdf->SetFont('Helvetica', 'B', 13);
$pdf->SetXY(10, 280); // Ajusta las coordenadas según sea necesario
$pdf->Cell(0, 0, 'Conforme Cliente', 0, 0, 'L');

// Texto en la parte inferior derecha
$pdf->SetXY(150, 280); // Ajusta las coordenadas según sea necesario
$pdf->Cell(0, 0, 'Conforme ALC', 0, 0, 'R');


//D en lugar de I para forzar la descarga
$pdf->Output('Reserva ' . $rowReserva["nombre_completo"] . ' ' . date('d_m_Y') . '.pdf', 'I');
