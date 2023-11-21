"use strict";

const selectpros = ()=>{
  var action = "selectallrecordsP"; $.ajax({ url: "barAction.php", method: "POST", data: { action: action }, dataType: "json", success: function (data) { for (var i = 0; i < data.length; i++) { var proC = data[i]["codigo"]; var proN = data[i]["producto"]; var proP = data[i]["pesoliquido"]; var proF = `${proC} - ${proN} - ${proP}`; var selectData = [proF]; $("#sellProComboBox").select2({ data: selectData }); } }, error: function () { alert('Erro') }})
}


function cleanSelectBox(){
    $("#sellProComboBox").select2().empty();
    $("#sellProComboBox").append(`<option>Selecione Producto</option>`)
    $("#sellProComboBox").select2()
}

const removeAllStoragecodes = ()=>{
    let codeList = sessionStorage.getItem('codeList')
    if(codeList){
      let codeListValue = codeList.split(',')
      let codeListLen = codeListValue.length

      if(codeListLen > 0){
        codeListValue.map((thisvalue) => {
          sessionStorage.removeItem(thisvalue)
        })
        sessionStorage.removeItem('codeList')
      }  
    }
}


function codeResults(codeStock, barcodeC){
 
    var action = "productData"
    $("#selectedCode").val(codeStock)
    if(codeStock == isNaN){    
        swal({ icon: "error", title: "Erro ao carregar os dados", text: "Por favor, actualize a página e tente novamente" })
    }else{
        $.ajax({
            url: "barAction.php",
            method: "POST",
            data: { codeStock: codeStock, action: action },
            dataType: "json",
            success: function (data) {
            if (data != false) {
                // sessionStorage.setItem('activeCode', codeStock)

                if(data[1] != false){
                    $("#nGarafas").val(data[1]["nprodutos"])
                    $("#vPromo").val(data[1]["vpromo"])
                }
                $("#productQtd").val(barcodeC)
                $('#nameproinput').val(data[0]["producto"])

                var srestante = document.querySelector('#srestante').value
                var codigodoproducto = data[0]['codigo']
                let stockrestante = parseInt(data[0]['stockrestante'])
    
                if(sessionStorage.getItem(codigodoproducto)){
                let provalue = sessionStorage.getItem(codigodoproducto)
                    srestante = stockrestante - provalue
                }else{
                    srestante = stockrestante
                }
                
                $("#srestante").val(srestante);

                $('#plproinput').val(data[0]["pesoliquido"])
                $("#valorCustoSell").val(data[0]["valorcusto"])
                $("#valorvenda").val(data[0]["valorvenda"])
                $("#afterDc").val(data[0]["valorvenda"])
                document.getElementById('valorTotal').value = data[0]["valorvenda"]
                $("#selectedCode").val(data[0]["codigo"])
                $("#proCode").val(data[0]["codigo"])
            
                $("#addSellPro").attr('disabled', false)
            
                document.querySelector("#qtddpro").innerHTML = `Total de productos por unidade ${srestante}`

            
            } else {
                swal({ icon: "error", title: "Nenhum producto encontrado", text: "o código scaneado não foi atribuiado a nenhum producto" })
            }
            }, error: function () { alert("Houve um erro desconhecido!") }
        })
    }
}

  $("#productQtd").click(() => { calcProCostOption() });
  $("#productQtd").keyup(() => { calcProCostOption() });
  $("#dcInput").change(() => {calcDesconto()})


const calcProCost = (quantidadePro, promoCode) => {
    var valorvenda = $("#valorvenda").val();
    var srestante = $("#srestante").val();
    // console.log(`stockrestante from calcpro ${srestante}`)
    if (quantidadePro == ""){
        $("#addSellPro").attr("disabled", true);
        $("#valorTotal").val("");
        $("#afterDc").val("")
    }else{
        if (parseInt(quantidadePro ) > parseInt(srestante)) {
            $("#addSellPro").attr("disabled", 'disabled')
            swal({icon: "info",title: "",text: "A quantidade requisitada é maior que a quantidade de producto existente"})
            cleanSellFilds();
            bInput = '';
            barcodeC = 0;
            $('#addSellPro').attr("disabled", true)

        } else {
            // var promoCode = $("#proCode").val()

            // console.log(quantidadePro)
            // console.log(parseInt(quantidadePro) + 1)
            var vDig = document.getElementById("productQtd")
            vDig.value = quantidadePro // as ivDig
            var newV = quantidadePro // as ivDig

            var action = "selectPromo"
            // console.log(promoCode, newV)

            $.ajax({
                url: "barAction.php",
                method: "POST",
                data: { promoCode: promoCode, vDig: newV, action: action },
                dataType: "json",
                success: function (data) {

                    if (data != false) {
                        console.log('tem promocoes')

                        var ngarafa = data.nprodutos
                        var vpromo = data.vpromo

                        if ($("#productQtd").val() == ngarafa) {
                            $("#valorTotal").val(vpromo)
                            $("#afterDc").val(vpromo)
                            $("#addSellPro").removeAttr('disabled')
                        } else {
                            let totalProCost = valorvenda * newV
                            $("#valorTotal").val(totalProCost)
                            $("#afterDc").val(totalProCost)
                            // console.log(totalProCost)
                            $("#addSellPro").removeAttr('disabled')
                        }
                    } else {
                        // console.log('nao tem promocoes')
                        let totalProCost = valorvenda * newV
                        $("#valorTotal").val(totalProCost)
                        $("#afterDc").val(totalProCost)
                        $("#addSellPro").removeAttr('disabled')
                    }
                }, error: function () {
                    alert("Houve um erro ao verificar promocões!")
                }
            })
        }
    }
}


var counterId = 0
function addRecsTable(){
    counterId += 1
    selectpros()
    
    var productName = $('#nameproinput').val()
    var restantStock = $("#srestante").val()
    var pltd = $('#plproinput').val()
    var qtdprovalue = $("#productQtd").val()
    var vcustosell = $("#valorCustoSell").val()
    var vvenda = $("#valorvenda").val()
    var totalDc = $("#afterDc").val()
    var proCode = $("#proCode").val()
    var dctd = $("#dcInput").val()

    bInput = '';
    barcodeC = 0;
    dctd == "" ? dctd = "0.00" : dctd = parseFloat(dctd)

    if(productName != ""){
        
        if(sessionStorage.getItem(proCode)){
            let lastListProQtd = sessionStorage.getItem(proCode)
            let newListProQtd = parseInt(lastListProQtd) + parseInt(qtdprovalue)
            sessionStorage.setItem(proCode, newListProQtd)
        }else{
            sessionStorage.setItem(proCode, qtdprovalue)
        }

        if(sessionStorage.getItem('codeList')){
            let lastCodeList = sessionStorage.getItem('codeList')
            sessionStorage.setItem('codeList', [lastCodeList, proCode])
        }else{
            sessionStorage.setItem('codeList', [proCode])
        }
        
        $("#recProListados").parent().append(`
        <tr class="trtablefake" id="trtablefake${counterId}" style="width:100%;color:white;max-height:22px;height:20px"> 

        <td width=20% id="pronametd" name="pronametd">${productName}</td>
        <td width=15% id="pltd" name="pltd">${pltd}</td> 
        <td width=15% id="qtdtd" name="qtdtd">${qtdprovalue}</td> 
        <td width=15% id="totaltd" name="totaltd">${totalDc}</td> 
        <td width=15% id="dctd" name="dctd">${dctd}</td> 
        <td width=10%><button type="button" id="${counterId}" class="editProSellRec prorecbtn editarButton" style="margin-right:0 !important" ></button></td>
        <td width=10%><button type="button" id="${counterId}" class="delProSellRec prorecbtn deleteButton" 
        style="margin-left:74%"></button></td>
        </tr>`)
        //
        $("#recProListados").parent().append(`
        <tr class="trtable" id="trtable${counterId}" style="color:transparent;height:20px;"> 
        <td id="codetd" name="codetd">${proCode}</td>
        <td id="pronametd" name="pronametd">${productName}</td>
        <td id="pltd" name="pltd">${pltd}</td> 
        <td id="vctd" name="vctd">${vcustosell}</td> 
        <td id="vvtd" name="vvtd">${vvenda}</td> 
        <td id="qtdtd" name="qtdtd">${qtdprovalue}</td> 
        <td id="totaltd" name="totaltd">${totalDc}</td> 
        <td id="sr" name="sr">${restantStock}</td>  
        <td id="dctd" name="dctd">${dctd}</td> 
        <td id="afterDc" name="afterDc">${totalDc}</td> 

        </tr>`)
    }
    var valorTotalDoPedido = $("#totalPedido").val()
    if (valorTotalDoPedido == "") {
        $("#totalPedido").val(totalDc);
    } else {
        var novoTotal = parseInt(totalDc) + parseInt(valorTotalDoPedido)
        $("#totalPedido").val(parseInt(novoTotal))
    }
    //
    cleanSellFilds()
    document.querySelector("#qtddpro").textContent = ""
    $("#finishPurchase").removeAttr('disabled')
    $("#addSellPro").attr('disabled', 'disabled')

}


const calcProCostOption = () => {
    var valorvenda = $("#valorvenda").val();
    var quantidadePro = $("#productQtd").val()
    // var codeAndRs = $('#selectedCode').val()
    var srestante = $("#srestante").val();

    // console.log(srestante)
    if (quantidadePro == ""){
        $("#addSellPro").attr("disabled", true);
        $("#valorTotal").val("");
        $("#afterDc").val("")
    }else{
        if (quantidadePro > parseInt(srestante)) {
            $("#addSellPro").attr("disabled", 'disabled')
            swal({icon: "info",title: "",text: "A quantidade requisitada é maior que a quantidade de producto existente"})
            $("#productQtd").val("")
        } else {
        // $("#selectedCode").val(returnSelectClasses()) 
            var promoCode = $("#proCode").val()
            var srvalue = $("#srestante").val()
            var vDig = document.getElementById("productQtd").value
            var newV = parseInt(vDig)
            var action = "selectPromo"

            $.ajax({
                url: "barAction.php",
                method: "POST",
                data: { promoCode: promoCode, vDig: newV, action: action },
                dataType: "json",
                success: function (data) {
                if (data != false) {
                    var ngarafa = data.nprodutos
                    var vpromo = data.vpromo
                
                    if ($("#productQtd").val() == ngarafa) {
                        $("#valorTotal").val(vpromo)
                        $("#afterDc").val(vpromo)
                        $("#addSellPro").removeAttr('disabled')

                    } else {
                        let totalProCost = valorvenda * newV
                        $("#valorTotal").val(totalProCost)
                        $("#afterDc").val(totalProCost)
                        $("#addSellPro").removeAttr('disabled')
                    }

                } else {
                    let totalProCost = valorvenda * newV
                    $("#valorTotal").val(totalProCost)
                    $("#afterDc").val(totalProCost)
                    $("#addSellPro").removeAttr('disabled')
                }
                }, error: function () {
                    alert("Houve um erro ao verificar promocões!")
                }
            })
        }
    }
}

  
const calcDesconto = () =>{
    var dcInput = document.getElementById("dcInput").value
    var qtdPro = $("#productQtd").val()
    var vvenda = $("#valorvenda").val()
    // console.log(qtdPro, vvenda)
    if (dcInput != ""){
        const lastTotal = $("#valorTotal").val()
        if(lastTotal != ""){
            if(parseInt(dcInput) > parseInt(lastTotal)){
                swal({
                icon:"error",
                title: "O desconto é demasiado elevado",
                text: "Não pode dar o desconto a cima do valor total da venda"
                })
            }else{
                $("#afterDc").val("")
                var newTotal = (qtdPro * vvenda) - dcInput
                $("#afterDc").val(newTotal)
            }
        }
    }else{
        $("#afterDc").val(qtdPro * vvenda)
    }
}

// calcDesconto()

function cleanRFilds(){
    for(const rf of document.querySelectorAll(".rascunhoFilds")){
        rf.value = ""
    }
}

function cleanSellFilds() {var profildsarray = ["productQtd", "valorCustoSell", "valorvenda", "valorTotal", "selectedCode", "srestante", "nameproinput", "plproinput", "proCode", 'dcInput', 'afterDc'];profildsarray.forEach(profild => {$(`#${profild}`).val("")})};