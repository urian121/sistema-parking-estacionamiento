$("#fecha_entrega").datepicker({
  minDate: new Date(new Date().getFullYear(), new Date().getMonth(), 1),
  format: "dd-mm-yyyy",
  showMonthAfterYear: true,
  autoclose: true,
  todayHighlight: true,
  locale: "es-es",
  disableDates: function (date) {
    var today = new Date();
    //Desabilitando el dia actual
    let dia_actual = today.setDate(today.getDate());
    return date > dia_actual;
  },
});

$("#fecha_entregaXX").datepicker({
  minDate: new Date(new Date().getFullYear(), new Date().getMonth(), 1),
  format: "dd-mm-yyyy",
  showMonthAfterYear: true,
  autoclose: true,
  todayHighlight: true,
  locale: "es-es",
  disableDates: function (date) {
    var today = new Date();
    let dia_actual = today.setDate(today.getDate() - 1);
    return date > dia_actual;
  },
});

$("#fecha_recogida").datepicker({
  minDate: new Date(new Date().getFullYear(), new Date().getMonth(), 1),
  format: "dd-mm-yyyy",
  showMonthAfterYear: true,
  autoclose: true,
  todayHighlight: true,
  locale: "es-es",
  disableDates: function (date) {
    var today = new Date();
    let dia_actual = today.setDate(today.getDate() - 1);
    return date > dia_actual;
  },
});
