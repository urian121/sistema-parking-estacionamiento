<?php
$opcionesToastr = json_encode(array(
    "closeButton" => true,
    "debug" => false,
    "newestOnTop" => false,
    "progressBar" => true,
    "positionClass" => "toast-top-right",
    "preventDuplicates" => false,
    "onclick" => null,
    "showDuration" => "300",
    "hideDuration" => "1000",
    "timeOut" => "8000",
    "extendedTimeOut" => "1000",
    "showEasing" => "swing",
    "hideEasing" => "linear",
    "showMethod" => "fadeIn",
    "hideMethod" => "fadeOut"
));


if (isset($_REQUEST['errorC'])) {
    $mensaje = 'Ya existe una cuenta con ese correo, por favor Verifique e intente nuevamente.';
    $tipo = 'error';
} elseif (isset($_REQUEST['welcome'])) {
    $mensaje = 'Felicitaciones, ha iniciado sesión correctamente.';
    $tipo = 'success';
} elseif (isset($_REQUEST['errorU'])) {
    $mensaje = 'El correo ya existe, por favor verifique.';
    $tipo = 'error';
} elseif (isset($_REQUEST['logout'])) {
    $mensaje = 'Felicitaciones, la sesión fue cerrada correctamente.';
    $tipo = 'success';
} elseif (isset($_REQUEST['errorl'])) {
    $mensaje = 'No existe el correo, por favor verifique.';
    $tipo = 'error';
} elseif (isset($_REQUEST['errorLogin'])) {
    $mensaje = 'Las credenciales son incorrectas, por favor verifique.';
    $tipo = 'error';
} elseif (isset($_REQUEST['successC'])) {
    $mensaje = 'Felicitaciones, Cuenta creada correctamente.';
    $tipo = 'success';
} elseif (isset($_REQUEST['successR'])) {
    $mensaje = 'Felicitaciones, tu Reserva fue creda correctamente.';
    $tipo = 'success';
} elseif (isset($_REQUEST['facturaR'])) {
    $mensaje = 'Felicitaciones, tu factura fue creda correctamente.';
    $tipo = 'success';
} elseif (isset($_REQUEST['successP'])) {
    $mensaje = 'Felicitaciones, tu Perfil fue actualizado correctamente.';
    $tipo = 'success';
}



if (isset($mensaje)) { ?>
    <script type='text/javascript'>
        toastr.options = <?php echo $opcionesToastr; ?>;
        toastr.<?php echo $tipo; ?>('<?php echo $mensaje; ?>');
    </script>
<?php } ?>