var barcode = '';
var bInput = '';
var barcodeC = 0;


document.addEventListener("keydown", function (e) {

  const textInput = String.fromCharCode(e.keyCode);
  if (e.keyCode == 13 && barcode.length > 3) {
    e.preventDefault()
    // alert('clicked')
    
    if(bInput == ""){
        bInput = barcode
        clearSellInputs()
        cleanSellFilds()

        barcodeC = 1

      if(barcode != ""){
        // codeResults(barcode, barcodeC)
        let codeStock = parseInt(barcode)
        var action = "productData"
        $("#selectedCode").val(barcode)
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
    
                    if(data[0] == false){
                        swal({ icon: "error", title: "Nenhum producto encontrado", text: "o código scaneado não foi atribuiado a nenhum producto" })
                    }else{
                        $("#bg-modal").css("top", "0")
                        if(data[1] != false){
                            $("#nGarafas").val(data[1]["nprodutos"])
                            $("#vPromo").val(data[1]["vpromo"])
                        }

                        $("#action").val("sellProducts")
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
                        let thisproCode = data[0]["codigo"]
                        $("#addSellPro").attr('disabled', false)
                    
                        document.querySelector("#qtddpro").innerHTML = `Total de productos por unidade ${srestante}`
        
                        calcProCost(barcodeC, thisproCode)
                    }
                } else {
                    swal({ icon: "error", title: "Nenhum producto encontrado", text: "o código scaneado não foi atribuiado a nenhum producto" })
                }
                }, error: function () { alert("Houve um erro desconhecido!") }
            })
        }
      }


    }else{
        if(barcode == bInput){
            barcodeC ++
            calcProCost(barcodeC,  $("#proCode").val())
            barcode = ''
        }else{
            bInput = barcode
            addRecsTable()
            barcodeC = 0
            cleanSellFilds()
        }
    }
    barcode = '';

  }else{
    barcode += textInput;
  }
});


function clearSellInputs() {
    document.querySelector("#sellProComboBox").value = "";
    document.querySelector("#qtddpro").innerHTML = "";
}
