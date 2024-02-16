<?php 

if($_POST["action"] == "realizarbackup"){
    $toExport = "";

    try{
        $minpath =  $_SERVER['DOCUMENT_ROOT'];
        $caminhodb = "$minpath/bar/src/barBank.sqlite";
        $systemUserName = get_current_user();
        $caminhobackup = "C:/Users/$systemUserName/Downloads/" . 'bar_backup_' . date('Ymd_Hi') . '.sqlite'; // funciona somente no windows.
        $caminhoparaexportar = "C:/Users/$systemUserName/Downloads";
        if(copy($caminhodb, $caminhobackup)){
            $toExport = $caminhoparaexportar;
        }else{
            $toExport = "403";
        }
        echo json_encode($toExport);
    } catch(Exception $e){
        echo 'Erro: ' . $e->getMessage();
    }
}
