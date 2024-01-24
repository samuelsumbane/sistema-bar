$(document).ready(function () {

    var table = $('#tabela').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': '../src/selectAtivities.php',
        "method": "POST"
      },
      'columns': [
        { data: "accao"},
        { data: "producto" },
        { data: "pesoliquido"},
        { data: "quantidade" },
        { data: "totalpago" },
        { data: "usuario" },
        { data: "dia" },
        { data: "hora" }
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

    $("#fecharModal").click(()=>{
      $("#bg-modal").css("top", "-100%")
      $(".trtable").remove()
    })
  
    $("#relatorioPage").click(function(){
      var bgModal = document.querySelector(".bg-modal");
      bgModal.classList.remove("hideModal");
      $("#bg-modal").css("top", "0");
      $('#relForm')[0].reset();
      $("#action").val("verifyA");
    })

    const datesinputrel = ["dateprintbegin", "dateprintfinal"].forEach(a=>{$(`#${a}`).change(()=>{$("#dateprintbegin").val() != "" && $("#dateprintfinal").val() != "" ? $("#submeter").removeAttr('disabled') : $("#submeter").attr('disabled', 'disabled') })})

    $("#bg-modal").on("submit", "#relForm", function(e){
      e.preventDefault()
      var dat = new Date($("#dateprintbegin").val())
      var dia = ("0" + dat.getDate()).slice(-2);
      var cMonth = dat.getMonth() + 1
      var mes = ("0" + cMonth).slice(-2);
      var ano = dat.getFullYear()
      var dateprintbegin = `${ano}-${mes}-${dia}`

      var datf = new Date($('#dateprintfinal').val())
      var diaf = ("0" + datf.getDate()).slice(-2);
      var cMonthf = datf.getMonth() + 1
      var mesf = ("0" + cMonthf).slice(-2);
      var anof = datf.getFullYear()
      var dateprintfinal = `${anof}-${mesf}-${diaf}`

      let horainicial = $('#horainicial').val()
      let horafinal = $('#horafinal').val()
      if(horainicial == "" || horafinal == ""){
        horainicial = "00:00"
        horafinal = "23:59"
      }
      var action = $("#action").val()
      $.ajax({
        url: "barAction.php",
        method: 'POST',
        data: {dateprintbegin:dateprintbegin, dateprintfinal:dateprintfinal, horainicial:horainicial, horafinal:horafinal, action:action}, 
        dataType: "json",
        success: function(data){
          if(data == false){
            swal({
              info: "error",
              title: "Registros não encontrados",
              text: `Não conseguimos encontrar nenhum registro nas datas selecionadas `
            })
          }else{
            // console.table(data)
            window.location = `../src/ativiRecibo.php?printdateinicial=${dateprintbegin}&printdatefinal=${dateprintfinal}&horainicial=${horainicial}&horafinal=${horafinal}`
          }
        }, error: function(){
          alert("Houve um erro desconhecido")
        }
      })
    })


})