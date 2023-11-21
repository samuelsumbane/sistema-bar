$(document).ready(function(){
  var table = $('#tabela').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':'../src/selectUser.php'
      },
      'columns': [
        { data: 'nome' },
        { data: 'user' },
        { data: 'nivel' },
        { data: 'imagem' },
        { data: 'deletar'}
      ], 
      "oLanguage": {
        "sProcessing":   "Processando...",
        "sLengthMenu":   "Mostrar _MENU_ registros",
        "sZeroRecords":  "Não foram encontrados resultados",
        "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
        "sInfoFiltered": "",
        "sInfoPostFix":  "",
        "sSearch":       "Pesquisar:",
        "sUrl":          "",
        "oPaginate": {
            "sFirst":    "Primeiro",
            "sPrevious": "Anterior",
            "sNext":     "Seguinte",
            "sLast":     "Último"
        }
    }
  });

  function controlForm(textpass, textlevel, value){
    document.getElementById('passerror').innerHTML = textpass;
    if(value == 0){
      $('#submeter').attr('disabled', 'disabled')
    }else{
      $('#submeter').attr('disabled', false)
    }
  }



  $('#nUser').change(()=>{var admin = document.querySelector('#admin');if(admin.checked == true){admin.checked = false}});$('#admin').change(()=>{var nUser = document.querySelector('#nUser');if (nUser.checked == true){nUser.checked = false}});

  (function disablebuttons(){
    var nomeuser = $("#nomeuser").val();
    var username = $("#username").val();
    var password = $("#password").val();
    var confirmpass = $('#confirmPassword').val()
    var passlength = $("#password").val().length;

    if(nomeuser == "" || username == "" || password == "" || confirmpass == "" ){
      controlForm('', '', 0)
    }else{
      if(passlength >= 6 && password == confirmpass ){
            controlForm('', '', 1)
      }else if(passlength < 6){
        controlForm("A senha deve ter no mínimo 6 caracteres", '', 0);
      }else if(password != confirmpass){
        controlForm('As senhas não correspondem', '', 0);
      }
    }
    setTimeout(disablebuttons, 850);
  })()


  $("#adduser").click(()=>{
    var bgModal = document.querySelector(".bg-modal");
    bgModal.classList.remove("hideModal");
      $("#bg-modal").css("top", "0");
      document.getElementById("modaltitle").innerHTML = "Adicionar usuário ";
      $("#userform")[0].reset();
      $('#action').val("addUser");
      $('#submeter').val('Salvar');
  })

  $("#fecharModal").click(()=>{$("#bg-modal").css("top", "-100%");})
  $("#tabela").on("click", ".editarButton", function(){
      var userid = $(this).attr("id");
      var action = 'getUser';
      $.ajax({
        url:'userAction.php',
        method:"POST",
        data:{userid:userid, action:action},
        dataType:"json",
        success:function(data){
          $("#bg-modal").css("top", "0");
          document.getElementById("modaltitle").innerHTML = "Editar usuário";
          $('#nomeuser').val(data.nome);
          $('#username').val(data.usuario);
          $('#password').val(data.senha);
          $('#nivelusuario').val(data.nivel);				
          $('#action').val('updateUser');
          $('#userid').val(data.id);
          $('#submeter').val('Actualizar');
        },
        error: function(){
          alert("erro")
        }
      })
  })

  $("#tabela").on('click', ".deleteButton", function(){
      swal({
        title: "Tem certeza?",
        text: "Essa acção não pode ser revertida!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
          var userid = $(this).attr("id");
          var action = 'delUser';
          $.ajax({
            url: "userAction.php",
            method: "POST",
            data:{userid:userid, action:action},
            success:function(){
              table.ajax.reload();
            }
          })
        }
      });
   });

   const userEdaded = ()=>{
     $('#userform')[0].reset();
      $("#bg-modal").css("top", "-100%");
      $('#submeter').attr('disabled', false);
      table.ajax.reload();
   }

   $('#bg-modal').on('submit', '#userform', function(event){
      event.preventDefault();
      $('#submeter').attr('disabled', 'disabled');

      $.ajax({
          url: "userAction.php",
          method: "POST",
          data: new FormData(this),
          contentType:false,
          processData:false,
          success: function(data){
            if(data == 1){
              $("#bg-modal").css("top", "-100%");
              $('#userform')[0].reset()
              swal({
                icon: 'error',
                title: "Falha no cadastro do novo usuário",
                text: "O usuário já existe"
              })
            }else if(data == 200){
             userEdaded()
            }else if(data == 12){
                swal({
                icon: "error",
                title: "Falha ao carregar o arquivo",
                text: "Esse tipo de arquivo não pode ser carregado."
                })
            }else{
              userEdaded()
            }
              
          }, error: function(){
            alert("Houve um erro desconhecido")
          }
      })
    });
  

});