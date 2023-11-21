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