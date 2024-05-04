

var inactivityTime = 0;
var timeout = 300000; // 5 minutos em milissegundos

function trackUserActivity() {
    // Reinicia o contador de inatividade sempre que houver uma ação do usuário
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);
    document.addEventListener('click', resetTimer);
    document.addEventListener('scroll', resetTimer);
}

function resetTimer() {
    inactivityTime = 0;
}

function checkInactivity() {
    inactivityTime += 1000; // Incrementa o contador a cada segundo
    if (inactivityTime >= timeout) {
        // Se o usuário estiver inativo por mais de 5 minutos, execute a função
        executeAfterInactivity();
        inactivityTime = 0; // Reinicia o contador após executar a função
    }
}

function executeAfterInactivity() {

    $.ajax({
        url: "sair.php",
        method: "GET",
        data: "logoutScript",
        success: function (data) {
          console.log("deu certo")
          sessionExpired()
         
        }, error: function () {
          alert("Deu erro ao terminar a sessão. Por favor entre com contacto com o gestor/programador do sistema")
        }
      })

}

window.onload = function() {
    trackUserActivity();
    setInterval(checkInactivity, 1000); // Verifica a inatividade a cada segundo
};

