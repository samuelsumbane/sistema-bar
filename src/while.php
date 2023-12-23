<?php

require_once('classCrud.php');
$p = new CrudAll;


//     // $this->saveActivity("Venda", $produto, $pesoliquido, $quantidade, $valortotal, $usernamelogged, $this->retornarData(), $this->retornarHora(), $this->venciDate());

//     $p->saveActivity("Venda", 'lite', "200ml", "2", "200", "samuel", "32", '434', '344');





// echo password_hash('pensador', PASSWORD_DEFAULT);

// // require "../vendor/autoload.php" ;

// // $Bar = new Picqer\Barcode\BarcodeGeneratorHTML();

// // $code = $Bar->getBarcode("Ol", $Bar::TYPE_CODE_128);

// // echo $code;


// $idenfier = 2;

// $dadoscodigo = $p->selectRecord('remessarecs', 'id', $idenfier);
// // print_r($dadoscodigo);
// // echo "<br>";

// // echo $dadoscodigo['id'];    
// // echo "<br>";
// // echo $idenfier;
// // echo "<br>";
// if($dadoscodigo != false){
//     while ($dadoscodigo['id'] == $idenfier){
//         $idenfier += 1;
//         $dadoscodigo = $p->selectRecord('remessarecs', 'id', $idenfier);
//     }

//     echo " consegui voce $idenfier";
//     // $this->saveremessadoc($idenfier, $pro, $pl, $qtd, $user, $dia, $hora);
// }else{
//     echo " cai directo aqui $idenfier";
    // $this->saveremessadoc($idenfier, $pro, $pl, $qtd, $user, $dia, $hora);
// }