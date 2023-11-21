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
    <title>Promoções - Cande's Bar</title>
    <script>document.querySelector('.payment').setAttribute('id', 'activo')</script>
</head>

<script>
    function printContent(el){
        var printData = document.querySelector(el);
        newWin = window.open("");
        newWin.document.write(printData.outerHTML);
        newWin.print();
        newWin.close();
    }
</script>

<body>

    <div class="rightside">

            <!-- <div class="divshadow"> -->

                <div class="princRightContainer" id="centerContainer">
                    <div class="topPrincContainer">
                        <div class="titleContainer">
                            <a href="pdv"><button style="font-size:1.13vw" class="backProPage" title="Voltar"></button></a>
                            <h3 style="margin:-35px 0 0 70px">Guia de remessa</h3>
                        </div>
                        <div class="addButtonDiv">
                            <a href="remessaDocs"><button style="font-size:1.13vw" class="firstbtn">Remessas</button></a>
                        </div>
                    </div>

                    <div class="tableContainer">
                        <input type="hidden" name="uLname" id="uLname" value="<?= $_SESSION['nome'] ?>">
                        <input type="hidden" name="uLlevel" id="uLlevel" value="<?= $_SESSION['nivel'] ?>">

                        <?php
                            $idenfier = 1;
                            $dadoscodigo = $p->selectRecord('remessarecs', 'id', $idenfier);
                            if($dadoscodigo != false){
                                $dadoscodigoId = $dadoscodigo['id'];

                                while ($dadoscodigoId == $idenfier){
                                    $idenfier++;
                                    $dadoscodigo = $p->selectRecord('remessarecs', 'id', $idenfier);
                                    if($dadoscodigo != false){
                                        $dadoscodigoId = $dadoscodigo['id'];                                    
                                    }
                                }
                                ?>
                                    <input type="hidden" name="idrecs" id="idrecs" value="<?= $idenfier ?>">
                                <?php
                            }else{
                                ?>
                                    <input type="hidden" name="idrecs" id="idrecs" value="<?= $idenfier ?>">
                                <?php
                            }
                        ?>

                        <div id="paperPart">
                            <div class="remessaPaper">
                                <div class="parentMainDiv" id="parentMainDiv" style="width:570px;height:800px;background:white;margin:auto;display:flex;flex-direction:column;">    
                                        <div id="topdiv" style="width:98%;height:10%;background:white;margin:auto;margin-top:2%;display:flex">
                                            <h4 id="Dados" style="padding-left:10px">Guia de remessa</h4>
                                            <h4 style="margin-left:auto;padding-right:10px">Cande's Bar</h4>
                                        </div>
                                        <!-- main -->
                                        
                                        <div id="maindiv" style="width:95%;min-width:50px;background:white;margin:5% auto 100% auto;display:flex;flex-direction:column" >
                                            <div class="rec" style="width:98%;background:white;border:1.9px solid black;margin:0 auto 0 auto;">
                                                <table style="width:98%;border-collapse:collapse;margin:auto;margin-top:7px" id="remessaTable">
                                                    <thead>
                                                        <tr style="background:lightgray;">
                                                            <th style="width:32%">Producto</th>
                                                            <th style="width:32%">P. liquido</th>
                                                            <th style="width:32%">Qtd.</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="remessaTableBody">     
                                                    </tbody>
                                               
                                                </table>
                                                <br><br>
                                            </div>
                                        </div>
                                        <!-- bottom -->
                                        <div id="bottomdiv" style="width:95%;height:5%;background:white;position:relative;bottom:60%;margin:0 auto 0 auto">
                                            <p style="font-size:0.85rem;padding-left:6%">Impresso por <?php echo $_SESSION['nome'] ?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <?php echo date("d/m/Y") ?>  &nbsp &nbsp &nbsp <?php date_default_timezone_set('Africa/Maputo'); echo date("H:i") ?> </p>
                                        </div>
                                    <!-- </div> -->
                                </div>

                            </div>
                        </div>
                        <div id="elemPart">
                            <div class="formContainer">
                                <div class="form-header">
                                    <h3>Adicionar producto</h3>
                                </div>
                                <div class="form-body">
                                    <form method="post" id='remessaForm'>
                                        <input type="text" name="proname" id="proname" placeholder="Producto">
                                        <input type="text" name="pl" id="pl" placeholder="Peso liquido">
                                        <input type="number" name="qtd" id="qtd" placeholder="Quantidade">

                                        <div class="submitbuttons" style='margin-top:15%;justify-content:right'>
                                            <input type="submit" id='submeter' value="A. Producto" style='width:40%;height:30px;font-size:13px'>
                                        
                                            <input type="button" id='saveRemessaRecs' value="Salvar o doc." style='width:40%;height:30px;background:tan'>
                                        </div>
                                        
                                    </form>
                                </div>
                                <div class="form-footer">
                                    
                                </div>
                            </div>

                            <div id="remessaBtns">
                                <button type="button" id="printRemessaButton" onclick="printContent('.remessaPaper')">Imprimir</button>
                                <button type="button" id="clearButton">Limpar</button>
                            </div>

                        </div>
                    </div>
                <!-- </div> -->
            </div>
    
    <script src="../scripts/sweetalert.min.js"></script>
    <script src="../scripts/jquery.dataTables.min.js"></script>
    <script src="../scripts/remessa.js"></script> 
    <script src="../scripts/script.js"></script>
</body>
</html>      