$(document).ready(function () {

    (function disablebuttons(){
      var pesoliquido = $("#pesoliquidoprostock").val();
      var quantidade = $("#productQtdStock").val();
      var vCusto = $("#vCusto").val();
      var vVenda = $("#vVenda").val();
      var totalPagoStock = $("#totalPagoStock").val()
      if( pesoliquido == "" || quantidade == "" || vCusto == "" || vVenda == ""){
          $('#addStockPro').attr('disabled', 'disabled');
      }else{
          $('#addStockPro').removeAttr('disabled');
      }
      if (totalPagoStock == ""){
        $("#finishPurchase").attr("disabled", "disabled");
      }else{
        $("#finishPurchase").removeAttr("disabled")
      }
      setTimeout(disablebuttons, 750);
    })()


    $("#cancelPurchase").click(()=>{
        $("#bg-modal").css("top", "-100%")
        $('#stockForm')[0].reset();

        $(".trtable").remove()
    })
     
    $("#addStockB").click(()=>{
        var bgModal = document.querySelector(".bg-modal");
        bgModal.classList.remove("hideModal");
        $("#bg-modal").css("top", "0");
        $('#stockForm')[0].reset();
        $("#action").val("addStockProducts");
        $("#addStockPro").val("Adicionar Stock")
    })

    var counterId = 0
    $("#addStockPro").click(()=>{
      counterId ++;
      var productname = $("#proNameStock").val()

      var pesoliquido = $("#pesoliquidoprostock").val()
      
      var quantidade = $("#productQtdStock").val()
      var valorcusto = $("#vCusto").val()
      var valorvenda = $("#vVenda").val()
      var totalPorProduto = $("#valorTotal").val()
      var barCode = $("#barcodeInput").val()
      // var action = "verifyonStock"
      // var verificationdata = `productname`

      $("#recProListados").parent().append(`<tr class="trtable" id="trtable${counterId}"> 
      <td id="pronametd" name="pronametd">${productname}</td>
      <td id="propesoliquido" name="propesoliquido">${pesoliquido}</td>
      <td id="qtdtd" name="qtdtd">${quantidade}</td>
      <td id="valorcusto" name="valorcusto">${valorcusto}</td>
      <td id="valorvendaunidade" name="valorvenda">${valorvenda}</td> 
      <td id="totalporpro" name="totalporpro">${totalPorProduto}</td> 
      <td id="barcode" name="barcode">${barCode}</td>
      <td><button type="button" id="${counterId}" class="editStockRec prorecbtn editarButton"></button></td>
      <td><button type="button" id="${counterId}" class="delStockRec prorecbtn deleteButton"></button></td>
      </tr>`)

      var totalPagoStock = $("#totalPagoStock").val()
      if (totalPagoStock == ""){
        $("#totalPagoStock").val(totalPorProduto);
      }else{
        var novoTotal = parseInt(totalPorProduto) + parseInt(totalPagoStock)
        $("#totalPagoStock").val(parseInt(novoTotal))
      }
      //
      var profildsarray = ["proNameStock", "pesoliquidoprostock", "productQtdStock", "vCusto", "vVenda", "valorTotal", "barcodeInput"]
      profildsarray.forEach(profild=>{
        $(`#${profild}`).val("")
      })

      if($("#action").val() == "updateStock"){
        submitFunc()
      }
                  
    })

    function calcNewtotalPago(valorTotal, valorcusto, quantidade){
      var novototalpro = parseInt(valorcusto) * parseInt(quantidade);
      $(`#${valorTotal}`).val(novototalpro);
    }

    $('#sellProTable').on('click', '.editStockRec', function(){
      var id = $(this).attr("id");

      var trtable = document.querySelector(`#trtable${id}`);
  
      $('#proNameStock').val(trtable.children[0].innerHTML)
      $("#pesoliquidoprostock").val(trtable.children[1].innerHTML)
      $("#productQtdStock").val(trtable.children[2].innerHTML)
      $("#vCusto").val(trtable.children[3].innerHTML)
      $("#vVenda").val(trtable.children[4].innerHTML)
      $("#valorTotal").val(trtable.children[5].innerHTML)
      $('#barcodeInput').val(trtable.children[6].innerHTML)
      var totalV = trtable.children[5].innerHTML
      document.querySelector('#totalPagoStock').value -= totalV
      $(`#trtable${id}`).remove()
      $("#addStockPro").removeAttr('disabled')
    })


    $('#sellProTable').on('click', '.delStockRec', function(){var id = $(this).attr("id");var trtable = document.querySelector(`#trtable${id}`);var recValue = trtable.children[5].innerHTML;document.querySelector('#totalPagoStock').value -= recValue;$(`#trtable${id}`).remove();})


    $("#productQtdStock").keyup(()=>{var quantidade = $("#productQtdStock").val();var valorcusto = $("#vCusto").val();valorcusto != "" && calcNewtotalPago("valorTotal", valorcusto, quantidade)});$("#vCusto").keyup(()=>{var quantidade = $("#productQtdStock").val();var valorcusto = $("#vCusto").val();quantidade != "" && calcNewtotalPago("valorTotal", valorcusto, quantidade)})


    const submitFunc = ()=>{
      var action = $("#action").val()
      var usernamelogged = $("#usernamelogged").val()
      var stockCode = $("#stockCode").val()
      var trtable = document.querySelectorAll(".trtable")
      trtable.forEach(trsun=>{
        var pronametd = trsun.children[0].innerHTML
        var pltd = trsun.children[1].innerHTML
        var qtdtd = trsun.children[2].innerHTML
        var vcutd = trsun.children[3].innerHTML
        var vvutd = trsun.children[4].innerHTML
        var tpptd = trsun.children[5].innerHTML
        var barCode = trsun.children[6].innerHTML
  
        var trdata = `pronametd=${pronametd}&pltd=${pltd}&qtdtd=${qtdtd}&vcutd=${vcutd}&vvutd=${vvutd}&tpptd=${tpptd}&stockr=${qtdtd}&action=${action}&stockCode=${stockCode}&usernamelogged=${usernamelogged}&barCodetd=${barCode}`
        
        $.ajax({
          url: "barAction.php",
          method: "POST",
          data: trdata,
          // dataType: "json",
          success: function(data){
            $("#action").val() == "updateStock" ? swal({icon: "success",title: "Actualização de Stock",text: "Stock actualizado com sucesso!"}) : swal({icon: "success",title: "Cadastro de Stock",text: "Novo stock cadastrado com sucesso!"})

            $('#stockForm')[0].reset();
            $(".trtable").remove();
            $("#bg-modal").css("top", "-100%");
            // window.location = "stock.php"
            refreshNeeded()

            // console.table(data)
          }, error: function(){
            alert('Houve um erro desconhecido!')
          }
        })
      })
    }

    $("#bg-modal").on("submit", "#stockForm", function(e){
      e.preventDefault()
      submitFunc()
    })

    var showhidebarcodediv = document.getElementById("showhidebarcodediv");showhidebarcodediv.addEventListener('click', function(){$("#barcodeInput").val("");document.querySelector('#barCodeDivstock').classList.toggle("hideBarcodeDivstock")})

});