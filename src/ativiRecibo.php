<?php

require_once('classCrud.php');
require_once 'conexao.php';
require_once 'funcoes.php';


session_start();
ob_start();


if((!isset($_SESSION['id'])) && (!$_SESSION['nome'])){
    header('Location: ../index.php');
}
//


$p = new CrudAll;
$func = new Funcoes;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../icones/bar_favicon.png" type="image/x-icon">

    <title>Relatório - Cande's Bar</title>

</head>

<style>
:root{--poligon:polygon(92% 0, 100% 12%, 100% 100%, 8% 100%, 0% 88%, 0 0)}
*{padding:0;margin:0}
body{display:fixed;width:100%;height:100%;}
#subbody{position:absolute;width:100%;height:100%;display:flex;flex-direction:row;row-gap:20px;background-image: linear-gradient(to right, rgb(217, 238, 248) 20%, rgba(57, 167, 201, 0.959));overflow:auto}

.mainDiv *{width:100%;}
.sunMainDiv *{font-size: 0.8rem;font-weight:bold;}

.botoesDaFatura{background:rgba(0,0,0,.2);width:75%;height:30%;margin:auto;display:flex;flex-direction:row;backdrop-filter:blur(5px);clip-path:var(--poligon)}#printFatDoc, #cancelButton{font-size:1rem;color:white;background-color:rgba(255,255,255,.2);font-weight: 100;clip-path:var(--poligon)}#printFatDoc{width:40%;height:60%;background-image: url("../icones/print.png");background-size:30px;background-repeat: no-repeat;background-position:right;margin:auto;border:none;transition:all 0.7s}#printFatDoc:hover{color:white;background-color:dodgerblue}#cancelButton{width:40%;height:60%;margin:auto;border:none;transition:all 0.7s}#cancelButton:hover{background:rgba(0,0,0,.5)}

</style>

<script>
    function printContent(el){
        var printData = document.getElementById(el);
        newWin = window.open("");
        newWin.document.write(printData.outerHTML);
        newWin.print();
        newWin.close();
    }
</script>

<body>

<div id="subbody">

    <div id="leftside" style="width:65%">

        <div class="parentMainDiv" id="parentMainDiv" style="width:570px;height:800px;background:white;margin:2% auto 0 auto;display:flex;flex-direction:column">
            
            <div id="topdiv" style="width:98%;height:10%;background:white;margin:auto;margin-top:30px;display:flex">
                <h4 id="Dados" style="padding-left:10px">Relatório</h4>
                <h4 style="margin-left:auto">Cande's Bar</h4>
            </div>

            <div id="maindiv" style="width:95%;background:white;margin:30px auto 0 auto;display:flex;flex-direction:column" >

            <input type="hidden" name="" id="dateinicial" value="<?php echo $_GET["printdateinicial"] ?>">
            <input type="hidden" name="" id="datefinal" value="<?php echo $_GET["printdatefinal"] ?>">
            <input type="hidden" name="" id="horainicial" value="<?php echo $_GET["horainicial"] ?>">
            <input type="hidden" name="" id="horafinal" value="<?php echo $_GET["horafinal"] ?>">

            <?php
                $totalsaida = 0;
                $proArray = [];
                // $dados = $p->selectActiRec($_GET["printdateinicial"], $_GET["printdatefinal"]);
            ?>
                <div class="rec" id="recdiv" style="width:98%;background:white;border:2px solid black;border-radius:0 0 5px 5px ;margin:0 auto 0 auto;">
                    <table style="width:98%;border-collapse:collapse;margin:auto;margin-top:7px">
                    <tr style="background:lightgray;">
                        <th style="width:15%">Accão</th>
                        <th style="width:20%">Producto</th>
                        <th style="width:15%">P. Liquido</th>
                        <th style="width:10%">Qtd.</th>
                        <th style="width:10%">T. Pago</th>
                        <th style="width:20%">Data</th>
                        <th style="width:10%">Hora</th>
                    </tr>
                    <tbody id="tbodyActivitiesList"></tbody>
            
                    </table>
                    <br><br>

                    <!-- tabela de producto e quantidade total -->
                    <table style="width:98%;border-collapse:collapse;margin:auto;margin-top:7px">
                        <tr style="background:lightgray;"><th>Producto</th><th>Quantidade</th> <th>Valor total</th></tr>
                        <tbody id="tbodyproandqtd"></tbody>
                    </table>

                    <br><br>

                    <!-- <p style="padding-left:8px">Valor total de vendas: &nbsp <strong><?php echo $totalentrada ?></strong> MT</p>
                    <p style="padding-left:8px">Valor total de stock recebido: &nbsp &nbsp &nbsp <strong><?php echo $totalsaida ?></strong> MT</p> -->

                </div>
            </div>
            <!-- bottom -->
            <div id="bottomdiv" style="width:95%;height:5%;background:white;margin-bottom:200%;background:white">
            <br>
                <p style="font-size:0.85rem;padding-left:6%">Impresso por <?php echo $_SESSION['nome'] ?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <?php echo date("d/m/Y") ?>  &nbsp &nbsp &nbsp <?php date_default_timezone_set('Africa/Maputo'); echo date("H:i") ?> </p>
            </div>
        </div>
    </div>

    <div id="rightside" style="width:35%;display:flex;">
            
        <div class="botoesDaFatura">
            <button type="button" name="button" id="printFatDoc" onclick="printContent('parentMainDiv')">Imprimir</button>
            <button type="button" name="button" id="cancelButton" onclick="window.location='activities'">Fechar</button>
        </div>

    </div>

    <script src="../scripts/jquery-3.3.1.js"></script>
    <script src="../scripts/ativiRecibo.js"></script>

</body>


</html>