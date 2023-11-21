<?php
include('barFunc.php');
$opc = new Bar;
$action = isset($_POST['action']) && $_POST['action'] != '' ? $_POST['action'] : '';

match($action){
    "getPro"=>$opc->getPro(),"getStock"=>$opc->getStock(),"updatePro"=>$opc->updatePro(),"productData"=>$opc->productData(),"sellProducts"=>$opc->sellProducts(),"verifyStockProduct"=>$opc->verifyStockProduct(),"addStockProducts"=>$opc->addStockProducts(),"updateStock"=>$opc->updateStock(),"delStock"=>$opc->delStock(),"verifyA"=>$opc->verifyA(),"addpromo"=>$opc->addpromo(),"delPromo"=>$opc->delPromo(),"selectPromo"=>$opc->selectPromo(),"returnDatesChart"=>$opc->returnDatesChart(),"selectAllProCards"=>$opc->selectAllProCards(),"filterPro"=>$opc->filterPro(),"selectAllStockCards"=>$opc->selectAllStockCards(),"filterStock"=>$opc->filterStock(),"saveLimiteInfe"=>$opc->saveLimiteInfe(),"saveremessarecs"=>$opc->saveremessarecs(),"selectallrecords"=>$opc->selectallrecords("remessarecs"),"selectremessadocs"=>$opc->selectremessadocs(),"selectremrecs"=>$opc->selectremrecs(),"selectallrecordsP"=>$opc->selectallrecords("controlodestock"),"selectallrecordsPromocoes"=>$opc->selectallrecords("promocoes"),"filterPromo"=>$opc->filter("promocoes", "produto"),"selectSells"=>$opc->selectSells("ano"),"selectMonths"=>$opc->selectSells("mes"),"selectSellsByY"=>$opc->selectSellsBy(),
    
};

// "importQuery"=>$opc->importQuery(),
// ,"delPro"=>$opc->delPro()
// ,"addProduct"=>$opc->addProduct()
// ,"verifyonStock"=>$opc->verifyonStock()