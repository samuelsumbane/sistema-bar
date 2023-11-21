<?php
require_once 'conexao.php';

$iddel= $_GET['idUserDel'];

$usercmd = $con->prepare("DELETE FROM users WHERE id = $iddel");
$usercmd->execute();

