<?php
session_start();
if (isset($_SESSION['emailUser']) != "" && $_SESSION['rol'] == 1) {
    $IdUser     = $_SESSION['IdUser'];
    $rolUser     = $_SESSION['rol'];
    $email      = $_SESSION['emailUser'];
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
            <?php include 'bases/navbar.php' ?>
            <div class="container-fluid page-body-wrapper">
                <?php
                include 'bases/config.html';
                include 'bases/nav.php';
                include 'funciones.php';
                $clientesBD = getClientes($con);
                ?>
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row justify-content-md-center">
                            <div class="col-md-5 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="auth-form-light py-2 px-4">
                                            <h3 class="card-title text-center mb-4">Crear Cuenta Cliente
                                                <hr>
                                            </h3>
                                            <form action="funciones.php" method="post" autocomplete="off">
                                                <input type="text" name="accion" value="crearCliente" hidden>
                                                <div class="row mb-2">
                                                    <div class="col-md-6 mb-2">
                                                        <input type="text" name="nombre_completo" class="form-control form-control-lg" required="" placeholder="Nombre completo">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="din" class="form-control form-control-lg" placeholder="DIN" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="direccion_completa" class="form-control form-control-lg" placeholder="Dirección completa" required="">
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-6 mb-2">
                                                        <input type="password" name="passwordUser" class="form-control form-control-lg" placeholder="Clave" required="">
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <input type="email" name="emailUser" class="form-control form-control-lg" placeholder="Email" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="observaciones" placeholder="Observaciones" style="height: 100px"></textarea>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                                        Crear Cuenta
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card">
                                    <div class="card-body mt-3">
                                        <h3 class="text-center mb-4">Lista de Clientes
                                            <hr>
                                        </h3>
                                        <div class="table-responsive">
                                            <table id="MiTabla" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nº Cliente</th>
                                                        <th>Cliente</th>
                                                        <th>DNI</th>
                                                        <th>Email</th>
                                                        <th>Teléfono</th>
                                                        <th>Dirección</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($reserva = mysqli_fetch_array($clientesBD)) { ?>
                                                        <tr>
                                                            <td class="custom_td">
                                                                <?php
                                                                $reserva_id = $reserva["IdUser"];
                                                                if ($reserva_id < 10) {
                                                                    echo 'C-00' . $reserva_id;
                                                                } elseif ($reserva_id < 100) {
                                                                    echo 'C-0' . $reserva_id;
                                                                } else {
                                                                    echo 'C-' . $reserva_id;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="custom_td"><?php echo $reserva["nombre_completo"]; ?></td>
                                                            <td class="custom_td"><?php echo $reserva["din"]; ?></td>
                                                            <td class="custom_td"><?php echo $reserva["emailUser"]; ?></td>
                                                            <td class="custom_td"><?php echo $reserva["tlf"]; ?></td>
                                                            <td class="custom_td"><?php echo $reserva["direccion_completa"]; ?></td>
                                                            <td class="custom_td"><button type="button" class="btn btn-info btn_padding">
                                                                    <i class="bi bi-pencil"></i>
                                                                    Editar
                                                                </button>
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
        </div>

        <?php include 'bases/PageJs.html'; ?>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"></script>
        <script>
            $(document).ready(function() {
                $("#MiTabla").DataTable({
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