<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include('../config/config.php');
    header("Access-Control-Allow-Origin: *");

    $jsondata = array();
    $data = json_decode(file_get_contents("php://input"), TRUE);
    $reserva_id = $data['reserva_id'];

    $sqlReservasAdmin = ("SELECT c.*, r.* FROM tbl_clientes AS c
                    INNER JOIN tbl_reservas AS r ON c.idUser = r.id_cliente
                    WHERE r.id = '$reserva_id'
                    ORDER BY r.date_registro DESC");
    $queryReserva = mysqli_query($con, $sqlReservasAdmin);
    if ($queryReserva) {
        $rowData = mysqli_fetch_assoc($queryReserva);
        $jsondata = $rowData;
    } else {
        $jsondata = mysqli_error($con);
    }

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    exit();
}
