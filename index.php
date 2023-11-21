<?php 
session_start();
ob_start();
require "src/classCrud.php";
$p = new CrudAll;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="icones/bar_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/login.css">
    <script src="scripts/jquery-3.3.1.js"></script>
    <script src="scripts/script.js"></script>
</head>


<body>
    
    <div class="parent">
        <?php

        // echo password_hash(12, PASSWORD_DEFAULT);

        //set login attempt if not set
		if(!isset($_SESSION['attempt'])){
			$_SESSION['attempt'] = 0;
		}

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(!empty($dados['loginbutton'])){
            $usuariodigitado = $dados['usuario'];
            $senhadigitada = $dados['senha'];

            $timenow = time();

            if($_SESSION['attempt'] == 5){
                $msg_erro = 'Limite de tentativas alcancado';
                $tempodefinido = $_SESSION['attempt_again'];
                $temporestante = $tempodefinido - $timenow;
                if($temporestante <= 0){
                    unset($_SESSION["attempt"]);
                    unset($_SESSION["attempt_again"]);
                }
            }else{
               $valores = $p->buscarDadosPorUsuario("users", $dados['usuario']);
                if ($valores == false){
                    $msg_erro = "Usuário ou senha inválida!";
                    $_SESSION['attempt'] += 1;
                    //set the time to allow login if third attempt is reach
                    if($_SESSION['attempt'] == 5){
                        $_SESSION['attempt_again'] = time() + (5*60);
                        //nota que 5*60 = 5mins, 60*60 = 1hr, para mudar para 2hrs mude para 2*60*60
                    }
                }else{
                    // $usuariodobanco = $valores['usuario'];
                    $senhadobanco = $valores['senha'];
                   
                    if(password_verify($senhadigitada, $senhadobanco)){
                        $_SESSION['id'] = $valores['id'];
                        $_SESSION['nome'] = $valores['nome'];
                        $_SESSION["usuario"] = $valores["usuario"];
                        $_SESSION["senha"] = $valores["senha"];
                        $_SESSION['nivel'] = $valores['nivel'];
                        $_SESSION['imagem'] = $valores['imagem'];
                        unset($_SESSION['attempt']);
                        header("Location: src/dash");
        
                    }else{
                        $msg_erro = " Usuário ou senha inválida!";
                        $_SESSION['attempt'] += 1;
                        //set the time to allow login if third attempt is reach
                        if($_SESSION['attempt'] == 5){
                            $_SESSION['attempt_again'] = time() + (5*60);
                            //note 5*60 = 5mins, 60*60 = 1hr, to set to 2hrs change it to 2*60*60
                        }
                    } 
                }
            }
        }
        ?>


    <div id="loginParent">
        <div id="bottle">
            <form method="POST" id="loginForm">
                <h2>Cande's Bar</h2><br>
                <input type="email" name="usuario" id="email" placeholder="Usuário">
                <input type="password" name="senha" id="password" placeholder="Senha">
                <input type="submit" name="loginbutton" id="loginbutton" value="Login" />
                <div class="login_info"><p id="error_mensage"><?php if(isset($msg_erro)){ echo $msg_erro; }?></p></div>
                <!-- <div class="login_info"><p id="error_mensage">Olaaa</p></div> -->
                
            </form>
        </div>
    </div>

    
    </div>
    
</body>
</html>