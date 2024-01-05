<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include('../../config/config.php');

    // Obtener el cuerpo de la solicitud POST
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si 'tipo_plaza' está presente en los datos recibidos
    if (isset($data['tipo_plaza'])) {
        $tabla = "";
        $tipo_plaza = $data['tipo_plaza'];
        //Existe 2 opciones (Plaza Cubierto y Plaza Aire Libre )
        if ($tipo_plaza == "Plaza Aire Libre") {
            $tabla = "tbl_parking_aire_libre";
        } else {
            $tabla = "tbl_parking_cubierto";
        }

        $total_dias = $data['total_dias'];
        $sqlData   = ("SELECT valor FROM $tabla WHERE dia='$total_dias' LIMIT 1");
        $querySQL  = mysqli_query($con, $sqlData);

        $totalDias = array();
        while ($fila_data = mysqli_fetch_array($querySQL)) {
            $totalDias[] = $fila_data;
        }

        echo json_encode($totalDias);
        exit();
    } else {
        echo json_encode(array('error' => 'Parámetro tipo_plaza no presente en la solicitud.'));
        exit();
    }
}
