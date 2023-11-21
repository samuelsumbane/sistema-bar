<?php


try {
    // $con = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);
    $con = new PDO('sqlite:barBank.sqlite');

    // $con = 
} catch (PDOException $e) {
    echo "Nao foi possivel conetar com banco de dados";
}