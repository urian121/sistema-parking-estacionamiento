 <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include('../config/config.php');


    function perfilUser($con, $idUser)
    {
        $sqlPerfil = "SELECT 
                    IdUser,
                    emailUser, 
                    nombre_completo,
                    din,
                    direccion_completa, 
                    tlf
                FROM tbl_clientes
                WHERE IdUser='$idUser' LIMIT 1";
        $queryPerfil = mysqli_query($con, $sqlPerfil);
        if (!$queryPerfil) {
            return false;
        }
        $data = mysqli_fetch_assoc($queryPerfil);
        mysqli_free_result($queryPerfil);
        return $data;
    }

    /**
     * Actualizar Perfil
     */
    if (isset($_POST["accion"]) && $_POST["accion"] == "actualizarPerfil") {
        $idU = trim($_POST['IdUser']);
        $nombre_completo = $_POST['nombre_completo'];
        $din = $_POST['din'];
        $direccion_completa = $_POST['direccion_completa'];
        $emailUser = $_POST['emailUser'];

        // Verificar si el campo passwordUser no está vacío
        if (!empty($_POST['passwordUser'])) {
            $PasswordHash = password_hash($_POST['passwordUser'], PASSWORD_BCRYPT);
            $updatePerfil = "UPDATE tbl_clientes 
            SET nombre_completo = '$nombre_completo',
                din = '$din',
                direccion_completa = '$direccion_completa',
                emailUser = '$emailUser',
                passwordUser = '$PasswordHash'
             WHERE IdUser = '$idU'";
        } else {
            $updatePerfil = "UPDATE tbl_clientes 
            SET nombre_completo = '$nombre_completo',
                din = '$din',
                direccion_completa = '$direccion_completa',
                emailUser = '$emailUser'
             WHERE IdUser = '$idU'";
        }

        $result = mysqli_query($con, $updatePerfil);

        if (!$result) {
            echo 'Error al guardar los datos en la base de datos.';
        } else {
            header("location:./?successP=1");
        }
    }

    /**
     * Crear Reserva desde el perfil Cliente
     */
    if (isset($_POST["accion"]) && $_POST["accion"] == "crearReservaClienteDashboard") {
        $id_cliente = trim($_POST['IdUser']);
        $fecha_entrega = date("Y-m-d", strtotime($_POST['fecha_entrega']));
        $hora_entrega = trim($_POST['hora_entrega']);
        $fecha_recogida = date("Y-m-d", strtotime($_POST['fecha_recogida']));
        $hora_recogida = trim($_POST['hora_recogida']);
        $tipo_plaza = trim($_POST['tipo_plaza']);
        $terminal_entrega = trim($_POST['terminal_entrega']);
        $terminal_recogida = trim($_POST['terminal_recogida']);
        $matricula = trim($_POST['matricula']);
        $color = trim($_POST['color']);
        $marca_modelo = trim($_POST['marca_modelo']);
        $numero_vuelo_de_vuelta = trim($_POST['numero_vuelo_de_vuelta']);
        $servicio_adicional = isset($_POST['servicio_adicional']) ? "Si" : "No";
        $total_pago_reserva = trim($_POST['total_pago_reserva']);
        $email_cliente = trim($_POST['email_cliente']);

        $queryInserReserva  = ("INSERT INTO tbl_reservas(id_cliente, fecha_entrega, hora_entrega, fecha_recogida, hora_recogida, tipo_plaza, terminal_entrega, terminal_recogida, matricula, color, marca_modelo, numero_vuelo_de_vuelta, servicio_adicional, total_pago_reserva) VALUES('$id_cliente','$fecha_entrega','$hora_entrega','$fecha_recogida','$hora_recogida', '$tipo_plaza', '$terminal_entrega', '$terminal_recogida', '$matricula', '$color', '$marca_modelo', '$numero_vuelo_de_vuelta', '$servicio_adicional', '$total_pago_reserva')");
        $resultInsert = mysqli_query($con, $queryInserReserva);
        if ($resultInsert) {
            // Obtener el último ID insertado
            $lastInsertId = mysqli_insert_id($con);
            header("location:../emails/aviso_reserva_email.php?emailUser=" . $email_cliente . "&IdReserva=" . $lastInsertId);
        }
    }

    /**
     * Crear reserva desde perfil Administrador
     */
    if (isset($_POST["accion"]) && $_POST["accion"] == "crearReserva") {
        $id_cliente = trim($_POST['IdUser']);
        $fecha_entrega = date("Y-m-d", strtotime($_POST['fecha_entrega']));
        $hora_entrega = trim($_POST['hora_entrega']);
        $fecha_recogida = date("Y-m-d", strtotime($_POST['fecha_recogida']));
        $hora_recogida = trim($_POST['hora_recogida']);
        $tipo_plaza = trim($_POST['tipo_plaza']);
        $terminal_entrega = trim($_POST['terminal_entrega']);
        $terminal_recogida = trim($_POST['terminal_recogida']);
        $matricula = trim($_POST['matricula']);
        $color = trim($_POST['color']);
        $marca_modelo = trim($_POST['marca_modelo']);
        $numero_vuelo_de_vuelta = trim($_POST['numero_vuelo_de_vuelta']);
        $servicio_adicional = isset($_POST['servicio_adicional']) ? "Si" : "No";


        $total_pago_reserva = trim($_POST['total_pago_reserva']);
        $descuento = isset($_POST['descuento']) ? trim($_POST['descuento']) : 0;
        $servicios_extras = $_POST['servicios_extras'];
        $total_gasto_extras = isset($_POST['total_gasto_extras']) ? trim($_POST['total_gasto_extras']) : 0;
        if ($total_gasto_extras != "") {
            // Convierte las variables a números y realiza la operación aritmética
            $deudaTotal = number_format(($total_pago_reserva + $total_gasto_extras), 2, '.', '');
        } else {
            $deudaTotal = $total_pago_reserva;
        }

        $queryInserReserva  = ("INSERT INTO tbl_reservas(id_cliente, fecha_entrega, hora_entrega, fecha_recogida, hora_recogida, tipo_plaza, terminal_entrega, terminal_recogida, matricula, color, marca_modelo, numero_vuelo_de_vuelta, servicio_adicional, total_pago_reserva, descuento, servicios_extras, total_gasto_extras) 
                            VALUES('$id_cliente','$fecha_entrega','$hora_entrega','$fecha_recogida','$hora_recogida', '$tipo_plaza', '$terminal_entrega', '$terminal_recogida', '$matricula', '$color', '$marca_modelo', '$numero_vuelo_de_vuelta', '$servicio_adicional', '$total_pago_reserva', '$descuento', '$servicios_extras', '$total_gasto_extras')");
        $resultInsert = mysqli_query($con, $queryInserReserva);
        if ($resultInsert) {
            // Obtener el último ID insertado
            $lastInsertId = mysqli_insert_id($con);

            $sqlPerfil = "SELECT emailUser FROM tbl_clientes WHERE IdUser='$id_cliente' LIMIT 1";
            $queryPerfil = mysqli_query($con, $sqlPerfil);
            $data = mysqli_fetch_assoc($queryPerfil);
            $email_cliente = $data['emailUser'];
            header("location:../emails/aviso_reserva_email.php?emailUser=" . $email_cliente . "&IdReserva=" . $lastInsertId);
        }
    }



    /**
     * Listas de Reservas por usuario conectado
     */
    function getReservaPerfil($con, $idUser)
    {
        $sqlReservasP = ("SELECT * FROM tbl_reservas WHERE id_cliente ='$idUser' ORDER BY fecha_entrega DESC");
        $queryR = mysqli_query($con, $sqlReservasP);
        if (!$queryR) {
            return false;
        }
        return $queryR;
    }

    /**
     * Lista de Clientes
     */
    function getClientes($con)
    {
        $sqlClientes = ("SELECT * FROM tbl_clientes ORDER BY IdUser DESC");
        $queryC = mysqli_query($con, $sqlClientes);
        if (!$queryC) {
            return false;
        }
        return $queryC;
    }

    /**
     * Lista de Reservas Pendientes
     */
    function getAllReservasPorEstadoReserva($con, $status_reserva)
    {
        $sqlReservasAdmin = ("SELECT c.*, r.* FROM tbl_clientes AS c
                    INNER JOIN tbl_reservas AS r ON c.idUser = r.id_cliente
                    WHERE r.estado_reserva = '{$status_reserva}'
                    ORDER BY r.date_registro DESC");
        $queryReserva = mysqli_query($con, $sqlReservasAdmin);
        if (!$queryReserva) {
            return false;
        }
        return $queryReserva;
    }

    /**
     * Crear cuenta de Cliente desde el Administrado
     */
    if (isset($_POST["accion"]) && $_POST["accion"] == "crearCliente") {
        date_default_timezone_set("Europe/Madrid");
        $createUser = date("Y-m-d H:i:s");

        $nombre_completo = $_POST['nombre_completo'];
        $din = $_POST['din'];
        $direccion_completa = $_POST['direccion_completa'];
        $passwordUser = trim($_POST['passwordUser']);
        $emailUser = trim($_POST['emailUser']);
        $tlf = $_POST['tlf'];
        $observaciones = $_POST['observaciones'];

        $PasswordHash = password_hash($passwordUser, PASSWORD_BCRYPT); //Incriptando clave,

        //Primero verifico si existe algun usuario asociado a dicho correo
        $SqlVerificandoEmail = ("SELECT emailUser FROM tbl_clientes WHERE emailUser COLLATE utf8_bin='$emailUser'");
        $jqueryEmail         = mysqli_query($con, $SqlVerificandoEmail);
        if (mysqli_num_rows($jqueryEmail) > 0) {
            header("location:./CrearCliente.php?errorC=1");
        } else {
            $queryInsertUser  = ("INSERT INTO tbl_clientes(emailUser, passwordUser, nombre_completo, din, direccion_completa, tlf, observaciones, createUser) VALUES ('$emailUser','$PasswordHash','$nombre_completo','$din', '$direccion_completa', '$tlf', '$observaciones', '$createUser')");
            $resultInsertUser = mysqli_query($con, $queryInsertUser);
            header("location:./CrearCliente.php?successC=1");
        }
    }

    /**
     * Crear Factura
     */
    if (isset($_POST["accion"]) && $_POST["accion"] == "crearFacturaCliente") {
        date_default_timezone_set("Europe/Madrid");
        $fecha_pago_factura = date("Y-m-d H:i:s");

        $deuda = isset($_POST["deuda"]) ? trim($_POST["deuda"]) : 0;

        $t_g_e = trim($_POST['total_gasto_extras']);
        $total_gasto_extras = 0;
        if ($t_g_e == "") {
            $total_gasto_extras = 0;
        } else {
            $total_gasto_extras = $t_g_e;
        }

        // Verifica si $total_gasto_extras es una cadena no vacía antes de realizar la operación aritmética
        if ($total_gasto_extras !== "") {
            // Convierte $total_gasto_extras a número flotante
            $total_gasto_extras = floatval($total_gasto_extras);

            // Realiza la operación aritmética
            $deudaTotal = number_format(($deuda + $total_gasto_extras), 2, '.', '');
        } else {
            $deudaTotal = $deuda;
        }


        $idReserva = $_POST['idReserva'];
        $email_cliente = trim($_POST['emailCliente']);
        $formato_pago = $_POST['formato_pago'];
        $servicios_extras = $_POST['servicios_extras'];

        $Update = "UPDATE tbl_reservas SET total_pago_reserva='$deudaTotal', formato_pago='$formato_pago', fecha_pago_factura='$fecha_pago_factura', servicios_extras='$servicios_extras', total_gasto_extras='$total_gasto_extras' WHERE id='$idReserva'";
        $resultado = mysqli_query($con, $Update);

        // Utiliza urlencode para asegurar que los parámetros del URL estén correctamente codificados
        header("location:../emails/factura_email.php?emailUser=" . urlencode($email_cliente) . "&IdReserva=" . urlencode($idReserva));
    }
    ?>