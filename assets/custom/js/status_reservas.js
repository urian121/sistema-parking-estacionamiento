const gestionarReserva = async (boton, idReserva, desde) => {
  try {
    let trReserva = document.querySelector(`.reserva_${idReserva}`);
    let divAlert = document.querySelector("#MiAlert");

    // Verificar si existe una alerta y eliminarla
    if (divAlert !== null) {
      divAlert.innerHTML = "";
    }

    const url = `../acciones/servicio_api/cambiarStatusReserva.php/`;
    const response = await axios.post(url, {
      idReserva,
      desde,
    });
    const { success, message } = response.data;

    if (success) {
      divAlert.innerHTML = `
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>${message}
                </div>
            </div>
        `;

      console.log("Msj: ", message);
      actualizarBotonExito(boton);
      // Eliminar la alerta después de 5 segundos
      setTimeout(() => {
        divAlert.innerHTML = "";
      }, 8000);

      setTimeout(() => {
        trReserva.remove();
      }, 300);
    } else {
      console.error(`Error  ${message}`);
      // Manejar otros casos de error según sea necesario
    }
  } catch (error) {
    console.error("Error en la función gestionarReserva:", error);
    // Manejar errores de red u otros errores
  }
};

const actualizarBotonExito = (boton) => {
  boton.classList.remove("btn-danger");
  boton.classList.add("btn-success");
  boton.innerHTML =
    "<i class='bi bi-check2-all' style='font-size: 15px !important;'></i> Reserva Aceptada";
  boton.onclick = null;
  // Puedes agregar más acciones si es necesario
};
