<?php

require_once('classCrud.php');
$p = new CrudAll;

if($_POST["inicialdate"] && $_POST["finaldate"]){
    $inicial = $_POST["inicialdate"];
    $final = $_POST["finaldate"];
    $horainicial = $_POST["horainicial"];
    $horafinal = $_POST["horafinal"];
    if($horainicial == '' || $horafinal == ''){
        $horainicial = "00:00";
        $horafinal = "23:53";
    }
    if($_POST["acao"] == "selectactivities" ){
        $dados = $p->selectActiRec($inicial, $final, $horainicial, $horafinal);
        echo json_encode($dados);
    }else{
        $dadosdeprocomqtd = $p->actirecs($inicial, $final, $horainicial, $horafinal);
        echo json_encode($dadosdeprocomqtd);
    }
}


