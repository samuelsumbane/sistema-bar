
function selectAllRecs(){
    var action = "selectAllStockCards"
    $.ajax({
        url: "barAction.php",
        method: "post",
        data: {action:action},
        dataType: "json",
        async:false,
        success: function(data){
          if($('#userLogged').val() == 1){
            data.forEach(i=>{
              let proc = i.barcode ?? i.codigo
              document.querySelector('.tableContainer').innerHTML += "<div class='stockprodiv' id=''><div class='stockprodivtitle'><h3>"+i.producto+"</h3><h3 id='pstitulo'>"+i.pesoliquido+"</h3></div><div class='stockprodivMlables'><div><p>Quantidade</p><p><strong>"+i.quantidade+"</strong></p></div><div><p>Valor Custo</p><p><strong>"+i.valorcusto+"</strong></p></div><div><p>Valor Venda</p><p><strong>"+i.valorvenda+"</strong></p></div><div><p>Total pago</p><p><strong>"+i.totalpago+"</strong></p></div><div><p>Stock Restante</p><p><strong>"+i.stockrestante+"</strong></p></div><div><p>Código de barra</p><p><strong>"+proc+"</strong></p></div><div><p>Vendido</p><p><strong>"+i.vendido+"</strong></p></div></div><div class='stockbuttonsdiv'><button class='updateStockB' id="+i.codigo+">Adicionar</button><button class='delStockB' id="+i.codigo+"></button></div></div>"
            })
          }else{
            data.forEach(i=>{
              let proc = i.barcode ?? i.codigo
                document.querySelector('.tableContainer').innerHTML += "<div class='stockprodiv' id=''><div class='stockprodivtitle'><h3>"+i.producto+"</h3><h3 id='pstitulo'>"+i.pesoliquido+"</h3></div><div class='stockprodivMlables'><div><p>Quantidade</p><p><strong>"+i.quantidade+"</strong></p></div><div><p>Valor Custo</p><p><strong>"+i.valorcusto+"</strong></p></div><div><p>Valor Venda</p><p><strong>"+i.valorvenda+"</strong></p></div><div><p>Total pago</p><p><strong>"+i.totalpago+"</strong></p></div><div><p>Stock Restante</p><p><strong>"+i.stockrestante+"</strong></p></div><div><p>Código de barra</p><p><strong>"+proc+"</strong></p></div><div><p>Vendido</p><p><strong>"+i.vendido+"</strong></p></div></div><div class='stockbuttonsdiv'><button class='updateStockB' id="+i.codigo+">Adicionar</button><button class='delStockB' id="+i.codigo+"></button></div></div>"
            })
          }
        }
    })

}

selectAllRecs()

function toggleCB(){
    clearSearch = document.querySelector('#clearSearcCard')
    var list = clearSearch.classList
    list.toggle('showClearButton')
}

const searchValueInput = document.querySelector('#searchStock')
  searchValueInput.addEventListener('keyup', function(){
    var searchValue = $('#searchStock').val()
    if(searchValue != ""){
      var action = 'filterStock';
      $.ajax({
        url: 'barAction.php',
        method: "POST",
        data: { searchValue: searchValue, action: action },
        dataType: "json",
        success:function(data){
          document.querySelector('.tableContainer').innerHTML = ""
          data.forEach(i=>{
            document.querySelector('.tableContainer').innerHTML += "<div class='stockprodiv' id=''><div class='stockprodivtitle'><h3>"+i.producto+"</h3><h3 id='pstitulo'>"+i.pesoliquido+"</h3></div><div class='stockprodivMlables'><div><p>Quantidade</p><p><strong>"+i.quantidade+"</strong></p></div><div><p>Valor Custo</p><p><strong>"+i.valorcusto+"</strong></p></div><div><p>Valor Venda</p><p><strong>"+i.valorvenda+"</strong></p></div><div><p>Total pago</p><p><strong>"+i.totalpago+"</strong></p></div><div><p>Stock Restante</p><p><strong>"+i.stockrestante+"</strong></p></div><div><p>Código de barra</p><p><strong>"+i.barcode+"</strong></p></div><div><p>Vendido</p><p><strong>"+i.vendido+"</strong></p></div></div><div class='stockbuttonsdiv'><button class='updateStockB' id="+i.codigo+">Adicionar</button><button class='delStockB' id="+i.codigo+"></button></div></div>"
          })
        }, error: function(){
          alert('Houve um erro desconhecido')
        }
      })
      var clearSearch = document.querySelector('#clearSearcCard')
      clearSearch.classList.add('showClearButton')
    //   toggleCB()
    }else{
      document.querySelector('.tableContainer').innerHTML = "";
        selectAllRecs();
        toggleCB()
    } 
  })

  $('#clearSearcCard').click(()=>{
    document.querySelector('.tableContainer').innerHTML = "";
    $('#searchStock').val("");
    selectAllRecs()
    toggleCB()
  })

    $('.tableContainer').on('click', ".updateStockB", function(){
    var stockCode = $(this).attr('id');
    var action = 'getStock';
    $("#action").val("updateStock")
    $.ajax({
        url: 'barAction.php',
        method: "POST",
        data: { stockCode: stockCode, action: action },
        dataType: "json",
        success: function (data) {
        $("#bg-modal").css("top", "0");

        $('#proNameStock').val(data.producto);
        $('#pesoliquidoprostock').val(data.pesoliquido);
        $('#vCusto').val(data.valorcusto);
        $('#vVenda').val(data.valorvenda);
        $('#action').val('updateStock');
        $('#stockCode').val(data.codigo);
        $("#barCodeInput").val(data.barcode)
        $('#addStockPro').val('Actualizar Stock');
        },
        error: function () {
        alert("Houve um erro desconhecido")
        }
    })
})

$('.tableContainer').on('click', '.delStockB', function(){
  // alert('ops')
  swal({
    title: "Tem certeza que deseja apagar o stock?",
    text: "Essa acção não pode ser revertida!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
      var action = 'delStock';
      var stockCode = $(this).attr('id');
      $.ajax({
        url: "barAction.php",
        method: "POST",
        data:{stockCode:stockCode, action:action},
        success:function(){
          window.location = "stock.php"
        }
      });
    }
  });

})