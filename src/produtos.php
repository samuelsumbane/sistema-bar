<?php
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Cande's Bar</title>
    <link rel="shortcut icon" href="../icones/water_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../styles/tooltip.css">
</head>

<body>
    <div class="leftside" id="leftside">
        <div class="title-div">
                <div id="title">Cande's bar</div>
                <div id="div-hamburger">
                    <div class="hamburger">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                </div>
            </div>
            <div class="botoes">
                <a href="dash.php"><button class="home tooltip">Página inicial <span class="tooltiptext"> Página inicial </span> </button></a>
                <a href="clientes.php"><button class="clients tooltip">Clientes <span class="tooltiptext">Clientes </span> </button></a>
                <a href="produtos.php"><button id="activo" class="payment tooltip">Gêrencia <span class="tooltiptext">Gêrencia </span> </button></a>
                <a href="usuarios.php"><button class="users tooltip">Usuários <span class="tooltiptext">Usuários </span> </button></a>
                <a href="activities.php"><button class="activities tooltip">Actividades <span class="tooltiptext">Actividades </span> </button></a>
                <a href="definicoes.php"><button class="settings tooltip">Definições <span class="tooltiptext">Definições </span> </button></a>
            </div>
            <div class="status">
              <a href="sair.php"><button class="sair tooltip">Sair <span class="tooltiptext">Sair </span> </button></a>
            </div>
        </div>
    </div>

    <div class="rightside">

    <div class="divshadow">

        <div class="princRightContainer" id="centerContainer">
            <div class="topPrincContainer">
                <div class="titleContainer">
                    <h3>Productos</h3>
                    <form method="POST" id="searcCardDiv">
                        <input type="text" name="searchPro" id="searchPro" placeholder="Pesquisar producto..." >
                        <button type="button" class="" id="clearSearcCard">X</button>
                    </form>
                </div>
                <div class="addButtonDivBar">
                    <a href="pdv.php"><button style="font-size:1.13vw" id="faturaButton">Vendas</button></a>
                    <a href="promo.php"><button style="font-size:1.13vw" class="firstbtn">Promoções</button></a>
                    <a href="remessa.php"><button style="font-size:1.13vw" class="firstbtn">G. Remessa</button></a>
                </div>
            </div>

            <div class="tableContainer">
                <input type="hidden" name="userLogged" id="userLogged" value="<?= $_SESSION['nivel'] ?>">
            </div>
         </div>
    </div>
    </div> <!--close div shadow -->

    <div class="bg-modal" id="bg-modal">
        <div class="modalContainer">

    <!-- <div class="bg-payMany" id="bg-payMany"> -->
            <div class="clientContent" >
                <form method="post" id="clientform">
                    <p>
                    <h3 id="modaltitle"></h3>
                    </p>
                  
                    <br>
                    <p style="display:flex;flex-direction:column">
                        <label for="">Peso liquido</label>
                        <input type="text" name="pesoLiquido" id="pesoLiquido" style="width:100%" readonly>
                    </p>
                    <br>
                    <p>
                        <label for="">Custo</label><br>
                        <input type="number" name="valorCusto" id="valorCusto" placeholder="Valor de Custo">
                    </p>
                    <br>
                    <p>
                        <label for="">Venda</label><br>
                        <input type="number" name="valorVenda" id="valorVenda" placeholder="Valor de Venda">
                    </p>
                 
                    <br><br>
                    <div class="submitbuttons">
                        <input type="hidden" name="proId" id="proId">
                        <input type="hidden" name="action" id="action" value="">
                        <div class="btns">
                        <input type="submit" name="submeter" id="submeter" value="Salvar">
                        <input type="button"  id="fecharClientModal" value="Fechar">
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
    <script src="../scripts/crudProducts.js"></script> 
    <script src="../scripts/selectPros.js"></script> 
    <script src="../scripts/script.js"></script>

</body>
</html>