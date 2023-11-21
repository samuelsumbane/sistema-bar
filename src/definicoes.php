<?php require('classCrud.php');
include "menu.php";

$p = new CrudAll;
$alldeftables = $p->selectAllRecs("definicoes");
if($alldeftables != false){$lminfe = $alldeftables[0]['limiteinfe'];}
session_start();
ob_start();
include_once 'conexao.php';
//

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Definições - Cande's bar</title>

</head>

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
    <!-- <div class="divshadow"> -->
        <div class="princRightContainerDef" id="centerContainer">
            <div class="topPrincContainer">
                <div class="titleContainer">
                    <h3 class="containerTitle">Definições</h3>
                </div>
                <div class="addButtonDiv">
                <a href="bcPage"><button style='font-size:1.13vw;margin:5% 0 0 44%;background:rgb(217, 238, 248);color:black'>Barcode</button></a>
                </div>
            </div>

            <!-- bottom side -->
            <div class="bottomPrincContainerDef">
                
                <div id="alertasDivDef">
                    <p id='alertTextSDef'>Notificar quando o estoque de um producto for inferior a:</p>
                    <input type="number" name="vstockdef" id="vstockdef" value="<?php if($alldeftables != false){ echo $alldeftables[0]['limiteinfe'];} ?>">
                    <p id="alertDefError" class="hiddenP">O valor deve ser um numero</p>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="../scripts/script.js"></script>
<script src="../scripts/defScript.js"></script>
<script src="../scripts/JsBarcode.all.min.js"></script>

</html>