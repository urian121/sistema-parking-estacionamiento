let tbody = document.querySelector("tbody");
let infoR1 = document.querySelector(".infoR1");
let infoR2 = document.querySelector(".infoR2");
if (tbody) {
  tbody.addEventListener("click", async (event) => {
    let target = event.target;

    console.log(target.cellIndex);
    if (target.cellIndex == undefined) {
      return;
    }

    if (target.tagName === "TD" && target.parentElement.tagName === "TR") {
      let trElement = target.parentElement;
      let reserva_id = trElement.id;
      let cellIndex = target.cellIndex;

      let tableBody = document.querySelector("table").getAttribute("id");
      console.log(tableBody);
      if (tableBody == "tablaReservasPendientes") {
        if (cellIndex === 11 || cellIndex === undefined) {
          //no hacer nada xq se hizo click en el primer td de cualquier fila tr
          return;
        }
      } else if (tableBody == "tablaHistorialReservas") {
        if (cellIndex === 12 || cellIndex === undefined) {
          //no hacer nada xq se hizo click en el primer td de cualquier fila tr
          return;
        }
      } else if (tableBody == "TablaAgenda") {
        if (cellIndex === 11 || cellIndex === undefined) {
          return;
        }
      }

      $("#DetalleReserva").modal("show");
      try {
        const response = await axios.post(
          "../acciones/CustomDetalleReserva.php",
          { reserva_id }
        );
        const {
          nombre_completo,
          din,
          emailUser,
          direccion_completa,
          tlf,
          conocido_por,
          observaciones,
          color,
          matricula,
          marca_modelo,
          tipo_plaza,
          terminal_entrega,
          terminal_recogida,
          servicio_adicional,
          fecha_entrega,
          fecha_recogida,
          hora_entrega,
          hora_recogida,
          total_pago_reserva,
          numero_vuelo_de_vuelta,
          formato_pago,
          fecha_pago_factura,
          date_registro,
        } = response.data;
        console.log(emailUser);

        infoR1.innerHTML = `
        <h3 class="mt-3">
          Información del Cliente
          <hr />
        </h3>
        <h4 class="card-text buttom mb-3">Cliente: ${nombre_completo}</h4>
        <h4 class="card-text buttom mb-3">DIN: ${din}</h4>
        <h4 class="card-text buttom mb-3">Teléfono: ${tlf}</h4>
        <h4 class="card-text buttom mb-3">Email: ${emailUser}</h4>
        <h4 class="card-text buttom mb-3">Dirección: ${direccion_completa}</h4>
        <h4 class="card-text buttom mb-3">Observaciones: ${observaciones}</h4>
        <h4 class="card-text buttom mb-3">Cómo nos conocio: ${
          conocido_por !== null ? conocido_por : "No especificado"
        }</h4>
        `;

        infoR2.innerHTML = `
         <h3 class="mt-3">
            Información de la Reserva
          <hr />
        </h3>
        <h4 class="card-text buttom mb-3">Matrícula: ${matricula}</h4>
        <h4 class="card-text buttom mb-3">Color: ${color}</h4>
        <h4 class="card-text buttom mb-3">Marca - Modelo: ${marca_modelo}</h4>
        <h4 class="card-text buttom mb-3">Tipo de Plaza: ${tipo_plaza}</h4>
        <h4 class="card-text buttom mb-3">Servicio Adicional: ${servicio_adicional}</h4>
        <h4 class="card-text buttom mb-3">Terminal de Entrega: ${terminal_entrega}</h4>
        <h4 class="card-text buttom mb-3">Terminal de Recorida: ${terminal_recogida}</h4>
        <h4 class="card-text buttom mb-3">Fecha de Entrega: ${fecha_entrega}</h4>
        <h4 class="card-text buttom mb-3">Hora de Entrega: ${hora_entrega}</h4>
        <h4 class="card-text buttom mb-3">Fecha de Recogida: ${fecha_recogida}</h4>
        <h4 class="card-text buttom mb-3">Hora de Recogida: ${hora_recogida}</h4>
        <h4 class="card-text buttom mb-3">terminal_entrega: ${numero_vuelo_de_vuelta}</h4>
        <h4 class="card-text buttom mb-3">Total Deauda: ${
          formato_pago !== null
            ? "<span style='color:green;'>" +
              total_pago_reserva +
              "<i class='bi bi-currency-euro'></i></span>"
            : "<span style='color:red;'>" +
              total_pago_reserva +
              "<i class='bi bi-currency-euro'></i></span>"
        }</h4>
        
        <h4 class="card-text buttom mb-3">Estatus Pago: ${
          formato_pago !== null
            ? "<span style='color:green;'>" + formato_pago + "</span>"
            : "<span style='color:red;'>No ha pagado</span>"
        }</h4>

        ${
          fecha_pago_factura !== null
            ? `<h4 class="card-text buttom mb-3">Fecha Pago: ${fecha_pago_factura}</h4>`
            : ""
        }
        `;
      } catch (error) {
        // Puedes manejar los errores aquí si es necesario
        console.error(error);
      }
    }
  });
}
