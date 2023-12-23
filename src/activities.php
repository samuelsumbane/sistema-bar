<?php
// session_start();
include "menu.php";
require_once('classCrud.php');
require_once "conexao.php";
require_once 'funcoes.php';
require_once 'phpfuncoes.php';

$p = new CrudAll;
$func = new Funcoes;
session_start();
ob_start();

if((!isset($_SESSION['id'])) && (!$_SESSION['nome'])){
    header('Location: ../index.php');
}

//
$data = date('d/m/Y');
$hora = date('H:i');

// $dataatualPAmerican = date('Y-m-d');
// $p->delActivity($dataatualPAmerican);

delActivitiesAuto();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Actividades - Cande's Bar</title>
    <!-- <script src="../scripts/sweetalert2.all.min.js"></script> -->
</head>
<script>document.querySelector('.activities').setAttribute('id', 'activo')</script>


<body>

    <div class="rightside">

    <!-- <div class="divshadow"> -->
        <div class="princRightContainer" id="centerContainer">
            <div class="topPrincContainer">
                <div class="titleContainer"><h3>Actividades</h3></div>
                <div class="addButtonDiv">
                    
                    <?php if($_SESSION['nivel'] == 1){?><button type="button" id="relatorioPage" >Relatório</button><?php }?>

                </div>
            </div>

            <div class="tableContainer" style="display:flex">
            <div class="tableContent">
                <table style="width:100%" id="tabela" class="display wrap">
                    <thead>
                        <tr>    
                            <th>Acçao</th>
                            <th>Produto</th>
                            <th>Peso Liquido</th>
                            <th>Quantidade</th>
                            <th>Total Pago</th>
                            <th>usuário</th>
                            <th>data</th>
                            <th>hora</th>
                            <!-- <th></th> -->
                        </tr>
                    </thead>
                </table>
                </div>
                </div>
            </div>
        </div>
    <!-- </div> close div shadow -->
    <div class="bg-modal" id="bg-modal">
        <div class="modalContainer">
   
        <div class="clientContent" >
            <form method="post" id="relForm">
                <p>
                  <h3 id="modaltitle"></h3>
                </p><br><br>
              
                <p>
                    <label for="">Data inicial</label><br>
                    <input type="date" name="dateprintbegin" id="dateprintbegin">
                </p><br>
                <p>
                    <label for="">Data final</label><br>
                    <input type="date" name="dateprintfinal" id="dateprintfinal">
                </p>
                <br>
                <br>
                <div class="submitbuttons">
                    <div class="btns">
                      <input type="hidden" name="action" id="action">
                      <input type="submit" id="submeter" value="Verificar" disabled>
                      <input type="button" id="fecharModal" value="Fechar">
                    </div>
                </div>
            </form>
            <!-- <br> -->
            <p id="lastpfooter">o</p>
            </div>
        </div>
    </div>
    <script src="../scripts/jquery-3.3.1.js"></script>
    <script src="../scripts/sweetalert.min.js"></script>
    <script src="../scripts/jquery.dataTables.min.js"></script>
    <script src="../scripts/listActivities.js"></script>
    <script src="../scripts/script.js"></script>
</body>
</html>