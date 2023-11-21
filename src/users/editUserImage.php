<?php

$minpath =  $_SERVER['DOCUMENT_ROOT'];
$path = "$minpath/bar/src";
$con = new PDO("sqlite:$path/barBank.sqlite");

if( isset($_POST['submit']) && isset($_FILES['editUserImage'])){

    $userid = $_POST["userid"];

    $img_name = $_FILES['editUserImage']['name'];
    $img_size = $_FILES['editUserImage']['size'];
    $tmp_name = $_FILES['editUserImage']['tmp_name'];
    $error = $_FILES['editUserImage']['error'];

    if($error === 0){
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png");
        if(in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
            $img_upload_path = '../uploads/'.$new_img_name; 
            move_uploaded_file($tmp_name, $img_upload_path);
            $addsql = $con->prepare("UPDATE users SET imagem = '".$new_img_name."' WHERE id = '".$userid."'");
            $addsql->execute();
            header("Location: ../userPage.php");
        }else{
            echo "algum erro";
        }
    }
}else{
    echo "Houve um erro desconhecido";
}