
<?php
include "menu.php";
require_once('classCrud.php');
$p = new CrudAll ;
include_once "conexao.php"; 
 
session_start();
ob_start();


if((!isset($_SESSION['id'])) && (!$_SESSION['nome'])){
    header('Location: ../index.php');
}

if($_SESSION['nivel'] != 1){
    header('Location: dash.php');
}
?>


<!DOCTYPE html>
<html lang="pt">
<head><title>Usuários - Cande's Fashion</title></head>
<script>document.querySelector('.users').setAttribute('id', 'activo')</script>
<body>
        <div class="rightside">
        <!-- <div class="divshadow"> -->
        <div class="princRightContainer" id="centerContainer">
            <div class="topPrincContainer">
                <div class="titleContainer">
                    <h3>Usuários</h3>
                </div>
                <div class="addButtonDiv">
                    <button type="button" name="button" id="adduser">Adicionar</button>
                </div>
            </div>


            <div class="tableContainer">
            <div class="tableContent">
                    <table style="width:100%;" id="tabela" class="display nowrap">
                        <thead>
                            <tr>
                                <th>Nome Completo</th>
                                <th>Usuário</th>
                                <th>Nivel</th>
                                <th>Imagem</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                  </div>
            </div>
         </div>
        </div>
    </div>


    <div class="bg-modal" id="bg-modal">
        <div class="modalContainer">
            
          <div class="modal-header">
            <h3 id='modaltitle'></h3>
          </div>

          <div class="modal-body">
            <form method="post" id="userform" enctype="multipart/form-data">
                  <p>
                      <label>Nome</label><br>
                      <input type="text" name="nomeuser" id="nomeuser" placeholder="Nome do usuário">
                  </p>
                  <br>
                  <p>
                      <label>Usuário</label><br>
                      <input type="email" name="username" id="username" placeholder="Ex: usuario@gmail.com">
                  </p>
                  <br>
                  <p>
                      <label>Senha</label><br>
                      <input type="password" name="password" id="password" placeholder="Senha do usuário">
                      <p id="passerror"></p>
                  </p>
                  <br>
                  <p>
                      <label>Confirmar</label><br>
                      <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirmar a senha">
                      <p id="passerror"></p>
                  </p><br>
                  <p>
                      <label>Image</label><br>
                      <input type="file" name="my_image" id="my_image">
                    </p>
                  <br>
                  <p style="display:flex;flex-direction:row;color:white">
                        <input type="radio" name="nivelusuario" id="nUser" checked="true" value='0'>Usuário
                        <input type="radio" name="nivelusuario" id="admin" value='1'>Admin                     
                  </p>
         
                  <br><br>
                  <div class="submitbuttons">
                    <input type="hidden" name="userid" id="userid" value="">
                    <input type="hidden" name="action" id="action" value="">
                    <div class="btns">
                      <input type="submit" name="submeterUser" id="submeter" value="Salvar" disabled>
                      <input type="button" id="fecharModal" value="Fechar">
                    </div>
                </div>
              </form>
          </div>

          <div class="modal-footer">
            <p>modalfooter</p>
          </div>

      </div>
    </div>

    <script src="../scripts/sweetalert.min.js"></script>
    <script src="../scripts/jquery-3.3.1.js"></script>
    <script src="../scripts/jquery.dataTables.min.js"></script>
    <script src="../scripts/cruduser.js"></script>
    <script src="../scripts/script.js"></script>

</body>
</html>