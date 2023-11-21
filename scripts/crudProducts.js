$(document).ready(function () {

  (function disablebuttons() {
    var marca = $("#nomeCliente").val();
    var  pesoLiquido = $("#pesoLiquido").val();
    var  valorCusto = $("#valorCusto").val();
    var valorVenda = $("#valorVenda").val();
    if (marca == "" || pesoLiquido == "" || valorCusto == "" || valorVenda == "") {
      $('#submeter').attr('disabled', 'disabled');
    } else {
      $('#submeter').removeAttr('disabled');
    }
    setTimeout(disablebuttons, 750);
  })();


  $("#addProductB").click(() => {
    var bgModal = document.querySelector(".bg-modal");
    bgModal.classList.remove("hideModal");
    $("#bg-modal").css("top", "0");
    document.getElementById("modaltitle").innerHTML = "Cadastrar Producto";
    $('#clientform')[0].reset();
    $('#action').val("addProduct");
    $('#submeter').val('Cadastrar');

  });

  $("#fecharClientModal").click(() => { $("#bg-modal").css("top", "-100%") });
  //
  $('#bg-modal').on('submit', '#clientform', function (event) {
    event.preventDefault();
    $('#submeter').attr('disabled', 'disabled');
    var formData = $(this).serialize();
    $.ajax({
      url: "barAction.php",
      method: "POST",
      data: formData,
      success: function (data) {
        $('#clientform')[0].reset();
        $("#bg-modal").css("top", "-100%");
        $('#submeter').attr('disabled', false);
        window.location = "produtos.php"
      },error: function(){
        alert("Houve um erro desconhecido")
      }
    })
  });

});