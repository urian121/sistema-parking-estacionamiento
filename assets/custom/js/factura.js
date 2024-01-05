$(".factura").click(function () {
  let reservaId = $(this).data("id");
  let cliente = $(this).data("cliente");
  let din = $(this).data("din");
  let matricula = $(this).data("matric");
  let deuda = $(this).data("deuda");
  let email = $(this).data("email");
  let servicios_extras = $(this).data("servicios_extras");
  let total_gasto_extras = $(this).data("total_gasto_extras");

  let contenido = `
            <h4>Cliente: ${cliente} </h4>
            <h4>DIN: ${din}</h4>
            <h4>Matricula: ${matricula}</h4>
            <h4>Deuda: ${deuda} <i class="bi bi-currency-euro"></i></h4>
        `;

  document.querySelector(".clienteModal").innerHTML = contenido;
  document.querySelector("#idReserva").value = reservaId;
  document.querySelector("#deuda").value = deuda;
  document.querySelector("#emailCliente").value = email;
  document.querySelector("#servicios_extras").value = servicios_extras;
  document.querySelector("#total_gasto_extras").value = total_gasto_extras;
  $("#modalFactura").modal("show");
});
