<?php 
require 'userFunc.php';
$func = new User;

$action = isset($_POST['action']) && $_POST['action'] != '' ? $_POST['action'] : '';

match($action){
    "addUser"=>$func->addUser(),
    "delUser"=>$func->deleteUser(),
    "getUser"=>$func->getUser(),
    "updateUser"=>$func->updateUser()
};