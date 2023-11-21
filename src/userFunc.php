<?php

class User {

    private $conn;

    public function __construct(){

        try {
            $this->conn = new PDO('sqlite:barBank.sqlite');
        } catch (PDOException $th) {
            echo "Erro de conexao com o banco. ".$th->getMessage();
        }
            
    }

    public function addUser(){

        $nome = addslashes($_POST['nomeuser']);
        $usuario = addslashes($_POST['username']);
        $senha = password_hash(addslashes($_POST['password']), PASSWORD_DEFAULT) ;
        $nivel = addslashes($_POST['nivelusuario']);
        
        
        $cmd = $this->conn->prepare("SELECT * FROM users WHERE usuario = :valor");
        $cmd->bindValue(":valor",$usuario);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        if($res > 0){
            $code = 1;
            echo json_encode($code);
        }else{
           if($_FILES["my_image"]){

                $img_name = $_FILES['my_image']['name'];
                $img_size = $_FILES['my_image']['size'];
                $tmp_name = $_FILES['my_image']['tmp_name'];
                $error = $_FILES['my_image']['error'];

                if($error === 0){
                    
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_lc = strtolower($img_ex);
                        $allowed_exs = array("jpg", "jpeg", "png");
                        if(in_array($img_ex_lc, $allowed_exs)) {
                            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                            $img_upload_path = 'uploads/'.$new_img_name; 
                            move_uploaded_file($tmp_name, $img_upload_path);
                            $addsql = $this->conn->prepare("INSERT INTO users(nome, usuario, senha, nivel, imagem) VALUES('".$nome."', '".$usuario."', '".$senha."', '".$nivel."', '".$new_img_name."')");
                            $addsql->execute(); 
                            $code = 200;
                        }else{
                            $code = 12;
                        }
                        echo json_encode($code);
                    // }
                }else{
                    $addsql = $this->conn->prepare("INSERT INTO users(nome, usuario, senha, nivel) VALUES('".$nome."', '".$usuario."', '".$senha."', '".$nivel."')");
                    $addsql->execute(); 
                } 

            }
        }



            


    }

    public function deleteUser(){
        if($_POST["userid"]){
            $userid = addslashes($_POST["userid"]);
            $delSql = $this->conn->prepare("DELETE FROM users where id = $userid");
            $delSql->execute();
        }
    }

    public function getUser(){
        if($_POST['userid']){
            $row = array();
            $iduser = addslashes($_POST["userid"]);
            $sqlQuery = $this->conn->query("SELECT * FROM users WHERE id = $iduser"); 
            $row = $sqlQuery->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row);
            // print_r($row);
        }
    }

    public function updateUser(){
        if($_POST['userid']){
            
            $iduser = addslashes($_POST['userid']);
            $nome = addslashes($_POST['nomeuser']);
            $usuario = addslashes($_POST['username']);
            $senha = password_hash(addslashes($_POST['password']), PASSWORD_DEFAULT) ;
            $nivel = addslashes($_POST['nivelusuario']);

            if($_POST["passChecked"]){
                $passChecked = $_POST["passChecked"];
                if($passChecked == "true"){
                    $sqlUpdate = $this->conn->prepare("UPDATE users set nome = '".$nome."', usuario = '".$usuario."', senha = '".$senha."', nivel = '".$nivel."' where id = '".$iduser."'");
                    $sqlUpdate->execute();  
                }else{
                    $sqlUpdate = $this->conn->prepare("UPDATE users set nome = '".$nome."', usuario = '".$usuario."' where id = '".$iduser."'");
                    $sqlUpdate->execute();  

                }
            }else{  
                $sqlUpdate = $this->conn->prepare("UPDATE users set nome = '".$nome."', usuario = '".$usuario."', senha = '".$senha."', nivel = '".$nivel."' where id = '".$iduser."'");
                $sqlUpdate->execute();         
            }

            
        }
    }


}