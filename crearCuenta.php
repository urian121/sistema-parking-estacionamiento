<!DOCTYPE html>
<html lang="es">
<?php include('basesLogin/head.php'); ?>

<body>
  <?php
  include('msjs.php');
  include("dashboard/bases/loader.html");
  ?>


  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row mt-5 w-100 mx-0">
          <div class="col-md-6 mx-auto">
            <div class="auth-form-light text-left py-5 px-4">
              <div class="brand-logo">
                <a href="./">
                  <img src="assets/custom/imgs/logo_naranja.png" alt="logo" />
                </a>
              </div>
              <h2 class="text-center mb-4">Crear Cuenta
                <hr>
              </h2>
              <form action="acciones/login/CreateUser.php" method="post" autocomplete="off">

                <div class="row mb-2">
                  <div class="col-md-6 mb-2">
                    <input type="text" name="nombre_completo" class="form-control form-control-lg" required placeholder="Nombre completo" />
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="din" class="form-control form-control-lg" placeholder="DIN" required />
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" name="direccion_completa" class="form-control form-control-lg" placeholder="Dirección completa" required />
                </div>
                <div class="row mb-2">
                  <div class="col-md-6 mb-2">
                    <input type="password" name="passwordUser" class="form-control form-control-lg" placeholder="Clave" required />
                  </div>
                  <div class="col-md-6 mb-2">
                    <input type="email" name="emailUser" class="form-control form-control-lg" placeholder="Email" required />
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-6 mb-3" style="margin-top: 32px !important;">
                    <input type="text" name="tlf" class="form-control form-control-lg" placeholder="Teléfono" required />
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="">¿Cómo nos ha conocido?</label>
                    <select name="conocido_por" class="form-control form-control-lg">
                      <option value="Seleccione">Seleccione</option>
                      <option value="Ya soy cliente">Ya soy cliente</option>
                      <option value="Google">Google</option>
                      <option value="Teléfono">Teléfono</option>
                      <option value="Un Amigo">Un Amigo</option>
                      <option value="Internet">Internet</option>
                      <option value="Periódico">Periódico</option>
                      <option value="Folleto">Folleto</option>
                      <option value="Radio">Radio</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-floating">
                    <textarea class="form-control" name="observaciones" placeholder="Observaciones" style="height: 100px"></textarea>
                  </div>
                </div>
                <div class="row mb-2 text-center">
                  <div class="col-md-12 mb-2">
                    <input type="checkbox" name="terminos" value="1" class="form-check-input" checked>
                    <label class="form-check-label" for="terminos">
                      Acepto los términos de uso
                    </label>
                  </div>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    Crear mi cuenta
                  </button>
                </div>
                <div class="my-2 d-flex justify-content-start align-items-center">
                  <a href="./" class="auth-link text-black" title="volver">
                    <i class="bi bi-arrow-left-circle"></i>
                    Volver
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('basesLogin/footerJS.html'); ?>
</body>

</html>