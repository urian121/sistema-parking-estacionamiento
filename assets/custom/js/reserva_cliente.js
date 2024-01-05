const calcularDiferenciaDias = () => {
  let fechaEntrega = document.getElementById("fecha_entrega").value;
  let fechaRecogida = document.getElementById("fecha_recogida").value;

  if (fechaEntrega == "") {
    mi_alerta("Debe seleccionar una fecha de entrega", 0);
    return null;
  }

  if (fechaRecogida == "") {
    mi_alerta("Debe seleccionar una fecha de recogida", 0);
    return null;
  }

  // Convertir las cadenas de fecha en objetos Date
  let fechaEntregaDate = new Date(
    fechaEntrega.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")
  );
  let fechaRecogidaDate = new Date(
    fechaRecogida.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")
  );

  resp = validarFechas(fechaEntregaDate, fechaRecogidaDate);
  /**
   * Actualizando los dias de la reserva cada vez que se modifique cualquier fecha
   */
  dias_reserva(resp);

  /**
   * Obtengo el valor de tipo plaza para llamar a la funcion calcularPago pasarle la plaza y actualizar el
   * pago cada vez que modifiquen cualquier fecha
   */
  calcularPago(document.querySelector("#tipo_plaza").value);
  return resp;
};

/**
 * Obtener dias de la reserva
 */
function dias_reserva(nuevoValor) {
  const clave = "dias_reservas";
  // Verificar si la clave existe en localStorage
  if (localStorage.getItem(clave) !== null) {
    // Actualizando el valor
    localStorage.setItem(clave, nuevoValor);
    return nuevoValor;
  } else {
    // La clave no existe, la creamos y le asignamos un valor
    localStorage.setItem(clave, nuevoValor);
    return nuevoValor;
  }
}

/**
 * Funcion para validar las fechas, aplicando algunas reglas
 */
function validarFechas(fechaEntregaDate, fechaRecogidaDate) {
  let m = "";
  let totaR = document.querySelector("#totalReserva");
  let totalPR = document.querySelector("#total_pago_reserva");
  if (fechaEntregaDate > fechaRecogidaDate) {
    m = "La fecha de entraga no puede ser mayor a la fecha de Recogida";
    totaR.innerHTML = "";
    totalPR.innerHTML = "";
    mi_alerta(m, 0);
    return null;
  } else if (fechaRecogidaDate < fechaEntregaDate) {
    m = "La fecha de recogida no puede ser mayor a la fecha de Entrega";
    totaR.innerHTML = "";
    totalPR.innerHTML = "";
    mi_alerta(m, 0);
    return null;
  } else if (fechaEntregaDate.getTime() === fechaRecogidaDate.getTime()) {
    m = "La fecha de Entrega no puede ser igual a la fecha de Recogida";
    totaR.innerHTML = "";
    totalPR.innerHTML = "";
    mi_alerta(m, 0);
    return null;
  }

  const divExist = document.querySelector(".alert");
  if (divExist) {
    divExist.remove();
  }

  // Calcular la diferencia en milisegundos
  var diferenciaMilisegundos = fechaRecogidaDate - fechaEntregaDate;
  // Calcular la diferencia en días
  var diferenciaDias = Math.floor(
    diferenciaMilisegundos / (1000 * 60 * 60 * 24)
  );
  return diferenciaDias;
}

/**
 * Funcion para calcular el total de la reserva en Euros
 */
const calcularPago = async (tipoPlaza) => {
  let totalR = document.querySelector("#totalReserva");
  let pagoTotalBD = document.querySelector("#total_pago_reserva");

  let fechaEntregaDate = document.getElementById("fecha_entrega").value;
  let fechaRecogidaDate = document.getElementById("fecha_recogida").value;
  if (fechaEntregaDate == "" || fechaRecogidaDate == "") {
    mi_alerta("Debe existir una fecha de entrega y una fecha de recogida", 0);
    totalR.innerHTML = "";
    dias_reserva("");
    return false;
  }

  if (tipoPlaza == "") {
    mi_alerta("Debe seleccionar un Tipo de Plaza", 0);
    totalR.innerHTML = "";
    pagoTotalBD.innerHTML = "";
    return false;
  }
  /**
   * Verificar que existen ambas fechas
   */
  var fechaEntregaD = new Date(
    fechaEntregaDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")
  );
  var fechaRecogidaD = new Date(
    fechaRecogidaDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")
  );

  // Convertir las cadenas de fecha en objetos Date

  let msj = "";
  if (fechaEntregaD > fechaRecogidaD) {
    totalR.innerHTML = "";
    msj = "La fecha de entraga no puede ser mayor a la fecha de Recogida";
    mi_alerta(msj, 0);
    return null;
  } else if (fechaRecogidaD < fechaEntregaD) {
    totalR.innerHTML = "";
    msj = "La fecha de recogida no puede ser mayor a la fecha de Entrega";
    mi_alerta(msj, 0);
    return null;
  } else if (fechaEntregaD.getTime() === fechaRecogidaD.getTime()) {
    totalR.innerHTML = "";
    msj = "La fecha de Entrega no puede ser igual a la fecha de Recogida";
    mi_alerta(msj, 0);
    return null;
  }

  let TotalDias = localStorage.getItem("dias_reservas");
  try {
    const formData = {
      tipo_plaza: tipoPlaza,
      total_dias: TotalDias,
    };

    // Puedes ajustar la URL a la que deseas enviar el formulario
    const url = "../acciones/servicio_api/api_dias_reserva.php";
    const response = await axios.post(url, formData);

    // Manejar la respuesta según sea necesario
    const dataFromServer = response.data;
    const valor = dataFromServer[0].valor;

    totalR.innerHTML = `${valor} €, con el IVA incluido.`;
    pagoTotalBD.value = valor;
  } catch (error) {
    // Manejar errores
    console.error("Error al consultar el valor a Pagar:", error);
  }
};

/**
 * Funcion para mostrar alerta
 */
function mi_alerta(msj, tipo_msj) {
  const divExistente = document.querySelector(".alert");
  if (divExistente) {
    divExistente.remove();
  }
  const divRespuesta = document.createElement("div");

  divRespuesta.innerHTML = `
          <div class="alert ${
            tipo_msj == 1 ? "alert-success" : "alert-danger"
          }  alert-dismissible text-center" role="alert" style="font-size: 16px;">
            ${msj}
          </div>
        `;

  setTimeout(function () {
    divRespuesta.innerHTML = "";
  }, 8000);

  // Agregar el div al final del contenedor con clase "container"
  const container = document.querySelector(".card-title");
  container.insertAdjacentElement("beforeend", divRespuesta);
}
