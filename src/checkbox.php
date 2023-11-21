<?php

require_once 'classCrud.php';
$p = new CrudAll;
require_once 'funcoes.php';
$func = new Funcoes;

?>


<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
        body
        {
            font-family: Arial;
            font-size: 10pt;
            background-color: gray;
        }
    </style>
</head>
<body>
    <script type="text/javascript">
        function ShowHideDiv(chkPassport) {
            var dvPassport = document.getElementById("dvPassport");
            dvPassport.style.display = chkPassport.checked ? "block" : "none";
        }
    </script>
    <label for="chkPassport">
        <input type="checkbox" id="chkPassport" onclick="ShowHideDiv(this)" />
        Do you have Passport?
    </label>
    <hr />
    <div id="dvPassport" style="display: none; background-color:white">
        <?php

            // $dados = $p->buscarDados("users", "usuario");
            // print_r($dados);

            $buscarValordafatura = $p->buscarDadosPorId("controlodepagamento", 1);
            $valordafatura = $buscarValordafatura['valordafatura'];
            print_r($valordafatura);

        ?>
    </div>
    
    <?php 
    
        $altura = "1,292.20";
        $largura = "0,90";
        $totalpago = "915,18";

        // $totalpagoconvertido = str_replace(",",".", str_replace(".", "", $totalpago));
        // $totalpagoconvertido = floatval(str_replace(",", ".", $totalpago));

        // echo $totalpagoconvertido;
       
      $totalpago = str_replace(',','.', $totalpago);
        // echo $totalpago ;

        // $val = $func->valor_por_extenso(1.915.18);
        // echo $val;
        
        $v = 21*60;
        $i = 0.03*$v;
        $total = $v+$i;
// echo $total;
// $consumo = number_format($total, 2);
// echo $consumo;
        $val = $func->valor_por_extenso($total);
        echo $val;


    ?>
</body>
</html>
