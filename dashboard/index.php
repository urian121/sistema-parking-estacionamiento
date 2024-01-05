<?php
session_start();
if (isset($_SESSION['emailUser']) != "") {
  include('../config/config.php');
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
  <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <style>
    .gj-picker-md table tr td.today div {
      color: #BDBDBD;
    }
  </style>

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
        ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <?php
            if ($rolUser == 0) { ?>
              <div class="row justify-content-md-center">
                <div class="col-md-8 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <h1 class="card-title text-center mb-5">Crea tu reserva aquí en segundos
                        <hr>
                      </h1>

                      <form action="funciones.php" method="post" autocomplete="off">
                        <input type="hidden" name="email_cliente" value="<?php echo $email; ?>">
                        <input type="hidden" name="IdUser" value="<?php echo $IdUser; ?>">
                        <input type="hidden" name="accion" value="crearReservaClienteDashboard">
                        <input type="hidden" name="total_pago_reserva" id="total_pago_reserva">
                        <div class="row mb-2">
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="fecha-entrega">Fecha de entrega</label>
                            <input type="text" name="fecha_entrega" id="fecha_entrega" onchange="calcularDiferenciaDias()" class="borderInput form-control form-control-lg campo_obligatorio" required />
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="hora_entrega">Hora de entrega</label>
                            <select name="hora_entrega" id="hora_entrega" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected="">Seleccione</option>
                              <?php
                              $start_time = strtotime('05:00');
                              $end_time     = strtotime('24:00');
                              $interval = 15 * 60; // 15 minutos en segundos
                              for ($time = $start_time; $time <= $end_time; $time += $interval) {
                                $hora_militar = date("H:i", $time);
                                $hora_am_pm = date("h:i A", $time);
                                echo '<option value="' . $hora_militar . '">' . $hora_am_pm . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="fecha-recogida">Fecha de recogida</label>
                            <input type="text" name="fecha_recogida" id="fecha_recogida" onchange="calcularDiferenciaDias()" class="borderInput form-control form-control-lg campo_obligatorio" required />
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="hora-recogida">Hora de recogida</label>
                            <select name="hora_recogida" id="hora_recogida" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected="">Seleccione</option>
                              <?php
                              $start_time = strtotime('05:00');
                              $end_time     = strtotime('24:00');
                              $interval = 15 * 60; // 15 minutos en segundos
                              for ($time = $start_time; $time <= $end_time; $time += $interval) {
                                $hora_militar = date("H:i", $time);
                                $hora_am_pm = date("h:i A", $time);
                                echo '<option value="' . $hora_militar . '">' . $hora_am_pm . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Tipo de plaza</label>
                            <select name="tipo_plaza" id="tipo_plaza" onchange="calcularPago(this.value)" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected>Seleccione</option>
                              <option value="Plaza Aire Libre">Plaza Aire Libre</option>
                              <option value="Plaza Cubierto">Plaza Cubierto</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Terminal de entrega</label>
                            <select name="terminal_entrega" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected>Seleccione</option>
                              <option value="Aeropuerto de Alicante">Aeropuerto de Alicante</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Terminal de recogida</label>
                            <select name="terminal_recogida" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected>Seleccione</option>
                              <option value="Aeropuerto de Alicante">Aeropuerto de Alicante</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Matrícula</label>
                            <input type="text" name="matricula" class="form-control form-control-lg campo_obligatorio" required />
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-12 col-md-4 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Color</label>
                            <input type="text" name="color" class="form-control form-control-lg campo_obligatorio" required />
                          </div>
                          <div class="col-md-6 mb-2">
                            <label for="">Marca - Modelo</label>
                            <input type="text" name="marca_modelo" class="form-control form-control-lg campo_obligatorio" required />
                          </div>

                          <div class="col-12 col-md-4 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Nº Vuelo de Vuelta</label>
                            <input type="text" name="numero_vuelo_de_vuelta" class="form-control form-control-lg campo_obligatorio" />
                          </div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-md-6 mb-2">
                            <label for="">Servicios Adicionales</label>
                            <div class="mb-3 form-check">
                              <input type="checkbox" name="servicio_adicional" id="servicio_adicional" class="form-check-input" style="margin-left: 0;" value="Si">
                              <label class="form-check-label" for="servicio_adicional">Lavado Exterior Básico (Gratuito)</label>
                            </div>
                          </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                          <button type="submit" class="btn btn-primary mr-2">Crear mi Reserva Ahora</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <h2 class="mb-4 text-center">Total a Pagar
                        <hr>
                      </h2>
                      <p id="totalReserva" class="fs-30 mb-2" style="line-height: 1.8rem;"></p>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>


    <?php include 'bases/PageJs.html'; ?>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/messages/messages.es-es.js" type="text/javascript"></script>
    <script src="../assets/custom/js/custom_date_time.js"></script>
    <script src="../assets/custom/js/reserva_cliente.js"></script>

  </body>

  </html>
<?php
} else { ?>
  <script type="text/javascript">
    location.href = "../acciones/login/exit.php";
  </script>
<?php }  ?>