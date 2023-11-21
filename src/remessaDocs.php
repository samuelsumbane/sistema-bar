<?php
// session_start();
include("menu.php");
require_once('classCrud.php');
require_once "conexao.php";
require_once 'funcoes.php';

$p = new CrudAll;
$func = new Funcoes;
session_start();
ob_start();
//
$data = date('d/m/Y');
$hora = date('H:i');

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Promoções - Cande's Bar</title>
</head>


<body>
    

    <div class="rightside">

        <div class="princRightContainer" id="centerContainer">
            <div class="topPrincContainer">
                <div class="titleContainer">
                    <a href="pdv"><button style="font-size:1.13vw" class="backProPage" title="Voltar"></button></a>
                    <h3>Remessas doc.</h3>

                </div>
                <div class="addButtonDiv">
                    <a href="remessa"><button style="font-size:1.13vw" class="firstbtn">G. Remessa</button></a>
                </div>
            </div>

            <div class="tableContainer">
                <input type="hidden" name="userLogged" id="userLogged" value="<?= $_SESSION['nivel'] ?>">
                    
                            <?php
                              $resdados = array();
                              $allids = $p->con()->query("SELECT id FROM remessarecs group by id");
                              $resid = $allids->fetchAll(PDO::FETCH_ASSOC);
                              $idsCount = count($resid);
                            //   print_r($resid);
                          
                              if($idsCount > 0){
                                $divId = 0;
                                foreach ($resid as $idk => $idv) {
                                    $ownId = $idv['id'];
                                    $divId += 1; 
                                    ?>
                           
                                        <div class='remessaPaperRec' id='remessaPaperRec' style='width:350px;height:370px'><div class='parentMainDiv' id='<?= "parentMainDiv$divId" ?>' style='width:90%;height:90%;background:white;margin:auto;display:flex;flex-direction:column;'><div id='topdiv' style='width:98%;height:10%;margin:auto;margin-top:2%;display:flex'><h4 id='Dados' style='padding-left:10px'>Guia de remessa</h4><h4 style='margin-left:auto;padding-right:10px'>Cande's Bar</h4></div><div id='maindiv' style='width:95%;min-width:50px;margin:5% auto 100% auto;display:flex;flex-direction:column'><div class='rec' style='width:98%;border:1.9px solid black;margin:0 auto 0 auto;'><table style='width:98%;border-collapse:collapse;margin:auto;margin-top:7px' id='remessaTable'><thead><tr style='background:lightgray'><th style='width:30%'>Producto</th><th style='width:30%'>P. Liquido</th><th style='width:30%'>Qtd.</th></tr></thead><tbody class='remessaTableBody'>
                                    
                                        <?php

                                            $dados = $p->con()->query("SELECT * FROM remessarecs where id = $ownId ");
                                            $resdados = $dados->fetchAll(PDO::FETCH_ASSOC);
                                            //   print_r($resdados);
                                            $resdadosCount = count($resdados);

                                            //

                                            for ($i=0; $i < $resdadosCount; $i++){
                                                $username = $resdados[$i]['usuario'];
                                                $data = $resdados[$i]['dia'];
                                                $time = $resdados[$i]['hora'];

                                                echo "<tr>";
                                                foreach($resdados[$i] as $k => $v){
                                                    
                                                    if($k != "id" and $k != "usuario" and $k !='dia' and $k !='hora' ){
                                                    ?><td style="width:10%;padding-left:10px;"><?php echo $v ?></td><?php
                                                    } 
                                                }
                                            }
                                            ?>
                                    
                                        <!-- </tbody></table></div> -->
                                        </tbody></table><br><br></div></div><div id='bottomdiv' style='width:95%;height:5%;position:relative;bottom:60%;margin:0 auto 0 auto'><p style='font-size:0.85rem;padding-left:6%'>Impresso por <?= $username?>   <?= $data ?> <?= $time ?></p></div></div>
                                        
                                        <div class="parentFooterDiv">
                                            <button class='printRemessaRecGrouped' id='<?= "$divId"?>' >Imprimir</button>
                                            
                                        </div>
                                    
                                    </div>

                                    <?php 
                                }
  
                              }else{
                                echo "<p id='infop'>As remessas salvas aparecem aqui</p>";

                              }
                            ?>
                    
                <!-- </div> -->

            </div>
         </div>
    </div>

    <script src="../scripts/sweetalert.min.js"></script>
    <script src="../scripts/jquery.dataTables.min.js"></script>
    <script src="../scripts/selectRemessa.js"></script> 
    <script src="../scripts/script.js"></script>
</body>
</html>      