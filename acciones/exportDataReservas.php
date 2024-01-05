<?php
include('../config/config.php');
$expo = (int)$_REQUEST['expo'];

date_default_timezone_set("Europe/Madrid");
$horaEnEspana = date("Y-m-d");

// Obtener los datos de la base de datos
$sqlClientes = "SELECT * FROM tbl_reservas WHERE estado_reserva='{$expo}' ORDER BY id DESC";
$query = mysqli_query($con, $sqlClientes);

// Configuración de encabezados para forzar la descarga del archivo
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="HISTORIAL DE RESERVAS ' . $horaEnEspana . '.xls"');
header('Cache-Control: max-age=0');

// Función para imprimir una fila de datos
function imprimirFila($fila)
{
    echo implode("\t", $fila) . "\n";
}

// Encabezados
$encabezados = ['Número', 'Fecha de entrega', 'Hora de entrega', 'Fecha de recogida', 'Hora de recogida', 'Tipo de plaza', 'Terminal de entrega', 'Terminal de recogida', 'Matrícula', 'Servicios Adicionales'];
imprimirFila($encabezados);

// Datos
$contador = 1;
while ($reserva = mysqli_fetch_assoc($query)) {
    $datos = [
        $contador++,
        $reserva['fecha_entrega'],
        $reserva['hora_entrega'],
        $reserva['fecha_recogida'],
        $reserva['hora_recogida'],
        $reserva['tipo_plaza'],
        $reserva['terminal_entrega'],
        $reserva['terminal_recogida'],
        $reserva['matricula'],
        $reserva['servicio_adicional']
    ];
    imprimirFila($datos);
}

// Salir para evitar cualquier salida HTML adicional
exit;
