const html = document.querySelector('html');
const checkbox = document.querySelector('#switch');
const hamburger = document.querySelector(".hamburger");
const addmontsbutton = document.getElementById("adicionarmes");
const divmonthview = document.getElementById("MonthsCalled");
const element = document.getElementById("centerContainer");
const leftslide = document.getElementById("leftside");
const titulo = document.getElementById('title');
const div_hamburger = document.getElementById('div-hamburger');
const slide_botoes = document.querySelector(".botoes");
const leavebutton = document.querySelector(".sair");
const botao_activo = document.getElementById('activo')
var porMetro = document.getElementById('precoMetro');
var valor_iva = document.getElementById('ivaValor');
var essuidate = document.getElementById("essuiDate");
var bgModal = document.querySelector(".bg-modal");
var paybgModal = document.querySelector(".bg-payMany");
var currentTheme = localStorage.getItem("candebarMode");
var elem = document.body;
const tlucro = document.querySelector(".hiddentlucro");


document.addEventListener('keydown', (event) => {
    var keyValue = event.key;
    if (event.altKey) {
        // Even though event.key is not 'Control' (e.g., 'a' is pressed)
        if (keyValue == "i") {
            window.location = "dash.php";
        } else if (keyValue == "c") {
            window.location = "clientes.php";
        } else if (keyValue == "u") {
            window.location = "usuarios.php";
        } else if (keyValue == "a") {
            window.location = "atividades.php";
        } else if (keyValue == "s") {
            window.location = "definicoes.php";
        }
    } else {
        // alert(`key pressed ${keyValue}`);
        return;
    }

}, false);


hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    leftslide.classList.toggle('active');
    titulo.classList.toggle('active');
    div_hamburger.classList.toggle('active');
    slide_botoes.classList.toggle('active')
    botao_activo.classList.toggle("active");
    leavebutton.classList.toggle("active");

})

if(bgModal){
    bgModal.addEventListener("click", (e) => {
        if (e.target == bgModal) {
            bgModal.classList.add("hideModal")
        }
    })
}


$('#closeNotInfo').click(()=>{
    document.querySelector('#notificationInfo').style.opacity = '0'
})


function myFunction() {
    var currentThemes = localStorage.getItem("candebarMode");
    if (currentThemes == "dark-mode") {
        html.classList.remove('dark-mode');
        localStorage.setItem('candebarMode', '');
    } else {
        html.classList.add("dark-mode");
        localStorage.setItem('candebarMode', 'dark-mode')
    }
}
html.classList.add(localStorage.getItem('candebarMode'));


function loading(){document.getElementById("flashingModal").style.display = "none";document.querySelector(".rightside").style.display = "block";}























// hamburger.forEach(n => n.addEventListener("click", () => {
//     leftbuttonstooltips.classList.remove("active");

// }))


// document.querySelectorAll('.nav-link').forEach(n => n.addEventListener("click", () => {
//     hamburger.classList.remove("active");
//     navMenu.classList.remove("active");
// }))


