<?php
$usuario = "root";
$password = "";
$servidor = "localhost";
$basededatos = "bd_parking";

$con = mysqli_connect($servidor, $usuario, $password, $basededatos);

function manejarErrorDeConexion($error_message)
{
    die("Error al conectar a la Base de Datos: " . $error_message);
}

if (mysqli_connect_errno()) {
    manejarErrorDeConexion(mysqli_connect_error());
}

if (!$con) {
    manejarErrorDeConexion(mysqli_connect_error());
}
//echo "Conexión exitosa a la Base de Datos";
