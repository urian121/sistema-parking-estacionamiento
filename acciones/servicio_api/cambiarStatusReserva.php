<?php
$response = array(); // Crear un array para la respuesta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include('../../config/config.php');

    // Obtener el cuerpo de la solicitud POST
    $data = json_decode(file_get_contents("php://input"), TRUE);
    $idReserva = $data['idReserva'];
    $desde = $data['desde'];
    $msj = "";
    if ($desde == 'ReservasPendientes') {
        $desde = 1;
        $msj = 'La reserva ha sido trasladada a la agenda';
    } else if ($desde == 'Agenda') {
        $desde = 2;
        $msj = 'La reserva ha sido trasladada al historial';
    }


    //Pasar reserva a la Agenda
    $update = "UPDATE tbl_reservas SET estado_reserva ='{$desde}' WHERE id = '$idReserva'";
    $result = mysqli_query($con, $update);

    if ($result) {
        $response['success'] = true;
        $response['message'] = $msj;
    } else {
        $response['success'] = false;
        $response['message'] = 'Error al actualizar la reserva.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Método de solicitud no válido.';
}
// Enviar la respuesta como JSON
echo json_encode($response);
