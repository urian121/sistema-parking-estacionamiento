const formatCurrency = (inputClick) => {
  let cantidad = inputClick.target.value.replace(/\D/g, ""); // Eliminar caracteres no numéricos
  cantidad = parseInt(cantidad, 10); // Convertir a número entero
  if (isNaN(cantidad)) {
    cantidad = 0; // Si no se puede convertir a número, se establece en 0
  }
  // Formatear la cantidad en euros y asignarla al campo de entrada
  inputClick.target.value = cantidad.toLocaleString("es-ES", {
    currency: "EUR",
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });
};
