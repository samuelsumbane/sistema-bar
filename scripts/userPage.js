var showHideUserPhoto = document.getElementById("showHideUserPhoto")

var showHideUserPass = document.getElementById("showHideUserPass")

showHideUserPass.addEventListener('click', function(){
    document.querySelector("#userPassDiv").classList.toggle("hideUserPass")
})

showHideUserPhoto.addEventListener('click', function(){
    document.querySelector('#userUpPhotoDiv').classList.toggle("hideUserUpPhoto")
})


function controlForm(textpass, textlevel, value){
    document.querySelector('.passerror').innerHTML = textpass;
    if(value == 0){
      $('#submeter').attr('disabled', 'disabled')
    }else{
      $('#submeter').attr('disabled', false)
    }
  }

showHideUserPass.addEventListener("click", ()=>{
    if(showHideUserPass.checked == true){
        var passInputArr = ["actualPassword", "password", "confirmPassword"]
        passInputArr.forEach(a =>{
            $(`#${a}`).val("") 
        })
    }
});

(function verifyUserProForm(){
    if(showHideUserPass.checked == false){
        if($("#nomeuser").val() == "" || $("#username").val() == ""){
            $("#submeter").attr("disabled", true)
        }else{
            $("#submeter").attr("disabled", false)            
        }
    }else{
        if($("#nomeuser").val() == "" || $("#username").val() == "" || $("#actualPassword").val() == "" || $("#password").val() == "" || $("#confirmPassword").val() == ""){
            controlForm("", "", 0)
        }else{
            var password = $("#password").val();
            var confirmpass = $('#confirmPassword').val()
            var passlength = password.length;

            var actualPassword = $("#actualPassword").val()
            var passFBank = $("#passFBank").val()

            $.ajax({
                url: "users/verifyPass.php",
                method: "POST",
                data: {actualPassword, passFBank},
                dataType: "json",
                success: function(data){
                    if(data == "200"){
                        $(".actualpassError").text("")
                        if(passlength > 6 && password == confirmpass ){
                            controlForm('', '', 1)
                        }else if(passlength < 6){
                            controlForm("A senha deve ter no mínimo 6 caracteres", '', 0);
                        }else if(password != confirmpass){
                            controlForm('As senhas não correspondem', '', 0);
                        }else if(password == confirmpass){
                            $(".passerror").text("")
                            $(".actualpassError").text("")
                        }
 
                    }else{
                        $(".actualpassError").text("A senha digitada não corresponde a senha actual")
                    }
                }, error: function(){
                    alert("Houve um erro desconhecido")
                }
            })

            $("#submeter").attr("disabled", false)
        }
    }

    setTimeout(verifyUserProForm, 1000)
})();


$(document).on("submit", "#userProForm", function(e){
    e.preventDefault()
  
    if(showHideUserPass.checked == true){
        $("#passChecked").val("true")
    }else{
        $("#passChecked").val("false")
    }
    var formData = $(this).serialize()


    $.ajax({
        url: "userAction.php",
        method: "POST",
        data: formData,
        success: function(data){
            swal({
                title: "Actualização feita com sucesso!",
                text: "As mudanças se manifestaram na proxíma inicialização",
                icon: "success",
                button: "Fechar",
            });
            var passInputArr = ["actualPassword", "password", "confirmPassword"]
            passInputArr.forEach(a =>{
                $(`#${a}`).val("") 
            })
        }, error: function(){
            alert("Houve um erro desconhecido")
        }
    })
})