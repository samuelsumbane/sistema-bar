<?php

require_once 'classCrud.php';
$p = new CrudAll;


// $iddafatura = addslashes($_GET['idFat']);
// $resId = $p->buscarDadosPorId("controlodefatura", $iddafatura);



$dataatual = date('Y-m-d');
$diadevencimento = "";


function verificarVencimento($codedafatura){

    // $resId = $p->buscarDadosPorId("controlodefatura", $iddafatura);
    $res = $p->buscarDadosPessoa("clientes", $codedafatura);

    $codigodocliente = $res['codigo'];
    $nomedocliente =  $res['nome'];
    
    echo $codigodocliente;
    echo "<br>";
    echo "$nomedocliente";



}

function dig(){
    echo "34";
}

function makeDBBackup(){
    try{
        $minpath =  $_SERVER['DOCUMENT_ROOT'];
        $caminhodb = "$minpath/bar/src/barBank.sqlite";
        $systemUserName = get_current_user();
        $caminhobackup = "C:/Users/$systemUserName/Downloads/" . 'bar_backup_' . date('Ymd_Hi') . '.sqlite'; // funciona somente no windows.
        $caminhoparaexportar = "C:/Users/$systemUserName/Downloads";
        if(copy($caminhodb, $caminhobackup)){
            return "sucess";
        }else{
            return "houve um erro";
        }
    } catch(Exception $e){
        echo 'Erro: ' . $e->getMessage();
    }
}