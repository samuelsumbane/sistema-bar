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

if((!isset($_SESSION['id'])) && (!$_SESSION['nome'])){
    header('Location: ../index.php');
}
//
$data = date('d/m/Y');


?> 
<!DOCTYPE html>
<html lang="pt">
<head>
    <title>pdv - Cande's bar</title>
</head>
<script>document.querySelector('.payment').setAttribute('id', 'activo')</script>


<body>
 
    <div class="rightside">

    <div class="divshadow">

        <div class="princRightContainer" id="centerContainer">
            <div class="topPrincContainer" >
                <div class="titleContainer">
                    <h3>Vendas</h3>
                </div>
                <div class="addButtonDivBar">
                    <!-- <div class="dshadow"> -->
                    <button style="font-size:1.13vw"  id="sellPageButton">Vender</button>
                    <!-- <a href="produtos.php"><button style="font-size:1.13vw" class="firstbtn">Productos</button></a> -->
                    <?php if($_SESSION['nivel'] == 1){?> <a href="stock.php"><button style="font-size:1.13vw" class="firstbtn">Stock</button></a> <?php }?>
                    <!-- </div> -->
                    <!-- <div class="ol"> -->
                    <!-- <button class="secondbtn" id="secondbutton">Pagar</button> -->
                    <a href="promo"><button style="font-size:1.13vw" class="firstbtn">Promoções</button></a>
                    <a href="remessa"><button style="font-size:1.13vw" class="firstbtn">G. Remessa</button></a>
                </div>
            </div>

            <div class="tableContainer" style="display:flex">
            <div class="tableContent">
                <?php 
                if($_SESSION['nivel'] == 1){
                    ?>
                        <table style="width:100%" id="tabelaVenda" class="display nowrap">
                            <thead>
                                <tr>    
                                    <th>Produto</th>
                                    <th>P. Liquido</th>
                                    <th>Qtd</th>
                                    <th>V. Custo</th>
                                    <th>V. Unico</th>
                                    <th>V. Total</th>
                                    <th>Desconto</th>
                                    <th>Lucro</th>
                                    <th>Mês</th>
                                    <th>Ano</th>
                                </tr>
                            </thead>
                        </table>
                    <?php
                }else{
                    ?>
                    <table style="width:100%" id="tabelaVendaUser" class="display nowrap">
                        <thead>
                            <tr>    
                                <th>Produto</th>
                                <th>Peso Liquido</th>
                                <th>Quantidade</th>
                                <th>Valor Total</th>
                                <th>Mês</th>
                                <th>Ano</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                    <?php
                }
                ?>
                
                </div>
                </div>
            </div>
        </div>
    </div> <!--close div shadow -->

    <div class="bg-modal" id="bg-modal">
        <div class="modalContainerSell" >
            <div class="sellContent" >
                <form method="post" id="sellForm">
                    <div id="leftPart">
                        <div id="leftPartTop">
   
                            <label for="">Producto por vender</label>

                            <select name="" id="sellProComboBox" style="width:100%;">
                                <option>Selecione Producto</option>
                            </select>

                            <!-- <input type="text" name="barcodeInput" id="barcodeInput"> -->
                            <input type="hidden" name="nGarafas" id="nGarafas">
                            <input type="hidden" name="vPromo" id="vPromo">
                            

                            <input type="hidden" name="selectedCode" id="selectedCode">
                            <input type="hidden" name="srestante" id="srestante">
                      

                            <p id="qtddpro" style="color:deepskyblue"></p>

                        
                        </div>
                        <div id="leftPartCenter" style="">
                            <div id="proNamesDiv">
                                <div id="proNameDivSon">
                                    <label>Nome</label>
                                    <input type="text" name="nameproinput" id="nameproinput" readonly>
                                    
                                </div>
                                <div id="proPlDiv">

                                    <label>P. Liquido</label>
                                    <input type="text" name="plproinput" id="plproinput">
                                </div>
                            </div>
                            <div id="codeAndQtd" style="height:30%">
        
                                <div id="productQtdDiv">
                                    <label for="">Quantidade</label>
                                    <input type="number" name="productQtd" id="productQtd">
                                    <input type="hidden" name="valorUnico" id="valorUnico" readonly>
                                    <input type="hidden" name="valorvenda" id="valorvenda">
                                    <input type="hidden" name="valorCustoSell" id="valorCustoSell" readonly>
                                    
                                </div>
                                <div id="valorTotalDiv">
                                    <label for="">Valor Total</label>
                                    <input type="number" name="valorTotal" id="valorTotal" readonly>
                                </div>
                            </div>

                            <div id="leftPartCenterFooter">
                                <?php if(($_SESSION['nivel'] == 1)){?><div id="dcLabelDiv"><label>Descontar</label><input type="checkbox" name="checkDc" id="checkDc"></div> <?php }?>  
                              
                                <div  class="hideDcInwputDiv" id="dcInputDiv">
                                    <div id="dcLeftSon">
                                        <label>Valor a descontar</label>
                                        <input type="number" class="dcfI" name="dcInput" id="dcInput">
                                    </div>

                                    <div id="dcRightSon">
                                        <label>N. V. Total</label>
                                        <input type="number" class="dcfI" name="afterDc" id="afterDc" readonly>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                        <div id="leftPartBottom" style="margin-top:15%">
                            <input type="hidden" name="action" id="action">
                            <input type="hidden" name="proCode" id="proCode">
                            
                            <input type="hidden" name="usernamelogged" id="usernamelogged" value="<?= $_SESSION["nome"] ?>">
                            <button type="button" id="addSellPro" disabled>Adicionar Producto</button>
                            
                        </div>
                    </div>
                    <div id="rightPart">
                        <div id="mainRightPartDiv">
                            <div id="sellProTable">
                                <table id="produtosListados" style="border-collapse:collapse;">
                                    <thead style="color:white">
                                        <!-- <th width="15%">Cod.</th> -->
                                        <th width=20%>Pro</th>
                                        <th width=15%>Pl</th>
                                        <th width=15%>Qtd</th>
                                        <th width=15%>Preço</th>
                                        <th width=15%>Desc.</th>
                                        <th width=10%></th>
                                        <th width=10%></th>
                                    </thead>
                                    <tbody id="recProListados"></tbody>
                                </table>
                            </div>
                            <div id="sellControl">
                                <div id="totalPedidoDiv">
                                    <label for="">TOTAL DO PEDIDO</label>
                                    <input type="number" name="totalPedido" id="totalPedido">
                                </div>

                                <div id="recebidoDivAndTrocoDiv">
                                    <div id="recebidoDiv">
                                        <label for="">Valor recebido</label>
                                        <input type="number" name="vRecebido" id="vRecebido">
                                    </div>
                                    <div id="trocoDiv">
                                        <h3 id="trocoText"></h3>
                                    </div>
                                </div>
                                <div id="sellButtonsControl">
                                    <button type="submit" id="finishPurchase" disabled>Finalizar</button>
                                    <button type="button" id="cancelPurchase">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <script src="../scripts/jquery-3.3.1.js"></script> -->
    <script src="../scripts/select2.min.js"></script>
    <script src="../scripts/sweetalert.min.js"></script>
    <script src="../scripts/jquery.dataTables.min.js"></script>

    <script  src="../scripts/listVendas.js"></script>
    <script src="../scripts/mainVendas.js"></script>
    <script src="../scripts/sellBarBarcode.js"></script>

    <script src="../scripts/listSellUser.js"></script>
    <script src="../scripts/script.js"></script>

</body>
</html>
