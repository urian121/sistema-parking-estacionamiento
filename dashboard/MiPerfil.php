<?php
session_start();
if (isset($_SESSION['emailUser']) != "") {
  $IdUser     = $_SESSION['IdUser'];
  $email      = $_SESSION['emailUser'];
  $rolUser     = $_SESSION['rol'];
?>
  <!DOCTYPE html>
  <html lang="es">
  <?php include('bases/head.html'); ?>

  <body>
    <?php include('bases/loader.html'); ?>
    <div class="container-scroller">
      <?php include 'bases/navbar.php' ?>
      <div class="container-fluid page-body-wrapper">
        <?php
        include 'bases/config.html';
        include 'bases/nav.php';
        include 'funciones.php';
        $perfilBD = perfilUser($con, $IdUser);
        ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row justify-content-md-center">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h1 class="card-title text-center mb-5">Actualizar Mi Perfil
                      <hr>
                    </h1>

                    <form action="funciones.php" method="post" autocomplete="off">
                      <input type="hidden" name="accion" value="actualizarPerfil">
                      <input type="hidden" name="IdUser" value="<?php echo $IdUser; ?>">

                      <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                          <input type="text" name="nombre_completo" class="form-control form-control-lg" required value="<?php echo $perfilBD['nombre_completo']; ?>" placeholder="Nombre completo" />
                        </div>
                        <div class="col-md-6">
                          <input type="text" name="din" class="form-control form-control-lg" value="<?php echo $perfilBD['din']; ?>" placeholder="DIN" required />
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="text" name="direccion_completa" class="form-control form-control-lg" value="<?php echo $perfilBD['direccion_completa']; ?>" placeholder="Dirección completa" required />
                      </div>
                      <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                          <input type="password" name="passwordUser" class="form-control form-control-lg" placeholder="Nueva Clave" />
                        </div>
                        <div class="col-md-6 mb-2">
                          <input type="email" name="emailUser" class="form-control form-control-lg" placeholder="Email" value="<?php echo $perfilBD['emailUser']; ?>" required />
                        </div>
                      </div>

                      <div class="row mb-2">
                        <div class="col-md-6 mb-3" style="margin-top: 32px !important;">
                          <input type="text" name="tlf" class="form-control form-control-lg" placeholder="Teléfono" value="<?php echo $perfilBD['tlf']; ?>" required />
                        </div>
                      </div>
                      <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" class="btn btn-primary mr-2">Actualizar datos</button>
                        <a href="./" class="btn btn-light">Cancelar</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include 'bases/PageJs.html'; ?>
  </body>

  </html>
<?php
} else { ?>
  <script type="text/javascript">
    location.href = "../acciones/login/exit.php";
  </script>
<?php }  ?>