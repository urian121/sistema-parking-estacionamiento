<?php
if (($_SERVER["REQUEST_METHOD"] == "POST")) {
    include('../../config/config.php');
    date_default_timezone_set("Europe/Madrid");
    $horaEnEspana = date("Y-m-d H:i:s");

    $correo = filter_var($_POST['emailUser'], FILTER_SANITIZE_EMAIL);
    if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $emailUser     = $_POST['emailUser'];
    }
    $passwordUser  = trim($_POST["passwordUser"]);

    $sqlVerificandoLogin = ("SELECT IdUser, emailUser, passwordUser, rol  FROM tbl_clientes WHERE emailUser COLLATE utf8_bin='$emailUser'");
    $resultLogin = mysqli_query($con, $sqlVerificandoLogin) or die(mysqli_error($con));

    if (mysqli_num_rows($resultLogin) == 1) {
        while ($rowData  = mysqli_fetch_assoc($resultLogin)) {
            $passwordBD = $rowData['passwordUser'];
            if (password_verify($passwordUser, $passwordBD)) {
                session_start(); //Creando la sesion ya que los datos son validos
                $_SESSION['IdUser']     = $rowData['IdUser'];
                $_SESSION['emailUser']     = $rowData['emailUser'];
                $_SESSION['rol'] = (int)$rowData['rol'];

                $Update = ("UPDATE tbl_clientes SET sesionDesde='$horaEnEspana' WHERE emailUser='$emailUser' ");
                $resultado = mysqli_query($con, $Update);

                header("location:../../dashboard/?welcome=1");
            } else {
                header("location:../../?errorLogin=1");
            }
        }
    } else {
        header("location:../../?errorU=1");
    }
}
