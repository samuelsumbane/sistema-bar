var vDateCharts = document.getElementById("vDateCharts");function changeClassLists(element, value1, value2){element.classList.remove(value1);element.classList.add(value2)};


function selectYears(){
    return new Promise((resolve) =>{
        var action = "selectSells";$.ajax({
            url: "barAction.php",
            method: "POST",
            data: {action:action},
            dataType: "json",
            success: function(data){
                for(let a = 0;a < data.length;a++){
                    var y = data[a]["ano"];
                    var year = `${y}`;
                    var allY = [year];
                    $("#yearSells").select2({data: allY})
                }
            }, error: function(){alert("Um erro inesperado!")}});
                
            $("#yearSells").change(()=>{var yearComb = $("#yearSells").val();if(yearComb != ""){var action = "selectSellsByY";
            var value = yearComb;
            $.ajax({url: "barAction.php",
            method: "POST",
            data: {value:value,action:action},
            dataType: "json",
            success: function(data){
                $("#monthSells").select2().empty();
     
                for(let item = 0;item < data.length;item++){
                    var i = data[item]["mes"];
                    var month = `${i}`;
                    var all = [month];
                    $("#monthSells").select2({ data: all });
                    
                    changeClassLists(vDateCharts, 'hiddenButton', 'shownButton')
                    }
                }, error: function(){alert("Um erro inesperado!")}})}else{changeClassLists(vDateCharts, 'shownButton', 'hiddenButton');$("#monthSells").select2().empty();
                    }
                })

            resolve()
    })
}

// selectYearsandMonths()
async function execAboveFunc(){
    await selectYears()
}

execAboveFunc();

function selectMonths(){
    return new Promise((resolve) =>{
        var action = "selectMonths";$.ajax({
            url: "barAction.php",
            method: "POST",
            data: {action:action},
            dataType: "json",
            success: function(data){

                for(let a = 0;a < data.length;a++){
                    var i = data[a]['mes'];
                    var month = `${i}`;
                    var allM = [month];
                    $("#monthSells").select2({ data: allM });
                }
            }, error: function(){alert("Um erro inesperado!")}});
                
        resolve()
    })
}

selectMonths()

const userpage = document.querySelector(".userDivPhoto");userpage.addEventListener("click", ()=>{window.location = "../src/userPage"});
const updateDateTime = ()=>{
    var novadata = new Date();var dia = ("0" + novadata.getDate()).slice(-2);var mesf = novadata.getMonth() + 1;var mesC = ("0" + mesf).slice(-2);var ano = novadata.getFullYear();var newFullDate = `${dia}/${mesC}/${ano}`;var hour = ("0"+ novadata.getHours()).slice(-2);var min = ("0" + novadata.getMinutes()).slice(-2);var sec = ("0" + novadata.getSeconds()).slice(-2);document.getElementById("timeH").textContent = `${hour}:${min}:${sec}`;document.getElementById("dateH").textContent = `${newFullDate}`;setTimeout(updateDateTime, 1000)
}

updateDateTime()
