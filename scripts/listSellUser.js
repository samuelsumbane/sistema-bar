$(document).ready(function () {

    var table = $('#tabelaVendaUser').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': '../src/selectVendas.php',
        "method": "POST"
      },
      'columns': [
        { data: "producto" },
        { data: "pesoliquido"},
        { data: "quantidade" },
        { data: "valortotal" },
        { data: "mes" },
        { data: "ano" }
      ],
      "oLanguage": {
        "sProcessing": "Processando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "Não foram encontrados resultados",
        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando de 0 até 0 de 0 registros",
        "sInfoFiltered": "",
        "sInfoPostFix": "",
        "sSearch": "Pesquisar:",
        "sUrl": "",
        "oPaginate": {
          "sFirst": "Primeiro",
          "sPrevious": "Anterior",
          "sNext": "Seguinte",
          "sLast": "Último"
        }
      }
    });

})