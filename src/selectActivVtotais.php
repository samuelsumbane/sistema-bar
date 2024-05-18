<?php

require_once('classCrud.php');
$p = new CrudAll;



if($_POST["inicialdate"] && $_POST["finaldate"] && $_POST['acao'] == "valorestotais"){
    $inicial = $_POST["inicialdate"];
    $final = $_POST["finaldate"];
    $inicialhora = $_POST["horainicial"] ?? '00:00';
    $finalhora = $_POST["horafinal"] ?? '23:59';
    $query = $p->con()->prepare("SELECT accao as acao, SUM(totalpago) as amount  from activities where acao = 'Stock' and dia >='$inicial' AND dia <='$final' AND hora >= '$inicialhora' AND hora <= '$finalhora' or acao = 'Venda' and dia >='$inicial' AND dia <='$final' AND hora >= '$inicialhora' AND hora <= '$finalhora' group by acao");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}