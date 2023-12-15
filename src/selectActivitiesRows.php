<?php

require_once('classCrud.php');
$p = new CrudAll;

if($_POST["inicialdate"] && $_POST["finaldate"]){
    $inicial = $_POST["inicialdate"];
    $final = $_POST["finaldate"];
    if($_POST["acao"] == "selectactivities" ){
        $dados = $p->selectActiRec($inicial, $final);
        echo json_encode($dados);
    }else{
        $dadosdeprocomqtd = $p->actirecs($inicial, $final);
        echo json_encode($dadosdeprocomqtd);
    }
}


