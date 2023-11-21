
function selectAllRecs(){
    var action = "selectAllProCards"
    $.ajax({
        url: "barAction.php",
        method: "post",
        data: {action:action},
        dataType: "json",
        async:false,
        success: function(data){
            if($('#userLogged').val() == 1){
              data.forEach(i=>{
                document.querySelector('.tableContainer').innerHTML += "<div class='proprodiv'><div class='stockprodivtitle'><h3>"+i.marca+"</h3>  <h3 id='pstitulo'>"+i.pesoLiquido+"</h3>  </div><div class='proprodivMlables'><div><p>Valor Custo</p><p><strong>"+i.valorCusto+"</strong></p></div><div><p>Valor Venda</p><p><strong>"+i.valorVenda+"</strong></p></div><div><p>C. de barra</p><p><strong>"+i.qrcode+"</strong></p></div></div><div class='probuttonsdiv'><button class='updateProB' id="+i.codigo+">Editar</button></div></div>"
                });
            }else{
              data.forEach(i=>{
                document.querySelector('.tableContainer').innerHTML += "<div class='proprodiv'><div class='stockprodivtitle'><h3>"+i.marca+"</h3>  <h3 id='pstitulo'>"+i.pesoLiquido+"</h3>  </div><div class='proprodivMlables'><div><p>Valor Custo</p><p><strong>"+i.valorCusto+"</strong></p></div><div><p>Valor Venda</p><p><strong>"+i.valorVenda+"</strong></p></div><div><p>C. de barra</p><p><strong>"+i.qrcode+"</strong></p></div></div><div class='probuttonsdiv'></div></div>"
              });
            }
            
        }
    });
}

selectAllRecs()

function toggleCB(){
    clearSearch = document.querySelector('#clearSearcCard')
    var list = clearSearch.classList
    list.toggle('showClearButton')
}

const searchValueInput = document.querySelector('#searchPro')
  searchValueInput.addEventListener('keyup', function(){
    var searchValue = $('#searchPro').val()
    if(searchValue != ""){
      var action = 'filterPro';
      $.ajax({
        url: 'barAction.php',
        method: "POST",
        data: { searchValue: searchValue, action: action },
        dataType: "json",
        success:function(data){
          document.querySelector('.tableContainer').innerHTML = ""
          data.forEach(i=>{
            document.querySelector('.tableContainer').innerHTML += "<div class='proprodiv'><div class='stockprodivtitle'><h3>"+i.marca+"</h3>  <h3 id='pstitulo'>"+i.pesoLiquido+"</h3>  </div><div class='proprodivMlables'><div><p>Valor Custo</p><p><strong>"+i.valorCusto+"</strong></p></div><div><p>Valor Venda</p><p><strong>"+i.valorVenda+"</strong></p></div><div><p>C. de barra</p><p><strong>"+i.qrcode+"</strong></p></div></div><div class='probuttonsdiv'><button class='updateProB' id="+i.codigo+">Editar</button></div></div>"
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
    $('#searchPro').val("");
    selectAllRecs()
    toggleCB()
  })

    $('.tableContainer').on('click', ".updateProB", function(){
    var proId = $(this).attr('id');
    var action = 'getPro';
    $.ajax({
        url: 'barAction.php',
        method: "POST",
        data: { proId: proId, action: action },
        dataType: "json",
        success: function (data) {
            $("#bg-modal").css("top", "0");
            document.getElementById("modaltitle").innerHTML = `${data.marca}`;
            $('#pesoLiquido').val(data.pesoLiquido);
            $('#valorCusto').val(data.valorCusto);
            $('#valorVenda').val(data.valorVenda);
            $('#action').val('updatePro');
            $('#proId').val(data.codigo);
            $('#submeter').val('Actualizar');
        },
        error: function () {
            alert("Houve um erro desconhecido")
        }
    })
})