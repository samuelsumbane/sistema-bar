<?php
session_start();
ob_start();
require "classCrud.php";
$p = new CrudAll;
include "menu.php";


?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Página de usuário - Cande's bar</title>
</head>
<script>document.querySelector('.home').setAttribute('id', 'activo')</script>

<body>

    <div class="rightside">
        <div class="princRightContainer" id="centerContainer">
            <div class="topPrincContainer" style="height:30px">
                <div class="titleContainer">
                    <a href="dash.php"><button style="font-size:1.13vw" class="backProPage" title="Voltar"></button></a>
                    <h3>Minha página</h3>
                </div>
                <div class="addButtonDiv">
                </div>
            </div>

            <div class="tableContainer">
                <div id="userProprieties" style="width:20%;min-width:200px;margin:auto;">
                    <div class="modal-body">
                            <br><br>
                            <div id="userProPhoto" style="width:125px;height:125px;margin:-15% auto 0 auto;background:lightgray;border-radius:50%">
                                <?php
                                    $data = $p->selectRecord("users", "id", $_SESSION["id"]);
                                    $image = $data["imagem"];
                                    // var_dump($data["imagem"]);
                                    if($image != ""){
                                        echo '<img src="uploads/'.$image.'" class="" height="" style="width:100%;height:100%;background-color:gray;object-fit:cover;border-radius:50%" />';
                                    }
                                ?>
                            </div>
                            <br>
                            
                            <div style="display:flex">
                                <label style="width:50%">Actualizar o perfil</label>
                                <input type="checkbox" name="" id="showHideUserPhoto" value="va" style="width:20px">
                            </div>  
                            <div id="userUpPhotoDiv" class="hideUserUpPhoto">
                                
                                <form method="post" action="users/editUserImage.php" enctype="multipart/form-data" id="imagestockinputs">
                                    
                                    <input type='file' name="editUserImage" id="editUserImage">
                                    <input type='submit' name="submit" value='sub' id='userimgbutton'>
                                    <input type="hidden" value="<?= $_SESSION["id"] ?>" name="userid" id="userid">
                                </form>
                            </div>
                        
                        <form method="post" id="userProForm">
                        
                            <p>
                                <label>Nome</label><br>
                                <input type="text" name="nomeuser" id="nomeuser" value="<?= $_SESSION["nome"] ?>">
                            </p>
                            <br>
                            <p>
                                <label>Usuário</label><br>
                                <input type="email" name="username" id="username" value="<?= $_SESSION["usuario"] ?>">
                            </p>
                            <br>
                            <div style="display:flex">
                                <label style="width:50%">Mudar senha</label>
                                <input type="checkbox" name="" id="showHideUserPass" value="va" style="width:20px">
                            </div>
                            
                            <div id="userPassDiv" class="hideUserPass">
                                <input type="hidden" name="passFBank" id="passFBank" value="<?= $_SESSION["senha"] ?>">
                                <input type="hidden" name="userid" id="userid" value="<?= $_SESSION["id"] ?>">
                                <input type="hidden" name="action" id="action" value="updateUser">
                                <input type="hidden" name="passChecked" id="passChecked" value="">

                                <input type="hidden" name="nivelusuario" id="nivelusuario" value="<?= $_SESSION["nivel"] ?>">
                                <p>
                                    <label>Senha actual</label><br>
                                    <input type="password" name="actualPassword" id="actualPassword">
                                    <p class="actualpassError"></p>
                                </p>
                                <br>
                                <p>
                                    <label>Nova senha</label><br>
                                    <input type="password" name="password" id="password">
                                    <p class="passerror"></p>
                                </p>
                                <br>
                                <p>
                                    <label>Confirmar</label><br>
                                    <input type="password" name="confirmPassword" id="confirmPassword">
                                    <p class="passerror"></p>
                                </p>  
                            </div>
                            
                            <!-- <br> -->
                            <br><br>
                            <div class="submitbuttons">
                            <div class="btns">
                                <input type="submit" name="submeterUser" id="submeter" value="Salvar" style="width:100%">
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>
    </div>


    <!-- <script src="../scripts/jquery-3.3.1.js"></script> -->
    <script src="../scripts/sweetalert.min.js"></script>
    <script src="../scripts/userPage.js"></script>
    <script src="../scripts/script.js"></script>
</body>
</html>      