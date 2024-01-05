<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/*
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	*/

	include('../../config/config.php');
	date_default_timezone_set("Europe/Madrid");
	$createUser = date("Y-m-d H:i:s");

	$nombre_completo = $_POST['nombre_completo'];
	$din = $_POST['din'];
	$direccion_completa = $_POST['direccion_completa'];
	$passwordUser = trim($_POST['passwordUser']);
	$emailUser = trim($_POST['emailUser']);
	$tlf = $_POST['tlf'];
	$conocido_por = $_POST['conocido_por'];
	$observaciones = $_POST['observaciones'];
	$terminos = isset($_POST['terminos']) ? 1 : 0;

	$PasswordHash = password_hash($passwordUser, PASSWORD_BCRYPT); //Incriptando clave,

	//Primero verifico si existe algun usuario asociado a dicho correo
	$SqlVerificandoEmail = ("SELECT emailUser FROM tbl_clientes WHERE emailUser COLLATE utf8_bin='$emailUser'");
	$jqueryEmail         = mysqli_query($con, $SqlVerificandoEmail);
	if (mysqli_num_rows($jqueryEmail) > 0) {
		header("location:../../?errorC=1");
	} else {
		$queryInsertUser  = ("INSERT INTO tbl_clientes(emailUser, passwordUser, nombre_completo, din, direccion_completa, tlf, conocido_por, observaciones, terminos, createUser) VALUES ('$emailUser','$PasswordHash','$nombre_completo','$din', '$direccion_completa', '$tlf', '$conocido_por', '$observaciones', '$terminos', '$createUser')");
		$resultInsertUser = mysqli_query($con, $queryInsertUser);

		if ($resultInsertUser) {
			header("location:../../emails/cuenta_creada_email.php?emailUser=" . $emailUser);
		}
	}
}
