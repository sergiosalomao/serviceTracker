
$("#cpf").mask("999.999.999-99");
$("#cep").mask("99999-999");
$("#telefone").mask("(99)99999-9999");
$('.money').mask('#.##0.00', { reverse: true });

function limparCampos(nomeform) {
  $("#" + nomeform).trigger("reset");

}

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})


$(function () {



  $('#datepicker').datepicker({
    /*     showOn: "button", */
    /*     buttonImage:  "./../images/calendar.svg", */
    /*     buttonText: "Date Picker", */
    /*     buttonImageOnly: true, */
    changeMonth: true,
    changeYear: true,
    changeDay: true,
    showButtonPanel: true,
    dateFormat: 'dd/mm/yy',
    onClose: function (dateText, inst) {
      var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
      var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
   /*    $(this).datepicker('setDate', new Date(year, month , 1)); */
      $(this).datepicker('setDate', dateText); 
    },
    onSelect: function (dateText, inst) {
      $(this).datepicker('setDate', dateText);
   }
  });


  $.datepicker.regional['pt'] = {
    closeText: 'Fechar',
    prevText: 'Anterior',
    nextText: 'Proximo',
    currentText: 'Mes Atual',
    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
      'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
      'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    dayNames: ['Domingo', 'Segunda&#236', 'Terca&#236', 'Quarta&#236',
      'Quinta&#236', 'Sexta&#236', 'Sabado'],
    dayNamesShort: ['Dom', 'Seg', 'Ter', 'Quar', 'Qui', 'Sex', 'Sab'],
    dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 0,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };

  $.datepicker.setDefaults($.datepicker.regional['pt']);


});



/* var myAlert =document.getElementById('toastNotice');//select id of toast
  var bsAlert = new bootstrap.Toast(myAlert);//inizialize it
  bsAlert.show();//show it */

