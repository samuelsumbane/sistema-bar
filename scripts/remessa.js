var remessaCouter = 0
$('#elemPart').on('submit', '#remessaForm', function(e){
    e.preventDefault();
    remessaCouter += 1
    var proname = $('#proname').val()
    var pl = $('#pl').val()
    var qtd = $('#qtd').val()

    if(proname == "" || pl == ""  || qtd == ""){
        swal({
            icon: "info",
            title: "Por favor, preencha todos os campos"
        })
    }else{
        $('#remessaTableBody').parent().append(`<tr class='remessaTr'><td style="text-align:center">${proname}</td><td style="text-align:center">${pl}</td><td style="text-align:center">${qtd}</td></tr>`)
        $('#remessaForm')[0].reset();   
    }

})

$('#clearButton').click(()=>{
    $(".remessaTr").remove()
})


$('#saveRemessaRecs').click(()=>{
    var remessaTr = document.querySelectorAll('.remessaTr')
    if(remessaTr.length == 0){
        swal({
            icon: 'error',
            title: 'Nenhum registro encontrado'
        })

    }else{
        var username = $('#uLname').val()
        var action = "saveremessarecs"
        var recId = $('#idrecs').val()
        
        remessaTr.forEach(tr => {
            var pro = tr.children[0].innerHTML
            var pl = tr.children[1].innerHTML
            var qtd = tr.children[2].innerHTML

            var trdata = `id=${recId}&produto=${pro}&pesoliquido=${pl}&quantidade=${qtd}&username=${username}&action=${action}`
            $.ajax({
                url: 'barAction.php',
                method: 'POST',
                data: trdata,
                // dataType: "json",
                success: function(data){
                    // console.log(data)
                    swal({
                        icon: 'info',
                        title: 'Documento salvo com sucesso!'
                    })
                    // for(const remessaTr of document.querySelectorAll('.remessaTr')){
                    //     remessaTr.remove()
                    // }
                    window.location = "remessa.php"
                   
                }, error: function(){
                    alert("Houve um erro desconhecido")
                }
            })
        })

        

    }
 
})