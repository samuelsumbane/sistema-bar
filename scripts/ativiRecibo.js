"use strict";

let inicialdate = document.querySelector("#dateinicial").value;
let finaldate = document.querySelector("#datefinal").value;
let horainicial = document.querySelector("#horainicial").value;
let horafinal = document.querySelector("#horafinal").value;
let registrosPorPagina = 10; // Número de registros a serem carregados a cada vez
let intervaloDeTempo = 1000; // Intervalo de tempo em milissegundos entre os carregamentos
let indiceInicial = 0; // Índice inicial para carregamento dos registros
let totalRegistros = 0; // Armazena o total de registros disponíveis

let totaldeentrada = 0; let totaldesaida = 0       


function exibirTotais() {
    $.ajax({
        url: 'selectActivVtotais.php',
        method: "POST",
        data: { inicialdate: inicialdate, finaldate: finaldate, horainicial:horainicial, horafinal:horafinal, acao:"valorestotais"},
        dataType: "json",
        success: function (data) {
            // console.log(data[0])
            let vendavalue = 0
            let stockvalue = 0

            if(data.length > 0){
                if(data[0]['acao'] == "Stock"){
                    if(data[1]){
                        if(data[1]['acao'] == "Venda"){
                            stockvalue = data[0]['amount']
                            vendavalue = data[1]['amount'] 
                        }  
                    }else{
                        vendavalue = 0.00
                        stockvalue = data[0]['amount']
                    }
                    
                }else{
                    vendavalue = data[0]['amount']
                    stockvalue = 0.00
                }
            }else{
                stockvalue = 0.00
                vendavalue = 0.00
            }

           
           document.querySelector("#recdiv").innerHTML += `<p style="padding-left:8px">Valor total de vendas: &nbsp <strong> ${parseFloat(vendavalue).toFixed(2)} </strong> MT</p>
            <p style="padding-left:8px">Valor total de stock recebido: &nbsp &nbsp &nbsp <strong> ${parseFloat(stockvalue).toFixed(2)} </strong> MT</p>`;  
        },
        error: function () {
            alert("Erro inesperado, por favor atualize a página. Se o erro continuar, contate o gestor/programador.");
        }
    });
    // valorestotais
  
}

// Função para carregar registros e retornar uma Promessa
function carregarRegistros() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: 'selectActivitiesRows.php',
            method: "POST",
            data: { inicialdate: inicialdate, finaldate: finaldate, horainicial:horainicial, horafinal:horafinal, acao: "selectactivities"},
            dataType: "json",
            success: function (data) {
                resolve(data);
            },
            error: function () {
                reject("Erro inesperado, por favor atualize a página. Se o erro continuar, contate o gestor/programador.");
            }
        });
    });
}

// Chama a função inicialmente para obter o total de registros e carregar os primeiros registros
carregarRegistros().then(function (data) {
    totalRegistros = data.length;
    // Chama a função para carregar os primeiros registros
    carregarMaisRegistros(data);
    // Se todos os registros já foram carregados, exiba os totais
    if (indiceInicial >= totalRegistros) {
        exibirTotais();
        clearInterval(intervalo); // Pare o intervalo quando todos os registros forem carregados
    }
}).catch(function (error) {
    alert(error);
});

// Agenda o carregamento gradual com base no intervalo de tempo
let action = "selectactivities";
let intervalo = setInterval(function () {
    carregarRegistros().then(function (data) {
        // Chame a função para carregar mais registros
        carregarMaisRegistros(data);
        // Se todos os registros já foram carregados, exiba os totais e pare o intervalo
        if (indiceInicial >= totalRegistros) {
            exibirTotais();
            clearInterval(intervalo);
        }
    }).catch(function (error) {
        alert(error);
    });
}, intervaloDeTempo);

$.ajax({
    url: 'selectActivitiesRows.php',
    method: "POST",
    data: { inicialdate: inicialdate, finaldate: finaldate, horainicial:horainicial, horafinal:horafinal, acao:"selectactivitiesandqtd" },
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


// ... (código posterior)




function carregarMaisRegistros(data) {
    if (data && Array.isArray(data)) {
        // Se não houver mais dados, pare o intervalo
        if (indiceInicial >= totalRegistros) {
            clearInterval(intervalo);
            return;
        }
        for (let i = indiceInicial; i < indiceInicial + registrosPorPagina; i++) {
            // Certifique-se de que há dados suficientes para carregar
            if (data[i]) {
                //
                // if(data[i]["totalpago"] != "-"){
                //     if(data[i]["accao"] == "Venda"){
                //         totaldeentrada += parseFloat(parseFloat(data[i]["totalpago"]).toFixed(2))
                //     }else if(data[i]["accao"] == "Stock"){
                //         totaldesaida += parseFloat(parseFloat(data[i]["totalpago"]).toFixed(2))
                //     }  
                // }

                document.querySelector("#tbodyActivitiesList").innerHTML += `<tr>  <td>${data[i]["accao"]}</td>  <td>${data[i]["producto"]}</td> <td>${data[i]["pesoliquido"]}</td> <td>${data[i]["quantidade"]}</td> <td>${data[i]["totalpago"]}</td> <td>${data[i]["dia"]}</td> <td>${data[i]["hora"]}</td>    </tr>`;
            }
        }
        // Atualize o índice inicial para o próximo conjunto de registros
        indiceInicial += registrosPorPagina;
        //
    }
}

// function exibirTotais() {
//     document.querySelector("#recdiv").innerHTML += ` <p style="padding-left:8px">Valor total de vendas: &nbsp <strong> ${parseFloat(totaldeentrada).toFixed(2)} </strong> MT</p>
//     <p style="padding-left:8px">Valor total de stock recebido: &nbsp &nbsp &nbsp <strong> ${parseFloat(totaldesaida).toFixed(2)} </strong> MT</p> `
// }

// // Chame a função inicialmente para obter o total de registros e carregar os primeiros registros
// $.ajax({
//     url: 'selectActivitiesRows.php',
//     method: "POST",
//     data: { inicialdate: inicialdate, finaldate: finaldate, acao:"selectactivities" },
//     dataType: "json",
//     success: function (data) {
//         totalRegistros = data.length;
//         // Chame a função para carregar os primeiros registros
//         carregarMaisRegistros(data);
//         if (indiceInicial >= totalRegistros) {
//             exibirTotais();
//             clearInterval(intervalo);
//         }

//     }, error: function () {
//         alert("Erro inesperado, por favor actualize a pagina. Se o esse erro continuar contacte o gestor/programador.");
//     }
// });

// // Agende o carregamento gradual com base no intervalo de tempo
// let action = "selectactivities"
// let intervalo = setInterval(function() {
//     $.ajax({
//         url: 'selectActivitiesRows.php',
//         method: "POST",
//         data: { inicialdate: inicialdate, finaldate: finaldate, acao:action},
//         dataType: "json",
//         success: function (data) {
//             // Chame a função para carregar mais registros
//             carregarMaisRegistros(data);
//             if (indiceInicial >= totalRegistros) {
//                 exibirTotais();
//                 clearInterval(intervalo);
//             }
//         }, error: function () {
//             alert("Erro inesperado, por favor actualize a pagina. Se o esse erro continuar contacte o gestor/programador.");
//         }
//     });
// }, intervaloDeTempo);

// //
// $.ajax({
//     url: 'selectActivitiesRows.php',
//     method: "POST",
//     data: { inicialdate: inicialdate, finaldate: finaldate, acao:"selectactivitiesandqtd" },
//     dataType: "json",
//     success: function (data) {
//         let proandqtd = data.filter(e=>e.accao == "Venda" || e.accao == "Stock");
//         let proandqtdlen = proandqtd.length

//         for(let i=0;i<proandqtdlen;i++){
//             document.querySelector("#tbodyproandqtd").innerHTML += `<tr style="text-align:center"> <td>${proandqtd[i]["proname"]}</td> <td>${proandqtd[i]["qtd"]}</td> <td>${proandqtd[i]["amount"]}</td>  </tr>`
//         }

//     }, error: function () {
//         alert("Erro inesperado, por favor actualize a pagina. Se o esse erro continuar contacte o gestor/programador.");
//     }
// });
