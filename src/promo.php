<?php
include "menu.php";

// session_start();
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


<body>

    <div class="rightside">

    <!-- <div class="divshadow"> -->

        <div class="princRightContainer" id="centerContainer">
            <div class="topPrincContainer">
                <div class="titleContainer" style="">
                    <a href="pdv"><button style="font-size:1.13vw" class="backProPage" title="Voltar"></button></a>
                    <h3>Promoções</h3>
                    <form method="POST" id="searcCardDiv" style="position:relative;left:30%">
                        <input type="text" name="searchStock" id="searchStock" placeholder="Pesquisar producto..." >
                        <button type="button" class="" id="clearSearcCard">X</button>
                    </form>
                </div>
                <div class="addButtonDiv" style="">
                    <?php if($_SESSION['nivel'] == 1){?><button style="font-size:1.13vw"  id="addProductB">Adicionar</button><?php }?>
                </div>
            </div>

            <div class="tableContainer"></div>
                <?php 

                    $allPro = $p->selectAllRecs("promocoes");
                    
                    $numpro = count($allPro);
                    if($numpro == 0){
                        echo "<p id='infop'>As promoções aparecem aqui</p>";
                    }else{}
                ?>
            </div>
         </div>
    </div>
    <!-- </div> close div shadow -->

    <div class="bg-modal" id="bg-modal">
        <div class="modalContainer" style="width:300px">

    <!-- Pay many of them -->
    <!-- <div class="bg-payMany" id="bg-payMany"> -->
            <div class="clientContent" >
                <form method="post" id="clientform">
                    <p>
                    <h3 id="modaltitle"></h3>
                    </p><br><br>
                    <br>
                    <p>
                        <label for="">Producto por atribuir promoção </label>
                        <select name="" id="sellProComboBox" style="width:100%;">
                            <option></option>
                        </select>
                    </p>
                    <br>
                    <div id="garafaDivAndPromoValueDiv">
                        <input type="hidden" name="userLogged" id="userLogged" value="<?= $_SESSION['nivel'] ?>">

                        <div id="garafaDiv">
                            <label for="">N. Garafas</label>
                            <input type="number" name="nGarafas" id="nGarafas">
                        </div>
                        <div id="promoValueDiv">
                            <label for="">V. Promocional</label>
                            <input type="number" name="valorPromo" id="valorPromo">
                            <input type="hidden" name="barcodeinput" id="barcodeinput">
                        </div>
                      
                    </div>
                 
                    <br><br>
                    <div class="submitbuttons">
                        <input type="hidden" name="proName" id="proName">
                        <input type="hidden" name="proCode" id="proCode">
                        <input type="hidden" name="plPro" id="plPro">
                        <input type="hidden" name="action" id="action" value="">
                        <div class="btns">
                        <input type="submit" name="submeter" id="submeter" value="Salvar" disabled>
                        <input type="button"  id="fecharClientModal" value="Fechar">
                        </div>
                    </div>
                </form>
                <!-- <br> -->
                <p id="lastpfooter">o</p>
            </div>
        <!-- <p id="lastpfooter">o</p> -->
        </div>
    </div>
    <!-- <script src="../scripts/jquery-3.3.1.js"></script> -->
    <script src="../scripts/select2.min.js"></script>

    <script src="../scripts/sweetalert.min.js"></script>
    <script src="../scripts/jquery.dataTables.min.js"></script>
    <script src="../scripts/promocoes.js"></script> 
    <script src="../scripts/script.js"></script>
</body>
</html>      