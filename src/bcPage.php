<?php 

include "menu.php";
require('classCrud.php');

$p = new CrudAll;

session_start();
ob_start();

include_once 'conexao.php';
//
if((!isset($_SESSION['id'])) && (!$_SESSION['nome'])){
    header('Location: ../index.php');
}

if($_SESSION['nivel'] != 1){
    header('Location: dash.php');
}
?>

<!DOCTYPE html>
<html lang="pt">
<head><title>Definições - Cande's bar</title></head>

<script>
    document.querySelector('.settings').setAttribute('id', 'activo')

    function printContent(el){
        var printData = document.getElementById(el);
        newWin = window.open("");
        newWin.document.write(printData.outerHTML);
        newWin.print();
        newWin.close();
    }
</script>

<body>

    <div class="rightside">
        <div class="princRightContainerDef" id="centerContainer">
            <div class="topPrincContainer">
                <div class="titleContainer">
                    <h3 class="containerTitle">Definições</h3>
                </div>
                <div class='addButtonDiv'>
                    <a href="definicoes"><button style='font-size:1.13vw;margin:5% 0 0 44%;background:rgb(217, 238, 248);color:black'>Definições</button></a>
                </div>
            </div>

            <!-- bottom side -->
            <div class="bottomPrincContainerDef">
                <div style="width:35%;height:100%;display:flex;flex-direction: column;margin-right:3%">
                    <div id="barCodeDivDef">
                        <form method="post" id="generateBarCodeForm" style=";display:flex;flex-direction:column">
                            <div id="topCbarCode" style="">
                            <!-- <form method="POST" id="searcCardDiv"> -->
                                    <input type="text" name="searchProbc" id="searchProbc" placeholder=" Pesquisar pro ..." >
                                    <button type="button" class="" id="clearSearcCard">X</button>
                                    <!-- </form> -->
                                    <button type="button" id="sAllProbc">S. Todos</button>
                            </div>

                            <div id="mainCbarCode" style=""></div>

                            <div id="footerCbarCode">
                                <input type="submit" id="subBarCds" value="Finalizar" />
                            </div> 
                        </form>

                    </div>

                    <div id="printCleanPBc">
                        <button type="button" id="printRemessaButton" onclick="printContent('remessaPaper')">Imprimir</button>
                        <button type="button" id="clearButton">Limpar papel</button>
                    </div>

                </div>


                <div id="barCodePaperDef">
                    <div id="remessaPaper" style="height:auto">
                        <div class="parentMainDiv" id="parentMainDiv" style="width:570px;height:auto;background:white;margin:auto;display:flex;flex-direction:column;">
                                <!-- main -->
                                <div id="maindiv" style="width:95%;min-width:50px;background:white;margin:5% auto 100% auto;display:flex;flex-wrap:wrap;gap:2%" ></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    

</body>
<script src="../scripts/script.js"></script>
<script src="../scripts/defScript.js"></script>
<script src="../scripts/JsBarcode.all.min.js"></script>
<script src="../scripts/select2.min.js"></script>


</html>