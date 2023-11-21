<?php
// session_start();
include "menu.php";
require_once('classCrud.php');
require_once "conexao.php";
require_once 'funcoes.php';


$p = new CrudAll;
$func = new Funcoes;
session_start();
ob_start();


//
$data = date('d/m/Y');
$hora = date('H:i');


?>

<!DOCTYPE html>
<html lang="pt">
<head>

    <title>Stock - Cande's Bar</title>
    <link rel="stylesheet" href="../styles/dotFlashing.css">

</head>


<body onload="loading()">
    <div id="flashingModal">
        <div class="dotsdiv">
            <div class="snippet" data-title="dot-flashing">
                <div class="stage">
                    <div class="dot-flashing"></div>
                </div>
            </div>
        </div>

    </div>
 

    <div class="rightside">
    <!-- <div class="divshadow"> -->

        <div class="princRightContainer" id="centerContainer">
            <div class="topPrincContainer">
                <div class="titleContainer">
                    <h3>Stock</h3>
                    <form method="POST" id="searcCardDiv">
                        <input type="text" name="searchStock" id="searchStock" placeholder="Pesquisar producto..." >
                        <button type="button" class="" id="clearSearcCard">X</button>
                    </form>
                </div>
                <div class="addButtonDivBar">
                    <!-- <div class="dshadow"> -->
                    
                    <?php if($_SESSION['nivel'] == 1){?><button style="font-size:1.13vw"  id="addStockB">+ stock</button><?php }?>

                    <!-- </div> -->
                    <!-- <a href="produtos.php"><button style="font-size:1.13vw" class="firstbtn">Productos</button></a> -->
                    <a href="pdv"><button style="font-size:1.13vw" class="firstbtn" id="faturaButton">Vendas</button></a>
                    <a href="promo"><button style="font-size:1.13vw" class="firstbtn">Promoções</button></a>
                    <a href="remessa"><button style="font-size:1.13vw" class="firstbtn">G. Remessa</button></a>
                </div>
            </div>

            <div class="tableContainer">
                <input type="hidden" name="userLogged" id="userLogged" value="<?= $_SESSION['nivel'] ?>">
            </div>
         </div>
    </div>
    </div> <!--close div shadow -->

    <div class="bg-modal" id="bg-modal">
        <div class="modalContainerSell" >
            <div class="sellContent" >

                <form method="post" id="stockForm">
                    <div id="leftPartStock">
                        <div id="leftPartTop">
                            <label for="">Producto por stockar</label>
                            <input type="text" name="proNameStock" id="proNameStock" >
                        </div>
                        <div id="leftPartCenter" style="height:40%">
                            <div id="codeAndQtd">
                                <div id="valorCustoSellDiv">
                                    <label for="">Peso Liquido</label>
                                    <input type="text" name="pesoliquidoprostock" id="pesoliquidoprostock" placeholder="Em ml">
                                </div>
                                <div id="productQtdDivStock">
                                    <label for="">Quantidade</label>
                                    <input type="number" name="productQtdStock" id="productQtdStock">
                                </div>
                            </div>

                            <div id="vCustoAndvVenda">
                                <div id="vCustoUniDiv">
                                    <label for="">Valor Custo</label>
                                    <input type="number" name="vCusto" id="vCusto" >
                                </div>
                                <div id="vVendaUniDiv">
                                    <label for="">Valor Venda</label>
                                    <input type="number" name="vVenda" id="vVenda" >
                                </div>
                            </div>
                            <!-- <div id="barCodeDiv">
                                <label for="">Código de barra</label>
                                <input type="number" name="barCodeInput" id="barCodeInput">
                            </div> -->
                            <div style="display:flex;">
                                <label style="color:deepskyblue;margin-top:1%">Digitar código de barras</label> &nbsp &nbsp &nbsp
                                <input type="checkbox" name="showhidebarcodediv" id="showhidebarcodediv">
                            </div>
                            
                            <div id="barCodeDivstock" class="hideBarcodeDivstock">
                                <label>Digite o código de barras</label>
                                <input type="number" name="barcodeInput" id="barcodeInput">
                            </div>
                        </div>
                        
                        <div id="leftPartBottom">
                                <div id="valorTotalStockDiv">
                                    <label for="">Valor Total</label><br>
                                    <input type="number" name="valorTotal" id="valorTotal">
                                </div>

                            <input type="hidden" name="stockCode" id="stockCode">
                            <input type="hidden" name="action" id="action">
                            <input type="hidden" name="usernamelogged" id="usernamelogged" value="<?= $_SESSION["nome"] ?>">
                            <!-- <button type="button" id="addStockPro"></button> -->
                            <input type="button" value="" id="addStockPro">
                        </div>
                    </div>
                    <div id="rightPartStock">
                        <div id="mainRightPartStockDiv">
                            <div id="sellProTable">
                                <table id="produtosListados">
                                    <thead>
                                        <td width="13%">Pro</td>
                                        <td width="10%">PL</td>
                                        <td width="10%">Qtd</td>
                                        <td width="10%">V. Custo</td>
                                        <td width="10%">V. Venda</td>
                                        <td width="12%">T. Pago</td>
                                        <td width="20%">c. Barra</td>
                                        <td width="15%"></td>
                                        <td width="15%"></td>
                                    </thead>
                                    <tbody id="recProListados"></tbody>
                                </table>
                            </div>
                            <div id="sellControl">
                                <div id="totalPedidoDiv">
                                    <label for="">TOTAL PAGO</label>
                                    <input type="number" name="totalPagoStock" id="totalPagoStock">
                                </div>
                                <div id="sellButtonsControl">
                                    <button type="submit" id="finishPurchase">Finalizar</button>
                                    <button type="button" id="cancelPurchase">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../scripts/jquery-3.3.1.js"></script>
    <script src="../scripts/sweetalert.min.js"></script>
    <script src="../scripts/jquery.dataTables.min.js"></script>
    <script src="../scripts/script.js"></script>
    <script src="../scripts/crudStock.js"></script>
    <script src="../scripts/selectStock.js"></script>

</body>
</html>
