<?php

session_start();
ob_start();
//
require_once 'funcoes.php';
$func = new Funcoes;
//
$username = $_SESSION['nome'];
$hora = $func->retornarHora();
$data = $func->retornarData();
$diahoje = date('d');
$dadosdeVDA = $func->returnActDate();
$mesVDA = $dadosdeVDA[0];
$anoVDA = $dadosdeVDA[1];
$activityVenci = $anoVDA."-".$mesVDA."-".$diahoje;
// $p->gravarActividades("Logout", "", $data, $hora, $username, $datadevencimento);

$p->saveActivity("Logout", "-", "-", "-", "-", $_SESSION["nome"], $data, $hora, $activityVenci);
//
unset($_SESSION['id'], $_SESSION['nome']);

header('Location: ../index.php');