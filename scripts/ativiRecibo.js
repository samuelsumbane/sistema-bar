"use strict";

let inicialdate = document.querySelector("#dateinicial").value;
let finaldate = document.querySelector("#datefinal").value;
let registrosPorPagina = 10; // Número de registros a serem carregados a cada vez
let intervaloDeTempo = 1000; // Intervalo de tempo em milissegundos entre os carregamentos
let indiceInicial = 0; // Índice inicial para carregamento dos registros
let totalRegistros = 0; // Armazena o total de registros disponíveis

function carregarMaisRegistros(data) {
    if (data && Array.isArray(data)) {
        // Se não houver mais dados, pare o intervalo
        if (indiceInicial >= totalRegistros) {
            clearInterval(intervalo);
            return;
        }
        let totaldeentrada = 0; let totaldesaida = 0       
        for (let i = indiceInicial; i < indiceInicial + registrosPorPagina; i++) {
            // Certifique-se de que há dados suficientes para carregar
            if (data[i]) {
                let accao = data[i]["accao"];
                //
                if(data[i]["totalpago"] != "-"){
                    if(data[i]["accao"] == "Venda"){
                        totaldeentrada += parseFloat(parseFloat(data[i]["totalpago"]).toFixed(2))
                    }else if(data[i]["accao"] == "Stock"){
                        totaldesaida += parseFloat(parseFloat(data[i]["totalpago"]).toFixed(2))
                    }  
                }

                document.querySelector("#tbodyActivitiesList").innerHTML += `<tr>  <td>${accao}</td>  <td>${data[i]["producto"]}</td> <td>${data[i]["pesoliquido"]}</td> <td>${data[i]["quantidade"]}</td> <td>${data[i]["totalpago"]}</td> <td>${data[i]["dia"]}</td> <td>${data[i]["hora"]}</td>    </tr>`;
            }
        }
        // Atualize o índice inicial para o próximo conjunto de registros
        indiceInicial += registrosPorPagina;
        //
        document.querySelector("#recdiv").innerHTML += ` <p style="padding-left:8px">Valor total de vendas: &nbsp <strong> ${parseFloat(totaldeentrada).toFixed(2)} </strong> MT</p>
        <p style="padding-left:8px">Valor total de stock recebido: &nbsp &nbsp &nbsp <strong> ${parseFloat(totaldesaida).toFixed(2)} </strong> MT</p> `
    }
}


// Chame a função inicialmente para obter o total de registros e carregar os primeiros registros
$.ajax({
    url: 'selectActivitiesRows.php',
    method: "POST",
    data: { inicialdate: inicialdate, finaldate: finaldate, acao:"selectactivities" },
    dataType: "json",
    success: function (data) {
        totalRegistros = data.length;
        // Chame a função para carregar os primeiros registros
        carregarMaisRegistros(data);
    }, error: function () {
        alert("Erro inesperado, por favor actualize a pagina. Se o esse erro continuar contacte o gestor/programador.");
    }
});

// Agende o carregamento gradual com base no intervalo de tempo
let action = "selectactivities"
let intervalo = setInterval(function() {
    $.ajax({
        url: 'selectActivitiesRows.php',
        method: "POST",
        data: { inicialdate: inicialdate, finaldate: finaldate, acao:action},
        dataType: "json",
        success: function (data) {
            // Chame a função para carregar mais registros
            carregarMaisRegistros(data);
            // console.log(data)
        }, error: function () {
            alert("Erro inesperado, por favor actualize a pagina. Se o esse erro continuar contacte o gestor/programador.");
        }
    });
}, intervaloDeTempo);

//
$.ajax({
    url: 'selectActivitiesRows.php',
    method: "POST",
    data: { inicialdate: inicialdate, finaldate: finaldate, acao:"selectactivitiesandqtd" },
    dataType: "json",
    success: function (data) {
        let proandqtd = data.filter(e=>e.accao == "Venda" || e.accao == "Stock");
        let proandqtdlen = proandqtd.length

        for(let i=0;i<proandqtdlen;i++){
            document.querySelector("#tbodyproandqtd").innerHTML += `<tr style="text-align:center"> <td>${proandqtd[i]["proname"]}</td> <td>${proandqtd[i]["qtd"]}</td> <td>${proandqtd[i]["amount"]}</td>  </tr>`
        }

    }, error: function () {
        alert("Erro inesperado, por favor actualize a pagina. Se o esse erro continuar contacte o gestor/programador.");
    }
});
