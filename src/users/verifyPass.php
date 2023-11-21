<?php 


if($_POST["passFBank"]){
    $pass = $_POST["actualPassword"];
    $fBank = $_POST["passFBank"];
    if(password_verify($pass, $fBank)){
        echo json_encode("200");
    }else{
        echo json_encode("404");
    }
}
