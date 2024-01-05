<?php
session_start();
if (isset($_SESSION['emailUser']) != "" && $_SESSION['rol'] == 1) {
    $IdUser     = $_SESSION['IdUser'];
    $email      = $_SESSION['emailUser'];
    $rolUser    = $_SESSION['rol'];
?>
    <!DOCTYPE html>
    <html lang="es">
    <?php
    include('bases/head.html');
    include('bases/toastr.html');
    ?>

    <body>
        <?php
        include('../msjs.php');
        include('bases/loader.html');
        ?>
        <div class="container-scroller">
            <?php include 'bases/navbar.php'; ?>
            <div class="container-fluid page-body-wrapper">
                <?php
                include 'bases/config.html';
                include 'bases/nav.php';
                include 'funciones.php';
                $mis_reservas = getAllReservasPorEstadoReserva($con, 1);
                ?>
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row justify-content-md-center" id="MiAlert"></div>

                        <div class="row justify-content-md-center">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="card-title text-center mb-4" style="font-size: 30px;">
                                            Agenda de Reservas Activas
                                            <a title="Lista de Todas las Reservas activas" href="../acciones/exportDataReservas.php?expo=1" download="Data_clientes.xls" style="float: right;font-size: 25px;">
                                                <i class="bi bi-filetype-csv"></i>
                                            </a>
                                            <hr>
                                        </h2>
                                        <div class="table-responsive">
                                            <table id="TablaAgenda" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nº Reserva</th>
                                                        <th>Cliente</th>
                                                        <th>DNI / CIF</th>
                                                        <th>Teléfono</th>
                                                        <th>Matrícula</th>
                                                        <th>Fecha de entrega</th>
                                                        <th>Hora de entrega</th>
                                                        <th>Fecha de recogida</th>
                                                        <th>Hora de recogida</th>
                                                        <th>Pago</th>
                                                        <th>Acción</th>
                                                        <th>Reserva / Factura</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($reserva = mysqli_fetch_array($mis_reservas)) {
                                                        $reserva_id = $reserva["id"]; ?>
                                                        <tr id="<?php echo $reserva_id; ?>" class="reserva_<?php echo $reserva_id; ?>">
                                                            <td class="custom_td">
                                                                <?php
                                                                if ($reserva_id < 10) {
                                                                    echo 'R-00' . $reserva_id;
                                                                } elseif ($reserva_id < 100) {
                                                                    echo 'R-0' . $reserva_id;
                                                                } else {
                                                                    echo 'R-' . $reserva_id;
                                                                } ?>
                                                            </td>
                                                            <td class="custom_td"><?php echo $reserva["nombre_completo"]; ?></td>
                                                            <td class="custom_td"><?php echo $reserva["din"]; ?></td>
                                                            <td class="custom_td"><?php echo $reserva["tlf"]; ?></td>
                                                            <td class="custom_td"><?php echo $reserva["matricula"]; ?></td>
                                                            <td class="custom_td"><?php echo date("d/m/Y", strtotime($reserva["fecha_entrega"])); ?></td>
                                                            <td class="custom_td"><?php echo $reserva["hora_entrega"]; ?></td>
                                                            <td class="custom_td"><?php echo date("d/m/Y", strtotime($reserva["fecha_recogida"])); ?></td>
                                                            <td class="custom_td"><?php echo $reserva["hora_recogida"]; ?></td>
                                                            <td class="custom_td">
                                                                <span class="<?php echo isset($reserva['formato_pago']) ? 'sin_deuda' : 'deuda' ?>">
                                                                    <?php echo $reserva["total_pago_reserva"]; ?>
                                                                    <i class="bi bi-currency-euro"></i>
                                                                </span>
                                                            </td>
                                                            <td class="text-center custom_td">
                                                                <?php if (isset($reserva["formato_pago"])) { ?>
                                                                    <button title="Enviar a Historial" type="button" onclick='gestionarReserva(this, <?php echo $reserva["id"]; ?>,"Agenda")' class="pad_btn btn btn-success btn-sm pd_7">
                                                                        Enviar a Historial
                                                                    </button>
                                                                <?php } else { ?>
                                                                    <button title="Enviar a Historial" type="button" class="pad_btn btn btn-danger btn-sm pd_7" disabled>
                                                                        Enviar a Historial
                                                                    </button>
                                                                <?php } ?>

                                                            </td>
                                                            <td class="custom_td" style="display: flex;justify-content: space-around;">
                                                                <a href="ReservaPDF.php?idReserva=<?php echo $reserva["id"]; ?>" title="Descargar Reserva">
                                                                    <i class="bi bi-filetype-pdf"></i>
                                                                </a>
                                                                <?php if (isset($reserva["formato_pago"])) { ?>
                                                                    <a href="FacturaClientePDF.php?idReserva=<?php echo $reserva["id"]; ?>" title="Descargar Factura">
                                                                        <i class="bi bi-receipt sin_deuda"></i>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a class="factura" title="Crear Factura" href="#" data-total_gasto_extras='<?php echo $reserva["total_gasto_extras"]; ?>' data-email="<?php echo $reserva["emailUser"]; ?>" data-cliente="<?php echo $reserva["nombre_completo"]; ?>" data-din="<?php echo $reserva["din"]; ?>" data-matric="<?php echo $reserva["matricula"]; ?>" data-deuda="<?php echo $reserva["total_pago_reserva"]; ?>" data-id="<?php echo $reserva["id"]; ?>" data-servicios_extras=<?php echo $reserva["servicios_extras"]; ?>'>
                                                                        <i class="bi bi-receipt"></i>
                                                                    </a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            include('ModalDetallesReserva.html');
            include('ModalCrearFactura.php');
            ?>
        </div>

        <?php include 'bases/PageJs.html'; ?>
        <script src="../assets/custom/js/tabla_reservas.js"></script>
        <script src="../assets/custom/js/status_reservas.js"></script>
        <script src="../assets/custom/js/factura.js"></script>
        <script src="../assets/custom/js/funciones_generales.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"></script>
        <script>
            $(document).ready(function() {
                $("#TablaAgenda").DataTable({
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                    },
                });
            });
        </script>
    </body>

    </html>
<?php
} else { ?>
    <script type="text/javascript">
        location.href = "../acciones/login/exit.php";
    </script>
<?php }  ?>